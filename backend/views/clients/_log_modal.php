<div class="modal fade show" id="interested_modal" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Loggføring</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="m-accordion m-accordion--bordered m-accordion--solid" role="tablist">
                    <form id="interested-form" method="post">
                        <input type="hidden" id="lead-id" class="form-control" name="id">

                        <div class="form-group jq-selectbox styler">
                            <label class="control-label" for="lead-log-type">Type</label>
                            <select id="lead-log-type" class="form-control styler is-logs-type" name="type" aria-required="true" aria-invalid="false">
                                <option value="1014">Påminnelse</option>
                                <option value="1020">Vunnet</option>
                                <?php /* <option value="Tapt">Tapt</option> */ ?>
                                <option value="1011">Har tatt kontakt</option>
                                <?php /* <option value="Får ikke kontakt">Får ikke kontakt</option> */ ?>
                                <option value="1008">Avtalt befaring</option>
                                <option value="1018">Utført befaring</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="lead-log-message">Beskjed</label>
                            <textarea id="lead-log-message" class="form-control styler" name="message"></textarea>
                        </div>

                        <div class="form-group is-for-notify">
                            <label class="control-label" for="lead-log-notify_at">Varsling kl.</label>
                            <input type="text" id="lead-log-notify_at" class="form-control styler is-datetimepicker" name="notify_at" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-dark">Ferdig</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
