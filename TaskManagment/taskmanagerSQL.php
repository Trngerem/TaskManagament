<?php

function getmanager(){
    //The database connection
    $db = new SQLite3('C:\xampp\TaskManagementProject\Task_Management.db');

    if(!isset($_POST['filterLevel'])){
        $sql = "SELECT * FROM Tasks";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute();

        while($row = $result->fetchArray(SQLITE3_NUM)){ //I use SQLITE3_NUM because I cannot remember the table's field names!
            $Tasks [] = $row;
        }
    }
    //Otherwise, it goes to here because the user has selected a value from the dropdown button
    else{
        //if the user selects non 'All' value from the dropdown button, we query a specific level
        if($_POST['filtermanager'] != 'All'){
            $sql = "SELECT * FROM Tasks WHERE manager = :manager";
            $stmt = $db->prepare($sql);

            $stmt->bindParam(':manager', $manager, SQLITE3_INTEGER);

            $manager = $_POST['filtermanager'];
            $results = $stmt->execute();

            while($row = $results->fetchArray()){
                $Tasks [] = $row;
            }
        }
        //Otherwise the user has selected 'All' from the dropdown button
        else{
            $sql = "SELECT * FROM Tasks WHERE UserID = :ID";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute();

            while($row = $result->fetchArray(SQLITE3_NUM)){ //I use SQLITE3_NUM because I cannot remember the table's field names!
                $Tasks [] = $row;
            }
        }
    }
    return $Tasks;
}
?>