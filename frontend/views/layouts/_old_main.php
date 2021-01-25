<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use \yii\widgets\ActiveForm;
use common\models\Forms;
use frontend\assets\AppAsset;
$viewParams = Yii::$app->view->params;
$bodyClass =  isset($viewParams['bodyClass']) ?
    $viewParams['bodyClass']
    :(isset($viewParams['page']) ? 'page-' . $viewParams['page']: '');
    AppAsset::register($this);

$model = isset($viewParams['sideForm']) ? $viewParams['sideForm'] : new Forms();// Form model fro sidepopup form
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon-180x180.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-128x128.png" sizes="128x128" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= $bodyClass; ?>">
<?php $this->beginBody() ?>

<?= $this->render('@app/views/layouts/_header.php'); ?>
<!-- You may need to put some content here -->

<?php
/* NavBar::begin([
     'brandLabel' => Yii::$app->name,
     'brandUrl' => Yii::$app->homeUrl,
     'options' => [
         'class' => 'navbar-inverse navbar-fixed-top',
     ],
 ]);
 $menuItems = [
     ['label' => 'Home', 'url' => ['/site/index']],
     ['label' => 'About', 'url' => ['/site/about']],
     ['label' => 'Contact', 'url' => ['/site/contact']],
 ];
 if (Yii::$app->user->isGuest) {
     $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
     $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
 } else {
     $menuItems[] = '<li>'
         . Html::beginForm(['/site/logout'], 'post')
         . Html::submitButton(
             'Logout (' . Yii::$app->user->identity->username . ')',
             ['class' => 'btn btn-link logout']
         )
         . Html::endForm()
         . '</li>';
 }
 echo Nav::widget([
     'options' => ['class' => 'navbar-nav navbar-right'],
     'items' => $menuItems,
 ]);
 NavBar::end();*/
?>
<div class="container std <?= $viewParams['page'] ?>">
    <?= $content ?>
</div>
<footer>
    <div class="VERDIVURDERING">
        <div class="vd_container">
            <a href="" class="btn vd_btn">verdivurdering</a>
            <div class="vd_main">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'contact-form',
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false
                        ],
                    ],
                    'options' => [
                        'class' => 'forms'
                    ]
                ]); ?>
                <div class="frow">
                    <?= $form->field($model, 'phone')
                        ->textInput(['class' => 'styler', 'placeholder' => 'TELEFON'])->label(false) ?>
                    <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                        ->hiddenInput(['value' => 'contact', 'class' => false])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($model, 'name')
                        ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'NAVN'])->label(false) ?>
                </div>
                <div class="frow">
                    <?= $form->field($model, 'post_number')
                        ->textInput(['class' => 'styler', 'placeholder' => 'POSTNUMMER'])->label(false) ?>
                </div>
                <div class="frow" style="text-align: left;">
                    <?= $form->field($model, 'i_agree')
                        ->checkbox(['class' => 'styler', 'label' => '<span style="font-size: 13px;">Jeg har lest og godkjent <a href="/personvern" style="color: white;" target="_blank">vilkårene</a></span>'])->label(false) ?>
                </div>
                <div class="frow frow_right">
                    <a href="#lagre_ditt_sok_result" style="display: none" class="popup" id="popup"></a>
                    <?= Html::submitButton('KONTAKT MEG', ['class' => 'btn contact_me']) ?>
                </div>
                <!--Hidden Inputs -->
                <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['value' => 'verdivurdering', 'class' => false])->label(false) ?>
                
                <?= $model->broker_id ?
                $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['class' => false])->label(false)
                : '';
                ?>

                <?= $model->department_id ?
                $form->field($model, 'department_id', ['errorOptions' => ['tag' => null]])
                ->hiddenInput(['class' => false])->label(false)
                : '';
                ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
