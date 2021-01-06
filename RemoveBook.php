<?php
    session_start();
    include "LibrarianNavBar.php";
    include "Connection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Remove Book</title>
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
        if(isset($_POST['RemoveBook']))
        {
            $warning=0;
            $sql="SELECT * from book where Book_Id=".$_POST['Book_id'].""; 
            $res=$db->query($sql);
            if($res->num_rows==0) 
            {
                $warning=1;
            }
            else
            {
                $warning=0;    
                $sql="SELECT SUM(Quantity) from `transaction` where Book_Id=".$_POST['Book_id']."";
                $res1=$db->query($sql);
                $sum=$res1->fetch_assoc();
				if($sum["SUM(Quantity)"]!=1)
                    $warning=2;
                else
                {    
                    $sql="DELETE FROM `transaction` where Book_Id=".$_POST['Book_id']."";  
                    $res=$db->query($sql);
                    $sql="DELETE FROM `book` where Book_Id=".$_POST['Book_id']."";  
                    $res=$db->query($sql);
                
    ?>
    <script type="text/javascript">
    alert("Book removed successfully");
    </script> 
    <?php
                }
            }    
        }
    ?>


     <form action="" method="POST">
        <div class="container text-center">                    
            <div class="row">
                    <div class="page-header">
                       <p style= "font-size:28px;color:white"><b> Remove Book</b></p>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <input type="number" name=" Book_id" class="form-control" placeholder="Enter Book ID">
                            <br>
							<span class="error">
                                <?php 
                                    if(isset($_POST['RemoveBook']))
                                    {
                                        if($warning==1) echo "Book doesn't exist. <br>";
                                        if($warning==2) echo "Book is not in the library. <br>";
                                    }   
                                ?> 
                            </span>
                            <input type="submit" class="btn btn-block btn-info" name="RemoveBook" value="Remove Book">
                        </div>    
                    </div>
                </div>    
            </div>
        </div>    
    </form>    
    </body> 