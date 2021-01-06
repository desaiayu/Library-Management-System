<?php
    session_start();
    include "LibrarianNavBar.php";
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
			.error {
			  padding-left: 13px;
			  padding-bottom: 2px;
			  font-weight: bold;
			  color:red;
			  font-size:17px;
			}
        </style>
    </head>
    <body>
        
       <?php 
        if(isset($_POST['RemoveMember']))
        {
            $warning=0;
            $sql="SELECT * from users where User_Id=".$_POST['Member_id']." and User_Grp=3"; 
            $res=$db->query($sql);
            $sql1="SELECT SUM(Quantity) from `transaction` where User_Id=".$_POST['Member_id']."";
            $res1=$db->query($sql1);
            echo $db->error;
            if($res->num_rows==0) 
            {
                $warning=1;
                echo "1";
            }
            else if($res1->num_rows>0)
            {
                $sum=$res1->fetch_assoc();
				if($sum["SUM(Quantity)"]!=0)
                    $warning=2;
                else
                {
                    $warning=0;
                    $db->query("CREATE TRIGGER `memdel1` AFTER DELETE ON `member` FOR EACH ROW DELETE from `transaction` where User_Id=".$_POST['Member_id']."");
                    $db->query("DELETE FROM member where Mem_Id=".$_POST['Member_id']."");
                    //$db->query("DELETE FROM `transaction` where User_Id=".$_POST['Member_id']."");
                    $db->query("DELETE FROM users where User_Id=".$_POST['Member_id']."");
                    ?>
                    <script type="text/javascript">
                    alert("Member removed successfully");
                    </script>    
                    <?php
                }
            }
            else
            {
                $warning=0;
                $db->query("DELETE FROM member where Mem_Id=".$_POST['Member_id']."");
                $db->query("DELETE FROM `transaction` where User_Id=".$_POST['Member_id']."");
                $db->query("DELETE FROM users where User_Id=".$_POST['Member_id']."");
    ?>
    <script type="text/javascript">
    alert("Member removed successfully");
    </script> 
    <?php
                //header("Location: addbooks.php");
            }
        }
    ?>


     <form action="" method="POST">
        <div class="container text-center">                    
            <div class="row">
				<div class="page-header">
                  <p style= "font-size:28px;color:white"><b>Remove Member</b></p>  
   			   </div>
			 </div>  
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <input type="number" name="Member_id" class="form-control" placeholder="Enter Member ID">
                            <br>
								<span class="error">
                                <?php 
                                    if(isset($_POST['RemoveMember']))
                                    {
                                        if($warning==1) echo "Member doesn't exist. <br>";
										if($warning==2) echo "Member has some book. <br>";
                                    }   
                                ?> 
                            </span>
                            <input type="submit" class="btn btn-block btn-info" name="RemoveMember" value="Remove Member">
                        </div>    
                    </div>   
            </div>
        </div>    
    </form>    
    </body> 
