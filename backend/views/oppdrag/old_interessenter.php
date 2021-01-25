<?php

/* @var $this yii\web\View */

use backend\assets\AppAsset;
use yii\widgets\ListView;

$this->title = 'Interessenter';
$this->params['breadcrumbs'][] = [
    'label' => '<span class="m-nav__link-text">Oppdrag</span>',
    'url' => ['/oppdrag/'],
    'class' => 'm-nav__link',
];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <div class="col-lg-12">

        <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
            <div class="m-portlet__body">

                <?= ListView::widget([
                    'dataProvider' => $leadsDataProvider,
                    'itemView' => '_lead',
                    'layout' => '
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>Navn</th>
                                    <th>Dato</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>{items}</tbody>
                            <tfoot>
                                <tr>
                                    <th>Navn</th>
                                    <th>Dato</th>
                                    <th>Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    ',
                ])?>
            </div>
        </div>

    </div>

</div>
