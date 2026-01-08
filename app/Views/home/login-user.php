<div class="container auth-container">
    <div class="auth-card">
        <h2 class="auth-title">Connexion</h2>
        
        <div id="message" style="display: none;" class="alert"></div>

        <form id="loginUserForm">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="exemple@email.com" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="Votre mot de passe" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; margin-top: 1rem;">Se connecter</button>
        </form>
        
        <div class="auth-footer">
            Pas encore de compte ? <a href="/users/create">Créer un compte</a>
        </div>
    </div>
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
            
            // Redirect to home
            setTimeout(() => {
                window.location.href = '/';
            }, 1000);
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