<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;


class Article // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('Article');
//        $this->setVendorName('The Correspondent');
//        $this->setVersion('1.0');
    }


    public function highlightComment(MimotoEntity $eInstance = null, $settings = null)
    {
        //Mimoto::output('settings', $settings);
        //Mimoto::error('highlightComment reached!');


        return $eInstance->get('message');//$settings;
    }

}