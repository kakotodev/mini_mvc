<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>Mon Panier</h1>
        <p style="color: var(--text-light);">Gérez vos articles sélectionnés</p>
    </div>

    <?php if(isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true): ?>
        
        <?php if (empty($paniers)): ?>
            <div style="text-align: center; padding: 4rem; background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
                <h3 style="margin-bottom: 0.5rem;">Votre panier est vide</h3>
                <p style="color: var(--text-light); margin-bottom: 2rem;">Découvrez nos configurations gamers dès maintenant.</p>
                <a href="/computers" class="btn">Voir les produits</a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 100px;">Image</th>
                            <th>Produit</th>
                            <th>Description</th>
                            <th>Actions</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paniers as $panier): ?>
                            <tr>
                                <td>
                                    <?php if(isset($panier['url_img'])): ?>
                                        <img src="<?= htmlspecialchars($panier['url_img']) ?>" alt="Produit" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center;">📷</div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 500;">
                                    <?= isset($panier['nom']) ? htmlspecialchars($panier['nom']) : 'Produit inconnu' ?>
                                </td>
                                <td style="color: var(--text-light); font-size: 0.9rem;">
                                    <?= isset($panier['composants']) ? htmlspecialchars($panier['composants']) : '' ?>
                                </td>
                                <td>
                                    <form action="/users/panier" method="POST">
                                        <input type="hidden" name="id_ordinateur" value="<?= $panier['id'] ?>">
                                        <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;">Retirer</button>
                                    </form>
                                </td>
                                <td>
                                    <?= isset($panier['quantity']) ? htmlspecialchars($panier['quantity']) : 'Quantité inconnue' ?>   
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div style="margin-top: 2rem; text-align: right;">
                <button class="btn" style="padding: 1rem 2rem; font-size: 1.1rem;" onclick="openCheckoutModal()">Passer la commande</button>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div style="text-align: center; padding: 4rem; background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
            <h3 style="margin-bottom: 1rem;">Connectez-vous pour voir votre panier</h3>
            <p style="color: var(--text-light); margin-bottom: 2rem;">Vous devez être connecté pour gérer votre panier et passer commande.</p>
            <a href="/users/login" class="btn">Se connecter / Créer un compte</a>
        </div>
    <?php endif; ?>
    <!-- Checkout Modal -->
    <div id="checkoutModal" class="modal-overlay">
        <div class="modal">
            <h3 class="modal-title">Confirmer la commande</h3>
            <p>Voulez-vous vraiment valider votre panier et passer la commande ?</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeCheckoutModal()">Annuler</button>
                <form action="/users/panier/checkout" method="POST" style="margin: 0;">
                    <button type="submit" class="btn">Confirmer l'achat</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openCheckoutModal() {
    document.getElementById('checkoutModal').classList.add('active');
}

function closeCheckoutModal() {
    document.getElementById('checkoutModal').classList.remove('active');
}

// Close modal when clicking outside
document.getElementById('checkoutModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCheckoutModal();
    }
});
</script>