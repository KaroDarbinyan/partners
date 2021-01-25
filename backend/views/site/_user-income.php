<?php
/** @var $userIncomes array */
?>
<?php foreach ($userIncomes as $userIncome): ?>
    <div class="col-xs-4 col-sm-4 col-md-4 col-xl-4">
        <!--begin::New Users-->
        <a href="<?= $userIncome['url']; ?>">
            <div class="m-widget24">
                <div class="m-widget24__item">
                    <h4 class="m-widget24__title">
                        <?= $userIncome['title']; ?>
                    </h4>
                    <span class="m-widget24__stats m--font-success">
                            <?= round($userIncome['price'], 1) ?>%
                        </span>
                    <div class="m--space-10"></div>
                    <div class="progress m-progress--sm">
                        <div class="progress-bar <?= $userIncome['background']; ?>" role="progressbar"
                             style="width: <?= number_format($userIncome['price'], 0, '.', '.') ?>%;" aria-valuenow="50"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <span class="m-widget24__change">
                            Total
                        </span>
                    <span class="m-widget24__number">
                            <?= number_format($userIncome['count'], 0, ' ', ' ') . ' / ' . number_format($userIncome['propertyDetailsCount'], 0, ' ', ' '); ?>
                        </span>
                </div>
            </div>
        </a>
        <!--end::New Users-->
    </div>
<?php endforeach; ?>
