<?php
/** @var $this yii\web\View */
/** @var $property common\models\Property */
/** @var $propertyImage common\models\Image */
/** @var $properties common\models\Property */

/** @var $pages \yii\data\Pagination */

use common\components\CdnComponent;

?>

<?php foreach ($properties as $property): ?>
    <li class="ed-card">
        <label class="ed-check" data-id="<?= $property->web_id; ?>">
            <span class="ed-checkbox">
                <span data-checked-id="<?= $property->web_id; ?>"></span>
            </span>
            <span>
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12,3C10.73,3 9.6,3.8 9.18,5H3V7H4.95L2,14C1.53,16 3,17 5.5,17C8,17
                     9.56,16 9,14L6.05,7H9.17C9.5,7.85 10.15,8.5 11,8.83V20H2V22H22V20H13V8.82C13.85,8.5
                      14.5,7.85 14.82,7H17.95L15,14C14.53,16 16,17 18.5,17C21,17 22.56,16
                       22,14L19.05,7H21V5H14.83C14.4,3.8 13.27,3 12,3M12,5C12.55,5 13,5.45 13,6C13,6.55 12.55,7
                       12,7C11.45,7 11,6.55 11,6C11,5.45 11.45,5 12,5M5.5,10.25L7,14H4L5.5,10.25M18.5,10.25L20,14H17L18.5,10.25Z"></path>
                </svg>
            </span>
        </label>

        <a hrefd="/<?= $property->propertyDetails->solgt == -1 ? 'eiendom' : 'annonse' ?>/<?= $property->web_id; ?>">

            <figure class="property-card">
                <img
                        data-clonable
                        src="<?= empty($property->propertyImage) ? 'https://via.placeholder.com/150' : CdnComponent::optimizedUrl($property->propertyImage->urlstorthumbnail, 630); ?>"
                        alt="<?= empty($property->propertyImage) ? '' : $property->propertyImage->overskrift; ?>"
                />
                <?php if ($property->propertyDetails->solgt == -1): ?>
                    <img src="/img/sold.png" class="is-sold" alt="Solgt">
                <?php endif ?>
                <figcaption>
                    <div>
                        <h3><?= $property->propertyDetails->title . ', ' . $property->address; ?></h3>
                    </div>
                    <div>
                        <p><?= number_format($property->price, 0, ' ', ' '); ?>,-</p>
                        <p>
                            <?php if ($property->propertyDetails->prom): ?>
                                <?= $property->propertyDetails->prom; ?> m<sup>2</sup>,
                            <?php elseif ($property->propertyDetails->bruksareal): ?>
                                <?= $property->propertyDetails->bruksareal; ?> m<sup>2</sup>,
                            <?php elseif ($property->propertyDetails->tomteareal): ?>
                                <?= $property->propertyDetails->tomteareal; ?> m<sup>2</sup>,
                            <?php endif; ?>
                            <?= $property->type; ?></p>
                    </div>
                </figcaption>
            </figure>
        </a>
    </li>
<?php endforeach; ?>

<?php if ($pages->getPage() + 1 >= $pages->getPageCount() && false): // tmp disable?>
    <li class="is-archives">
        <a href="/eiendommer/alle">
            <figure class="property-card">
                <img data-clonable
                     src="/img/property-default.png"
                     alt="Vis alle solgte eiendommer"
                >
                <figcaption>
                    <div>Vis alle solgte eiendommer</div>
                </figcaption>
            </figure>
        </a>
    </li>
<?php endif ?>

<li class="is-pagination center-block">
    <?= \yii\widgets\LinkPager::widget(['pagination' => $pages]) ?>
</li>
