<?php
/* @var $employer \common\models\User */
$urlEm = '/ansatte/'.$employer->navn;
$department = $employer->department;
$departmentName = $department? $employer->department->short_name : '';

use yii\helpers\Html;

?>
<div class="one-broker">
    <div class="">
        <a href="<?= $urlEm?>">
            <img src="<?= $employer->urlstandardbilde; ?>"
                 alt="<?= $employer->navn; ?>">
        </a>
    </div>
    <h3 class=""><?= $employer->navn ?></h3>

    <div class="">

        <ul>

            <?php
            // if($departmentName) {
            //     echo Html::tag('li', 'Avdelingsleder');
            //     echo Html::tag('li', $departmentName);
            // }
            $title =  $employer->tittel;
            echo Html::tag('li', $title);
            ?>
        </ul>

        <div class="vu_phone">
            <?php if ($employer->mobiltelefon): ?>
                <a href="tel:<?=$employer->mobiltelefon ?>"><?= $employer->mobiltelefon ?></a><br/>                
            <?php endif; ?>
            <?php if ($employer->email): ?>
                <a href="mailto:<?=$employer->email ?>"><?= $employer->email ?></a>
            <?php endif; ?>


        </div>

    <div class="vu_contact">
            <label
                data-check-target = "<?= "__broker_{$employer->web_id}" ?>"
                for="<?= "__broker_{$employer->web_id}" ?>"
                href="#kontakt-meg"
                class="popup btn btn_ss"
            >KONTAKT MEG</label>
        </div>
    </div>

</div>