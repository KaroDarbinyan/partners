<?php
namespace console\controllers\UpdateTraits;

use common\models\Forms;
use common\models\Partner;
use SimpleXMLElement;
use Yii;
use yii\console\Exception;
use yii\db\Expression;

trait GetFromApiTraits
{
    private $oAuth2 = array(
        '233'=>[
            'url' => "https://api.webmegler.no/oauth/connect/token",
            'clientId' => "involve.233.website",
            'secret' => "6c20378fdfb74dd786a51074",
            "grant_type" => "client_credentials",
            'token' => false,
            'tokenFileName' => 'oAuth2Token233.txt',
        ],
        '343'=>[
            'url' => "https://api.webmegler.no/oauth/connect/token",
            'clientId' => "involve.343.webpage",
            'secret' => "14d264d224ec4a63a520ccc8",
            "grant_type" => "client_credentials",
            'token' => false,
            'tokenFileName' => 'oAuth2Token343.txt',
        ],
    );

    private $statusMessages = array(
        401 => '401 Authorization Required',
    );
    private $tokenGetAttempts = 0;
    private $requests = array(
        'accounting' => array(
            'url' => 'https://api.webmegler.no/legacy/xml/wnregnskapxml.exe?/k{{companyWebId}}&id_firma={{id_firma}}&kommando=bilag_endretdato&fradato={{start}}&tildato={{end}}&rapporttype=fakturaflatfil',
            'name' => 'contacts',
        ),
        'soap' => array(
            'url' => 'https://api.webmegler.no/legacy/soap/webmegler/webmegler.asmx',
            'name' => 'soap'
        ),
        'contacts' => array(
            'url' => 'https://api.webmegler.no/rest/v6/k{{companyWebId}}/Contacts',
            'name' => 'contacts',
        ),
        'contact' => array(
            'url' => 'https://api.webmegler.no/rest/v6/k{{companyWebId}}/Contacts/{{contact_id}}',
            'name' => 'contact',
        ),
        'department' => array(
            'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aavdelinger',
            'name' => 'avdelinger',
        ),
        'employees' => array(
            'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aansatte/i{{department_id}}',
            'name' => 'ansatte',
        ),
        'employee_properties' => array(
            'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aansattoppdrag/i{{employee_id}}',
            'name' => 'ansattes_eiendommer',
        ),
        'properties' => array(
            'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aeiendommer{{params}}/m{{minutes}}',
            'name' => 'eiendommer',
        ),
        'property' => array(//TODO:: check property request
            'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aeneiendom/{{order_id_web_id}}{{params}}',
            'name' => 'eiendom',
        ),
    );
    public $companyWebId = '233';
    // public $companyWebId = '343';

    /**
     * @param SimpleXMLElement $obj
     * @return array
     */
    public static function xmlObjToAssocArray(SimpleXMLElement $obj)
    {
        $feltStandartAttrs = [
            'navn',
            'format',
            'maxlen',
        ];
        $temp = [];
        //parse Attributes
        //Do the main job of recursion
        foreach ($obj->attributes() as $key => $val) {
            $temp[$key] = $val->__toString();
        }

        //Parse Items
        foreach ($obj as $key => $item) {
            if ($key == 'felt') {
                //Parse field(felt)
                //Do the main job of recursion
                $attrs = $item->attributes();
                $temp[ $attrs['navn']->__toString() ] = $item->__toString();
                if ('type_dokumentkategorier' == $attrs['navn']) {// TODO: fix hardcoded
                    $temp[ 'typeid' ] = $attrs['typeid']->__toString();
                }
            } else {
                $temp[$key] = isset($temp[$key]) ? $temp[$key] : [];
                // NOTE: Call to recursion
                $temp[$key][] = self::xmlObjToAssocArray($item);
            }
        }

        return $temp;
    }

    /**
     * Update the auth token from oAuth2 service
     * @throws Exception
     */
    private function updateAuthToken()
    {
        $this->tokenGetAttempts++;

        // Get token if there it's missing
        $auth = $this->oAuth2[$this->companyWebId];
        $auth['token'] =
            json_decode($this->request(array(
                'url'    => $auth['url'],
                'isPost' => 1,
                'args' => array(
                    "grant_type"    => $auth['grant_type'],
                    "client_id"     => $auth['clientId'],
                    "client_secret" => $auth['secret'],
                ),
            ), true), true)
        ;

        if (isset($auth['token']['access_token'])) {
            $auth['token'] = $auth['token']['access_token'];
        } else {
            throw new Exception('Missing Token in' . $auth['token']);
        };

        file_put_contents(
            Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  .
            $auth['tokenFileName'],
            $auth['token']
        );
        $this->oAuth2[$this->companyWebId] = $auth;
        return $auth['token'];
    }

    /**
     * get data for $requestName
     * @param string $requestName
     * @param array $params
     * @param bool $save
     * @param bool|string $fileName
     * @return array|bool
     * @throws Exception
     */
    public function get($requestName = '', $params = [], $save = true, $fileName = false)
    {
        $this->tokenGetAttempts = 0;
        $auth = $this->oAuth2[$this->companyWebId];
        
        if (!isset($auth['token']) || !$auth['token']) {
            $token = file_exists($auth['tokenFileName']) ?
                file_get_contents($auth['tokenFileName']):
                false
            ;
            $auth['token'] = $token ? $token : $this->updateAuthToken();
            $this->oAuth2[$this->companyWebId]['token'] = $auth['token'];
        }
        
        // Adapt request name to function name syntax
        $actionName =
            str_replace(
                ' ',
                '',
                ucwords(strtolower(
                    str_replace('_', ' ', $requestName)
                ))
            )
        ;

        while (!is_array($resp = $this->{"get{$actionName}"}($params))) { // Call method by name

            $this->updateAuthToken();
            //TODO: find better solution to handle auth rejections
            if (3 < $this->tokenGetAttempts) {
                file_put_contents(
                    'token_requests_fail_logs.txt',
                    date('l jS \of F Y h:i:s A') . "failed to request token several times \n",
                    FILE_APPEND
                );
                echo "<pre>";
                var_dump(date('l jS \of F Y h:i:s A') . "failed to request token several times \n");
                echo "</pre>";
                return false;
                break;
            }
        }// End While

        if ($save) { //Save data if required
            $fileName = $fileName ? $fileName : "{$requestName}_{$this->requests[$requestName]['name']}";
            $fileName = "{$fileName}.json";
            file_put_contents(
                "{$fileName}",
                json_encode($resp)
            );
        }

        return $resp;
    }

    /**
     * Get and save or update Departments
     * @return array|bool|SimpleXMLElement|string
     */
    private function getDepartment()
    {
        $resp = $this->request(array(
            'url' => $this->requests['department']['url'],
        ));

        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // TODO: Find 100% solution
            // Response unauthorized
            return false;
        }

        $resp = simplexml_load_string($resp);
        $resp = self::xmlObjToAssocArray($resp);
        return $resp;
    }

    /**
     * Get and save or update All Contacts
     * includes multiple querys for each contact
     * @throws Exception
     */
    private function getContacts()
    {
        $contactIds = $this->request(array(
            'url' => $this->requests['contacts']['url'],
        ));

        if (strpos($contactIds, $this->statusMessages[401]) == 21) {
            // Response unauthorized
            return false;
        }

        $contact = array();
        $contacts = json_decode($contactIds);
        $resp = array();
        $limit = 0;
        foreach ($contacts as $id) {
            if (4 < $limit) {
                break;
            }
            $limit++;
            $resp[ $id ] = $this->get('contact', [ $id ], false);
        }
        return $resp;
    }

    /**
     * Get and update Contact by id
     * @param array $params must contain 1 value <id of contact>
     * @return bool|mixed|string
     */
    private function getContact($params)
    {
        $resp = $this->request(array(
            'url' => str_replace('{{contact_id}}', $params[0], $this->requests['contact']['url']),
        ));
        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // Response unauthorized
            return false;
        }

        $resp = json_decode($resp, true);
        return $resp;
    }

    /**
     * Get and update Employees by department id
     * @param array $params must contain 1 value <id of department>
     * @return bool|mixed|string
     */
    private function getEmployees($params)
    {
        $resp = $this->request(array(
            'url' => str_replace(
                '{{department_id}}',
                $params[0],
                $this->requests['employees']['url']
            ),
        ));
        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // Response unauthorized
            return false;
        }

        $resp = simplexml_load_string($resp);
        $resp = self::xmlObjToAssocArray($resp);
        return $resp;
    }

    /**
     * Get and update Employees Properties by employee id
     * @param array $params must contain 1 value <id of employee>
     * @return bool|mixed|string
     */
    private function getEmployeeProperties($params)
    {
        $resp = $this->request(array(
            'url' => str_replace(
                '{{employee_id}}',
                $params[0],
                $this->requests['employee_properties']['url']
            ),
        ));
        if (strpos($resp, $this->statusMessages[401]) == 21) {
            //TODO: change to status code checking
            // Response unauthorized
            return false;
        }

        $resp = simplexml_load_string($resp);
        $resp = self::xmlObjToAssocArray($resp);
        return $resp;
    }

    /**
     * Get and update Properties by time in minutes
     * @param array $params must contain 1 value <minutes>
     * @return bool|mixed|string
     */
    private function getProperties($params)
    {
        $m = $params[0] !== -1 ? "/m{$params[0]}" : "";

        $requestParams = array(
            'url' => str_replace(
                '/m{{minutes}}',
                $m,// Minutes
                $this->requests['properties']['url']
            ),
        );

        if (isset($params[1])) {
            $requestParams['url'] = str_replace(
                '{{params}}',
                $params[1],//additional Params
                $requestParams['url']
            );
        }
        $resp = $this->request($requestParams);

        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // Response unauthorized
            return false;
        }

        $resp = simplexml_load_string($resp);
        $resp = self::xmlObjToAssocArray($resp);

        return $resp;
    }

    /**
     * Get and update Properties by time in minutes
     * @param array $params must contain 1 value <minutes>
     * @return bool|mixed|string
     */
    private function getProperty($params)
    {

        $requestParams = [
            'url' => str_replace(
                '{{order_id_web_id}}',
                $params[0],
                $this->requests['property']['url']
            ),
        ];
        if (isset($params[1])) {
            $requestParams['url'] = str_replace(
                '{{params}}',
                $params[1],//additional Params
                $requestParams['url']
            );
        }

        $resp = $this->request($requestParams);

        // TODO: use curl status instead
        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // Response unauthorized
            return false;
        }
        $resp = simplexml_load_string($resp, "SimpleXMLElement", LIBXML_NOERROR);
        return $resp ? self::xmlObjToAssocArray($resp) : [];
    }

    /**
     * @param $args [curl_setopt function values]
     * @param bool $isAuth
     * @return bool|string [answer of request]
     */
    private function request($args, $isAuth = false)
    {
        if (isset($args['args']) && is_array($args['args'])) {
            $args['args'] = http_build_query($args['args']);
        }

        //Setup company id from webmegler
        if (isset($args['url'])) {
            $args['url'] = str_replace(
                '{{companyWebId}}',
                $this->companyWebId,
                $args['url']
            );
        }

        $params = array(
            'url'       => array( CURLOPT_URL ),
            'isPost'    => array( CURLOPT_POST ),
            'args'      => array( CURLOPT_POSTFIELDS ),
            'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
            'headers'   => array(
                CURLOPT_HTTPHEADER,
                array('Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'])
            ),
        );

        // remove header token if requesting that token
        if ($isAuth) {
            unset($params['headers'][1]);
        }

        $ch = curl_init();
        foreach ($params as $key => $param) {
            if (isset($args[$key]) && $key == 'headers') {
                $param[1] = array_merge($param[1], $args[$key]);
            } elseif (isset($args[$key])) {
                $param[1] = $args[$key];
            }

            if (isset($param[1])) {
                curl_setopt($ch, $param[0], $param[1]);
            }
        }
        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     * Get and save or update Accounting
     * @param $params
     * @return array|bool|SimpleXMLElement|string
     */
    private function getAccounting($params)
    {
        $requestParams = isset($params['params']) ? $params['params'] : [];

        // Set Start date in request url
        $requestParams['url'] = str_replace(
            '{{start}}',
            $params['date'][0],
            $this->requests['accounting']['url']
        );

        // Set End date in request url
        $requestParams['url'] = str_replace(
            '{{end}}',
            $params['date'][1],
            $requestParams['url']
        );

        // Set Firma id in request url
        $requestParams['url'] = str_replace(
            '{{id_firma}}',
            $params['firmaId'],
            $requestParams['url']
        );

        $resp = $this->__request($requestParams);
        if (strpos($resp, $this->statusMessages[401]) == 21) {
            // TODO: Find 100% solution
            // Response unauthorized
            return false;
        }

        $resp = simplexml_load_string($resp);
        file_put_contents("webmegler-data/test/test-{$params['firmaId']}.json", json_encode($resp));
        
        return $resp;
    }

    /**
     * @param $args [curl_setopt function values]
     * @param bool $isAuth
     * @return bool|string [answer of request]
     */
    private function __request($args, $isAuth = false)
    {
        if (isset($args['args']) && is_array($args['args'])) {
            $args['args'] = http_build_query($args['args']);
        }

        //Setup company id from webmegler
        if (isset($args['url'])) {
            $args['url'] = str_replace(
                '{{companyWebId}}',
                $this->companyWebId,
                $args['url']
            );
        }

        $params = array(
            'url'       => array( CURLOPT_URL ),
            'isPost'    => array( CURLOPT_POST ),
            'file'      => array( CURLOPT_FILE ),
            'isFile'    => array( CURLOPT_FOLLOWLOCATION ),
            'timeout'   => array( CURLOPT_TIMEOUT ),
            'args'      => array( CURLOPT_POSTFIELDS ),
            'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
            'headers'   => array(
                CURLOPT_HTTPHEADER,
                array('Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'])
            ),
        );

        // remove header token if requesting that token
        if ($isAuth) {
            unset($params['headers'][1]);
        }

        // remove header token if requesting that token
        if ($isAuth) {
            unset($params['headers'][1]);
        }

        $ch = curl_init();
        foreach ($params as $key => $param) {
            if (isset($args[$key])) {
                $param[1] = $args[$key];
            }

            if (isset($param[1])) {
                curl_setopt($ch, $param[0], $param[1]);
            }
        }

        $return = curl_exec($ch);
        curl_close($ch);
        return $return;
    }

    /**
     *
     * @param $params
     * @throws Exception
     * @throws \yii\console\Exception
     */
    public function registerInteressent($params)
    {
        if(!isset($params['target_id'])) {
            return; // Break function if no attached property
        }

        $typeCommentMap = [
            'book_visning' => 'Visningspåmelding',
            'salgsoppgave' => 'Salgsoppgave',
            'visningliste' => 'Visningliste',
        ];

        $partner = Partner::find()->select([
            'wapi_id',
        ])->joinWith(['properties'])
            ->where(['property_details.id'=>$params['target_id']])
            ->one()
        ;
        /** @var Partner $partner */
        if (!$partner) {
            return;// Break function if no attached partner
        }

        $wid = $this->companyWebId;
        $this->companyWebId = $partner->wapi_id;
        $this->updateAuthToken();

        $consents = [
            'subscribe_email' => '2901341',
            'subscribe_to_related_properties' => '2901340',
            'contact_me' => '2901342',
            'send_sms' => '2901339',
        ];
        $acceptedConsents = [];
        $visning = '';

        if (strtolower($params['type']) == strtolower(Forms::SCENARIO_VISNINGLISTE)) {
            $visning = '<ser:DeltattPaaVisning>'.date('Y-m-d').'</ser:DeltattPaaVisning>';
        }

        foreach ($consents as $key => $consent) {
            if (array_key_exists($key, $params) && $params[$key] == 1) {
                $acceptedConsents[] = '<ser:string>'.$consent.'</ser:string>';
            }
        }

        // NOTE: Add send_sms Param form forms with type BUDVARSEL, because they are always agree for sms
        if (strtolower($params['type']) == strtolower(Forms::SCENARIO_BUDVARSEL)) {
            $acceptedConsents[] = '<ser:string>'.$consents['send_sms'].'</ser:string>';
        }
        $names = preg_split('/[\s]+/', $params['name'], 2);

        if (count($names) < 2) {
            $names[] = 'IngenEtternavn';
        }

        // TODO : prettyfy following message
        $soap = '
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://webmegler.no/external/services/">
                <soapenv:Body>
                    <ser:RegistrerInteressent5>
                        <ser:relasjon>
                            <ser:Konsernid>' . $partner->wapi_id . '</ser:Konsernid>
                            <ser:Id_oppdrag>' . $params['target_id'] . '</ser:Id_oppdrag>
                        </ser:relasjon>
                        <ser:interessent>
                            <ser:Fornavn>' . ligatures($names[0]) . '</ser:Fornavn>
                            <ser:Etternavn>' . ligatures($names[1]) . '</ser:Etternavn>
                            <ser:Postnummer>' . $params['post_number'] . '</ser:Postnummer>
                            <ser:Email>' . $params['email'] . '</ser:Email>
                            <ser:Telefonnummer>' . $params['phone'] . '</ser:Telefonnummer>
                            ' . $visning . '
                            <ser:Samtykker>
                                ' . implode('', array_unique($acceptedConsents)) . '
                            </ser:Samtykker>
                        </ser:interessent>
                        <ser:registrertfra>partners.no</ser:registrertfra>
                        <ser:automailmottakere>4</ser:automailmottakere>
                        <ser:kommentar>' . (isset($typeCommentMap[$params['type']]) ? ligatures($typeCommentMap[$params['type']]) : $params['type']) . '</ser:kommentar>
                    </ser:RegistrerInteressent5>
                </soapenv:Body>
            </soapenv:Envelope>
        ';
        $res = $this->request([
            'url' => $this->requests['soap']['url'],
            'isPost' => 1,
            'args' => $soap,
            'headers'=>['Content-Type: text/xml']
        ], false);

        $msg = "Tlf: ".$params['phone']."\nOppdrag: ".$params['target_id']."\nResultat: ";

        if ($res) {
            $msg .= $res;

            try {
                $xml = simplexml_load_string((string) $res);
                $response = $xml->children('soap', true)->Body->children()->children()->children();

                $lead = Forms::findOne($params['id']);

                if ($lead) {
                    $lead->updateAttributes([
                        'pushed_to_webmegler' => (string) $response->Suksess === 'true',
                        'push_error' => (string) $response->Melding,
                    ]);

                    $lead->updateCounters(['push_attempts' => 1]);
                }
            } catch (\Exception $exception) {
                // Maybe write log
            }
        } else {
            $msg .= 'Kunne ikke koble til Webmegler!';
        }

        $ch = curl_init('https://hooks.slack.com/services/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');
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['text' => $msg,]),
            CURLOPT_HTTPHEADER => ['Content-type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 5,
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->companyWebId = $wid;
    }

}
