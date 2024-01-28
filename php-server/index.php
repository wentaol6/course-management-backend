<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
require_once 'Router.php';
require_once 'ReqMsg.php';

// Decode all the infomation into ReqMsg
$reqMsg = new ReqMsg();

// generate the corresponding RequestHandler
Router::getInstance()->Route($reqMsg);




