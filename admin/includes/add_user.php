<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
?>
<?php
    if(isset($_POST['create_user'])){
        $username = $_POST['username'];
        $user_password = $_POST['user_password'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_image = $_FILES['image']['name'];
        $user_image_temp = $_FILES['image']['tmp_name'];
        $user_role = $_POST['user_role'];

        move_uploaded_file($user_image_temp, "../images/$user_image");

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

        if(!empty($username) && !empty($user_password) && !empty($user_email)){

        $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
        $query .= "VALUES('{$username}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}',
        '{$user_image}', '{$user_role}') ";

        $create_user_query = mysqli_query($connection, $query);

        confirm_query($create_user_query);

        echo "<div class='bg-success'>
                User  '{$username}' created with the role of $user_role successfully!
              </div>";

        echo "<script>setTimeout(\"location.href = './users.php';\",1200);</script>";

      } else {
        echo "<p class='text-center bg-warning'> Fields ('username', 'email' and 'password  ') cannot be empty. </p>";
        echo "<script>setTimeout(\"location.href = 'users.php?source=add_user';\",2000);</script>";
      };
    };
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" class="form-control" name="image">
    </div>

    <div class="form-group">
        <label for="user_role">User Role</label>
        <select class="form-control" name="user_role">
          <option value="subscriber">Select Options</option>
          <option value="admin">Admin</option>
          <option value="subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>
</form>
