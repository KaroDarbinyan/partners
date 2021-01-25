<?php
/** @var \common\models\User $choosenUser */

use backend\components\UrlExtended;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;

$nameLabel = 'PARTNERS';

if( isset($currentDep) && isset($depUrlNameMap[$currentDep])) {
    $nameLabel = $depUrlNameMap[$currentDep];
} elseif ($choosenUser) {
    $nameLabel = $choosenUser->navn;
}

if ($partner = Yii::$app->partnerService->selected()) $nameLabel = $partner->name;
else if ($department = Yii::$app->departmentService->selected()) $nameLabel = $department->navn;

$partners = ArrayHelper::index($departments, null, 'partner.name');

?>
<header id="m_header" class="m-grid__item m-header" m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="<?= UrlExtended::toRoute(['site/index']) ?>" class="m-brand__logo-wrapper">
                            <img alt="" src="/admin/images/logo-partners.svg" class="logotype">
                        </a>
                    </div>

                    <div class="m-subheader m-sub-header-fix d-md-none">
                        <!--Date Picker-->
                        <span class="m-subheader__daterange m_dashboard_daterangepicker"
                              data-target-url="<?= Yii::$app->request->url ?>"
                              data-target-dynamic-content="main-content">
                            <span class="m-subheader__daterange-label">
                                <span class="m-subheader__daterange-title"></span>
                                <span class="m-subheader__daterange-date m--font-white"></span>
                            </span>
                            <a href="#" class="btn btn-sm btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                <i class="la la-angle-down"></i>
                            </a>
                        </span>
                    </div>

                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">

                            <img src="<?= $user->urlstandardbilde; ?>"
                                 class="m--img-rounded m--marginless person-img" alt="<?= $user->navn; ?>" title="<?= $user->navn; ?>" />
                        </a>
                        <!-- END -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->

            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <div class="m-subheader m-subheader-deskfix d-none d-lg-block">
                    <div class="d-flex align-items-center">
                        <div class="mr-auto">
                            <h3 class="m-subheader__title m-subheader__title--separator"><?= $this->title; ?></h3>
                            <?= Breadcrumbs::widget([
                                'homeLink' => [
                                    'label' => '<span class="m-nav__link-text">Home</span>',
                                    'url' => Url::home(),
                                    'class' => 'm-nav__link',
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                'itemTemplate' => '<li class="m-nav__item">{link}</li>',
                                'activeItemTemplate' => '<li class="m-nav__item" style="color: #898b96">{link}</li>',
                                'encodeLabels' => false,
                                'options' => [
                                    'class' => 'm-subheader__breadcrumbs m-nav m-nav--inline',
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                </div>

                <!-- BEGIN: Topbar Main-->
                <div id="m_header_topbar" class="m-topbar m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-subheader m-sub-header-fix d-md-block">
                        <!--Date Picker-->
                        <span class="m-subheader__daterange m_dashboard_daterangepicker"
                              data-target-url="<?= Yii::$app->request->url ?>"
                              data-target-dynamic-content="main-content">
                            <span class="m-subheader__daterange-label">
                                <span class="m-subheader__daterange-title"></span>
                                <span class="m-subheader__daterange-date m--font-white"></span>
                            </span>
                            <a href="#" class="btn btn-sm btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                                <i class="la la-angle-down"></i>
                            </a>
                        </span>
                    </div>

                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-dropdown m-dropdown--large
                                    m-dropdown--arrow m-dropdown--align-center
                                    m-dropdown--mobile-full-width m-dropdown--skin-light
                                    m-list-search m-list-search--skin-light"
                                m-dropdown-toggle="click"
                                id="m_quicksearch"
                                m-quicksearch-mode="dropdown"
                                m-dropdown-persistent="1"
                            >
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner ">
                                        <div class="m-dropdown__header">
                                            <form class="m-list-search__form">
                                                <div class="m-list-search__form-wrapper">
                                                        <span class="m-list-search__form-input-wrapper">
                                                            <input id="m_quicksearch_input" autocomplete="off"
                                                                   type="text" name="q"
                                                                   class="m-list-search__form-input" value=""
                                                                   placeholder="Search...">
                                                        </span>
                                                    <span class="m-list-search__form-icon-close"
                                                          id="m_quicksearch_close"><i
                                                                class="la la-remove"></i></span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true"
                                                 data-height="300" data-mobile-height="200">
                                                <div class="m-dropdown__content"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php if ($user && $user->hasRole(['superadmin', 'partner', 'director'])): ?>
                                <li class=" m-nav__item m-topbar__user-profile
                                                m-topbar__user-profile--img  m-dropdown
                                                m-dropdown--medium m-dropdown--arrow
                                                m-dropdown--header-bg-fill m-dropdown--align-right
                                                m-dropdown--mobile-full-width
                                                m-dropdown--skin-light"
                                    m-dropdown-toggle="click" m-dropdown-persistent="1">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                                        <span class = "office-selector-name pl-2"> <?= $nameLabel; ?> </span>
                                    </a>
                                    <div class="m-dropdown__wrapper sc-kontorvelger">

                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center">
                                                    <span class="m-dropdown__header-subtitle"
                                                          style="letter-spacing:2px;">KONTORER</span>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <?php if ($user->role == 'superadmin'): ?>
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__section m--hide">
                                                                <span class="m-nav__section-text">Section</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a
                                                                    data-title="<?= $user->url; ?>"
                                                                    href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'user'=>$user->url]) ?>"
                                                                    class="m-nav__link" id="superadmin"
                                                                ><span class="m-nav__link-text"><?= $user->navn; ?></span></a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a
                                                                    href="<?= Url::toRoute([$currentRoute]) ?>"
                                                                    class="m-nav__link offices"
                                                                ><span class="m-nav__link-text">
                                                                    PARTNERS
                                                                </span></a>
                                                            </li>

                                                            <?php foreach ($partners as $key => $partner):
                                                                    /** @var \common\models\Department[] $partner */
                                                                if (!$partner[0]->partner){
                                                                    continue;
                                                                }
                                                                    ?>
                                                                <?php if (count($partner) > 1):
                                                                ArrayHelper::multisort($partner, "short_name", SORT_ASC);
                                                                ?>
                                                                    <li class="m-nav__item partner-dropdown">
                                                                        <input type="checkbox" class = "accordion-trigger" id = "<?= "accordion_{$key}"?>">
                                                                        <span class="m-nav__link offices">
                                                                            <span class="m-nav__link-text">
                                                                                <label for="<?= "accordion_{$key}"?>"><?= $key; ?></label>
                                                                            </span>
                                                                        </span>
                                                                        <ul class="m-nav m-nav--skin-light sub-nav-dropdown">
                                                                            <li class="m-nav__item">
                                                                                <a href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'partner' => $partner[0]->partner->url], false) ?>"
                                                                                   class="m-nav__link offices"
                                                                                ><span class="m-nav__link-text"><?= $partner[0]->partner->name ?></span></a>
                                                                            </li>
                                                                            <?php foreach ($partner as $url => $department): ?>
                                                                                <?php if ($user->url !== $url): ?>
                                                                                    <li class="m-nav__item">
                                                                                        <a href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'office' => $department->url], false) ?>"
                                                                                           class="m-nav__link offices"
                                                                                        ><span class="m-nav__link-text"><?= $department->short_name; ?></span></a>
                                                                                    </li>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </ul>
                                                                    </li>
                                                                <?php else: ?>
                                                                    <li class="m-nav__item">
                                                                        <a href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'partner' => $partner[0]['partner_id']], false) ?>"
                                                                           class="m-nav__link offices"
                                                                        ><span class="m-nav__link-text"><?= $key; ?></span></a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php elseif ($user && $user->hasRole('partner')): ?>
                                                        <?php if ($partner = Yii::$app->partnerService->headOfficeWithParentDepartments()): ?>
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__item">
                                                                    <a data-title="<?= $user->url; ?>"
                                                                       href="<?= UrlExtended::toRouteAddaptive([
                                                                           $currentRoute, 'user' => $user->url
                                                                       ]) ?>" class="m-nav__link" id="partner">
                                                                        <span class="m-nav__link-text">
                                                                            <?= $user->navn ?>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="<?= UrlExtended::toRouteAddaptive([
                                                                        $currentRoute, 'partner' => $partner->url
                                                                    ]) ?>" class="m-nav__link">
                                                                        <span class="m-nav__link-text">
                                                                            <?= $partner->name ?>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <?php foreach ($partner->activeDepartments as $department): ?>
                                                                    <li class="m-nav__item">
                                                                        <a href="<?= UrlExtended::toRouteAddaptive([
                                                                            $currentRoute, 'office' => $department->url
                                                                        ]) ?>" class="m-nav__link">
                                                                            <span class="m-nav__link-text">
                                                                                &ndash; <?= $department->short_name ?>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                <?php endforeach ?>
                                                            </ul>
                                                        <?php endif ?>
                                                    <?php else: ?>
                                                        <ul class="m-nav m-nav--skin-light">
                                                            <li class="m-nav__section m--hide">
                                                                <span class="m-nav__section-text">Section</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a data-title="<?= $user->url; ?>"
                                                                   href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'user'=>$user->url]) ?>"
                                                                   class="m-nav__link" id="broker">
                                                                    <span class="m-nav__link-text"><?= $user->navn; ?></span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a
                                                                    href="<?= UrlExtended::toRouteAddaptive([
                                                                        $currentRoute,
                                                                        'office'=>$departments[$user->id_avdelinger]['url'] ]) ?>"
                                                                    class="m-nav__link"
                                                                >
                                                                    <span class="m-nav__link-text">
                                                                        <?= $departments[$user->id_avdelinger]['short_name']; ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img">
                                    <span class="m-nav__link">
                                        <span class="office-selector-name pl-2"><?= $user->navn ?></span>
                                    </span>
                                </li>
                            <?php endif ?>
                            <li class="hidden-xs m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light user-top-image">
                                <?php if ($choosenUser && !$user->equals($choosenUser)): ?>
                                    <div class="position-relative">
                                        <img src="<?= $choosenUser->urlstandardbilde ?>"
                                             class="m--img-rounded m--marginless person-img" alt="<?= $choosenUser->navn ?>" title="<?= $choosenUser->navn ?>">
                                        <a href="<?= UrlExtended::toRouteAddaptive([$currentRoute, 'user' => $user->url]) ?>" class="switch-to-current-user position-absolute">
                                            <img src="<?= $user->urlstandardbilde ?>"
                                                 class="m--img-rounded m--marginless"
                                                 alt="Switch to <?= $user->navn ?>"
                                                 title="Switch to <?= $user->navn ?>">
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <img src="<?= $user->urlstandardbilde ?>"
                                         class="m--img-rounded m--marginless person-img" alt="<?= $user->navn ?>" title="<?= $user->navn ?>">
                                <?php endif ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->

            </div>
        </div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'date-form d-none'], 'method' => 'get']) ?>
        <?= Html::hiddenInput('label') ?>
        <?= Html::hiddenInput('start') ?>
        <?= Html::hiddenInput('end') ?>
    <?php ActiveForm::end() ?>
</header>

