<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PostNumber */

$this->title = 'Update Post Number: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Post Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-number-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
