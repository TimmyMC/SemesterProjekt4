using System;
using System.Collections.Generic;
using System.Linq;
using System.ServiceModel;
using System.ServiceModel.Web;
using System.Text;
using System.Threading.Tasks;
using System.Runtime.Serialization;
using System.ServiceModel.Description;

namespace BeerProductionAPI
{
    class Program
    {
        static void Main(string[] args)
        {

            WebServiceHost host = new WebServiceHost(typeof(OpcuaConnectionAPI), new Uri("http://localhost:8001/"));
            try
            {
                ServiceEndpoint ep = host.AddServiceEndpoint(typeof(IOpcuaConnectionAPI), new WebHttpBinding(), "");
                host.Open();
                using (ChannelFactory<IOpcuaConnectionAPI> cf = new ChannelFactory<IOpcuaConnectionAPI>(new WebHttpBinding(), "http://localhost:8000"))
                {
                    cf.Endpoint.Behaviors.Add(new WebHttpBehavior());

                    IOpcuaConnectionAPI channel = cf.CreateChannel();

                    string s;

                    Console.WriteLine("Calling EchoWithGet via HTTP GET: ");
                    Console.WriteLine("   Output: {0}", "virk");

                    Console.WriteLine("");
                    Console.WriteLine("This can also be accomplished by navigating to");
                    Console.WriteLine("http://localhost:8000/EchoWithGet?s=Hello, world!");
                    Console.WriteLine("in a web browser while this sample is running.");

                    Console.WriteLine("");

                    Console.WriteLine("Calling EchoWithPost via HTTP POST: ");
                    Console.WriteLine("   Output: {0}", "virk");
                    Console.WriteLine("");
                }

                Console.WriteLine("Press <ENTER> to terminate");
                Console.ReadLine();

                host.Close();
            }
            catch (CommunicationException cex)
            {
                Console.WriteLine("An exception occurred: {0}", cex.Message);
                host.Abort();
            }
        }

        public static void writeText(string text)
        {
            Console.WriteLine(text);
        }
    }
}
