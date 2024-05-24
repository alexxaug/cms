<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
include "includes/delete_modal.php";
?>
<?php
  if(isset($_POST["checkBoxArray"])){
    if(isset($_SESSION['user_role'])){
      if($_SESSION['user_role'] == 'admin'){

        foreach($_POST["checkBoxArray"] as $postValueId){

          $bulk_options = $_POST['bulk_options'];

          switch($bulk_options){
            case 'Published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId ";
            $update_post_to_published = mysqli_query($connection, $query);
            confirm_query($update_post_to_published);
            header("Location: posts.php");
            break;

            case 'Draft':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = $postValueId  ";
            $update_post_to_draft = mysqli_query($connection, $query);
            confirm_query($update_post_to_draft);
            header("Location: posts.php");
            break;

            case 'Clone':
            $query = "SELECT * FROM posts WHERE post_id = $postValueId ";

            $select_post_query = mysqli_query($connection, $query);
            confirm_query($select_post_query);

            while($row = mysqli_fetch_array($select_post_query)){
              $post_id = $row["post_id"];
              $post_author = $row["post_author"];
              $post_title = $row["post_title"];
              $post_category_id = $row["post_category_id"];
              $post_status = $row["post_status"];
              $post_image = $row["post_image"];
              $post_tags = $row["post_tags"];
              $post_date = $row["post_date"];
              $post_content = $row["post_content"];
            };

            $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
            $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}',
            '{$post_tags}', '{$post_status}') ";

            $clone_post_query = mysqli_query($connection, $query);

            confirm_query($clone_post_query);

            $the_post_id = mysqli_insert_id($connection);

            header("Location: posts.php");
            break;

            case 'delete':
            $query = "DELETE FROM posts WHERE post_id = $postValueId ";
            $delete_post_query = mysqli_query($connection, $query);
            confirm_query($delete_post_query);
            header("Location: posts.php");
            break;
          }
        };
      };
    };
  };
?>

<form action="" method="post">
  <table class="table table-bordered table-hover">

<div class="row">
  <div id="bulkOptionsContainer" class="col-xs-4 form-group">
    <select class="form-control" name="bulk_options" id="">
      <option value="">Select Options</option>
      <option value="Published">Publish</option>
      <option value="Draft">Draft</option>
      <option value="Clone">Clone</option>
      <option value="delete">Delete</option>
    </select>
    </div>

    <div class="col-xs-4 form-group">
        <input type="submit" name="submit" class="btn btn-success" value="Apply" onclick="return confirm('Are sure that the correct action is selected?')">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
  </div>



      <thead>
          <tr>
              <th><input id="selectAllBoxes" type="checkbox"></th>
              <th>Id</th>
              <th>Author</th>
              <th>Title</th>
              <th>Category</th>
              <th>Status</th>
              <th>Image</th>
              <th>Tags</th>
              <th>Comments</th>
              <th>Date</th>
              <!-- <th>Post View Count</th> -->
              <th>View Post</th>
              <th>Edit</th>
              <th>Delete</th>
          </tr>
      </thead>
      <tbody>
          <?php
              $query = "SELECT * FROM posts ";
              $select_posts = mysqli_query($connection, $query);
              while($row = mysqli_fetch_assoc($select_posts)){
                  $post_id = $row["post_id"];
                  $post_author = $row["post_author"];
                  $post_title = $row["post_title"];
                  $post_category_id = $row["post_category_id"];
                  $post_status = $row["post_status"];
                  $post_image = $row["post_image"];
                  $post_tags = $row["post_tags"];
                  $post_date = $row["post_date"];
                  // $post_view_count = $row["post_view_count"];

                  echo "<tr>";
                  ?>

                  <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

                  <?php
                  echo "<td>{$post_id}</td>";
                  echo "<td>{$post_author}</td>";
                  echo "<td>{$post_title}</td>";

                  $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
                  $select_categories_id = mysqli_query($connection, $query);

                  while($row = mysqli_fetch_assoc($select_categories_id)){
                  $cat_id = $row["cat_id"];
                  $cat_title = $row["cat_title"];

                  echo "<td>{$cat_title}</td>";
                  };

                  echo "<td>{$post_status}</td>";
                  echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                  echo "<td>{$post_tags}</td>";

                  $get_comments_query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                  $send_comments_query = mysqli_query($connection, $get_comments_query);

                  $row = mysqli_fetch_array($send_comments_query);
                  $comment_id = isset($row['comment_id']);
                  $comment_count = mysqli_num_rows($send_comments_query);

                  echo "<td><a href='post_comments.php?id={$post_id}'>{$comment_count}</a></td>";

                  echo "<td>{$post_date}</td>";
                  echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
                  echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit Post</a></td>";
                  // echo "<td><a onClick=\"javascript: return confirm('Are you sure that you would like to delete this post?') \"
                  //       href='posts.php?delete={$post_id}' >Delete Post</a></td>";
                  echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete Post</a></td>";
                  echo "</tr>";
              };
          ?>
      </tbody>
  </table>
</form>

<?php

  if(isset($_SESSION['user_role'])){
    if($_SESSION['user_role'] == 'admin'){
     if(isset($_GET['delete'])){
       global $connection;
          $the_post_id = $_GET['delete'];
          $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
          $delete_post_query = mysqli_query($connection, $query);
         header("Location: posts.php");
     };
   };
 };

?>

<script>
  $(document).ready(function(){
      $('.delete_link').on('click', function(){
        var id = $(this).attr('rel');
        var delete_url = "posts.php?delete="+ id +" ";
        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');
      });
  });

</script>
