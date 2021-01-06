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
				.error {
				  padding-left: 16px;
				  padding-bottom: 2px;
				  font-weight: bold;
				  color: red;
				  font-size:small;
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
            if(isset($_POST['issue']))
            {
                $warning=0;
                $book=$_POST['book'];
                $member=$_POST['member'];
                $sql1="SELECT SUM(Quantity) from `transaction` where Book_Id=".$book."";
                $qua1=$db->query($sql1)->fetch_assoc();
                $sql2="SELECT SUM(Quantity) from `transaction` where User_Id=".$member."";
                $qua2=$db->query($sql2)->fetch_assoc();
                $sql3="SELECT* from book where Book_Id=".$book."";
                $res=$db->query($sql3)->num_rows;
                $sql4="SELECT* from users where User_Id=".$member."";
                $res1=$db->query($sql4)->num_rows;
				if($qua1["SUM(Quantity)"]!=1 or $res==0)
                    $warning=1;
                else if($qua2["SUM(Quantity)"]==-3)
                    $warning=2;
				else if($res1==0)
					$warning=3;
                else
                {
                    $warning=0;
                    $sql="INSERT into `transaction` (Quantity, Trans_Date, Book_ID, User_Id, Trans_Type) values(-1, now(), ".$book.", ".$member.", 'Issue out')";
                    $db->query($sql);
                    $dt=date('Y-m-d', strtotime('7 days'));
                    ?>
                    <script>
                        alert("Book issued successfully. Please return by <?= $dt ?>");
                    </script>    
                    <?php
                }
            }
        ?>
        
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                       <p style= "font-size:25px;color:white"><b> Issue Book</b></p>
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
                    <div class="col-lg-offset-4 col-lg-3">
                        <input type="submit" class="btn btn-block btn-info" name="issue" value="Issue">
                    </div>
                    <div class="col-lg-4">
					<span class="error">
                        <?php
                            if(isset($_POST['issue']))
                            {
                                if($warning==1) echo "Book is not available in the library";
                                if($warning==2) echo "Issue limit reached";
								if($warning==3) echo "Member not found";
                            }
                        ?>
						</span>
                    </div>
                </div>
            </div>
        </form>    
    </body> 
</html>

