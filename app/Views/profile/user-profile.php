<div>
    <?php
        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            ?>
                <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?></h1>
                <div>
                    <h2>Votre Panier :</h2>
                </div>
                <hr>
                <div>
                    <h2>Votre historique d'achat :</h2>
                </div>
            <?php
        }else{
            ?>
                <p>Veuillez vous connecter </p^>
            <?php
        }
    ?>
</div>