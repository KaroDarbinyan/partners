<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployees */

$this->title = 'Create Webmegler Employees';
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-employees-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
