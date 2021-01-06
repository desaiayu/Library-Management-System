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
			.error {
				  padding-left: 16px;
				  padding-bottom: 2px;
				  font-weight: bold;
				  color: red;
				  font-size:13px;
			}
            body
            {
                background-image:url("https://i.pinimg.com/originals/4a/d3/1e/4ad31e581fea06529ca8997f583b87be.jpg");
                background-repeat:no-repeat;
                background-position:center;
                background-attachment:fixed;
                background-size:cover;
                color:white;
            }  
				.size
			{
				color:black;
				font-size:17px;
				font-weight:bold;
			}
        </style>
    </head>
    <body>
        
        <?php
			
            //getting details
            $id=$_SESSION['mem'];
            $sql="SELECT* from users where User_Id=".$id."";
            $res=$db->query($sql);
            $row = $res->fetch_assoc();
            if($_SESSION['uid']==$id)
            {
                switch($_SESSION['grp'])
                {
                    case 1: $sql="SELECT Lib_Salary as extra from librarian where Lib_Id=".$_SESSION['uid']."";
                            break;
                    case 2: $sql="SELECT Staff_Salary as extra from staff where Staff_Id=".$_SESSION['uid']."";
                            break;
                    case 3: $sql="SELECT Mem_Dept as extra from member where Mem_Id=".$_SESSION['uid']."";
                            break;            
                }
            }
            else
            {
                $sql="SELECT Mem_Dept as extra from member where Mem_Id=".$id."";
            }
            $res1=$db->query($sql);
            $row1 = $res1->fetch_assoc();
            $extra=$row1["extra"];
            if(isset($_POST['Update']))
            {
                $name=$_POST['name'];
                $phno=$_POST['phno'];
                $row["User_Name"]=$name;
                $row["User_PhNo"]=$phno;
                $sql="UPDATE users set User_Name='$name' where User_Id=".$id."";
                $db->query($sql);
                $sql="UPDATE users set User_PhNo='$phno' where User_Id=".$id."";
                $db->query($sql);
				if (!preg_match("/^[a-zA-Z]*$/", $_POST["name"])){
				 $warning=1;
				}
				else if (!preg_match("/([0-9]){10}/", $_POST["phno"]))
				{
					$warning=2;
				}
            }
			
        ?>
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                        <p style= "font-size:25px;color:white"><b>Update Details</b></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-offset-1 col-lg-2">
                        <div class="form-group">
                            <label>UID</label>
                            <input type="number" class="form-control" value="<?= $id ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" value="<?= $row["User_Name"] ?>" name="name" <?php if(!(isset($_POST['Update']))){ ?>readonly="readonly" <?php } ?>>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" value="<?= $row["User_PhNo"] ?>" name="phno" <?php if(!(isset($_POST['Update']))){ ?>readonly="readonly" <?php } ?>>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label><?php if($_SESSION['uid']==$id and ($_SESSION['grp']==1 or $_SESSION['grp']==2)){ echo "Salary"; } else{ echo "Department"; } ?></label>
                            <input type="text" class="form-control" value="<?= $extra ?>" readonly="readonly">
                        </div>
                    </div>
                </div>
				<span class="error">
				<?php
					if(isset($_POST['Update']))
                       {
                           if($warning==1) echo "Only letters and space in name. <br>";
                           if($warning==2) echo "Phone Number should be 10 digit.  <br>";
					   }   
				?>
				</span>
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" value="Update" name="Update">
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" value="Back" name="Back">
                    </div>
                </div>        
            </div>
        </form>    
    </body> 
</html>
