using Opc.UaFx.Client;
using System.Collections.Generic;

namespace BeerProductionAPI.API.MachineModule
{
    class MachineWriteData : IMachineWriteData
    {
        private Dictionary<NodeID, string> nodeIDDictionary;  //TODO move to Database package

        private enum NodeID { ControlCommand, CommandChangeRequest, MachSpeed, NextBatchID, NextBatchProductType, NextBatchSize};

        public MachineWriteData()
        {
            nodeIDDictionary = new Dictionary<NodeID, string>()
            {
                { NodeID.ControlCommand, "ns=6;s=::Program:Cube.Command.CntrlCmd" },
                { NodeID.CommandChangeRequest, "ns=6;s=::Program:Cube.Command.CmdChangeRequest" },
                { NodeID.MachSpeed, "ns=6;s=::Program:Cube.Command.MachSpeed" },
                { NodeID.NextBatchID, "ns=6;s=::Program:Cube.Command.Parameter[0].Value" },
                { NodeID.NextBatchProductType, "ns=6;s=::Program:Cube.Command.Parameter[1].Value" },
                { NodeID.NextBatchSize, "ns=6;s=::Program:Cube.Command.Parameter[2].Value" },
            };
        }

        public void WriteControlCommand(OpcClient accessPoint, int commandValue)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.ControlCommand], commandValue);
            WriteCommandChangeRequest(accessPoint);
        }

        public void WriteCommandChangeRequest(OpcClient accessPoint)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.CommandChangeRequest], true);
        }

        public void WriteDesiredMachineSpeed(OpcClient accessPoint, float speed)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.MachSpeed], speed);
        }

        public void WriteNextBatchID(OpcClient accessPoint, float batchID)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.NextBatchID], batchID);
        }

        public void WriteNextBatchProductType(OpcClient accessPoint, float productTypeValue)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.NextBatchProductType], productTypeValue);
        }

        public void WriteNextBatchSize(OpcClient accessPoint, float batchSize)
        {
            accessPoint.WriteNode(nodeIDDictionary[NodeID.NextBatchSize], batchSize);
        }
    }
}
