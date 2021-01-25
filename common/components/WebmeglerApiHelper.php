<?php

namespace common\components;

use console\controllers\UpdateTraits\CoreActions;
use yii\base\Component;

class WebmeglerApiHelper extends Component
{
    use CoreActions;

    // private $oAuth2 = array(
    //     '233'=>[
    //         'url' => "https://api.webmegler.no/oauth/connect/token",
    //         'clientId' => "involve.233.website",
    //         'secret' => "6c20378fdfb74dd786a51074",
    //         "grant_type" => "client_credentials",
    //         'token' => false,
    //         'tokenFileName' => 'oAuth2Token233.txt',
    //     ],
    //     '343'=>[
    //         'url' => "https://api.webmegler.no/oauth/connect/token",
    //         'clientId' => "involve.343.webpage",
    //         'secret' => "14d264d224ec4a63a520ccc8",
    //         "grant_type" => "client_credentials",
    //         'token' => false,
    //         'tokenFileName' => 'oAuth2Token343.txt',
    //     ],
    // );
    // private $statusMessages = array(
    //     401 => '401 Authorization Required',
    // );
    // private $tokenGetAttempts = 0;
    // private $requests = array(
    //     'contacts' => array(
    //         'url' => 'https://api.webmegler.no/rest/v6/k{{companyWebId}}/Contacts',
    //         'name' => 'contacts',
    //     ),
    //     'contact' => array(
    //         'url' => 'https://api.webmegler.no/rest/v6/k{{companyWebId}}/Contacts/{{contact_id}}',
    //         'name' => 'contact',
    //     ),
    //     'department' => array(
    //         'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aavdelinger',
    //         'name' => 'avdelinger',
    //     ),
    //     'employees' => array(
    //         'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aansatte/i{{department_id}}',
    //         'name' => 'ansatte',
    //     ),
    //     'employee_properties' => array(
    //         'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aansattoppdrag/i{{employee_id}}',
    //         'name' => 'ansattes_eiendommer',
    //     ),
    //     'properties' => array(
    //         'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aeiendommer{{params}}/m{{minutes}}',
    //         'name' => 'eiendommer',
    //     ),
    //     'property' => array(
    //         'url' => 'https://api.webmegler.no/legacy/xml/wnsokemotorxml.exe?/k{{companyWebId}}/aeneiendom/o{{order_id}}&visalleendringer=-1&visbefaringsoppdrag=-1&visarkiverteoppdrag=-1&visomsetningsdata=-1&visallefritekster=-1&visprovisjonskontoer=3000,3030&vistommeelementer=-1',
    //         'name' => 'eiendom',
    //     ),
    //     'soap' => array(
    //         'url' => 'https://api.webmegler.no/legacy/soap/webmegler/webmegler.asmx',
    //         'name' => 'soap'
    //     ),
    // );
    // public $companyWebId = '233';
    //
    // /**
    //  * WebmeglerApiHelper constructor.
    //  * @param array $config
    //  * @throws Exception
    //  */
    // public function __construct($config = [])
    // {
    //     parent::__construct($config);
    //     if (property_exists(Yii::$app, 'session')) {
    //         $session = Yii::$app->session;
    //
    //         // check if a session is already open
    //         if (!$session->isActive) {
    //             // open a session
    //             $session->open();
    //         }
    //         if (!$session['oAuth2Token']) {
    //             $this->updateAuthToken();
    //         }
    //     } else {
    //         // Get token with another way
    //     }
    //
    // }
    //
    //
    // /**
    //  * @param SimpleXMLElement $obj
    //  * @return array
    //  */
    // public static function xmlObjToAssocArray(SimpleXMLElement $obj)
    // {
    //     $temp = [];
    //     //parse Attributes
    //     //Do the main job of recursion
    //     foreach ($obj->attributes() as $key => $val) {
    //         $temp[$key] = $val->__toString();
    //     }
    //
    //     //Parse Items
    //     foreach ($obj as $k => $item) {
    //         if ($k == 'felt') {
    //             //Parse field(felt)
    //             //Do the main job of recursion
    //             $temp[ $item->attributes()['navn']->__toString() ] = $item->__toString();
    //         } else {
    //             $temp[$k] = isset($temp[$k]) ? $temp[$k] : [];
    //             // NOTE: Call to recursion
    //             $temp[$k][] = self::xmlObjToAssocArray($item);
    //         }
    //     }
    //
    //     return $temp;
    // }
    //
    // /**
    //  * Update the auth token from oAuth2 service
    //  * @throws Exception
    //  */
    // private function updateAuthToken()
    // {
    //     $this->tokenGetAttempts++;
    //
    //     // Get token if there it's missing
    //     $auth = $this->oAuth2[$this->companyWebId];
    //     $auth['token'] =
    //         json_decode($this->request(array(
    //             'url'    => $auth['url'],
    //             'isPost' => 1,
    //             'args' => array(
    //                 "grant_type"    => $auth['grant_type'],
    //                 "client_id"     => $auth['clientId'],
    //                 "client_secret" => $auth['secret'],
    //             ),
    //         ), true), true)
    //     ;
    //
    //     if (isset($auth['token']['access_token'])) {
    //         $auth['token'] = $auth['token']['access_token'];
    //     } else {
    //         throw new Exception('Missing Token in' . $auth['token']);
    //     };
    //
    //     file_put_contents(
    //         Yii::getAlias('@yiiroot') . DIRECTORY_SEPARATOR  .
    //         $auth['tokenFileName'],
    //         $auth['token']
    //     );
    //
    //     $this->oAuth2[$this->companyWebId] = $auth;
    //     return $auth['token'];
    // }
    //
    // /**
    //  * get data for $requestName
    //  * @param string $requestName
    //  * @param array $params
    //  * @param bool $save
    //  * @param bool|string $fileName
    //  * @return array|bool
    //  * @throws Exception
    //  */
    // public function get($requestName = '', $params = [], $save = true, $fileName = false)
    // {
    //     $this->tokenGetAttempts = 0;
    //     $auth = $this->oAuth2[$this->companyWebId];
    //     if (!isset($auth['token']) || !$auth['token']) {
    //         $token = file_exists($auth['tokenFileName']) ?
    //             file_get_contents($auth['tokenFileName']):
    //             false
    //         ;
    //         $auth['token'] = $token ? $token : $this->updateAuthToken();
    //     }
    //
    //     // Adapt request name to function name syntax
    //     $actionName =
    //         str_replace(
    //             ' ',
    //             '',
    //             ucwords(strtolower(
    //                 str_replace('_', ' ', $requestName)
    //             ))
    //         )
    //     ;
    //
    //     while (!is_array($resp = $this->{"get{$actionName}"}($params))) { // Call method by name
    //         $this->updateAuthToken();
    //         //TODO: find better solution to handle auth rejections
    //         if (3 < $this->tokenGetAttempts) {
    //             file_put_contents(
    //                 'token_requests_fail_logs.txt',
    //                 date('l jS \of F Y h:i:s A') . "failed to request token several times \n",
    //                 FILE_APPEND
    //             );
    //             echo "<pre>";
    //             var_dump(date('l jS \of F Y h:i:s A') . "failed to request token several times \n");
    //             echo "</pre>";
    //             return false;
    //             break;
    //         }
    //     }// End While
    //
    //
    //
    //     if ($save) { //Save data if required
    //         $fileName = $fileName ? $fileName : "{$requestName}_{$this->requests[$requestName]['name']}";
    //         $fileName = "{$fileName}.json";
    //         file_put_contents(
    //             "{$fileName}",
    //             json_encode($resp)
    //         );
    //     }
    //
    //     return $resp;
    // }
    //
    // /**
    //  * Get and save or update Departments
    //  * @return array|bool|SimpleXMLElement|string
    //  */
    // private function getDepartment()
    // {
    //     $resp = $this->request(array(
    //         'url' => $this->requests['department']['url'],
    //     ));
    //
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         // TODO: Find 100% solution
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = self::xmlObjToAssocArray($resp);
    //     return $resp;
    // }
    //
    // /**
    //  * Get and save or update All Contacts
    //  * includes multiple querys for each contact
    //  * @throws Exception
    //  */
    // private function getContacts()
    // {
    //     $contactIds = $this->request(array(
    //         'url' => $this->requests['contacts']['url'],
    //     ));
    //
    //     if (strpos($contactIds, $this->statusMessages[401]) == 21) {
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $contact = array();
    //     $contacts = json_decode($contactIds);
    //     $resp = array();
    //     $limit = 0;
    //     foreach ($contacts as $id) {
    //         if (4 < $limit) {
    //             break;
    //         }
    //         $limit++;
    //         $resp[ $id ] = $this->get('contact', [ $id ], false);
    //     }
    //     return $resp;
    // }
    //
    // /**
    //  * Get and update Contact by id
    //  * @param array $params must contain 1 value <id of contact>
    //  * @return bool|mixed|string
    //  */
    // private function getContact($params)
    // {
    //     $resp = $this->request(array(
    //         'url' => str_replace('{{contact_id}}', $params[0], $this->requests['contact']['url']),
    //     ));
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = json_decode($resp, true);
    //     return $resp;
    // }
    //
    // /**
    //  * Get and update Employees by department id
    //  * @param array $params must contain 1 value <id of department>
    //  * @return bool|mixed|string
    //  */
    // private function getEmployees($params)
    // {
    //     $resp = $this->request(array(
    //         'url' => str_replace(
    //             '{{department_id}}',
    //             $params[0],
    //             $this->requests['employees']['url']
    //         ),
    //     ));
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = self::xmlObjToAssocArray($resp);
    //     return $resp;
    // }
    //
    // /**
    //  * Get and update Employees Properties by employee id
    //  * @param array $params must contain 1 value <id of employee>
    //  * @return bool|mixed|string
    //  */
    // private function getEmployeeProperties($params)
    // {
    //     $resp = $this->request(array(
    //         'url' => str_replace(
    //             '{{employee_id}}',
    //             $params[0],
    //             $this->requests['employee_properties']['url']
    //         ),
    //     ));
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         //TODO: change to status code checking
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = self::xmlObjToAssocArray($resp);
    //     return $resp;
    // }
    //
    // /**
    //  * Get and update Properties by time in minutes
    //  * @param array $params must contain 1 value <minutes>
    //  * @return bool|mixed|string
    //  */
    // private function getProperties($params)
    // {
    //     $m = $params[0] !== -1 ? "/m{$params[0]}" : "";
    //
    //
    //     $requestParams = array(
    //         'url' => str_replace(
    //             '/m{{minutes}}',
    //             $m,// Minutes
    //             $this->requests['properties']['url']
    //         ),
    //     );
    //
    //     if (isset($params[1])) {
    //         $requestParams['url'] = str_replace(
    //             '{{params}}',
    //             $params[1],//additional Params
    //             $requestParams['url']
    //         );
    //     }
    //
    //     $resp = $this->request($requestParams);
    //
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = self::xmlObjToAssocArray($resp);
    //
    //     return $resp;
    // }
    //
    // /**
    //  * Get and update Properties by time in minutes
    //  * @param array $params must contain 1 value <minutes>
    //  * @return bool|mixed|string
    //  */
    // private function getProperty($params)
    // {
    //     $resp = $this->request(array(
    //         'url' => str_replace(
    //             '{{order_id}}',
    //             $params[0],
    //             $this->requests['property']['url']
    //         ),
    //     ));
    //     if (strpos($resp, $this->statusMessages[401]) == 21) {
    //         // Response unauthorized
    //         return false;
    //     }
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = self::xmlObjToAssocArray($resp);
    //     return $resp;
    // }
    //
    // /**
    //  * @param $args [curl_setopt function values]
    //  * @param bool $isAuth
    //  * @return bool|string [answer of request]
    //  */
    // private function request($args, $isAuth = false)
    // {
    //     if (isset($args['args']) && is_array($args['args'])) {
    //         $args['args'] = http_build_query($args['args']);
    //     }
    //
    //     //Setup company id from webmegler
    //     if (isset($args['url'])) {
    //         $args['url'] = str_replace(
    //             '{{companyWebId}}',
    //             $this->companyWebId,
    //             $args['url']
    //         );
    //     }
    //
    //     $params = array(
    //         'url'       => array( CURLOPT_URL ),
    //         'isPost'    => array( CURLOPT_POST ),
    //         'args'      => array( CURLOPT_POSTFIELDS ),
    //         'isTranfer' => array( CURLOPT_RETURNTRANSFER, 1 ),
    //         'headers'   => array(
    //             CURLOPT_HTTPHEADER,
    //             array('Authorization: Bearer ' . $this->oAuth2[$this->companyWebId]['token'])
    //         ),
    //     );
    //
    //     // remove header token if requesting that token
    //     if ($isAuth) {
    //         unset($params['headers'][1]);
    //     }
    //
    //
    //     $ch = curl_init();
    //
    //
    //     foreach ($params as $key => $param) {
    //         if (isset($args[$key])) {
    //             if (isset($param[1]) && is_array($param[1])){
    //                 $param[1] = array_merge($param[1], $args[$key]);
    //             }else{
    //                 $param[1] = $args[$key];
    //             }
    //         }
    //
    //         if (isset($param[1])) {
    //             curl_setopt($ch, $param[0], $param[1]);
    //         }
    //     }
    //     $return = curl_exec($ch);
    //     return $return;
    // }
    //

    //
    // /**
    //  * Get and update Postnumbers coordinates by time in minutes
    //  * @param array $params must contain 1 value <minutes>
    //  * @return bool|mixed|string
    //  */
    // private function getPostCoordinates($params)
    // {
    //     $resp = $this->request(array(
    //         'url' => $this->requests['property']['url'],
    //     ));
    //
    //     $resp = simplexml_load_string($resp);
    //     $resp = $this->xmlObjToAssocArray($resp);
    //     return $resp;
    // }
}

