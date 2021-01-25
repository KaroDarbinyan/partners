<?php

/* @var $this yii\web\View */
/* @var $model \common\models\Forms */
/* @var $showMessage bool */

?>

<div class="modal fade" id="valuation-modal" tabindex="-1" role="dialog" aria-labelledby="valuationModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="valuationModalCenterTitle">VERDIVURDERING</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->render('@frontend/views/partials/valuationForm.php',
                    compact('model', 'showMessage')
                ) ?>
            </div>
        </div>
    </div>
</div>

