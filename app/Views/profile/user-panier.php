<div>
    <?php if (empty($panier) ): ?>
        <div>
            <p>Votre panier est vide</p>
        </div>
    <?php else: ?>
        <div>
            <?php foreach ($panier as $product): ?>
                <div>
                    <p><?= htmlspecialchars($product['produit_id'])?></p>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>
</div>

<script>

</script>