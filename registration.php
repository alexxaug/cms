<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
 <?php  include "admin/admin_functions.php"; ?>

<?php
  if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    if(!empty($username) && !empty($password) && !empty($email)){

      $username = mysqli_real_escape_string($connection, $username);
      $email = mysqli_real_escape_string($connection, $email);
      $password = mysqli_real_escape_string($connection, $password);

      $query1 = "SELECT randSalt FROM users ";
      $select_randsalt_query = mysqli_query($connection, $query1);

      confirm_query($select_randsalt_query);

      $row = mysqli_fetch_array($select_randsalt_query);
      $salt = $row['randSalt'];

      $password = crypt($password, $salt);


      $query = "INSERT INTO users(username, user_password, user_email, user_role, user_firstname, user_lastname) ";
      $query.= "VALUES('{$username}', '{$password}', '{$email}', 'subscriber', '{$firstname}', '{$lastname}') ";

      $register_user_query = mysqli_query($connection, $query);

      confirm_query($register_user_query);

      echo "<p class='text-center bg-success'> User registered. </p>";
      echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
    } else {
      echo "<p class='text-center bg-warning'> Fields ('username', 'email' and 'password  ') cannot be empty. </p>";
      echo "<script>setTimeout(\"location.href = 'registration.php';\",2000);</script>";
    };
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
