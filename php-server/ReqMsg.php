<?php
class ReqMsg {
    private $path;
    private $method;
    private $getId;
    private $body;

    public function __construct() {
        // 获取请求的URL路径
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // 获取请求方法
        $this->method = $_SERVER['REQUEST_METHOD'];

        // 根据请求方法处理数据
        if ($this->method === 'GET') {
            $this->handleGetRequest();
        } elseif (in_array($this->method, ['POST', 'PUT', 'DELETE'])) {
            $this->handleBodyRequest();
        }
    }

    private function handleGetRequest() {
        // 解析GET请求的查询参数
        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $queryParams);
        $this->getId = $queryParams['get_id'] ?? null;
    }

    private function handleBodyRequest() {
        // 获取并解析请求体
        $requestBody = file_get_contents("php://input");
        $this->body = json_decode($requestBody, true);

        // 如果JSON解析失败，设置body为空数组
        if (!is_array($this->body)) {
            $this->body = [];
        }
    }

    // 公共方法以获取成员变量值
    public function getPath() {
        return $this->path;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getGetId() {
        return $this->getId;
    }

    public function getBody() {
        return $this->body;
    }
}

