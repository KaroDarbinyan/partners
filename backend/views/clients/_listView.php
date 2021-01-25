<?php

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var yii\data\Sort $sort */

use yii\grid\GridView;
use yii\widgets\LinkSorter;
use yii\widgets\ListView;
use yii\widgets\Pjax;

$labels = [
    "Navn" => [
        'slug' => 'name',
        'class' => 'sorting',
        SORT_ASC => 'la-sort-alpha-asc',
        SORT_DESC => 'la-sort-alpha-desc'
    ],
    "Registrert" => [
        'slug' => 'created_at',
        'class' => 'sorting_desc',
        SORT_ASC => 'la-sort-amount-asc',
        SORT_DESC => 'la-sort-amount-desc'
    ],
    "Sist Endret" => [
        'slug' => 'updated_at',
        'class' => 'sorting',
        SORT_ASC => 'la-sort-amount-asc',
        SORT_DESC => 'la-sort-amount-desc'
    ],
];
?>
<?php ob_start(); ?>
<table class="dataTable table table-striped- table-bordered table-hover table-checkable" >
    <thead>
    <tr>
        <?php foreach ($labels as $name => $label) { ?>
            <th >
                <a class="" href="<?= $sort->createUrl($label['slug']) ?>"
                   data-sort="<?= $label['slug'] ?>"><?= $name ?>
                    <i class="la <?= isset($label[$sort->getAttributeOrder($label['slug'])])
                        ? $label[$sort->getAttributeOrder($label['slug'])] : '' ?>"></i></a>
            </th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>{items}</tbody>
    <tfoot>
    <tr>
        <?php foreach ($labels as $name => $label) { ?>
            <th>
                <a class="" href="<?= $sort->createUrl($label['slug']) ?>"
                   data-sort="<?= $label['slug'] ?>"><?= $name ?>
                    <i class="la <?= isset($label[$sort->getAttributeOrder($label['slug'])])
                        ? $label[$sort->getAttributeOrder($label['slug'])] : '' ?>"></i></a>
            </th>
        <?php } ?>
    </tr>
    </tfoot>
</table>
{pager}
<?php $layout = ob_get_clean(); ?>
<?php Pjax::begin([
    'formSelector' => '[data-active-form-header]',// this form is submitted on change
    'submitEvent' => 'change',
]); ?>

<?= /** @noinspection PhpUnhandledExceptionInspection */
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_post',
    'pager' => [
        'prevPageLabel' => '<i class="la la-angle-left"></i>',
        'nextPageLabel' => '<i class="la la-angle-right"></i>',
        'maxButtonCount' => 7,

        // Customzing options for pager container tag
        'options' => [
            'class' => 'copy-datatable-pagination',
        ],

        // Customzing CSS class for pager link
        'activePageCssClass' => 'active',
        'disabledPageCssClass' => 'disabled',
    ],
    'layout' => $layout,
]) ?>
<?php Pjax::end(); ?>

<?php return; ?>
<?php
/*
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'name',
        'surname',
        'delegated',
        'post_number',
        //'phone',
        //'email:email',
        //'message:ntext',
        //'subscribe_email:email',
        //'contact_me',
        //'type',
        //'target_id',
        //'send_sms',
        //'created_at',
        //'updated_at',
    ],
]);*/ ?>
