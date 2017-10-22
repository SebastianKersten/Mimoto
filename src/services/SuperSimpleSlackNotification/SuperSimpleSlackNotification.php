<?php



// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;


class SuperSimpleSlackNotification // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('SuperSimpleSlackNotification');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }

    public function sendNotification(MimotoEntity $eArticle, $settings = null)
    {



        // compose
        $data = "payload=" . json_encode(array
            (
                "channel" => "#" . 'mimoto_notifications',
                "text" => "An article was changed\n```Title = ".$eArticle->get('title')."```\n```".json_encode($settings)."```",
                "username" => "Mimoto",
                "icon_emoji" => ":ant:"
            ));

        // You can get your webhook endpoint from your Slack settings
        $ch = curl_init(Mimoto::value('config')->slack->webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }


}