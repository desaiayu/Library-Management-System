<?php
session_start();
    include "LibrarianNavBar.php";
include "Connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <title>Add User</title>
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
			.error {
			  padding-left: 13px;
			  padding-bottom: 2px;
			  font-weight: bold;
			  color:red;
			  font-size:14px;
			}
        </style>
    </head>
<body>

    <?php 
        if(isset($_POST['AddUser']))
        {
			$nameErr=$name=$scErr=$rnErr =$anErr=$aeErr="";
			function test_input($data) {
					  $data = trim($data);
					  $data = stripslashes($data);
					  $data = htmlspecialchars($data);
					  return $data;
					}
            $warning=0;
            $sql="SELECT* from users where User_Id=$_POST[Id]";
            $res=$db->query($sql);
            $sql="SELECT* from users where User_PhNo='$_POST[PhNo]'";
            $res1=$db->query($sql);
			
            if($res->num_rows>0) 
            {
                $warning=1;
            }
            else if($res1->num_rows>0)
            {
                $warning=2;
            }
			else if(empty($_POST["Name"]) ||	empty($_POST["Department"]) || empty($_POST["PhNo"]) || empty($_POST["Id"]) || empty($_POST["Password"]))
			{
				$warning=4;
			}
			else if (!preg_match("/^[a-zA-Z]*$/", $_POST["Name"])){
				 $warning=3;
				}
			else if (!preg_match("/^[a-zA-Z]*$/", $_POST["Department"])){
				 $warning=6;
				}
			else if (!preg_match("/([0-9]){10}/", $_POST["PhNo"]))
				{
					$warning=5;
				}
			
            else
            {
                $warning=0;
                $sql="INSERT INTO `users` VALUES($_POST[Id], '$_POST[Name]', '$_POST[Password]', '$_POST[PhNo]', 3)";
                $db->query($sql);   
                $sql="INSERT INTO `member` VALUES($_POST[Id], '$_POST[Department]')";
                $db->query($sql);      
    ?>
    <script type="text/javascript">
    alert("User added successfully");
    </script> 
    <?php
               // header("Location: index.php");
            }
        }
    ?>

    <form action="" method="POST">
        <div class="container text-center">                    
            <div class="row">
                <div class="page-header">
                   		<p style= "font-size:28px;color:white"><b>Add Member</b></p>	
                </div>
            </div>
            <div class="row">          
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                           
                            <input type="number" name="Id" class="form-control" placeholder="Enter Unique ID">
                            <br>
                            <input type="text" name="Name" class="form-control" placeholder="Enter Name">
                            <br>
                            <input type="text" name="PhNo" class="form-control" placeholder="Enter Phone Number">
                            <br>
                            <input type="text" name="Department" class="form-control" placeholder="Enter Department">
                            <br>
                            <input type="password" name="Password" class="form-control" placeholder="Enter Password">
                            <br>	
                            <span class="error" class="help-block"> 
                                <?php 
                                    if(isset($_POST['AddUser']))
                                    {
                                        if($warning==1) echo "UID already exists. <br>";
                                        if($warning==2) echo "Phone Number already exists. <br>";
										if($warning==4) echo "All fields Required";
										if($warning==3) echo "Only letters and space allowed in Name. <br>";
										if($warning==5) echo "10 Digit number required <br>";
										if($warning==6) echo "Only letters and space allowed in Department. <br>";

                                    }   
                                ?> 
                            </span>
                            <input type="submit" class="btn btn-block btn-info" name="AddUser" value="Add User">
                        </div>    
                    </div>
                </div>    
            </div>
        </div>    
    </form>
</body>
</html>