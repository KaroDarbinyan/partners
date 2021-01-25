<?php

namespace console\controllers;
use yii\console\Controller;

class WebmeglerCronController extends Controller
{
    public $message;
    public $count = 0;

    public function options($actionID)
    {
        return ['message', 'count'];
    }

    public function optionAliases()
    {
        return [
            'm' => 'message',
            'c' => 'count',
        ];
    }

    public function actionIndex()
    {
        $this->count++;
        file_put_contents('cron-test.php', $this->message .  '  ' . date("Y-m-d h:i:s") . "\n", FILE_APPEND);

    }

    public function actionDis()
    {
        $this->distance();
    }

    public function actionDelegate()
    {
        //yii webmegler-cron/delegate

        $this->count++;
        echo date('h:i:s')."\n" ;
        file_put_contents('cron-test-delegate.php', $this->message .  '  ' . date("Y-m-d h:i:s") . "\n", FILE_APPEND);
        if (!$this->message){
            $cmd = 'yii webmegler-cron/sleep ';
            pclose(popen("start /B ". $cmd, "r"));
        }
    }

    private function distance(){
        $f1 = 1;
        $d1 = 1;
        $f2 = 2;
        $d2 = 2;

        /*
         * a = sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
         * c = 2 ⋅ atan2( √a, √(1−a) )
         * d = R ⋅ c
        */
        $R = 6371 * 1000; // R Earth Radius in meters
        $f1 = deg2rad($f1);// φ1
        $f2 = deg2rad($f2);// φ2
        $d1 = deg2rad($d1);// λ1
        $d2 = deg2rad($d2);// λ2
        $df = sin(($f1-$f2)/2);
        $df = $df*$df;// sin²(Δφ/2)

        $dd = sin(($d1-$d2)/2);
        $dd = $dd*$dd;// sin²(Δλ/2)
        $a = $df + cos($f1) * cos($f2) * $dd;// sin²(Δφ/2) + cos φ1 ⋅ cos φ2 ⋅ sin²(Δλ/2)
        $c = 2 * atan2( sqrt($a), sqrt(1-$a) );// 2 ⋅ atan2( √a, √(1−a) )

        $L= $R*$c;// R ⋅ c
        var_dump($L);

    }
}