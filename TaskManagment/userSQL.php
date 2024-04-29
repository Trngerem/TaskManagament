<?php
function user () {

    $db = new SQLITE3('C:\xampp\TaskManagementProject\Task_Management.db');
        
    $stmt = $db->prepare('SELECT * FROM Users WHERE Email=:email');
    $stmt->bindParam(':email', $email, SQLITE3_TEXT);

    $email = $_GET['email'];
    $result = $stmt->execute();

    $rows_array = [];

    while ($row=$result->fetchArray())
    {
       $rows_array[]=$row;
    }
    return $rows_array;
} //this gets email and outputs the users data