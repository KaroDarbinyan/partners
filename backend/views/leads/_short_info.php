<?php
$postNumber = $lead->post_number;

\common\components\Befaring::numFormat($postNumber);

$details = [
    'Navn' => "{$lead->name} {$lead->surname}",
    'Vedr. adresse' => '',
    'Postadresse' => $postNumber,
    'Telefon' => "<a href='tel:" . $lead->phone . "'>$lead->phone</a>",
    'E-post' => "<a href='mailto:$lead->email'>$lead->email</a>",
    'Adresse' => $lead->address,
    'Kommentar' => $lead->message ? str_replace('Kommentar:', '', $lead->message) : '',
    'Oppdragsnummer' => '',
];

if ($lead->propertyDetails) {
    $details['Oppdragsnummer'] = '<div class="flex">
        <a href="' . \backend\components\UrlExtended::toRoute(['oppdrag/detaljer', 'id' => $lead->propertyDetails->id]) . '">' . $lead->propertyDetails->oppdragsnummer . '</a>
        <span class="schala-status">
            <span class="m-badge m-badge--dot schala-status-' . ($lead->propertyDetails->solgt == -1 ? 'solgt' : 'selger') . '"></span>
            <em>' . $lead->propertyDetails->tinde_oppdragstype . '</em>
        </span>
    </div>';
} else {
    unset($details['Oppdragsnummer']);
}

if (!$lead->isHot() && $lead->propertyDetails) {
    $details['Vedr. adresse'] = $lead->propertyDetails->adresse;
} else {
    unset($details['Vedr. adresse']);
}

if (!$lead->isHot() || empty($lead->address)) {
    unset($details['Adresse']);
}
?>

<div class="table-responsive mt-2">
    <button type="button" class="close btn btn-success p-2 js-close-lead-short-info" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <table class="table table-sm">
        <thead>
        <tr>
            <?php if ($property = $lead->propertyDetails): ?>
                <th scope="col">Statistikk for <?= $property->oppdragsnummer ?></th>
            <?php endif ?>
            <th scope="col">Client</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php if ($property = $lead->propertyDetails): ?>
            <td style="max-width: 300px; white-space: normal; overflow: hidden;">
                    <div class="table-responsive">
                        <table class="table m-table m-table--head-no-border table-hover tabababa">
                            <tbody>
                            <tr>
                                <th scope="row">Adresse</th>
                                <td><?= $property->adresse ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Salgstid</th>
                                <td><?= $property->markedsforingsdato !== 0 ? round((strtotime(date($property->akseptdato)) - $property->markedsforingsdato) / (86400)) . ' dager' : '-' ?></td>
                            </tr>
                            <?php if ($property->prom): ?>
                                <tr>
                                    <th scope="row">Kvadratmeterpris</th>
                                    <td><?= number_format($property->salgssum / $property->prom, 0, '', ' ') ?>,-
                                    </td>
                                </tr>
                            <?php endif ?>
                            <tr>
                                <th scope="row">Prisantydning</th>
                                <td><?= number_format($property->prisantydning, 0, '', ' ') ?>,-</td>
                            </tr>
                            <tr>
                                <th scope="row">Salgssum</th>
                                <td><?= number_format($property->salgssum, 0, '', ' ') ?>,-</td>
                            </tr>
                            <tr>
                                <th scope="row">Oppdragsdato</th>
                                <td><?= date('j. F Y', $property->oppdragsdato) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Markedsføringsdato</th>
                                <td><?= $property->markedsforingsdato !== 0 ? date('j. F Y', $property->markedsforingsdato) : '-' ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Akseptdato</th>
                                <td><?= date('j. F Y', strtotime(date($property->akseptdato))) ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Befaringsdato</th>
                                <td><?= $property->befaringsdato !== '' ? date('j. F Y', strtotime(date($property->befaringsdato))) : '-' ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Over prisantydning</th>
                                <td><?= $property->salgssum ? round(($property->salgssum - $property->prisantydning) * 100 / $property->salgssum, 1) : 0 ?>
                                    %
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
            </td>
            <?php endif ?>
            <td style="max-width: 350px; white-space: normal; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table m-table m-table--head-no-border table-hover tabababa">
                        <tbody>
                        <?php foreach ($details as $label => $detail): ?>
                            <tr>
                                <th scope="row"><?= $label ?></th>
                                <td><?= $detail ?></td>
                            </tr>
                        <?php endforeach ?>
                        <?php if ($broker = $lead->user): ?>
                            <tr>
                                <th scope="row">Megler</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?= $broker->urlstandardbilde ?? '/images/default-user.png' ?>"
                                             class="m--img-rounded m--marginless table-schala-img"
                                             alt="<?= $broker->navn ?>"
                                             title="<?= $broker->navn ?>"
                                        >
                                        <div>
                                            <p class="table-schala-time"><?= $broker->navn ?></p>
                                            <?php if ($broker->department): ?>
                                                <p class="table-schala-time-ago"><?= $broker->department->short_name ?></p>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
