<?php include "db.php"; ?>
<?php session_start(); ?>
<?php include "../admin/admin_functions.php"; ?>

<?php

# If the submit button named 'login' was clicked
if(isset($_POST['login'])){

  # create an empty array to hold any form submission error
  $form_errors = array();

  // Validate the email address:
  if(empty($_POST['username'])){
    $form_errors[] = 'Empty username input field detected - Please go back and enter a username.';
  } else {
    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
  };

  // Validate the password:
  if(empty($_POST['password'])){
    $form_errors[] = 'Empty password input field detected - Please go back and enter a password.';
  } else {
    $username = mysqli_real_escape_string($connection, trim($_POST['password']));
  };

  if(empty($form_errors)){ // If there were no form errors
    # Log the user in
    loginUser($username, $password);
  } else { // We had form errors - inform user what happened
    # show form submission errors
    showLoginFormErrors($form_errors);
  }; // End of if(empty($form_errors)) IF
}; // End of main if(isset) IF


?>
