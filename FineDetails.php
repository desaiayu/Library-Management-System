<?php
    session_start();
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
                color:black;
            }    
            tr:nth-child(even) 
            {
                color:white;
            }
			.size
				{
					font-size:18px;
					font-weight:bold;
					color:black;
				}
        </style>
    </head>
    <body>
        <?php 
            if(isset($_POST['Calc']))
            {
                $start=$_POST['start'];
                $end=$_POST['end'];
                $sql="SELECT SUM(Fine) from `transaction` where Trans_Date BETWEEN '$start' and '$end'";
                $total=0;
                $total=$db->query($sql)->fetch_assoc();
            }
        ?>
        
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                        <p style= "font-size:25px;color:white"><b> Fine Details</b></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-2">
                        <input type="text" onfocus="(this.type='date')" class="form-control" name="start" placeholder="Enter start date">
                    </div>
                    <div class="col-lg-2">
                        <input type="text" onfocus="(this.type='date')" class="form-control" name="end" placeholder="Enter end date">
                    </div>
                    <div class="col-lg-2">
                        <label><input type="checkbox" name="check">Group by User Id</label> 
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-offset-4 col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" name="Calc" value="Calculate">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-3">
                        <?php if(isset($_POST['Calc'])) echo "Total fine is Rs." . $total['SUM(Fine)']; ?>
                    </div>
                </div>        
                <br>  
                <div class="row">
                    <table class="table table-condensed table-striped" style="background:white;">
                        <thead>
                            <th>Book Id</th>
                            <th>User Id</th>
                            <th>Date</th>
                            <th>Fine</th>
                        </thead>
                        <tbody style="color:black;">
                <?php 
                        if(isset($_POST['Calc']))
                        {
                            $check="";
                            if(isset($_POST['check']))    
                            {
                                $check=$_POST['check'];
                                $sql="SELECT SUM(Fine) as Fine, User_Id from `transaction` where Trans_Type='Issue in' and Trans_Date BETWEEN '$start' and '$end' GROUP BY User_Id";
                                $details=$db->query($sql);
                                while($a=$details->fetch_assoc())
                                {
                                    echo "<tr><td></td><td>" . $a["User_Id"]. "</td><td></td><td>" . $a["Fine"]. "</td></tr>";
                                }
                            }
                            else
                            {
                                $sql="SELECT* from `transaction` where Trans_Type='Issue in' and Trans_Date BETWEEN '$start' and '$end'";
                                $details=$db->query($sql);
                                while($a=$details->fetch_assoc())
                                {
                                    echo "<tr><td>" . $a["Book_Id"]. "</td><td>" . $a["User_Id"]. "</td><td>" . $a["Trans_Date"]. "</td><td>" . $a["Fine"]. "</td></tr>";
                                }
                            }   
                        }       
                ?>  
                        </tbody>
                    </table>    
                </div>
            </div>
        </form>    
    </body> 
</html>

