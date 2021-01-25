<?php
use yii\helpers\Url;

/** @var $model common\models\PropertyDetails */

setlocale(LC_ALL, 'nb_NO.UTF-8'); // TODO: set locale with Yii2 config

$registrertTimeStamp = $model->oppdragsdato;
$delegertTimeStamp = $model->endretdato;

$url = Yii::$app->request->get('office') ? '/admin/'.Yii::$app->request->get('office'): '/admin';

$image = $model->user->urlstandardbilde;
$name = isset($model->user->navn)? $model->user->navn:false;
$oppdrag = array(
    'entity' => array(
        'url' => Url::toRoute(['oppdrag/detaljer', 'id' => $model->id]),
    ),
    'status' => array(
        'date' => strftime("%d. %B %Y", $registrertTimeStamp),
        'stamp' => $registrertTimeStamp,
    ),
    'action' => array(
        'date' => strftime("%d. %B %Y %H:%M ", $delegertTimeStamp),
        'stamp' => $delegertTimeStamp,
    ),
    'broker' => [
        'image' => $image,
        'name' => $name,
        'firmName' => $model->user->department->short_name,
    ],
    'nummer' => $model->oppdragsnummer,
);
?>

<tr>
    <!-- Name -->
    <td>
        <span class="schala-status">
            <span
                class="m-badge m-badge--dot schala-type-<?= $model->solgt == -1 ? 'solgt' : 'selger' ?>">
            </span>
            <em><?= $model->tinde_oppdragstype ?></em>
        </span>
        <a
            class="table-schala-street"
            href = "<?= $oppdrag['entity']['url']  ?>"
        ><?= $model->adresse ?></a>
    </td>

    <!-- Registered -->
    <td data-order = "<?= $oppdrag['status']['stamp'] ?>" >
        <span class="table-schala-time">
            <?= $oppdrag['status']['date'] ?>
        </span>
        <span class="table-schala-time-ago" data-moment="<?= $oppdrag['status']['stamp'] ?>"></span>
    </td>

    <!-- Delegated -->
    <td data-order = "<?= $oppdrag['action']['stamp'] ?>">
        <span class="table-schala-time">
            <?= $oppdrag['action']['date'] ?>
        </span>
        <span class="table-schala-time-ago" data-moment="<?= $oppdrag['action']['stamp'] ?>"></span>
    </td>

    <!-- Broker -->
    <td>
        <img
            src="<?= $oppdrag['broker']['image'] ?>"
            class="m--img-rounded m--marginless table-schala-img" alt=""
        />
        <span class="table-schala-time">
            <?= $oppdrag['broker']['name'] ?>
        </span>
        <span class="table-schala-time-ago">
            <?= $oppdrag['broker']['firmName'] ?>
        </span>
    </td>

    <!-- Nummer -->
    <td>
        <span class="table-schala-time">
            <?= $oppdrag['nummer'] ?>
        </span>
    </td>
</tr>

