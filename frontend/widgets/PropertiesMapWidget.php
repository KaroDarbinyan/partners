<?php

namespace frontend\widgets;

use yii\base\Widget;

class PropertiesMapWidget extends Widget
{
    protected $apiKey;
    public $callbackFunction;
    public $needActivation = true;
    public $height;

    public function run()
    {
        $this->apiKey = \Yii::$app->params['googleMapApiKey'] ?? '';

        if (empty($this->apiKey)) {
            return 'Map display error! You must specify the API key.';
        }

        return $this->render('properties_map', [
            'apiKey' => $this->apiKey,
            'callbackFunction' => $this->callbackFunction,
            'needActivation' => $this->needActivation,
            'height' => $this->height,
        ]);
    }
}