<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

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
<div class="container" >
	<div class="navidiv" align="left">
		<?php
			$sql="SELECT * FROM vacancies";
			$query=(mysqli_query($conn,$sql));
			while($row = mysqli_fetch_array($query)) {
		?>
				<button class="but"  onclick="location.href='vacancy.php?no=<?php echo $row['vacancy_id'] ?>'">
		<?php
				echo $row['vacancy_id'].') '.$row['title'];
    			echo '</button><br/>';
			}

	
		?>
	</div>
	<div class="display" align="center">
		<h2>VACANCY MANAGEMENT</h2>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
		  *Job title:<input type="text" name="title">
		  <span class="error"><br><?php echo $titleError;?></span>
		  <br><br>
		  *Job description:<textarea name="description" rows="5" cols="40"></textarea>
		  <span class="error"><br><?php echo $descriptError;?></span>
		  <br><br>
		  *Minimum qualifications needed:<input type="text" name="qualifications">
		  <span class="error"><br><?php echo $qualiError;?></span>
		  <br><br>
		  *Basic salary (Rs.):<input type="text" name="salary">
		  <span class="error"><br><?php echo $salError;?></span>
		  <br><br>
		  <input type="submit" name="submit" value="Submit">  
		</form>

		<?php
			if(isset($_GET['no'])){
	        	$no = $_GET['no'];
		?>

		<button class="rep"  onclick="location.href='vacancy.php?accept=<?php echo $no ?>'">Update</button>
		<button class="rej"  onclick="location.href='vacancy.php?reject=<?php echo $no ?>'">Delete</button>

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

        echo "<script>alert('Update Form.'); window.location.href='vacancy.php'; </script>";
    }



	if(isset($_GET['reject'])){
	        $reject = $_GET['reject'];
	        $sqld= "DELETE FROM vacancies WHERE vacancy_id = $reject";
	        mysqli_query($conn,$sqld);

	        echo "<script>alert('Delete Form.'); window.location.href='vacancy.php'; </script>";
	}

?>


</body>
</html>