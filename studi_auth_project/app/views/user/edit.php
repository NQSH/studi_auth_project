<h1>Modifier le profil</h1>

<?php displayResponse() ?>

<form method="POST" action="edit" class="container mt-5" style="max-width: 400px;">
    <?php generate_csrf_token() ?>

    <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $user->username) ?>" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= old('email', $user->email) ?>" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
    </div>

    </br>

    <button type="submit" class="btn btn-dark w-100">Modifier le profil</button>
</form>