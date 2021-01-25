<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


/**
 * Topplister controller
 */
class EiendomsverdiController extends Controller
{

    const WSDL = 'https://externalapi.eiendomsverdi.no/singlesignon.svc?wsdl';
    const FRONT_PAGE_URL = 'https://portal.eiendomsverdi.no/Account/Home/ExternalLogin?';


    public function actionIndex($address = '')
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $displayMode = Yii::$app->request->get('address') ? 'valueAssistant' : 'info';
        $xml = /** @lang text */
            '<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope" xmlns:a="http://www.w3.org/2005/08/addressing" xmlns:u="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                    <s:Header>
                        <a:Action>http://tempuri.org/ISingleSignOn/Web40GetLoginUrl</a:Action>
                        <a:To s:mustUnderstand="1">https://externalapi.eiendomsverdi.no/SingleSignOn.svc</a:To>
                        <u:Security>
                            <u:UsernameToken>
                                <u:Username>involve;' . $user->department->eiendomsverdi . ';' . $user->web_id . ':' . $user->email . ';true</u:Username>
                                <u:Password>ppCc2SsSI3sT48imM%D+</u:Password>
                            </u:UsernameToken>
                        </u:Security>
                    </s:Header>
                    <s:Body>
                        <Web40GetLoginUrl xmlns="http://tempuri.org/">
                            <filter xmlns:ev="http://schemas.datacontract.org/2004/07/EV.InformationServices.ExternalApi.DTO">
                                <ev:DisplayMode>' . $displayMode . '</ev:DisplayMode>
                                <ev:SearchString>' . $address . '</ev:SearchString>
                            </filter>
                        </Web40GetLoginUrl>
                    </s:Body>
                </s:Envelope>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::WSDL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-type: application/soap+xml", "Connection: close"]);
        $data = curl_exec($ch);

        preg_match('#token=(\w+)#', $data, $matches);

        if ($matches && $matches[0]) {
            $url = self::FRONT_PAGE_URL . $matches[0];
            return $this->redirect($url);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
