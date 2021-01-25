    <?php foreach ($webmegler_properties as $webmegler_property):
        ?>
        <li>
            <img src="/image/temp_1.png" alt="" /><!-- All images must be the same size -->
            <span>
					<span><?= $webmegler_property->avdeling_fagansvarlig_navn; ?> <br>
                        <?= $webmegler_property->prisantydning; ?>
                        <?= $webmegler_property->soverom; ?>
                        ,-</span>
					<span><?= $webmegler_property->type_eiendomstyper;?> - 111 KVM</span>
					<a href="/annonse/<?= $webmegler_property->id__; ?>"></a>
				</span>
        </li>
    <?php endforeach; ?>
