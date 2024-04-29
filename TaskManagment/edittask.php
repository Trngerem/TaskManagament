<?php require("userNav.php");
include_once('TaskListSQL.php'); //fetch the tasks from an ID
include_once('userSQL.php'); //transform email into ID

$user = user(); //change $_GET email into userid
$tasklist = getTasks($user[0]['UserID']); //change user id into list of tasks with same id in record
$row = $_GET['row']; //get the row of task

if (isset($_POST['submit'])){

    $conn = new SQLite3('C:\xampp\TaskManagementProject\Task_Management.db');
    $stmt = $conn->prepare("UPDATE Tasks SET task = :task, due_date = :due_date, favourite = :fav, support = :support, pass = :pass WHERE task = :oldtask AND due_date = :olddue");
    $stmt->bindParam(":oldtask", $oldtask);
    $stmt->bindParam(":olddue", $olddue);
    $stmt->bindParam(":task", $task);
    $stmt->bindParam(":due_date", $due_date);
    $stmt->bindParam(":fav", $fav);
    $stmt->bindParam(":support", $support);
    $stmt->bindParam(":pass", $pass);

    $olddue = $_GET['olddue'];
    $oldtask = $_GET['task'];
    $task = $_POST["task"];
    $due_date = $_POST["due_date"];
    $fav = "yes";

    if($_POST['fav'] == "yes"){
        $fav = $_POST['fav'];
    }
    else{
        $fav = null;
    }

    if($_POST['support'] == "yes"){
        $support = $_POST['support'];
    }
    else{
        $support = null;
    }

    if($_POST['pass'] == "yes"){
        $pass = $_POST['pass'];
    }
    else{
        $pass = null;
    }

    $stmt->execute();
    header("Location: privateindex.php?email=".$_GET['email']); 
}


?>
    <nav class="box2">
        <div class="container">
            <div>
            <h1 style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: black">Update Task: <b><u><?php echo $_GET['task'] ?></b></u></h1>
                <form method="post">
                <label for="task">New Task Name:</label>
                    <input class="form-control" type="text" id="task" name="task" value="<?php echo $tasklist[$row]['task']; ?>">
                    <br>
                    <label for="due_date">New Due Date:</label>
                    <input class="form-control" type="date" id="due_date" name="due_date" value="<?php echo $tasklist[$row]['due_date']; ?>">
                    <br>
                    <label for="fav">Favourite?</label>
                    <input type="checkbox" name="fav" value="yes">
                    <br>
                   <div class="form-group col-md-3">
                       <input type="submit" name="submit" value="Update" class="btn btn-primary">
                       <a class="btn btn-primary" href="privateindex.php?email=<?php echo $_GET['email']; ?>">Return</a>
                       <a class="btn btn-danger" href="deletetask.php?email=<?php echo $_GET['email']; ?>&row=<?php echo $_GET['row']; ?>">Delete</a>
                   </div>
                   <?php if ($user[0]['Role'] == "worker"){ ?>
                            <label for="support">support?</label>
                            <input type="checkbox" name="support" value="yes">
                            <br>
                            <label for="pass">Pass onto someone else?</label>
                            <input type="checkbox" name="pass" value="yes">
                            <br>
                            <?php } 
                            else{

                            } ?>
                    <?php if($user[0]['Role'] == "manager"){


                    }
                    
                    ?>
                </form>
            </div>
        </div>
		</main>

	</div>
<?php require("Footer.php");?>