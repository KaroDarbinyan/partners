<?php

/* @var $this View */

/* @var $model Forms */

use common\models\Forms;
use yii\helpers\Url;
use yii\web\View;

?>

<?php $this->beginBlock('head') ?>
<meta property="og:type" content="website"/>
<meta property="og:title" content="VERDIVURDERING AV DITT HJEM"/>
<meta property="og:description"
      content="Lang og bred erfaring, sammen med best mulig eksponering av din bolig i riktige kanaler,
       sørger for at du som kunde oppnår best mulig pris. Megleren fra Partners ivaretar deg gjennom
        hele salgsprosessen, og sikrer deg en trygg og god handel."/>
<meta property="og:url" content="<?= Url::current([], true); ?>"/>
<meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
<meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay" data-background="/img/header_contact_bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="align-center uppercase regular">Verdivurdering <span
                            class="xs-hidden light">av ditt hjem</span></h1>
                <h4 class="align-center">Fyll ut skjema, så kontakter vi deg i løpet av kort tid</h4>
                <?= $this->render('@frontend/views/partials/valuationForm.php', [
                    'model' => $model,
                    'showMessage' => false
                ]) ?>
                <p class="center">Lang og bred erfaring, sammen med best mulig eksponering av din bolig i riktige
                    kanaler, sørger for at du som kunde oppnår best mulig pris. Megleren fra Partners ivaretar deg
                    gjennom hele salgsprosessen, og sikrer deg en trygg og god handel.</p>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?> 
