<?php

namespace common\components;

use Aws\Ses\SesClient;
use Yii;
use yii\base\Component;
use Aws\Exception\AwsException;
use Aws\Credentials\Credentials;

class SesMailer extends Component
{
    private $client;
    private $credentials;

    private $fails = false;

    public function __construct()
    {
        $this->credentials = new Credentials(
            'AKIAJN2PEJNIZHIPUP2A',
            'PjJccawQChGEDrmIOwCxzvWWzWo77aDVwNUXu1QY'
        );

        $this->client = new SesClient([
            'region' => 'eu-west-1',
            'version' => '2010-12-01',
            'credentials' => $this->credentials
        ]);
    }

    public function sendMail($body, $subject, array $recipients, $sender = null, $plaintextBody = null)
    {
        $charset = 'UTF-8';
        // ATTANTION: this row is for blocking emails from dev or other local servers. Do NOT comment it. to manage data go to common/config/params-local.php
        $recipients = isset(Yii::$app->params['defaultEmail']) ? [Yii::$app->params['defaultEmail']] : $recipients;
        try {
            $result = $this->client->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipients,
                ],
                'ReplyToAddresses' => [$sender ? $sender : 'Partners.no <post@partners.no>'],
                'Source' => $sender ? $sender : 'Partners.no <post@partners.no>',
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => $charset,
                            'Data' => $body,
                        ],
                        'Text' => [
                            'Charset' => $charset,
                            'Data' => $plaintextBody ?? strip_tags($body),
                        ],
                    ],
                    'Subject' => [
                        'Charset' => $charset,
                        'Data' => "Partners.no : $subject",
                    ]
                ]
            ]);

            return $result;
        } catch (AwsException $e) {
            $this->fails = true;

            return ['error' => $e->getAwsErrorMessage()];
        }
    }

    public function fails()
    {
        return $this->fails;
    }
}