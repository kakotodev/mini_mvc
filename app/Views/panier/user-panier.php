<div>
    <?php
    if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
    ?>
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
    <?php
    }else{
        ?>
            <p>Veuillez vous connecter à votre compté / Crée votre compte pour voir votre profile</p>
        <?php
    }
    ?>
</div>

<script>

</script>