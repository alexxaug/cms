<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php  include "admin/admin_functions.php"; ?>
 <?php
 foreach($_POST as $field => $value) {
   $_POST[$field] = mysqli_real_escape_string($connection, $value);
 };
 ?>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);

    //checking for error in form and storing that message
    $error = [
      'username'=> '',
      'email'=> '',
      'password'=> ''
    ];

    if(strlen($username) < 4){
      $error['username'] = 'Username needs atleast 4 characters.';
    };

    if($username == ''){
      $error['username'] = 'Username cannot be empty.';
    };

    if($email == ''){
      $error['email'] = 'Email cannot be empty.';
    };

    if($password == ''){
      $error['password'] = 'Password cannot be empty.';
    };

    if(usernameExists($username)){
      $error['username'] = 'This username is taken, please pick another one.';
    };

    if(emailExists($email)){
      $error['email'] = 'An existing account is linked to this email. Try <a href="index.php">logging in.</a>';
    };

    foreach($error as $key => $value){
      if(empty($value)){
         unset($error[$key]);
      };
    }; // for each end

    if(empty($error)){
      registerUser($username, $email, $password, $firstname, $lastname);
      loginUser($username, $password);
    };


    // if(!empty($username) && !empty($password) && !empty($email)){
    //
    //   if(!usernameExists($username) && !emailExists($email)){
    //
    //   $username = mysqli_real_escape_string($connection, $username);
    //   $email = mysqli_real_escape_string($connection, $email);
    //   $password = mysqli_real_escape_string($connection, $password);
    //
    //   $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    //
    //   $query = "INSERT INTO users(username, user_password, user_email, user_role, user_firstname, user_lastname) ";
    //   $query.= "VALUES('{$username}', '{$password}', '{$email}', 'subscriber', '{$firstname}', '{$lastname}') ";
    //
    //   $register_user_query = mysqli_query($connection, $query);
    //
    //   confirm_query($register_user_query);
    //
    //   echo "<p class='text-center bg-success'> User registered. </p>";
    //   echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
    // } else {
    //   echo "<p class='text-center bg-warning'>That username and/ or email exists. Please choose an alternative or login.</p>";
    // };
    // } else {
    //   echo "<p class='text-center bg-warning'> Fields ('username', 'email' and 'password  ') cannot be empty. </p>";
    //   echo "<script>setTimeout(\"location.href = 'registration.php';\",2000);</script>";
    // };

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
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on"
                            value="<?php echo isset($username) ? $username : ''?>">
                            <!-- displaying errors if any -->
                            <p><?php echo isset($error['username']) ? $error['username'] : ''?></p>

                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Firstname - optional" autocomplete="on"
                            value="<?php echo isset($firstname) ? $firstname : ''?>">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Lastname - optional" autocomplete="on"
                            value="<?php echo isset($lastname) ? $lastname : ''?>">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                            value="<?php echo isset($email) ? $email : ''?>">
                            <!-- displaying errors if any -->
                            <p><?php echo isset($error['email']) ? $error['email'] : ''?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <!-- displaying errors if any -->
                            <p><?php echo isset($error['password']) ? $error['password'] : ''?></p>
                        </div>

                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
