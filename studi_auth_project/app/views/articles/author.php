<div class="container d-flex flex-column gap-3">
    <h3 class="card-title">
        <?php if (isLoggedIn() && $data['author_id'] === $_SESSION['user']['id']) {
            echo "Mes articles";
        } else {
            echo "@" . $data['author'];
        }
        ?>
    </h3>

    <?php foreach ($data['articles'] as $article) include 'author_article.php' ?>
</div>