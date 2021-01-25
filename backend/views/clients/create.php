<?php

/** @var $this yii\web\View */
/** @var $lead common\models\Forms */

use backend\components\UrlExtended;use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Legg til ny client';

$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Ny client</span>',
    'url' => ['/clients/hot'],
    'class' => 'm-nav__link',
];

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; display: block;"></div>
        <div class="row">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 10px;">
                                <h4 style="color: white;">Legg til ny client</h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <div class="forms-form">
                            <?php $form = ActiveForm::begin([
                                'id' => 'add-lead-form',
                                'method' => 'post',
                                'action'=> Url::toRoute('clients/create'),
                            ]); ?>

                            <?= $form->field($model, 'type')
                                ->dropDownList([
                                    'verdivurdering' => 'Verdivurdering',
                                    'pristilbud' => 'Pristilbud',
                                    'kontakt' => 'Kontakt',
                                    'skal_selge' => 'Skal selge',
                                ], ['class' => 'add-lead-input', 'id' => 'lead-type',])
                                ->label(false) ?>

                            <?= $form->field($model, 'phone')
                                ->textInput(['maxlength' => true, 'id' => 'lead-phone', 'class' => 'add-lead-input', 'placeholder' => 'Telefon'])->label(false) ?>

                            <?= $form->field($model, 'name')
                                ->textInput(['maxlength' => true, 'id' => 'lead-name', 'class' => 'add-lead-input', 'placeholder' => 'Navn'])->label(false) ?>

                            <?= $form->field($model, 'email')
                                ->textInput(['maxlength' => true, 'id' => 'lead-email', 'class' => 'add-lead-input', 'placeholder' => 'Epost'])->label(false) ?>

                            <?= $form->field($model, 'post_number')
                                ->textInput(['maxlength' => true, 'id' => 'lead-post_number', 'class' => 'add-lead-input', 'placeholder' => 'Postnummer'])->label(false) ?>

                            <?= $form->field($model, 'address')
                                ->textInput(['maxlength' => true, 'id' => 'lead-address', 'class' => 'add-lead-input', 'placeholder' => 'Adresse'])->label(false) ?>

                            <?= $form->field($model, 'message')
                                ->textarea(['rows' => 6, 'class' => 'add-lead-input', 'placeholder' => 'Melding'])->label(false) ?>

                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <?= $form->field($model, 'subscribe_email')
                                    ->checkbox([
                                        'class' => 'custom-control-input',
                                        'id' => 'lead-subscribe_email',
                                        'label' => '<span class="custom-control-label" for="lead-subscribe_email">Jeg ønsker å motta eiendomsrelatert informasjon på e-post</span>'
                                    ]); ?>
                                <?= $form->field($model, 'i_agree')
                                    ->checkbox([
                                        'class' => 'custom-control-input',
                                        'id' => 'lead-i_agree',
                                        'label' => '<span class="custom-control-label" for="lead-i_agree">Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a></span>'
                                    ]); ?>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success is-clients-create" type="button" name="after_action" value="list">
                                    Legg til
                                </button>
                                <button class="btn btn-secondary is-clients-create" type="button" name="after_action" value="detail">
                                    Legg til og rediger
                                </button>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#myModal"></button>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 class="text-center text-success">Leaden opprettet</h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Lukk</button>
            </div>
        </div>
    </div>
</div>
