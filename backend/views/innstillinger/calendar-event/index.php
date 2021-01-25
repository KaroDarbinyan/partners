<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CalendarEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Befaringsaktiviteter';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="calendar-event-index ">
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
                        <div class="row">
                            <div class="col-lg-12 pr-4">
                                <?= Html::a(Yii::t('app', 'Legg til ny aktivitet'), ['create'], ['class' => 'btn btn-success float-right mt-4 mr-4']) ?>
                            </div>
                        </div>
                        <div class="m-portlet__body">                       
                            <?php Pjax::begin(); ?>

                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'columns' => [

                                    'id',
                                    'name',
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'template' => '{update}{delete}',
                                        'buttons' => [
                                            'update' => function($url) {
                                                return Html::a('Rediger', str_replace("innstillinger", "calendar-event", $url), ['class' => 'btn btn-success']);
                                            },
                                            'delete' => function($url) {
                                                return Html::a('Fjern', str_replace("innstillinger", "calendar-event", $url), [
                                                    'title' => Yii::t('app', 'Fjern'),
                                                    'data-confirm' => Yii::t('app', 'Er du sikker at du vil fjerne stillingen?'),
                                                    'data-method' => 'post',
                                                    'class' => ' ml-2 btn btn-danger'
                                                ]);
                                            }
                                        ]
                                    ]
                                ],
                            ]); ?>
                            <?php Pjax::end(); ?>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
