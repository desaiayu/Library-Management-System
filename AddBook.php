<?php
    session_start();
    include "LibrarianNavBar.php";
    include "Connection.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Book</title>
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
				.error {
			  padding-left: 13px;
			  padding-bottom: 2px;
			  font-weight: bold;
			  color:red;
			  font-size:13px;
			}
        </style>
    </head>
    <body>
	
        
       <?php 
        if(isset($_POST['AddBook']))
        {
			$nameErr=$name=$scErr=$rnErr =$anErr=$aeErr="";
			function test_input($data) {
					  $data = trim($data);
					  $data = stripslashes($data);
					  $data = htmlspecialchars($data);
					  return $data;
					}
            $warning=0;
            $sql="SELECT * from book where Book_Name='".$_POST['Book_name']."'"; 
            $res=$db->query($sql);
            if($res->num_rows>0) 
            {
                $warning=1;
            }
			else if(empty($_POST["Book_name"]) || empty($_POST["Subject_code"]) || empty($_POST["Rack_no"]) || empty($_POST["Author_name"]) || empty($_POST["Author_exp"])) {
				$warning=2;
			 }
			else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["Book_name"])){
				 $warning=3;
				}
			else if (!preg_match("/^[a-zA-Z ]*$/", $_POST["Author_name"])){
				 $warning=3;
				}		
		
            else
            {	
                $warning=0;
                $sql="SELECT Author_Id from author where Author_Name='".$_POST['Author_name']."'";
                $res=$db->query($sql);
                if($res->num_rows==0)
                {
                    $db->query("INSERT into `author`(Author_Name,Experience) VALUES('".$_POST['Author_name']."', ".$_POST['Author_exp'].")");
                    $result=$db->query("SELECT MAX(`Author_Id`) from `author`");
                    $array=mysqli_fetch_array($result);
                    $sql="INSERT INTO `book`(Book_Name,Subject_Code,Rack_No,Author_Id) VALUES('".$_POST['Book_name']."', '".$_POST['Subject_code']."', ".$_POST['Rack_no'].", ".$array[0].")";
                    $db->query($sql);
                    $result=$db->query("SELECT MAX(`Book_Id`) from `book`");
                    $array=mysqli_fetch_array($result);
                    $sql = "INSERT INTO `transaction`(Quantity, Trans_Date, Book_Id, User_Id, Trans_Type, Fine) VALUES( 1, now(), " . $array[0]. ", ".$_SESSION['uid'].", 'Purchase', 0)"; //change user_id to session variable
                    $db->query($sql);

                }
                else
                {
                    $array=mysqli_fetch_array($res);
                    $sql="INSERT INTO `book`(Book_Name,Subject_Code,Rack_No,Author_Id) VALUES('".$_POST['Book_name']."', '".$_POST['Subject_code']."', ".$_POST['Rack_no'].", ".$array[0].")";
                    $db->query($sql);
                    $result=$db->query("SELECT MAX(`Book_Id`) from `book`");
                    $array=mysqli_fetch_array($result);
                    $sql = "INSERT INTO `transaction`(Quantity, Trans_Date, Book_Id, User_Id, Trans_Type, Fine) VALUES( 1, now(), " . $array[0]. ", 9, 'Purchase', 0)"; //change user_id to session variable
                    $db->query($sql);
                }  
						
    ?>
		
			
    <script type="text/javascript">
    alert("Book added successfully");
    </script> 
    <?php
                //header("Location: AddBook.php");
            }
        }
    ?>
</script>
     <form action="" method="POST">
        <div class="container text-center">
			<div class="row">  
				<div class="page-header">
					<p style= "font-size:28px;color:white"><b>Add Book</b></p>	
				</div>
			</div>	
                   
                <div class="col-lg-offset-4 col-lg-4"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
							
								<input type="text" name="Book_name" class="form-control" placeholder="Enter Name">
								<br>
								<input type="text" name="Subject_code" class="form-control" placeholder="Enter Subject Code">
								<br>
								<input type="number" name="Rack_no" class="form-control" placeholder="Enter Rack No">
								<br>
								<input type="text" name="Author_name" class="form-control" placeholder="Enter Author Name">
								<br>
								<input type="number" name="Author_exp" class="form-control" placeholder="Enter Author Experience">
								<br>
								<span class="error" class="help-block"> 
									<?php 
										if(isset($_POST['AddBook']))
										{
											if($warning==1) echo "Book already exists. <br>";
											if($warning==2) echo "Required";
											if($warning==3) echo "Only letters and space allowed in name. <br>";
										}   
									?> 
								</span>
								<input type="submit" class="btn btn-block btn-info" name="AddBook" value="Add Book">
							</div>
                        </div>    
                    </div>
               </div>
             
    </form>    
    </body> 
</html>

