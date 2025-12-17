<div>
    <?php
    if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
    ?>
        <?php if (empty($products) ): ?>
        <div>
            <p>Votre panier est vide</p>
            <?= htmlspecialchars($title)?>
        </div>
    <?php else: ?>
        <div>
            <?php var_dump($products)?>

            <?php foreach ($products as $product): ?>
                <div>
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