<?php

use Codeception\Module\Yii1;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'BEFARING';
$this->registerCssFile('/css/befaring/node.css?v=123456')
/* @var $this yii\web\View */

?>

<?php if($msg = Yii::$app->session->getFlash('success')): ?>
    <div class="text-success"><?= $msg ?></div>
<?php endif;?>

<div class="notater">
    <div class="notater-header">
        <img class="pencil" src="/img/befaring/icons/Group 1793.svg" alt="pen"> <span>Notater</span>
    </div>

    <div class="notate-wrapper">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'notater-content'
            ],
            'method' => 'post',
        ]); ?>

        <div class="form-group">
            <input type="text" name="title" value="" placeholder="Title..." autofocus>
        </div>

        <div class="form-group">
            <textarea name="notes" rows="10" placeholder="Write the notate..."></textarea>
        </div>

        <?= Html::submitButton('Send på e-post', ['class' => 'btn btn-notate']) ?>

        <div class="clearfix"></div>
        
        <?php ActiveForm::end(); ?>
    </div>
</div>
