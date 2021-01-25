<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WebmeglerContacts */

$this->title = $model->id__;
$this->params['breadcrumbs'][] = ['label' => 'Webmegler Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="webmegler-contacts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id__], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id__], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id__',
            'id',
            'har_tilgang_til_detaljer',
            'kontakttype',
            'id_kontakter__ny',
            'id_kunder',
            'fornavn',
            'etternavn',
            'firmanavn',
            'organisasjonsnummer',
            'adresse',
            'postnummer',
            'poststed',
            'land',
            'nyadresse',
            'nypostnummer',
            'nypoststed',
            'nyadressefradato',
            'nyland',
            'email:email',
            'telefon',
            'mobiltelefon',
            'personnummer',
            'fodselsdato',
            'id_ansatte__registrertav',
            'id_ansatte__endretav',
            'endretdato',
            'registrertdato',
            'relatertegrupper',
            'budgiveroppdrag',
            'andrekontakteroppdrag',
            'interessentoppdrag',
            'selgerkjoperoppdrag',
            'samtykkeregistreringer',
        ],
    ]) ?>

</div>
