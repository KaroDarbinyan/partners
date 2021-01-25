<?php

/* @var $users \common\models\User[] */

$inntekt = 0;
$snittprovisjon = 0;
$hitrate = 0;
$befaringer = 0;
$salg = 0;
$count = 0;



foreach ($users as $user): ?>



    <?php if ($user->budsjett): ?>
        <?php $inntekt += $user->budsjett->inntekt;
        $snittprovisjon += $user->budsjett->snittprovisjon;
        $hitrate += $user->budsjett->hitrate;
        $befaringer += $user->budsjett->befaringer;
        $salg += $user->budsjett->salg;
        if ($user->budsjett->hitrate != '0') {
            $count++;
        }
        ?>
        <tr class="budsjett-calc" data-id="<?= $user->web_id; ?>" data-avdeling_id="<?= $user->department_id; ?>">
            <td><?= $user->navn; ?></td>
            <td><?= $user->department->short_name; ?></td>
            <td><input class="inntekt" name="inntekt" type="number" value="<?= $user->budsjett->inntekt; ?>"></td>
            <td><input class="snittprovisjon" name="snittprovisjon" type="number"
                       value="<?= $user->budsjett->snittprovisjon; ?>"></td>
            <td><input class="hitrate" name="hitrate" type="number" value="<?= $user->budsjett->hitrate; ?>"></td>
            <td class="befaringer"><?= $user->budsjett->befaringer; ?></td>
            <input type="hidden" name="befaringer" class="befaringer" value="<?= $user->budsjett->befaringer; ?>">
            <td class="salg"><?= $user->budsjett->salg; ?></td>
            <input type="hidden" name="salg" class="salg" value="<?= $user->budsjett->salg; ?>">
        </tr>
    <?php else: ?>
        <tr class="budsjett-calc" data-id="<?= $user->web_id; ?>" data-avdeling_id="<?= $user->id_avdelinger; ?>">
            <td><?= $user->navn; ?></td>
            <td><?= $user->department->short_name ?? '' ?></td>
            <td><input class="inntekt" name="inntekt" type="number" value="0"></td>
            <td><input class="snittprovisjon" name="snittprovisjon" type="number" value="0"></td>
            <td><input class="hitrate" name="hitrate" type="number" value="0"></td>
            <td class="befaringer">0</td>
            <input type="hidden" name="befaringer" class="befaringer" value="0">
            <td class="salg">0</td>
            <input type="hidden" name="salg" class="salg" value="0">
        </tr>
    <?php endif; ?>

<?php endforeach; ?>
<tr id="sum-row">
    <th>Sum</th>
    <th></th>
    <th id="inntekt"><?= number_format($inntekt, 0, ' ', ' '); ?></th>
    <th id="snittprovisjon"><?= number_format($snittprovisjon, 0, ' ', ' '); ?></th>
    <th id="hitrate"><?= $count == 0 ? $hitrate : number_format($hitrate / $count, 1, '.', '.'); ?></th>
    <th id="befaringer"><?= number_format($befaringer, 0, ' ', ' '); ?></th>
    <th id="salg"><?= number_format($salg, 0, ' ', ' '); ?></th>
</tr>

