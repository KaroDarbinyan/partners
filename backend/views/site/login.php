<?php

/* @var $model \common\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">


<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">


    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1"
         id="m_login">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <?php //Merge: dev-local -> ringelsite ?>
                    <img alt="" src="/frontend/web/img/logo.svg" class="logotype" style="height: 100px;"><br/>
                </div>
                <div class="m-login__signin">
                    <?php
                    if ($msg = Yii::$app->session->getFlash('success')): ?>
                        <div class="kt-alert kt-alert--outline alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                            <span><?= $msg ?></span>
                        </div>
                    <?php endif; ?>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'options' => ['class' => 'm-login__form m-form'],
                        'fieldConfig' => [
                            'options' => [
                                'tag' => false,
                            ],
                        ],
                    ]); ?>
                    <div class="form-group m-form__group">
                        <?= $form->field($model, 'username')->textInput([
                            'autofocus' => true,
                            'autocomplete' => 'off',
                            'class' => 'form-control m-input',
                            'placeholder' => 'E-post',
                        ])->label(false) ?>
                    </div>
                    <div class="form-group m-form__group">
                        <?= $form->field($model, 'password')->passwordInput([
                            'autofocus' => true,
                            'autocomplete' => 'off',
                            'class' => 'form-control m-input m-login__form-input--last',
                            'type' => 'password',
                            'placeholder' => 'Passord',
                        ])->label(false) ?>
                        <?= $form->field($model, 'active')->hiddenInput()->label(false) ?>
                    </div>
                    <div class="row m-login__form-sub">
                        <div class="col m--align-left m-login__form-left">
                            <label class="m-checkbox  m-checkbox--light">
                                <input type="checkbox" name="remember" name="LoginForm[rememberMe]" value="0"> Husk meg
                                <span></span>
                            </label>
                        </div>
                        <div class="col m--align-right m-login__form-right">
                            <a href="/admin/site/forgot-password" id="" class="m-link">Glemt passord ?</a>
                        </div>
                    </div>
                    <div class="m-login__form-action">
                        <?= Html::submitButton('Logg inn', [
                            'class' => 'btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary',
//                            'id' => 'm_login_signin_submit',
                            'name' => 'login-button'
                        ]) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <div class="m-login__forget-password">
                    <div class="m-login__head">
                        <h3 class="m-login__title">Har glemt passord ?</h3>
                        <div class="m-login__desc">Skriv inn epost din for å tilbakestille passordet ditt:</div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email"
                                   id="m_email" autocomplete="off">
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_forget_password_submit"
                                    class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                    Gjenopprett passord
                            </button>&nbsp;&nbsp;
                            <button id="m_login_forget_password_cancel"
                                    class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Avbryt
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- end:: Page -->

<script src="<?= Yii::getAlias('@web') ?>/css/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/css/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script src="<?= Yii::getAlias('@web') ?>/snippets/custom/pages/user/login.js" type="text/javascript"></script>

<!-- end::Body -->
</body>