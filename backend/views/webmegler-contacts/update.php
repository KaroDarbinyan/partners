<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerContacts */

$this->title = 'Update Webmegler Contacts: ' . $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id__, 'url' => ['view', 'id' => $model->id__]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webmegler-contacts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
