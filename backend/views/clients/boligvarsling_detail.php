<?php

/** @var Boligvarsling[] $boligvarslings */

use common\models\Boligvarsling;
use yii\helpers\Url;

?>

<table class="table table-condensed">
  <thead>
  <tr role="row">
    <th>Abonnerer</th>
    <th>Varslet</th>
    <th>Registrering</th>
    <th>Sist endret</th>
    <th>Handlinger</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($boligvarslings as $key => $boligvarsling): ?>
    <tr role="row" class="<?= $key % 2 === 0 ? 'odd' : 'even' ?>">
      <td>
          <?php if ($boligvarsling->subscribe): ?>
            <div class="text-success"><i class="fa fa-check"></i></div>
          <?php else: ?>
            <div class="text-danger"><i class="fa fa-times-circle"></i></div>
          <?php endif ?>
      </td>
      <td><?= $boligvarsling->notify_at ? strftime('%d. %B %Y %H:%M', $boligvarsling->notify_at) : 'Aldri' ?></td>
      <td><?= $boligvarsling->created_at ?></td>
      <td><?= $boligvarsling->updated_at ?></td>
      <td><a href="<?= Url::toRoute(['clients/boligvarsling-edit', 'id' => $boligvarsling->id]) ?>"
             class="btn btn-default btn-xs" target="_blank">Redigere</a>
      </td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>
