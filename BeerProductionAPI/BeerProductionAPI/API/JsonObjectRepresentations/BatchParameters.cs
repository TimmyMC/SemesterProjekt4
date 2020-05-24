using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI.API.JsonObjectRepresentations
{
    [DataContract]
    public class BatchParameters
    {
        [DataMember(Order =1)]
        public float batchProductType { get; set; }
        [DataMember(Order =0)]
        public int batchID { get; set; }
        [DataMember(Order =2)]
        public int batchSpeed { get; set; }
        [DataMember(Order =3)]
        public int batchSize { get; set; }
    }
}
