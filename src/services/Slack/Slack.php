<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;


class Slack // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('Slack');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }

    public function sendMessage(MimotoEntity $eInstance, $settings = null)
    {
        // 1. validate
        if (empty($settings) || !isset($settings->channel)) return;

        // 4. compose message
        $data = "payload=" . json_encode(array
            (
                "channel" => "#".$settings->channel,
                "text" => (!empty($settings->message)) ? $settings->message : '_empty message_',
                "username" => (isset($settings->username) && !empty($settings->username)) ? $settings->username : 'Slack for Mimoto',
                "icon_emoji" => (isset($settings->icon) && !empty($settings->icon)) ? $settings->icon: ''
            ));

        // 5. send
        // note: You can get your webhook endpoint from your Slack settings
        $ch = curl_init(Mimoto::value('config')->slack->webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }


}