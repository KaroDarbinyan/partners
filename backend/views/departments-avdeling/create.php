<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DepartmentsAvdeling */

$this->title = 'Create Departments Avdeling';
$this->params['breadcrumbs'][] = ['label' => 'Departments Avdelings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departments-avdeling-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
