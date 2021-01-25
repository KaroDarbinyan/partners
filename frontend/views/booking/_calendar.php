<?php

use common\models\Forms;
use edofre\fullcalendar\Fullcalendar;
use yii\web\JsExpression;

/* @var $model Forms */
/* @var $showMessage bool */

?>

<h2><b>Book megler nå</b></h2>
<div class="row">
    <div class="col-10 offset-1">
        <?= Fullcalendar::widget([
            "options" => [
                "id" => "calendar",
                "language" => "no",
            ],
            "header" => [
                "center" => false,
                "left" => "title",
                "right" => "prev,next"
            ],
            "clientOptions" => [
                "weekNumbers" => true,
                "selectable" => true,
                "dayClick" => new JsExpression("
                    function(moment) {
                    console.log(moment)
                        $.ajax({
                            url: window.location.pathname,
                            type: 'GET',
                            data: {
                                'date': moment.unix()
                            },
                            success: function () {
                                window.location.href = '/booking/information';
                            }
                        });
                    }
            "),

            ],
        ]); ?>

    </div>
</div>
<br>
<div class="mt-5 navigate-container">
<!--    <button class="order float-right" data-url="/booking/information">Neste steg</button>-->
    <button class="order" data-url="/booking/tjenester">Gå tilbake</button>
</div>