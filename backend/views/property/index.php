<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PropertySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Property', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],

            'id',
            'web_id',
            'address:ntext',
            'price',
            'type',
            's_meters',
            'employee_id',

        ],
    ]); ?>
</div>
