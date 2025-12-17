<div>
    <?php
        if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true){
            ?>
                <h1>Bienvenue <?= htmlspecialchars($_SESSION['username']) ?></h1>
                <div>
                    <span>Vos informations</span>
                </div>
            <?php
        }else{
            ?>
                <p>Veuillez vous connecter à votre compte / Crée votre compte pour voir votre profile</p>
            <?php
        }
    ?>
</div>