<?php


use common\models\Forms;
use yii\web\View;

/* @var $this View */
/* @var $model Forms */

?>
<?php $this->beginBlock('page_header') ?>
<header class="header bg_img bg_overlay"
        data-background="/img/<?= isset($this->params["meglerbooking_bg"]) ? $this->params["meglerbooking_bg"] : "header_contact_bg.jpg" ?>">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2">
                <h1 class="align-center"><?= Yii::$app->view->params['header'] ?></h1>
                <h4 class="align-center">Book oss når det passer deg best – enkelt og praktisk – til en uforpliktende
                    prat med en av våre lokalkjente Partners-meglere. Vi tilbyr deg profesjonelle råd om kjøp og salg av
                    bolig. Fyll ut skjemaet nedenfor, så kontakter vi deg så raskt vi kan. Vi gleder oss til å ta en
                    prat eller komme på besøk til deg.</h4>
                <?= $this->render($this->params["render_form"], [
                    'model' => $model,
                    'showMessage' => false
                ]) ?>
            </div>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?php


$this->registerCssFile("@web/css/bootstrap-datetimepicker4.css");
$this->registerCss("
    .datetimepicker {
        font-size: 15px !important;
        font-weight: bold;
        background: #0a0a0a;
        color: white;
        border: 1px solid #999;
    }
    
    .datetimepicker::after {
        display: none;
    }

    .booking_date {
        position: absolute;
        top: -25px;
    }

    table {
        width: 100%
    }
    
    .datetimepicker .form-control:disabled, .form-control[readonly] {
        background: #0a0a0a !important;
     }

    #forms-megler_booking_date {
        cursor: pointer;
    }
    
    span.hour.disabled {
        display: none;
    }
    
    .datetimepicker table tr td.disabled, .datetimepicker table tr td.disabled:hover {
        opacity: 0.3 !important;
        text-decoration: line-through !important;
        cursor: not-allowed !important;
    }
    
");

?>

