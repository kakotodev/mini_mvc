<div>
    <div>
        <h1>LES VRAIS PC POUR LES GAMERS</h1>
    </div>
    <div>
    <div id="message" style="display: none; padding: 10px; margin-bottom: 20px; border-radius: 4px;"></div>
        <?php if (empty($computerproducts)):?>
            <div>
                <p>Aucun article Disponible, revenez plus tard !</p>
            </div>
        <?php else: ?>
            <div>
                <?php foreach ($computerproducts as $product): ?>
                    <div>
                        <img 
                            src="<?= htmlspecialchars($product['url_img']) ?>"
                            alt="<?= htmlspecialchars($product['nom']) ?>"
                            style="max-width: 100%; max-height: 300px"
                            >
                    </div>
                    <div>
                        <div>
                            <span><?= htmlspecialchars($product['nom']) ?></span>
                        </div>
                        <div>
                            <p><?= htmlspecialchars($product['composants'])?></p>
                        </div>
                        <form method="POST" class="PanierProductForm" action="/computers">
                            <input type="hidden" name="id_ordinateur" value="<?= $product['id_ordinateur']?>"/>
                            <button type="submit">Ajouter à votre panier</button>
                        </form>
                        <div id="status-<?=$product['id_ordinateur']?>" style="padding: 5px; margin-top: 5px; border-radius: 4px;">

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif ?>
    </div>
</div>

<script>

const forms = document.querySelectorAll('.PanierProductForm');

forms.forEach(form => {
    form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            console.log(formData)
            const id_ordinateur = formData.get('id_ordinateur')
            console.log(id_ordinateur)
            const messageProfilUserDiv = document.getElementById('status-'+id_ordinateur);
            if(messageProfilUserDiv) {
                messageProfilUserDiv.style.display = 'block';
                messageProfilUserDiv.style.backgroundColor = '#d1ecf1';
                messageProfilUserDiv.style.color = '#0c5460';
                messageProfilUserDiv.textContent = 'Connexion en cours...';
            }
            
            try {
                const response = await fetch('/computers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id_ordinateur: id_ordinateur
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messageProfilUserDiv.style.backgroundColor = '#d4edda';
                    messageProfilUserDiv.style.color = '#155724';
                    messageProfilUserDiv.textContent = '✅ ' + data.message;
                } else {
                    messageProfilUserDiv.style.backgroundColor = '#f8d7da';
                    messageProfilUserDiv.style.color = '#721c24';
                    messageProfilUserDiv.textContent = '❌ ' + (data.error || 'Une erreur est survenue');

                }
            } catch (error) {
                messageProfilUserDiv.style.backgroundColor = '#f8d7da';
                messageProfilUserDiv.style.color = '#721c24';
                messageProfilUserDiv.textContent = '❌ Erreur de connexion : ' + error.message;
            }      
        }
    )
})

</script>