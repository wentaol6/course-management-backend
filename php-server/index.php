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

// invoke different file for different api
echo "Requested Path: " . $path . "\n";
switch ($path) {
    case '/php-server/api/users':
        echo "users api \n";
        require 'api/users.php';
        break;
    case '/php-server/api/courses':
        require 'api/courses.php';
        break;
    case '/php-server/api/enrolments':
        require 'api/enrolments.php';
        break;
    case '/php-server/api/reports':
        require 'api/reports.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Not Found"]);
        break;
}

$conn->close();