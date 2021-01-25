<?php

/* @var $model \common\models\User */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">


<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">


    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <img alt="" src="/frontend/web/img/logo.svg" class="logotype" style="height: 100px;"><br/>
                </div>

                <div class="m-login__forget-password" style="display: block">
                    <div class="m-login__head">
                        <h3 class="m-login__title">Har glemt passord ?</h3>
                        <div class="m-login__desc">Skriv inn epost din for å tilbakestille passordet ditt:</div>
                    </div>
                    <?php $formForget = ActiveForm::begin([
                        'action' => '',
                        'options' => ['class' => 'm-login__form m-form'],
                        'fieldConfig' => [
                            'options' => [
                                'tag' => false,
                            ],
                        ],
                    ]); ?>
                        <div class="form-group m-form__group">
                            <?= $formForget->field($model, 'email')->textInput([
                                'autofocus' => true,
                                'autocomplete' => 'off',
                                'class' => 'form-control m-input',
                                'placeholder' => 'E-post',
                            ])->label(false) ?>
                        </div>
                        <div class="m-login__form-action">
                            <?= Html::submitButton('Gjenopprett passord ', [
                                'class' => 'm_login_forget_password_cancel btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary',
                                'name' => 'forgot-button'
                            ]) ?>
                            <a  href="/admin/site/login"  id="" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">Avbryt
                            </a>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- end:: Page -->


<!--begin::Global Theme Bundle -->
<script src="/admin/css/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="/admin/css/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->


<!--begin::Page Scripts -->
<script src="/admin/snippets/custom/pages/user/login.js" type="text/javascript"></script>
<!--end::Page Scripts -->


<!-- end::Body -->
</body>
