<?php

/** @var array $properties */

?>

<label for="property-sequence">
    <select id="property-sequence" class="selectpicker" data-size="2" data-style="btn-success mt-3 mb-1">
        <option value="alphabet">Etter adresse</option>
        <option value="fra">Etter visningsdato</option>
    </select>
</label>
<div style="overflow: hidden">
    <div class="row" data-lightSlider="3">
        <?php foreach ($properties as $property): ?>
            <div data-alphabet="<?= $property['alphabet']; ?>"
                 data-fra="<?= isset($property['date'][0]) ? $property['date'][0]['fra'] : $property['alphabet']; ?>">
                <!--begin:: Widgets/Activity-->
                <div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
                    <div class="m-portlet__head w-100" style="padding: 0 1rem;">
                        <div class="m-portlet__head-caption w-100 mt-2">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="mb-0"><?= $property['address'] ?></h4>
                                    <h6><?= $property['oppdragsnummer'] ?></h6>
                                    <?php if (count($property['date']) > 0): ?>
                                        <h5 class="m-portlet__head-text m--font-light" style="font-weight: 400;">
                                            <?php foreach ($property['date'] as $date): ?>
                                                <p><?= date("d.m.Y / H:i", $date['fra']) . ' - ' . date("H:i", $date['til']); ?></p>
                                            <?php endforeach; ?>
                                            <span class="schala-status">
                                        <span class="m-badge m-badge--dot schala-status-registrert"></span>
                                        <em>visning</em>
                                    </span>
                                        </h5>
                                    <?php endif; ?>
                                </div>
                                <div class="col-4">
                                    <a href="/visning/<?= $property['id'] ?>" class="btn btn-light btn-sm mb-2 d-block" target="_blank">
                                        Visning
                                    </a>
                                    <a href="/befaring/<?= $property['id'] ?>" class="btn btn-light btn-sm d-block" target="_blank">
                                        Befaring
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-widget17">
                            <div class="m-widget17__visual m-widget17__visual--chart m-portlet-fit--top m-portlet-fit--sides m--bg-danger dom01">
                                <?php if ($property['background']): ?>
                                    <img src="<?= $property['background'] ?>" class="bg-image-imitator">
                                <?php endif ?>
                                <div class="m-widget17__chart m-portlet-apartment-dom">
                                    <img class = "person-image"
                                         src="<?= $property['user_img']; ?>"
                                         alt=""
                                    /><br/>
                                    <a href="<?= $property['detail_url'] ?>"  class="btn btn-primary btn-sm" style="width: 100px;" target="_blank">
                                        Detalier
                                    </a>
                                    <a href="<?= $property['statistics_url'] ?>" class="btn btn-third" target="_blank">
                                        Statistikk
                                    </a>
                                    <a href="<?= $property['parties_concerned_url'] ?>" class="btn btn-primary btn-sm" style="width: 100px;" target="_blank">
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
                                                <td><?= $property['finn_viewings'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Markedsoppføring</td>
                                                <td><?= ceil($property['markedsforing']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Partners.no</td>
                                                <td><?= $property['eiendom_viewings'] ?></td>
                                            </tr>
                                            <?php foreach ($property['leads'] as $lead => $type): ?>
                                                <tr>
                                                    <td><?= str_replace("_", " ", ucfirst($lead)); ?></td>
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
            </div>
        <?php endforeach ?>
    </div>
</div>
