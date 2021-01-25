<?php

namespace common\components;

use Yii;
use yii\base\Component;

class CdnComponent extends Component
{
    public static function optimizedUrl($path, $width = '', $height = '')
    {
        $baseUrl = 'https://cdn.involve.no/t/yii2/schala/'.$width.'_'.$height.'/';
        if (strpos(strToLower($path), 'http://') === 0 || strpos(strToLower($path), 'https://') === 0) {
            $finalPath = base64_encode($path);
        } else {
            $finalPath = $path;
        }
        $finalUrl = $baseUrl.$finalPath;
        return $finalUrl;
    }
}
