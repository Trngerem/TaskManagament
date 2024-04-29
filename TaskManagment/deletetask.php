<?php require("userNav.php");
include_once('TaskListSQL.php'); //fetch the tasks from an ID
include_once('userSQL.php'); //transform email into ID


$user = user(); //change $_GET email into userid
$tasklist = getTasks($user[0]['UserID']); //change user id into list of tasks with same id in record
$row = $_GET['row'];

$ID = $tasklist[$row]['UserID'];
$task = $tasklist[$row]['task'];
$due_date = $tasklist[$row]['due_date'];

if (isset($_POST['delete'])){

    $conn = new SQLite3('C:\xampp\TaskManagementProject\Task_Management.db');
    $stmt = $conn->prepare("DELETE FROM Tasks WHERE task = :task AND due_date = :due AND UserID = :ID");
    $stmt->bindParam(":task", $task);
    $stmt->bindParam(":due", $due_date);
    $stmt->bindParam(":ID", $ID);

    $stmt->execute();
    header("Location: privateindex.php?deleted=true&email=".$_GET['email']);
}
?>

<nav class="box2">
        <div class="container">
            <div>
            <h1 style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: black">Delete Task: <b><u><?php echo $tasklist[$row]['task']; ?></b></u></h1>
                    <a>Due Date:</a>
                    <a class="text4"><u> <?php echo $tasklist[$row]['due_date']; ?></a></u>
                    <br>
                    <a>Favourite:</a>
                    <a class="text4"><u> <?php if($tasklist[$row]['favourite'] == null){
                        echo "No";
                    }
                        else{
                            echo "Yes";
                        }
                     ?></a></u>
                    <br>
                   <div class="form-group col-md-3">
                    <form method="post">
                       <input type="submit" name="delete" value="Delete" class="btn btn-danger">
                    </form>
                       <a class="btn btn-primary" href="privateindex.php?email=<?php echo $_GET['email']; ?>">Return</a>
                   </div>
                </form>
            </div>
        </div>
		</main>

	</div>
<?php require("Footer.php");?>