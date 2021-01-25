<?php
/** @var $this yii\web\View */
/** @var $properties \common\models\PropertyDetails */
/** @var $propertyImage common\models\Image */
/** @var $pages \yii\data\Pagination  */

use common\components\CdnComponent;

?>

<?php foreach ($properties as $property): ?>
    <li>
        <a href="/<?= $property->solgt == -1 ? 'eiendom' : 'annonse' ?>/<?= $property->id; ?>">
            <figure class="property-card">
                <img
                        data-clonable
                        src="<?= empty($property->propertyImage) ? 'https://via.placeholder.com/150': CdnComponent::optimizedUrl($property->propertyImage->urlstorthumbnail, 630); ?>"
                        alt="<?= empty($property->propertyImage) ? '' : $property->propertyImage->overskrift ; ?>"
                />
                <?php if ($property->solgt == -1): ?>
                    <img src="/img/sold.png" class="is-sold" alt="Solgt">
                <?php endif ?>
                <figcaption>
                    <div>
                        <h3><?= $property->title . ', ' . $property->adresse; ?></h3>
                    </div>
                    <div>
                        <p><?= number_format($property->prissamletsum, 0, ' ', ' '); ?>,-</p>
                        <p>
                            <?php if ($property->prom): ?>
                                <?= $property->prom; ?> m<sup>2</sup>,
                            <?php elseif ($property->bruksareal): ?>
                                <?= $property->bruksareal; ?> m<sup>2</sup>,
                            <?php elseif ($property->tomteareal): ?>
                                <?= $property->tomteareal; ?> m<sup>2</sup>,
                            <?php endif; ?>
                            <?= $property->type_eiendomstyper; ?></p>
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
