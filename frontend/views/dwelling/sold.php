<?php

/* @var $this yii\web\View */
/* @var $model common\models\Forms */
/* @var $property common\models\PropertyDetails */
/* @var $broker common\models\User */

use common\components\CdnComponent;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Solgt ' . $property->type_eiendomstyper . ' på ' . $property->adresse . ' for ' . number_format($property->prissamletsum, 0, ' ', ' ') . ' NOK : Schala Partners eiendomsmegler';
$this->registerMetaTag(['name' => 'description', 'content' => $property->overskrift]);
?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="<?php if ($property->images && count($property->images) > 0): ?><?= CdnComponent::optimizedUrl($property->images[0]->urlstorthumbnail) ?><?php else: ?>/img/header_broker_bg.jpg<?php endif ?>">
    <div class="container">
        <div class="row">
            <div class="col-12 tac">
                <h1 class="text-uppercase font-bold mb-2">Solgt</h1>
                <h4 class="mb-2"><?= $property->title ?>, <?= $property->adresse ?></h4>
                <h4 class="mb-2">Prisantydning: <?= $property->getCost() ?>, -</h4>
                <h4 class="mb-2">Størrelse: <?= $property->getProm() ?> m<sup>2</sup></h4>
                <p>Ønsker du å vite hva denne eiendommen ble solgt for?</p>
            </div>
            <div class="col-12 col-md-6 order-2 order-md-1">
                <?php $form = ActiveForm::begin(['id' => 'salgssum_landing-form',
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false
                        ],
                    ],
                    'options' => [
                        'class' => 'lead-form contact_form'
                    ]]) ?>

                <?= $form->field($model, 'type', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput(['value' => 'salgssum_landing', 'class' => false])
                    ->label(false) ?>

                <?= $form->field($model, 'target_id', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput()
                    ->label(false); ?>

                <?= $form->field($model, 'broker_id', ['errorOptions' => ['tag' => null]])
                    ->hiddenInput()
                    ->label(false); ?>

                <?= $form->field($model, 'phone')
                    ->textInput(['class' => 'styler', 'placeholder' => 'Telefon'])
                    ->label(false) ?>

                <?= $form->field($model, 'name')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'Navn'])
                    ->label(false) ?>

                <?= $form->field($model, 'post_number', ['errorOptions' => ['tag' => null]])
                    ->textInput(['class' => 'styler', 'placeholder' => 'Postnummer'])
                    ->label(false) ?>

                <?= $form->field($model, 'email')
                    ->textInput(['maxlength' => true, 'class' => 'styler', 'placeholder' => 'E-post'])
                    ->label(false) ?>

                <?= $form->field($model, 'subscribe_email', [
                    'template' => '{input} {label} {error}{hint}'
                ])
                    ->checkbox(['class' => 'input_check'], false)
                    ->label('Jeg ønsker å motta eiendomsrelatert informasjon (nyhetsbrev o.l.) på e-post', ['class' => 'label_check'])
                ?>

                <?= $form->field($model, 'i_agree', [
                    'template' => '{input} {label} {error}{hint}'
                ])
                    ->checkbox(['class' => 'input_check'], false)
                    ->label('Jeg har lest og godkjent <a href="/personvern" target="_blank">vilkårene</a>', ['class' => 'label_check'])
                ?>

                <?= Html::submitButton('Send', ['class' => 'order mt-4']) ?>

                <?php ActiveForm::end() ?>
            </div>
            <div class="col-12 col-md-6 order-1 order-md-2">
                <div class="box_office_info box_broker_info">
                    <div class="box_img">
                        <img src="<?= $broker->urlstandardbilde ?>" alt="<?= $broker->navn ?>">
                    </div>
                    <div class="box_text">
                        <h1><?= $broker->navn ?></h1>
                        <p><?= $broker->tittel ?></p>
                        <div class="box_info">
                            <a href="mailto:<?= $broker->email ?>"><?= $broker->email ?></a>
                            <br><a href="tel:<?= $broker->mobiltelefon ?>"><?= $broker->mobiltelefon ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>
