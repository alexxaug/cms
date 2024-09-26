  <?php include "includes/admin_header.php"; ?>


<<?php if(isset($_SESSION['username'])){ ?>
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

                                  echo $_SESSION['username'];

                              ?>
                          </small>
                        </h1>
                    </div>
                </div>

                <!-- inserting the admin widgets code -->

<?php if(isAdmin($_SESSION['username'])){?>

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

                 $draft_post_count = checkStatusCount('posts', 'post_status', 'Draft');

                 $published_post_count = checkStatusCount('posts', 'post_status', 'Published');

                 $admin_count = checkStatusCount('users', 'user_role', 'admin');

                 $subscriber_count = checkStatusCount('users', 'user_role', 'subscriber');

                 $approved_comment_count = checkStatusCount('comments', 'comment_status', 'Approved');

                 $unapproved_comment_count = checkStatusCount('comments', 'comment_status', 'Unapproved');

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

          <?php }; ?>



        </div>

      <?php } else {
        header("Location: ../index.php");
      }; ?>
        <?php include "includes/admin_footer.php"; ?>
