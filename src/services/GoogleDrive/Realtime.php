<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;


class Realtime // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('Data');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }


    public function broadcastOnCreate(MimotoEntity $eInstance, $settings = null)
    {

    }

    public function broadcastOnUpdate(MimotoEntity $eInstance, $settings = null)
    {

    }

    public function broadcastOnDelete(MimotoEntity $eInstance, $settings = null)
    {

    }

}
