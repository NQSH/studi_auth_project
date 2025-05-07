<?php

function render(string $viewPath, array $data = [], string $title = 'Bienvenue')
{
    if (isset($_SESSION['title'])) {
        $title = $_SESSION['title'];
        unset($_SESSION['title']);
    }
    extract($data); // Rend les variables accessibles dans la vue
    $view = VIEW_PATH . '/' . $viewPath . '.php';
    require __DIR__ . '/../../app/views/layout/main.php';
}

function renderNotFound(): void
{
    http_response_code(404);
    render('404', [], 'Page non trouvée');
}

function renderForbidden(): void
{
    http_response_code(403);
    render('403', [], 'Vous n\'êtes pas autorisé à accéder à cette page');
}
