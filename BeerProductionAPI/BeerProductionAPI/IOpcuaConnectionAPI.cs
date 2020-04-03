using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;
using System.Threading.Tasks;

namespace BeerProductionAPI
{
    interface IOpcuaConnectionAPI
    {
        [OperationContract]
        [WebInvoke(ResponseFormat = WebMessageFormat.Json, BodyStyle = WebMessageBodyStyle.Wrapped
        , UriTemplate = "Connect/{machineName}")]
        bool ConnectToMachine(string machineName);

        [OperationContract]
        [WebGet(ResponseFormat = WebMessageFormat.Json, BodyStyle = WebMessageBodyStyle.Wrapped
        ,UriTemplate = "Connection")]
        bool CheckMachineConnection();

        [OperationContract]
        [WebGet(ResponseFormat = WebMessageFormat.Json,
        UriTemplate = "allData")]
        LiveRelevantData GetUpdateData();


        [OperationContract]
        [WebInvoke(ResponseFormat = WebMessageFormat.Json
        , UriTemplate = "sendCommand/{command}")]
        void SendCommand(string command);

        //skal data sendes som json data, eller opsat i parametre i URI'en?

        void SetBatchParameters(float productType, int productionSpeed, int batchSize, int batchID);

    }
}
