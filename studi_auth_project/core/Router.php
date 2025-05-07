<?php
// core/Router.php
class Router
{
    private $routes = [];

    public function get($path, $callback, $title = null)
    {
        $this->addRoute('GET', $path, $callback, $title);
    }

    public function post($path, $callback, $title = null)
    {
        $this->addRoute('POST', $path, $callback, $title);
    }

    private function addRoute($method, $path, $callback, $title = null)
    {
        $this->routes[] = compact('method', 'path', 'callback', 'title');
    }

    public function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            $pattern = "@^" . preg_replace('/\{[^\}]+\}/', '([^/]+)', $route['path']) . "$@";
            if ($method === $route['method'] && preg_match($pattern, $uri, $matches)) {
                if (isset($route['title'])) {
                    $_SESSION['title'] = $route['title'];
                }
                array_shift($matches);
                if (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $matches);
                } else {
                    [$controllerName, $methodName] = explode('@', $route['callback']);
                    $controllerPath = "../app/controllers/{$controllerName}.php";
                    if (file_exists($controllerPath)) {
                        require_once $controllerPath;
                        $controller = new $controllerName();
                        call_user_func_array([$controller, $methodName], $matches);
                    }
                }
                return;
            }
        }
        renderNotFound();
    }
}
