<div class="container header-inner">
    <div class="header-logo">
        <h1><a href="/" style="text-decoration:none;">BuyYourPC</a> <span style="font-size: 0.8rem; font-weight: normal; color: var(--text-light); margin-left:8px;">Sponso By EFREI</span></h1>
    </div>
    <div class="header-nav">
        <nav>
            <ul>
                <li><a href="/" class="<?= ($_SERVER['REQUEST_URI'] === '/' ? 'active' : '') ?>">Accueil</a></li>
                <li><a href="/computers" class="<?= (strpos($_SERVER['REQUEST_URI'], '/computers') !== false ? 'active' : '') ?>">Les vrais PCs</a></li>
                <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
                    <!-- Logged in menu items if any specific to navigation -->
                <?php else: ?>
                    <li><a href="/users/login" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Connexion / Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <div class="header-user">
        <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
            <div class="user-info">
                <p>Hello, <span><?= htmlspecialchars($_SESSION['username'])?></span></p>
            </div>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <a href="/admin/dashboard" class="btn btn-warning" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Tableau de bord</a>
            <?php else: ?>
                <a href="/users/profile" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Profil</a>
                <a href="/users/panier" class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Panier</a>
            <?php endif; ?>
            <a href="/users/logout" style="color: var(--danger-color); font-size: 0.9rem; font-weight: 500;">Déconnexion</a>
        <?php else: ?>
            <div class="user-info">
                <p>Visiteur</p>
            </div>
        <?php endif; ?>
    </div>
</div>