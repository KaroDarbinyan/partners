<?php


namespace api\components;


use Yii;

class ApiResponseHelper
{


    /**
     * @param int $statusCode
     * @param array $response_params ["data", "error"]
     * @return array
     */
    public static function responseTemplate($statusCode = 200, $response_params = [])
    {
        Yii::$app->response->statusCode = $statusCode;
        $success = isset($response_params["error"]) ? false : true;
        $return = [
            "success" => $success,
            "status" => Yii::$app->response->statusText,
            "code" => Yii::$app->response->statusCode,
        ];

        if (isset($response_params["error"])) {
            $return["error"] = $response_params["error"];
        }

        if (isset($response_params["data"])) {
            $return["data"] = $response_params["data"];
        }

        return $return;
    }
}