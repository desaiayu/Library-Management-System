<?php
    session_start();
    $_SESSION['loc']="MyProfile.php";
    if(isset($_POST['ChPass']))
        header("location: ChangePassword.php");
    if(isset($_POST['Update']))
        header("location: UpdateDetails.php");
    if($_SESSION['grp']==1)
        include "LibrarianNavBar.php";
    if($_SESSION['grp']==2)
        include "StaffNavBar.php";
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
                
            } 
				.size
				{
				color:black;
				font-size: 17px;
				font-weight:bold;
				}
			
        </style>
    </head>
    <body>
        <?php 
            $_SESSION['mem']=$_SESSION['uid'];
            $sql="SELECT* from users where User_Id=".$_SESSION['uid']."";
            $row=$db->query($sql);
            $row=$row->fetch_assoc();
            if($_SESSION['grp']==1)
                $sql="SELECT Lib_Salary as salary from librarian where Lib_Id=".$_SESSION['uid']."";
            if($_SESSION['grp']==2)
                $sql="SELECT Staff_Salary as salary from staff where Staff_Id=".$_SESSION['uid']."";
            $sal=$db->query($sql)->fetch_assoc();
            $sal=$sal["salary"];
        ?>
        
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                        <p style= "font-size:25px;color:white"><b>My Profile</b></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>UID</label>
                            <input type="text" class="form-control" value="<?= $_SESSION['uid'] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="<?= $row["User_Name"] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" value="<?= $row["User_PhNo"] ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" class="form-control" value="<?= $sal ?>" readonly="readonly">
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-lg-offset col-lg-3">
                        <input type="submit" class="btn btn-block btn-info" value="Update Details" name="Update">
                    </div>
                    <div class="col-lg-3">
                        <input type="submit" class="btn btn-block btn-info" value="Change Password" name="ChPass">
                    </div>
                </div>
            </div>
        </form>    
    </body> 
</html>

