<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerContacts */

$this->title = 'Create Webmegler Contacts';
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-contacts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
