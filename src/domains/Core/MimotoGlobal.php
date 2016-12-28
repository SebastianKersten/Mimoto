<?php

namespace domains\Core;


final class MimotoGlobal
{

    private $aServices = [];


    public static function getService($sServiceName) { }



    /**
     * Call this method to get singleton
     *
     * @return MimotoGlobal
     */
    public static function singleton()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new MimotoGlobal();
        }
        return $inst;
    }

    /**
     * Private ctor so nobody else can instance it
     *
     */
    private function __construct()
    {
        //Mimoto::service('data')->get
    }


    //public function setService()
}
