<?php
/**
 * @var  integer $id
 * @var  string $view
 */

$this->registerCssFile('/css/befaring/oppdrag.css?v=' . time());
$detaljer = '/befaring/oppdrag/detaljer/'.$id;
$statistics = '/befaring/oppdrag/statistikk/'.$id;
if(!isset($view)) {
    $view = 'detaljer';
}
$this->registerJs("
    $('li.$view').addClass('tab-active');
");
?>

<div class="oppdrag" >
    <?php /*<ul class="about-tabs">
        <li class="about-tabs_item detaljer" href="<?= $detaljer ?>"><a>Detaljer</a></li>
        <li class="about-tabs_item statistikk" href="<?= $statistics ?>"><a >Statistikk</a></li>
    </ul>*/ ?>
<!--    <div class="tab-content">-->
        <?= $this->render('/befaring/oppdrag/'.$view, compact('data'))?>
<!--    </div>-->
</div>