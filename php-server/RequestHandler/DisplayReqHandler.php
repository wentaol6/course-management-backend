<?php
require_once 'IRequestHandler.php';
require_once __DIR__ . '/../Database/DatabaseManager.php';

class DisplayReqHandler implements IRequestHandler {

    public function HandleRequest(ReqMsg $reqMsg) {
        // only accept get method
        if ($reqMsg->getMethod() !== 'GET') {
            http_response_code(405); 
            header('Content-Type: application/json');
            echo json_encode(["error" => "Invalid method"]);
            return;
        }

        $conn = DatabaseManager::GetInstance()->GetConnection();
        $stmt = $conn->query("
            SELECT enrolments.enrolment_id, Users.first_name, Users.surname, Courses.description
            FROM enrolments
            INNER JOIN Users ON enrolments.user_id = Users.user_id
            INNER JOIN Courses ON enrolments.course_id = Courses.course_id
            " . $this->GetQueryCondition($reqMsg->GetParam())
        );

    
        if ($stmt) {
            $records = $stmt->fetch_all(MYSQLI_ASSOC);
            if (empty($records)) {
                // no record found
                http_response_code(404); 
                $records = ['error' => 'No records found'];
            }
        } else {
            // query failure
            http_response_code(500); 
            $records = ['error' => $conn->error];
        }

        header('Content-Type: application/json');
        echo json_encode($records);
    }

    private function GetQueryCondition($params) {
        $condition = "";
        switch ($params['query_condition']) {
            case 'by_user':
                $condition = " WHERE Users.user_id = {$params['id']}"; 
                break;
            case 'by_course':
                $condition = " WHERE Courses.course_id = {$params['id']}"; 
                break;
            default:
                break;
        }
        return $condition;
    }
}
