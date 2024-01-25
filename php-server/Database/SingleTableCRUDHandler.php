<?php
require_once 'DatabaseManager.php';
class SingleTableCRUDHandler {

    static function Read($table, $searchKey, $searchValue) {
        $conn = DatabaseManager::GetInstance()->GetConnection();
        if ($searchValue === 'all') {
            $stmt = $conn->query("SELECT * FROM {$table}");
    
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
        } else {
            $stmt = $conn->prepare("SELECT * FROM {$table} WHERE {$searchKey} = ?");
            $stmt->bind_param("s", $searchValue);
            $stmt->execute();
    
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $records = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                // no record found
                http_response_code(404); 
                $records = ['error' => 'Record not found'];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($records);
    }

    static function Create($table, array $entityAttributes) {
        $conn = DatabaseManager::GetInstance()->GetConnection();
    
        $fields = array_keys($entityAttributes);
        $values = array_values($entityAttributes);
    
        $fieldList = implode(', ', $fields);
        $placeholderList = implode(', ', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO {$table} ($fieldList) VALUES ($placeholderList)";
    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500); 
            header('Content-Type: application/json');
            echo json_encode(["error" => "Failed to prepare SQL statement"]);
            return;
        }
    
        // Bind parameters
        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();
    
        // Handle execution result
        if (!$success) {
            http_response_code(500); 
            header('Content-Type: application/json');
            echo json_encode(["error" => "Failed to insert data"]);
            return;
        }
    
        http_response_code(201); 
        header('Content-Type: application/json');
        echo json_encode(["message" => "Data inserted successfully"]);
    }
    

    static function Update($table, $searchKey, $searchValue, array $entityAttributes) {
        $conn = DatabaseManager::GetInstance()->GetConnection();
    
        $setClause = '';
        $values = array_values($entityAttributes);
        $types = '';
    
        foreach ($entityAttributes as $key => $value) {
            $setClause .= $key . ' = ?, ';
            $types .= 's'; 
        }
    
        $setClause = rtrim($setClause, ', ');
    

        $sql = "UPDATE {$table} SET {$setClause} WHERE {$searchKey} = ?";
    
        $values[] = $searchValue;
        $types .= 's'; 
    
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(["error" => "Failed to prepare SQL statement"]);
            return;
        }
    
        // Bind parameters
        $stmt->bind_param($types, ...$values);
        $success = $stmt->execute();
    
        // Handle execution result
        if (!$success) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(["error" => "Failed to update data"]);
            return;
        }

        if ($stmt->affected_rows === 0) {
            // no record found
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(["error" => "No matching records found"]);
            return;
        }
    
        http_response_code(200); 
        header('Content-Type: application/json');
        echo json_encode(["message" => "Data updated successfully"]);
    }
    

    static function Delete($table, $searchKey, $searchValue) {
        $conn = DatabaseManager::GetInstance()->GetConnection();
        $stmt = $conn->prepare("DELETE FROM {$table} WHERE {$searchKey} = ?");
        $stmt->bind_param("s", $searchValue);
        $success = $stmt->execute();
    
        if (!$success) {
            // Delete operation failed
            http_response_code(500); 
            header('Content-Type: application/json');
            echo json_encode(["error" => "Failed to delete"]);
            return;
        }
    
        if ($conn->affected_rows === 0) {
            // No records were deleted
            http_response_code(404); 
            header('Content-Type: application/json');
            echo json_encode(["message" => "No record found with given ID"]);
            return;
        }
    
        // Deletion successful
        header('Content-Type: application/json');
        echo json_encode(["message" => "Record deleted successfully"]);
    }
    
}