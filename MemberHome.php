<?php
    session_start();
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
			p{
				font-size: 35px;
				font-type: Italics;
				font-family : Times new roman;
			}
		</style>
    </head>
    <body>
        
        <?php
            $_SESSION['mem']=$_SESSION['uid'];
            $_SESSION['mempass']=$_SESSION['pass'];
        ?>
		<center><p><b>LIBRARY MANAGEMENT SYSTEM</b></p></center>
	<div id="myCarousel" class="carousel slide">
  
	  <ol class="carousel-indicators">
    
	    <li data-target="#myCarousel" data-slide-to="0" class="" contenteditable="false"></li>

            <li data-target="#myCarousel" data-slide-to="1" class="active" contenteditable="false"></li>
    
        <li data-target="#myCarousel" data-slide-to="2" class="" contenteditable="false"></li>

         </ol>

    <div class="carousel-inner">

         <div class="item" style="">

             <img src="https://abaforlawstudents.com/wp-content/uploads/2013/01/lawstudentsudying.jpg" style="width:4500px; height:600px" >


             <div class="carousel-caption">
 
              
            </div>
 
       </div>


        <div class="item active">

            <img src="http://www.benettongroup.com/wp-content/uploads/download.php?file=2015/06/fabrica_event_05_0.jpg " style="width:4500px; height:600px">

            <div class="carousel-caption">


            </div>
 
       </div>
  
      <div class="item" style="">

            <img src="https://www.hendersoncountync.gov/sites/default/files/imageattachments/library/page/4681/20170509_eng_library_dja_012_3.jpg" style="width:4500px; height:600px">

            <div class="carousel-caption">


            </div>
 
       </div>

    </div> 
   

    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
 
       <span class="glyphicon glyphicon-chevron-left"></span>
 </a>



    <a class="right carousel-control" href="#myCarousel" data-slide="next">
 
       <span class="glyphicon glyphicon-chevron-right"></span>
    </a>



</div>




    </body>
</html>

