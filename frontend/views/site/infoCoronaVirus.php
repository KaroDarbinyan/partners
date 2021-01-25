<?php

/* @var $this \yii\web\View */

?>



<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="w-75 mx-auto">
            <div class="page-header text-center">
                <h1>Retningslinjer for visning</h1>
            </div>
            <ol class="ul-ol-default">
                <li>Ta kontakt med megler før visning og meld fra at du kommer. Informer om du er i en risikogruppe, er i karantene eller har symptomer på smitte. </li>
                <li>Unngå håndhilsning eller annen fysisk kontakt på visning – vi bruker smil i stedet. </li>
                <li>Alle visningsdeltakere oppfordres til god hoste- og håndhygiene. </li>
                <li>Hold minst 1 meters avstand til andre på visning. </li>
                <li>Ikke berør noe i boligen. Ta kontakt med megler dersom det er behov for å undersøke noe som forutsetter berøring. </li>
                <li>Ikke berør noe unødvendig i fellesarealer som fellesoppganger eller felles inngangsparti i sameie, borettslag og andre bygg med innvendige fellesarealer. Vent utenfor bygningen dersom du ikke kommer inn på vising umiddelbart. </li>
                <li>Visning tilrettelegges for god håndhygiene med såpe, Antibac e.l. ved inngangsdør. </li>
                <li>Delta ikke på visning hvis du er i karantene, har vært i smitteområder eller har symptomer på korona-smitte. Ring megler ved usikkerhet, slik at alternative måter å vise boligen på kan vurderes. </li>
                <li>Fellesvisninger med mange deltakere unngås og erstattes av lengre visningstid med mindre puljer eller individuelle visninger basert på en konkret risikovurdering. </li>
                <li>Hvis selger er eldre eller i en annen risikogruppe, foreta en risikovurdering og tilrettelegge visning på en måte som minimaliserer risiko for at det etterlates smitte i boligen. </li>
                <li>Bruk av prospekt i papir bør unngås hvis det ikke kan skje uten smitterisiko. </li>
                <li>Reis til visning på en måte som ikke utsetter andre for unødvendig smitterisiko. </li>
            </ol>
            <p><strong>God visning! </strong></p>

        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?= $this->render('@frontend/views/partials/jobs.php') ?>
