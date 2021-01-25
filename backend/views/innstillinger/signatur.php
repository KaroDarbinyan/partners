<?php

use backend\assets\AppAsset;
use common\models\Partner;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/** @var User $user */
/** @var string $logo */

$this->title = 'Signatur';
$user = Yii::$app->user->identity;

?>
<style>
    @font-face {
        font-family: 'Futura-PT-Book';
        src: url('/fonts/FuturaPT-Book/FuturaPT-Book.ttf')
        format('truetype');
        font-weight: normal;
        font-style: normal;
    }
</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-content pt-0">
        <div style="clear: both; padding-top: 30px; display: block;"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="mt-1">
                                <h4 class="text-white">Signatur</h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body m--block-center">
                        <?php $form = ActiveForm::begin([
                            'id' => 'signatur-form',
                            'method' => 'post',
                        ]); ?>
                        <div class="row">
                            <div class="col-md-5 p-1">
                                <?= $form->field($model, 'left_content')->textarea([
                                    'rows' => '8',
                                    'style' => 'resize: none; font-family: Futura-PT-Book,serif !important'
                                ])->label(false); ?>
                            </div>
                            <div class="col-md-5 p-1">
                                <?= $form->field($model, 'right_content')->textarea([
                                    'rows' => '8',
                                    'style' => 'resize: none; font-family: Futura-PT-Book,serif !important'
                                ])->label(false); ?>
                            </div>
                            <div class="col-md-12 p-1">
                                <a id="download-signatur" class="btn btn-success btn-sm"
                                   data-user-name="<?= $user->navn; ?>"><i class="flaticon-download"></i></a>
                                <?= Html::submitButton('Generate', [
                                    'id' => 'generate-signatur',
                                    'class' => 'btn btn-success btn-sm'
                                ]); ?>
                                <select id="signatur-theme" class="selectpicker"
                                        data-style="btn-sm btn-success btn p-2 w-">
                                    <option data-color="white" data-background="#000000" selected="selected">SORT
                                    </option>
                                    <option data-color="white" data-background="#0b202d">BLÅ</option>
                                    <option data-color="white" data-background="#686f73">GRÅ</option>
                                    <option data-color="black" data-background="#f5ce99">SAND</option>
                                </select>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <div class="row">
                            <div class="col-md-12 overflow-auto p-1">
                                <canvas id="canvas"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= Html::img($logo, ["id" => "signatur_logo", "class" => "d-none"]); ?>

<button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#signaturModal"></button>
<div id="signaturModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: #2b2b2b">
            <div class="modal-body">
                <h3 id="signatur-message" class="text-center text-success"></h3>
            </div>
            <div class="modal-footer" style="border-top: none">
                <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

