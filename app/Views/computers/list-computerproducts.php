<div>
    <div>
        <h1>LES VRAIS PC POUR LES GAMERS</h1>
    </div>
    <div>
        <?php if (empty($computerproducts)):?>
            <div>
                <p>Aucun article Disponible, revenez plus tard !</p>
            </div>
        <?php else: ?>
            <div>
                <?php foreach ($computerproducts as $product): ?>
                    <div>
                        <img 
                            src="<?= htmlspecialchars($product['url_img']) ?>"
                            alt="<?= htmlspecialchars($product['nom']) ?>"
                            style="max-width: 100%; max-height: 300px"
                            >
                    </div>
                    <div>
                        <div>
                            <span><?= htmlspecialchars($product['nom']) ?></span>
                        </div>
                        <div>
                            <p><?= htmlspecialchars($product['composants'])?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
</div>