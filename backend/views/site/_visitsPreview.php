<?php
/** @var \common\models\PropertyVisits[] $visitsPreviews */
?>
<div style = "overflow: hidden">
    <div class="row" data-lightSlider="3">
        <?php foreach ($visitsPreviews as $visit): ?>
            <div class="" >
                <!--begin:: Widgets/Activity-->
                <div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div>
                                <h4><?= $visit['address'] ?></h4>
                                <h5 class="m-portlet__head-text m--font-light" style="font-weight: 400;">
                                    <?php foreach ($visit['date'] as $date): ?>
                                        <p><?= date("d.m.Y / H:i", $date); ?></p>
                                    <?php endforeach; ?>
                                    <span class="schala-status">
                                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                                        <em>visning</em>
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-widget17">
                            <div class="m-widget17__visual m-widget17__visual--chart m-portlet-fit--top m-portlet-fit--sides m--bg-danger dom01">
                                <?php if (isset($visit['pImageSrc'])): ?>
                                    <img src="<?= $visit['pImageSrc'] ?>" alt="" class = "bg-image-imitator"/>
                                <?php endif; ?>
                                <div class="m-widget17__chart m-portlet-apartment-dom">
                                    <img class = "person-image"
                                         src="<?= $visit['uImageSrc']; ?>"
                                         alt=""
                                    /><br/>
                                    <a href="<?= $visit['detaljerHref'] ?>"  class="btn btn-primary btn-sm" style="width: 100px;">
                                        Detalier
                                    </a>
                                    <a href="<?= $visit['statistikkHref'] ?>" class="btn btn-third">
                                        Statistikk
                                    </a>
                                    <a href="<?= $visit['interessenterHref'] ?>" class="btn btn-primary btn-sm" style="width: 100px;">
                                        Interessenter
                                    </a>
                                </div>
                            </div>
                            <div class="m-widget17__stats" style="width: 100%">
                                <div class="m-widget17__items m-widget17__items-col1">
                                    <div class="m-widget17__item m-apartment">
                                        <table>
                                            <tr>
                                                <td>FINN.NO</td>
                                                <td><?= $visit['finn_viewings']?$visit['finn_viewings']:0; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Markedsoppføring</td>
                                                <td><?= ceil($visit['markedsforing']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Partners.no</td>
                                                <td><?= $visit['eiendom_viewings'] ?></td>
                                            </tr>
                                            <?php foreach ($visit['leads'] as $lead => $type): ?>
                                                <tr>
                                                    <td class="text-capitalize"><?= $lead ?></td>
                                                    <td><?= $type; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:: Widgets/Activity-->
            </div>
        <?php endforeach;?>
    </div>
</div>
