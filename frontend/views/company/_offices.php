<?php

/**
 * Created by PhpStorm.
 * User: FSW10
 * Date: 14.03.2019
 * Time: 17:11
 */

/* @var $this \yii\web\View */
?>


<div class="main">
    <div class="velkommen_body">
        <div class="vm_left">
            <div class="ic_body">
                <h1><?= Yii::$app->view->params['header'] ?></h1>
            </div>
            <form class="vc_body" action="/company/office-search" method="get">

                <div class="frow vm_search">
                    <div class="vms_title">SKRIV DITT POSTNUMMER</div>
                    <input type="text" name="postNumber" class="styler" value="" placeholder=""/>
                </div>
                <div class="two_btn">
                    <div class="frow">
                        <button class="btn btn_s btn_more" id="post-search">SØK</button>
                    </div>
                </div>
            </form>
            <div style="margin: 30px 0">
                eller velg fra listen
            </div> 
            <div class="kontorerliste">
                <a href="/office/Bj%C3%B8rvika">Bjørvika/Gamle Oslo</a>
                <a href="/office/Carl%20Berner">Carl Berner</a>
                <a href="/office/Gr%C3%BCnerl%C3%B8kka">Grünerløkka</a>
                <a href="/office/Kalbakken">Kalbakken</a>
                <a href="/office/Sagene">Sagene</a>
                <a href="/office/Torshov">Torshov</a>
            </div>
        </div>
    </div>
</div>
