<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>
<!-- Navigation -->
<?php include "includes/navigation.php" ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

            <?php

                if(isset($_GET['p_id'])){
                    $get_post_id = $_GET['p_id'];

                    $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $get_post_id ";
                    $send_view_query = mysqli_query($connection, $view_query);

                    if(!$send_view_query){
                      die("Query failed!");
                    };

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){
                    $query = "SELECT * FROM posts WHERE post_id = $get_post_id ";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $get_post_id AND post_status = 'published' ";
                };

                $select_all_posts_query = mysqli_query($connection, $query);

                if(mysqli_num_rows($select_all_posts_query)==0){
                    echo "<h1 class='text-center'>The post you are trying to view is unavailable.</h1>";
                } else {

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
                       <small><?php echo "You are viewing a $post_status post by $post_author"; ?></small>
                    </h1>

                        <!-- First Blog Post -->
                            <h2>
                                <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                            </h2>
                                <p class="lead">
                                    by <a href="author_related_posts.php?author=<?php echo $post_author; ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                                </p>
                            <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                            <hr>
                            <img class="img-responsive" width="300" src="images/<?php echo $post_image;?>" alt="">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <hr>

                <?php
                };

                ?>

            <!-- Blog Comments -->



                <hr>

                <!-- Posted Comments -->

                <div class="media-body">
                    <h3 class="media-heading text-muted"><u>Comments</u></h3>
                </div>

                <?php

                  $query = "SELECT * FROM comments WHERE comment_post_id = $get_post_id ";
                  $query .= "AND comment_status = 'Approved' ";
                  $query .= "ORDER BY comment_id DESC ";
                  $select_comment_query = mysqli_query($connection, $query);

                  if(!$select_comment_query){
                    die("Query Failed" . mysqli_error($connection));
                  };

                  while ($row = mysqli_fetch_array($select_comment_query)) {
                    $comment_date = $row['comment_date'];
                    $comment_content = $row['comment_content'];
                    $comment_author = $row['comment_author'];

                  ?>

                  <!-- Comment -->
                  <div class="media">
                      <a class="pull-left" href="#">
                          <img class="media-object" src="http://placehold.it/64x64" alt="">
                      </a>
                      <div class="media-body">
                          <h4 class="media-heading"><?php echo $comment_author; ?>
                              <small><?php echo $comment_date; ?></small>
                          </h4>
                           <?php echo $comment_content; ?>
                      </div>
                  </div>


                  <?php
                    };
                  ?>

                  <?php
                    if(isset($_POST['create_comment'])){

                        $get_post_id = $_GET['p_id'];
                        $comment_author = $_SESSION['username'];
                        $comment_email = $_SESSION['user_email'];
                        $comment_content = $_POST['comment_content'];

                            if(!empty($comment_content)){

                                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                                $query .= "VALUES ({$get_post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now()) ";

                                $create_comment_query = mysqli_query($connection, $query);
                                if(!$create_comment_query){
                                    die("Query Failed!" . mysqli_error($connection));
                                };
                            } else {
                                      echo "<script>
                                        alert('Fields cannot be empty')
                                        </script>";
                            };

                    }; // end of if isset check


                  ?>

                      <!-- Comments Form -->
                      <hr>
                      <div class="well">
                          <h4>Leave a Comment:</h4>
                          <form action="" method="post" role="form">
                              <div class="form-group">
                                  <label for="comment">Your Comment</label>
                                  <textarea name="comment_content" class="form-control" rows="3"></textarea>
                              </div>
                              <h3 class="page-header">
                                <small>
                                  You are commenting as User: <?php echo $_SESSION['username']; ?>
                                </small>
                              </h3>
                              <button type="submit" name="create_comment" class="btn btn-primary">Comment</button>
                          </form>
                      </div>

                  <?php

                  }
                } else {
                    header("Location: index.php");
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
