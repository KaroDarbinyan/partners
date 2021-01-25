<?php
/** @var $userRatings array */
/** @var $choosenUser \common\models\User */
?>

<?php if (Yii::$app->mobileDetect->isMobile()) { ?>
    <?php /* MOBILE VERSION */ ?>

    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl block-dashboard-top">
            <div class="col-xs-12 col-sm-4 col-xl-4">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=aktiviteter">
                            <h3 class="m-widget14__title">
                                TOPP AKTIVITETER
                            </h3>
                        </a>
                        <span class="m-widget14__desc"></span>
                    </div>
                    <div class="row align-items-center">
                        <div class="col">
                            <table class="top5">

                                <?php if ($userRatings['aktiviteter']['best']): ?>
                                    <tr>
                                        <td>#1</td>
                                        <td><?= $userRatings['aktiviteter']['best']['user']['navn']; ?></td>
                                        <td><?= number_format($userRatings['aktiviteter']['best']['count'], 0, '', ' '); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php $aktiviteterClass = '';
                                $aktiviteterUser = false;
                                foreach ($userRatings['aktiviteter']['top'] as $key => $userRating): ?>
                                    <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                        $aktiviteterClass = 'class="me"';
                                        $aktiviteterUser = $userRatings['aktiviteter']['top'][$key];
                                    } ?>
                                    <tr <?php echo $aktiviteterClass;
                                    $aktiviteterClass = ''; ?> >
                                        <td>#<?= $userRating['index']; ?></td>
                                        <td><?= $userRating['user']['navn']; ?></td>
                                        <td><?= number_format($userRating['count'], 0, '', ' '); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <?php if ($aktiviteterUser): ?>
                            <div class="comeon">
                                <?php if (isset($aktiviteterUser['prev_count'])): ?>
                                    <span><?= number_format($aktiviteterUser['prev_count'] - $aktiviteterUser['count'] + 1, 0, '', ' '); ?> poeng igjen til <?= $aktiviteterUser['index'] - 1; ?>. plass</span>
                                <?php else: ?>
                                    <span>Du er best<br/>av de beste</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xs-12 col-sm-4 col-xl-4">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=signeringer">
                            <h3 class="m-widget14__title">
                                TOPP SIGNERINGER
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div class="row  align-items-center">
                        <div class="col">
                            <table class="top5">
                                <?php if ($userRatings['signeringer']['best']): ?>
                                    <tr>
                                        <td>#1</td>
                                        <td><?= $userRatings['signeringer']['best']['user']['navn']; ?></td>
                                        <td><?= number_format($userRatings['signeringer']['best']['count'], 0, '', ' '); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php $signeringerClass = '';
                                $signeringerUser = false;
                                foreach ($userRatings['signeringer']['top'] as $key => $userRating): ?>
                                    <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                        $signeringerClass = 'class="me"';
                                        $signeringerUser = $userRatings['signeringer']['top'][$key];
                                    } ?>
                                    <tr <?php echo $signeringerClass;
                                    $signeringerClass = ''; ?> >
                                        <td>#<?= $userRating['index']; ?></td>
                                        <td><?= $userRating['user']['navn']; ?></td>
                                        <td><?= number_format(floor($userRating['count']), 0, ' ', ' '); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <?php if ($signeringerUser): ?>
                            <div class="comeon">
                                <?php if (isset($signeringerUser['prev_count'])): ?>
                                    <span><?= number_format(floor($signeringerUser['prev_count'] - $signeringerUser['count'] + 1), 0, ' ', ' '); ?> NOK igjen til <?= $signeringerUser['index'] - 1; ?>. plass</span>
                                <?php else: ?>
                                    <span>Du er best<br/>av de beste</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xs-12 col-sm-4 col-xl-4">

                <!--begin:: Widgets/Revenue Change-->
                <a href="/admin/topplister/index?type=salg">
                    <div class="m-widget14">
                        <div class="m-widget14__header">
                            <h3 class="m-widget14__title">
                                TOPP SALG
                            </h3>
                            <span class="m-widget14__desc"></span>
                        </div>
                        <div class="row  align-items-center">
                            <div class="col">
                                <table class="top5">

                                    <?php if ($userRatings['salg']['best']): ?>
                                        <tr>
                                            <td>#1</td>
                                            <td><?= $userRatings['salg']['best']['user']['navn']; ?></td>
                                            <td><?= number_format($userRatings['salg']['best']['count'], 0, '', ' '); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php $salgClass = '';
                                    $salgUser = false;
                                    foreach ($userRatings['salg']['top'] as $key => $userRating): ?>
                                        <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                            $salgClass = 'class="me"';
                                            $salgUser = $userRatings['salg']['top'][$key];
                                        } ?>
                                        <tr <?php echo $salgClass;
                                        $salgClass = ''; ?> >
                                            <td>#<?= $userRating['index']; ?></td>
                                            <td><?= $userRating['user']['navn']; ?></td>
                                            <td><?= number_format($userRating['count'], 0, '', ' '); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                            <?php if ($salgUser): ?>
                                <div class="comeon">
                                    <?php if (isset($salgUser['prev_count'])): ?>
                                        <span><?= number_format($salgUser['prev_count'] - $salgUser['count'] + 1, 0, '', ' '); ?> salg igjen til <?= $salgUser['index'] - 1; ?>. plass</span>
                                    <?php else: ?>
                                        <span>Du er best<br/>av de beste</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xs-12 col-sm-4 col-xl-4">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=provisjon">
                            <h3 class="m-widget14__title">
                                TOPP PROVISJON
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div class="row  align-items-center">
                        <div class="col">
                            <table class="top5">

                                <?php if ($userRatings['provisjon']['best']): ?>
                                    <tr>
                                        <td>#1</td>
                                        <td><?= $userRatings['provisjon']['best']['user']['navn']; ?></td>
                                        <td><?= number_format(floor($userRatings['provisjon']['best']['count']), 0, '', ' '); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php $provisjonClass = '';
                                $provisjonUser = false;
                                foreach ($userRatings['provisjon']['top'] as $key => $userRating): ?>
                                    <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                        $provisjonClass = 'class="me"';
                                        $provisjonUser = $userRatings['provisjon']['top'][$key];
                                    } ?>
                                    <tr <?php echo $provisjonClass;
                                    $provisjonClass = ''; ?> >
                                        <td>#<?= $userRating['index']; ?></td>
                                        <td><?= $userRating['user']['navn']; ?></td>
                                        <td><?= number_format(floor($userRating['count']), 0, ' ', ' '); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                        <?php if ($provisjonUser): ?>
                            <div class="comeon">
                                <?php if (isset($provisjonUser['prev_count'])): ?>
                                    <span><?= number_format(floor($provisjonUser['prev_count'] - $provisjonUser['count'] + 1), 0, ' ', ' '); ?> kr igjen til <?= $provisjonUser['index'] - 1; ?>. plass</span>
                                <?php else: ?>
                                    <span>Du er best<br/>av de beste</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
        </div>
    </div>


<?php } else { ?>
    <?php /* DESKTOP VERSION */ ?>


    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="d-flex align-items-stretch row m-row--no-padding m-row--col-separator-xl block-dashboard-top">
            <div class="col-xl-3 col-sm-6" style="background-color: #101010">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=aktiviteter">
                            <h3 class="m-widget14__title">
                                TOPP AKTIVITETER
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div>
                        <table class="top5 w-100">
                            <?php if ($userRatings['aktiviteter']['best']): ?>
                                <tr>
                                    <td>#1</td>
                                    <td><?= $userRatings['aktiviteter']['best']['user']['navn']; ?></td>
                                    <td><?= number_format($userRatings['aktiviteter']['best']['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php $aktiviteterClass = '';
                            $aktiviteterUser = false;
                            foreach ($userRatings['aktiviteter']['top'] as $key => $userRating): ?>
                                <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                    $aktiviteterClass = 'class="me"';
                                    $aktiviteterUser = $userRatings['aktiviteter']['top'][$key];
                                } ?>
                                <tr <?php echo $aktiviteterClass;
                                $aktiviteterClass = ''; ?> >
                                    <td>#<?= $userRating['index']; ?></td>
                                    <td><?= $userRating['user']['navn']; ?></td>
                                    <td><?= number_format($userRating['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                        <?php if ($aktiviteterUser): ?>
                            <div class="comeon">
                                <?php if (isset($aktiviteterUser['prev_count'])): ?>
                                    Du har kun <?= number_format($aktiviteterUser['prev_count'] - $aktiviteterUser['count'] + 1, 0, '', ' '); ?> poeng igjen til <?= $aktiviteterUser['index'] - 1; ?>. plass
                                <?php else: ?>
                                    <span>Du er best av de beste</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xl-3 col-sm-6" style="background-color: #101010">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=signeringer">
                            <h3 class="m-widget14__title">
                                TOPP SIGNERINGER
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div>
                        <table class="top5 w-100">
                            <?php if ($userRatings['signeringer']['best']): ?>
                                <tr>
                                    <td>#1</td>
                                    <td><?= $userRatings['signeringer']['best']['user']['navn']; ?></td>
                                    <td><?= number_format($userRatings['signeringer']['best']['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php $signeringerClass = '';
                            $signeringerUser = false;
                            foreach ($userRatings['signeringer']['top'] as $key => $userRating): ?>
                                <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                    $signeringerClass = 'class="me"';
                                    $signeringerUser = $userRatings['signeringer']['top'][$key];
                                } ?>
                                <tr <?php echo $signeringerClass;
                                $signeringerClass = ''; ?> >
                                    <td>#<?= $userRating['index']; ?></td>
                                    <td><?= $userRating['user']['navn']; ?></td>
                                    <td><?= number_format(floor($userRating['count']), 0, ' ', ' '); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php if ($signeringerUser): ?>
                        <div class="comeon">
                            <?php if (isset($signeringerUser['prev_count'])): ?>
                                Du har kun <?= number_format(floor($signeringerUser['prev_count'] - $signeringerUser['count'] + 1), 0, ' ', ' '); ?> signeringer igjen til <?= $signeringerUser['index'] - 1; ?>. plass
                            <?php else: ?>
                                <span>Du er best av de beste</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xl-3 col-sm-6" style="background-color: #101010">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=salg">
                            <h3 class="m-widget14__title">
                                TOPP SALG
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div>
                        <table class="top5 w-100">
                            <?php if ($userRatings['salg']['best']): ?>
                                <tr>
                                    <td>#1</td>
                                    <td><?= $userRatings['salg']['best']['user']['navn']; ?></td>
                                    <td><?= number_format($userRatings['salg']['best']['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php $salgClass = '';
                            $salgUser = false;
                            foreach ($userRatings['salg']['top'] as $key => $userRating): ?>
                                <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                    $salgClass = 'class="me"';
                                    $salgUser = $userRatings['salg']['top'][$key];
                                } ?>
                                <tr <?php echo $salgClass;
                                $salgClass = ''; ?> >
                                    <td>#<?= $userRating['index']; ?></td>
                                    <td><?= $userRating['user']['navn']; ?></td>
                                    <td><?= number_format($userRating['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php if ($salgUser): ?>
                        <div class="comeon">
                            <?php if (isset($salgUser['prev_count'])): ?>
                                Du har kun <?= number_format($salgUser['prev_count'] - $salgUser['count'] + 1, 0, '', ' '); ?> salg igjen til <?= $salgUser['index'] - 1; ?>. plass
                            <?php else: ?>
                                <span>Du er best av de beste</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
            <div class="col-xl-3 col-sm-6" style="background-color: #101010">

                <!--begin:: Widgets/Revenue Change-->
                <div class="m-widget14">
                    <div class="m-widget14__header">
                        <a href="/admin/topplister/index?type=provisjon">
                            <h3 class="m-widget14__title">
                                TOPP PROVISJON
                            </h3>
                        </a>
                        <span class="m-widget14__desc">
                                </span>
                    </div>
                    <div>
                        <table class="top5 w-100">
                            <?php if ($userRatings['provisjon']['best']): ?>
                                <tr>
                                    <td>#1</td>
                                    <td><?= $userRatings['provisjon']['best']['user']['navn']; ?></td>
                                    <td><?= number_format($userRatings['provisjon']['best']['count'], 0, '', ' '); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php $provisjonClass = '';
                            $provisjonUser = false;
                            foreach ($userRatings['provisjon']['top'] as $key => $userRating): ?>
                                <?php if ($userRating['user']['id'] == $choosenUser->id) {
                                    $provisjonClass = 'class="me"';
                                    $provisjonUser = $userRatings['provisjon']['top'][$key];
                                } ?>
                                <tr <?php echo $provisjonClass;
                                $provisjonClass = ''; ?> >
                                    <td>#<?= $userRating['index']; ?></td>
                                    <td><?= $userRating['user']['navn']; ?></td>
                                    <td><?= number_format(floor($userRating['count']), 0, ' ', ' '); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <?php if ($provisjonUser): ?>
                        <div class="comeon">
                            <?php if (isset($provisjonUser['prev_count'])): ?>
                                Du har kun <?= number_format(floor($provisjonUser['prev_count'] - $provisjonUser['count'] + 1), 0, ' ', ' '); ?> NOK igjen til <?= $provisjonUser['index'] - 1; ?>. plass
                            <?php else: ?>
                                <span>Du er best av de beste</span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!--end:: Widgets/Revenue Change-->
            </div>
        </div>
    </div>

<?php } ?>