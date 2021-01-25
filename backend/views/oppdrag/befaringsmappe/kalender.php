<?php
/* @var $this yii\web\View */

use backend\assets\AppAsset;

$this->title = 'Kalender';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Befaringsmappe</span>',
    'url' => ['/oppdrag/befaringsmappe/omrade'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;


$this->registerJsFile('admin/js/befaringsmappe/kalender.js',
    ['depends' => [AppAsset::className()]]);

?>
<div class="m-portlet__body" style="padding: 0;">

    <div class="row">
        <div class="col-md-12">
            <div id="m_calendar"></div>
        </div>

    </div>
</div>


