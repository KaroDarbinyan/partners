<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PropertyImagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Property Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-images-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Property Images', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'property_id',
            'src',
            'alt',
            'angle_name',
            //'type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
