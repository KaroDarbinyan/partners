<div class="collapse" id="collapseFilter">

    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet m-portlet--mobile m-portlet--body-progress- margin-bottom-0">
                <div class="m-portlet__body">

                    <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label ionrange-label-fix">Adresse:</label>
                            <div class="col-lg-3">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" id="m_slider_adresse"/>
                                </div>
                            </div>
                            <label class="col-lg-2 col-form-label ionrange-label-fix">Prisantydning:</label>
                            <div class="col-lg-3">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" id="m_slider_prisantydning"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label ionrange-label-fix">Primærrom:</label>
                            <div class="col-lg-3">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" id="m_slider_primaerrom"/>
                                </div>
                            </div>
                            <label class="col-lg-2 col-form-label ionrange-label-fix">Salgssum:</label>
                            <div class="col-lg-3">
                                <div class="m-ion-range-slider">
                                    <input type="hidden" id="m_slider_salgssum"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Postnummer:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect"
                                        id="m_solgte_postnummer" name="param" multiple="multiple">
                                    <optgroup label="Sagene">
                                        <option value="AK" selected>0553</option>
                                        <option value="HI">0566</option>
                                    </optgroup>
                                    <optgroup label="Torshov">
                                        <option value="CA">0557</option>
                                        <option value="NV" selected>0556</option>
                                        <option value="OR">0571</option>
                                        <option value="WA">0564</option>
                                    </optgroup>
                                    <optgroup label="Carl Barner">
                                        <option value="AZ">0567</option>
                                        <option value="CO">0568</option>
                                        <option value="ID">0569</option>
                                        <option value="MT" selected>0670</option>
                                        <option value="NE">0671</option>
                                        <option value="NM">0672</option>
                                        <option value="ND">0673</option>
                                        <option value="UT">0674</option>
                                        <option value="WY">0675</option>
                                    </optgroup>
                                    <optgroup label="Kalbakken">
                                        <option value="AL">0880</option>
                                        <option value="AR">0881</option>
                                        <option value="IL">0882</option>
                                        <option value="IA">0883</option>
                                        <option value="KS">0884</option>
                                        <option value="KY">0885</option>
                                        <option value="LA">0886</option>
                                        <option value="MN">0887</option>
                                        <option value="MS">0888</option>
                                        <option value="MO">0830</option>
                                        <option value="OK">0833</option>
                                        <option value="SD">0834</option>
                                        <option value="TX">0835</option>
                                        <option value="TN">0836</option>
                                        <option value="WI">0837</option>
                                    </optgroup>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Medlem:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect" id="m_solgte_medlem"
                                        name="param" multiple="multiple">
                                    <option>Schala & Partners</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Eindomstype:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect"
                                        id="m_solgte_eindomstype" name="param" multiple="multiple">
                                    <option value="HI">Aksjeleilighet</option>
                                    <option value="HI">Andelsleilighet</option>
                                    <option value="HI">Annet</option>
                                    <option value="HI">Boligtomt</option>
                                    <option value="HI" selected>Enebolig</option>
                                    <option value="HI">Garasje selveier</option>
                                    <option value="HI" selected>Leilighet</option>
                                    <option value="HI">Leilighet selveier</option>
                                    <option value="HI">Næringsbygg</option>
                                    <option value="HI">Parkeringsplass</option>
                                    <option value="HI">Tomannsbolig</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Kontor:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect" id="m_solgte_kontorer"
                                        name="param" multiple="multiple">
                                    <option>Bjørvika / Gamle Oslo</option>
                                    <option>Carl Berner</option>
                                    <option>Grünerløkka</option>
                                    <option>Kalbakken</option>
                                    <option>Oslo Vest</option>
                                    <option>Sagene</option>
                                    <option>Torshov</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group m-form__group row">
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Byggeår:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect" id="m_solgte_byggear"
                                        name="param" multiple="multiple">
                                    <option value="HI">1990</option>
                                    <option value="HI">1991</option>
                                    <option value="HI">1992</option>
                                    <option value="HI">1993</option>
                                    <option value="HI">1993</option>
                                    <option value="HI">1994</option>
                                    <option value="HI">1995</option>
                                    <option value="HI">1996</option>
                                    <option value="HI">1997</option>
                                    <option value="HI">1998</option>
                                    <option value="HI">1999</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label ionrange-label-fix2">Megler:</label>
                            <div class="col-lg-3">

                                <select class="form-control m-select2 schala-multiselect" id="m_solgte_megler"
                                        name="param" multiple="multiple">
                                    <optgroup label="Sagene">
                                        <option>Ada Kjenner</option>
                                        <option>Adrian Jensen</option>
                                        <option>Anders Sveen</option>
                                        <option>Andreas Ulfsrud</option>
                                        <option>Anette Borvik</option>
                                        <option>Anne Christensen</option>
                                        <option>Anne Grethe Følstad</option>
                                        <option>Beate Kylstad Larsen</option>
                                        <option>Berit Holmeide Vaagland</option>
                                        <option>Bjørnar Mikkelsen</option>
                                        <option>Brigt Stelander Skeie</option>
                                        <option>Bård Tisthamar</option>
                                        <option>Camilla Næss Kopperstad</option>
                                    </optgroup>
                                    <optgroup label="Carl Barner">
                                        <option>Carl Uthus</option>
                                        <option>Cathrine Haavelsrud</option>
                                        <option>Duy Vidar Tang</option>
                                        <option>Elisabeth Skjold</option>
                                        <option>Emil Månsson</option>
                                        <option>Erik Bryn Johannessen</option>
                                        <option>Erik Danielsen</option>
                                        <option>Eskil Næss hagen</option>
                                        <option>Espen Anker larsen</option>
                                        <option>Espen Skaar</option>
                                        <option>Eva Otnes</option>
                                        <option>Frederick Horntvedt</option>
                                        <option>Fredrik Bjerch-andresen</option>
                                        <option>Helene Molle</option>
                                        <option>Inge Mysen</option>
                                        <option>Joachim Schala</option>
                                        <option>Joakim Torp</option>
                                        <option>Kjerstin Falkum</option>
                                        <option>Kristen Brekke</option>
                                    </optgroup>
                                    <optgroup label="Toshov">
                                        <option>Lene Brekken</option>
                                        <option>Mads Nordahl</option>
                                        <option>Malin Brorsson</option>
                                        <option>Marius M. Myren</option>
                                        <option>Marius Wang</option>
                                        <option>Mona Irene Tunsli</option>
                                        <option>Morgan Løveid</option>
                                        <option>Morten Kvelland</option>
                                        <option>Oscar André Halsen</option>
                                        <option>Preben Emil Rasmussen</option>
                                        <option>Ramin Oddin</option>
                                        <option>Robin Rodahl</option>
                                        <option>Sigurd Følstad Skarsem</option>
                                    </optgroup>
                                    <optgroup label="Kalbakken">
                                        <option>Silje Rindahl Krogstad</option>
                                        <option>Sofie Lund</option>
                                        <option>Steffen Usterud</option>
                                        <option>Steinar Hånes</option>
                                        <option>Stine Charlotte granmo</option>
                                        <option>Tanju Uysal</option>
                                        <option>Terje Rindal</option>
                                        <option>Thomas Karlsen</option>
                                        <option>Thor Wæraas</option>
                                        <option>Torbjørn Skjelde</option>
                                        <option>Torfinn Sørvang</option>
                                        <option>Vegard Robertsen</option>
                                        <option>Vidar Tangstad</option>
                                        <option>Zehra Catak</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
