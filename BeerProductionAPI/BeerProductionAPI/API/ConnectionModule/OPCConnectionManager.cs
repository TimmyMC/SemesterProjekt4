using Opc.UaFx;
using Opc.UaFx.Client;

namespace BeerProductionAPI.API.ConnectionModule
{
    class OPCConnectionManager
    {
        public OpcClient AccessPoint { get; set; }
        private readonly string PHYSICALURL = "opc.tcp://192.168.0.122:4840";
        private readonly string SIMULATIONURL = "opc.tcp://127.0.0.1:4840";

        public OPCConnectionManager() {
        }

        // server state was either connected or created, but "created" didn't sound like it wasn't connected
        public bool CheckConnection()
        {
            OpcClientState state = AccessPoint.State;
            return state == OpcClientState.Connected;
        }

        public bool ConnectToServer(string machineName)
        {
            string url = SetMachineAddress(machineName);
            AccessPoint = new OpcClient(url);

            try
            {
                AccessPoint.Connect();
                return true;    //Connected
            }
            catch (OpcException)
            {
                return false;   //Not Connected
            }
        }

        private string SetMachineAddress(string machineName)
        {
            return machineName == "Physical Machine" ? PHYSICALURL : SIMULATIONURL;
        }

        //disconnect and clean up
        public void DisconnectFromServer()
        {
            AccessPoint.Disconnect();
            AccessPoint.Dispose();
        }
    }
}
