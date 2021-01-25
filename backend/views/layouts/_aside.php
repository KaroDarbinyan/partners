<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\Theme;
use backend\components\UrlExtended;

?>
<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn"><i
        class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-dark">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark"
         m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item m-menu__item--<?= isset(Yii::$app->view->params['dashboard']) ? Yii::$app->view->params['dashboard'] : 'submenu'; ?>"
                aria-haspopup="true">
                <a href="<?= UrlExtended::toRoute(['site/index']); ?>" class="m-menu__link" >
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-text">Dashboard</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['clients/paminnelser']) ? Yii::$app->view->params['clients/paminnelser'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/paminnelser']) ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-alert-2"></i><span class="m-menu__link-text">Varslinger</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['favoritter']) ? Yii::$app->view->params['favoritter'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/favoritter']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-text">Favoritter</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['ringeliste']) ? Yii::$app->view->params['ringeliste'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/ringeliste']); ?>"
                class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-alert"></i><span class="m-menu__link-text">Ringeliste</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['clients/visning']) ? Yii::$app->view->params['clients/visning'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/visning']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2"></i><span class="m-menu__link-text">Visningspåmelding</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['clients/hot']) ? Yii::$app->view->params['clients/hot'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/hot']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2"></i>
                    <span class="m-menu__link-text">Hot clients</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['clients/cold']) ? Yii::$app->view->params['clients/cold'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/cold']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-2"></i><span class="m-menu__link-text">Cold clients</span>
                </a>
            </li>

            <?php /*<li class="m-menu__item">
                <a href="<?= UrlExtended::toRoute(['clients/alle']); ?>" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text">Alle clients</span>
                </a>
            </li>*/ ?>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['potential']) ? Yii::$app->view->params['potential'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['clients/potential']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Mulige kjøpere</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['oppdrag']) ? Yii::$app->view->params['oppdrag'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['oppdrag/index']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-home-2"></i><span class="m-menu__link-text">Oppdrag</span>
                </a>
            </li>


            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['befaring']) ? Yii::$app->view->params['befaring'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="<?= UrlExtended::toRoute(['/befaring']); ?>"
                   class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-interface-4"></i><span class="m-menu__link-text">Befaring</span>
                </a>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['statistikk']) ? Yii::$app->view->params['statistikk'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-graphic-2"></i>
                    <span class="m-menu__link-text">Statistikk</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['topplister/index']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Topplister</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['statistikk/clients']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Clients</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['statistikk/befaringer']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Diagrammer</span>
                            </a>
                        </li>
                        <?php if($user && !$user->hasRole('broker')): ?>
                            <li class="m-menu__item " aria-haspopup="true">
                                <a href="<?= UrlExtended::toRoute(['statistikk/budsjett']); ?>"
                                   class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Budsjett</span>
                                </a>
                            </li>
                        <?php endif ?>
                        
                        <?php //TODO:: add to permition controll ?>
                        <?php if ($user &&  $user->hasRole('superadmin')): ?>
                            <li class="m-menu__item " aria-haspopup="true">
                                <a href="<?= UrlExtended::toRoute(['statistikk/salgssnitt']); ?>"
                                   class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Salgssnitt</span>
                                </a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['intranett']) ? Yii::$app->view->params['intranett'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-suitcase"></i>
                    <span class="m-menu__link-text">Intranett</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">

                        <?php if ($user &&  !$user->hasRole('broker')): ?>
                            <li class="m-menu__item " aria-haspopup="true">
                                <a href="<?= UrlExtended::toRoute(['intranett/nyheter-create']); ?>"
                                   class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Legg til nyheter</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['intranett/nyheter']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Nyheter</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['intranett/profilering']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Dokumenter</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['intranett/idedatabase']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Idedatabase</span>
                            </a>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['intranett/leverandorer']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Leverandører</span>
                            </a>
                        </li>
                        <?php /*
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['/site/send-sms']); ?>"
                                class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Send SMS</span>
                            </a>
                        </li>

                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['/site/mailing']); ?>"
                                class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Send epost</span>
                            </a>
                        </li>

                        */ ?>
                        <?php if($user && !$user->hasRole('broker')): ?>
<!--                        <li class="m-menu__item " aria-haspopup="true">-->
<!--                            <a href="--><?//= UrlExtended::toRoute(['/ledige-stillinger']); ?><!--"-->
<!--                                class="m-menu__link ">-->
<!--                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>-->
<!--                                <span class="m-menu__link-text">Ledige stillinger</span>-->
<!--                            </a>-->
<!--                        </li>-->
                        <?php endif; ?>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['/innstillinger/signatur']); ?>"
                               class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Signatur</span>
                            </a>
                        </li>
                        <?php if ($user && $user->hasRole(['superadmin', 'partner', 'director'])): ?>
                          <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['department/appoint-deputy']); ?>"
                               class="m-menu__link ">
                              <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                              <span class="m-menu__link-text">
                                  <?= Yii::t('app', 'Vikar') ?>
                              </span>
                            </a>
                          </li>
                        <?php endif ?>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['innstillinger']) ? Yii::$app->view->params['innstillinger'] : 'submenu'; ?>" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-settings"></i>
                    <span class="m-menu__link-text">Innstillinger</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
<!--                        <li class="m-menu__item " aria-haspopup="true">-->
<!--                            <a href="--><?//= UrlExtended::toRoute(['/calendar-event']); ?><!--"-->
<!--                                class="m-menu__link ">-->
<!--                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>-->
<!--                                <span class="m-menu__link-text">Befaringsaktiviteter</span>-->
<!--                            </a>-->
<!--                        </li>-->
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="<?= UrlExtended::toRoute(['/innstillinger/endre-passord']); ?>"
                                class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Endre passord</span>
                            </a>
                        </li>
                        <?php if (user() && !user()->hasRole('broker')): ?>
                            <li class="m-menu__item " aria-haspopup="true">
                                <a href="<?= UrlExtended::toRoute(['/innstillinger/markedspakke']); ?>"
                                   class="m-menu__link ">
                                    <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                    <span class="m-menu__link-text">Markedspakke</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (false): ?>
                        <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['innstillinger']) ? Yii::$app->view->params['innstillinger'] : 'submenu'; ?>" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Theme</span>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu">
                                <span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <?php $themes = Theme::find()->all(); foreach ($themes as $theme): ?>
                                    <li class="m-menu__item" data-color="<?= $theme->color; ?>" aria-haspopup="true">
                                        <a href="<?= Url::base(true) . "/theme/{$theme->color}"; ?>" class="m-menu__link">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span style="width: 10px; height: 10px; background-color: <?= $theme->hex; ?>; border-radius: 100%"></span>
                                            </i>
                                            <span class="m-menu__link-text"><?= $theme->title; ?></span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item  m-menu__item--<?= isset(Yii::$app->view->params['eiendomsverdi']) ? Yii::$app->view->params['eiendomsverdi'] : 'submenu'; ?>"
                aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a id="eiendomsverdi"
                   href="<?= UrlExtended::toRoute(['eiendomsverdi/index']); ?>"
                   target="_blank"
                   class="m-menu__link m-menu__toggle"
                >
                    <i class="m-menu__link-icon flaticon-location"></i>
                    <span class="m-menu__link-text">Eiendomsverdi</span>
                </a>
            </li>

            <li class="m-menu__item m-menu__item--logout" aria-haspopup="true">
                <?= Html::beginForm(['/site/logout'], 'post', ['id' => 'logout-form', 'style' => 'display:none']); ?>
                <!--<?= Html::submitButton('Logg ut', ['class' => 'btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder btn-exit']); ?>-->
                <?= Html::endForm(); ?>
                <a href="#" class="m-menu__link" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    <i class="m-menu__link-icon flaticon-logout"></i>
                    <span class="m-menu__link-text">Logg ut</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->

</div>
<!-- END: Left Aside -->