<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AllPostNumber */

$this->title = 'Update All Post Number: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'All Post Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="all-post-number-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
