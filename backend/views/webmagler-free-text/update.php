<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmaglerFreeText */

$this->title = 'Update Webmagler Free Text: ' . $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Webmagler Free Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id__, 'url' => ['view', 'id' => $model->id__]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webmagler-free-text-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
