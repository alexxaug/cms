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
                    </div>
                </div>

                <!-- inserting the admin widgets code -->



                         <!-- /.row -->

         <div class="row">
             <div class="col-lg-3 col-md-6">
                 <div class="panel panel-primary">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-xs-3">
                                 <i class="fa fa-file-text fa-5x"></i>
                             </div>
                             <div class="col-xs-9 text-right">
                                <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
                                 <div>Posts</div>
                             </div>
                         </div>
                     </div>
                     <a href="posts.php">
                         <div class="panel-footer">
                             <span class="pull-left">View Details</span>
                             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                             <div class="clearfix"></div>
                         </div>
                     </a>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="panel panel-green">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-xs-3">
                                 <i class="fa fa-comments fa-5x"></i>
                             </div>
                             <div class="col-xs-9 text-right">
                                  <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>
                               <div>Comments</div>
                             </div>
                         </div>
                     </div>
                     <a href="comments.php">
                         <div class="panel-footer">
                             <span class="pull-left">View Details</span>
                             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                             <div class="clearfix"></div>
                         </div>
                     </a>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="panel panel-yellow">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-xs-3">
                                 <i class="fa fa-user fa-5x"></i>
                             </div>
                             <div class="col-xs-9 text-right">
                               <div class='huge'><?php echo $user_count = recordCount('users'); ?></div>
                                 <div> Users</div>
                             </div>
                         </div>
                     </div>
                     <a href="users.php">
                         <div class="panel-footer">
                             <span class="pull-left">View Details</span>
                             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                             <div class="clearfix"></div>
                         </div>
                     </a>
                 </div>
             </div>
             <div class="col-lg-3 col-md-6">
                 <div class="panel panel-red">
                     <div class="panel-heading">
                         <div class="row">
                             <div class="col-xs-3">
                                 <i class="fa fa-list fa-5x"></i>
                             </div>
                             <div class="col-xs-9 text-right">
                               <div class='huge'><?php echo $category_count = recordCount('categories'); ?></div>                               
                                  <div>Categories</div>
                             </div>
                         </div>
                     </div>
                     <a href="categories.php">
                         <div class="panel-footer">
                             <span class="pull-left">View Details</span>
                             <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                             <div class="clearfix"></div>
                         </div>
                     </a>
                 </div>
             </div>
         </div>
                         <!-- /.row -->


                <!-- end of insert incase need to remove -->

                <!-- start of google graph code -->

                <?php
                 $query = "SELECT * FROM posts WHERE post_status = 'Draft' ";
                 $select_all_draft_posts = mysqli_query($connection, $query);
                 $draft_post_count = mysqli_num_rows($select_all_draft_posts);

                 $query = "SELECT * FROM posts WHERE post_status = 'Published' ";
                 $select_all_published_posts = mysqli_query($connection, $query);
                 $published_post_count = mysqli_num_rows($select_all_published_posts);

                 $query = "SELECT * FROM users WHERE user_role = 'admin' ";
                 $select_all_admin_users = mysqli_query($connection, $query);
                 $admin_count = mysqli_num_rows($select_all_admin_users);

                 $query = "SELECT * FROM users WHERE user_role = 'subscriber' ";
                 $select_all_subscriber_users = mysqli_query($connection, $query);
                 $subscriber_count = mysqli_num_rows($select_all_subscriber_users);

                 $query = "SELECT * FROM comments WHERE comment_status = 'Approved' ";
                 $select_all_approved_comments = mysqli_query($connection, $query);
                 $approved_comment_count = mysqli_num_rows($select_all_approved_comments);

                 $query = "SELECT * FROM comments WHERE comment_status = 'Unapproved' ";
                 $select_all_unapproved_comments = mysqli_query($connection, $query);
                 $unapproved_comment_count = mysqli_num_rows($select_all_unapproved_comments);
                ?>

                <div class="row">

                  <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                      var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],
                            <?php
                             $element_text = ['All Posts', 'Draft Posts', 'Published Posts', 'Comments', 'Approved Comments', 'Unapproved Comments', 'Users', 'Admin Users',
                                             'Subscriber Users', 'Categories'];
                             $element_count = [$post_count, $draft_post_count, $published_post_count, $comment_count, $approved_comment_count, $unapproved_comment_count, $user_count, $admin_count,
                                             $subscriber_count, $category_count];

                                 for($i=0; $i<10; $i++) {
                                   echo "['{$element_text[$i]}'" . ", " . "{$element_count[$i]}],";
                                 };
                            ?>


                       ]);

                      var options = {
                        chart: {
                          title: '',
                          subtitle: '',
                        }
                      };

                      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                      chart.draw(data, google.charts.Bar.convertOptions(options));
                    };
                  </script>

                  <div id="columnchart_material" style="width: 'auto'; height: 600px;"></div>
                </div>
            </div>

            <!-- commenting out end of google graph code -->





        </div>

        <?php include "includes/admin_footer.php"; ?>
