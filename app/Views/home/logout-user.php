<div class="container auth-container">
    <div class="auth-card" style="text-align: center;">
        <h2 class="auth-title">Déconnexion</h2>
        <p style="color: var(--text-light); margin-bottom: 2rem;">Vous êtes en train de vous déconnecter...</p>
        <div class="alert alert-success">
            Au revoir !
        </div>
        <script>
            // Optional: Redirect if it hangs
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
        </script>
    </div>
</div>