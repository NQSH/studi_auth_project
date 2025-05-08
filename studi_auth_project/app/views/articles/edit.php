<form method="POST" action="/articles/edit/<?= $article['_id'] ?>" class="container vstack gap-3">
    <?php generate_csrf_token() ?>
    <div class="container p-0">
        <label for="content" class="form-label ps-3">Modification de l'article</label>
        <textarea name="content" class="form-control" rows="5"><?= htmlspecialchars($article['content']) ?></textarea>
    </div>
    <button class="btn btn-dark">Envoyer</button>
</form>