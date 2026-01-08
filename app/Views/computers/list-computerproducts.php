<div>
    <div style="text-align: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; color: var(--text-color); margin-bottom: 0.5rem;">Nos Configurations Gamers</h1>
        <p style="color: var(--text-light);">Découvrez notre sélection de PC haute performance</p>
    </div>
    
    <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
        <form method="GET" action="/computers" style="display: flex; align-items: center; gap: 0.5rem;">
            <label for="sort" style="font-weight: 500;">Trier par :</label>
            <select name="sort" id="sort" class="form-input" style="width: auto; padding: 0.5rem;" onchange="this.form.submit()">
                <option value="default" <?= (!isset($_GET['sort']) || $_GET['sort'] === 'default') ? 'selected' : '' ?>>Par défaut</option>
                <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_asc') ? 'selected' : '' ?>>Prix croissant</option>
                <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'price_desc') ? 'selected' : '' ?>>Prix décroissant</option>
                <option value="stock_asc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'stock_asc') ? 'selected' : '' ?>>Stock croissant</option>
                <option value="stock_desc" <?= (isset($_GET['sort']) && $_GET['sort'] === 'stock_desc') ? 'selected' : '' ?>>Stock décroissant</option>
            </select>
        </form>
    </div>
    
    <div id="message" style="display: none;" class="alert"></div>

    <?php if (empty($computerproducts)):?>
        <div style="text-align: center; padding: 4rem; background: white; border-radius: var(--radius); box-shadow: var(--shadow-sm);">
            <p style="font-size: 1.2rem; color: var(--text-light);">Aucun article disponible pour le moment, revenez plus tard !</p>
        </div>
    <?php else: ?>
        <div class="product-grid">
            <?php foreach ($computerproducts as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img 
                            src="<?= htmlspecialchars($product['url_img']) ?>"
                            alt="<?= htmlspecialchars($product['nom']) ?>"
                            loading="lazy"
                        >
                    </div>
                    <div class="product-content">
                        <div class="product-title"><?= htmlspecialchars($product['nom']) ?></div>
                        <div class="product-desc"><?= htmlspecialchars($product['composants'])?></div>
                        <div class="product-price"><?= htmlspecialchars($product['prix']) ?>€</div>
                        <div class="product-stock">
                            <span style="<?= $product['stock'] > 0 ? '' : 'color: var(--danger-color);' ?>">
                                <?= $product['stock'] > 0 ? htmlspecialchars($product['stock']) . ' disponibles' : 'Rupture de stock' ?>
                            </span>
                        </div>
                        <div style="margin-top: auto;">
                            <?php if($product['stock'] > 0): ?>
                                <form method="POST" class="PanierProductForm" action="/computers">
                                    <input type="number" name="quantity" min="1" max="<?= htmlspecialchars($product['stock']) ?>" value="1" aria-label="Quantité"/>
                                    <input type="hidden" name="id_ordinateur" value="<?= $product['id_ordinateur']?>"/>
                                    <button type="submit" class="btn" style="flex: 1;">Ajouter au panier</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled style="width: 100%; cursor: not-allowed; opacity: 0.7;">Indisponible</button>
                            <?php endif; ?>
                            <div id="status-<?=$product['id_ordinateur']?>" style="text-align: center; font-size: 0.9rem; margin-top: 0.5rem; display: none;"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
</div>

<script>

const forms = document.querySelectorAll('.PanierProductForm');

forms.forEach(form => {
    form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const id_ordinateur = formData.get('id_ordinateur');
            const quantity = formData.get('quantity');
            
            const messageProfilUserDiv = document.getElementById('status-'+id_ordinateur);
            if(messageProfilUserDiv) {
                messageProfilUserDiv.style.display = 'block';
                messageProfilUserDiv.style.color = 'var(--text-light)';
                messageProfilUserDiv.textContent = 'Connexion en cours...';
            }
            
            try {
                const response = await fetch('/computers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id_ordinateur: id_ordinateur,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageProfilUserDiv.style.color = 'var(--success-color)';
                    messageProfilUserDiv.textContent = '✅ ' + data.message;
                } else {
                    messageProfilUserDiv.style.color = 'var(--danger-color)';
                    messageProfilUserDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');

                }
            } catch (error) {
                messageProfilUserDiv.style.color = 'var(--danger-color)';
                messageProfilUserDiv.textContent = '❌ Erreur de connexion : ' + error.message;
            }      
        }
    )
})

</script>