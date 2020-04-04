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
                machineReadData.ReadCurrentState(accessPoint)
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

        public void SetBatchParameters(float productType, int productionSpeed, int batchSize, int batchID)
        {
            machineWriteData.WriteNextBatchProductType(accessPoint, productType);
            machineWriteData.WriteDesiredMachineSpeed(accessPoint, productionSpeed);
            machineWriteData.WriteNextBatchSize(accessPoint, batchSize);
            machineWriteData.WriteNextBatchID(accessPoint, batchID);

        }


        public bool CheckMachineConnection()
        {
            return opcConnection.CheckConnection();
        }

        public bool something(string floatID)
        {
            float virk = 0;
            float.TryParse(floatID, out virk);
            machineWriteData.WriteNextBatchID(accessPoint, virk);
            return true;
        }
    }
}
