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
                    <th style="padding: 1rem;">Disponibilité</th>
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
                                <?= htmlspecialchars($p['nom']) ?>
                            </td>
                            <td style="padding: 1rem;">
                                <?= $p['prix'] ?> €
                            </td>
                            <td style="padding: 1rem;">
                                <?= $p['stock'] ?>
                            </td>
                            <td style="padding: 1rem;">
                                <span style="
                                    padding: 0.25rem 0.5rem; 
                                    border-radius: 4px; 
                                    font-size: 0.85rem;
                                    background: <?= $p['disponible'] === 'disponible' ? '#d1fae5' : '#fee2e2' ?>;
                                    color: <?= $p['disponible'] === 'disponible' ? '#065f46' : '#991b1b' ?>;
                                ">
                                    <?= htmlspecialchars($p['disponible'] ?? 'disponible') ?>
                                </span>
                            </td>
                            <td style="padding: 1rem;">
                                <button class="btn btn-secondary" 
                                        style="padding: 0.25rem 0.5rem; font-size: 0.8rem;" 
                                        data-id="<?= $p['id_ordinateur'] ?>"
                                        data-nom="<?= htmlspecialchars($p['nom']) ?>"
                                        data-prix="<?= $p['prix'] ?>"
                                        data-stock="<?= $p['stock'] ?>"
                                        data-disponible="<?= htmlspecialchars($p['disponible'] ?? 'disponible') ?>"
                                        data-description="<?= htmlspecialchars($p['description']) ?>"
                                        data-composants="<?= htmlspecialchars($p['composants']) ?>"
                                        data-url_img="<?= htmlspecialchars($p['url_img']) ?>"
                                        onclick="openEditModal(this)">
                                    Modifier
                                </button>
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
                <label class="form-label">Disponibilité</label>
                <select name="disponible" class="form-input">
                    <option value="disponible">Disponible</option>
                    <option value="non disponible">Non disponible</option>
                </select>
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

// Edit Modal Logic
let currentEditId = null;

function openEditModal(btn) {
    currentEditId = btn.getAttribute('data-id');
    document.getElementById('edit_id').value = currentEditId;
    document.getElementById('edit_nom').value = btn.getAttribute('data-nom');
    document.getElementById('edit_prix').value = btn.getAttribute('data-prix');
    document.getElementById('edit_stock').value = btn.getAttribute('data-stock');
    document.getElementById('edit_url_img').value = btn.getAttribute('data-url_img');
    document.getElementById('edit_composants').value = btn.getAttribute('data-composants');
    document.getElementById('edit_description').value = btn.getAttribute('data-description');
    document.getElementById('edit_disponible').value = btn.getAttribute('data-disponible') || 'disponible';
    
    document.getElementById('editModal').classList.add('active');
}

function closeEditModal() {
    document.getElementById('editModal').classList.remove('active');
}

function openConfirmModal() {
    // Hide edit modal nicely? Or just overlay?
    // Let's stack them or hide the first one. For simplicity, let's keep edit open and show confirm on top (z-index)
    // But since they use same class, let's just create a separate confirm modal that closes the edit one for clarity, 
    // or better: just show confirm modal and if canceled re-open edit.
    
    // Simple approach: Close Edit, Open Confirm.
    document.getElementById('editModal').classList.remove('active');
    document.getElementById('confirmModal').classList.add('active');
}

function cancelConfirm() {
    document.getElementById('confirmModal').classList.remove('active');
    document.getElementById('editModal').classList.add('active');
}

async function submitUpdate() {
    const id = document.getElementById('edit_id').value;
    const nom = document.getElementById('edit_nom').value;
    const prix = document.getElementById('edit_prix').value;
    const stock = document.getElementById('edit_stock').value;
    const url_img = document.getElementById('edit_url_img').value;
    const composants = document.getElementById('edit_composants').value;
    const description = document.getElementById('edit_description').value;
    const disponible = document.getElementById('edit_disponible').value;

    try {
        const res = await fetch('/admin/products/update', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id, nom, prix, stock, url_img, composants, description, disponible
            })
        });
        const data = await res.json();
        if(data.success) {
            alert('Produit mis à jour !');
            location.reload();
        } else {
            alert('Erreur: ' + (data.error || 'Server error'));
        }
    } catch(e) {
        alert('Erreur connexion');
    }
}
</script>

<!-- Edit Product Modal -->
<div id="editModal" class="modal-overlay">
    <div class="modal">
        <h3 class="modal-title">Modifier le produit</h3>
        <form id="editProductForm" onsubmit="event.preventDefault(); openConfirmModal();">
            <input type="hidden" id="edit_id">
            <div class="form-group">
                <label class="form-label">Nom du produit</label>
                <input type="text" id="edit_nom" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">URL Image</label>
                <input type="url" id="edit_url_img" class="form-input">
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Prix (€)</label>
                    <input type="number" id="edit_prix" step="0.01" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Stock</label>
                    <input type="number" id="edit_stock" class="form-input" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Disponibilité</label>
                <select id="edit_disponible" class="form-input">
                    <option value="disponible">Disponible</option>
                    <option value="non disponible">Non disponible</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Composants</label>
                <textarea id="edit_composants" class="form-input" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="edit_description" class="form-input" rows="3"></textarea>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Annuler</button>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal-overlay" style="z-index: 2000;">
    <div class="modal" style="max-width: 400px; text-align: center;">
        <h3 class="modal-title">Confirmer la modification</h3>
        <p style="margin-bottom: 1.5rem;">Êtes-vous sûr de vouloir enregistrer ces modifications ?</p>
        <div class="modal-actions" style="justify-content: center;">
            <button type="button" class="btn btn-secondary" onclick="cancelConfirm()">Non</button>
            <button type="button" class="btn btn-primary" onclick="submitUpdate()">Oui</button>
        </div>
    </div>
</div>
