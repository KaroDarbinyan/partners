<?php

use kartik\switchinput\SwitchInput;
use yii\grid\CheckboxColumn;
use yii\grid\DataColumn;
use yii\grid\SerialColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\ActionColumn'],
            'navn:ntext',
            'tittel:ntext',
            'inaktiv:text',
            'mobiltelefon:ntext',
            [
                'attribute' => 'department_id',
                'label' => 'Office',
                'value' => 'department.navn'
            ],
            [
                'attribute' => 'inaktiv_status',
                'content' => function ($model) {
                    return SwitchInput::widget([
                        'pluginEvents' => [
                            'switchChange.bootstrapSwitch' => 'function() { 
                            let activeStatus = this.checked ? 1 : 0;
                              $.ajax({
                                  method: "get",
                                  url: "/admin/user/active-status?id="+this.getAttribute("data-id")+"&activeStatus="+activeStatus,
                              });
                            }',
                        ],
                        'pluginOptions' => [
                            'size' => 'mini',
                        ],
                        'name' => 'active',
                        'value' => $model->inaktiv_status,
                        'options' => ['data-id' => $model->id]
                    ]);
                },
                'label' => 'Inaktiv Status',
            ],
        ],
    ]); ?>
</div>
