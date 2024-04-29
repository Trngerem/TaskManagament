<!doctype html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="stylesheet.css/">


<?php
require("UserNav.php");
include_once("userSQL.php");

$user = user();

if (isset($_POST['submit'])) {
    $conn = new SQLite3('C:\xampp\TaskManagementProject\Task_Management.db');

    // Prepare and execute SQL statement to insert new task
    $stmt = $conn->prepare("INSERT INTO Tasks (task, due_date, UserID, favourite) VALUES (:task, :due_date, :ID, :fav)");
    $stmt->bindParam(":task", $task);
    $stmt->bindParam(":due_date", $due_date);
    $stmt->bindParam(":ID", $userid);
    $stmt->bindParam(":fav", $fav);

    $userid = $user[0]['UserID'];
    $task = $_POST["task"];
    $due_date = $_POST["due_date"];

    if ($_POST['fav'] == '1'){
        $fav = "yes";
    }
    else{
        $fav = null;
    }

    $stmt->execute();

    header('Location: privateindex.php?email='.$_GET['email']);
}
?>

<style>
</style>    

<body class= "bgColor">
    <main role="main" class="pb-3">

    <h1>Task Management System</h1>

    <body>
    <nav class="box2">
        <div class="container">
            <div>
            <h1 style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: white">Add Task</h1>
                <form method="post">

                <label for="task">Task:</label>
                    <input class="form-control" type="text" id="task" name="task" required>
                    <br>
                    <label for="due_date">Due Date:</label>
                    <input class="form-control" type="date" id="due_date" name="due_date">
                    <br>
                    <label for="fav">Favourite?</label>
                    <input type="hidden" name="fav" value="0" />
                    <input type="checkbox" name="fav" value="1">
                    <br>
                    <input type="submit" id="submit" name="submit" value="Add Task">
                </form>
            </div>  
        </div>    
        </main>
        <a class="btn btn-primary" href="privateindex.php?email=<?php echo $_GET['email']; ?>">return</a>
</body>



<?php require("Footer.php");?>