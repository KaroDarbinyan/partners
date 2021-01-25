<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WebmeglerEmployeePropertiesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webmegler Employee Properties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-employee-properties-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webmegler Employee Properties', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id__',
            'id',
            'oppdragsnummer',
            'markedsforingsklart',
            'type_oppdragstatus',
            'adresse',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
