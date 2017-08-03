<?php


require_once("Kraken.php");


class KrakenService extends MimotoService
{

    public function __construct()
    {
        $this->setServiceName('Kraken');
        $this->setVendorName('Mimoto');
        $this->setVersion('1.0');

    }

    public function optimizeImage(MimotoEntity $eImage)
    {

        // https://github.com/kraken-io/kraken-php
        // https://kraken.io/docs/generating-image-sets


        // entity: kraken_job - kraken_job_id = value, image = entity


        require_once("Kraken.php");

        $kraken = new Kraken("your-api-key", "your-api-secret");

        $params = array(
            "url" => "http://awesome-website.com/images/header.png",
            "wait" => true
        );

        $data = $kraken->url($params);

        if ($data["success"]) {
            echo "Success. Optimized image URL: " . $data["kraked_url"];
        } else {
            echo "Fail. Error message: " . $data["message"];
        }
    }


}