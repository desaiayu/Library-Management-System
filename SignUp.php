<?php
    include "Connection.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up</title>
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
<body>

    <?php 
        if(isset($_POST['SignUp']))
        {
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
			else if($_POST['Password']!=$_POST['CPassword'])
			{
				$warning=3;
			}
			else if(empty($_POST["Name"]) ||	empty($_POST["Department"]) || empty($_POST["PhNo"]) || empty($_POST["Id"]) || empty($_POST["Password"]))
			{
				$warning=6;
			}			
			else if (!preg_match("/^[a-zA-Z]*$/", $_POST["Name"])){
				 $warning=4;
				}
			/*else if (!preg_match("/^[a-zA-Z]*$]/", $_POST["Department"])){
				 $warning=7;
				}*/
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
    alert("Account created successfully");
    </script> 
    <?php
                header("Location: index.php");
            }
        }
    ?>

    <form action="" method="POST" id="signup">
        <div class="container-fluid text-center">                    
            <div class="row">
                <h1>Welcome to Library</h1>          
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Sign Up</h3>
                            <input type="number" name="Id" class="form-control" placeholder="Enter Unique ID">
                            <br>
                            <input type="text" name="Name" class="form-control" placeholder="Enter Name">
                            <br>
                            <input type="number" name="PhNo" class="form-control" placeholder="Enter Phone Number">
                            <br>
                            <input type="text" name="Department" class="form-control" placeholder="Enter Department">
                            <br>
                            <input type="password" name="Password" class="form-control" placeholder="Enter Password">
                            <br>
                            <input type="password" name="CPassword" class="form-control" placeholder="Confirm Password">
                            <br>
                            <span class="error" class="help-block"> 
                                <?php 
                                    if(isset($_POST['SignUp']))
                                    {
                                        if($warning==1) echo "UID already exists. <br>";
                                        if($warning==2) echo "Phone Number already exists. <br>";
										if($warning==3) echo "Passwords do not match. <br>";
										if($warning==4) echo "Only letters and space in name. <br>";
										if($warning==5) echo "Only 10 digit number allowed. <br>";
										if($warning==6) echo "all fields Required. <br>";
										//if($warning==7) echo "Only letters and space in department. <br>";
                                    }   
                                ?> 
                            </span>
                            <input type="submit" class="btn btn-block btn-info" name="SignUp" value="Sign Up">
                        </div>    
                    </div>
                </div>    
            </div>
        </div>    
    </form>
</body>
</html>