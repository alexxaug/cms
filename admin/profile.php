<?php include "includes/admin_header.php"; ?>
<?php
  if(isset($_SESSION['username'])){
    $the_username = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = '{$the_username}' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_array($select_user_profile_query)){
      $user_id = $row["user_id"];
      $username = $row["username"];
      $user_password = $row["user_password"];
      $user_firstname = $row["user_firstname"];
      $user_lastname = $row["user_lastname"];
      $user_email = $row["user_email"];
      $user_image = $row["user_image"];
      $user_role = $row["user_role"];
    };
  };
?>

<?php
if(isset($_POST['update_user_profile'])){
    $username = $_POST['username'];
    $user_password = $_POST['user_password'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];

    move_uploaded_file($user_image_temp, "../images/$user_image");

    if(empty($user_image)){
        $query = "SELECT * FROM users WHERE username = '{$the_username}' ";
        $select_image = mysqli_query($connection, $query);
        while($row = mysqli_fetch_array($select_image)){
            $user_image = $row['user_image'];
        };
    };

    if(!empty($user_password))   {

      $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

      $query = "UPDATE users SET ";
      $query .= "user_firstname = '$user_firstname', ";
      $query .= "user_lastname = '$user_lastname', ";
      $query .= "user_role = '$user_role', ";
      $query .= "username = '$username', ";
      $query .= "user_email = '$user_email', ";
      $query .= "user_password = '$user_password' ";
      $query .= "WHERE username = '{$the_username}'";

      $update_user_profile_query = mysqli_query($connection, $query);

      confirm_query($update_user_profile_query);
      header("Location: ./users.php");

    } else {

      $query = "UPDATE users SET ";
      $query .= "user_firstname = '$user_firstname', ";
      $query .= "user_lastname = '$user_lastname', ";
      $query .= "user_role = '$user_role', ";
      $query .= "username = '$username', ";
      $query .= "user_email = '$user_email' ";
      $query .= "username = '{$the_username}'";

      $update_user_profile_query = mysqli_query($connection, $query);

      confirm_query($update_user_profile_query);
      header("Location: ./users.php");

    };

};
?>

<body>

    <div id="wrapper">



        <!-- Navigation -->
        <?php
            include "includes/admin_navigation.php";
        ?>



        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>


                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input autocomplete="off" type="password" class="form-control" name="user_password">
                            </div>

                            <div class="form-group">
                                <label for="user_firstname">Firstname</label>
                                <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_lastname">Lastname</label>
                                <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
                            </div>

                            <div class="form-group">
                                <label>User Image</label>
                                <br>
                                <img width="100" src="../images/<?php echo $user_image; ?>" alt="">
                                <input type="file" name="image">
                            </div>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_user_profile" value="Update Profile">
                            </div>
                        </form>



                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>

        <?php include "includes/admin_footer.php"; ?>
