<h2><b>VEGARD TØNSBERG - Velg tjeneste (4)</b></h2>
<div class="row">
    <div class="col-12">
        <ul class="tjeneste_checkbox_list">
            <form id="tjenester-form" action="/booking/tjenester" method="post">
                <li class="pr-3">
                    <input type="checkbox" name="tjenester[]" id="checkbox_1" class="input_check"
                           value="Verdivurdering / E-takst">
                    <label class="label_check text-left" for="checkbox_1">
                        <h4 class="m-0">Verdivurdering / E-takst</h4>
                        <p>Tar ca. 1 time</p>
                    </label>
                </li>
                <li class="pr-3">
                    <input type="checkbox" name="tjenester[]" id="checkbox_2" class="input_check"
                           value="Befaring for å selge bolig">
                    <label class="label_check text-left" for="checkbox_2">
                        <h4 class="m-0">Befaring for å selge bolig</h4>
                        <p>Tar ca. 1 time</p>
                    </label>
                </li>
                <li class="pr-3">
                    <input type="checkbox" name="tjenester[]" id="checkbox_3" class="input_check"
                           value="J Befaring for salg av tomt / prosjekt">
                    <label class="label_check text-left" for="checkbox_3">
                        <h4 class="m-0">J Befaring for salg av tomt / prosjekt</h4>
                        <p>Tar ca. 1 time</p>
                    </label>
                </li>
                <li class="pr-3">
                    <input type="checkbox" name="tjenester[]" id="checkbox_4" class="input_check" value="Annet">
                    <label class="label_check text-left" for="checkbox_4">
                        <h4 class="m-0">Annet</h4>
                    </label>
                </li>
            </form>
        </ul>
    </div>
</div>
<br>
<div class="mt-5 navigate-container">
    <button class="order float-right" id="tjenester-next" disabled>Neste steg</button>
    <button class="order" data-url="/booking/kontorer">Gå tilbake</button>
</div>