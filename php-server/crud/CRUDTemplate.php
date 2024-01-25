<?php

// CRUD Template

abstract class CRUDTemplate {
    protected $reqMsg;
    protected $conn;

    public function __construct($reqMsg, $conn) {
        $this->reqMsg = $reqMsg;
        $this->conn = $conn;
    }

    public function handleRequest($reqMsg) {
        switch ($reqMsg->getMethod()) {
            case 'GET':
                $this->read();
                break;
            case 'POST':
                $this->create();
                break;
            case 'PUT':
                $this->update();
                break;
            case 'DELETE':
                $this->delete();
                break;
            default:
                header("HTTP/1.1 405 Method Not Allowed");
                exit;
        }
    }

    private function read() {
        [$searchKey, $searchTable] = $this->getRdParams();
        $courseId = $this->reqMsg->getParam()[$searchKey];
        $courses = [];
        if ($courseId === 'all') {
            $stmt = $this->conn->prepare("SELECT * FROM ?");
            $stmt->bind_param("s", $searchTable);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }

        } else {
            $stmt = $this->conn->prepare("SELECT * FROM ? WHERE course_id = ?");
            $stmt->bind_param("si", $searchTable, $courseId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            if ($course = $result->fetch_assoc()) {
                $courses[] = $course;
            } else {
                // course not found
                $courses = ['error' => 'Course not found'];
            }
    
        }
        header('Content-Type: application/json');
        echo json_encode($courses);
    }
    protected abstract function create();
    protected abstract function getRdParams();
    protected abstract function update();
    private function delete(){
        [$searchKey, $searchTable] = $this->getRdParams();
        // delete course
        $stmt = $this->conn->prepare("DELETE FROM ? WHERE ? = ?");
        $stmt->bind_param("ssi", $searchTable, $searchKey, $this->reqMsg->getParam()[$searchKey]);
        $success = $stmt->execute();

        header('Content-Type: application/json');
        if (!$success) {
            // fail to execute
            echo json_encode(["error" => "Failed to delete"]);
            return;
        }
    
        if ($this->conn->affected_rows === 0) {
            // no record
            echo json_encode(["message" => "No record found with given ID"]);
            return;
        }
    
        // delete succeed
        echo json_encode(["message" => "Record deleted successfully"]);
    }
}
