<h2><b>Bekreftelse på bookingforespørsel</b></h2>
<div class="row confirmation">

    <div class="col-12">
        <div class="row">
            <div class="col-md-6"><p class="text-right">Du har valgt følgende megler:</p></div>
            <div class="col-md-6"><p class="text-left"><?= $data["department"]["director"]["short_name"]; ?></p></div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-md-6"><p class="text-right">Postnr. / sted:</p></div>
            <div class="col-md-6"><p class="text-left"><?= $data["department"]["postnummer"]; ?></p></div>
        </div>
    </div>


    <div class="col-12">
        <div class="row">
            <div class="col-md-6"><p class="text-right">Fornavn og etternavn:</p></div>
            <div class="col-md-6"><p class="text-left"><?= $data["formName"]; ?></p></div>
        </div>
    </div>


    <div class="col-12">
        <div class="row">
            <div class="col-md-6"><p class="text-right">Tjenesten:</p></div>
            <div class="col-md-6">
                <?php foreach ($data["tjenester"] as $datum): ?>
                    <p class="text-left"><?= $datum; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row">
            <div class="col-md-6"><p class="text-right">Dato:</p></div>
            <div class="col-md-6"><p class="text-left"><?= date("d.m.Y", $data["date"]); ?></p></div>
        </div>
    </div>

</div>

<br>
<div class="mt-5 navigate-container">
    <button class="order float-right" data-url="/">Hjemmeside</button>
</div>
