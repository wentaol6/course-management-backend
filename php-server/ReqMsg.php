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

        // decode parameters       
        parse_str($_SERVER['QUERY_STRING'], $this->param);

        // decode body
        if ($this->method === 'POST'|| $this->method === 'PUT') {
            $this->DecodeBody();
        }
    }

    private function DecodeBody() {
        // decode request body
        $requestBody = file_get_contents("php://input");
        $this->body = json_decode($requestBody, true);
        if ($this->body === null) {
            // decode failure
            http_response_code(400); 
            echo json_encode(array("message" => "Invalid JSON data"));
            exit;
        }

    }

    // getters
    public function GetPath() {
        return $this->path;
    }

    public function GetMethod() {
        return $this->method;
    }

    public function GetParam() {
        return $this->param;
    }

    public function GetBody() {
        return $this->body;
    }
}

