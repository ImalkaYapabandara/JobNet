<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Portal 2</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS: You can use this stylesheet to override any Bootstrap styles and/or apply your own styles -->
    <link href="css/custom.css" rel="stylesheet">

   
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Logo and responsive toggle -->
            <div class="col-sm-3">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-globe"></span> Jobnet.lk</a>
            </div>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse" align="center" id="navbar">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a class="navbar-brand" href="jobnetAdmin.php">Home</a>
                    </li>
                    <li>
                        <a class="navbar-brand" href="#">Vacancy Management</a>
                    </li>
                    <li>
                        <a class="navbar-brand" href="#">Application Handling</a>
                    </li>
                    <li>
                        <a class="navbar-brand" href="#">Self Evaluation</a>
                    </li>
                    <li>
                        <a class="navbar-brand" href="#">Admin updation</a>
                    </li>
					

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	
	<?php #include 'db_con.php';
		$conn=mysqli_connect("localhost","root","","db_vacancies");
		if(!$conn){
		    echo "connection failed".mysqli_connect_error();
		}

$title = $description = $qualifications = $salary = $no = "";
$titleError = $descriptError = $qualiError = $salError = $salValiError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["title"])){
		$titleError = "A job title is required";
	}else{
		$title = func($_POST["title"]);
	}
	
	if (empty($_POST["description"])){
		$descriptError = "A job description is required";
	}else{
		$description = func($_POST["description"]);
	}

	if (empty($_POST["qualifications"])){
		$qualiError = "Minimum qualificatons are required";
	}else{
		$qualifications = func($_POST["qualifications"]);
	}

	if (empty($_POST["salary"])){
		$salError = "A basic salary is required";
	}else{
		if (!preg_match("/[^0-9]*$/",$salary)) {
  			$salError = "Only numbers are allowed"; 
		}
		else{
			$salary = func($_POST["salary"]);
		}
	}
	$sql = "INSERT INTO vacancies (title, description, qualifications, salary)VALUES ('$title', '$description', '$qualifications', '$salary')";
	if (mysqli_query($conn,$sql)){
	}else{
		echo "error";
	}		
}

function func($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<div class="container-fluid">

	<div class="col-sm-3" align="left">
		<?php
			$sql="SELECT * FROM vacancies";
			$query=(mysqli_query($conn,$sql));
			while($row = mysqli_fetch_array($query)) {
		?>
				<button class="btn btn-default"  onclick="location.href='formV.php?no=<?php echo $row['vacancy_id'] ?>'">
		<?php
				echo $row['vacancy_id'].'. '.$row['title'];
    			echo '</button><br/>';
			}

	
		?>
	</div>

		

	  <!-- Right Column--> 
	  <div class="col-sm-6" align="center">
 
			<!--Form--> 
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-log-in"></span> 
						VACANCY MANAGEMENT
					</h3>
				</div>
				<div class="panel-body">
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<input type="text" class="form-control" id="tid" name="title" placeholder="Title">
							<span class="error"><br><?php echo $titleError;?></span>
		  <br><br>
						</div>
						<div class="form-group">
							<textarea name="description" rows="5" cols="40" class="form-control" id="did" name="description" placeholder="Job Description"></textarea>
							<span class="error"><br><?php echo $descriptError;?></span>
		  <br><br>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="qid" name="qualifications" placeholder="Minimum Qualifiacations needed">
							<span class="error"><br><?php echo $qualiError;?></span>
		  <br><br>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="sid" name="salary" placeholder="Basic Salary(Rs.)">
							<span class="error"><br><?php echo $salError;?></span>
		  <br><br>
						</div>
						<button type="submit" class="btn btn-default">SUBMIT</button>
						
					
					</form>
					<?php
					if(isset($_GET['no'])){
	        		$no = $_GET['no'];
					?>

					<button class="btn btn-default"  onclick="location.href='formV.php?accept=<?php echo $no ?>'">UPDATE</button>
					<button class="btn btn-default"  onclick="location.href='formV.php?reject=<?php echo $no ?>'">DELETE</button>

					<?php
						}
					?>

					
				</div>
			</div>

			<?php
	

	if(isset($_GET['accept'])){
        $accept = $_GET['accept'];
		$sqlu = "UPDATE vacancies SET title='$title', description='$description', qualifications='$qualifications', salary='$salary'  WHERE vacancy_id = '$accept'";

		mysqli_query($conn,$sqlu);

        echo "<script>alert('Update Form.'); window.location.href='formV.php'; </script>";
    }



	if(isset($_GET['reject'])){
	        $reject = $_GET['reject'];
	        $sqld= "DELETE FROM vacancies WHERE vacancy_id = $reject";
	        mysqli_query($conn,$sqld);

	        echo "<script>alert('Delete Form.'); window.location.href='formV.php'; </script>";
	}

?>

 


	  </div><!--/Right Column--> 

	</div><!--/container-fluid
	
	
	
    <!-- jQuery -->
    <script src="js/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	
	<!-- IE10 viewport bug workaround -->
	<script src="js/ie10-viewport-bug-workaround.js"></script>
	
	<!-- Placeholder Images -->
	<script src="js/holder.min.js"></script>
	
</body>

</html>
