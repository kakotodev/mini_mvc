<div>
    Vous êtes entrain de vous deconnecter...
</div>

<script>
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['flash_message'])):
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
</script>