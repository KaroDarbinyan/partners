<?php

/* @var $this yii\web\View */

/* @var $topplister String */

use backend\assets\AppAsset;
use common\models\Department;
use common\models\Partner;
use common\models\User;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Topplister';
$this->params['breadcrumbs'][] = $this->title;
/** @var User $user */
$user = Yii::$app->user->identity;
$rating = Yii::$app->request->post('rating') ?? 'megler';
$type = Yii::$app->request->get('type') ?? 'provisjon';


$tl_data = [
    'type' => [
        'provisjon',
        'befaringer',
        'signeringer',
        'salg',
        'aktiviteter',
        'visninger'
    ],
    'rating' => [
        'megler' => ' topp-megler',
        'kontor' => 'topp-kontor',
        'medlem' => 'topp-medlem',
        'kjede' => 'topp-kjede'
    ],
    'office' => Partner::find()
        ->joinWith(["department" => function (ActiveQuery $query) {
            $query->where(["department.inaktiv" => 0]);
        }])
        ->andWhere(['or', ['!=', 'partner.id', 15], ['partner.name' => 'Partners']])->orderBy(['partner.name' => SORT_ASC])->asArray()->all()
];

$this->registerJsFile(Yii::$app->getUrlManager()->getBaseUrl() . '/js/topplister.js',
    ['depends' => [AppAsset::className()]]);

?>
<style>

    #tl-label {
        color: white;
    }

    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu a::after {
        transform: rotate(-90deg);
        position: absolute;
        right: 6px;
        top: .8em;
    }

    .dropdown-submenu .dropdown-menu {
        top: 0;
        left: 100%;
        margin-left: .1rem;
        margin-right: .1rem;
        min-width: auto !important;
    }

    .bootstrap-select .dropdown-toggle:before {
        width: unset
    }

    .dropdown.bootstrap-select > button {
        color: black;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper topliste-block">
    <div class="m-content">
        <button type="button" class="btn video-btn mb-4" data-toggle="modal"
                data-src="https://player.vimeo.com/video/400425905" data-target="#myModalVideo">
            <i class="flaticon-warning"></i> Instruksjonsvideo
        </button>
        <!-- List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <h1 class="d-flex justify-content-center">Toppliste</h1>
                        <div class="justify-content-center">
                            <div class="row" id="tl-filter">
                                <div class="col-md-12">
                                    <?php $form = ActiveForm::begin([
                                        'id' => 'tl-date-form',
                                        'method' => 'post',
                                        'options' => [
                                            'data-style' => 'tl-select',
                                            'class' => 'topliste-menus'
                                        ]
                                    ]); ?>
                                    <div>
                                        <select id="tl-type" name="tl-type" class="selectpicker"
                                                data-style="tl-select">
                                            <?php foreach ($tl_data['type'] as $item): ?>
                                                <option value="<?= $item; ?>" <?= $item === $type ? 'selected' : ''; ?>>
                                                    <?= $item; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div>
                                        <select id="tl-rating" name="tl-rating" class="selectpicker"
                                                data-style="tl-select">
                                            <?php foreach ($tl_data['rating'] as $key => $item): ?>
                                                <option value="<?= $key; ?>">
                                                    <?= $key; ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                    <div>
                                        <div class="dropdown bootstrap-select">
                                            <button class="nav-link dropdown-toggle btn tl-select"
                                                    id="navbarDropdownMenuLink" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                PARTNERS
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                <li class="dropdown-item">
                                                    <a class="dropdown-item partner-item"
                                                       data-partner-name="Partners"
                                                       data-partner-value="all"
                                                       data-partner-id="all"
                                                       href="#">PARTNERS</a>
                                                </li>
                                                <?php foreach ($tl_data['office'] as $item): ?>
                                                    <?php if (count($item["department"]) > 1): ?>
                                                        <li class="dropdown-item dropdown-submenu">
                                                            <a class="dropdown-item dropdown-toggle partner-item"
                                                               data-partner-name="<?= $item['name']; ?>"
                                                               data-partner-value="all"
                                                               data-partner-id="<?= $item["id"]; ?>"
                                                               href="#"><?= $item['name']; ?></a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item dropdown-sub-item partner-item"
                                                                       data-partner-name="<?= $item['name']; ?>"
                                                                       data-partner-value="all"
                                                                       data-partner-id="<?= $item["id"]; ?>"
                                                                       href="#">All</a></li>
                                                                <?php foreach ($item["department"] as $value): ?>
                                                                    <li>
                                                                        <a class="dropdown-item dropdown-sub-item office-item"
                                                                           href="#"
                                                                           data-office-name="<?= $value["short_name"]; ?>"
                                                                           data-partner-id="<?= $item["id"]; ?>"
                                                                           data-office-id="<?= $value["id"]; ?>"
                                                                        ><?= $value["short_name"]; ?></a>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php else: ?>
                                                        <li class="dropdown-item">
                                                            <a class="dropdown-item partner-item"
                                                               data-partner-name="<?= $item['name']; ?>"
                                                               data-partner-value="all"
                                                               data-partner-id="<?= $item["id"]; ?>"
                                                               href="#"><?= $item['name']; ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php if (false): ?>
                                        <div>
                                            <select id="tl-office" name="tl-office" class="selectpicker"
                                                    data-style="tl-select">
                                                <option value="all">S & P</option>
                                                <?php foreach ($tl_data['office'] as $item): ?>
                                                    <option value="<?= $item['url'] ?>">
                                                        <?= $item['short_name'] ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <?= Html::hiddenInput('tl-label'); ?>
                                        <?= Html::hiddenInput('tl-partner', 'all'); ?>
                                        <?= Html::hiddenInput('tl-office', 'all'); ?>
                                        <?= Html::hiddenInput('tl-start'); ?>
                                        <?= Html::hiddenInput('tl-end'); ?>
                                        <!--Date Picker-->
                                        <span id="tl-datepicker"
                                              class="btn dropdown-toggle tl-select"
                                              style="margin: 5px auto!important; width: 170px; text-align: left;">
                                                <span class="m-subheader__daterange-label">
                                                    <span class="m-subheader__daterange-title"></span>
                                                    <span class="m-subheader__daterange-date m--font-white"
                                                          id="tl-label"></span>
                                                </span>
                                        </span>
                                    </div>
                                    <?php ActiveForm::end() ?>
                                </div>
                            </div>
                        </div>
                        <p id="aktiviteter-info" class="text-center text-white h5 pt-2">
                            <?= (Yii::$app->request->get("type") === "aktiviteter")
                                ? "salg - 2 poeng, befaringer og visninger - 1 poeng" : ""; ?>
                        </p>
                        <div class="toppliste <?= $tl_data['rating'][$rating]; ?>" id="tl-container">
                            <?= $topplister; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>