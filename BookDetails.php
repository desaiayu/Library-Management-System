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
			
			.size
			{
				color:black;
				font-size:17px;
			}
			
			
        </style>
    </head>
    <body>
        <form action="" method="POST" class="size">
            <div class="container text-center">
                <div class="row">
                    <div class="page-header" >
                       <p style= "font-size:25px;color:white"><b> Book Details</b></p>
                    </div>
                </div>         
                <div class="row">
                    <div class="col-lg-4">
                        <label>Search By: </label>
                        <label class="radio-inline"><input type="radio" name="search" value="Book_Name" <?php if(isset($_POST['search']) and $_POST['search']=='Book_Name'){ ?> checked <?php } ?>>Book</label>
                        <label class="radio-inline"><input type="radio" name="search" value="Author_Name" <?php if(isset($_POST['search']) and $_POST['search']=='Author_Name'){ ?> checked <?php } ?>>Author</label>
                    </div>
                    <div class="col-lg-4">
                        <label>Sort By: </label>
                        <label class="radio-inline"><input type="radio" name="sort" value="Book_Name" <?php if(isset($_POST['sort']) and $_POST['sort']=='Book_Name'){ ?> checked <?php } ?>>Book</label>
                        <label class="radio-inline"><input type="radio" name="sort" value="Author_Name" <?php if(isset($_POST['sort']) and $_POST['sort']=='Author_Name'){ ?> checked <?php } ?>>Author</label>
                        <label class="radio-inline"><input type="radio" name="sort" value="Subject_Code" <?php if(isset($_POST['sort']) and $_POST['sort']=='Subject_Code'){ ?> checked <?php } ?>>Subject Code</label>
                    </div>
                    <div class="col-lg-4">
                        <label>Order By: </label>
                        <label class="radio-inline"><input type="radio" name="order" value="ASC" <?php if(isset($_POST['order']) and $_POST['order']=='ASC'){ ?> checked <?php } ?>>Ascending</label>
                        <label class="radio-inline"><input type="radio" name="order" value="DESC" <?php if(isset($_POST['order']) and $_POST['order']=='DESC'){ ?> checked <?php } ?>>Descending</label>
                    </div>
                </div>     
                <?php
                        if(isset($_POST['search']))
                            $search=$_POST['search'];
                        if(isset($_POST['sort']))
                            $sort=$_POST['sort'];
                        if(isset($_POST['order']))
                            $order=$_POST['order'];    
                        if(isset($_POST['Go']))
                            $what=$_POST['what'];
                ?>
                <div class="row">
                    <div class="col-lg-offset-3 col-lg-4">
                        <input type="text" name="what" class="form-control" placeholder="<?php if(isset($_POST['search'])) echo "Enter ".$search; ?> ">
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn btn-block btn-info" name="Go" value="Search">
                    </div>
                </div>     
                <br>
                <div class="row">
                    <table class="table table-condensed table-striped" style="background:white;">
                        <thead>
                            <th>Book Id</th>
                            <th>Book Name</th>
                            <th>Author Name</th>
                            <th>Subject Code</th>
                            <th>Rack No.</th>
                        </thead>
                        <tbody>
                <?php 
                        if(isset($_POST['search']) and isset($_POST['sort']) and isset($_POST['order']))
                        {
                            $sql="SELECT* from `bdview` where lower(".$search.") LIKE lower('%$what%') ORDER BY ".$sort." ".$order."";
                            $details=$db->query($sql);
                            if($details->num_rows>0)
                            {
                                while($a=$details->fetch_assoc())
                                {
                                    echo "<tr><td>" . $a["Book_Id"]. "</td><td>" . $a["Book_Name"]. "</td><td>" . $a["Author_Name"]. "</td><td>" . $a["Subject_Code"]. "</td><td>" . $a["Rack_No"]. "</td><td>" . $a["Value"]. "</td></tr>";
                                }
                            }
                            else
                            {
                                echo "<tr><td>No Data Available</td></tr";
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

