<div class="d-flex flex-column">
    <?php displayResponse() ?>
    <p><b>Nom d'utilisateur: </b><?= htmlspecialchars($user->username) ?></p>
    <p><b>Adresse email: </b><?= htmlspecialchars($user->email) ?></p>
    <button class="btn btn-dark" onclick="window.location.href='/user/edit'">Modifier mon profil</button>
    </br>
    <button class="btn btn-dark" onclick="window.location.href='/user/delete'">Supprimer mon compte</button>
</div>