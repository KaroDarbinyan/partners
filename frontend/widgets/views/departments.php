<?php

/** @var $this yii\web\View */
/** @var $groupedDepartments array */
/** @var string $textHeader */

?>

<div id="partner-offices" class="col-12 text-center">
    <h2 class="mt-5 mb-0"><?= $textHeader ?></h2>
</div>

<div class="col-12">
    <ul class="list_office">
        <?= $this->render("@frontend/views/partials/_office_list", compact('groupedDepartments')); ?>
    </ul>
</div>

<?= $this->render('@frontend/views/partials/departmentsModal') ?>

