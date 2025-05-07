<?php

class ArticleController
{
    public function index()
    {
        $page = isset($_GET['page']) ? (int)cleanInput($_GET['page']) : 1;

        $articles = Article::all($page);
        foreach ($articles as $article) {
            $article['author'] = User::findById($article['author_id'])->username;
        }
        render('articles/index', ['articles' => $articles, 'page' => $page, 'total' => Article::count()]);
    }

    public function show($id)
    {
        $article = Article::find($id);
        $article['author'] = User::findById($article['author_id'])->username;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'author_id' => $_SESSION['user']['id'],
                'content' => cleanInput($_POST['content']),
                'created_at' => new MongoDB\BSON\UTCDateTime(),
            ];
            Article::create($data);
            redirect('articles');
            exit;
        }
    }

    public function edit($id)
    {
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
            $data = $_POST;
            Article::update($id, $data);
            redirect('articles/' . $id);
            exit;
        }

        render('articles/edit', ['article' => $article]);
    }

    public function delete($id)
    {
        Article::delete($id);
        redirect('articles');
        exit;
    }
}
