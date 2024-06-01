<?php
if (isset($_POST['contact'])) {
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validating Fields
  if (empty($email) || empty($message)) {
    echo "
          <div class='error'>
            <i class='fa-regular fa-times close'></i> All fields are required" . "
          </div>";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo "
          <div class='error'>
            <i class='fa-regular fa-times close'></i> Invalid email format
          </div>";
  } else {
    require_once 'connect.php';
    $sql = "INSERT INTO contact (Email, Message) VALUES (?, ?)";

    // Initializing statement 
    $stmt = mysqli_stmt_init($con);

    // Preparing statement
    $preparestmt = mysqli_stmt_prepare($stmt, $sql);

    // If statement is prepared then bind the parameters
    if ($preparestmt) {
      mysqli_stmt_bind_param($stmt, "ss", $email, $message);

      // Execute the statement
      mysqli_stmt_execute($stmt);

      echo "
            <div class='success'>
              <span class='fa-regular fa-times close'></span> Message sent successfully
            </div>";
    } else {
      echo "
            <div class='error'>
              <i class='fa-regular fa-times close'></i> Error: " . $sql . "<br>" . mysqli_error($con) . "
            </div>";
    }
  }
}