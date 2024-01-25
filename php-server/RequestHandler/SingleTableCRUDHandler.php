<?
class SingleTableCRUDHandler {
    private $reqMsg;
    private $conn;
    private $table;

    public function __construct($reqMsg, $conn, $table) {
        $this->reqMsg = $reqMsg;
        $this->conn = $conn;
        $this->table = $table;
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
        $searchKey = array_key_first($this->reqMsg->getParam());
        $courseId = $this->reqMsg->getParam()[$searchKey];
        $courses = [];
        if ($courseId === 'all') {
            $stmt = $this->conn->prepare("SELECT * FROM ?");
            $stmt->bind_param("s", $this->table);
            $stmt->execute();
            $result = $stmt->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }

        } else {
            $stmt = $this->conn->prepare("SELECT * FROM ? WHERE course_id = ?");
            $stmt->bind_param("si", $this->table, $courseId);
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

    private function create(){
        // 获取要插入的数据
        $insertData = $this->reqMsg->getBody();

        // 获取字段名和相应的值
        $fields = array_keys($insertData);
        $values = array_values($insertData);

        // 构建SQL插入语句
        $fieldList = implode(', ', $fields);
        $placeholderList = implode(', ', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO {$this->table} ($fieldList) VALUES ($placeholderList)";

        $stmt = $this->conn->prepare($sql);
        header('Content-Type: application/json', true, 500);
        if (!$stmt) {
            echo json_encode(["error" => "Failed to prepare SQL statement"]);
            return;
        }

        // 绑定参数
        $types = str_repeat("s", count($values)); // 假设所有字段都是字符串类型
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();

        // 处理执行结果
        if (!$success) {
            echo json_encode(["error" => "Failed to insert data"]);
            return;
        }

        echo json_encode(["message" => "Data inserted successfully"]);
    }

    private function update(){
        $updateData = $this->reqMsg->getBody();
        // 提取第一对键值对作为更新条件
        reset($updateData); // 重置数组指针到第一个元素
        $conditionKey = key($updateData); // 获取第一个键
        $conditionValue = array_shift($updateData); // 获取并移除第一个值

        // 检查是否还有数据用于更新
        header('Content-Type: application/json');
        if (count($updateData) === 0) {
            echo json_encode(["error" => "No data provided for update"]);
            return;
        }

        // 准备更新字段的SQL语句部分
        $setParts = [];
        $types = "s"; // 第一个参数的类型
        $values = [$conditionValue]; // 初始化参数数组
        foreach ($updateData as $key => $value) {
            $setParts[] = "$key = ?";
            $types .= "s"; // 假设所有字段都是字符串类型
            $values[] = $value;
        }

        // 构建完整的SQL语句
        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE $conditionKey = ?";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(["error" => "Failed to prepare SQL statement"]);
            return;
        }

        // 绑定参数
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();

        // 处理执行结果
        if (!$success) {
            echo json_encode(["error" => "Failed to update"]);
            return;
        }

        if ($this->conn->affected_rows === 0) {
            echo json_encode(["message" => "No record updated"]);
            return;
        }

        echo json_encode(["message" => "Record updated successfully"]);
    }

    private function delete(){
        // delete course
        $searchKey = array_key_first($this->reqMsg->getParam());
        $stmt = $this->conn->prepare("DELETE FROM ? WHERE ? = ?");
        $stmt->bind_param("ssi", $this->table, $searchKey, $this->reqMsg->getParam()[$searchKey]);
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
