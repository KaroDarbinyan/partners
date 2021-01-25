<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;

class MainAsset extends AssetBundle
{
    /**
     * The Web-accessible directory that contains the asset files in this bundle.
     *
     * @var string
     */
    public $basePath = '@webroot';

    /**
     * The base URL for the relative asset files listed in js and css.
     *
     * @var string
     */
    public $baseUrl = '@web';

    /**
     * List of CSS files that this bundle contains.
     *
     * @var array
     */
    public $css = [
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/default-skin/default-skin.min.css',
        'https://unpkg.com/swiper/swiper-bundle.min.css',
        'vendor/animate/animate.min.css',
        'vendor/fontawesome/css/all.min.css',
        'vendor/magnific-popup/magnific-popup.css',
        'vendor/sweetalert2/sweetalert2.css',
        'vendor/ion.rangeSlider/css/ion.rangeSlider.css',
        'vendor/easy-autocomplete/easy-autocomplete.min.css',
        'css/main.css'
    ];

    /**
     * List of JavaScript files that this bundle contains.
     *
     * @var array
     */
    public $js = [
        'https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js',
        'https://cdn.jsdelivr.net/npm/intersection-observer@0.7.0/intersection-observer.js',
        'https://cdn.jsdelivr.net/npm/vanilla-lazyload@15.1.1/dist/lazyload.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/photoswipe/4.1.3/photoswipe-ui-default.min.js',
        'https://unpkg.com/swiper/swiper-bundle.min.js',
        'vendor/wow/wow.min.js',
        'vendor/animate/animate-css.js',
        'vendor/magnific-popup/jquery.magnific-popup.min.js',
        'vendor/PageScroll2id/PageScroll2id.min.js',
        'vendor/sweetalert2/sweetalert2.all.min.js',
        'vendor/ion.rangeSlider/js/ion.rangeSlider.js',
        '/vendor/easy-autocomplete/jquery.easy-autocomplete.min.js',
        'js/jquery.blockUI.js',
        'js/common.js',
    ];

    /**
     * List of bundle class names that this bundle depends on.
     *
     * @var array
     */
    public $depends = [
        YiiAsset::class,
        RespondAsset::class,
    ];
}