<?php
require_once 'Router.php';
require_once 'ReqMsg.php';

$reqMsg = new ReqMsg();
Router::getInstance()->Route($reqMsg);




