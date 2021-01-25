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
    html, body {
        margin: 0;
        padding: 0;
    }
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
            <h1 class="forsiden-header" style="font: 300 30px 'Oswald', sans-serif; text-align: center;">Facebook</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="background: #2B2B2B; padding: 30px">
               <table style="margin: 0 auto; color: white; font: 400 14px 'Montserrat', sans-serif, 'Helvetica Neue', Helvetica;">
                    <tbody>
                        <tr>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['facebook']['clicks']; ?><br/>
                                <span style="font-size: 20px; color: white;">klikk</span>
                            </td>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['facebook']['impressions']; ?><br/>
                                <span style="font-size: 20px; color: white;">visninger</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="forsiden-header" style="font: 300 30px 'Oswald', sans-serif; text-align: center;">Instagram</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="background: #2B2B2B; padding: 30px">
               <table style="margin: 0 auto; color: white; font: 400 14px 'Montserrat', sans-serif, 'Helvetica Neue', Helvetica;">
                    <tbody>
                        <tr>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['instagram']['clicks']; ?><br/>
                                <span style="font-size: 20px; color: white;">klikk</span>
                            </td>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['instagram']['impressions']; ?><br/>
                                <span style="font-size: 20px; color: white;">visninger</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    
    <div class="row">
        <div class="col-lg-12">
            <h1 class="forsiden-header" style="font: 300 30px 'Oswald', sans-serif; text-align: center;">Programmatisk</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="background: #2B2B2B; padding: 30px">
               <table style="margin: 0 auto; color: white; font: 400 14px 'Montserrat', sans-serif, 'Helvetica Neue', Helvetica;">
                    <tbody>
                        <tr>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['deltaStandard']['clicks']; ?><br/>
                                <span style="font-size: 20px; color: white;">klikk</span>
                            </td>
                            <td style="text-align: center; color: #24B196; font-size: 50px">
                                <?= $dm['deltaStandard']['impressions']; ?><br/>
                                <span style="font-size: 20px; color: white;">visninger</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>