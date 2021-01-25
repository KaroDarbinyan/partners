<?php

use common\models\Forms;
use common\models\FreeText;
use common\models\PropertyDetails;
use frontend\widgets\PropertyGalleryWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $property PropertyDetails */
/* @var $texts FreeText[] */
/* @var $formModel Forms */

setlocale(LC_ALL, 'nb_NO.UTF-8');

$areaData = ['Primærrom' => 'prom', 'Bruksareal' => 'bruksareal', 'Bruttoareal' => 'bruttoareal', 'Tomt' => 'tomteareal'];

// TODO: move function to some helper
function area_format($area)
{
    return number_format($area, 0, ' ', ' ');
}

foreach ($areaData as $label => $attr) {
    if ($property->isParent() && $property->properties) {
        $result = ArrayHelper::getColumn($property->properties, $attr);

        $min = min($result);
        $max = max($result);

        if ($min !== $max) {
            $areaData[$label] = area_format($min) . '-' . area_format($max);
            continue;
        }
    }

    if (!$property->getAttribute($attr)) {
        unset($areaData[$label]);
        continue;
    }

    $areaData[$label] = area_format($property->getAttribute($attr));
}

$js = <<<JS
function sortTable(el, n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchCount = 0;
  
  table = document.getElementById('project-properties');
  switching = true;
  dir = 'asc';

  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName('TD')[n];
      y = rows[i + 1].getElementsByTagName('TD')[n];
      
      if (dir === 'asc') {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchCount ++;
    } else {
      if (switchCount === 0 && dir === 'asc') {
        dir = 'desc';
        switching = true;
      }
    }
    
    el.classList.remove('asc', 'desc');
    el.classList.add(dir);
  }
}
JS;

$this->registerJs($js, View::POS_HEAD);

?>

<?php $this->beginBlock('head') ?>
<?= $property->partner->head_stack ?? '' ?>
<meta property="og:type" content="website"/>
<meta property="og:title"
      content="<?= $property->prom ?>m², <?= $property->getCost() ?>, <?= $property->getTitle() ?>, <?= $property->adresse ?>"/>
<meta property="og:description" content="<?= $property->overskrift ?>"/>
<meta property="og:url" content="<?= $property->path() ?>"/>
<meta property="og:image" content="<?= $property->posterPath() ?>"/>
<meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>

<?= PropertyGalleryWidget::widget(compact('property')) ?>

<section class="property-details section_block">
  <div class="container">
    <div class="row">
      <div class="col-12 share-btn">
          <?= $this->render('@frontend/views/partials/shares.php') ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h2 class="font-weight-bold text-white"><?= $property->getTitle() ?></h2>
        <h2 class="font-weight-bold text-white"><?= $property->overskrift ?></h2>
        <h3><?= $property->adresse ?>
          , <?= sprintf('%04d', $property->postnummer) ?> <?= $property->poststed ?></h3>
      </div>
    </div>

    <div class="row">
      <!--Form buttons -->
      <div class="col-12 col-xl-4 order-1 order-xl-2 h-100">
          <?php if ($property->solgt != -1): ?>
            <div class="item_portfolio" data-click="book_visning"
                 style="background-image: url('/img/visning-min.jpg'); cursor: pointer">
              <div class="box_text">
                <h2>VISNINGER</h2>
                  <?php if ($visits = $property->propertyVisits): ?>
                      <?php foreach ($visits as $visit): ?>
                      <h4><?= strftime("%e. %B \n %A \n kl. %H:%M-", $visit['fra']) . strftime('%H:%M', $visit['til']); ?></h4>
                      <?php endforeach ?>
                  <?php else: ?>
                      <h4>Visning etter avtale med megler</h4>
                      <p class="m-auto pt-4">Husk påmelding til visning</p>
                  <?php endif ?>
              </div>
            </div>


              <?php if (!$property->isParent()): ?>
                  <?php if ($property->getPdfLinkSalgsoppgave()): ?>
                <a href="#salgsoppgave"
                   data-toggle="modal"
                   data-target="#contact-modal"
                   data-title="SALGSOPPGAVE"
                   data-type="salgsoppgave"
                   data-broker_id="<?= $formModel->broker_id ?>"
                   data-includes="contact_me, send_sms, subscribe_to_related_properties"
                   class="order order_full mb-3 tac">KOMPLETT <br>SALGSOPPGAVE</a>
                  <?php endif ?>
              <?php endif ?>

            <a href="#book_visning"
               data-toggle="modal"
               data-target="#contact-modal"
               data-title="MELD DEG PÅ VISNING"
               data-type="book_visning"
               data-includes="booking_date, message, book_visning, contact_me, send_sms, subscribe_to_related_properties, <?php if ($property->getPdfLinkSalgsoppgave()): ?>download_sales_report<?php endif ?>"
               class="order order_full mb-3">MELD DEG PÅ VISNING</a>

              <?php if (!$property->isParent()): ?>
              <div class="row my-3">
                <div class="col-6">
                  <a href="<?= $property->urlelektroniskbudgivning ?>" target="_blank"
                     class="order order_full">GI BUD</a>
                </div>
                <div class="col-6">
                  <a href="#budvarsel"
                     data-toggle="modal"
                     data-target="#contact-modal"
                     data-title="BUDVARSEL"
                     data-includes="contact_me, subscribe_to_related_properties"
                     data-type="budvarsel"
                     class="order order_full">BUDVARSEL</a>
                </div>
              </div>
              <a href="#salgssum"
                 data-toggle="modal"
                 data-target="#contact-modal"
                 data-title="BE OM SALGSSUM"
                 data-includes="subscribe_to_related_properties"
                 data-type="salgssum_venter"
                 class="order order_full mb-5">BE OM SALGSSUM</a>
              <?php endif ?>
          <?php else: ?>
            <a href="#salgssum"
               data-toggle="modal"
               data-target="#contact-modal"
               data-title="BE OM SALGSSUM"
               data-includes="subscribe_to_related_properties"
               data-type="salgssum_venter"
               class="order order_full mb-5">BE OM SALGSSUM</a>
          <?php endif ?>

        <div class="card-deck brokers-deck">
            <?php foreach ($property->getBrokers() as $broker): ?>
              <div class="card broker-card">
                <a href="<?= Url::toRoute(['company/broker', 'navn' => $broker->url]) ?>">
                  <img src="<?= $broker->urlstandardbilde ?>" class="card-img-top"
                       alt="<?= $broker->navn ?>">
                </a>
                <div class="card-body">
                  <h5 class="card-title">
                      <?= $broker->navn ?>
                    <small class="broker-title d-block"><?= $broker->tittel ?></small>
                  </h5>
                  <ul class="card-text">
                    <li><a href="tel:<?= $broker->mobiltelefon ?>"><?= $broker->mobiltelefon ?></a></li>
                    <li><a href="mailto:<?= $broker->email ?>"><?= $broker->email ?></a></li>
                  </ul>
                </div>
                <div class="card-footer">
                  <a href="#verdivurdering-<?= $broker->web_id ?>"
                     data-toggle="modal"
                     data-target="#contact-modal"
                     data-title="VERDIVURDERING"
                     data-type="verdivurdering"
                     data-includes="message"
                     data-broker_id="<?= $broker->web_id ?>"
                     class="order order_full text-sm">VERDIVURDERING</a>
                </div>
              </div>
            <?php endforeach ?>
        </div>


          <?php if ($property->percentTexts && $percentTextsCount = count($property->percentTexts)): ?>
            <h2 class="box-percent-header">NABOLAGSPROFIL</h2>
            <div class="row">
                <?php for ($i = 0; $i < ($percentTextsCount > 5 ? 5 : $percentTextsCount); $i++): $item = $property->percentTexts[$i] ?>
                  <div class="col mb_30">
                    <div class="box_percent">
                      <div class="percent"><span class="orange"><?= $item['value'] ?></span>%</div>
                      <p><?= $item['name'] ?></p>
                    </div>
                  </div>
                <?php endfor; ?>
                <?php if ($property->nabolagsprofilLink): ?>
                  <div class="col mb_30">
                    <a href="<?= $property->nabolagsprofilLink->url ?>" target="_blank"
                       class="order order_full">SE MER <br>DETALJERT
                      <br>STATISTIKK</a>
                  </div>
                <?php endif ?>
            </div>
          <?php endif ?>
      </div>

      <div class="col-12 col-xl-8 order-2 order-xl-1 h-100">
        <div class="row">
          <div class="col-12 col-md-6 item_block">
            <table class="mb_30">
              <tr>
                <td class="font-weight-bold text-white">Type / Eierform</td>
                <td><?= $property->type_eiendomstyper ?> / <?= $property->type_eierformbygninger ?></td>
              </tr>
                <?php foreach ($areaData as $label => $v): ?>
                  <tr>
                    <td class="font-weight-bold text-white"><?= $label ?></td>
                    <td><?= trim($v) ?>
                      m² <?php if ($label === 'Tomt'): ?>/ <?= $property->type_eierformtomt ?><?php endif ?></td>
                  </tr>
                <?php endforeach ?>
            </table>
            <table class="mb_30">
                <?php if ($property->oppholdsrom): ?>
                  <tr>
                    <td class="font-weight-bold text-white">Oppholdsrom</td>
                    <td><?= $property->oppholdsrom ?></td>
                  </tr>
                <?php endif ?>
                <?php if ($property->soverom): ?>
                  <tr>
                    <td class="font-weight-bold text-white">Soverom</td>
                    <td><?= $property->soverom ?></td>
                  </tr>
                <?php endif ?>
                <?php if ($property->byggeaar): ?>
                  <tr>
                    <td class="font-weight-bold text-white">Byggeår</td>
                    <td><?= $property->byggeaar ?></td>
                  </tr>
                <?php endif ?>
              <tr>
                <td class="font-weight-bold text-white">Gårdsnummer</td>
                <td><?= $property->gaardsnummer ?></td>
              </tr>
              <tr>
                <td class="font-weight-bold text-white">Bruksnummer</td>
                <td><?= $property->bruksnummer ?></td>
              </tr>
                <?php if ($property->energimerke_bokstav): ?>
                  <tr>
                    <td class="font-weight-bold text-white">Energimerking</td>
                    <td><?= $property->energimerke_bokstav ?></td>
                  </tr>
                <?php endif ?>
                <?php if ($property->propertyAds): ?>
                  <tr>
                    <td class="font-weight-bold text-white">FINN.no</td>
                    <td>
                      <a href="https://www.finn.no/realestate/<?= $property->isNewBuilding() ? 'newbuildings' : 'homes' ?>/ad.html?finnkode=<?= $property->propertyAds->finn_adid ?>"
                         target="_blank" style="text-decoration: underline; color: white;">
                          <?= $property->propertyAds->finn_adid ?>
                      </a>
                    </td>
                  </tr>
                <?php endif ?>
              <tr>
                <td class="font-weight-bold text-white">Sist endret</td>
                <td><?= date('d.m.Y H:i', $property->endretdato) ?></td>
              </tr>
            </table>
          </div>
          <div class="col-12 col-md-6 mb-5 item_block">
            <table class="mb_30">
              <tr>
                <td class="font-weight-bold text-white">Prisantydning</td>
                <td class="tar"><?= $property->getCost() ?></td>
              </tr>
              <tr>
                <td class="font-weight-bold text-white">Totalpris</td>
                <td class="tar"><?= $property->getTotalCost() ?></td>
              </tr>
            </table>

              <?php if ($property->ligningsverdi): ?>
                <table class="mb_30">
                  <tr>
                    <td class="font-weight-bold text-white">Ligningsverdi</td>
                    <td class="tar"><?= money($property->ligningsverdi) ?></td>
                  </tr>
                </table>
              <?php endif ?>

              <?php if ($property->totalkostnadsomtekst && !$property->isParent()): ?>
                <p><b>Beregnet totalkostnad</b></p>
                <p style="white-space: pre-line"><?= $property->totalkostnadsomtekst ?></p>
              <?php endif ?>
          </div>
        </div>

          <?php if ($property->properties): ?>
            <h4>Boliger</h4>
            <div class="table-responsive">
              <table id="project-properties" class="table table-sm table-borderless mb-4 table-properties">
                <thead>
                <tr>
                  <th scope="col" onclick="sortTable(this, 0)" class="sortable">Bolig</th>
                  <th scope="col">Soverom</th>
                  <th scope="col">Etg</th>
                  <th scope="col">P-rom</th>
                  <th scope="col">BRA</th>
                  <th scope="col">Prisantydning</th>
                  <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($property->properties as $prop): ?>
                  <tr>
                    <td>
                      <a href="<?= $prop->path() ?>"><?= $prop->bruksenhetsnummer ?? $prop->oppdragsnummer ?></a>
                    </td>
                    <td><?= $prop->soverom ?></td>
                    <td><?= $prop->etasje ?></td>
                    <td><?php if ($prop->prom): ?><?= $prop->prom ?> m<sup>2</sup><?php endif ?></td>
                    <td><?= $prop->bruksareal ?> m<sup>2</sup></td>
                    <td><?= $prop->isSold() ? 'Solgt' : money($prop->prisantydning) ?></td>
                    <td>
                      <div class="d-flex items-stretch">
                        <a href="<?= $prop->path() ?>" class="order order_full mr-2">Les mer</a>
                        <a href="<?= $prop->urlelektroniskbudgivning ?>" target="_blank"
                           class="order order_full">GI BUD</a>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
                </tbody>
              </table>
            </div>
          <?php endif ?>

        <div class="item_block">
            <?php foreach ($texts as $title => $paragraphs): ?>
              <p>
                <b><?= $title ?></b>
                  <?php foreach ($paragraphs as $paragraph): ?>
                      <?= clean($paragraph->htmltekst) ?><br>
                  <?php endforeach ?>
              </p>
            <?php endforeach ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
          <?php if ($property->solgt != -1 && $pdfLink = $property->getPdfLinkSalgsoppgave()): ?>
              <?= Html::a(
    'LAST NED KOMPLETT SALGSOPPGAVE',
    $pdfLink,
    [
                      'class' => 'order mb-4 download-pdf',
                      'download' => $pdfLink,
                      'target' => "_blank"
                  ]
) ?>
          <?php endif ?>
      </div>
    </div>
  </div>
</section>

<?= $this->render('@frontend/views/partials/contactModal.php', [
    'model' => $formModel,
]) ?>
