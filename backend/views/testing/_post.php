<?php

/** @var $model common\models\Forms*/

use yii\helpers\Url;

setlocale(LC_ALL, 'nb_NO.UTF-8'); // TODO: set locale with Yii2 config

$registrertTimeStamp = $model->created_at;
$delegertTimeStamp = $model->updated_at;

$registrert = strftime("%d. %B %Y %H:%M ", $registrertTimeStamp);
$registrertPassDays =  round((time() - $registrertTimeStamp) / 60 / 60 / 24);
$delegert = strftime("%d. %B %Y %H:%M ", $delegertTimeStamp);
$delegertPassDays =  round((time() - $delegertTimeStamp) / 60 / 60 / 24);

$lead = array(
  'name'         => $model->name,
  'url'          => Url::to(['/clients/detaljer/', 'id' => $model->id ]),
  'type'         => $model->type,
  'address'      => $model->propertyDetails ? $model->propertyDetails->adresse : '',
  'regStamp'     => $registrertTimeStamp,
  'regDate'      => $registrert ,
  'regDays'      => $registrertPassDays,
  'delegateStamp'=> $delegertTimeStamp,
  'delegateDate' => $delegert ,
  'delegateDays' => $delegertPassDays,
  'user' => array(
      'name' => "Joachim Schala",
      'firm' => "Carl Berner",
      'image' => 'https://external.webmegler.no/wngetbilde.ashx?/abilde/k343/f\bilder\2018\3000002\11\3151995_1-dciuqb.jpg',
  ),
);


?>

<tr href = "<?= $lead['url']?>">
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
        <span class="table-schala-street">
            <?= $lead['address'] ?>
        </span>
        <span class="table-schala-time-ago">
            <?= $lead['regDays'] ?> dag(er) siden
        </span>
    </td>

    <!-- Delegated -->
    <td data-order="<?= $lead['delegateStamp'] ?>">
        <span class="schala-status">
            <span class="m-badge m-badge--dot schala-status-delegert"></span>
            <em>delegert</em>
        </span>
        <span class="table-schala-time">
            <?= $lead['delegateDate'] ?>
        </span>
        <span class="table-schala-time-ago">
            <?= $lead['delegateDays'] ?> dag(er) siden
        </span>
    </td>

    <!-- Broker -->
    <!--<td>
        <img
            src="<?/*= $lead['user']['image'] */?>"
            class="m--img-rounded m--marginless table-schala-img"
            alt=""
        />
        <span class="table-schala-time">
            <?/*= $lead['user']['name'] */?>
        </span>
        <span class="table-schala-time-ago">
            <?/*= $lead['user']['firm'] */?>
        </span>
    </td>-->
</tr>

