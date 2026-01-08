<div class="hero">
    <h2>Bienvenue sur BuyYourPC</h2>
    <p>Le meilleur endroit pour trouver les composants de vos rêves. Performance, qualité et prix imbattables.</p>
    <div style="margin-top: 2rem;">
        <a href="/computers" class="btn" style="background-color: white; color: var(--primary-color); font-weight: bold;">Voir les PCs</a>
        <?php if(!isset($_SESSION['is_logged_in'])): ?>
            <a href="/users/login" class="btn btn-secondary" style="background: transparent; color: white; border-color: white; margin-left: 1rem;">Se connecter</a>
        <?php endif; ?>
    </div>
</div>

<div style="text-align: center; margin-bottom: 3rem;">
    <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Pourquoi nous choisir ?</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 900px; margin: 0 auto;">
        <div style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <h4 style="color: var(--primary-color); font-weight: 600; margin-bottom: 0.5rem;">Qualité Premium</h4>
            <p style="color: var(--text-light); font-size: 0.95rem;">Nous sélectionnons uniquement les meilleurs composants pour nos machines.</p>
        </div>
        <div style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <h4 style="color: var(--primary-color); font-weight: 600; margin-bottom: 0.5rem;">Support 24/7</h4>
            <p style="color: var(--text-light); font-size: 0.95rem;">Une équipe d'experts à votre écoute pour vous conseiller.</p>
        </div>
        <div style="background: white; padding: 2rem; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <h4 style="color: var(--primary-color); font-weight: 600; margin-bottom: 0.5rem;">Livraison Rapide</h4>
            <p style="color: var(--text-light); font-size: 0.95rem;">Recevez votre PC monté et testé en temps record.</p>
        </div>
    </div>
</div>

<div style="background: #f1f5f9; padding: 1rem; border-radius: var(--radius); font-family: monospace; font-size: 0.8rem; overflow-x: auto;">
    <p style="font-weight: bold; margin-bottom: 0.5rem;">Debug Session:</p>
    <?php
        var_dump($_SESSION);
    ?>
</div>


