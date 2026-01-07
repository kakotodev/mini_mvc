<div class="header-section">
    <div>
        <h1>BuyYourPC - Sponso By EFREI</h1>
    </div>
    <div>
        <nav>
            <li>
                <a href="/">accueil</a>
                <a href="/computers">Les vrais PCs</a>
                <?php
                    if(isset($_SESSION['is_logged_in'])&& $_SESSION['is_logged_in'] === true) {
                ?>  
                    <a href="users/logout">Se déconnecter</a>
                <?php
                    }else{
                    ?>
                        <a href="/users/login">Connectez/Crée votre compte</a>
                    <?php
                    }
                ?>
            </li>
        </nav>
    </div>
    <div>
        <?php
            if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
                ?>
                <div>
                    <p>User : <span><?= htmlspecialchars($_SESSION['username'])?></span> </p>
                    <a href="/users/profile">Votre profile</a>
                    <a href="/users/panier">Panier</a>
                </div>
                <?php
            } else {
                ?>
                <div>
                    <p>User : Visitor </p>
                </div>
                <?php
            }
        ?>
    </div>
</div>