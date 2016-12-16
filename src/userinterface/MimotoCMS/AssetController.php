<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * AssetController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AssetController
{

    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function loadJavascriptMimotoAimless(Application $app)
    {
        $this->setHeaderJavascript();

        return new Response($this->loadStaticFile('js/mimoto.aimless.js'));
    }

    public function loadJavascriptMimotoCMS(Application $app)
    {
        $this->setHeaderJavascript();

        return new Response($this->loadStaticFile('js/mimoto.cms.js'));
    }

    public function loadStylesheetMimotoCMS(Application $app)
    {
        $this->setHeaderCSS();

        return new Response($this->loadStaticFile('css/mimoto.cms.css'));
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    private function setHeaderJavascript()
    {
        header("Content-type: text/javascript; charset: UTF-8");
    }

    private function setHeaderCSS()
    {
        header("Content-type: text/css; charset: UTF-8");
    }

    private function loadStaticFile($sFile)
    {
        $sFile = dirname(dirname(dirname(dirname(__FILE__)))).'/web/static/'.$sFile;

        include($sFile);

        if (file_exists($sFile))
        {
            return file_get_contents($sFile);
        }
        else
        {
            die('File not found');
        }
    }
}
