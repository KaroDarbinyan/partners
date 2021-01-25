<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WebmaglerFreeText */

$this->title = $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Webmagler Free Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webmagler-free-text-view">

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
            'propertyDetailId',
            'nr',
            'visinettportaler',
            'compositeTextId',
            'gruppenavn',
            'overskrift',
            'tekst',
            'htmltekst',
        ],
    ]) ?>

</div>
