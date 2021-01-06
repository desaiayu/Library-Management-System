<?php
    session_start();
    if(isset($_POST['Back']))
        header("Location: ".$_SESSION['loc']);
    if($_SESSION['grp']==1)
        include "LibrarianNavBar.php";
    if($_SESSION['grp']==2)
        include "StaffNavBar.php";
    if($_SESSION['grp']==3)
        include "MemberNavBar.php";    
    include "Connection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Library Management System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            body
            {
                background-image:url("https://i.pinimg.com/originals/4a/d3/1e/4ad31e581fea06529ca8997f583b87be.jpg");
                background-repeat:no-repeat;
                background-position:center;
                background-attachment:fixed;
                background-size:cover;
                color:white;
            } 
			#cp .error {
			  padding-left: 13px;
			  padding-bottom: 2px;
			  font-weight: bold;
			  color:red;
			  font-size:20px;
			}
        </style>
    </head>
    <body>
        <?php 
            if(isset($_POST['Change']))
            {
                $warning=0;
                $old=$_POST["old"];
                $new=$_POST["new"];
                $cnew=$_POST["cnew"];
                if($_SESSION['pass']!=$old)
                    $warning=1;
                else
                {
                    if($new!=$cnew)
                        $warning=2;
                    else
                    {
                        $warning=0;
                        $sql="UPDATE users set User_Password='$new' where User_Id=".$_SESSION['uid']."";
                        $db->query($sql);
                        $_SESSION['pass']=$new;
                    }
                }
            }
        ?>
        
        <form action="" method="POST" id="cp">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                        <p style= "font-size:25px;color:white"><b> Change Password</b></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-offset-5 col-lg-2">
                        <input type="text" class="form-control" name="old" placeholder="Enter old password">
                    </div>
					<span class="error">
                    <?php
                        if(isset($_POST['Change']))
                        {
                            if($warning==1)
							
                                echo "Old Password not correct. Please try again!";
                        }
                    ?>
					</span>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-5 col-lg-2">
                        <input type="password" class="form-control" name="new" placeholder="Enter new password">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-5 col-lg-2">
                        <input type="password" class="form-control" name="cnew" placeholder="Confirm password">
                    </div>
					<span class="error">
                    <?php
                        if(isset($_POST['Change']))
                        {
                            if($warning==2)
                                echo "Passwords do not match. Please try again!";
                        }
                    ?>
					</span>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" name="Change" value="Change">
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" name="Back" value="Back">
                    </div>
                </div>          
            </div>
        </form>    
    </body> 
</html>

