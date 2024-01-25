<?php
class ReqMsg {
    private $path;
    private $method;
    private $param;
    private $body;

    public function __construct() {
        // decode url
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // decode method
        $this->method = $_SERVER['REQUEST_METHOD'];

        // decode message based on method
        if ($this->method === 'GET'|| $this->method === 'DELETE') {
            $this->handleParamRequest();
        } elseif ($this->method === 'POST'|| $this->method === 'PUT') {
            $this->handleBodyRequest();
        }
    }

    private function handleParamRequest() {
        // decode parameters
        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $this->param);
        print_r($this->param);
    }

    private function handleBodyRequest() {
        // decode request body
        $requestBody = file_get_contents("php://input");
        $this->body = json_decode($requestBody, true);

        // handle failure
        if (!is_array($this->body)) {
            $this->body = [];
        }
    }

    // getters
    public function getPath() {
        return $this->path;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getParam() {
        return $this->param;
    }

    public function getBody() {
        return $this->body;
    }
}

