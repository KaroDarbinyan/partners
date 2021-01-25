<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = 'Siden ikke funnet';

?>

<?php $this->beginBlock('page_header') ?>
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <span style="font-size: 100px;">404</span>
                        <h1><?= $this->title ?></h1>
                        <p>&nbsp;</p>
                        <a href="/verdivurdering" class="order">VERDIVURDERING</a>
                        <p class="pt-3">eller</p>
                        <a href="/eiendommer" class="order">VIS EIENDOMMER TIL SALGS</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
<?php $this->endBlock() ?>
