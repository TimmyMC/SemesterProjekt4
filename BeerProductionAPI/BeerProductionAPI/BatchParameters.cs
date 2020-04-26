using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI
{
    [DataContract]
    public class BatchParameters
    {
        [DataMember]
        public float productType { get; set; }
        [DataMember]
        public int batchID { get; set; }
        [DataMember]
        public int productionSpeed { get; set; }
        [DataMember]
        public int batchSize { get; set; }
    }
}
