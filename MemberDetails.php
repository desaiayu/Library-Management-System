<?php
    session_start();
    $_SESSION['loc']="MemberDetails.php";
    if(isset($_POST['ChPass']))
        header("location: ChangePassword.php");
    if(isset($_POST['Update']))
        header("location: UpdateDetails.php");
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
                
            }  
			.size
			{
                color:black;
				font-size:17px;
			}
        </style>
    </head>
    <body>
        
        <?php
            //getting details
            $warning=0;
            if(isset($_POST['Search']) or $_SESSION['grp']==3)
            {
                if($_SESSION['grp']!=3)
                {
                    $id=$_POST['Id'];
                    $sql="SELECT User_Password from users where User_Id=".$id."";
                    $pass=$db->query($sql)->fetch_assoc();
                    $pass=$pass["User_Password"];
                }
                else    
                {
                    $id=$_SESSION['uid'];
                    $pass=$_SESSION['pass'];
                }
                $_SESSION['mem']=$id;    
                $_SESSION['mempass']=$pass;    
                $sql="SELECT* from member where Mem_Id=$id";
                $res=$db->query($sql);
                if ($res->num_rows == 0) 
                    $warning=1;
                else    
                {
                    $warning=0;
                    $row = $res->fetch_assoc();
                    $sql="SELECT* from users where User_Id=$id";
                    $res1=$db->query($sql);
                    $row1 = $res1->fetch_assoc();
                }   
            }
        ?>
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                       <p style= "font-size:25px;color:white"><b> Member Details</b></p>
                    </div>
                </div>    
                <?php 
                    if($_SESSION['grp']!=3)
                    {
                ?>
                        <div class="row">
                            <div class="col-lg-offset-3 col-lg-3">
                                <input type="text" name="Id" class="form-control" placeholder="Enter Unique ID">
                            </div>
                            <div class="col-lg-3">
                                <input type="submit" class="btn btn-block btn-info" name="Search" value="Get Details">
                            </div>
                            <div class="col-lg-3">
                                <?php 
                                    if(isset($_POST['Search']))
                                        if($warning==1)
                                            echo "Member not found";
                                ?>
                            </div>
                        </div>
                        <br>
                <?php
                    }
                ?>    
                <div class="row">
                    <?php
                        if(isset($_POST['Search']) or $_SESSION['grp']==3 and $warning==0)
                        {
                    ?>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>UID</label>
                                    <input type="text" class="form-control" value="<?= $row["Mem_Id"] ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" value="<?= $row1["User_Name"] ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" value="<?= $row1["User_PhNo"] ?>" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Department</label>
                                    <input type="text" class="form-control" value="<?= $row["Mem_Dept"] ?>" readonly="readonly">
                                </div>
                            </div>
                </div>
                <br>
                <label>Current Issues: </label>
                <div class="row">
                    <table class="table table-condensed table-striped" style="background:white;">
                        <thead>
                            <th>Book Id</th>
                            <th>Book Name</th>
                            <th>Author Name</th>
                            <th>Issue Date</th>
                            <th>Return By</th>
                        </thead>
                        <tbody>
                        <?php
                            $sql="SELECT Book_Id, SUM(Quantity) from `transaction` where User_Id=$id GROUP BY Book_Id";
                            $res=$db->query($sql);
                            if($res->num_rows>0)
                            {
                                while($a=$res->fetch_assoc())
                                {
                                    if($a["SUM(Quantity)"]!=0)
                                    {
                                        $sql1="SELECT Book_Name, Author_Name from `bdview` where Book_Id=".$a["Book_Id"]."";
                                        $b=$db->query($sql1)->fetch_assoc();
                                        $sql2="SELECT Trans_Date from `transaction` where User_Id=$id and Book_Id=".$a["Book_Id"]." and Trans_Type='Issue out' ORDER BY Trans_Date DESC LIMIT 1";
                                        $c=$db->query($sql2)->fetch_assoc();
                                        $dt=date('Y-m-d', strtotime($c["Trans_Date"].'+ 7 days'));
                                        echo "<tr><td>" . $a["Book_Id"]. "</td><td>" . $b["Book_Name"]. "</td><td>" . $b["Author_Name"]. "</td><td>" . $c["Trans_Date"]. "</td><td>" . $dt. "</td></tr>";
                                    }
                                }
                            }
                            else
                            {
                                echo "<tr><td>No Data Available</td></tr";
                            }    
                        ?>
                        </tbody>
                    </table>    
                </div> 
                <div class="row">
                            <br>
                            <div class="col-lg-offset-3 col-lg-2">
                                <input type="submit" class="btn btn-block btn-info" value="Update Details" name="Update">
                            </div>
                            <div class="col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" value="Change Password" name="ChPass" <?php if($_SESSION['grp']!=3){ ?> disabled="disabled" <?php } ?>>
                            </div>
                            <div class="col-lg-2">
                                <a href="IssueHistory.php" class="btn btn-block btn-info">Issue History</a>
                            </div>
                    <?php
                        }
                    ?>
                </div>        
            </div>
        </form>    
    </body> 
</html>


