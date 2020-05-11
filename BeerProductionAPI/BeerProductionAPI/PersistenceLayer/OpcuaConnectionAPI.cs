using BeerProductionAPI;
using Opc.UaFx.Client;
using System.Collections.Generic;
using System.ServiceModel;

namespace BeerProductionAPI
{
    /// <summary>
    /// Implementation of the IPersistenceFacade interface
    /// </summary>
    /// 
    //[ServiceBehavior(InstanceContextMode = InstanceContextMode.Single)]
    //måske lav klasse til singleton hvis contructor ikke bliver kaldt
    public class OpcuaConnectionAPI : IOpcuaConnectionAPI
    {
        private IMachineReadData machineReadData;
        private IMachineWriteData machineWriteData;
        private OPCConnectionManager opcConnection;
        private OpcClient accessPoint;
        private string currentMachineName;

        public OpcuaConnectionAPI()
        {
            machineReadData = new MachineReadData();
            machineWriteData = new MachineWriteData();
            opcConnection = new OPCConnectionManager();
            ConnectToMachine("opc.tcp://127.0.0.1:4840");
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
                machineReadData.ReadNextBatchSize(accessPoint)
                );
        }

        public BatchReportData getBatchReportData()
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

        public void SendCommand(string command)
        {
            int intCommand = 0;
            if (int.TryParse(command, out intCommand))
            {
                machineWriteData.WriteControlCommand(accessPoint, intCommand);
            }
        }

        public void SetBatchParameters(string productType, string productionSpeed, string batchSize, string batchID)
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

        public void SetParameters(BatchParameters batch)
        {
            machineWriteData.WriteNextBatchProductType(accessPoint, batch.batchProductType);
            machineWriteData.WriteDesiredMachineSpeed(accessPoint, batch.batchSpeed);
            machineWriteData.WriteNextBatchSize(accessPoint, batch.batchSize);
            machineWriteData.WriteNextBatchID(accessPoint, batch.batchID);
            int abortedState = 9;
            if (machineReadData.ReadCurrentState(accessPoint) == abortedState)
            {
                machineWriteData.WriteControlCommand(accessPoint, 5);
            }
            machineWriteData.WriteControlCommand(accessPoint, 1);
            machineWriteData.WriteControlCommand(accessPoint, 2);

        }


        public bool CheckMachineConnection()
        {
            return opcConnection.CheckConnection();
        }

        public bool IdTest(string floatID)
        {
            float virk = 0;
            float.TryParse(floatID, out virk);
            machineWriteData.WriteNextBatchID(accessPoint, virk);
            return true;
        }
    }
}
