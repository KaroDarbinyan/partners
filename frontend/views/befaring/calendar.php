<?php
/***
 * @var CalendarEvent[] $events
 * @var PropertyEvent[] $propertyEvens
 * @var PropertyDetails $property
 */

use common\components\StaticMethods;
use common\models\ArchiveForm;
use common\models\CalendarEvent;
use common\models\Mail;
use common\models\PropertyDetails;
use common\models\PropertyEvent;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'BEFARING';
$model = new Mail();

$model->message = "Hei!\n
Takk for hyggelig befaring av din bolig!
Jeg og resten av ditt boligteam er motiverte og klare til å gå i gang med forberedelser
som gjør at vi finner de kjøperne som er på jakt etter akkurat din bolig.\n
Som avtalt sender jeg deg et forslag til en fremdriftsplan med de ulike aktivitetene som
må gjennomføres som en del av salgsprosessen.\n
Neste steg er så å signere avtale om salg av din bolig. Avtalen kan signeres på papir eller elektronisk
ved bruk av Bank-ID.\n\n\n";

if ($user = $property->user) {
    $model->from = "{$user->short_name} <{$user->email}>";
    $phone = StaticMethods::convertPhone($user->mobiltelefon);
    $from = str_repeat("\n", 3) . "{$user->short_name}\n{$user->tittel}\nTelefon: {$phone}\nE-post: {$user->email}";
} else {
    $model->from = "Partners.no <post@partners.no>";
    $from = str_repeat("\n", 4) . "PARTNERS EIENDOMSMEGLING\nwww.partners.no";
}

$from = "\n\nJeg minner også om at du i appen &quot;Mitt hjem&quot; kan følge salgsprosessen og det er også
her bilder og andre relevante dokumenter vil bli gjort tilgjengelig fortløpende.\n
Dersom du har noen spørsmål hører jeg gjerne fra deg. Jeg ser frem til et godt
samarbeid!{$from}";

$selgers = ArchiveForm::find()
    ->where(["and",
        ["target_id" => $property->id],
        ["type" => "selger"],
        ["!=", "email", ""]
    ])
    ->groupBy("email")
    ->asArray()->all();

$items = [];
foreach ($selgers as $selger) {
    $items[$selger["id"]] = "{$selger["name"]} ({$selger["email"]})";
}

?>

    <div id="calendar">
        <div class="row">
            <div class="col-md-12">
                <div id="kt_calendar">
                    <div id="event-list" tabindex="-1" role="dialog"
                         class="event-list modal fc-popover fc-more-popover">
                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                            <div class="modal-content">
                                <!--<div class="fc-header fc-widget-header">
                                <span
                                        class="fc-close fc-icon fc-icon-x"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                ></span>
                                    <span class="fc-title"></span>
                                    <div class="fc-clear"></div>
                                </div>-->
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="fc-body fc-widget-content">
                                    <div class="fc-event-container modal-events">
                                        <?php foreach ($events as $event): ?>
                                            <label data-original-title=""
                                                   class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-event-danger fc-draggable"
                                                   title="<?= $event['description']; ?>">
                                                <span class="fc-content">
                                                    <span class="fc-title custom-title"><?= $event['name']; ?></span>
                                                    <img class="event-check-mark"
                                                         src="/img/befaring/icons/event-check-mark.svg">
                                                    <?= Html::checkbox('', false, ['value' => $event['id'], 'class' => 'event-checkbox']); ?>
                                                </span>
                                            </label>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="send-email">
        <div id="send-email-modal" tabindex="-1" role="dialog"
             class="send-email-modal modal">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="fc-body fc-widget-content p-4">
                        <div id="mail-response"></div>
                        <div class="fc-event-container">
                            <?php $form = ActiveForm::begin([
                                'id' => 'mailing-form',
                                'method' => 'post',
                                'action' => '/befaring/mailing'
                            ]); ?>

                            <?= $form->field($model, 'subject')->hiddenInput(['value' => 'Subject'])->label(false); ?>

                            <?= $form->field($model, 'message')->textarea([
                                "placeholder" => "Message",
                                "style" => "resize: none",
                                "rows" => 20,
                                "data-value" => $model->message,
                                "data-from" => $from
                            ])->label(false); ?>

                            <?= $form->field($model, 'from')->hiddenInput()->label(false); ?>

                            <?php if ($selgers): ?>
                                <?= $form->field($model, 'emails')->checkboxList($items,
                                    ["itemOptions" => ["style" => "margin: 10px"]]
                                )->label(false); ?>
                                <?= Html::hiddenInput("selger", "exist"); ?>
                            <?php else: ?>
                                <?= $form->field($model, 'email')->textInput(["placeholder" => "E-post"])->label(false); ?>
                            <?php endif; ?>

                            <?php if ($property->user): ?>
                                <div class="form-group send_broker">
                                    <label>
                                        <?= Html::checkbox("send_broker", false, [
                                            "style" => "margin: 10px",
                                            'value' => $property->user->email
                                        ]); ?>
                                        <?= "{$property->user->short_name} ({$property->user->email})" ?>
                                    </label>
                                </div>
                            <?php endif; ?>

                            <label class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-event-danger fc-draggable">
                                <?= Html::submitButton('Send', ['class' => 'btn btn-success w-100']) ?>
                            </label>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php
$propertyEvens = json_encode($propertyEvens);
$events = json_encode($events);
$js = <<<JS
try {
    var events = JSON.parse('$events');
    var propertyEvens = JSON.parse('$propertyEvens');
} catch(e) {
}
JS;

echo $this->registerJs($js, View::POS_HEAD);