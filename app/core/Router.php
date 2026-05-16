<?php
class Router {
    private $current_controller = 'HomeController';
    private $current_method = 'index';
    private $params = [];

    private $routes = [
        'about'       => ['controller' => 'PagesController', 'method' => 'about'],
        'services'    => ['controller' => 'PagesController', 'method' => 'services'],
        'promotions'  => ['controller' => 'PagesController', 'method' => 'promotions'],
        'contact'     => ['controller' => 'PagesController', 'method' => 'contact'],
        'faq'         => ['controller' => 'PagesController', 'method' => 'faq'],
        'tracking'    => ['controller' => 'TrackingController', 'method' => 'index'],
        'dashboard'   => ['controller' => 'DashboardController', 'method' => 'index'],
    ];

    public function __construct() {
        $url = $this->parseUrl();

        if ($url) {
            $route_key = strtolower($url[0]);

            if (isset($this->routes[$route_key])) {
                $this->current_controller = $this->routes[$route_key]['controller'];
                $this->current_method = $this->routes[$route_key]['method'];
                unset($url[0]);
            } elseif (file_exists('../app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->current_controller = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->current_controller . '.php';
        $this->current_controller = new $this->current_controller;

        if (isset($url[1]) && $url[1] === 'view' && method_exists($this->current_controller, 'detail')) {
            $url[1] = 'detail';
        }

        if (isset($url[1]) && method_exists($this->current_controller, $url[1])) {
            $this->current_method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->current_controller, $this->current_method], $this->params);
    }

    public function parseUrl() {
        if (!isset($_GET['url'])) {
            return null;
        }

        return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
    }
}
