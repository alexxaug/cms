<?php



    function confirm_query($result){
        global $connection;
        if(!$result){
            die('QUERY FAILED ' . mysqli_error($connection));
        };
    };


    function isAdmin($username = ''){
      global $connection;
      $query = "SELECT user_role FROM users WHERE username = '$username' ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);
      $row = mysqli_fetch_array($result);
      if($row['user_role'] == 'admin'){
        return true;
      } else {
        return false;
      };
    };

    function redirect($location){
      return header("Location:" . $location);
    };

    // function registerUser($username, $email, $password, $firstname, $lastname){
    //   global $connection;
    //   //if(!empty($username) && !empty($password) && !empty($email)){
    //
    //     //if(!usernameExists($username) && !emailExists($email)){
    //
    //     // $username = mysqli_real_escape_string($connection, $username);
    //     // $email = mysqli_real_escape_string($connection, $email);
    //     // $password = mysqli_real_escape_string($connection, $password);
    //
    //     $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    //
    //     $query = "INSERT INTO users(username, user_password, user_email, user_role, user_firstname, user_lastname) ";
    //     $query.= "VALUES('{$username}', '{$password}', '{$email}', 'subscriber', '{$firstname}', '{$lastname}') ";
    //
    //     $register_user_query = mysqli_query($connection, $query);
    //
    //     confirm_query($register_user_query);

      //   echo "<p class='text-center bg-success'> User registered. </p>";
      //   echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
      // } else {
      //   echo "<p class='text-center bg-warning'>That username and/ or email exists. Please choose an alternative or login.</p>";
      // };
      // } else {
      //   echo "<p class='text-center bg-warning'> Fields ('username', 'email' and 'password  ') cannot be empty. </p>";
      //   echo "<script>setTimeout(\"location.href = 'registration.php';\",2000);</script>";
      // };

      //};

    function registerUser($username, $email, $password, $firstname, $lastname){
      global $connection;

      $form_errors = array();

      if($username == ''){
        $form_errors[] = '$ERROR! - Empty field detected. Please go back and fill out the username field.*';
      } else if (usernameExists($username)){
        $form_errors[] = '$ERROR! - Sorry this username is currently taken.*';
      } else if (strlen($username) < 4){
        $form_errors[] = '$ERROR! - The username must be at least 4 characters long.*';
      } else {
        $reg_username = $username;
      };

      if($firstname == ''){
        $form_errors[] = '$ERROR! - Empty field detected. Please go back and fill out the first name field.*';
      } else {
        $reg_firstname = $firstname;
      };

      if($lastname == ''){
        $form_errors[] = '$ERROR! - Empty field detected. Please go back and fill out the last name field.*';
      } else {
        $reg_lastname = $lastname;
      };

      if($email == ''){
        $form_errors[] = '$ERROR! - Empty field detected. Please go back and fill out the email field.*';
      } else if (emailExists($email)){
        $form_errors[] = '$ERROR! - Sorry there is already an account with this email address. <a href="index.php">Plese login</a>*';
      } else {
        $reg_email = $email;
      };

      if($password = ''){
        $form_errors[] = '$ERROR! - Empty field detected. Please go back and fill out the password field.*';
      } else if (strlen($password) < 6){
        $form_errors[] = '$ERROR! - Password must be at least 6 characters long.*';
      } else {
        $reg_password = $password;
      };

      if(!empty($form_errors)){
        $form_msg = '<div class="form_msgs"><h4>The following errors ocurred:</h4>';
        foreach($form_errors as $form_error){
          $form_msg .= '<h5>' . $form_error . '</h5>';
        };
        $form_msg .= '</div>';
        return $form_msg;
      } else { // Mo form errors - all fields were filled in, lets move forwards..
        $password = password_hash($reg_password, PASSWORD_BCRYPT, array('cost' => 12, ));

        $query = "INSERT INTO users (username, user_firstname, user_lastname, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$reg_username}', '{$reg_firstname}', '{$reg_lastname}', '{$reg_email}', '{$reg_password}', 'subscriber') ";
        $register_user_query = mysqli_query($connection, $query);
        if(!$register_user_query){
          die("QUERY FAILED " . mysqli_error($connection) . ' ' . mysqli_errno($connection));
        };
        $last_id = mysqli_insert_id($connection);
        updateUsersOnline($last_id);
        $form_msg = '<div class="form_msgs"><h5>Thanks' . $reg_username . ' Your registration is now complete<h5></div>';
        return $form_msg;
      };
    }; // end of register user

    function showLoginFormErrors($form_errors){
      global $connection;
      echo "<h3>The following errors occured when trying to login: </h3>";
      echo "<br>";
      foreach($form_errors as $err_msg){
        echo "<h2>" . $err_msg . "</h5>";
      };
    };

    function loginUser($username, $password){
      global $connection;

      $username = trim($username);
      $password = trim($password);

      $username = mysqli_real_escape_string($connection, $username);
      $password = mysqli_real_escape_string($connection, $password);

      $query = "SELECT * FROM users WHERE username = '{$username}' ";
      $select_user_query = mysqli_query($connection, $query);
      if(!$select_user_query){
        die("Query Failed" . mysqli_error($connection));
      };

      while($row = mysqli_fetch_array($select_user_query)){
        $db_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        $db_user_email = $row['user_email'];
      };

        if(password_verify($password,$db_user_password)){
          $_SESSION['username'] = $db_username;
          $_SESSION['firstname'] = $db_user_firstname;
          $_SESSION['lastname'] = $db_user_lastname;
          $_SESSION['user_role'] = $db_user_role;
          $_SESSION['user_email'] = $db_user_email;

          header("Location: ../admin");
        } else {
          header("Location: ../index.php");
        };
    };

    function insert_categories(){
        global $connection;
        if(isset($_POST['submit'])){
            $cat_title = $_POST['cat_title'];

            if($cat_title == '' || empty($cat_title)){
                echo "<p class='bg-warning'>Field below cannot be empty.</p>";
            } else if ($cat_title == 'orphaned' || $cat_title == 'Orphaned' || $cat_title == 'Uncategorised' ||
              $cat_title == 'Uncategorized' || $cat_title == 'uncategorized' || $cat_title == 'uncategorised'){
                echo "<p class='bg-warning'>Category cannot be named $cat_title.</p>";
            } else {
                $query = "INSERT INTO categories(cat_title) ";
                $query .= "VALUE('{$cat_title}') ";
                $create_category_query = mysqli_query($connection, $query);
            };
        };
    };

    function findAllCategories(){
        global $connection;
        $query = "SELECT * FROM categories ";
        $select_categories = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_categories)){
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];
            if($cat_title !== 'orphaned'){
            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?delete=$cat_id'>Delete</a></td>";
            echo "<td><a href='categories.php?edit=$cat_id'>Edit</a></td>";
            echo "<tr>";
          };
        };
    };

    function deleteCategories(){
        global $connection;
        if(isset($_GET['delete'])){
          if(isset($_SESSION['user_role'])){
            if($_SESSION['user_role'] == 'admin'){
              $get_cat_id = $_GET['delete'];
              $query = "DELETE FROM categories WHERE cat_id = {$get_cat_id} ";
              $delete_categorie_query = mysqli_query($connection, $query);

              echo "<p class='text-center bg-success'> Category deleted. </p>";

              //IF CATEGORY DELETED, POSTS IN THAT CATEGORY WILL MOVE TO THE ORPHAN CATEGORY ie Cat ID will change from deleted ID to ORPHANED ID
              $change_post_cat_id_query = "UPDATE posts SET post_category_id = '1' WHERE post_category_id = {$get_cat_id} ";
              $change_category_query = mysqli_query($connection, $change_post_cat_id_query);

              echo "<script>setTimeout(\"location.href = 'categories.php';\",1500);</script>";
            };
          };
        };
      };

    function deletePost(){
        global $connection;
        if(isset($_GET['delete'])){
            $the_post_id = $_GET['delete'];

            $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
            $delete_post_query = mysqli_query($connection, $query);
            header("Location: posts.php");
        };
    };

    function selectDisplayCategoryOptions(){
        global $connection;
        $query = "SELECT * FROM categories ";
        $select_categories = mysqli_query($connection, $query);
        confirm_query($select_categories);

        while($row = mysqli_fetch_assoc($select_categories)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<option value='{$cat_id}'>{$cat_title}</option>";
        };
    };

    function recordCount($table){
      global $connection;
      $query = "SELECT * FROM " . $table;
      $select_all_records_query = mysqli_query($connection, $query);
      $result = mysqli_num_rows($select_all_records_query);
      confirm_query($result);
      return $result;
    };

    function checkStatusCount($table, $column, $status){
      global $connection;
      $query = "SELECT * FROM $table WHERE $column = '$status' ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);
      return mysqli_num_rows($result);
  };

    function post_comment_count($table, $column, $post_id){
      global $connection;
      $query = "SELECT * FROM $table WHERE $column = $post_id ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);
      return mysqli_num_rows($result);
    };

    function usernameExists($username){
      global $connection;

      $query = "SELECT username FROM users WHERE username = '$username' ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);

      if(mysqli_num_rows($result)>0){
        return true;
      }else{
        return false;
      };
    };

    function emailExists($email){
      global $connection;
      $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);

      if(mysqli_num_rows($result)>0){
        return true;
      }else{
        return false;
      };
    };

    function users_online(){

      if(isset($_GET['onlineusers'])){

        global $connection;
        if(!$connection){
          session_start();
          include("../includes/db.php");

          $session = session_id();
          $time = time();
          $timeout_in_seconds = 60;
          $timeout = $time - $timeout_in_seconds;

          $get_users_query = "SELECT * FROM users_online WHERE session = '$session'";
          $send_get_users_query = mysqli_query($connection, $get_users_query);
          $count = mysqli_num_rows($send_get_users_query);

          if($count == NULL){
            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
          } else {
            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
          };

          $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > $timeout");
          echo $count_user = mysqli_num_rows($users_online_query);
        };
    }; // GET Request isset
  };
  users_online();

?>
