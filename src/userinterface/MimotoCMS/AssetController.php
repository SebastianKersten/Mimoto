<?php

// classpath
namespace Mimoto\UserInterface\MimotoCMS;

// Silex classes
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/**
 * AssetController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class AssetController
{

    private $_sStaticFolder = '';
    private $_sDynamicFolder = '';



    public function __construct()
    {
        $this->_sStaticFolder = dirname(dirname(dirname(dirname(__FILE__)))).'/web/static/';
        $this->_sDynamicFolder = dirname(dirname(dirname(dirname(__FILE__)))).'/web/dynamic/';
    }




    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function loadJavascriptMimoto(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'js/mimoto.js');
    }

    public function loadJavascriptMapMimoto(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'js/mimoto.js.map');
    }

    public function loadJavascriptMimotoCMS(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'js/mimoto.cms.js');
    }

    public function loadJavascriptMapMimotoCMS(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'js/mimoto.cms.js.map');
    }

    public function loadStylesheetMimotoCMS(Application $app)
    {
        // compose
        $sFile = $this->_sStaticFolder.'css/mimoto.cms.css';

        // open the file in a binary mode
        $fp = fopen($sFile, 'rb');

        // prepare
        header("Content-type: text/css; charset: UTF-8");

        // 1. load and send
        return new Response(fpassthru($fp));
    }

    public function loadFontFuturaTtf(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/futura/4d6d50ec-b049-44ba-a001-e847c3e2dc79.ttf');
    }

    public function loadFontFuturaEot(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/futura/94fe45a6-9447-4224-aa0f-fa09fe58c702.eot');
    }

    public function loadFontFuturaWoff(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/futura/475da8bf-b453-41ee-ab0e-bd9cb250e218.woff');
    }

    public function loadFontFuturaWoff2(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/futura/cb9d11fa-bd41-4bd9-8b8f-34ccfc8a80a2.woff2');
    }

    public function loadFontAwesomeTtf(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/fontawesome/fontawesome-webfont.ttf');
    }

    public function loadFontAwesomeEot(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/fontawesome/fontawesome-webfont.eot');
    }

    public function loadFontAwesomeWoff(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/fontawesome/fontawesome-webfont.woff');
    }

    public function loadFontAwesomeWoff2(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'fonts/fontawesome/fontawesome-webfont.woff2');
    }

    public function loadImageLogo(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'images/mimoto_logo.png');
    }

    public function loadImageLogoCollapsed(Application $app)
    {
        // 1. load and send
        return new BinaryFileResponse($this->_sStaticFolder.'images/mimoto_logo_collapsed.png');
    }

}
