<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Liste des utilisateurs</h1>
        <a href="/users/create" class="btn">Nouvel utilisateur</a>
    </div>

    <?php if (!empty($users)) : ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td>#<?= htmlspecialchars($user['id']) ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($user['nom']) ?></td>
                            <td style="color: var(--text-light);"><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <a class="btn btn-secondary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem;" href="edit.php?id=<?= $user['id'] ?>">Modifier</a>
                                <a class="btn btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; margin-left: 0.5rem;" href="delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <div class="alert alert-error">Aucun utilisateur trouvé.</div>
    <?php endif; ?>
</div>
