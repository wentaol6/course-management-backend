<?php
// EnrolmentsCRUD.php

require_once 'CRUDTemplate.php';

class EnrolmentsCRUD extends CRUDTemplate {

    protected function create() {
        // create enrolment
        $stmt = $this->conn->prepare("INSERT INTO enrolments (user_id, course_id, status) VALUES (?, ?, ?)");
        $body = $this->reqMsg->getBody();
        if (!isset($body['user_id'], $body['course_id'], $body['status'])) {
            echo "Error: Missing required data.";
            return;
        }

        $stmt->bind_param("iis", $body['user_id'], $body['course_id'], $body['status']);

        if ($stmt->execute()) {
            echo "Enrolment added successfully.";
        } else {
            echo "Error executing statement.";
        }
    }

    protected function read() {
        // read enrolment
        if ($this->reqMsg->getGetId() === 'all') {
            $sql = "SELECT * FROM Enrolments";
            $result = $this->conn->query($sql);
            $enrolments = [];
            
            while ($row = $result->fetch_assoc()) {
                $enrolments[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($enrolments);
        } else {
            $enrolmentId = $this->reqMsg->getGetId();
            $stmt = $this->conn->prepare("SELECT * FROM Enrolments WHERE enrolment_id = ?");
            $stmt->bind_param("i", $enrolmentId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $enrolment = $result->fetch_assoc();
    
            header('Content-Type: application/json');
            echo json_encode($enrolment);
        }
    }

    protected function update() {
        // update enrolment
        $stmt = $this->conn->prepare("UPDATE Enrolments SET user_id = ?, course_id = ?, status = ? WHERE enrolment_id = ?");
        $stmt->bind_param("iisi", $this->reqMsg->getBody()['user_id'], $this->reqMsg->getBody()['course_id'], $this->reqMsg->getBody()['status'], $this->reqMsg->getBody()['enrolment_id']);
        $stmt->execute();
    
        echo "User updated successfully";
    }

    protected function delete() {
        // delete enrolment
        $stmt = $this->conn->prepare("DELETE FROM Enrolments WHERE enrolment_id = ?");
        $stmt->bind_param("i", $this->reqMsg->getBody()['enrolment_id']);
        $stmt->execute();

        echo "Enrolment deleted successfully";
    }
}
