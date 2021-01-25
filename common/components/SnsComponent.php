<?php
namespace common\components;

use Yii;
use yii\base\Component;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;
use Aws\Credentials\Credentials;

class SnsComponent extends Component
{
    private $credentials;
    private $SnsClient;
    private $senderId;
    private $topic;

    public function __construct()
    {
        //TODO: uncomment for .env
        /*$this->senderId = getenv('SMS_SENDER_ID');
        $this->topic = getenv('SNS_TOPIC');
        

        $this->credentials = new Credentials(
            getenv('AWS_ACCESS_KEY_ID'),
            getenv('AWS_SECRET_ACCESS_KEY')
        );*/

        $this->senderId = 'PARTNERS';
        $this->topic = 'arn:aws:sns:eu-west-1:355010040302:TestTopic';
        $this->credentials = new Credentials(
            'AKIAJN2PEJNIZHIPUP2A',
            'PjJccawQChGEDrmIOwCxzvWWzWo77aDVwNUXu1QY'
        );
        $this->SnsClient = new SnsClient([
            'region' => 'eu-west-1',
            'version' => '2010-03-31',
            'credentials' => $this->credentials
        ]);
    }

    /**
     * @param string $senderId
     */
    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function publishSms($message, $phoneNumber, $type = 'Transactional')
    {
        $payload = ['text' => 'null'];
        $date = date('F j, Y, g:i a');
        $payload['text'] = "M:{$message}\nN:{$phoneNumber}\nT:{$type}\nd:{$date}\n";

        // Blocking sms sending to real persons from dev-local-staging servers
            $payload['text'] = $payload['text'] . (isset(Yii::$app->params['defaultPhone']) ? ("INTERSEPTED " . Yii::$app->params['baseUrl']) :'') . "\n";
            $payload['text'] = $payload['text'] . "-------------\n";
            // ATTANTIONE: this row is to send sms to default user from dev or other local servers. Do NOT comment it. to manage data go to common/config/params-local.php
            $phoneNumber = isset(Yii::$app->params['defaultPhone']) ? Yii::$app->params['defaultPhone'] : $phoneNumber;

        try {
            file_put_contents(
                Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . 'sms_log.log',
                $payload['text'],
                FILE_APPEND
            );
        } catch (\Exception $e) {}
        // ATTANTIONE: this row is for blocking sms from dev or other local servers. Do NOT comment it. to manage data go to common/config/params-local.php
        if(!!Yii::$app->params['enableSms']){
            try {
                $result = $this->SnsClient->publish([
                    'Message' => $message,
                    'PhoneNumber' => $phoneNumber,
                    'MessageAttributes' => $this->getMessageAttributes()
                ]);
            } catch (\Exception $e) {
                // output error message if fails
                file_put_contents(
                    Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  . 'sms_error_log.log',
                    $e->getMessage(),
                    FILE_APPEND
                );
                $payload['text'] = 'Error: '.$e->getMessage();
            }


        }

        if(!Yii::$app->params['slackReport']){
            return;
        }
        $ch = curl_init('https://hooks.slack.com/services/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');
        $payload = json_encode($payload);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        // curl -X POST -H 'Content-type: application/json' --data '{"text":"Hello, World!"}' https://hooks.slack.com/services/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
    }

    /**
     * @param $message
     * @param string $type
     */
    public function publishTopic($message, $type = 'Transactional')
    {
        try {
            $result = $this->SnsClient->publish([
                'Message' => $message,
                'TopicArn' => $this->topic,
                'MessageAttributes' => $this->getMessageAttributes()
            ]);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    public function subscribeSmsTopic($phoneNumber)
    {
        try {
            $result = $this->SnsClient->subscribe([
                'Protocol' => 'sms',
                'Endpoint' => $phoneNumber,
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $this->topic,
            ]);
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    public function listSubscriptions()
    {
        try {
            $result = $this->SnsClient->listSubscriptionsByTopic([
                'TopicArn' => $this->topic
            ]);
            return $result;
        } catch (AwsException $e) {
            // output error message if fails
            error_log($e->getMessage());
        }
    }

    public function unsubscribeTopic($phoneNumber)
    {
        $subscriptions = $this->listSubscriptions()->get('Subscriptions');

        $toUnsubscribe = array_filter($subscriptions, function ($sub) use ($phoneNumber) {
            return $sub['Endpoint'] == $phoneNumber;
        });

        foreach ($toUnsubscribe as $key => $subscription) {
            try {
                $result = $this->SnsClient->unsubscribe([
                    'SubscriptionArn' => $subscription['SubscriptionArn'],
                ]);
            } catch (AwsException $e) {
                // output error message if fails
                error_log($e->getMessage());
            }
        }
    }

    public function getMessageAttributes($senderId = false, $type = 'Transactional')
    {
        $messageAttributes = [
            'AWS.SNS.SMS.SenderID' => [
                'DataType' => 'String',
                'StringValue' => $senderId === false ? $this->senderId : $senderId
            ],
            'AWS.SNS.SMS.SMSType' => [
                'DataType' => 'String',
                'StringValue' => $type
            ]
        ];
        return $messageAttributes;
    }

    public $smsText = [
        'budvarsel' => [
        ],
        'verdivurdering' => [
            'client' => "Takk for henvendelse i forbindelse med verdivurdering. Vi kontakter deg så fort som mulig.\nMvh {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden har bedt om verdivurdering #{{lead_id}}. \n{{link}}"
        ],
        'skal_selge' => [
            'client' => "Takk for henvendelse i forbindelse med verdivurdering. Vi kontakter deg så fort som mulig.\nMvh {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden skal selge eiendom #{{lead_id}}.\n{{link}}"
        ],
        'pristilbud' => [
            'client' => "Takk for henvendelse i forbindelse med pristilbud. Vi kontakter deg så fort som mulig.\nMvh {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden har bedt om pristilbud #{{lead_id}}.\n{{link}}"
        ],
        'visningliste' => [
            'client' => "Du er registrert på visningslisten på {{address}}.\nSalgsoppgave: {{pdf}}.\nMvh {{broker}}, {{department}}.",
        ],
        'salgssum' => [
            //'client' => "Du har bedt om salgspris på {{address}}. Vi kontakter deg med detaljer om salgssum.\nMvh {{broker}}, {{department}}.",
        ],
        'salgssum_landing' => [
            //'client' => "Du har bedt om salgspris på {{address}}. Vi kontakter deg så fort som mulig.\nMvh {{broker}}, {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden har bedt om salgssum #{{lead_id}}.\n{{link}}"
        ],
        'kontakt' => [
            'client' => "Vi kontakter deg så fort som mulig.\nMvh PARTNERS EIENDOMSMEGLING.",
            'broker' => "Hei {{broker}}.\nKunden ønsker kontakt #{{lead_id}}.\n{{link}}"
        ],
        'meglerbooking' => [
            'client' => "Vi kontakter deg så fort som mulig.\nMvh PARTNERS EIENDOMSMEGLING.",
            'broker' => "Hei {{broker}}.\nKunden ønsker meglerbooking #{{lead_id}}.\n{{link}}"
        ],
        'kontakt_broker' => [
            'client' => "Vi kontakter deg så fort som mulig.\nMvh {{broker}}, {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden ønsker kontakt direkte med deg #{{lead_id}}.\n{{link}}"
        ],
        'book_visning' => [
            //'client' => "Du har bedt om visning på {{address}}. Vi kontakter deg så fort som mulig.\nMvh {{broker}}, {{partner}}",
            'broker' => "Hei {{broker}}. En interessent har meldt seg på visning på {{address}}. Ta kontakt direkte med kunden for å avtale nærmere.\n{{link}}"
        ],
        'e_takst' => [
            'client' => "Takk for henvendelse i forbindelse med Е-takst. Vi kontakter deg så fort som mulig.\nMvh {{department}}.",
            'broker' => "Hei {{broker}}.\nKunden har bedt om Е-takst #{{lead_id}}. \n{{link}}"
        ],
        'salgsoppgave' => [
            'client' => "Salgsoppgaven på {{address}} er sendt til din epostadresse.\n{{pdf}}\nMvh {{broker}}, {{department}}.",
            //'client' => "Du har bedt om salgsoppgave på {{address}}.\n{{pdf}}\nMvh {{broker}}, {{department}}.",
            //'client' => "Salgsoppgaven er sendt til din epostadresse",
        ]
    ];

   
}
