<?php
class ReportApiHandler {
    protected $reqMsg;
    protected $conn;

    public function __construct($reqMsg, $conn) {
        $this->reqMsg = $reqMsg;
        $this->conn = $conn;
    }

    public function handleRequest() {
        if ($this->reqMsg->getMethod() !== 'POST') {
            echo "Invalid method.";
            return;
        }
        if ($this->reqMsg->getPath() === '/php-server/report/user') {
            $stmt = $this->conn->prepare("SELECT * FROM Enrolments WHERE user_id = ?");
            $stmt->bind_param("i", $this->reqMsg->getBody()['user_id']);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $enrolments = [];
            
            while ($row = $result->fetch_assoc()) {
                $enrolments[] = $row;
            }
            
            header('Content-Type: application/json');
            echo json_encode($enrolments);


        } else if ($this->reqMsg->getPath() === '/php-server/report/course') {
            $stmt = $this->conn->prepare("SELECT * FROM Enrolments WHERE course_id = ?");
            $stmt->bind_param("i", $this->reqMsg->getBody()['course_id']);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $enrolments = [];
            
            while ($row = $result->fetch_assoc()) {
                $enrolments[] = $row;
            }
            
            header('Content-Type: application/json');
            echo json_encode($enrolments);
        } else {
            echo "Invalid request url.";
        }
    }
}