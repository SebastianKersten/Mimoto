<?php

// classpath
namespace Mimoto\CMS;

// Mimoto classes
use Mimoto\Event\MimotoEventServiceProvider;
use Mimoto\Aimless\MimotoAimlessServiceProvider;
use Mimoto\Data\MimotoEntityServiceProvider;
use Mimoto\Cache\MimotoCacheServiceProvider;



/**
 * Mimoto
 *
 * @author Sebastian Kersten (@subertaboo)
 */
class Mimoto
{
    
    /**
     * Constructor
     * @param Application $app
     */
    public function __construct($app)
    {

        // setup templates
        $app['twig']->getLoader()->addPath(dirname(dirname(dirname(__FILE__))).'/userinterface/templates');


        // setup entities - #todo - combine all in MimotoProvider
        $app->register(new MimotoCacheServiceProvider());
        $app->register(new MimotoEntityServiceProvider());
        $app->register(new MimotoAimlessServiceProvider());
        $app->register(new MimotoEventServiceProvider());


        function output($sTitle, $data)
        {
            echo '<div style="background-color:#f5f5f5;border:solid 1px #858585;padding:0 20px 20px 20px">';
            echo '<h2><b style="color:#06afea">'.$sTitle.'</b></h2><hr>';
            echo '<pre style="width:100%">';
            print_r($data);
            echo '</pre>';
            echo '</div>';
            echo '<br>';
        }

        function error($sMessage)
        {
            echo '<div style="background-color:#f3f3f3;border:solid 1px #cccccc;padding:0 20px 20px 20px">';
            echo '<div style="display:inline-block;position:relative;margin-right:20px;width:220px;height:50px;overflow:hidden;background-image:url(http://mimoto.nl/Mimoto.Applications/Website/img/985c78e82ddadbb8b1197a78d89ca537.png);"></div>';
            echo '<div style="display:inline-block;position:relative;">';
            echo '<h2><b style="color:#ff66cc;padding:0 20px 0 0;">Error</b></h2><hr>';
            echo $sMessage;
            echo '</div>';
            echo '<br>';
            die();
        }

    }
    
}
