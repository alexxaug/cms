<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php  include "admin/admin_functions.php"; ?>
 <?php
 foreach($_POST as $field => $value) {
   $_POST[$field] = mysqli_real_escape_string($connection, $value);
 };
 ?>

<?php
  if(isset($_POST['submit'])){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    $error = [
      'username' => '',
      'email' => '',
      'password' => ''
    ];

    if(strlen($username) < 4){
      $error['username'] = 'Username must be longer than 4 characters';
    };

    if($username = ''){
      $error['username'] = 'Username cannot be empty';
    };

    if(usernameExists($username)){
      $error['username'] = 'Username already exists';
    };

    if($email = ''){
      $error['email'] = 'Email cannot be empty';
    };

    if(EmailExists($email)){
      $error['email'] = 'Email already exists, <a href="index.php">Please login</a>';
    };

    if($password = ''){
      $error['password'] = 'Password cannot be empty';
    };

    registerUser($username, $email, $password, $firstname, $lastname);

  };

?>

    <!-- Navigation -->

    <?php  include "includes/navigation.php"; ?>


    <!-- Page Content -->
    <div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Firstname - optional">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Lastname - optional">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>

                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
