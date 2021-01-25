<?php

use common\models\Image;
use common\models\PropertyDetails;
use yii\web\View;

/* @var yii\web\View $this */
/* @var PropertyDetails $property */
/* @var Image[] $images */
/* @var boolean $isSolgt */

$this->registerJsFile('@web/js/property-gallery.js?v=1.0.6', ['depends' => ['yii\web\JqueryAsset']], View::POS_READY)

?>

<div class="property-gallery container">
    <?php if ($isSolgt): ?>
      <img src="/img/sold.png" alt="Solgt" class="big-sold">
    <?php endif ?>
  <div class="swiper-container">
    <ul class="swiper-wrapper photo-gallery">
        <?php foreach ($images as $key => $image): ?>
          <li class="swiper-slide">
            <a href="<?= $image->path(1920) ?>" title="Klikk på bildet for full størrelse"
               data-caption="<b><?= $key + 1 ?></b>/<b><?= count($images) ?></b> &centerdot; <?= $image->overskrift ?>"
               data-size="<?= $image->width ?? 0 ?>x<?= $image->height ?? 0 ?>">
              <img data-src="<?= $image->path(1920) ?>" alt="<?= $image->overskrift ?>" class="swiper-lazy">
              <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
            </a>
          </li>
        <?php endforeach ?>
        <?php if ($property->has360View()): ?>
          <li class="swiper-slide">
            <iframe allow="vr" allowfullscreen="" frameborder="0" height="100%"
                    src="<?= $property->urlbilder . '&title=0&f=0&mls=1&play=0&qs=0&dh=1&gt=0&hr=0&vr=0&pin=0' ?>"
                    width="100%" data-html="true"></iframe>
          </li>
        <?php endif ?>
    </ul>
    <div class="swiper-button-next swiper-button-white"></div>
    <div class="swiper-button-prev swiper-button-white"></div>
    <div class="swiper-pagination"></div>
  </div>
</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="pswp__bg"></div>
  <div class="pswp__scroll-wrap">
    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>
    <div class="pswp__ui pswp__ui--hidden">
      <div class="pswp__top-bar">
        <div class="pswp__counter"></div>
        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
        <button class="pswp__button pswp__button--share" title="Share"></button>
        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

        <div class="pswp__preloader">
          <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>

      <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
      <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>

      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>
    </div>
  </div>
</div>