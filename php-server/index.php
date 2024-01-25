<?php
// index.php
require_once 'Router.php';
require_once 'ReqMsg.php';

$reqMsg = new ReqMsg();

// Debug:echo message
// $path = $reqMsg->getPath();
// $method = $reqMsg->getMethod();
// $getId = $reqMsg->getParam();
// $body = $reqMsg->getBody();
// $jsonBody = json_encode($body);
// echo "Requested path: " . $path . "\n";
// echo "Requested method: " . $method . "\n";
// echo "Requested getId: " . $getId . "\n";
// var_dump($reqMsg->getBody());

Router::getInstance()->Route($reqMsg);




