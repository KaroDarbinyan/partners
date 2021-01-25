<?php

/* @var $this View */

use yii\helpers\Url;
use yii\web\View;

?>

<?php $this->beginBlock('head') ?>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?= $this->title ?>"/>
    <meta property="og:description"
          content="Partners er en nytenkende uavhengig eiendomsmeglerkjede med et brennende engasjement og interesse for lokalmiljøet,
           og dermed også høy lokalkunnskap og lokalkjennskap. Velger du Partners kan du være trygg på at vi håndplukker
           den aller beste megleren for deg og din bolig. Vi er ikke eid av en bank. Derfor har vi friheten til å kun fokusere på
           det vi skal være best på – eiendom – noe våre kunder nyter godt av."/>
    <meta property="og:url" content="<?= Url::current([], true); ?>"/>
    <meta property="og:image" content="<?= Url::home(true); ?>img/property-default.jpg"/>
    <meta property="og:site_name" content="PARTNERS.NO"/>
<?php $this->endBlock() ?>


<?php $this->beginBlock('page_header') ?>
<header class="header">
    <div class="container">
        <div class="w-75 mx-auto">
            <div class="page-header text-center">
                <h1><?= Yii::$app->view->params['header'] ?></h1>
            </div>
            <p>Partners er en nytenkende uavhengig eiendomsmeglerkjede med et brennende engasjement og interesse for lokalmiljøet, og dermed også høy lokalkunnskap og lokalkjennskap. Velger du Partners kan du være trygg på at vi håndplukker den aller beste megleren for deg og din bolig. Vi er ikke eid av en bank. Derfor har vi friheten til å kun fokusere på det vi skal være best på – eiendom – noe våre kunder nyter godt av. </p>

            <p>Meglerne tilknyttet oss er våre ess i ermet og våre største helter. Det er meglerne som definerer Partners og skiller oss fra våre konkurrenter. Våre kontorer kaprer stadig større markedsandeler i byene sine – nettopp på grunn av godt meglerhåndverk og en innarbeidet, solid salgsprosess. Velger du Partners så velger du en god opplevelse, hvor du skal bli ivaretatt, informert og orientert, fra den første samtalen med oss til den siste.</p>

            <p>Sammen med deg utarbeider vi en salgsstrategi skreddersydd til din bolig, med målrettet markedsføring i relevante kanaler, tradisjonelle og nye. Både vårt boligkjøperregister og våre innsiktsanalyser gjør at vi finner de kjøperne som er på jakt etter akkurat din bolig. Og i kombinasjon med våre lokalkjente meglere, sikrer vi et best mulig boligsalg for alle involverte parter. Der både selger og kjøper signerer avtalen med en god magefølelse.</p>

            <p>Hos Partners er du alltid hjertelig velkommen, og vi gleder oss til å ønske kjøperne velkommen til deg.</p>
        </div>
    </div>
</header>
<?php $this->endBlock() ?>

<?= $this->render('@frontend/views/partials/jobs.php') ?>
