<?php





class SuperSimpleMail extends MimotoService
{

    public function __construct()
    {
        $this->setServiceName('SuperSimpleMail');
        $this->setVendorName('Mimoto');
        $this->setVersion('1.0');

    }

    public function sendMail(MimotoEntity $eArticle)
    {

    }


}