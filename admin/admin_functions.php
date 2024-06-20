<?php



    function confirm_query($result){
        global $connection;
        if(!$result){
            die('QUERY FAILED ' . mysqli_error($connection));
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

    function checkStatus($table, $column, $status){
      global $connection;
      $query = "SELECT * FROM $table WHERE $column = '$status' ";
      $result = mysqli_query($connection, $query);
      confirm_query($result);
      return mysqli_num_rows($result);
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
