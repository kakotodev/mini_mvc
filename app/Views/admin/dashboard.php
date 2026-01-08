<div class="container" style="padding-top: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Tableau de bord Administrateur</h2>
        <button class="btn btn-primary" onclick="openAddModal()">+ Ajouter un produit</button>
    </div>

    <div class="card" style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--bg-color); text-align: left;">
                    <th style="padding: 1rem;">ID</th>
                    <th style="padding: 1rem;">Image</th>
                    <th style="padding: 1rem;">Nom</th>
                    <th style="padding: 1rem;">Prix</th>
                    <th style="padding: 1rem;">Stock</th>
                    <th style="padding: 1rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                        <tr style="border-bottom: 1px solid var(--border-color);">
                            <td style="padding: 1rem;">#<?= $p['id_ordinateur'] ?></td>
                            <td style="padding: 1rem;">
                                <?php if($p['url_img']): ?>
                                    <img src="<?= htmlspecialchars($p['url_img']) ?>" alt="Img" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php endif; ?>
                            </td>
                            <td style="padding: 1rem;">
                                <input type="text" id="nom-<?= $p['id_ordinateur'] ?>" value="<?= htmlspecialchars($p['nom']) ?>" class="form-input" style="width: 150px; padding: 0.25rem;">
                            </td>
                            <td style="padding: 1rem;">
                                <input type="number" step="0.01" id="prix-<?= $p['id_ordinateur'] ?>" value="<?= $p['prix'] ?>" class="form-input" style="width: 80px; padding: 0.25rem;"> €
                            </td>
                            <td style="padding: 1rem;">
                                <input type="number" id="stock-<?= $p['id_ordinateur'] ?>" value="<?= $p['stock'] ?>" class="form-input" style="width: 80px; padding: 0.25rem;">
                            </td>
                            <td style="padding: 1rem;">
                                <button class="btn btn-secondary" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" onclick="updateProduct(<?= $p['id_ordinateur'] ?>)">Mettre à jour</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center;">Aucun produit trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addModal" class="modal-overlay">
    <div class="modal">
        <h3 class="modal-title">Ajouter un produit</h3>
        <form id="addProductForm">
            <div class="form-group">
                <label class="form-label">Nom du produit</label>
                <input type="text" name="nom" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">URL Image</label>
                <input type="url" name="url_img" class="form-input">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Prix (€)</label>
                    <input type="number" name="prix" step="0.01" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stock initial</label>
                    <input type="number" name="stock" class="form-input" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Composants</label>
                <textarea name="composants" class="form-input" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-input" rows="3"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Annuler</button>
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('addModal').classList.add('active');
}
function closeAddModal() {
    document.getElementById('addModal').classList.remove('active');
}

// Update Product logic
async function updateProduct(id) {
    const nomVal = document.getElementById('nom-' + id).value;
    const prixVal = document.getElementById('prix-' + id).value;
    const stockVal = document.getElementById('stock-' + id).value;
    
    try {
        const res = await fetch('/admin/products/update', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id: id, 
                nom: nomVal,
                prix: prixVal,
                stock: stockVal
            })
        });
        const data = await res.json();
        if(data.success) {
            alert('Produit mis à jour !');
        } else {
            alert('Erreur: ' + (data.error || 'Server error'));
        }
    } catch(e) {
        alert('Erreur connexion');
    }
}

// Add Product logic
document.getElementById('addProductForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const res = await fetch('/admin/products/add', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if(result.success) {
            alert('Produit ajouté !');
            location.reload();
        } else {
            alert('Erreur: ' + (result.error || 'Server error'));
        }
    } catch(err) {
        alert('Erreur connexion');
    }
});
</script>
