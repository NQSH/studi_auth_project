<?php

class ArticleController
{
    public function index()
    {
        $page = isset($_GET['page']) ? (int)cleanInput($_GET['page']) : 1;
        $articles = Article::all($page);
        render('articles/index', ['articles' => $articles, 'page' => $page, 'total' => Article::count()]);
    }

    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            renderNotFound();
            return;
        }
        render('articles/show', ['article' => $article]);
    }

    public function showAuthor($id)
    {
        $articles = Article::allByAuthor($id);
        $author = User::findById($id)->username;
        render('articles/author', ['articles' => $articles, 'author' => $author, 'author_id' => $id]);
    }

    public function create()
    {
        requireLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                Article::create($_SESSION['user']['id'], $_POST['content']);
                redirect('articles');
            } catch (Exception $e) {
                setResponseMessage('error', $e->getMessage());
                redirect('articles');
                return;
            }
        }
    }

    public function edit($id)
    {
        requireLogin();

        $article = Article::find($id);

        if (!$article) {
            renderNotFound();
            return;
        }

        if ($article['author_id'] !== $_SESSION['user']['id']) {
            renderForbidden();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            check_csrf_token();
            Article::update($id, $_POST);
            redirect('articles/' . $id);
            exit;
        }

        render('articles/edit', ['article' => $article]);
    }

    public function delete($id)
    {
        requireLogin();

        $article = Article::find($id);

        if (!$article) {
            renderNotFound();
            return;
        }

        if ($article['author_id'] !== $_SESSION['user']['id']) {
            renderForbidden();
            return;
        }

        try {
            Article::delete($id);
            setResponseMessage('success', "Article supprimé avec succès.");
            redirect('articles');
        } catch (Exception $e) {
            setResponseMessage('error', $e->getMessage());
            redirect('articles');
        }
    }
}
