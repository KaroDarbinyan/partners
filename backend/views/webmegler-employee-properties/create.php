<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerEmployeeProperties */

$this->title = 'Create Webmegler Employee Properties';
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Employee Properties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-employee-properties-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
