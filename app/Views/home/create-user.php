<div class="container auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Créer un compte</h2>
        
        <div id="message" style="display: none;" class="alert"></div>

        <form id="createUserForm">
            <div class="form-group">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" id="nom" name="nom" class="form-input" placeholder="Votre nom" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="exemple@email.com" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Votre mot de passe" required>
            </div>

            <div class="form-group">
                <label for="confirmedpassword" class="form-label">Confirmer le mot de passe</label>
                <input type="password" id="confirmedpassword" name="confirmedpassword" class="form-input" placeholder="Confirmez votre mot de passe" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">S'inscrire</button>
        </form>
        
        <div class="auth-footer">
            Déjà un compte ? <a href="/users/login">Se connecter</a>
        </div>
    </div>
</div>

<script>
// Gestion de la soumission du formulaire
document.getElementById('createUserForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Récupère les valeurs du formulaire
    const nom = document.getElementById('nom').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmedpassword = document.getElementById('confirmedpassword').value.trim();

    // Affiche un message de chargement
    const messageCreateUserDiv = document.getElementById('message');
    messageCreateUserDiv.style.display = 'block';
    messageCreateUserDiv.style.backgroundColor = '#d1ecf1';
    messageCreateUserDiv.style.color = '#0c5460';
    messageCreateUserDiv.textContent = 'Création en cours...';
    
    try {
        // Envoie la requête POS    T avec les données en JSON
        const response = await fetch('/users/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                nom: nom,
                email: email,
                password: password,
                confirmedpassword: confirmedpassword
            })
        });
        
        const data = await response.json();
        
        if (response.ok && data.success) {
            // Succès
            messageCreateUserDiv.style.backgroundColor = '#d4edda';
            messageCreateUserDiv.style.color = '#155724';
            messageCreateUserDiv.textContent = '✅ ' + data.message;
            
            // Redirect to home
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
        } else {
            // Erreur
            messageCreateUserDiv.style.backgroundColor = '#f8d7da';
            messageCreateUserDiv.style.color = '#721c24';
            messageCreateUserDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');
        }
    } catch (error) {
        // Erreur réseau
        messageCreateUserDiv.style.backgroundColor = '#f8d7da';
        messageCreateUserDiv.style.color = '#721c24';
        messageCreateUserDiv.textContent = '❌ Erreur de connexion : ' + error.message;
        
    }
});
</script>

