<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <a href="/computers" style="display: inline-block; margin-bottom: 2rem; color: var(--text-light);">← Retour à la liste</a>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
        <!-- Image Section -->
        <div style="background: white; padding: 2rem; border-radius: var(--radius); border: 1px solid var(--border-color); display: flex; justify-content: center; align-items: center;">
            <img 
                src="<?= htmlspecialchars($product['url_img']) ?>" 
                alt="<?= htmlspecialchars($product['nom']) ?>" 
                style="max-width: 100%; max-height: 500px; object-fit: contain;"
            >
        </div>

        <!-- Info Section -->
        <div>
            <h1 style="font-size: 2.5rem; color: var(--text-color); margin-bottom: 1rem; line-height: 1.2;">
                <?= htmlspecialchars($product['nom']) ?>
            </h1>
            
            <div style="font-size: 2rem; font-weight: 700; color: var(--primary-color); margin-bottom: 2rem;">
                <?= htmlspecialchars($product['prix']) ?> €
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Description</h3>
                <p style="color: var(--text-light); white-space: pre-line;"><?= htmlspecialchars($product['description']) ?></p>
            </div>

            <div style="margin-bottom: 2rem;">
                <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem; border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem;">Composants</h3>
                <div style="color: var(--text-color); white-space: pre-line; background: var(--background-color); padding: 1rem; border-radius: var(--radius);">
                    <?= htmlspecialchars($product['composants']) ?>
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
               <h3 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Disponibilité</h3>
                <?php if($product['stock'] > 0): ?>
                     <div style="color: var(--success-color); font-weight: 600; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: inline-block; width: 10px; height: 10px; background: var(--success-color); border-radius: 50%;"></span>
                        En stock (<?= htmlspecialchars($product['stock']) ?> disponibles)
                     </div>
                <?php else: ?>
                    <div style="color: var(--danger-color); font-weight: 600; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="display: inline-block; width: 10px; height: 10px; background: var(--danger-color); border-radius: 50%;"></span>
                        Rupture de stock
                     </div>
                <?php endif; ?>
            </div>

            <?php if($product['stock'] > 0): ?>
                <form id="addToCartForm" style="display: flex; gap: 1rem; align-items: center;">
                    <input type="number" name="quantity" min="1" max="<?= htmlspecialchars($product['stock']) ?>" value="1" 
                           style="width: 80px; padding: 1rem; font-size: 1.2rem; border: 1px solid var(--border-color); border-radius: var(--radius); text-align: center;">
                    <input type="hidden" name="id_ordinateur" value="<?= $product['id_ordinateur'] ?>">
                    <button type="submit" class="btn" style="flex: 1; font-size: 1.2rem;">Ajouter au panier</button>
                </form>
                <div id="status-message" style="margin-top: 1rem;"></div>
            <?php else: ?>
                 <button class="btn btn-secondary" disabled style="width: 100%; cursor: not-allowed; opacity: 0.7; font-size: 1.2rem;">Indisponible</button>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const msgDiv = document.getElementById('status-message');
    msgDiv.textContent = 'Ajout en cours...';
    msgDiv.className = '';
    
    try {
        const response = await fetch('/computers', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(Object.fromEntries(formData))
        });
        const data = await response.json();
        
        if (data.success) {
            msgDiv.textContent = '✅ ' + data.message;
            msgDiv.style.color = 'var(--success-color)';
        } else {
             msgDiv.textContent = '❌ ' + (data.error || 'Erreur');
             msgDiv.style.color = 'var(--danger-color)';
        }
    } catch (err) {
        msgDiv.textContent = '❌ Erreur connexion';
        msgDiv.style.color = 'var(--danger-color)';
    }
});
</script>
