<?php session_start(); ?>

  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home Page</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <?php

                        $query = "SELECT * FROM categories LIMIT 9 ";
                        $select_all_categories_query = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_all_categories_query)){
                            $cat_title = $row["cat_title"];
                            $cat_id = $row["cat_id"];

                            $category_class = '';

                            $page_name = basename($_SERVER['PHP_SELF']);

                            if(isset($_GET['category']) && $_GET['category'] == $cat_id){
                              $category_class = 'active';
                            };

                            echo "<li class='$category_class'>
                                    <a href='category.php?category=$cat_id'>{$cat_title}</a>
                                  </li>";
                        };


                        if(isset($_SESSION['username'])){
                          //if($_SESSION['user_role'] == 'admin'){
                            echo  "<li>
                              <a href='./admin'>Admin</a>
                            </li>";
                          //};
                        } else {
                          $registration = 'registration.php';
                          $registration_class ='';
                          if ($page_name == $registration){
                            $registration_class = "active";
                          };
                          echo "<li class='$registration_class'>
                            <a href='registration.php'>Register</a>
                          </li>";
                        };

                    if(isset($_SESSION['user_role'])){
                      if($_SESSION['user_role'] == 'admin'){
                        if(isset($_GET['p_id'])){
                            $the_p_id = $_GET['p_id'];
                            echo "<li>
                                    <a href='admin/posts.php?source=edit_post&p_id=$the_p_id'>Edit Post</a>
                                  </li>";
                        };
                      };
                    };

                    ?>

                    <?php // if(isset($_SESSION['username'])){ ?>

                    <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php // echo $_SESSION['username']; ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="admin/profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                            </li>

                            <li class="divider"></li>
                            <li>
                                <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                            </li>
                        </ul>
                    </li> -->

                  <?php // }; ?>

                </ul>



            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
