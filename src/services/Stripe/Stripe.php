<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;


class Stripe // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('Stripe');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }

    public function collectRecurringayment(MimotoEntity $eInstance, $settings = null)
    {

    }

}