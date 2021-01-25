<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WebmeglerContactsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Webmegler Contacts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webmegler-contacts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Webmegler Contacts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id__',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
