<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>


<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <img alt="" src="/frontend/web/img/logo.svg" class="logotype" style="height: 100px;"><br/>
                </div>
                <div class="m-login__reset-password" style="display: block">
<!--                    <div class="m-login__head">-->
<!--                        <h3 class="m-login__title">Forgotten Password ?</h3>-->
<!--                        <div class="m-login__desc">Enter your email to reset your password:</div>-->
<!--                    </div>-->
                    <?php $form = ActiveForm::begin([
                        'action' => '',
                        'options' => ['class' => 'm-login__form m-form'],
                        'fieldConfig' => [
                            'options' => [
                                'tag' => false,
                            ],
                        ],
                    ]); ?>
                    <div class="form-group m-form__group">
                        <?= $form->field($model, 'password')->passwordInput([
                            'autofocus' => true,
                            'autocomplete' => 'off',
                            'class' => 'form-control m-input',
                            'placeholder' => 'Passord',
                        ])->label(false) ?>
                    </div>
                    <div class="m-login__form-action">
                        <?= Html::submitButton('Gjenopprett passord', [
                            'class' => 'm_login_forget_password_cancel btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary',
                            'name' => 'forgot-button'
                        ]) ?>
                        <a  href="/admin/site/login"  id="" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Cancel
                        </a>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>