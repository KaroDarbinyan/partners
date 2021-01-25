<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\FormsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forms-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>


    <p>
        <?= Html::a('Create Forms', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin([
        'formSelector' => 'form',// this form is submitted on change
        'submitEvent' => 'change',
    ]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'surname',
            'delegated',
            'post_number',
            //'phone',
            //'email:email',
            //'message:ntext',
            //'subscribe_email:email',
            //'contact_me',
            //'type',
            //'target_id',
            //'send_sms',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
