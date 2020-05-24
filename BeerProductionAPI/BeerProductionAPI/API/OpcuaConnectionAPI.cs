using Opc.UaFx.Client;
using System;
using System.ComponentModel;
using System.ServiceModel;
using System.Threading;
using System.Threading.Tasks;
using BeerProductionAPI.API.ConnectionModule;
using BeerProductionAPI.API.JsonObjectRepresentations;
using BeerProductionAPI.API.MachineModule;

namespace BeerProductionAPI.API
{
    /// <summary>
    /// Implementation of the IPersistenceFacade interface
    /// </summary>
    /// nullreference exception when no connection
    [ServiceBehavior(InstanceContextMode = InstanceContextMode.Single)]
    //Maybe make class singleton if constructor is not being called
    public class OpcuaConnectionAPI : IOpcuaConnectionAPI
    {
        private IMachineReadData machineReadData;
        private IMachineWriteData machineWriteData;
        private OPCConnectionManager opcConnection;
        private OpcClient accessPoint;
        private string currentMachineName;
        private string simulationIP;
        private bool ValidConnection;
        private Task task;

        public OpcuaConnectionAPI()
        {
            machineReadData = new MachineReadData();
            machineWriteData = new MachineWriteData();
            opcConnection = new OPCConnectionManager();
            simulationIP = "opc.tcp://127.0.0.1:4840";
            ConnectToMachine(simulationIP);
            ValidConnection = true;

        }

        public bool ConnectToMachine(string machineName)
        {
            if (machineName == "")
            {
                machineName = currentMachineName;
            }
            bool isSuccess = opcConnection.ConnectToServer(machineName);
            currentMachineName = machineName;
            accessPoint = opcConnection.AccessPoint;
            return isSuccess;
        }



        public LiveRelevantData GetUpdateData()
        {
            if (ValidConnection)
            {
                try
                {
                    return new LiveRelevantData(
                        machineReadData.ReadTemperature(accessPoint),
                        machineReadData.ReadHumidity(accessPoint),
                        machineReadData.ReadVibration(accessPoint),
                        machineReadData.ReadActualMachineSpeed(accessPoint),
                        machineReadData.ReadProducedProducts(accessPoint),
                        machineReadData.ReadDefectProducts(accessPoint),
                        machineReadData.ReadBarleyAmount(accessPoint),
                        machineReadData.ReadHopsAmount(accessPoint),
                        machineReadData.ReadMaltAmount(accessPoint),
                        machineReadData.ReadWheatAmount(accessPoint),
                        machineReadData.ReadYeastAmount(accessPoint),
                        machineReadData.ReadMaintenanceCounter(accessPoint),
                        machineReadData.ReadCurrentState(accessPoint),
                        machineReadData.ReadNextBatchID(accessPoint),
                        machineReadData.ReadBatchSize(accessPoint),
                        machineReadData.ReadBatchID(accessPoint)
                        //0
                        );
                }
                catch (NullReferenceException ex)
                {
                    Console.WriteLine(ex.ToString());
                    retryConnection();
                }
                catch (InvalidOperationException e)
                {
                    retryConnection();
                }
                catch (LicenseException ex)
                {
                    remakeOPCClient();
                }
            }
            return null;

        }

        public BatchReportData getBatchReportData()
        {
            if (ValidConnection)
            {
                try
                {
                    return new BatchReportData(
                        machineReadData.ReadNextBatchID(accessPoint),
                        machineReadData.ReadNextBatchSize(accessPoint),
                        machineReadData.ReadActualMachineSpeed(accessPoint),
                        machineReadData.ReadProducedProducts(accessPoint),
                        machineReadData.ReadDefectProducts(accessPoint),
                        machineReadData.ReadNextBatchProductType(accessPoint)
                        );
                }
                catch (NullReferenceException ex)
                {
                    retryConnection();
                }
                catch (InvalidOperationException e)
                {
                    retryConnection();
                }
                catch (LicenseException ex)
                {
                    remakeOPCClient();
                }
            }
            return null;

        }

        public void SendCommand(string command)
        {
            if (ValidConnection)
            {

                try
                {
                    int intCommand = 0;
                    if (int.TryParse(command, out intCommand))
                    {
                        machineWriteData.WriteControlCommand(accessPoint, intCommand);
                    }
                }
                catch (NullReferenceException ex)
                {
                    retryConnection();
                }
                catch (InvalidOperationException e)
                {
                    retryConnection();
                }
                catch (LicenseException ex)
                {
                    remakeOPCClient();
                }
            }

        }

        public void SetBatchParameters(string productType, string productionSpeed, string batchSize, string batchID)
        {
            if (ValidConnection)
            {

                try
                {
                    float floatType = 0;
                    int intSpeed = 0;
                    int intSize = 0;
                    int intID = 0;
                    float.TryParse(productType, out floatType);
                    int.TryParse(productionSpeed, out intSpeed);
                    int.TryParse(batchSize, out intSize);
                    int.TryParse(batchID, out intID);
                    machineWriteData.WriteNextBatchProductType(accessPoint, floatType);
                    machineWriteData.WriteDesiredMachineSpeed(accessPoint, intSpeed);
                    machineWriteData.WriteNextBatchSize(accessPoint, intSize);
                    machineWriteData.WriteNextBatchID(accessPoint, intID);

                }
                catch (NullReferenceException ex)
                {
                    retryConnection();
                }
                catch (InvalidOperationException e)
                {
                    retryConnection();
                }
                catch (LicenseException ex)
                {
                    remakeOPCClient();
                }
            }

        }

        public void SetParameters(BatchParameters batch)
        {
            if (ValidConnection)
            {

                try
                {
                    machineWriteData.WriteNextBatchProductType(accessPoint, batch.batchProductType);
                    machineWriteData.WriteDesiredMachineSpeed(accessPoint, batch.batchSpeed);
                    machineWriteData.WriteNextBatchSize(accessPoint, batch.batchSize);
                    machineWriteData.WriteNextBatchID(accessPoint, batch.batchID);
                    int abortedState = 9;
                    if (machineReadData.ReadCurrentState(accessPoint) == abortedState)
                    {
                        machineWriteData.WriteControlCommand(accessPoint, 5);
                        Thread.Sleep(1000);
                    }
                    machineWriteData.WriteControlCommand(accessPoint, 1);
                    Thread.Sleep(1000);
                    machineWriteData.WriteControlCommand(accessPoint, 2);
                }
                catch (NullReferenceException ex)
                {
                    retryConnection();
                }
                catch (InvalidOperationException e)
                {

                }
                catch (LicenseException ex)
                {
                    remakeOPCClient();
                }
            }


        }


        public bool CheckMachineConnection()
        {
            return opcConnection.CheckConnection();
        }


        private void ReconnectToMachine()
        {
            if (task == null || task.IsCompleted)
            {
                task = Task.Run(() =>
                {
                    while (!ValidConnection)
                    {
                        if (ConnectToMachine(currentMachineName))
                        {
                            ValidConnection = true;
                            Console.WriteLine("reconnected");
                        }
                        else
                        {
                            Thread.Sleep(1000);
                        }
                    }
                });
            }
        }

        private void retryConnection()
        {
            ValidConnection = false;
            ReconnectToMachine();
        }

        private void remakeOPCClient()
        {
            opcConnection = new OPCConnectionManager();
            opcConnection.ConnectToServer(currentMachineName);
            accessPoint = opcConnection.AccessPoint;
        }
    }
}
