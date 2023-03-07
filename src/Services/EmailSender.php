<?php
namespace App\Services;

use App\Entity\User;
use Mailjet\Client;
use Mailjet\Resources;
use App\Entity\EmailModel;

class EmailSender{

    public function sendEmailContactByMailJet(User $user, EmailModel $email){
        # This call sends a message to the given recipient with vars and custom vars.
            $mj = new Client($_ENV['MJ_API_PUBLIC'], $_ENV['MJ_API_SECRETE'],true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                [
                    'From' => [
                    'Email' => "contact@webnelldev.fr",
                    'Name' => "AliExprass contact"
                    ],
                    'To' => [
                    [
                        'Email' => $user->getEmail(),
                        'Name' => $user->getLastname()
                    ]
                    ],
                    'TemplateID' => 3488899,
                    'TemplateLanguage' => true,
                    'Subject' => $email->getSubject(),
                    'Variables' => [
                        'title' => $email->getTitle(),
                        'content' => $email->getContent()
                    ]
                ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            //$response->success() && dd($response->getData());

    }
}