<?php

use common\models\Partner;
use common\models\SpBoost;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var User $user */
/** @var SpBoost $models */
/** @var Partner[] $partners */

$this->title = "Markedspakke";

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-7">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h4 class="text-white">Markedspakke</h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <?php foreach ($models as $model): ?>
                            <?php
                            $options = array_fill_keys(array_keys($partners), ['selected' => false]);

                            if ($model->partner_ids) {
                                $ids = explode(",", $model->partner_ids);
                                foreach ($ids as $id) {
                                    if (isset($partners[$id])) $options[$id] = ['selected' => true];
                                }
                            } ?>
                            <?php $form = ActiveForm::begin([
                                'id' => "markedspakke_{$model->id}",
                                'method' => 'post',
                                'options' => [
                                    "data-sp_boost_id" => $model->id,
                                    'class' => 'markedspakke-form w-100',
                                ]
                            ]); ?>
                            <div class="row p-2">
                                <div class="col-md-2 pt-2"><?= $model->name; ?></div>
                                <div class="col-md-3">
                                    <?= $form->field($model, 'price')->textInput([
                                        "placeholder" => "Price",
                                        'class' => 'spboost-price form-control'
                                    ])->label(false); ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($model, 'partner_ids')->dropDownList($partners, [
                                        'multiple' => 'multiple',
                                        'class' => 'form-control selectpicker',
                                        'options' => $options
                                    ])->label(false); ?>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= Html::submitButton('Lagre', ['class' => 'btn btn-success', 'style' => 'border-radius: 7px']) ?>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        <?php endforeach; ?>
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
                <h3 class="text-center text-success">Vellykket sendt</h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
