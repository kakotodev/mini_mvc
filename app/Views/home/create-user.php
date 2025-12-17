<!-- Formulaire pour créer un nouvel utilisateur -->
<div style="max-width: 600px; margin: 0 auto; padding: 20px;">
    <h2>Ajouter un nouvel utilisateur</h2>
    
    <!-- Message de succès ou d'erreur -->
    <div id="message" style="display: none; padding: 10px; margin-bottom: 20px; border-radius: 4px;"></div>
    
    <form id="createUserForm" action="/users/create" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
        <div>
            <label for="nom" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom :</label>
            <input 
                type="text" 
                id="nom" 
                name="nom" 
                required 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
                placeholder="Entrez le nom de l'utilisateur"
            >
        </div>
        
        <div>
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email :</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
                placeholder="exemple@email.com"
            >
        </div>

        <div>
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Mot de passe :</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
            >
        </div>
        <div>
            <label for="confirmedpassword" style="display: block; margin-bottom: 5px; font-weight: bold;">Confirmé votre mot de passe :</label>
            <input 
                type="password" 
                id="confirmedpassword" 
                name="confirmedpassword" 
                required 
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;"
            >
        </div>

        
        <button 
            type="submit" 
            style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;"
            onmouseover="this.style.backgroundColor='#0056b3'" 
            onmouseout="this.style.backgroundColor='#007bff'"
        >
            Créer l'utilisateur
        </button>
    </form>
    
    <div style="margin-top: 20px;">
        <a href="/" style="color: #007bff; text-decoration: none;">← Retour à l'accueil</a>
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
            
            // Réinitialise le formulaire
            document.getElementById('createUserForm').reset();
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

