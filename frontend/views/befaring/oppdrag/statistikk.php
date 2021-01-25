<?php

use common\components\Befaring;
use frontend\assets\BefaringAsset;
use yii\web\View;

$this->title = 'BEFARING';


$this->params['breadcrumbs'][] = $this->title;
//$data ['above_price_quote'] = 15.1;
//$data ['process'] = 2710000;
$this->registerJs(
    <<<JS
KTMorrisChart.init("{$data['above_price_quote']}");
JS

)
?>
<div class="statistikk">
    <div class="statistic_item">
        <div class="chart">
            <div id="statistikk-chart"></div>

        </div>


        <div class="processing">
            <h1 class="forsiden-header"><?= $data['process'] ?></h1>
            <p>Prisantydning</p>

        </div>
    </div>
    <div class="digital-marketing" >
        <div>
            <div>
                <strong><?= $data ['cl_sum'] ?></strong>
                <p>klikk</p>
            </div>
            <div>
                <strong><?= $data ['im_sum'] ?></strong>
                <p>visninger</p>
            </div>
            <div>
                <strong><?= $data ['rc_sum'] ?></strong>
                <p>unike visninger</p>
            </div>
        </div>
    </div>
</div>
