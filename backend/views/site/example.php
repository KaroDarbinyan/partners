<?php
 use backend\assets\AppAsset;

$this->registerJsFile('admin/js/lead-registrere.js',
    ['depends' => [AppAsset::className()]]);

$this->registerJsFile('admin/js/google-maps.js',
    ['depends' => [AppAsset::className()]]);


?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">

    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->

    <div class="m-content">

        <!--Begin::Main Portlet-->
        <div class="m-portlet m-portlet--full-height">


            <!--end: Portlet Head-->

            <!--begin: Portlet Body-->
            <div class="m-portlet__body m-portlet__body--no-padding">

                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--4 m-wizard--brand" id="m_wizard">
                    <div class="row m-row--no-padding">
                        <div class="col-xl-3 col-lg-12 m--padding-top-20 m--padding-bottom-15">

                            <!--begin: Form Wizard Head -->
                            <div class="m-wizard__head">

                                <!--begin: Form Wizard Nav -->
                                <div class="m-wizard__nav">
                                    <div class="m-wizard__steps">
                                        <div class="m-wizard__step m-wizard__step--done" m-wizard-target="m_wizard_form_step_1">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>1</span></span>
                                                </a>
                                                <div class="m-wizard__step-label">
                                                    Område
                                                </div>
                                                <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                            </div>
                                        </div>
                                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>2</span></span>
                                                </a>
                                                <div class="m-wizard__step-label">
                                                    Kriterier
                                                </div>
                                                <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                            </div>
                                        </div>
                                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3">
                                            <div class="m-wizard__step-info">
                                                <a href="#" class="m-wizard__step-number">
                                                    <span><span>3</span></span>
                                                </a>
                                                <div class="m-wizard__step-label">
                                                    Kontakter
                                                </div>
                                                <div class="m-wizard__step-icon"><i class="la la-check"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--end: Form Wizard Nav -->
                            </div>

                            <!--end: Form Wizard Head -->
                        </div>
                        <div class="col-xl-9 col-lg-12">

                            <!--begin: Form Wizard Form-->
                            <div class="m-wizard__form">

                                <!--
            1) Use m-form--label-align-left class to alight the form input lables to the right
            2) Use m-form--state class to highlight input control borders on form validation
        -->
                                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="m_form">

                                    <!--begin: Form Body -->
                                    <div class="m-portlet__body m-portlet__body--no-padding">

                                        <!--begin: Form Wizard Step 1-->

                                        <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">

                                            <div id="map" style="height:400px; width: 100%;"></div>

                                        </div>


                                        <!--end: Form Wizard Step 1-->

                                        <!--begin: Form Wizard Step 2-->
                                        <div class="m-wizard__form-step" id="m_wizard_form_step_2">

                                            <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-3 col-form-label ionrange-label-fix">Primærrom:</label>
                                                    <div class="col-lg-7">
                                                        <div class="m-ion-range-slider">
                                                            <input type="hidden" id="m_slider_kvm" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-3 col-form-label ionrange-label-fix">Pris:</label>
                                                    <div class="col-lg-7">
                                                        <div class="m-ion-range-slider">
                                                            <input type="hidden" id="m_slider_pris" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <label class="col-lg-3 col-form-label ionrange-label-fix2">Eindomstype:</label>
                                                    <div class="col-lg-7">

                                                        <select class="form-control m-select2 schala-multiselect" id="m_solgte_eindomstype" name="param" multiple="multiple">
                                                            <option value="HI">Diverse</option>
                                                            <option value="HI" selected>Enebolig</option>
                                                            <option value="HI">Fritid</option>
                                                            <option value="HI" selected>Leilighet</option>
                                                            <option value="HI">Næring</option>
                                                            <option value="HI">Rekkehus</option>
                                                            <option value="HI">Tomannsbolig</option>
                                                            <option value="HI">Tomtetyper</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                        <!--end: Form Wizard Step 2-->

                                        <!--begin: Form Wizard Step 3-->
                                        <div class="m-wizard__form-step" id="m_wizard_form_step_3">

                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label ionrange-label-fix2">Navn:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control m-input">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label ionrange-label-fix2">Postnummer:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control m-input">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label ionrange-label-fix2">Telefon:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control m-input">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label ionrange-label-fix2">E-post:</label>
                                                <div class="col-lg-7">
                                                    <input type="text" class="form-control m-input">
                                                </div>
                                            </div>
                                            <div class="form-group m-form__group row">
                                                <label class="col-lg-3 col-form-label"></label>
                                                <div class="col-lg-7">
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox m-checkbox--success">
                                                            <input type="checkbox"> Jeg selger bolig og ønsker å bli kontaktet via telefon / e-post
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>




                                        </div>

                                        <!--end: Form Wizard Step 3-->

                                    </div>

                                    <!--end: Form Body -->

                                    <!--begin: Form Actions -->
                                    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
                                        <div class="m-form__actions">
                                            <div class="row">
                                                <div class="col-lg-6 m--align-left">
                                                    <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
																		<span>
																			<i class="la la-arrow-left"></i>&nbsp;&nbsp;
																			<span>Tilbake</span>
																		</span>
                                                    </a>
                                                </div>
                                                <div class="col-lg-6 m--align-right">
                                                    <a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--icon" data-wizard-action="submit">
																		<span>
																			<i class="la la-check"></i>&nbsp;&nbsp;
																			<span>Send</span>
																		</span>
                                                    </a>
                                                    <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon" data-wizard-action="next">
																		<span>
																			<span>Fortsette</span>&nbsp;&nbsp;
																			<i class="la la-arrow-right"></i>
																		</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end: Form Actions -->
                                </form>
                            </div>

                            <!--end: Form Wizard Form-->
                        </div>
                    </div>
                </div>

                <!--end: Form Wizard-->
            </div>

            <!--end: Portlet Body-->
        </div>

        <!--End::Main Portlet-->
    </div>
</div>