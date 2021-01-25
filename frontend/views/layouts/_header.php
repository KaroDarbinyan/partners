<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (yii::$app->controller->id == 'dwelling' && yii::$app->controller->action->id == 'visning') {
    return '';
}

?>


<?php if (!!Yii::$app->params['google_analytics_enable']): ?>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162444681-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-162444681-1');
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144999206-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-144999206-1');
    </script>
    <script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym"); ym(54692584, "init", { clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/54692584" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <script type="text/javascript">
    var _d7=_d7||[];

    document.addEventListener('DOMContentLoaded', function() {
        var priceEl = document.querySelector('#price-value');
        var pageId = 'YOUR_PAGE_ID';
        if (priceEl && priceEl.dataset.price) {
            var p = priceEl.dataset.price;
            switch (true) {
                case (p > 2500000 && p <= 3500000):
                    pageId = 'prisklasse2'
                    break;
                case (p > 3500000 && p <= 5000000):
                    pageId = 'prisklasse3'
                    break;
                case (p > 5000000 && p <= 7000000):
                    pageId = 'prisklasse4'
                    break;
                case (p > 7000000):
                    pageId = 'prisklasse5'
                    break;

                default:
                    pageId = 'prisklasse1'
                    break;
            }
        }

        _d7.push({
            action:"pageView",
            pageId: pageId //PLEASE MAKE NO CHANGES TO PAGEID UNLESS INSTRUCTED OTHERWISE
        });
    });

    (function(){
        var d=document.createElement("script"),s=document.getElementsByTagName("script")[0];
        _d7.id="14430";_d7.p=("https:" == document.location.protocol ? "https://" : "http://");
        d.src=_d7.p+"tb.de17a.com/d7.js";d.type="text/javascript";d.async=1;s.parentNode.insertBefore(d,s);
    })();
    </script>
    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window,document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1937574599677180'); 
    fbq('track', 'PageView');
    </script>
    <noscript>
    <img height="1" width="1" src="https://www.facebook.com/tr?id=1937574599677180&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->

<?php endif ?>

<script id="CookieConsent" src="https://policy.app.cookieinformation.com/uc.js" data-culture="NB" type="text/javascript"></script>