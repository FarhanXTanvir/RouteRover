<?php 
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	$errors = array();

	// Checking empty fields
	if(empty($username) || empty($email) || empty($password) || empty($cpassword)) {
		array_push($errors, "All fields are required");
	}
	//Validating email syntax
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		array_push($errors, "Email is not valid");
	}
	//Validating password rules
	if(strlen($password) < 8) {
		array_push($errors,"Password must be at least 8 characters long");
	}
	//Validating matching passwords
	if ($password !== $cpassword){
		array_push($errors,"Password does not match");
	}

	require_once 'connect.php';
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($con, $sql);
	$rowCount = mysqli_num_rows($result);
	if ($rowCount>0) {
		array_push($errors,"Username already exists!");
	}
	if(count($errors)>0){
		foreach($errors as $error){
			echo "<div class='test alert alert-danger alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> $error
			</div>";
		}
	}
	else{
		$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($con);
		$preparestmt = mysqli_stmt_prepare($stmt, $sql);
		if($preparestmt){
			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);
			mysqli_stmt_execute($stmt);
			echo "<div class='alert alert-success alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'> &times;</a> Registration Successful! You can now login.
			</div>";
		}
		else{
			die("Something went wrong");
		}
	}
}
?>
                