using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;
using System.Threading.Tasks;
using BeerProductionAPI.API;
using BeerProductionAPI.API.JsonObjectRepresentations;

namespace BeerProductionAPI
{
    [ServiceContract]
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
        UriTemplate = "data")]
        LiveRelevantData GetUpdateData();


        [OperationContract]
        [WebGet(ResponseFormat = WebMessageFormat.Json,
        UriTemplate = "batchReport")]
        BatchReportData getBatchReportData();


        [OperationContract]
        [WebInvoke(ResponseFormat = WebMessageFormat.Json
        , UriTemplate = "sendCommand/{command}")]
        void SendCommand(string command);

        //skal data sendes som json data, eller opsat i parametre i URI'en?

        
        [OperationContract]
        [WebInvoke(ResponseFormat = WebMessageFormat.Json
        , UriTemplate = "BatchParameters/{productType}/{productionSpeed}/{batchSize}/{batchID}")]
        void SetBatchParameters(string productType, string productionSpeed, string batchSize, string batchID);

        //[return: MessageParameter(Name = "success")]  an example on how to choose the key value when returning as json

        [OperationContract]
        [WebInvoke(ResponseFormat = WebMessageFormat.Json, RequestFormat = WebMessageFormat.Json, BodyStyle = WebMessageBodyStyle.Bare
        , UriTemplate = "BatchParameters")]
        void SetParameters(BatchParameters batchParameters);


    }
}
