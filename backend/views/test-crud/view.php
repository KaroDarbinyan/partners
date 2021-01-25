<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Forms */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="forms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'name',
            'surname',
            'delegated',
            'post_number',
            'phone',
            'email:email',
            'message:ntext',
            'subscribe_email:email',
            'contact_me',
            'type',
            'target_id',
            'send_sms',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
