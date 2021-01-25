<?php

namespace console\controllers;

use common\components\SesMailer;
use common\components\StaticMethods;
use common\models\DigitalMarketing;
use common\models\PropertyAds;
use common\models\PropertyDetails;
use Matrix\Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\helpers\FileHelper;
use yii\httpclient\Client;


class ParsingController extends Controller
{

    public $log;

    public function options($actionID)
    {
        return ['log'];
    }

    public function optionAliases()
    {
        return [
            'log' => 'log',
        ];
    }


    private $digitalMarketing = [
        'apiUrl' => 'https://europe-west1-involve-a7a2d.cloudfunctions.net/getStats?apiKey={{api_key}}Id={{partner_id}}',
        'apiKey' => 'XuSh55O7HpanuL6T5YaLE3sGUEG0VUlw&organization',
        'partnerIds' => [
            '1' => ['OUjJnFRUjHyQoSfUKpD9'],// Schala Partners
            '2' => [
                "3wY7wdKGmkG4p6HaAyKW",//Aursnes & Partners Ålesund ->
                "v8acaa8jom56KjuiWQoj4M",//Aursnes & Partners Sykkylven - >
            ],
            '4' => ["7MGXiNZYxDQrkYE9bYTUhB"], //Bakke Sørvik & Partners ->
            '5' => ["iSuFK7VQqE3TFbv8Fv3iLQ"], //Grimsøen & Partners ->
            '6' => ["dTkFGQ2f8ExMjaS4Fxu4KE"], //Huus & Partners ->
            '7' => ["sos36QWTzXkaviKzx5VXTS"], //Leinæs & Partners ->
            '8' => ["bg8Vbu9gaQncbmbBd1vrb4"], //Meglerhuset & Partners Arendal ->
            '12' => ["wGPvAQhbz5FU3mfBNTeWcX"],//Partners Eiendomsmegling Gjøvik ->
            '13' => ["7trQWTUfD1y6aydLsqUksN"],//Møller & Partners ->
            '14' => ["dkG9TJJpzmrj8uyzdgz6mS"],//Adamsen Eiendomsmegling ->
            '16' => ["qrwQ6mF3optp4ZbU55yCGi"],//Meglerhuset & Partners Drammen ->
            '17' => ["fynBUtkqgZKo6cNNrnt1tD"],//Meglerhuset & Partners Telemark ->
            '18' => ["3LXBF1aDCQ5XFvejH6fLgB"],//Partners Eiendomsmegling, Indre Østfold ->
            '19' => ["dyYdXYu4rd96mtfKAZbaFb"],//Olden & Partners ->
        ],

    ];

    /**
     *
     */
    public function actionFinnParsing()
    {

        $property_details = PropertyDetails::find()
            ->select(['id', "oppdragsnummer", 'finn_importstatisticsurl'])
            ->andWhere(["not", ["finn_importstatisticsurl" => null]])
            ->andWhere(['solgt' => 0, 'arkivert' => 0, 'vispaafinn' => -1]);

        $clone = clone $property_details;
        $count = $clone->count();

        $success = 0;
        $error = 0;
        foreach ($property_details->batch(50) as $properties) {
            foreach ($properties as $property) {
                $ch = curl_init($property['finn_importstatisticsurl']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, CURLOPT_URL);
                $data = curl_exec($ch);
                $data = simplexml_load_string($data, null, LIBXML_NOCDATA);
                $data = json_decode(json_encode($data), true);
                if (isset($data['OBJECT']) && isset($data['OBJECT']['COUNTER'])) {
                    $propertyAds = isset($property->propertyAds) ? $property->propertyAds : new PropertyAds();

                    $propertyAds->property_id = $property->id;
                    $propertyAds->finn_adid = $data['OBJECT']['ADID'];
                    $propertyAds->finn_viewings = $data['OBJECT']['COUNTER']['NO_OF_VIEWINGS'];
                    $propertyAds->finn_emails = $data['OBJECT']['COUNTER']['NO_OF_EMAILS'];
                    $propertyAds->finn_general_emails =
                        (($data['OBJECT']['COUNTER']['NO_OF_GENERAL_EMAILS']) && ($data['OBJECT']['COUNTER']['NO_OF_GENERAL_EMAILS'] != 'null'))
                            ? $data['OBJECT']['COUNTER']['NO_OF_GENERAL_EMAILS'] : null;

                    if ($propertyAds->save(false)) ++$success;
                    else ++$error;
                } else {
                    ++$success;
                }
                echo "\e[0mUpdate in progress, [\e[32msuccess: {$success} \e[0m| \e[31merror: {$error}\e[0m] of {$count}\r";
            }
        }
        echo "\n\r\nCount:  {$count}\n\e[32mSuccess: {$success}\n\e[31mError: {$error}\n\n\e[0m";
        return true;
    }

    /**
     *  Request and save all partners digital marketings
     *  php yii parsing/digital-marketing-parsing
     */
    public function actionDigitalMarketingParsing()
    {
        foreach ($this->digitalMarketing['partnerIds'] as $partnerId => $depIds) {
            foreach ($depIds as $id) {
                try {
                    $this->requestSaveDigitalMarketingParsing($id);
                } catch (Exception $e) {
                    if (Yii::$app->params['enableEmail']) {
                        $mailer = new SesMailer();
                        $mailer->sendMail(
                            "From Server :" . Yii::$app->params['serverName'] . " \n" .
                            $e->getMessage(),
                            "Digital Marketing Failed with Id = {$id}",
                            ['partners@involve.no'],// TODO: unite notification system in one controller
                            "Cron:parsing:digital-marketing-parsing"
                        );
                    }
                    echo $e->getMessage();
                }
            }
        }
    }

    /**
     * Request Digital Marketing data and save
     * @param $id string hash id
     */
    public function requestSaveDigitalMarketingParsing($id)
    {
        $url = $this->digitalMarketing['apiUrl'];
        $url = str_replace('{{api_key}}', $this->digitalMarketing['apiKey'], $url);
        $url = str_replace('{{partner_id}}', $id, $url);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, CURLOPT_URL);
        $data = curl_exec($ch);
        $data = json_decode($data, true);

        foreach ($data as $item) {
            if (!$digital_marketing = DigitalMarketing::findOne(['key' => $item['id']])) {
                $digital_marketing = new DigitalMarketing();
            }
            $digital_marketing->attributes = $item;
            $digital_marketing->key = $item['id'];
            $digital_marketing->campaign_name = $item['campaignName'];
            $digital_marketing->source_object_id = $item['sourceObjectId'];
            $digital_marketing->live = intval($item['live']);
            $digital_marketing->completed = intval($item['completed']);
            $digital_marketing->creative_a_stats = is_array($item['creativeAStats']) && count($item['creativeAStats']) > 0 ? json_encode($item['creativeAStats']) : null;
            $digital_marketing->creative_b_stats = is_array($item['creativeBStats']) && count($item['creativeBStats']) > 0 ? json_encode($item['creativeBStats']) : null;
            $digital_marketing->stats = is_array($item['stats']) && count($item['stats']) > 0 ? json_encode($item['stats']) : null;
            $digital_marketing->save();
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     * @throws InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionPropertyGeocodeParsing()
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?key=%s&address=%s';
        $key = 'AIzaSyDyziDv02leqwiVKBD9oEH4p1vwh0EoqOU';

        $count = PropertyDetails::find()->where(['lat' => null, 'lng' => null])->count();

        $property = PropertyDetails::find()
            ->select(['id', 'oppdragsnummer', 'adresse', 'postnummer', 'poststed', 'lat', 'lng'])
            ->where(['lat' => null, 'lng' => null]);

        $success = 0;
        $error = 0;
        $logs = [];
        foreach ($property->batch(50) as $property_details) {
            foreach ($property_details as $property_detail) {
                /** @var PropertyDetails $property_detail */
                $post_number = sprintf('%04d', $property_detail->postnummer);

                $address = urlencode(preg_replace('/\s+/', ' ', "{$property_detail->adresse} Norway"));

                $client = new Client(['baseUrl' => sprintf($url, $key, urlencode("{$property_detail->adresse} Norway"))]);
                $response = $client->createRequest()->setFormat(Client::FORMAT_JSON)->send();

                $content = json_decode($response->content, true);
                if (!isset($content['results'][0]['geometry']['location'])) {
                    $client = new Client(['baseUrl' => sprintf($url, $key, urlencode("{$property_detail->adresse}"))]);
                    $response = $client->createRequest()->setFormat(Client::FORMAT_JSON)->send();
                    $content = json_decode($response->content, true);
                }

                if (isset($content['results'][0]['geometry']['location'])) {
                    $property_detail->lat = strval($content['results'][0]['geometry']['location']['lat']);
                    $property_detail->lng = strval($content['results'][0]['geometry']['location']['lng']);
                } else {
                    $property_detail->lat = 1000;
                    $property_detail->lng = 1000;
//                    $logs[] = [
//                        "property" => [
//                            "id" => $property_detail->id,
//                            "oppdragsnummer" => $property_detail->oppdragsnummer,
//                            "adresse" => $property_detail->adresse,
//                            "poststed" => $property_detail->poststed,
//                        ],
//                        "request_url" => $basUrl,
//                        "response" => $content,
//                    ];
                }

                if ($property_detail->save(false)) ++$success;
                else ++$error;

                echo "\e[0mUpdate in progress, [\e[32msuccess: {$success} \e[0m| \e[31merror: {$error}\e[0m] of {$count}\r";

            }
        }
        echo "\n\r\nCount:  {$count}\n\e[32mSuccess: {$success}\n\e[31mError: {$error}\n\n\e[0m";
        //$this->addGeocodeLog(json_encode($logs, JSON_PRETTY_PRINT), $success, $error);
        return true;
    }


    /**
     * @param $logs
     * @param $success
     * @param $error
     * @throws \yii\base\Exception
     */
    private function addGeocodeLog($logs, $success, $error)
    {
        $dirs = [
            "runtime", "logs"
        ];

        $directory = Yii::$app->basePath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $dirs);
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
        $file = $directory . DIRECTORY_SEPARATOR . 'geocode.log';
        $implode = implode("", array_fill(0, 100, "-"));

        if ($this->log) {
            echo date('d.m.y H:i', time()) . "\nCount:  " . ($success + $error) . "\n\e[32mSuccess: {$success}\n\e[31mError: {$error}\n\nerror data: {$logs}\n";
        } else {
            $fOpen = fopen($file, 'a');
            fwrite($fOpen, date('d.m.y H:i', time()) . "\nCount:  " . ($success + $error) . "\nSuccess: {$success}\nError: {$error}\n\nerror data: {$logs}\n\n{$implode}\n\n\n\n");
            fclose($fOpen);
        }

    }


}