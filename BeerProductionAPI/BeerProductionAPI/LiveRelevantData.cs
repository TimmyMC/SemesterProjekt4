using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI
{

    [DataContract(IsReference = false)]
    public class LiveRelevantData
    {
        [DataMember]
        public float Temperature { get; set; }
        [DataMember]
        public float Humidity { get; set; }
        [DataMember]
        public float Vibration { get; set; }
        [DataMember]
        public float BatchID { get; set; }
        [DataMember]
        public float BatchSize { get; set; }
        [DataMember]
        public float ActualMachineSpeed { get; set; }
        [DataMember]
        public int ProducedProducts { get; set; }
        [DataMember]
        public int AcceptableProducts { get; set; }
        [DataMember]
        public int DefectProducts { get; set; }
        [DataMember]
        public float Barley { get; set; }
        [DataMember]
        public float Hops { get; set; }
        [DataMember]
        public float Malt { get; set; }
        [DataMember]
        public float Wheat { get; set; }
        [DataMember]
        public float Yeast { get; set; }
        [DataMember]
        public ushort MaintainenceMeter { get; set; }
        [DataMember]
        public int CurrentState { get; set; }
        /*
        [DataMember]
        public Dictionary<int, TimeSpan> StateDictionary { get; set; }
        */
        public LiveRelevantData(float temperature, float humidity, float vibration,
            float actualMachineSpeed, int producedProducts, 
            int defectProducts, float barley, float hops, float malt, float wheat, 
            float yeast, ushort maintainenceMeter, int currentState, float batchID, float batchSize)
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
            BatchID = batchID;
            BatchSize = batchSize;
           // StateDictionaryInit();
        }
        /*
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
        */

    }


}
