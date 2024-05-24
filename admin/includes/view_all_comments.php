<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
include "includes/delete_modal.php";
?>
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php


            $select_all_comments_query = "SELECT * FROM comments ORDER BY comment_id DESC ";
            $select_comments = mysqli_query($connection, $select_all_comments_query);
            while($row = mysqli_fetch_assoc($select_comments)){
                $comment_id = $row["comment_id"];
                $comment_post_id = $row["comment_post_id"];
                $comment_author = $row["comment_author"];
                $comment_email = $row["comment_email"];
                $comment_content = $row["comment_content"];
                $comment_status = $row["comment_status"];
                $comment_date = $row["comment_date"];

                echo "<tr>";
                echo "<td>{$comment_id}</td>";
                echo "<td>{$comment_author}</td>";
                echo "<td>{$comment_content}</td>";
                echo "<td>{$comment_email}</td>";
                echo "<td>{$comment_status}</td>";

                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                $select_post_id_query = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_post_id_query)){
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    if($post_id == $comment_post_id){
                        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                    };
                };

                if(mysqli_num_rows($select_post_id_query)==0){
                  $del_comm_query = "DELETE FROM comments WHERE comment_id = $comment_id ";
                  $delete_comment_query = mysqli_query($connection, $del_comm_query);
                  header("Location: comments.php");
                };

                echo "<td>{$comment_date}</td>";
                echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                echo "<td><a href='comments.php?unapprove=$comment_id'</a>Unapprove</td>";
                // echo "<td><a onClick=\"javascript: return confirm('Are you sure that you would like to delete this comment?') \"
                //       href='comments.php?delete=$comment_id'>Delete</a></td>";
                echo "<td><a rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete Comment</a></td>";
                echo "</tr>";
            };
        ?>
    </tbody>
</table>

<?php

  if(isset($_GET['unapprove'])){
          global $connection;
          if(isset($_GET['unapprove'])){
              $the_comment_id = $_GET['unapprove'];

              $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = $the_comment_id ";
              $comment_unapprove_query = mysqli_query($connection, $query);

              header("Location: comments.php");
      };
  };

  if(isset($_GET['approve'])){
          global $connection;
          if(isset($_GET['approve'])){
              $the_comment_id = $_GET['approve'];

                $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = $the_comment_id ";
                $comment_approve_query = mysqli_query($connection, $query);
                header("Location: comments.php");
      };
  };

  if(isset($_GET['delete'])){

    if(isset($_SESSION['user_role'])){
      if($_SESSION['user_role'] == 'admin'){
        global $connection;
        $the_comment_id = $_GET['delete'];

        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $delete_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
      };
    };
  };


?>

<script>
  $(document).ready(function(){
      $('.delete_link').on('click', function(){
        var id = $(this).attr('rel');
        var delete_url = "comments.php?delete="+ id +" ";
        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');
      });
  });

</script>
