<?php


// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;


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
        if (empty($settings) && !isset($settings->channel)) return;

        // 2. replace enter
        $settings->message = preg_replace('/\\\n/', chr(13), $settings->message);

        // 3. get variables
        if (preg_match('/({{.*?}})/U', $settings->message, $aMatches))
        {
            // remove full match
            array_splice($aMatches, 0, 1);

            $nVarCount = count($aMatches);
            for ($nVarIndex = 0; $nVarIndex < $nVarCount; $nVarIndex++)
            {
                // a. register
                $sMatch = $aMatches[$nVarIndex];

                // b. isolate
                $sPropertyName = trim(substr($sMatch, 2, strlen($sMatch) - 4));

                // c. validate
                if (!MimotoDataUtils::validatePropertyName($sPropertyName) || !$eInstance->hasProperty($sPropertyName)) continue;

                // d. inject
                $settings->message = preg_replace('/'.$sMatch.'/', $eInstance->get($sPropertyName), $settings->message);
            }
        }

        // 4. compose message
        $data = "payload=" . json_encode(array
            (
                "channel" => "#".$settings->channel,
                "text" => (isset($settings->message) ? $settings->message : '_empty message_'),
                "username" => (isset($settings->username) ? $settings->username : 'Slack for Mimoto'),
                "icon_emoji" => (isset($settings->icon) ? $settings->icon: '')
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