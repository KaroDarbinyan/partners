<?php

/* @var $this yii\web\View */

/* @var $property PropertyDetails */

use common\components\StaticMethods;
use common\models\PropertyDetails;

$events = [];


foreach (Yii::$app->params['events'] as $event) {
    if (!isset($events[$event->start_time])) {
        $events[$event->start_time] = [];
    }
    $events[$event->start_time][] = $event;
}


$months = ["01" => "JANUAR", "02" => "FEBRUAR", "03" => "MARS", "04" => "APRIL", "05" => "MAI", "06" => "JUNI", "07" => "JULI", "08" => "AUGUST", "09" => "SEPTEMBER", 10 => "OKTOBER", 11 => "NOVEMBER", 12 => "DESEMBER"];
$selected_date = '';

$time = time();
//$time = strtotime('2020-10-23');
$date_format = date("Y-m-d", $time);

$next_month = date('m', strtotime("{$date_format} +1 month"));
$prev_month = date('m', strtotime("{$date_format} -1 month"));

$today = date("d", $time); // Current day
$month = date("m", $time); // Current month
$year = date("Y", $time); // Current year

$days = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Days in current month
$last_month = date("t", mktime(0, 0, 0, $month - 1, 1, $year)); // Days in previous month
$start = date("N", mktime(0, 0, 0, $month, 1, $year)); // Starting day of current month
$finish = date("N", mktime(0, 0, 0, $month, $days, $year)); // Finishing day of  current month
$last_start = $start - 1; // Days of previous month in calander

$counter = 0;
$next_month_counter = 1;

if ($start > 5) {
    $rows = 6;
} else {
    $rows = 5;
}


?>

<style>
    h2 {
        width: 100%;
        text-align: center;
        padding: 10px 0;
    }
</style>

<div class="container">
    <h2 class="text-white"><?= "{$months[$month]} {$year}"; ?></h2>
    <table>
        <thead>
        <tr>
            <th>Mandag</th>
            <th>Tirsdag</th>
            <th>Onsdag</th>
            <th>Torsdag</th>
            <th>Fredag</th>
            <th>Lørdag</th>
            <th>Søndag</th>
        </tr>
        </thead>
        <tbody>
        <?php

        for ($i = 1; $i <= $rows; $i++): ?>
            <tr class="week">
                <?php for ($x = 1; $x <= 7; $x++): ?>

                    <?php

                    $class = '';
                    $counter++;
                    if (($counter - $start) < 0) {
                        $date = (($last_month - $last_start) + $counter);
                        $class = 'class="blur"';
                        $selected_date = "{$year}-{$prev_month}-{$date}";
                    } else if (($counter - $start) >= $days) {
                        $date = ($next_month_counter);
                        $next_month_counter++;
                        $class = 'class="blur"';
                        $selected_date = "{$year}-{$next_month}-0{$date}";
                    } else {
                        $date = ($counter - $start + 1);
                        $selected_date = "{$year}-{$month}-{$date}";
                        if ($today == $counter - $start + 1) {
                            $class = 'class="today"';
                        }
                    }
                    ?>
                    <td <?= $class ?>>
                        <p class="date"><?= $date; ?></p>
                        <?php if (isset($events[$selected_date])): ?>
                            <table style="margin-top: 5px">
                                <?php foreach ($events[$selected_date] as $event): ?>
                                    <tr class="tr">
                                        <td class='event'><p><?= $event['event']["name"]; ?></p></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        <?php endif; ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
        </tbody>
    </table>
</div>
