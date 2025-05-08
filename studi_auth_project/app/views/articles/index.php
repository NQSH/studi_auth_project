<div class="container d-flex flex-column gap-3">
    <?php if (isLoggedIn()): ?>
        <?php include 'create.php'; ?>
        <?php displayResponse() ?>
        <br>
    <?php else: ?>
        <p class="text-center"><a href="/login">Connectez-vous</a> pour pouvoir ajouter un article.</p>
    <?php endif; ?>
    <?php foreach ($data['articles'] as $article) include 'index_article.php' ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= ceil($data['total'] / 10); $i++): ?>
                <li class="page-item <?= $data['page'] === $i ? 'active' : '' ?>">
                    <a class="page-link <?= $data['page'] === $i ? 'bg-dark border-dark' : 'text-dark' ?>" href="/articles?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>