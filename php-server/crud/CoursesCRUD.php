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

    protected function read() {
        // read course
        if ($this->reqMsg->getGetId() === 'all') {
            $sql = "SELECT * FROM Courses";
            $result = $this->conn->query($sql);
            $courses = [];
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }

            header('Content-Type: application/json');
            echo json_encode($courses);
        } else {
            $courseId = $this->reqMsg->getGetId();
            $stmt = $this->conn->prepare("SELECT * FROM Courses WHERE course_id = ?");
            $stmt->bind_param("i", $courseId);
            $stmt->execute();
    
            $result = $stmt->get_result();
            $course = $result->fetch_assoc();
    
            header('Content-Type: application/json');
            echo json_encode($course);
        }
    }

    protected function update() {
        // update course
        // TODO 错误处理：更新不存在的值
        $stmt = $this->conn->prepare("UPDATE Courses SET description = ? WHERE course_id = ?");
        $stmt->bind_param("ss", $this->reqMsg->getBody()['description'], $this->reqMsg->getBody()['course_id']);
        $stmt->execute();
    
        echo "Course updated successfully";
    }

    protected function delete() {
        // delete course
        $stmt = $this->conn->prepare("DELETE FROM Courses WHERE course_id = ?");
        $stmt->bind_param("i", $this->reqMsg->getBody()['course_id']);
        $stmt->execute();

        echo "Course deleted successfully";
    }
}
