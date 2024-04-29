<?php
require('UserNav.php');
include('TaskListSQL.php'); //fetch the tasks from an ID
include('userSQL.php'); //transform email into ID
include_once('taskmanagerSQL.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1 class="pagefont"><u>Home Page</u></h1>

            <?php if(isset($_GET['deleted'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="float:right">
                <strong>The task has been deleted</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <?php endif; ?>
                </div>

    <h2 class="greetingUser"><?php echo $_GET['email'] ?></h2>
    <nav class="box3">
        <div class="column1">
            <ul style="padding-top:80px">
                <li><a class="sideBarfont documentfont" href="AddTask.php?email=<?php echo $_GET['email']; ?>"><b>Add Task</b></a></li>
            </ul>
            <nav class="box1">
                <table class="table table-striped"> <!--table header titles-->
                    <thead class="table-dark">
                        <td>Task</td>
                        <td>Due Date</td>
                        <td>Days Remaining</td>
                        <td></td>
                    </thead>

                <?php 
                $user = user();
                $tasklist = getTasks($user[0]['UserID']);
                date_default_timezone_set("Europe/London");
                
                
                for ($i=0; $i<count($tasklist); $i++): //outputs the rows of tasks with matching user id 
                    $duedate =  new DateTime($tasklist[$i]['due_date']);
                    $current = new DateTime(date("y-m-d"));
                    $difference = $current->diff($duedate);
                ?>
                <tr>
                    <td class="text4"><a href="edittask.php?email=<?php echo $_GET['email']; ?>&task=<?php echo $tasklist[$i]['task']; ?>&olddue=<?php echo $tasklist[$i]['due_date']; ?>&row=<?php echo $i?>"><?php echo $tasklist[$i]['task']; ?></a></td>
                    <td class="text4"><?php echo $tasklist[$i]['due_date']; ?>
                    <td class="text4"><?php echo $difference->d.' days';?></td> <!--days until date in here-->
                    <td><?php if($tasklist[$i]['favourite'] == "yes"){?><img style="height:40px; width:40px" src="star.png"><?php } ?>
                </tr>
                
                <?php if($user[0]['Role'] == "manager"){ 
                    $managerlist = getTasks($user[0]['Fname']);

                    for ($i=0; $i<count($managerlist); $i++):
                        $due =  new DateTime($managerlist[$i]['due_date']);
                        $diff = $current->diff($due);
                    ?>
                    <tr>
                    <td class="text4"><a href="edittask.php?email=<?php echo $_GET['email']; ?>&task=<?php echo $managerlist[$i]['task']; ?>&row=<?php echo $i?>"><?php echo $managerlist[$i]['task']; ?></a></td>
                    <td class="text4"><?php echo $managerlist[$i]['due_date']; ?></td>
                    <td class="text4"><?php echo $diff->d.' days';?></td> <!--days until date in here-->
                    <td><?php if($managerlist[$i]['favourite'] == "yes"){?><img style="height:40px; width:40px" src="star.png"><?php } ?></td>
                    </tr>
                    <?php endfor; 
                    }?>

                <?php endfor; ?>
            </nav><!--task box-->
            <?php for ($i=0; $i<count($tasklist); $i++):
            if($tasklist[$i]['manager'] == null){

            }
            else{ 
                $Tasks = getmanager(); ?>
                <form method="post">
                    <div class="form-group">
                        <label class="control-label" style="font-weight: bold;">Filter by Name : </label>
                            <select type="text" style="width:80px;" name="filtermanager" class="form-control">
                            <option>ALL</option>
                            <?php for ($i=0; $i<count($tasklist); $i++): ?>   
                            <option><?php echo $tasklist[$i]['manager']; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" value="filter" class="btn btn-primary">Filter</button>      
                    </div>
                </form>
        <?php }
            ?>
            <?php endfor; ?>
        </div>
    </nav>
</body>
</html>
