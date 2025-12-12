<div>
    <h2>Connectez vous</h2>

    <form id="userForm">
        <div>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email">
        </div>
        <div>
            <label for="password" id="password" name="password">Mot de passe :</label>
            <input type="password">
        </div>
        <button type="submit">Connecter</button>
    </form>
</div>

<script>

document.getElementById('userForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();


    const messageDiv = document.getElementById('message');
    messageDiv.style.display = 'block';
    messageDiv.style.backgroundColor = '#d1ecf1';
    messageDiv.style.color = '#0c5460';
    messageDiv.textContent = 'Connexion en cours...';
    
    try {
        const response = await fetch('users', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            messageDiv.style.backgroundColor = '#d4edda';
            messageDiv.style.color = '#155724';
            messageDiv.textContent = '✅ ' + data.message;
        } else {
            messageDiv.style.backgroundColor = '#f8d7da';
            messageDiv.style.color = '#721c24';
            messageDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');
        }
    } catch (error) {
        messageDiv.style.backgroundColor = '#f8d7da';
        messageDiv.style.color = '#721c24';
        messageDiv.textContent = '❌ Erreur de connexion : ' + error.message;
    }      
    }
})

</script>