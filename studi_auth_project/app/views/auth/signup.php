<h1>Créer un compte</h1>

<?php displayResponse() ?>

<form method="POST" action="signup" class="container mt-5" style="max-width: 400px;">
    <?php generate_csrf_token() ?>

    <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= e(old('username')) ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= e(old('email')) ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" value="<?= e(old('password')) ?>" required>
    </div>

    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" value="<?= e(old('confirm_password')) ?>" required>
    </div>

    </br>

    <button type="submit" class="btn btn-dark w-100">S'inscrire</button>
</form>

</br>

<p>Déjà un compte ? <a href="/login">Se connecter</a></p>