<?php include "includes/admin_header.php"; ?>

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
                            <small>
                              <?php
                                if(isset($_SESSION['username'])){
                                  echo $_SESSION['username'];
                                };
                              ?>
                            </small>
                        </h1>

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

//" ORDER BY comment_id DESC "

            $select_post_comments_query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']);
            $select_comments = mysqli_query($connection, $select_post_comments_query);
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
                echo "<td><a onClick=\"javascript: return confirm('Are you sure that you would like to delete this comment?') \"
                      href='comments.php?delete=$comment_id'>Delete</a></td>";
                echo "</tr>";
            };

            if(mysqli_num_rows($select_comments)==0){
                echo "<h2 class='text-center'>There are no comments on this post.</h2>";
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
      global $connection;
        $the_comment_id = $_GET['delete'];
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $delete_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    };
  };

?>

</div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>

<?php include "includes/admin_footer.php"; ?>
