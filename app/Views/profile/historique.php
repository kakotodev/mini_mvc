<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1>Historique d'Achats</h1>
        <p style="color: var(--text-light);">Consultez la liste de vos achats passés.</p>
        <a href="/users/profile" class="btn btn-secondary" style="margin-top: 1rem;">&larr; Retour au profil</a>
    </div>

    <?php if (empty($historique)): ?>
        <div class="alert">
            <p>Vous n'avez pas encore effectué d'achats.</p>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historique as $achat): ?>
                        <tr>
                            <td><?= isset($achat['date_achat']) ? htmlspecialchars($achat['date_achat']) : 'N/A' ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <?php if(!empty($achat['url_img'])): ?>
                                        <img src="<?= htmlspecialchars($achat['url_img']) ?>" alt="" style="width: 40px; height: 40px; object-fit: contain;">
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($achat['nom']) ?></span>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($achat['quantity']) ?></td>
                            <td><?= htmlspecialchars($achat['prix']) ?>€</td>
                            <td style="font-weight: bold;"><?= htmlspecialchars((float)$achat['prix'] * (int)$achat['quantity']) ?>€</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
