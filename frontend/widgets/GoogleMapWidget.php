<?php

namespace frontend\widgets;

use yii\base\Widget;

class GoogleMapWidget extends Widget
{
    protected $apiKey;
    public $mapScript;
    public $callback;
    public $width;
    public $height;
    public $needActivation = true;
    public $dataTablesCoordinatesIndex;
    public $radius;
    public $coordinate;

    public function run()
    {
        $this->apiKey = \Yii::$app->params['googleMapApiKey'] ?? '';

        if (empty($this->apiKey)) {
            return 'Map display error! You must specify the apiKey.';
        }

        if (empty($this->mapScript)) {
            return 'Map display error! You must specify the mapScript.';
        }

        return $this->render('google_map', [
            'apiKey' => $this->apiKey,
            'mapScript' => $this->mapScript,
            'width' => $this->width,
            'height' => $this->height,
            'needActivation' => $this->needActivation,
            'callback' => $this->callback,
            'dataTablesCoordinatesIndex' => $this->dataTablesCoordinatesIndex,
            'radius' => $this->radius,
            'coordinate' => $this->coordinate,
        ]);
    }
}