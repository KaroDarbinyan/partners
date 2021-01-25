<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WebmaglerFreeTextSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webmagler Free Texts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmagler-free-text-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webmagler Free Text', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id__',
            'propertyDetailId',
            'nr',
            'visinettportaler',
            'compositeTextId',
            //'gruppenavn',
            //'overskrift',
            //'tekst',
            //'htmltekst',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
