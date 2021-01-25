<?php

/* @var $this yii\web\View */
/** @var $lead common\models\Forms */
/** @var $partners common\models\Partner[] */
/** @var $logModel common\models\LeadLog */
/** @var $lastLog common\models\LeadLog */
/** @var $logs \yii\data\ArrayDataProvider */
/** @var $customLogs array */
/** @var $actions array */
/** @var $office array */
/** @var $id array */

/** @var $allDeps \common\models\partner[] */

use backend\assets\AppAsset;
use backend\components\UrlExtended;
use common\components\Befaring;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

$this->title = 'Detaljer';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">' . ($lead->isHot() ? 'Hot clients' : 'Cold clients') . '</span>',
    'url' => UrlExtended::toRoute([$lead->isHot() ? 'clients/hot' : 'clients/cold']),
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
    '//maps.google.com/maps/api/js?key=AIzaSyBigZy49qUlMNHKyai6MSjdMW3Bl-p2HqM&callback=initMap',
    [
        'depends' => AppAsset::className(),
        'async' => true, 'defer' => true
    ]
);
$this->registerJsFile('@web/js/google-maps.js', ['depends' => [AppAsset::className()]]);
$postNumber = $lead->post_number;
Befaring::numFormat($postNumber);

$details = [
    'Navn' => "<span data-field='name' contenteditable='true'>{$lead->name}</span>",
    'Vedr. adresse' => '',
    'Postadresse' => '<span data-field="post_number" contenteditable="true">' . $postNumber . '</span>',
    'Telefon' => "<a href='tel:" . $lead->phone . "'>$lead->phone</a>" . Html::img("/admin/images/sms.svg", [
            "data-toggle" => "modal",
            "data-target" => "#send_sms",
            "class" => "float-right lead-contact",
            "data-id" => $lead->id,
            "data-type" => "sms",
            "title" => "Send Sms"
        ]),
    'E-post' => "<a href='mailto:$lead->email' data-field='email'>$lead->email</a>" . (
        $lead->email && !empty($lead->email) ? Html::img("/admin/images/mail.svg", [
            "data-toggle" => "modal",
            "data-target" => "#send_email",
            "class" => "float-right lead-contact",
            "data-id" => $lead->id,
            "data-type" => "mail",
            "title" => "Send E-post"
        ]) : ""
    ),
    'Ønsker tid' => $lead->booking_date ? substr($lead->booking_date, -5) : "",
    'Adresse' => '<span data-field="address" contenteditable="true">' . $lead->address . '</span>',
    'Kommentar' => $lead->message ? str_replace('Kommentar:', '', $lead->message) : '',
    'Oppdragsnummer' => '',
];

if ($lead->propertyDetails) {
    $details['Oppdragsnummer'] = '<div class="flex">
        <a href="' . UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $lead->propertyDetails->id]) . '">' . $lead->propertyDetails->oppdragsnummer . '</a>
        <span class="schala-status">
            <span class="m-badge m-badge--dot schala-status-' . ($lead->propertyDetails->solgt == -1 ? 'solgt' : 'selger') . '"></span>
            <em>' . $lead->propertyDetails->tinde_oppdragstype . '</em>
        </span>
    </div>';
} else {
    unset($details['Oppdragsnummer']);
}

if (!$lead->isHot() && $lead->propertyDetails) {
    $details['Vedr. adresse'] = $lead->propertyDetails->adresse;
} else {
    unset($details['Vedr. adresse']);
}

if (!$lead->isHot() || empty($lead->address)) {
    unset($details['Adresse']);
}

if (!$lead->booking_date) {
    unset($details['Ønsker tid']);
}

$actionsData = [
    'delegate' => [
        'class' => "dropdown-item",
        'href' => '#',
        'data-toggle' => "modal",
        'data-target' => "#m_modal_delegere",
        'data-backdrop' => 'static',
        'label' => "Delegere",
    ],
    'log' => [
        'class' => "dropdown-item",
        'href' => '#',
        'data-toggle' => "modal",
        'data-target' => "#m_modal_loggforing",
        'data-backdrop' => 'static',
        'label' => "Loggføring",
    ],
    'create_hot_lead' => [
        'class' => "dropdown-item",
        'href' => UrlExtended::toRoute(['clients/create', 'id' => $lead->id]),
        'label' => "Cold -> Hot",
    ],
    'delete' => [
        'class' => "dropdown-item",
        'href' => '#',
        'data-toggle' => "modal",
        'data-target' => "#m_modal_delete_lead",
        'label' => "Fjerne"
    ],
];


if (array_key_exists('fjernet', ArrayHelper::map($logs->allModels, 'type', 'type'))
    || !$lead->delegated || $lead->delegated != Yii::$app->user->identity->web_id) {
    unset($actionsData['delete']);
}

foreach ($actionsData as $n => $action) {
    if (!in_array($n, $actions)) {
        unset($actionsData[$n]);
    }
}

?>

<div class="m-grid__item m-grid__item--fluid m-wrapper">

  <div class="m-content">

    <div class="row">
      <div class="col-lg-12">
        <ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--danger" role="tablist">
          <li class="nav-item m-tabs__item">
            <a href="<?= UrlExtended::toRoute(['clients/detaljer', 'id' => $id]) ?>"
               class="nav-link m-tabs__link active">Detaljer</a>
          </li>
          <li class="nav-item m-tabs__item">
            <a href="<?= UrlExtended::toRoute(['clients/info', 'id' => $lead->client_id]) ?>"
               class="nav-link m-tabs__link">Client</a>
          </li>
            <?php if (false): ?>
              <li class="nav-item m-tabs__item">
                <a href="<?= UrlExtended::toRoute(['/clients/potensielle/']) ?>" class="nav-link m-tabs__link">Potensielle
                  interessenter <sup
                          class="colorstd">2 650</sup></a>
              </li>
              <li class="nav-item m-tabs__item">
                <a href="<?= UrlExtended::toRoute(['/clients/solgte/']) ?>" class="nav-link m-tabs__link">Solgte i
                  nærheten <sup
                          class="colorstd">432</sup></a>
              </li>
            <?php endif; ?>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-5">
        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                                    <span class="schala-status">
                                        <span
                                                class="
                                                m-badge m-badge-xxl m-badge--dot
                                                schala-type-<?= $lead->type ?>
                                            "
                                        ></span>
                                        <em><?= $lead->type ?></em>
                                    </span>
                </h3>
              </div>
            </div>
            <div class="m-portlet__head-tools">

              <!--<button class="btn btn-success m-btn" type="button">
                  Søk i eiendomsverdi
              </button>-->

                <?php if ($lead->isOwner()): ?>
                  <div class="form-group pt-4">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                      <input class="lead-favorite" type="checkbox" <?= $lead->favorite ? 'checked' : '' ?>
                             data-id="<?= $lead->id ?>">
                      Legg til favoritter
                      <span></span>
                    </label>
                  </div>
                <?php endif ?>
            </div>
          </div>
          <div class="m-portlet__body">

            <!--begin::Section-->
            <div class="">
              <div class="m-section__content">
                <table class="table m-table m-table--head-no-border table-hover editable"
                       data-action="<?= \yii\helpers\Url::toRoute(['leads/update', 'id' => $lead->id]) ?>">
                  <tbody>
                  <?php foreach ($details as $label => $detail) { ?>
                    <tr>
                      <th scope="row"><?= $label ?></th>
                      <td><?= $detail ?></td>
                    </tr>
                  <?php } ?>
                  </tbody>
                </table>

                  <?php /* <div id="map" style="height:300px;"></div> */ ?>

              </div>
            </div>

            <!--end::Section-->
          </div>
        </div>

        <div class="d-flex d-md-none justify-content-center mb-3">
          <a class="js-lead-contact text-decoration-none"
             data-id="<?= $lead->id ?>"
             data-type="Har ringt"
             href="tel:<?= $lead->phone ?>"
             title="Ring"><?= Html::img("/admin/images/phone.svg"); ?>
          </a>

          <a class="js-lead-contact text-decoration-none"
             data-id="<?= $lead->id ?>"
             data-type="Sendte sms"
             href="sms:<?= $lead->phone ?>"
             title="Send Sms"><?= Html::img("/admin/images/sms.svg"); ?>
          </a>
        </div>

          <?php if ($property = $lead->propertyDetails): ?>
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                  <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text text-white">
                      Info om <?= $property->oppdragsnummer ?>
                    </h3>
                  </div>
                </div>
                <div class="m-portlet__head-tools"></div>
              </div>
              <div class="m-portlet__body">
                <div>
                  <div class="m-section__content">
                    <table class="table m-table m-table--head-no-border table-hover">
                      <tbody>
                      <tr>
                        <th scope="row">Veinavn</th>
                        <td><?= $property->adresse ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Postadresse</th>
                        <td>
                            <?= $property->postnummer ?>
                            <?= $property->poststed ?>
                        </td>
                      </tr>
                      <tr>
                        <th scope="row">Primærrom</th>
                        <td><?= $property->prom ?> m<sup>2</sup></td>
                      </tr>
                      <tr>
                        <th scope="row">Byggeår</th>
                        <td><?= $property->byggeaar ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Eiertype</th>
                        <td><?= $property->type_eierformbygninger ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Borettslag</th>
                        <td><?= $property->borettslag ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Oppdragsnummer</th>
                        <td><a href="/eiendom/<?= $property->id ?>"
                               target="_blank"><?= $property->oppdragsnummer ?></a></td>
                      </tr>

                      <?php if ($parent = $property->parent): ?>
                        <tr>
                          <th>Hovedannonse</th>
                          <td>
                            <a href="<?= UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $parent->id]) ?>">
                                <?= $parent->oppdragsnummer ?>
                            </a>
                          </td>
                        </tr>
                      <?php endif ?>

                      <tr>
                        <th>Megler</th>
                        <td>
                            <?php foreach ($property->getBrokers() as $broker): ?>
                              <p><img src="<?= $broker->urlstandardbilde; ?>"
                                      class="m--img-rounded m--marginless table-schala-img" alt="">
                                <span class="table-schala-time"><?= $broker->navn ?></span>
                                <span class="table-schala-time-ago"><?= $broker->department->short_name ?></span>
                              </p>
                            <?php endforeach ?>
                        </td>
                      </tr>
                      <?php if (isset($property->propertyAds)): ?>
                        <tr>
                          <td class="font-weight-bold text-white">FINN.no</td>
                          <td>
                            <a href="https://www.finn.no/realestate/homes/ad.html?finnkode=<?= $property->propertyAds->finn_adid ?>"
                               target="_blank" style="text-decoration: underline; color: white;">
                                <?= $property->propertyAds->finn_adid ?>
                            </a>
                          </td>
                        </tr>
                      <?php endif ?>

                      <?php if ($pdfLink = $property->getPdfLinkSalgsoppgave()): ?>
                        <tr>
                          <td class="text-center" colspan="2">
                            <a href="<?= $pdfLink ?>" download="<?= $pdfLink ?>" target="_blank">
                              Last ned komplett salgsoppgave
                            </a>
                          </td>
                        </tr>
                      <?php endif ?>
                      </tbody>
                    </table>
                      <?php if ($property->propertyImage): ?>
                        <div class="oppdrag-gallery">
                          <div class="m-section__content">
                            <img src="<?= $property->propertyImage->urlstorthumbnail ?>">
                          </div>
                        </div>
                      <?php endif ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endif ?>

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
          <div class="m-portlet__body">


            <!--begin::Section-->
            <div class="">
              <div class="m-section__content">
                <h5>Samtykker</h5>
                <div class="m-form__group form-group">
                    <?php //TODO: convert to loop read from model attributes?>
                  <div class="m-checkbox-list">
                    <!-- Render Update client form -->
                      <?= $this->render('_form', [
                          'lead' => $lead,
                          'client' => $lead->client,
                      ]) ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="col-lg-7">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
          <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
              <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                                    <span class="schala-status">
                                        <span class="m-badge m-badge-xxl m-badge--dot schala-status-<?= $lastLog->type ?>"></span>
                                        <em><?= $lastLog->type ?></em>
                                    </span>
                </h3>
              </div>
            </div>

            <div class="m-portlet__head-tools">
              <div class="dropdown right">
                <button class="btn btn-success m-btn dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" style="min-width: 10rem;">
                  Handlinger
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <?php foreach ($actionsData as $action) { ?>
                      <a <?php foreach ($action as $k => $v) {
                          echo " {$k}='{$v}' ";
                      } ?>>
                          <?= $action['label'] ?>
                      </a>
                    <?php } ?>
                </div>
              </div>

            </div>

          </div>
          <div class="m-portlet__body">

            <!--begin::DETAILS-->
            <div class="">
              <div class="m-section__content">
                  <?= ListView::widget([
                      'dataProvider' => $logs,
                      'itemView' => '_log',
                      'layout' => '
                                        <table class="table m-table m-table--head-no-border table-hover table-cell-center logs-table">
                                            <thead class="thead-default">
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Beskrivelse</th>
                                                    <th>Tidspunkt</th>
                                                </tr>
                                            </thead>
                                            <tbody>{items}</tbody>
                                        </table>
                                    ',
                  ]) ?>
              </div>
            </div>
          </div>
        </div>

          <?php $oppdrag = $lead->propertyDetails;
          if ($oppdrag && $oppdrag->solgt === -1): ?>
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
              <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                  <div class="" style="margin-top: 15px;">
                    <h4 style="color: white;">
                      Statistikk for <?= $oppdrag->oppdragsnummer ?>
                    </h4>
                  </div>
                </div>
              </div>
              <div class="m-portlet__body">

                <!--begin::Section-->
                <div class="">
                  <div class="m-section__content">
                    <table class="table m-table m-table--head-no-border table-hover">
                      <tbody>
                      <tr>
                        <th scope="row">Adresse</th>
                        <td><?= $oppdrag->adresse; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Salgstid</th>
                        <td><?= $oppdrag->markedsforingsdato !== 0 ? round((strtotime(date($oppdrag->akseptdato)) - $oppdrag->markedsforingsdato) / (86400)) . ' dager' : '-'; ?></td>
                      </tr>
                      <?php if ($oppdrag->prom): ?>
                        <tr>
                          <th scope="row">Kvadratmeterpris</th>
                          <td><?= number_format($oppdrag->salgssum / $oppdrag->prom, 0, '', ' '); ?>,-
                          </td>
                        </tr>
                      <?php endif; ?>
                      <tr>
                        <th scope="row">Prisantydning</th>
                        <td><?= number_format($oppdrag->prisantydning, 0, '', ' '); ?>,-</td>
                      </tr>
                      <tr>
                        <th scope="row">Salgssum</th>
                        <td><?= number_format($oppdrag->salgssum, 0, '', ' '); ?>,-</td>
                      </tr>
                      <tr>
                        <th scope="row">Oppdragsdato</th>
                        <td><?= date('j. F Y', $oppdrag->oppdragsdato); ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Markedsføringsdato</th>
                        <td><?= $oppdrag->markedsforingsdato !== 0 ? date('j. F Y', $oppdrag->markedsforingsdato) : '-'; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Akseptdato</th>
                        <td><?= date('j. F Y', strtotime(date($oppdrag->akseptdato))); ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Befaringsdato</th>
                        <td><?= $oppdrag->befaringsdato !== '' ? date('j. F Y', strtotime(date($oppdrag->befaringsdato))) : '-'; ?></td>
                      </tr>
                      <tr>
                        <th scope="row">Over prisantydning</th>
                        <td><?= $oppdrag->salgssum ? round(($oppdrag->salgssum - $oppdrag->prisantydning) * 100 / $oppdrag->salgssum, 1) : 0 ?>
                          %
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>

      </div>

    </div>


  </div>
</div>

<div class="modal fade show" id="m_modal_loggforing" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Loggføring</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <?php if ($lead->user): ?>
            <div class="m-accordion m-accordion--bordered m-accordion--solid" id="m_accordion_4" role="tablist">
                <?php
                $form = ActiveForm::begin([
                    'id' => 'add_log-form',
                    'fieldConfig' => [
                        'options' => [
                            'tag' => false,
                        ],
                    ],
                    'action' => UrlExtended::toRoute(['clients/add_log', 'id' => $lead->id]),
                    'options' => ['method' => 'post']
                ]); ?>

              <div class="form-group jq-selectbox styler">
                  <?= $form->field($logModel, 'type')->dropDownList(
                    $customLogs,
                    [
                          'class' => 'form-control styler is-logs-type',
                          'label' => false
                      ]
                ); ?>
              </div>

              <div class="form-group">
                  <?= $form->field($logModel, 'message')->textarea([
                      'class' => 'form-control styler'
                  ])->label('Beskjed') ?>
              </div>

              <div class="form-group is-for-notify">
                  <?= $form->field($logModel, 'notify_at')->textInput([
                      'class' => 'form-control styler is-datetimepicker',
                      'autocomplete' => 'off'
                  ])->label('Varsling kl.') ?>
              </div>

              <!--<div class="form-group jq-selectbox styler is-for-notify">
                            <?= $form->field($logModel, 'inform_in_advance')
                  ->dropDownList(
                      [
                      '1 hours' => '1 time',
                      '2 hours' => '2 timer',
                      '3 hours' => '3 timer',
                      '1 days' => '1 dag',
                      '2 days' => '2 dager',
                      '3 days' => '3 dager',
                  ],
                      [
                          'class' => 'form-control styler',
                          'label' => false
                      ]
                  ); ?>
                        </div>-->

                <?php if ($lead->isOwner()): ?>
                  <div class="form-group" style="display: none">
                    <label class="m-checkbox m-checkbox--solid m-checkbox--success">
                      <input class="favorite-checkbox" type="checkbox" name="favorite" checked>
                      Legg til favoritter
                      <span></span>
                    </label>
                  </div>
                <?php endif ?>

                <?= Html::submitButton('Lagre', ['class' => 'btn btn-dark']) ?>

                <?= $form->field($lead, 'id')->hiddenInput()->label(false); ?>

                <?php ActiveForm::end(); ?>
            </div>
          <?php else: ?>
            Du må delegere leaden først!
          <?php endif ?>
      </div>

      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<?php $modalFooter = !$allDeps ? ListView::widget([
    'dataProvider' => $partners,
    'itemView' => '_partnerList',
    'viewParams' => ['lead' => $lead,],
    'layout' => '
        <h5>Eller videresend til</h5>
        {items}
    ',
]) : '' ?>

<?= $partners ? ListView::widget([
    'dataProvider' => $partners,
    'itemView' => '_partnerOption',
    'viewParams' => ['leadId' => $lead->id, 'delegated' => $lead->broker_id],
    'layout' => '
        <div class="modal fade show" id="m_modal_delegere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delegere</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="m-accordion m-accordion--bordered m-accordion--solid" id="m_accordion_4" role="tablist">
                            {items}
                        </div>
                    </div>
                    <div class="modal-footer special">' .
        $modalFooter . '
                    </div>
                </div>
            </div>
        </div>
    ',
]) : '' ?>

<div class="modal fade" id="m_modal_delete_lead" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header p-2">
        <h5 class="modal-title ml-2" id="exampleModalLabel">Slette</h5>
        <button type="button" class="close p-3 mt-0 text-danger" data-dismiss="modal"
                style="opacity: 1; text-shadow: unset;"
                aria-label="Close">
          <span aria-hidden="true" class="shadow-none">×</span>
        </button>
      </div>
      <div class="modal-body p-3"><span class="h4">Er du sikker at du vil fjerne ?</span></div>
      <div class="modal-footer border-0 p-3">
        <button type="button" class="btn btn-danger btn-sm float-right js-soft-delete-form" data-dismiss="modal"
                aria-label="Close"
                data-form-id="<?= $lead->id; ?>">
          <span aria-hidden="true">Ja</span>
        </button>
        <button type="button" class="btn btn-sm btn-success float-right" data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">Nei</span>
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->render("modal/_mail", compact("lead")); ?>
<?= $this->render("modal/_sms", compact("lead")); ?>


<button type="button" id="open-modal" class="btn btn-info btn-lg d-none" data-toggle="modal"
        data-target="#myModal"></button>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #2b2b2b">
      <div class="modal-body">
        <h3 class="text-center text-success">Vellykket sendt</h3>
      </div>
      <div class="modal-footer" style="border-top: none">
        <button type="button" class="btn btn-default m--block-center" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



