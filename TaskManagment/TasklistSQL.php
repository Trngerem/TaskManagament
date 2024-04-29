<?php

function getTasks ($ID){
    $db = new SQLITE3('C:\xampp\TaskManagementProject\Task_Management.db');
    $sql = "SELECT * FROM Tasks WHERE UserID = :ID OR manager = :ID ORDER BY due_date";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ID', $ID, SQLITE3_TEXT);

    $result = $stmt->execute();
    
    while ($row = $result->fetchArray()){ 
        $arrayResult [] = $row; 
    }
    return $arrayResult;
}
?>