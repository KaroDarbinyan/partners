<?php

namespace api\modules\v1\controllers;

use Yii;
use Firebase\JWT\JWT;

class AuthController {
    public static function authorize() {
        require \Yii::getAlias('@webroot').'/../../frontend/config/OAuthPublicKey.php';

        try {
            $jwt = '';
            $headers = Yii::$app->request->headers;
            if ($headers->has('Authorization')) {
                $authorization = $headers->get('Authorization');
                $parts = explode(' ', $authorization);
                $jwt = $parts[1];
            }
            $decoded = JWT::decode($jwt, $publicKey, ['RS256']);

            if (!in_array('partners.stats.read', $decoded->scopes)) {
                throw new Exception();
            }
        } catch (\Throwable $th) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            Yii::$app->response->statusCode = 401;
            $response->data = [
                'error' => 'Unauthorized',
                'status' => 401
            ];
            // return $response;
            return false;
        }

        return true;
    }
}