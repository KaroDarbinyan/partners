<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployees */

$this->title = 'Update Webmegler Employees: ' . $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id__, 'url' => ['view', 'id' => $model->id__]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webmegler-employees-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
