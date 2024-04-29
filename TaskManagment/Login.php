<?php include("navBar.php");
$passwordErr = $idErr = $invalidMesg = "";

if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $pass = $_POST['password'];

    if ($email == null) {
        $idErr = "Email is required";
    }
    elseif ($pass == null) {
        $passwordErr = "Password is required";
    }
    elseif ($email != null && $pass != null) {
        $db = new SQLITE3('C:\xampp\TaskManagementProject\Task_Management.db');
        
        $stmt = $db->prepare('SELECT Email, Password FROM Users WHERE Email=:email AND Password=:password');
        $stmt->bindParam(':email', $email, SQLITE3_TEXT);
        $stmt->bindParam(':password', $pass, SQLITE3_TEXT);
    
        $exists = $stmt->execute();
        
        if($exists == false){
            $invalidMesg = "Invalid email and password!";
        }
        else{
            header('Location:privateindex.php?email=' . $email);
        }
    }
}
?>


<head>
    <style>
        body {
            background-image: url("whiteBkg.jpg");
        }
    </style>
</head>

<body>
    <nav class="box2">
        <div class="container">
            <main role="main" class="pb-3">
                <div>
                    <form method="post">
                        <h1 style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: white">Bank User Login</h1>

                        <div class="form-group logincenter">
                            <label style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: white; position:relative; left:-312px; top:65px"><b>Email</b></label>
                            <input class="form-control" type="text" name="email">
                            <span class="text-danger"><?php echo $idErr; ?></span>
                        </div>
                        <div class="form-group logincenter">
                            <label style="letter-spacing: 2px; font-family: 'Segou UI', Tahoma, Geneva, Verdana, sans-serif; color: white; position:relative; left:-300px; top:65px"><b>Password</b></label>
                            <input class="form-control" type="password" name="password">
                            <span class="text-danger"><?php echo $passwordErr; ?></span>
                        </div>

                        <input type="hidden"><span class="text-danger"><?php echo $invalidMesg; ?></span>

                        <div class="form-group col-md-4 logincenter">
                            <input class="btn btn-light" type="submit" value="Login" name="submit">
                            <a href="Index.php" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                </div>




            </main>
        </div>
    </nav>
</body>
<?php require("footer.php"); ?>