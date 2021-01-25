<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WebmeglerEmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webmegler Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-employees-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webmegler Employees', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id__',
            'id',
            'avdeling_id',
            'navn',
            'tittel',
            'inaktiv',
            'mobiltelefon',
            'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
