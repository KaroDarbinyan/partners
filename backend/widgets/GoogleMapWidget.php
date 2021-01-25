<?php

namespace backend\widgets;

use yii\base\Widget;

class GoogleMapWidget extends Widget
{
    protected $apiKey;
    public $callback;
    public $width;
    public $height;
    public $needActivation = true;

    public function run()
    {
        $this->apiKey = \Yii::$app->params['googleMapApiKey'] ?? '';

        if (empty($this->apiKey)) {
            return 'Map display error! You must specify the API key.';
        }

        return $this->render('google_map', [
            'apiKey' => $this->apiKey,
            'width' => $this->width,
            'height' => $this->height,
            'needActivation' => $this->needActivation,
            'callback' => $this->callback
        ]);
    }
}