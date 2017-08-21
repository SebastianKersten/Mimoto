<?php

class GoogleDriveService extends MimotoService
{

    public function __construct()
    {
        $this->setServiceName('Drive');
        $this->setVendorName('Google');
        $this->setVersion('1.0');

    }

}