<?php
    session_start();
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
					font-size:17px;
					font-weight:bold;
					color:black;
				}
        </style>
    </head>
    <body>
        <?php 
            if(isset($_POST['return']))
            {
                $warning=0;
                $book=$_POST['book'];
                $member=$_POST['member'];
                $sql1="SELECT SUM(Quantity) from `transaction` where Book_Id=".$book." and User_Id=".$member."";
                $qua1=$db->query($sql1)->fetch_assoc();
                $sql2="SELECT* from users where User_Id=".$member."";
                $qua2=$db->query($sql2)->num_rows;
                $sql3="SELECT* from book where Book_Id=".$book."";
                $res=$db->query($sql3)->num_rows;
                if($res==0)
                    $warning=1;
                else if($qua2==0)
                    $warning=2;
                else if($qua1["SUM(Quantity)"]!=-1)
                    $warning=3;    
                else
                {
                    $warning=0;
                    $sql1="SELECT Trans_Date from `transaction` where Book_Id=".$book." and User_Id=".$member." and Trans_Type='Issue out' ORDER BY Trans_Date DESC LIMIT 1";
                    $dt=$db->query($sql1)->fetch_assoc();
                    $dt1=date('Y-m-d', strtotime($dt["Trans_Date"].'+ 7 days'));
                    //$dt2=date('Y-m-d', strtotime(($db->query("SELECT CURRENT_DATE()")->fetch_array())[0]));
                    //$dt=$dt1-$dt2;
                    $interval = date_diff(date_create(), date_create($dt1));
                    //var_dump($interval->d);
                    //echo $dt1 . " " . $dt2 . " ";
                    
                    //exit();
                    //$sql1="SELECT days_between($dt1, $dt2) as diff from dual";
                    //$dt=$db->query($sql1)->fetch_assoc();
                    //$dt=$dt["diff"];
                    //echo $dt;
                    $interval->d=($interval->d)*5;
                    $sql="INSERT into `transaction` (Quantity, Trans_Date, Book_ID, User_Id, Trans_Type, Fine) values(1, now(), ".$book.", ".$member.", 'Issue in', ".$interval->d.")";
                    $db->query($sql);
                    ?>
                    <script>
                        alert("Book returned successfully. Collect fine of Rs. <?= $interval->d ?>");
                    </script>    
                    <?php
                }
            }
        ?>
        
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                       <p style= "font-size:25px;color:white"><b> Return Book</b></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-3">
                        <label>Book Id</label>
                        <input type="number"  class="form-control" name="book" placeholder="Enter Book Id">
                    </div>
                    <div class="col-lg-3">
                        <label>Member Id</label>
                        <input type="number" class="form-control" name="member" placeholder="Enter Member Id">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-4">
                        <input type="submit" class="btn btn-block btn-info" name="return" value="Return">
                    </div>
                    <div class="col-lg-4">
                        <?php
                            if(isset($_POST['return']))
                            {
                                if($warning==1) echo "Invalid book id";
                                if($warning==2) echo "Invalid member id";
                                if($warning==3) echo "Book is not issued to this member";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </form>    
    </body> 
</html>

