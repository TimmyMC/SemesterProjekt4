using Opc.UaFx.Client;
using System;
using System.Collections.Generic;

namespace BeerProductionAPI
{
    class MachineReadData : IMachineReadData
    {
        private Dictionary<NodeID, string> nodeIDDictionary;
        private enum NodeID
        {
            ProducedProducts, DefectProducts, StopReasonID, StopReasonValue, CurrentState, BatchID, BatchSize, Humidity, Temperature,
            Vibration, ActualMachineSpeed, NormalizedSpeed, DesiredSpeed, ControlCommand, CommandChangeRequest, NextBatchID, NextBatchType, NextBatchSize,
            BarleyAmount, HopsAmount, MaltAmount, WheatAmount, YeastAmount, FillingInventory, MaintenanceCounter, MaintenanceTrigger
        }

        public MachineReadData()
        {
            nodeIDDictionary = new Dictionary<NodeID, string>
            {
                {NodeID.ActualMachineSpeed, "ns=6;s=::Program:Cube.Status.MachSpeed" },
                {NodeID.BarleyAmount, "ns=6;s=::Program:Inventory.Barley" },
                {NodeID.BatchID, "ns=6;s=::Program:batch_id"},
                {NodeID.BatchSize, "ns=6;s=::Program:Cube.Status.Parameter[1].Value" },
                {NodeID.CommandChangeRequest, "ns=6;s=::Program:Cube.Command.CmdChangeRequest" },
                {NodeID.ControlCommand, "ns=6;s=::Program:Cube.Command.CntrlCmd" },
                {NodeID.CurrentState, "ns=6;s=::Program:Cube.Status.StateCurrent"  },
                {NodeID.DefectProducts, "ns=6;s=::Program:product.bad" },
                {NodeID.DesiredSpeed, "ns=6;s=::Program:Cube.Command.MachSpeed" },
                {NodeID.FillingInventory, "ns=6;s=::Program:FillingInventory"},
                {NodeID.HopsAmount, "ns=6;s=::Program:Inventory.Hops"},
                {NodeID.Humidity, "ns=6;s=::Program:Cube.Status.Parameter[2].Value" },
                {NodeID.MaintenanceCounter, "ns=6;s=::Program:Maintenance.Counter" },
                {NodeID.MaintenanceTrigger, "ns=6;s=::Program:Maintanence.Trigger" },
                {NodeID.MaltAmount, "ns=6;s=::Program:Inventory.Malt" },
                {NodeID.NextBatchID, "ns=6;s=::Program:Cube.Command.Parameter[0].Value" },
                {NodeID.NextBatchSize, "ns=6;s=::Program:Cube.Command.Parameter[2].Value" },
                {NodeID.NextBatchType, "ns=6;s=::Program:Cube.Command.Parameter[1].Value" },
                {NodeID.NormalizedSpeed, "ns=6;s=::Program:Cube.Status.CurMachSpeed" },
                {NodeID.ProducedProducts, "ns=6;s=::Program:product.produced" },
                {NodeID.StopReasonID, "ns=6;s=::Program:Cube.Admin.StopReason.ID" },
                {NodeID.StopReasonValue, "ns=6;s=::Program:Cube.Admin.StopReason.Value" },
                {NodeID.Temperature, "ns=6;s=::Program:Cube.Status.Parameter[3].Value" },
                {NodeID.Vibration, "ns=6;s=::Program:Cube.Status.Parameter[4].Value" },
                {NodeID.WheatAmount, "ns=6;s=::Program:Inventory.Wheat" },
                {NodeID.YeastAmount,"ns=6;s=::Program:Inventory.Yeast" }
                
            };
            
        }

        public float ReadActualMachineSpeed(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.ActualMachineSpeed]).Value;
        }

        public float ReadBarleyAmount(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.BarleyAmount]).Value;
        }

        public UInt16 ReadBatchID(OpcClient accessPoint)
        {
            return (UInt16)accessPoint.ReadNode(nodeIDDictionary[NodeID.BatchID]).Value;
        }

        public ushort ReadBatchSize(OpcClient accessPoint)
        {
            return (ushort)accessPoint.ReadNode(nodeIDDictionary[NodeID.BatchSize]).Value;
        }

        public bool ReadCommandChangeRequest(OpcClient accessPoint)
        {
            return (bool)accessPoint.ReadNode(nodeIDDictionary[NodeID.CommandChangeRequest]).Value;
        }

        public int ReadControlCommand(OpcClient accessPoint)
        {
            return (int)accessPoint.ReadNode(nodeIDDictionary[NodeID.ControlCommand]).Value;
        }

        public int ReadCurrentState(OpcClient accessPoint)
        {
            return (int)accessPoint.ReadNode(nodeIDDictionary[NodeID.CurrentState]).Value;
        }

        public ushort ReadDefectProducts(OpcClient accessPoint)
        {
            return (ushort)accessPoint.ReadNode(nodeIDDictionary[NodeID.DefectProducts]).Value;
        }

        public float ReadDesiredMachineSpeed(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.DesiredSpeed]).Value;
        }

        public bool ReadFlillingInventory(OpcClient accessPoint)
        {
            return (bool)accessPoint.ReadNode(nodeIDDictionary[NodeID.FillingInventory]).Value;
        }

        public float ReadHopsAmount(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.HopsAmount]).Value;
        }

        public float ReadHumidity(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.Humidity]).Value;
        }

        public ushort ReadMaintenanceCounter(OpcClient accessPoint)
        {
            return (ushort)accessPoint.ReadNode(nodeIDDictionary[NodeID.MaintenanceCounter]).Value;
        }

        public ushort ReadMaintenanceTrigger(OpcClient accessPoint)
        {
            return (ushort)accessPoint.ReadNode(nodeIDDictionary[NodeID.MaintenanceTrigger]).Value;
        }

        public float ReadMaltAmount(OpcClient accesspoint)
        {
            return (float)accesspoint.ReadNode(nodeIDDictionary[NodeID.MaltAmount]).Value;
        }

        public float ReadNextBatchID(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.NextBatchID]).Value;
        }
        public float ReadNextBatchSize(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.NextBatchSize]).Value;
        }

        public float ReadNextBatchProductType(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.NextBatchType]).Value;
        }

        public float ReadNormalizedMachineSpeed(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.NormalizedSpeed]).Value;
        }

        public ushort ReadProducedProducts(OpcClient accessPoint)
        {
            return (ushort)accessPoint.ReadNode(nodeIDDictionary[NodeID.ProducedProducts]).Value;
        }

        public int ReadStopReasonID(OpcClient accessPoint)
        {
            return (int)accessPoint.ReadNode(nodeIDDictionary[NodeID.StopReasonID]).Value;
        }

        public int ReadStopReasonValue(OpcClient accessPoint)
        {
            return (int)accessPoint.ReadNode(nodeIDDictionary[NodeID.StopReasonValue]).Value;
        }

        public float ReadTemperature(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.Temperature]).Value;
        }

        public float ReadVibration(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.Vibration]).Value;
        }

        public float ReadWheatAmount(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.WheatAmount]).Value;
        }

        public float ReadYeastAmount(OpcClient accessPoint)
        {
            return (float)accessPoint.ReadNode(nodeIDDictionary[NodeID.YeastAmount]).Value;
        }
    }
}
