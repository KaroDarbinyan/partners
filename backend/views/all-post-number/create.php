<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AllPostNumber */

$this->title = 'Create All Post Number';
$this->params['breadcrumbs'][] = ['label' => 'All Post Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="all-post-number-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
