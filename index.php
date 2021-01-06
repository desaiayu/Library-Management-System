 <?php
        session_start();
        include "Connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Log In</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .error {
			  padding-left: 13px;
			  padding-bottom: 2px;
			  font-weight: bold;
			  color:red;
			  font-size:15px;
			}
</style>

</head>
<body class="bg">

    <?php 
        if(isset($_POST['LogIn']))
        {
            $warning=0;
            $id=$_POST['Id'];
            $pass=$_POST['Password'];    
            $_SESSION['uid']=$id;
            $_SESSION['pass']=$pass;
            $sql="SELECT* from users where User_Id=$id and User_Password='$pass'";
            $res=$db->query($sql);
            if ($res->num_rows == 0) 
                $warning=1;
            else
            {
                $warning=0;
                $sql="SELECT User_Grp from users where User_Id=$id and User_Password='$pass'";
                $res=$db->query($sql);
                $row = $res->fetch_assoc();
                $_SESSION['grp']=$row["User_Grp"];
                if($row["User_Grp"]==1)
                    header('Location: LibrarianHome.php');
                if($row["User_Grp"]==2)
                    header('Location: StaffHome.php');
                if($row["User_Grp"]==3)
                    header('Location: MemberHome.php');           
            }            
        }
    ?>        

    <form action="" method="POST">
        <div class="container-fluid text-center">                    
            <div class="row">
                <h1>Welcome to Library</h1>
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Log In</h3>
                            <br>
                            <input type="number" name="Id" class="form-control" placeholder="Enter Unique ID">
                            <br>
                            <input type="password" name="Password" class="form-control" placeholder="Enter Password">
                            <br>
                            <span class="error" class="help-block"> 
                                <?php 
                                    if(isset($_POST['LogIn']))
                                        if($warning==1) echo "UID or Password incorrect <br>"; 
                                ?> 
                            </span>
                            <input type="submit" class="btn btn-block btn-info" name="LogIn" value="Log In">
                            <br>
                            Dont have an account? <a href="SignUp.php">Sign Up as a member</a>
                        </div>    
                    </div>
                </div>    
            </div>
        </div>    
    </form>

     
</body>
</html>