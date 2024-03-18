<?php
    if(isset($_GET['edit_user'])){
      $the_user_id = $_GET['edit_user'];
      };

      $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
      $select_users = mysqli_query($connection, $query);

      while($row = mysqli_fetch_assoc($select_users)){
            $user_id = $row["user_id"];
            $username = $row["username"];
            $user_password = $row["user_password"];
            $user_firstname = $row["user_firstname"];
            $user_lastname = $row["user_lastname"];
            $user_email = $row["user_email"];
            $user_image = $row["user_image"];
            $user_role = $row["user_role"];
      };

      if(isset($_POST['edit_user'])){
          $username = $_POST['username'];
          $user_password = $_POST['user_password'];
          $user_firstname = $_POST['user_firstname'];
          $user_lastname = $_POST['user_lastname'];
          $user_email = $_POST['user_email'];
          $user_image = $_FILES['image']['name'];
          $user_image_temp = $_FILES['image']['tmp_name'];
          $user_role = $_POST['user_role'];

          move_uploaded_file($user_image_temp, "../images/$user_image");

          if(empty($user_image)){
              $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
              $select_image = mysqli_query($connection, $query);
              while($row = mysqli_fetch_array($select_image)){
                  $user_image = $row['user_image'];
              };
          };

          if(!empty($user_password)){
            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id ";
            $get_user_query = mysqli_query($connection, $query_password);
            confirm_query($get_user_query);

            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row['user_password'];
          };

          if($db_user_password != $user_password){
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
          };

          $query = "UPDATE users SET ";
          $query .= "username = '{$username}', ";
          $query .= "user_password = '{$hashed_password}', ";
          $query .= "user_firstname = '{$user_firstname}', ";
          $query .= "user_lastname = '{$user_lastname}', ";
          $query .= "user_email = '{$user_email}', ";
          $query .= "user_image = '{$user_image}', ";
          $query .= "user_role = '{$user_role}' ";
          $query .= "WHERE user_id = $the_user_id ";

          $edit_user_query = mysqli_query($connection, $query);
          confirm_query($edit_user_query);

          echo "<div class='form-group'>
                    <p class='bg-success'>'{$username}'s' profile edited successfully. " .
                    "<a href='users.php'>View All Users</a></p>
                </div>";
      // } else {
      //   echo "<p class='text-center bg-warning'> Password field cannot be empty. </p>";
      //   echo "<script>setTimeout(\"location.href = 'users.php?source=edit_user&edit_user={$the_user_id}';\",2000);</script>";
      // };
};
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>


<!-- class="bg-danger text-danger" -->
    <div class="form-group">
        <label for="user_password">Enter Password</label>
        <input type="password" class="form-control" name="user_password" value="">
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
        <label for="user_role">User Role</label>
        <select class="form-control" name="user_role">
            <option><?php echo $user_role; ?></option>
            <?php if($user_role == 'admin'){
              echo "<option value='subscriber'>subscriber</option>";
            } else {
              echo "<option value='admin'>admin</option>";
            };
            ?>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Update">
    </div>
</form>
