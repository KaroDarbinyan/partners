<?php

/* @var $this yii\web\View */

/* @var $property PropertyDetails */

use common\models\PropertyDetails;

?>
<style>

    .text-white {
        color: white;
    }

    h2 {
        margin-left: 10px
    }


    .container {
        width: 100%;
        position: absolute;
        left: 0;
        right: 0;
        margin: 0 auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        padding-top: 15px;
        padding-bottom: 15px;
        font-weight: 400;
    }

    td {
        height: 110px;
        padding: 10px;
        vertical-align: top;
    }

    th, td {
        color: white;
        background-color: rgba(134, 133, 133, 0.5) !important;
        width: 14.285%;
        border: 2px solid black;
    }

    .event {
        height: 10px;
        padding: 4px;
        vertical-align: middle;
        width: 100%;
        background-color: rgba(0, 0, 0, .5) !important;
        border: 1px solid silver;

    }

</style>

<?= $this->render('/befaring/pdf/partials/_calendar'); ?>
