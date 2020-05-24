using System;
using System.Collections.Generic;
using System.Linq;
using System.Runtime.Serialization;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI.API.JsonObjectRepresentations
{
    [DataContract(IsReference = false)]
    public class BatchReportData
    {
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
        public float ProductType { get; set; }

        public BatchReportData(float batchID, float batchSize, float actualMachineSpeed, int producedProducts,
            int defectProducts, float productType)
        {
            BatchID = batchID;
            BatchSize = batchSize;
            ActualMachineSpeed = actualMachineSpeed;
            ProducedProducts = producedProducts;
            DefectProducts = defectProducts;
            ProductType = productType;
        }
    }
}
