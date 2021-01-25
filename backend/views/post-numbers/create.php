<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\PostNumber */

$this->title = 'Create Post Number';
$this->params['breadcrumbs'][] = ['label' => 'Post Numbers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-number-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
