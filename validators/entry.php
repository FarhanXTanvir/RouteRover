<?php
if (isset($_POST['register'])) {
	// Store the form post data into some variables
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	// Array for storing Form Validation errors 
	$errors = array();

	// Checking empty fields
	if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
		array_push($errors, "All fields are required");
	}
	// Validating email syntax
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Email is not valid");
	}
	// Validating password rules
	if (empty($password)) {
		$password_err = "Please enter a password.";
	} elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$!%*?&])[A-Za-z\d@#$!%*?&]{8,}$/", $password)) {
		array_push($errors, "Please enter a valid password. Must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@$!%*?&).");
	} else {
		// Hashing password for data security
		$password_hash = password_hash($password, PASSWORD_DEFAULT);
	}

	//Validating Confirmation password
	if ($password !== $cpassword) {
		array_push($errors, "Confirmation Password does not match");
	}

	require_once 'connect.php';
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($con, $sql);

	// Checking if same username already exists
	$userCount = mysqli_num_rows($result);
	if ($userCount > 0) {
		array_push($errors, "Username already exists!");
	}
	// If there are any errors print them one by one
	if (count($errors) > 0) {
		//  $error contains each error message from $errors
		foreach ($errors as $error) {
			echo "
			<div class='error'>
				<span class='close'> x </span> $error
			</div>";
		}
	}
	// If there is no error then insert the data into database or add new user in DB
	else {
		$sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

		// Initializing statement 
		$stmt = mysqli_stmt_init($con);

		// Preparing statement
		$preparestmt = mysqli_stmt_prepare($stmt, $sql);

		// If statement is prepared then bind the parameters
		if ($preparestmt) {
			mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password_hash);

			// Execute the statement
			mysqli_stmt_execute($stmt);
			echo "
			<div class='success'>
				<span class='close'> x </span> Registration Successful. You can Login now!
			</div>";
			// Close statement
			mysqli_stmt_close($stmt);
		} else {
			die("Oops! Something went wrong. Please try again later.");
		}
	}
	// Close connection
	mysqli_close($con);
}