<?php
/** @var \yii\data\ActiveDataProvider $dataProvider */

use nullref\datatable\DataTable;
?>
<div style = "color: black;">
<?php
try {
    echo DataTable::widget([
        'data' => $dataProvider->getModels(),
        'columns' => [
            'id',
            'name',
            'email'
        ],
        'withColumnFilter' => true,
    ]);
} catch (Exception $e) {
    echo $e->getMessage();
} ?>
</div>
