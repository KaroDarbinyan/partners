<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DepartmentsAvdelingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Departments Avdelings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-avdeling-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Departments Avdeling', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            //'id__',
            'id',
            'id_firma',
            'navn',
            'juridisknavn',
            'organisasjonsnummer',
            'urlhtmlpresentasjon_avdeling',
            'urlhtmlpresentasjon_konsern',
            'logo_url:url',
            'besoksadresse',
            'postadresse',
            'postnummer',
            'poststed',
            'telefon',
            'telefax',
            'email:email',
            'hjemmeside',
            'inaktiv',
            'dagligleder',
            'avdelingsleder',
            'fagansvarlig',
            'superbruker',
            'bilder',
            'fritekster',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
