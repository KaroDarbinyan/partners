<?php


use common\models\PropertyDetails;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $properties PropertyDetails[] */
/* @var $properties PropertyDetails[] */
/** @var User $user */
/* @var $dataProvider ActiveDataProvider */

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'class' => false
    ],
    'rowOptions' => function($model) {
        return ['style' => $model->is_visible == 1 ? "opacity: 1": "opacity: 0.4"];
    },
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            'contentOptions' => ['class' => 'align-middle'],
            'options' => [
                'style' => 'width: 1%'
            ],
            'checkboxOptions' => function ($model) {
                return $model->is_visible == 1 ? ["checked" => "checked"] : [];
            }
        ],
        [
            'class' => 'yii\grid\Column',
            'options' => [
                'style' => 'width: 20%'
            ],
            'header' => 'Image',
            'content' => function ($model) {
                $content = Html::img($model->posterPath(), ["class" => "w-75"]);
                if ($model->isSold()) $content .= Html::img("https://partners.no/img/sold.png", ["class" => "solgt"]);
                return $content;
            }
        ],
        [
            'class' => 'yii\grid\Column',
            'options' => [
                'style' => 'width: 15%'
            ],
            'header' => 'Description',
            'content' => function ($model) {
                $content = $model->isOwnedSchalaPartners()
                    ? StringHelper::truncate(ltrim("{$model->title}, {$model->overskrift}, {$model->adresse}", ', '), 300)
                    : StringHelper::truncate("{$model->overskrift}, {$model->adresse}", 350);

                return "<span class='pr-2 mb-auto'>{$content}</span>";
            }
        ],
        [
            'attribute' => 'prisantydning',
            'options' => [
                'style' => 'width: 10%'
            ],
            'label' => 'Pris',
            'content' => function ($model) {
                return "<span class='property-price'>{$model->getCost()}</span>";
            }
        ],

        [
            'attribute' => 'prom',
            'options' => [
                'style' => 'width: 10%'
            ],
            'content' => function ($model) {
                $pr = $model->getProm() ? "{$model->getProm()} m<sup>2</sup>," : "-";
                return "<span class='property-desc'>{$pr}</span>";
            }
        ],
        [
            'attribute' => 'type_eiendomstyper',
            'label' => 'Boligtype',
            'options' => [
                'style' => 'width: 10%'
            ],
        ],
        [
            'attribute' => 'soverom',
            'filter' => [ "1"=>"open", "2"=>"in progress", "3"=>"closed" ],
            'options' => [
                'style' => 'width: 5%'
            ],
            'content' => function ($model) {
                return $model->soverom ? $model->soverom : "-";
            }
        ]
    ]
]); ?>
