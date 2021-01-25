<?php

use common\models\Boligvarsling;
use yii\helpers\Url;

/* @var yii\web\View $this */
/* @var Boligvarsling[] $subscriptions */

$this->title = 'Abonnementene dine';

$js = <<<JS
    $('.js-subscription-toggle').change(function (event) {
      event.preventDefault();
      
      let form = $(this).parents('td').find('form');
      
      if (form.length) {
        $.post(form.prop('action'), {id: $(this).val()})
      }
    });
JS;

$this->registerJs($js);

?>

<?php $this->beginBlock('page_header') ?>
<header class="header">
  <div class="container">
    <h1><?= $this->title ?></h1>
    <div class="table-responsive">
      <table class="table table-sm">
        <thead>
        <tr>
          <th scope="col">BOLIGTYPE</th>
          <th scope="col">PRIS</th>
          <th scope="col">KVM</th>
          <th scope="col">SOVEROM</th>
          <th scope="col">REGISTRERING</th>
          <th scope="col">ABONNERER</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subscriptions as $subscription): ?>
          <tr>
            <th scope="row"><?= $subscription->getPropertyTypesHumanize() ?></th>
            <td><?= $subscription->getCostRangeHumanize() ?></td>
            <td><?= $subscription->getAreaRangeHumanize() ?></td>
            <td><?= $subscription->getRoomsHumanize() ?></td>
            <td><?= $subscription->created_at ?></td>
            <td>
              <input id="subscription_<?= $subscription->id ?>" class="input_check js-subscription-toggle"
                     type="checkbox" <?= $subscription->subscribe ? 'checked' : '' ?> value="<?= $subscription->id ?>">
              <label for="subscription_<?= $subscription->id ?>" class="label_check mt-0">
                &nbsp;
              </label>
              <form action="<?= Url::toRoute(['forms/subscriptions', 'hash' => Yii::$app->request->get('hash')]) ?>">
              </form>
            </td>
          </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</header>
<?php $this->endBlock() ?>
