<?php
// UsersCRUD

require_once 'CRUDTemplate.php';

class UsersCRUD extends CRUDTemplate {

    protected function create() {
        // create user
        $stmt = $this->conn->prepare("INSERT INTO Users (first_name, surname) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->reqMsg->getBody()['first_name'], $this->reqMsg->getBody()['surname']);
        $stmt->execute();
        echo "User created successfully";
    }

    protected function read() {
        // read user
        if ($this->reqMsg->getParam() === 'all') {
            $sql = "SELECT * FROM Users";
            $result = $this->conn->query($sql);
            $users = [];
            
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($users);
        } else {
            $userId = $this->reqMsg->getParam();
            $stmt = $this->conn->prepare("SELECT * FROM Users WHERE user_id = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
    
            header('Content-Type: application/json');
            echo json_encode($user);
        }
        
    }

    protected function update() {
        // update user
        $stmt = $this->conn->prepare("UPDATE Users SET first_name = ?, surname = ? WHERE user_id = ?");
        $stmt->bind_param("ssi", $this->reqMsg->getBody()['first_name'], $this->reqMsg->getBody()['surname'], $this->reqMsg->getBody()['user_id']);
        $stmt->execute();
    
        echo "User updated successfully";
    }

    protected function delete() {
        // delete user
        $stmt = $this->conn->prepare("DELETE FROM Users WHERE user_id = ?");
        $stmt->bind_param("i", $this->reqMsg->getBody()['user_id']);
        $stmt->execute();

        echo "User deleted successfully";
    }
}
