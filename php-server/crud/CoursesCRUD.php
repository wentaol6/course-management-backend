<?php
// CoursesCRUD

require_once 'CRUDTemplate.php';

class CoursesCRUD extends CRUDTemplate {

    protected function create() {
        // create course
        $stmt = $this->conn->prepare("INSERT INTO Courses (description) VALUES (?)");
        $stmt->bind_param("s", $this->reqMsg->getBody()['description']);
        $stmt->execute();
        echo "Course created successfully";
    }

    // protected function read() {
    //     // read course
    //     $courseId = $this->reqMsg->getParam()['course_id'];
    //     $courses = [];
    //     if ($courseId === 'all') {
    //         $sql = "SELECT * FROM Courses";
    //         $result = $this->conn->query($sql);
            
    //         while ($row = $result->fetch_assoc()) {
    //             $courses[] = $row;
    //         }

    //     } else {
    //         $stmt = $this->conn->prepare("SELECT * FROM Courses WHERE course_id = ?");
    //         $stmt->bind_param("i", $courseId);
    //         $stmt->execute();
    
    //         $result = $stmt->get_result();
    //         if ($course = $result->fetch_assoc()) {
    //             $courses[] = $course;
    //         } else {
    //             // course not found
    //             $courses = ['error' => 'Course not found'];
    //         }
    
    //     }
    //     header('Content-Type: application/json');
    //     echo json_encode($courses);
    // }

    protected function getRdParams() {
        return ['course_id', 'Courses'];
    }
    protected function update() {
        // update course
        $stmt = $this->conn->prepare("UPDATE Courses SET description = ? WHERE course_id = ?");
        $stmt->bind_param("ss", $this->reqMsg->getBody()['description'], $this->reqMsg->getBody()['course_id']);
        $success = $stmt->execute();

        header('Content-Type: application/json');
        if (!$success) {
            // fail to execute
            echo json_encode(["error" => "Failed to update course"]);
            return;
        }
    
        if ($this->conn->affected_rows === 0) {
            // no record
            echo json_encode(["message" => "No course found with given ID"]);
            return;
        }
    
        // update succeed
        echo json_encode(["message" => "Course updated successfully"]);
    }

    // protected function delete() {
    //     // delete course
    //     $stmt = $this->conn->prepare("DELETE FROM Courses WHERE course_id = ?");
    //     $stmt->bind_param("i", $this->reqMsg->getParam()['course_id']);
    //     $success = $stmt->execute();

    //     header('Content-Type: application/json');
    //     if (!$success) {
    //         // fail to execute
    //         echo json_encode(["error" => "Failed to delete course"]);
    //         return;
    //     }
    
    //     if ($this->conn->affected_rows === 0) {
    //         // no record
    //         echo json_encode(["message" => "No course found with given ID"]);
    //         return;
    //     }
    
    //     // delete succeed
    //     echo json_encode(["message" => "Course deleted successfully"]);
    // }
}
