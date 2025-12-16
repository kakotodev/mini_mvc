<div>
    <h2>Connectez vous</h2>

    <div id="message" style="display: none; padding: 10px; margin-bottom: 20px; border-radius: 4px;"></div>


    <form id="loginUserForm">
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit">Connecter</button>
    </form>
    <a href="/users/create">Crée un utilisateurs</a>
</div>

<script>

document.getElementById('loginUserForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const loginEmail = document.getElementById('email').value.trim();
    const loginPassword = document.getElementById('password').value.trim();

    console.log(loginEmail)
    console.log(loginPassword)

    const messageLoginUserDiv = document.getElementById('message');
    messageLoginUserDiv.style.display = 'block';
    messageLoginUserDiv.style.backgroundColor = '#d1ecf1';
    messageLoginUserDiv.style.color = '#0c5460';
    messageLoginUserDiv.textContent = 'Connexion en cours...';
    
    try {
        const response = await fetch('/users/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                loginEmail: loginEmail,
                loginPassword: loginPassword
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            messageLoginUserDiv.style.backgroundColor = '#d4edda';
            messageLoginUserDiv.style.color = '#155724';
            messageLoginUserDiv.textContent = '✅ ' + data.message;
        } else {
            messageLoginUserDiv.style.backgroundColor = '#f8d7da';
            messageLoginUserDiv.style.color = '#721c24';
            messageLoginUserDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');

        }
    } catch (error) {
        messageLoginUserDiv.style.backgroundColor = '#f8d7da';
        messageLoginUserDiv.style.color = '#721c24';
        messageLoginUserDiv.textContent = '❌ Erreur de connexion : ' + error.message;
        }      
    }
)
</script>