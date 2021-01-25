<?php
/* @var $this yii\web\View */

use backend\components\UrlExtended;
use common\models\DigitalMarketing;
use common\models\Forms;
use common\models\PropertyDetails;
use yii\helpers\Url;

/* @var $model PropertyDetails */
/* @var $dm DigitalMarketing */

$this->title = 'Statistikk';

$model = $this->params['model'];


?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700|Oswald:300,600,700" rel="stylesheet">

<style>
    td, th {
        padding: 5px 10px;
        text-align: center;
    }
    td:first-child, th:first-child {
        padding: 5px 10px;
        text-align: left;
    }
</style>


<div style="color: white; flex: 1; max-width: 100%; height: 100%; background: #333333">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="forsiden-header" style="font: 300 30px 'Oswald', sans-serif; text-align: center;">DIGITAL MARKEDSFØRING</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="background: #2B2B2B; padding: 30px">
                <table style="margin: 0 auto; color: white; font: 400 14px 'Montserrat', sans-serif, 'Helvetica Neue', Helvetica;">
                    <thead>
                    <tr>
                        <th class="text-left pl-5">KLIDE</th>
                        <th>KLIKK</th>
                        <th>VISNINGER</th>
                        <th>UNIKE VISNINGER</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-left"><i class="socicon-facebook mr-3 pl-4"></i>Facebook</td>
                        <td><?= $dm['facebook']['clicks']; ?></td>
                        <td><?= $dm['facebook']['impressions']; ?></td>
                        <td><?= $dm['facebook']['reach']; ?></td>
                    </tr>
                    <tr>
                        <td class="text-left"><i class="socicon-instagram  mr-3 pl-4"></i>Instagram</td>
                        <td><?= $dm['instagram']['clicks']; ?></td>
                        <td><?= $dm['instagram']['impressions']; ?></td>
                        <td><?= $dm['instagram']['reach']; ?></td>
                    </tr>
                    <tr>
                        <th  class="text-left pl-5"></i>Programmatisk</th>
                        <th><?= $dm['deltaStandard']['clicks']; ?></th>
                        <th><?= $dm['deltaStandard']['impressions']; ?></th>
                        <th><?= $dm['deltaStandard']['reach']; ?></th>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-left pl-5">TOTALT</th>
                        <th><?= $dm['cl_sum']; ?></th>
                        <th><?= $dm['im_sum']; ?></th>
                        <th><?= $dm['rc_sum']; ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

