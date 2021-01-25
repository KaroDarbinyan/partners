<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmaglerFreeText */

$this->title = 'Create Webmagler Free Text';
$this->params['breadcrumbs'][] = ['label' => 'Webmagler Free Texts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmagler-free-text-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
