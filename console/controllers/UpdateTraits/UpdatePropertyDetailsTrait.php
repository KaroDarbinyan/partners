<?php
namespace console\controllers\UpdateTraits;

use common\models\AllPostNumber;
use common\models\PropertyDetails;
use yii\httpclient\Client;

trait UpdatePropertyDetailsTrait{

    /**
     *
     * @param $jsonProp
     * @param $c
     * @param bool $isShort
     *
     * @return PropertyDetails
     */
    public static function getPropertyDetailsModel($jsonProp, $c, $isShort = false){
        $newPropD = PropertyDetails::findOne(['id' => $jsonProp['id']]);
        if (!$newPropD) {
            $newPropD = new PropertyDetails();
            $propDStatus = 'new';
        } else {
            $propDStatus = 'Update';
            if (
                isset($jsonProp['solgt'])
                && $jsonProp['solgt'] == -1
                && $newPropD->solgt === 0
            ) {
                self::$currentlySolgtIds[] = $newPropD->id;
                self::$currentlySolgtMessages[$newPropD->id] = $newPropD->user ? $newPropD->user->short_name : $newPropD->ansatte1_id;
                ;
            }
        }

        // Send statistic
        if (($newPropD->vispaafinn == 0 || $newPropD->vispaafinn == null) && isset($jsonProp['vispaafinn']) && $jsonProp['vispaafinn'] == "-1"){
            //(new static)->deliverMarketingLinks($newPropD->id, $newPropD->oppdragsnummer);
        }

        $attrs = $newPropD->attributes();

        if (!$isShort) {
            echo "Property Details -> {$jsonProp['id']} : N: {$c} -> {$propDStatus}\n";
        }
        $defaultsMap = [// fields that must be saved as default value if they are missing in json
            "vispaafinn" => 0,
            "markedsforingsklart" => 0,
            "utlopsdato" => 0,
            "ansatte2_id" => null,
        ];

        $timeMap = [// Fields that must be converted to seconds from string date
            'endretdato',
            'utlopsdato',
            'oppdragsdato',
            'markedsforingsdato',
            'overtagelse',
            'kontraktsmoteinklklokkeslett',
            // 'akseptdato',
        ];

        $intMap = [// Fields that must be converted to int
            'borettslag_organisasjonsnummer',
        ];
        $checkColumns = [
            'vispaafinn',
            'solgt',
            'markedsforingsklart',
            'markedsforingsdato',
        ];
        $newPropD->sold_date = (isset($jsonProp['akseptdato'])&&$jsonProp['akseptdato']&&!$newPropD->akseptdato) ? time(): $newPropD->sold_date;


        foreach ($attrs as $attrName) {
            $jsonKey = str_replace('__', '-', $attrName);
            if (!array_key_exists($jsonKey,$jsonProp)) {
                if (array_key_exists($jsonKey,$defaultsMap)) {
                    $column = $defaultsMap[$jsonKey];
                } else {
                    continue;
                }
            } else {
                $column = $jsonProp[$jsonKey];
            }

            if (is_array($column)) {// Ignore nested params
                continue;
            }

            if (in_array($attrName, $timeMap)) {// Convert dates to seconds
                $column = strtotime($column);
            }

            if (in_array($attrName, $intMap)) {// remove spaces
                $column = intval($column);
            }

            if (in_array($jsonKey, $checkColumns) && $propDStatus == 'Update') {
                if ($column != $newPropD->getAttribute($attrName) && !$isShort) {
                    self::$changedProperties[$newPropD->oppdragsnummer][$jsonKey] = [
                        'old' => $newPropD->getAttribute($attrName),
                        'new' => $column
                    ];
                }
            }

            $newPropD->setAttribute($attrName, $column);
        }

        // Detect Sity Area from post number
        if (isset($jsonProp['postnummer'])) {
            // TODO: OPTIMIZATION get all post numbers and search in it
            $postNummer = AllPostNumber::findOne(['post_number' => $jsonProp['postnummer']]);
            $newPropD->area = $postNummer ? $postNummer->area : null;
        }

        // Extract street name from adresse
        if (isset($jsonProp['adresse'])) {
            preg_match_all('/ [0-9]/', $jsonProp['adresse'], $m, PREG_OFFSET_CAPTURE);
            $newPropD->street = substr(
                $jsonProp['adresse'],// Full addresee
                0,
                end($m[0])[1]// building number position in addresse
            );
        }

        // if (!$newPropD->lat && !$newPropD->lng) {
        //     $address = urlencode("{$newPropD->adresse} {$newPropD->poststed}");
        //     $baseUrl = preg_replace('/\s+/', '+', sprintf(self::$googleGeocodeUrl, $address));
        //     $client = new Client(['baseUrl' => $baseUrl]);
        //     $response = $client->createRequest()->setFormat(Client::FORMAT_JSON)->send();
        //
        //     $content = json_decode($response->content, true);
        //
        //     if (isset($content['results'][0]['geometry']['location'])) {
        //         $newPropD->lat = strval($content['results'][0]['geometry']['location']['lat']);
        //         $newPropD->lng = strval($content['results'][0]['geometry']['location']['lng']);
        //     }
        // }
        return $newPropD;
    }
}

