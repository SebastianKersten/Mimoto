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
        $this->_socketIOClient = new Client(new Version1X(Mimoto::service('config')->get('socketio.workerAddress').':'.Mimoto::service('config')->get('socketio.workerPort')));

        // init
        $worker = new GearmanWorker();

        // setup
        $worker->addServer(Mimoto::service('config')->get('gearman.serverAddress'));
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

    public function async(Request $request, Application $app)
    {
        echo "\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "--- Mimoto - The ultra fast, fluid & realtime data management microframework ---\n";
        echo "--------------------------------------------------------------------------------\n";
        echo "\n";
        echo "Booting async event worker at ".date('Y.m.d H:i:s')." ... \n\n";


        // output
        ob_flush();
        flush();


        // init
        $sServicesPath = Mimoto::service('config')->get('folders.projectroot').Mimoto::service('config')->get('folders.services');


        // init
        $worker = new GearmanWorker();

        // setup
        $worker->addServer(Mimoto::service('config')->get('gearman.serverAddress'));
        $worker->addFunction("asyncEvent", function($job, $sServicesPath)
        {
            // read
            $workload = json_decode($job->workload());


            // output
            echo "Async event (".date('Y.m.d H:i:s').")\n";
            echo "-------------------------------------\n";
            echo print_r($workload, true);
            echo "-------------------------------------\n\n\n";



            if (!empty($sServicesPath) && isset($workload->serviceName) && isset($workload->serviceFile) && isset($workload->function))
            {
                // 1. verify
                if (!class_exists($workload->serviceName)) {
                    // a. prepare
                    $sClassFile = $sServicesPath . $workload->serviceFile;

                    // b. verify
                    if (file_exists($sClassFile)) {
                        // load
                        require_once($sClassFile);
                    }
                }


                // init
                $service = new $workload->serviceName;

                // load
                $eInstance = Mimoto::service('data')->get($workload->entityType, $workload->instanceId);

                // a. call and pass clone of settings (unserialize/serialize)
                call_user_func([$service, $workload->function], $eInstance, $workload->settings);
            }


            // output
            ob_flush();
            flush();
        }, $sServicesPath);

        var_dump($worker, true);

        // run
        while ($worker->work());


        // output
        return new Response();
    }
    
}
