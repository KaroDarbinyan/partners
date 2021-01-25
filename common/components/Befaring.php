<?php

namespace common\components;

use Aws\Ses\SesClient;
use common\models\Property;
use common\models\PropertyDetails;
use Yii;
use yii\base\Component;
use Aws\Exception\AwsException;
use Aws\Credentials\Credentials;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class Befaring extends Component
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public static function numFormat(&$str, $count = 4 , $prependNumber = 0) {

        if(strlen($str) < $count) {
            $str = $prependNumber.$str;
        }
        if(strlen($str) < $count) {
            return self::numFormat($str, $count, $prependNumber);
        }
        return $str;
    }

    public static function strReplace($str, $search = ' ', $replace = '_') {
        return str_replace($search, $replace, $str);
    }

    public static  function checkPropertyId($id)
    {
        if(!$property = PropertyDetails::find()->where(['id' => $id])->one()) {
            return false;
        }
        Yii::$app->session->set('propertyAddress', $property->adresse);
        Yii::$app->session->set('propertyName', $property->department? $property->department->short_name :'');
        return true;
    }

    /**
     * @param $data
     * @param bool $die
     * @return bool
     */
    public static function  print_r($data, $die = true) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        echo $die? die() : '';
       return true;

    }

    public function getDataDetaljer() {
        $model = Property::find()->joinWith('neighbors')
            ->where(['property.web_id' => $this->id]);
        if (!$model = $model->one()){
           return false;
        }
        $data = $model->neighbors;
        return compact( 'model', 'data');
    }

    public function getDataStatistic() {

        /** @var $oppdrag PropertyDetails */
        $model = Property::find()
            ->joinWith('propertyDetails')
            ->andWhere(['property.web_id' => $this->id])->one();
            if(!$model) {
                return false;
            }
        $oppdrag = $model->propertyDetails;
        $above_price_quote = $process = $clicks = $impressions = 0;
        if($oppdrag->salgssum) {
            $above_price_quote = round(($oppdrag->salgssum - $oppdrag->prisantydning) * 100 / $oppdrag->salgssum, 1);
        }
        if($oppdrag->prom ) {
            $process =  number_format($oppdrag->salgssum / $oppdrag->prom, 0, '', ' ');
        }
        $data =  [
            'clicks' => 0,
            'impressions' => 0,
            'reach' => 0
        ];
        $dm = [
            'deltaStandard' => $data,
            'instagram' => $data,
            'facebookAB' => $data,
            'cl_sum'  => 0,
            'im_sum'  => 0,
            'rc_sum'  => 0
        ];
        if (isset($model->propertyDetails->digitalMarketing) && $model->propertyDetails->digitalMarketing) {
            $dms = ArrayHelper::toArray($model->propertyDetails->digitalMarketing);
            $start_date = $dms[0]['start']; $stop_date =  $dms[0]['stop'];
            foreach ($dms as $item) {
                $start_date = $start_date < $item['start'] ? $start_date : $item['start'];
                $stop_date = $stop_date > $item['stop'] ? $stop_date : $item['stop'];
                if ($item['stats']) {
                    $arr = json_decode($item['stats'], true);
                    $dm[$item['type']]['clicks'] += $arr['clicks'];
                    $dm[$item['type']]['impressions'] += $arr['impressions'];
                    $dm[$item['type']]['reach'] += $arr['reach'];
                }
            }
            $dm['start'] = date('j. M Y', substr($start_date, 0, 10));
            $dm['stop'] = date('j. M Y.', substr($stop_date, 0, 10));
            $dm['cl_sum'] = $dm['deltaStandard']['clicks'] + $dm['instagram']['clicks'] + $dm['facebookAB']['clicks'];
            $dm['im_sum'] = $dm['deltaStandard']['impressions'] + $dm['instagram']['impressions'] + $dm['facebookAB']['impressions'];
            $dm['rc_sum'] = $dm['deltaStandard']['reach'] + $dm['instagram']['reach'] + $dm['facebookAB']['reach'];
        }
        $cl_sum = $dm['cl_sum'];
        $im_sum = $dm['im_sum'];
        $rc_sum = $dm['rc_sum'];
        $data = compact('above_price_quote', 'process', 'im_sum', 'cl_sum', 'rc_sum');
        return compact( 'model', 'data');

    }
}