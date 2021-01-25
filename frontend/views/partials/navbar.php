<?php

use frontend\widgets\SearchWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
?>

<nav class="nav_bar">
  <div class="container">
    <div class="row align-items-center justify-content-between search-helper">
      <a href="<?= Url::home() ?>" class="logo">
        <img src="/img/logo.svg" alt="PARTNERS EIENDOMSMEGLING">
      </a>

      <ul class="menu">
        <li><a href="/verdivurdering" class="regular">Verdivurdering</a></li>
        <li><a href="/eiendommer">Eiendommer</a></li>
        <li><a href="<?= Url::toRoute(['eiendommer/nybygg']) ?>">Nybygg</a></li>
        <li><a href="<?= Url::toRoute(['dwelling/form']) ?>">Boligvarsling</a></li>
        <li><a href="/kontorer">Kontorer</a></li>
        <li><a href="/salgsprosessen">Salgsprosessen</a></li>
        <li><a href="/om-oss">Om oss</a></li>
        <li><a href="/kontakt">Kontakt oss</a></li>
        <li class="search-helper-absolute">
          <div class="box_search">
            <a href="#" class="search-button">
              <i class="icon" data-svg="/img/icon_search.svg"></i>
            </a>
          </div>
        </li>
      </ul>

      <div class="box_nav">
        <button class="mob_button">
          <span class="line_menu line-1"></span>
          <span class="line_menu line-2"></span>
          <span class="line_menu line-3"></span>
        </button>
      </div>
    </div>
  </div>
</nav>

<div class="search-wrap">
  <div class="search-main">
    <form method="post">
        <?= SearchWidget::widget() ?>
    </form>
  </div>
</div>
