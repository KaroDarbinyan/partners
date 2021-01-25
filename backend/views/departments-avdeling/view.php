<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentsAvdeling */

$this->title = $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Departments Avdelings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="departments-avdeling-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id__], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id__], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id__',
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
        ],
    ]) ?>

</div>
