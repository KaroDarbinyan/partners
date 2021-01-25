<?php

/* @var $this yii\web\View */
/** @var yii\data\Sort $sort */

$this->title = 'Oppdrag';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <div class="m-content">
        <?php if(false) { //Temprorarry removed untill functionality will be added
            $this->render('_filter');
        }?>
        <!-- List -->
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                    <div class="m-portlet__body">
                        <?= $this->render(
                            '_listView',
                            compact('dataProvider','sort')
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>