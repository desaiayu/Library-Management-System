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
            }    
            tr:nth-child(even) 
            {
                color:black;
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
        
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header">
                       <p style= "font-size:25px;color:white"><b>Issue History</b></p>
                    </div>
                </div>    
                <div class="row">
                    <table class="table table-condensed table-striped" style="background:white;">
                        <thead>
                            <th>Book Id</th>
                            <th>Book Name</th>
                            <th>Author Name</th>
                            <th>Date</th>
                            <th>Activity</th>
                        </thead>
                        <tbody style="color:black;">
                <?php 
                        //issue history
                        $sql="SELECT `transaction`.Book_Id, book.Book_Name, author.Author_Name, `transaction`.Trans_Date, `transaction`.Trans_Type from `transaction`, book, author where `transaction`.Book_Id=book.Book_Id and `transaction`.User_Id=".$_SESSION['mem']." and book.Author_Id=author.Author_Id ORDER BY Trans_Date DESC";
                        $hist=$db->query($sql);
                        while($a=$hist->fetch_assoc())
                        {
                            echo "<tr><td>" . $a["Book_Id"]. "</td><td>" . $a["Book_Name"]. "</td><td>" . $a["Author_Name"]. "</td><td>" . $a["Trans_Date"]. "</td><td>" . $a["Trans_Type"]. "</td></tr>";
                        }
                ?>  
                        </tbody>
                    </table>
                <?php    
                    if($_SESSION['grp']!=3)
                    {
                ?>    
                    <div class="col-lg-2">
                        <a href="MemberDetails.php" class="btn btn-block btn-info">Back</a>
                    </div>
                <?php
                    }
                ?>    
                </div>          
            </div>
        </form>    
    </body> 
</html>

