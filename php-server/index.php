<?php
// index.php

header("Content-Type: application/json");

// get request method and url
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// read the configuration
require_once 'config.php';

// connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// check db connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 创建ReqMsg实例
require_once 'ReqMsg.php';
$reqMsg = new ReqMsg();

// Debug:查看消息体
$path = $reqMsg->getPath();
$method = $reqMsg->getMethod();
$getId = $reqMsg->getGetId();
$body = $reqMsg->getBody();
$jsonBody = json_encode($body);
echo "Requested path: " . $path . "\n";
echo "Requested method: " . $method . "\n";
echo "Requested getId: " . $getId . "\n";
var_dump($reqMsg->getBody());


// new logic

require_once 'crud/CRUDFactory.php';
require_once 'ReportApiHandler.php';
echo "Requested REQUEST_URI: " . $path . "\n";
if (preg_match('/^\/php-server\/(users|courses|enrolments)\/?$/', $path, $matches)) {
    try {
        echo "try try tryyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy\n";
        $crudHandler = CRUDFactory::createCRUD($reqMsg, $conn);
        $crudHandler->handleRequest($reqMsg);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
} else {
    // TODO implement report api
    $reportApiHandler = new ReportApiHandler($reqMsg, $conn);
    $reportApiHandler->handleRequest();
}

$conn->close();