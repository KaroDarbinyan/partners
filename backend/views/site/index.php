<?php

/* @var $this yii\web\View */
/* @var $visitsPreview PropertyVisits[] */
/* @var $propertyDetails PropertyDetails[] */
/* @var $visits PropertyVisits[] */
/* @var $portletBlocks PropertyDetails[] */
/* @var $properties array */
/* @var $accordion array */

/* @var $leadsBlock array */
/** @var $activeEvents array */

use backend\components\UrlExtended;
use common\models\PropertyDetails;
use common\models\PropertyVisits;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Dashboard';
Pjax::begin([
    'formSelector' => '[data-active-form-header]',// this form is submitted on change
    'submitEvent' => 'change',
]);

$user = Yii::$app->user->identity;

?>

<?php Pjax::end(); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal" data-src="https://player.vimeo.com/video/400559461" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>
        <!--Begin::Section-->
        <div class="row">
            <div class="col-xl-12 col-sm-12">
                <div class="m-portlet first-last-radius">
                    <div class="m-portlet__body  m-portlet__body--no-padding block-dashboard-stats">
                        <div class="row m-row--no-padding m-row--col-separator-xl">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-xl-12">
                                <div class="m-widget24">
                                    <div class="row pl-3 pr-3">
                                        <div class="col-xs-5 col-sm-12 col-md-5 col-xl-4 d-flex justify-content-start">
                                            <select id="user-income-year" class="selectpicker" data-size="4"
                                                    data-style="btn-success">
                                                <?php $curentYear = date('Y');
                                                for ($i = $curentYear; $i >= 2015; $i--): ?>
                                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                            <select id="user-income-month" class="selectpicker" data-size="4"
                                                    data-style="btn-success">
                                            </select>
                                            <?php if (!$user->hasrole('broker')): ?>
                                                <div style="padding: 20px 0">
                                                    <button class="btn btn-success" data-toggle="modal"
                                                            data-target="#m_modal_delegere">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="user-income">
                            <div class="row m-row--no-padding m-row--col-separator-xl">
                                <div class="col-xs-3 col-sm-3 col-md-3 col-xl-3 befaringer">
                                    <!--begin::New Users-->
                                    <a href="<?= UrlExtended::toRoute(['statistikk/befaringer']) ?>">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Befaringer</h4>
                                                <span class="m-widget24__stats">0%</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-info" role="progressbar"></div>
                                                </div>
                                                <span class="m-widget24__change">Total</span>
                                                <span class="m-widget24__number">0 / 0</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!--end::New Users-->
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-xl-3 signeringer">
                                    <!--begin::New Users-->
                                    <a href="<?= UrlExtended::toRoute(['statistikk/signeringer']) ?>">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Signeringer</h4>
                                                <span class="m-widget24__stats">0%</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-info" role="progressbar"></div>
                                                </div>
                                                <span class="m-widget24__change">Total</span>
                                                <span class="m-widget24__number">0 / 0</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!--end::New Users-->
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-xl-3 salg">
                                    <!--begin::New Users-->
                                    <a href="<?= UrlExtended::toRoute(['statistikk/salg']) ?>">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">Salg</h4>
                                                <span class="m-widget24__stats">0%</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-info" role="progressbar"></div>
                                                </div>
                                                <span class="m-widget24__change">Total</span>
                                                <span class="m-widget24__number">0 / 0</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!--end::New Users-->
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-xl-3 provisjon">
                                    <!--begin::New Users-->
                                    <a href="<?= UrlExtended::toRoute(['statistikk/provisjon']) ?>">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title">
                                                    Provisjon </h4>
                                                <span class="m-widget24__stats">0%</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar m--bg-info" role="progressbar"></div>
                                                </div>
                                                <span class="m-widget24__change">Total</span>
                                                <span class="m-widget24__number">0 / 0</span></div>
                                        </div>
                                    </a>
                                    <!--end::New Users-->
                                </div>
                            </div>
                        </div>
                        <div id="user-incomes"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6 col-sm-6">
                <!--begin:: Widgets/Activity-->
                <div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h4 style="color: white;">
                                    CLIENTS
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body" style="padding: 0">

                        <div class="m-widget17__item m-hendelser">

                            <table class="table m-table m-table--head-no-border table-hover table-cell-center table-maina">
                                <?php foreach ($leadsBlock as $row) { ?>
                                    <tr href = "<?= $row['href'] ?>">
                                        <td>
                                            <?php if (isset($row['preSpan'])): ?>
                                                <span class="table-schala-time"><?= $row['preSpan'] ?></span>
                                            <?php endif; ?>
                                            <a href="<?= $row['href'] ?>" style="color: #797979; text-decoration: none;">
                                                <span class="m-hendelser-adresse"><?= $row['label'] ?></span>
                                            </a>
                                        </td>
                                        <td><?= $row['count'] ?></td>
                                    </tr>
                                <?php } ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6">
                <div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force block-varslinger">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="" style="margin-top: 15px;">
                                <h4 style="color: white;">
                                    <?= $activeEvents['title'] ?> <span class="badge badge-dark"><?= $activeEvents['count'] ?></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body" style="padding: 0">

                        <div class="m-widget17__item m-hendelser perfect-scrollbar" style="max-height: 325px">

                            <table class="table m-table m-table--head-no-border table-hover table-cell-center table-maina2">
                                <?php foreach ($activeEvents['news'] as $event): ?>
                                    <tr>
                                        <td>
                                            <a class="d-block" href="<?= $event['url'] ?>"><?= $event['name'] ?></a>
                                            <span class="schala-status">
                                                    <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                    <em><?= $event['badge'] ?></em>
                                                </span>
                                        </td>
                                        <td></td>
                                        <td><?= $event['datetime'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($activeEvents['departments'] as $event): ?>
                                    <tr>
                                        <td>
                                            <a class="d-block" href="<?= $event['url'] ?>"><?= $event['name'] ?></a>
                                        </td>
                                        <td><?= $event['datetime'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($activeEvents["partners"] as $partner): ?>
                                    <?php if (count($partner["departments"]) > 1): ?>
                                        <tr class="partner-row" data-id="<?= $partner["id"]; ?>">
                                            <td class="d-block">+ <?= $partner["name"]; ?></td>
                                            <td><?= $partner["count"]; ?></td>
                                        </tr>
                                        <?php foreach ($partner['departments'] as $department): ?>
                                            <tr class="p-r-child d-none" data-partner-id="<?= $partner["id"]; ?>">
                                                <td>
                                                    <a class="d-block"
                                                       href="<?= $department['url'] ?>">- <?= $department['name'] ?></a>
                                                </td>
                                                <td><?= $department['datetime'] ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <tr>
                                            <td>
                                                <a class="d-block"
                                                   href="<?= $partner["departments"][0]['url'] ?>"><?= $partner['name'] ?></a>
                                            </td>
                                            <td><?= $partner["departments"][0]['datetime'] ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                                <?php foreach ($activeEvents['clients'] as $event): ?>
                                    <tr class="<?= $event['expired'] ? 'bg-expired' : '' ?>">
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-fill">
                                                    <a class="d-block" href="<?= $event['url'] ?>"
                                                       title="<?= $event['note'] ?>"><?= $event['name'] ?></a>
                                                    <span class="schala-status">
                                                        <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                            <em><?= $event['type'] ?></em>
                                                    </span>
                                                    <span class="schala-status">
                                                        <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                        <em><?= $event['badge'] ?></em>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="broker-row d-flex justify-content-center">
                                            <?php if ($event['user_name']): ?>
                                                <div class="flex-fill mt-2 mb-2">
                                                    <div class="d-flex justify-content-center">
                                                        <div>
                                                            <img src="<?= $event['user_avatar'] ?>"
                                                                 class="m--img-rounded m--marginless table-schala-img"
                                                                 alt="<?= $event['user_name'] ?>">
                                                        </div>
                                                        <div>
                                                            <span class="table-schala-time"><?= $event['user_name'] ?></span>
                                                            <span class="table-schala-time-ago"><?= $event['user_department_name'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif ?>
                                        </td>
                                        <td><?= $event['datetime'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($activeEvents['properties'] as $event): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex">
                                                <div class="flex-fill">
                                                    <a class="d-block" href="<?= $event['url'] ?>">
                                                        <span class="m-hendelser-adresse"><?= $event['name'] ?></span>
                                                    </a>
                                                    <span class="schala-status">
                                                        <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                        <em><?= $event['badge'] ?></em>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="broker-row d-flex justify-content-center">
                                            <?php if ($event['brokers']): ?>
                                                <?php foreach ($event['brokers'] as $broker): ?>
                                                    <div class="flex-fill mt-2 mb-2">
                                                        <div class="d-flex justify-content-center">
                                                            <div>
                                                                <img src="<?= $broker->urlstandardbilde ?>"
                                                                     class="m--img-rounded m--marginless table-schala-img"
                                                                     alt="<?= $broker->navn ?>">
                                                            </div>
                                                            <div>
                                                                <span class="table-schala-time"><?= $broker->navn ?></span>
                                                                <span class="table-schala-time-ago"><?= $broker->department->short_name ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach ?>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $event['datetime'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php foreach ($activeEvents['visits'] as $event): ?>
                                    <tr>
                                        <td>
                                            <a class="d-block" href="<?= $event['url'] ?>">
                                                <span class="m-hendelser-adresse"><?= $event['name'] ?></span>
                                            </a>
                                            <span class="schala-status">
                                                    <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                    <em><?= $event['badge'] ?></em>
                                                </span>
                                        </td>
                                        <td><?= $event['datetime'] ?></td>
                                    </tr>
                                <?php endforeach ?>

                                <?php if(isset($activeEvents['outadingProps'])): ?>
                                    <?php foreach ($activeEvents['outadingProps'] as $event): ?>
                                        <tr>
                                            <td>
                                                <a class="d-block" href="<?= $event['href'] ?>">
                                                    <span class="m-hendelser-adresse"><?= $event['key'] ?></span>
                                                </a>
                                                <span class="schala-status">
                                                        <span class="m-badge m-badge--dot schala-type-visning"></span>
                                                        <em>Ringeliste </em>
                                                    </span>
                                            </td>
                                            <td></td>
                                            <td><p>Count:<?= $event['count'] ?></p> <?= $event['date'] ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--End::Section-->


        <?php if ($properties['type'] === 'userOrOffice'): ?>
            <?= $this->render('_properties', [
                'properties' => $properties['data']
            ]) ?>
        <?php elseif ($properties['type'] === 'partner'): ?>
            <div class="row">
                <?php foreach ($properties['data'] as $department): ?>
                    <div class="col-xl-3 col-sm-3 partner-card">
                        <a href="<?= UrlExtended::toRouteAddaptive(['site/index', 'office' => $department['url']]) ?>"
                           class="text-white"
                           style="cursor: pointer; text-decoration: none">
                            <div class="pt-4 m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
                                <div class="m-portlet__head">
                                    <h2 class="text-center w-100"><?= $department['short_name'] ?></h2>
                                </div>
                                <div class="m-portlet__body pd_count">
                                    <h2 class="text-center w-100"><?= count($department['properties']) ?></h2>
                                    <p class="text-center w-100 h3">oppdrag</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        <?php else: ?>
        <div class="row">
            <?php foreach ($properties['data'] as $partner): ?>
                <?php if ($partner["dep_count"] > 1): ?>
                    <div class="col-xl-3 col-sm-3 partner-card">
                        <div class="pt-4 m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--skin-light  m-portlet--rounded-force m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force block-varslinger">
                            <div class="partner-info">
                                <div class="m-portlet__head">
                                    <h2 class="text-center w-100"><?= $partner['name']; ?></h2>
                                </div>
                                <div class="m-portlet__body pd_count">
                                    <h2 class="text-center w-100"><?= $partner['pd_count']; ?></h2>
                                    <p class="text-center w-100 h3">oppdrag</p>
                                </div>
                            </div>
                            <div class="partner-child">
                                <div class="m-portlet__body" style="padding: 0">
                                    <div class="m-widget17__item m-hendelser perfect-scrollbar ps ps--active-y">
                                        <table class="table m-table m-table--head-no-border table-hover table-cell-center table-maina2">
                                            <?php foreach ($partner["activeDepartments"] as $department): ?>
                                                <tr>
                                                    <td>
                                                        <a class="d-block"
                                                           href="<?= Url::to(['site/index', 'office' => $department['dep_url']]); ?>"><?= $department["dep_name"]; ?></a>
                                                    </td>
                                                    <td><?= $department["pd_count"]; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-xl-3 col-sm-3 partner-card">
                        <a href="<?= Url::to(['site/index', 'office' => $partner["activeDepartments"][0]['dep_url']]); ?>"
                           class="text-white"
                           style="cursor: pointer; text-decoration: none">
                            <div class="pt-4 m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
                                <div class="m-portlet__head">
                                    <h2 class="text-center w-100"><?= $partner['name']; ?></h2>
                                </div>
                                <div class="m-portlet__body pd_count">
                                    <h2 class="text-center w-100"><?= $partner['pd_count']; ?></h2>
                                    <p class="text-center w-100 h3">oppdrag</p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xl-12">
                <div class="m-portlet first-last-radius" id="user-rating"></div>
            </div>
        </div>
    </div>
</div>

    
<?php /* } */ ?>



<?php if (!$user->hasrole('broker')): ?>
    <div class="modal fade" id="m_modal_delegere" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="modal-title" id="exampleModalLabel">Status ansatt</h5>
                    <button type="button" class="close m-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="m-accordion m-accordion--bordered m-accordion--solid" id="m_accordion_4" role="tablist">
                        <?php foreach ($accordion as $item): ?>
                            <div data-key="<?= $item["id"]; ?>">
                                <div class="m-accordion__item">
                                    <div id="m_accordion_2_item_<?= $item["id"]; ?>_head"
                                         href="#m_accordion_2_item_<?= $item["id"]; ?>_body"
                                         class="m-accordion__item-head collapsed" data-toggle="collapse"
                                         aria-expanded="false" role="tab">
                                        <span class="m-accordion__item-title"><?= $item["name"]; ?></span>
                                        <span class="m-accordion__item-mode"></span>
                                    </div>
                                    <div class="m-accordion__item-body collapse"
                                         id="m_accordion_2_item_<?= $item["id"]; ?>_body"
                                         role="tabpanel" aria-labelledby="m_accordion_2_item_<?= $item["id"]; ?>_head"
                                         data-parent="#m_accordion_4" style="">
                                        <?php if (count($item["departments"]) > 1): ?>
                                            <div class="m-accordion__item-content">
                                                <?php foreach ($item["departments"] as $department): ?>
                                                    <div class="m-accordion__item">
                                                        <div id="m_accordion_2_item_<?= $department["web_id"]; ?>_head"
                                                             href="#m_accordion_alesund_item_<?= $department["web_id"]; ?>_body"
                                                             class="m-accordion__item-head collapsed"
                                                             data-toggle="collapse"
                                                             aria-expanded="false" role="tab">
                                                            <span class="m-accordion__item-title"><?= $department["navn"]; ?></span>
                                                            <span class="m-accordion__item-mode"></span>
                                                        </div>
                                                        <div class="m-accordion__item-body collapse"
                                                             id="m_accordion_alesund_item_<?= $department["web_id"]; ?>_body"
                                                             role="tabpanel"
                                                             aria-labelledby="m_accordion_4_item_<?= $department["web_id"]; ?>_head"
                                                             data-parent="#m_accordion_2_item_<?= $item["id"]; ?>_body">
                                                            <a class="float-right check-all-users mt-2 mr-3 h5"
                                                               data-user-ids="<?= join(",", ArrayHelper::getColumn($department["users"], "id")) ?>">
                                                                Velg alle <i class="fas fa-check ml-2"></i>
                                                            </a>
                                                            <div class="m-accordion__item-content pt-5">
                                                                <ul class="list-unstyled broker-list mb-0">
                                                                    <?php foreach ($department["users"] as $user): ?>
                                                                        <li>
                                                                            <p class="w-100">
                                                                                <span class="m-accordion__item-icon">
                                                                                     <?= Html::img($user["urlstandardbilde"], [
                                                                                         "class" => "m--img-rounded m--marginless table-schala-img float-none d-inline-block",
                                                                                         "title" => $user["navn"]
                                                                                     ]); ?>
                                                                                </span>
                                                                                <?= Html::a($user["navn"], "javascript:", [
                                                                                    "style" => "text-decoration: none; font-size: 15px !important; color: white",
                                                                                    "data" => [
                                                                                        "user-id" => $user["id"],
                                                                                        "user-src" => $user["urlstandardbilde"],
                                                                                        "clicked" => "0"
                                                                                    ]
                                                                                ]); ?>
                                                                                <span class="float-right check-user mt-3"></span>
                                                                            </p>
                                                                        </li>
                                                                    <?php endforeach; ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <?php $department = array_pop($item["departments"]); ?>
                                            <a class="float-right check-all-users mt-2 mr-3 h5"
                                               data-user-ids="<?= join(",", ArrayHelper::getColumn($department["users"], "id")) ?>">
                                                Velg alle <i class="fas fa-check ml-2"></i>
                                            </a>
                                            <div class="m-accordion__item-content pt-5">
                                                <ul class="list-unstyled broker-list mb-0">
                                                    <?php foreach ($department["users"] as $user): ?>
                                                        <li>
                                                            <p class="w-100">
                                                                    <span class="m-accordion__item-icon">
                                                                         <?= Html::img($user["urlstandardbilde"], [
                                                                             "class" => "m--img-rounded m--marginless table-schala-img float-none d-inline-block",
                                                                             "title" => $user["navn"]
                                                                         ]); ?>
                                                                    </span>
                                                                <?= Html::a($user["navn"], "javascript:;", [
                                                                    "style" => "text-decoration: none; font-size: 15px !important; color: white",
                                                                    "data" => [
                                                                        "user-id" => $user["id"],
                                                                        "user-src" => $user["urlstandardbilde"],
                                                                        "clicked" => "0"
                                                                    ]
                                                                ]); ?>
                                                                <span class="float-right check-user mt-3"></span>
                                                            </p>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="modal-footer special">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

