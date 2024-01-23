<?php
// api/users.php

switch ($method) {
    case 'GET':
        echo'get request';
        error_log("user/get");
        if (isset($_GET['user_id'])) {
            getUser($conn, $_GET['user_id']);
        } else {
            getUsers($conn);
        }
        break;
    case 'POST':
        createUser($conn);
        break;
    case 'PUT':
        $user_id = $_GET['user_id'] ?? null;
        updateUser($conn, $user_id);
        break;
    case 'DELETE':
        $user_id = $_GET['user_id'] ?? null;
        deleteUser($conn, $user_id);
        break;
    default:
        header("HTTP/1.1 405 Method Not Allowed");
        exit;
}

function getUsers($conn) {
    $sql = "SELECT * FROM Users";
    $result = $conn->query($sql);

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($users);
}

function getUser($conn, $user_id) {
    $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($user);
}

function createUser($conn) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("INSERT INTO Users (first_name, surname) VALUES (?, ?)");
    $stmt->bind_param("ss", $data['first_name'], $data['surname']);
    $stmt->execute();

    echo "User created successfully";
}

function updateUser($conn, $user_id) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $conn->prepare("UPDATE Users SET first_name = ?, surname = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $data['first_name'], $data['surname'], $user_id);
    $stmt->execute();

    echo "User updated successfully";
}

function deleteUser($conn, $user_id) {
    $stmt = $conn->prepare("DELETE FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo "User deleted successfully";
}