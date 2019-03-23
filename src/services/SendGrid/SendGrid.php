<?php

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Data\MimotoEntity;
use Mimoto\Data\MimotoDataUtils;


class SendGridService // extends MimotoService
{

    public function __construct()
    {
//        $this->setServiceName('SendGrid');
//        $this->setVendorName('Mimoto');
//        $this->setVersion('1.0');
    }

    public function sendMail(MimotoEntity $eInstance, $settings = null)
    {
        // 1. validate input
        if (empty($settings)) return;
        if (empty($settings->fromEmail)) return;
        if (empty($settings->toEmail)) return;
        if (empty($settings->subject)) return;
        if (empty($settings->message) && empty($settings->componentPlain)) return;

        // 2. validate config
        if (empty(Mimoto::config('sendgrid.api_key'))) return;


        // ---


        // 3. setup
        $from = new SendGrid\Email($settings->fromName, $settings->fromEmail);
        $to = new SendGrid\Email($settings->toName, $settings->toEmail);

        if (!empty($settings->componentPlain))
        {
            $eComponentPlain = Mimoto::service('output')->create($settings->componentPlain, $eInstance);

            $contentPlain = new SendGrid\Content("text/plain", $eComponentPlain->render());
        }
        else
        {
            $contentPlain = new SendGrid\Content("text/plain", strip_tags($settings->message));
        }


        // 4. composer
        $mail = new SendGrid\Mail($from, $settings->subject, $to, $contentPlain);


        if (!empty($settings->componentHTML))
        {
            $eComponentHTML = Mimoto::service('output')->create($settings->componentHTML, $eInstance);

            $contentHTML = new SendGrid\Content("text/html", $eComponentHTML->render());

            $mail->addContent($contentHTML);
        }


        // 5. init
        $sg = new SendGrid(Mimoto::config('sendgrid.api_key'));


        // 6. send
        $response = $sg->client->mail()->send()->post($mail);


        // ---


        // #todo - optional: store in log

        //echo $response->statusCode();
        //print_r($response->headers());
        //echo $response->body();
    }


}