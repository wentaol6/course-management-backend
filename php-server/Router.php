<?php
define('REQ_HANDLER_DIR', 'RequestHandler/');

class Router {
    private static $instance = null;
    private $routes = [];

    private function __construct() {
        $this->Init();
    }

    // return the instance of the singleton class
    public static function GetInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function Init() {
        // add routing rules
        $this->AddRoute('/php-server/management', 'ManageReqHandler');
        $this->AddRoute('/php-server/display', 'DisplayReqHandler');

    }

    public function AddRoute($path, $handlerClass) {
        $this->routes[$path] = $handlerClass;
    }

    // GET the corresponding RequestHandler and handle message
    public function Route(ReqMsg $reqMsg) {
        if (isset($this->routes[$reqMsg->getPath()])) {
            $handlerClass = $this->routes[$reqMsg->getPath()];
            require_once REQ_HANDLER_DIR . $handlerClass . '.php';

            $handler = new $handlerClass();
            $handler->HandleRequest($reqMsg);
        } else {
            echo "404 Not Found";
        }
    }
}