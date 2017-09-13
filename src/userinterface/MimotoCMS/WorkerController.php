<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Gearman classes
use GearmanWorker;

// ElephantIO classes
use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version0X;
use ElephantIO\Engine\SocketIO\Version1X;
use ElephantIO\Engine\SocketIO\Version2X;
use ElephantIO\Exception\ServerConnectionFailureException;

// Brian L. Moon classes
use Net_Gearman_Manager;


/**
 * WorkerController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class WorkerController
{

    //private $_socketIOClient = null;
    private $_socket = null;
    private $_loop = null;
    private $_connector = null;
    private $_connection = null;


    private $_emitter = null;



    public function overview(Application $app)
    {
        $gearmanManager = new Net_Gearman_Manager('127.0.0.1');

        $workers = $gearmanManager->workers();

        Mimoto::error($workers);
    }

    public function data(Request $request, Application $app)
    {
        echo "\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "--- Mimoto - The ultra fast, fluid & realtime data management microframework ---\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "\n";
        echo "Booting Socket.io worker at ".date('Y.m.d H:i:s')." ... \n\n";


        // output
        ob_flush();
        flush();


        // setup connection
        $this->_socketIOClient = new Client(new Version1X(Mimoto::value('config')->socketio->workergateway));

        // init
        $worker = new GearmanWorker();

        // setup
        $worker->addServer(Mimoto::value('config')->gearman->server_address);
        $worker->addFunction("sendUpdate", function($job)
        {
            // read
            $workload = json_decode($job->workload());

            // convert
            $aData = [];
            foreach ($workload->data as $sKey => $value)
            {
                $aData[$sKey] = $value;
            }

            $this->_socketIOClient->initialize(false);
            $this->_socketIOClient->emit($workload->sEvent, $aData);
            $this->_socketIOClient->close();

            // output
            echo "Socket.io event (".date('Y.m.d H:i:s').")\n";
            echo "-------------------------------------\n";
            echo print_r($workload, true);
            echo "-------------------------------------\n\n\n";

            // output
            ob_flush();
            flush();
        });

        var_dump($worker, true);

        // run
        while ($worker->work());


        // output
        return new Response();
    }

    public function xxx()
    {

        $time = date('YmdHis');

        echo 'Poging -----> '.$time.'\n';


        return $time < '20170510102700';

        //return true;
    }

    public function slack(Request $request, Application $app)
    {

        //Mimoto::error(gearman_version());

        echo "\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "--- Mimoto - The ultra fast, fluid & realtime data management microframework ---\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "\n";
        echo "Booting Slack worker at ".date('Y.m.d H:i:s')." ... \n\n";

        // output
        ob_flush();
        flush();


        // init
        $worker = new GearmanWorker();

        // setup
        $worker->addServer(Mimoto::value('config')->gearman->server_address);
        $worker->addFunction("sendSlackNotification", function ($job) {


            // read
            $workload = json_decode($job->workload());

            // compose
            $data = "payload=" . json_encode(array
                (
                    "channel" => "#" . $workload->channel,
                    "text" => $workload->message,
                    "username" => "Mimoto",
                    "icon_emoji" => ":ant:"
                ));

            echo "Slack event (" . date('Y.m.d H:i:s') . ")\n";
            echo "-------------------------------------\n";
            echo print_r($data, true);
            echo "-------------------------------------\n\n\n";


            // You can get your webhook endpoint from your Slack settings
            $ch = curl_init(Mimoto::value('config')->slack->webhook);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);


            // output
            ob_flush();
            flush();
        });

        while ($worker->work()) ;
    }
}
