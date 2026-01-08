<div>
    <?php
        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            ?>
                <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?></h1>
                <div>
                    <span>Vos informations</span>
                    <div style="margin-top: 1.5rem;">
                        <a href="/users/historique" class="btn">Voir mon historique d'achats</a>
                    </div>
                </div>
            <?php
        }else{
            ?>
                <p>Veuillez vous connecter à votre compte / Crée votre compte pour voir votre profile</p>
            <?php
        }
    ?>
</div>