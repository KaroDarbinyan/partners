<?php

use backend\components\UrlExtended;
use common\widgets\SearchWidget;
use yii\helpers\Url;

?>

<button type="button" class="btn video-btn mt-4 ml-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400402232" data-target="#myModalVideo">
<i class="flaticon-warning"></i> Instruksjonsvideo
</button>

<div class="site-befaring">
    <div class="header">
        <h1>Befaring</h1>
    </div>

    <div class="form-group">
        <?=  SearchWidget::widget($data = [
            'elementId' => 'befaring-search',
            'page' => true,
            'url' => Url::toRoute(['befaring']),
            'inputClass' => 'form-control',
            'placeholder' => 'Søk etter adresse',
        ]) ?>
        <small class="form-text text-muted"></small>
    </div>

    <div class="text-center">
        <a class="text-white" href="<?= UrlExtended::toRouteAddaptive(['oppdrag/befaring']) ?>">
            Eller velg fra listen
        </a>
    </div>
</div>
