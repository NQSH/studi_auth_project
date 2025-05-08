<h1>Connexion</h1>

<?php displayResponse() ?>

<form method="POST" action="login" class="container mt-5" style="max-width: 400px;">
    <?php generate_csrf_token() ?>

    <div class="mb-3">
        <label for="identifier" class="form-label">Nom d'utilisateur ou Email</label>
        <input type="text" name="identifier" id="identifier" class="form-control" value="<?= e(old('identifier', 'john.doe@email.fr')) ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" value="<?= e(old('password', '1234')) ?>" required>
    </div>
    </br>
    <button type="submit" class="btn btn-dark w-100">Se connecter</button>
</form>

</br>

<p>Pas encore de compte ? <a href="/signup">Créer un compte</a></p>