<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentsAvdeling */

$this->title = 'Update Departments Avdeling: ' . $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Departments Avdelings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id__, 'url' => ['view', 'id' => $model->id__]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="departments-avdeling-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
