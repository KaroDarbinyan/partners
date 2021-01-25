<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Budsjett */

$this->title = 'Create Budsjett';
$this->params['breadcrumbs'][] = ['label' => 'Budsjetts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budsjett-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
