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

    // ----------------------------------------------------------------------------
    // --- Public methods ---------------------------------------------------------
    // ----------------------------------------------------------------------------


    public function loadJavascriptMimotoAimless(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForJavascript();

        // 2. load and send
        return new Response($this->loadStaticFile('js/mimoto.aimless.js'));
    }

    public function loadJavascriptMimotoCMS(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForJavascript();

        // 2. load and send
        return new Response($this->loadStaticFile('js/mimoto.cms.js'));
    }

    public function loadStylesheetMimotoCMS(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForCSS();

        // 2. load and send
        return new Response($this->loadStaticFile('css/mimoto.cms.css'));
    }

    public function loadFontFuturaTtf(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForFont();

        // 2. load and send
        return new Response($this->loadStaticFile('fonts/futura/4d6d50ec-b049-44ba-a001-e847c3e2dc79.ttf'));
    }

    public function loadFontFuturaEot(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForFont();

        // 2. load and send
        return new Response($this->loadStaticFile('fonts/futura/94fe45a6-9447-4224-aa0f-fa09fe58c702.eot'));
    }

    public function loadFontFuturaWoff(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForFont();

        // 2. load and send
        return new Response($this->loadStaticFile('fonts/futura/475da8bf-b453-41ee-ab0e-bd9cb250e218.woff'));
    }

    public function loadFontFuturaWoff2(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForFont();

        // 2. load and send
        return new Response($this->loadStaticFile('fonts/futura/cb9d11fa-bd41-4bd9-8b8f-34ccfc8a80a2.woff2'));
    }

    public function loadImageLogo(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForImagePNG();

        // 2. load and send
        return new Response($this->loadStaticFile('images/mimoto_logo.png'));
    }

    public function loadImageLogoCollapsed(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForImagePNG();

        // 2. load and send
        return new Response($this->loadStaticFile('images/mimoto_logo_collapsed.png'));
    }

    public function loadImageAvatar(Application $app)
    {
        // 1. prepare output
        $this->setHeaderForImagePNG();

        // 2. load and send
        return new Response($this->loadDynamicFile('avatar.png'));
    }



    // ----------------------------------------------------------------------------
    // --- Private methods --------------------------------------------------------
    // ----------------------------------------------------------------------------


    /**
     * Set header to match javascript content
     */
    private function setHeaderForJavascript()
    {
        header("Content-type: application/javascript; charset: UTF-8");
    }

    /**
     * Set header to match stylesheet content
     */
    private function setHeaderForCSS()
    {
        header("Content-type: text/css; charset: UTF-8");
    }

    /**
     * Set header to match font content
     */
    private function setHeaderForFont()
    {
        header("Content-type: font/opentype");
    }

    /**
     * Set header to match png content
     */
    private function setHeaderForImagePNG()
    {
        header("Content-type: image/png");
    }

    /**
     * Load static file
     * @param $sFile
     * @return string
     */
    private function loadStaticFile($sFile)
    {
        // compose
        $sFile = dirname(dirname(dirname(dirname(__FILE__)))).'/web/static/'.$sFile;

        // load and send
        return (file_exists($sFile)) ? file_get_contents($sFile) : 'File not found';
    }

    /**
     * Load dynamic file
     * @param $sFile
     * @return string
     */
    private function loadDynamicFile($sFile)
    {
        // compose
        $sFile = dirname(dirname(dirname(dirname(__FILE__)))).'/web/dynamic/'.$sFile;

        // load and send
        return (file_exists($sFile)) ? file_get_contents($sFile) : 'File not found';
    }
}
