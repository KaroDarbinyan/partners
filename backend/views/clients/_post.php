<?php

/** @var $model common\models\Forms*/

use backend\components\UrlExtended;
use yii\helpers\Url;
setlocale(LC_ALL, 'nb_NO.UTF-8'); // TODO: set locale with Yii2 config
$registrertTimeStamp = $model->created_at;
$delegertTimeStamp = $model->updated_at;
$office = Yii::$app->request->get('office');
$registrert = strftime("%d. %B %Y %H:%M ", $registrertTimeStamp);
$registrertPassDays =  round (( time() - $registrertTimeStamp ) / 60 / 60 / 24 );
$delegert = strftime("%d. %B %Y %H:%M ", $delegertTimeStamp);
$delegertPassDays =  round ((time() - $delegertTimeStamp) / 60 / 60 / 24 );

$lead = [
    'name' => $model->name,
    'url' => UrlExtended::toRoute(['/clients/detaljer/','id' => $model->id]),
    'type' => $model->type,
    'address' => $model->propertyDetails ? $model->propertyDetails->adresse : '',
    'regStamp' => $registrertTimeStamp,
    'regDate' => $registrert,
    'regDays' => $registrertPassDays,
    'delegateStamp' => $delegertTimeStamp,
    'delegateDate' => $delegert,
    'delegateDays' => $delegertPassDays,
    'status' => $model->status ? [
        'type' => $model->status,
        'date' => strftime("%d. %B %Y %H:%M ", $model->updated_at),
        'timestamp' => $model->updated_at,
    ]: false,
    'user' => [
    ],
];

/**
 * Init brokers images
 */
if($model->user){
    $lead['user'][] = [
        'attrs' => [
            'src' => $model->user->urlstandardbilde ?? '/images/default-user.png',
            'alt' => $model->user->navn,
            'title' => $model->user->navn,
            'class' => "m--img-rounded m--marginless table-schala-img",
        ],
        'icon' => '',
    ];

    if (
        $model->delegatedUser
        && $model->user->web_id != $model->delegatedUser->web_id
    ){
        array_unshift($lead['user'],[
            'attrs' => [
                'src' => $model->delegatedUser->urlstandardbilde ?? '/images/default-user.png',
                'alt' => $model->delegatedUser->navn,
                'title' => $model->delegatedUser->navn,
                'class' => "m--img-rounded m--marginless table-schala-img",
            ],
            'icon' => "<i class=\"fa fa-arrow-right mr-2\"></i>",
        ]);
    }
}

?>

<tr href = "<?= $lead['url'] ?>">
    <!-- Name -->
    <td>
        <span class="schala-status">
            <span
                    class="m-badge m-badge--dot schala-type-selger">
            </span>
            <em><?= $lead['type'] ?></em>
        </span>
        <span class="table-schala-name">
            <?= $lead['name'] ?>
        </span>
        <span class="table-schala-street">
             <span >
                <?= $lead['address'] ?>
            </span>
        </span>
    </td>

    <!-- Registered -->
    <td data-order="<?= $lead['regStamp'] ?>">
        <span class="schala-status">
            <span class="m-badge m-badge--dot schala-status-registrert"></span>
            <em>registrert</em>
        </span>
        <span class="table-schala-time">
            <?= $lead['regDate'] ?>
        </span>
        <span class="table-schala-time-ago" data-moment="<?= $lead['regStamp'] ?>"></span>
    </td>

    <!-- Delegated -->
    <td data-order="<?= $lead['delegateStamp'] ?>">
        <div class="d-flex">
            <?php if( $lead['status'] ): ?>
                <div>
                    <span class="schala-status">
                        <span class="m-badge m-badge--dot schala-status-<?= $lead['status']['type'] ?>"></span>
                        <em><?= $lead['status']['type'] ?></em>
                    </span>
                    <span class="table-schala-time">
                        <?= $lead['status']['date'] ?>
                    </span>
                    <span class="table-schala-time-ago" data-moment="<?= $lead['status']['timestamp'] ?>"></span>
                </div>
            <?php endif; ?>

            <!--Broker Info -->
            <div class="d-flex flex-wrap align-items-center" >
                <?php foreach ( $lead['user'] as $img ) { ?>
                    <img <?php foreach( $img['attrs'] as $n => $v ){echo " {$n}='{$v}'";}?>/>
                    <?= $img['icon'] ?>
                <?php } ?>
            </div>
        </div>
    </td>
</tr>
