<?php
	include 'connect.php';
	if (mysqli_connect_errno()) {
		// If there is an error with the connection, stop the script and display the error.
		exit('Failed to connect to MySQL: ' . mysqli_connect_error());
	}
	// Now we check if the data was submitted, isset() function will check if the data exists.
	if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
		// Could not get the data that should have been sent.
		echo 'Please complete the registration form!';
	}
	// Make sure the submitted registration values are not empty.
	elseif (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
		// One or more values are empty.
		echo 'Please complete the registration form';
	}
	elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		echo'Email is not valid!';
	}
	elseif (preg_match('/^[a-z, A-Z, 0-9]+$/', $_POST['username']) == 0) {
		echo'Username is not valid!';
	}
	elseif (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
		echo'Password must be between 5 and 20 characters long!';
	}
	// We need to check if the account with that username exists.
	elseif ($stmt = $con->prepare('SELECT id, password FROM users WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
		$stmt->bind_param('s', $_POST['username']);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the account exists in the database.
		if ($stmt->num_rows > 0) {
			// Username already exists
			echo 'Username exists, please choose another!';
		} else {
			// Username doesn't exists, insert new account
			if ($stmt = $con->prepare('INSERT INTO users (username, password, email, account) VALUES (?, ?, ?)')) {
				// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
				$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
				$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
				$stmt->execute();
				echo 'You have successfully registered! You can now login!
				<a href="login.php"><button>Login</button></a>
				';
			} else {
				// Something is wrong with the SQL statement, so you must check to make sure your users table exists with all three fields.
				echo 'Could not prepare statement!';
			}
		}
		$stmt->close();
	} else {
		// Something is wrong with the SQL statement, so you must check to make sure your users table exists with all 3 fields.
		echo 'Could not prepare statement!';
	}
	$con->close();
?>