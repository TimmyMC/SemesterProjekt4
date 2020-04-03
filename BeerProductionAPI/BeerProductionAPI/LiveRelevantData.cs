using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI
{

    [DataContract]

    public class LiveRelevantData
    {
        [DataMember]
        public float Temperature { get; }
        [DataMember]
        public float Humidity { get; }
        [DataMember]
        public float Vibration { get; }
        [DataMember]
        public int BatchID { get; set; }
        [DataMember]
        public int BatchSize { get; set; }
        [DataMember]
        public float ActualMachineSpeed { get; }
        [DataMember]
        public int ProducedProducts { get; }
        [DataMember]
        public int AcceptableProducts { get; set; }
        [DataMember]
        public int DefectProducts { get; }
        [DataMember]
        public float Barley { get; }
        [DataMember]
        public float Hops { get; }
        [DataMember]
        public float Malt { get; }
        [DataMember]
        public float Wheat { get; }
        [DataMember]
        public float Yeast { get; }
        [DataMember]
        public ushort MaintainenceMeter { get; }
        [DataMember]
        public int CurrentState { get; }
        [DataMember]
        public Dictionary<int, TimeSpan> StateDictionary { get; set; }

        public LiveRelevantData(float temperature, float humidity, float vibration, float actualMachineSpeed, int producedProducts, int defectProducts, float barley, float hops, float malt, float wheat, float yeast, ushort maintainenceMeter, int currentState)
        {
            Temperature = temperature;
            Humidity = humidity;
            Vibration = vibration;
            ActualMachineSpeed = actualMachineSpeed;
            ProducedProducts = producedProducts;
            DefectProducts = defectProducts;
            Barley = barley;
            Hops = hops;
            Malt = malt;
            Wheat = wheat;
            Yeast = yeast;
            MaintainenceMeter = maintainenceMeter;
            CurrentState = currentState;
            StateDictionaryInit();
        }

        private void StateDictionaryInit()
        {
            this.StateDictionary = new Dictionary<int, TimeSpan>();
            this.StateDictionary.Add((int)MachineState.Deactivated, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Clearing, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Stopped, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Starting, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Idle, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Suspended, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Execute, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Stopping, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Aborting, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Aborted, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Holding, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Held, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Resetting, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Completing, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Complete, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Deactivating, TimeSpan.Zero);
            this.StateDictionary.Add((int)MachineState.Activating, TimeSpan.Zero);

        }

    }
    enum MachineState
    {
        Deactivated,
        Clearing,
        Stopped,
        Starting,
        Idle,
        Suspended,
        Execute,
        Stopping,
        Aborting,
        Aborted,
        Holding,
        Held,
        Resetting = 15,
        Completing,
        Complete,
        Deactivating,
        Activating
    }

}
