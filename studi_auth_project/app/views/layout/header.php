<!-- app/Views/layouts/header.php -->
<header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><?= APP_NAME ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (isLoggedIn()): ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/articles/author/<?= $_SESSION['user']['id'] ?>">Mes articles</a></li>
                        <li class="nav-item"><a class="nav-link" href="/user">Profil</a></li>
                        <li class="nav-item">
                            <button class="btn btn-dark ms-3" onclick="window.location.href='/logout'">Déconnexion</button>
                        </li>
                    </ul>
                <?php endif; ?>

                <?php if (!isLoggedIn()): ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="/login">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="/signup">Créer un compte</a></li>
                    </ul>
                <?php endif; ?>
            </div>

        </div>
    </nav>
</header>