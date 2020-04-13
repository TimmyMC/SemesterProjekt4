using Opc.UaFx.Client;

namespace BeerProductionAPI
{
    interface IMachineWriteData
    {
        void WriteDesiredMachineSpeed(OpcClient accessPoint, float speed);

        void WriteControlCommand(OpcClient accessPoint, int commandValue);

        void WriteCommandChangeRequest(OpcClient accessPoint);

        void WriteNextBatchID(OpcClient accessPoint, float batchID);

        void WriteNextBatchProductType(OpcClient accessPoint, float productTypeValue);

        void WriteNextBatchSize(OpcClient accessPoint, float batchSize);
    }
}
