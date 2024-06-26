<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<!-- Navigation -->
<?php include "includes/navigation.php" ?>
<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php

                if(isset($_GET['p_id'])){
                    $get_post_id = $_GET['p_id'];
                    $get_post_author = $_GET['author'];
                };


                $i = 0;
                $query = "SELECT * FROM posts WHERE post_author = '$get_post_author' ";
                $select_all_posts_query = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                    $post_status = $row["post_status"];
                    $post_id = $row["post_id"];

                    ?>



                    <h1 class="page-header">
                      <?php $post_status = strtolower($post_status); ?>
                      <?php

                            if($i == 0){
                              echo "<small> You are viewing all posts by $post_author</small>";
                              $i = 1;
                            };

                      ?>

                    </h1>

                        <!-- First Blog Post -->
                            <h2>
                              <?php
                                echo "<a href='post.php?p_id={$post_id}'>$post_title</a>";
                              ?>
                            </h2>
                                <p class="lead">
                                    by <a href="index.php"><?php echo $post_author ?></a>
                                </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                            <hr>
                            <img class="img-responsive" width="300" src="images/<?php echo $post_image;?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>
                            <hr>

                <?php }; ?>

            <!-- Blog Comments -->

            <?php
                if(isset($_POST['create_comment'])){

                  $get_post_id = $_GET['p_id'];
                  $comment_author = $_POST['comment_author'];
                  $comment_email = $_POST['comment_email'];
                  $comment_content = $_POST['comment_content'];

                    if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)){

                    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                    $query .= "VALUES ({$get_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now()) ";

                    $create_comment_query = mysqli_query($connection, $query);
                    if(!$create_comment_query){
                        die("Query Failed!" . mysqli_error($connection));
                    };

                    $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
                    $query .= "WHERE post_id = $get_post_id ";
                    $update_post_comment_count = mysqli_query($connection, $query);
                } else {
                  echo "<script>
                          alert('Fields cannot be empty')
                        </script>";
                };
              };

                  ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <?php include "includes/footer.php" ?>
