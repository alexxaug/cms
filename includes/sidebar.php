<div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Search Posts</h4>

                    <form action="search.php" method="post">

                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>

                    </form> <!-- search form -->
                    <!-- /.input-group -->
                </div>

                <!-- Login -->
                <div class="well">
                <?php
                // if(!isset($_SESSION['username'])){
                //   echo
                //     '<div class="well">
                //       <h4>Login</h4>
                //       <form action="includes/login.php" method="post">
                //         <div class="form-group">
                //           <input name="username" type="text" class="form-control" placeholder="Enter Username">
                //         </div>
                //         <div class="input-group">
                //           <input name="password" type="password" class="form-control" placeholder="Enter Password">
                //           <span class="input-group-btn">
                //             <button class="btn btn-primary" type="submit" name="login">Login</button>
                //           </span>
                //         </div>
                //     </form> <!-- search form -->
                //     <!-- /.input-group -->
                //     </div>';
                //   } else {
                //
                //   };


                  ?>

                  <?php if(isset($_SESSION['user_role'])): ?>

                    <h4>Logged in as: <?php echo $_SESSION['username'] ?></h4>
                    <span class="input-group-btn">
                      <a href="includes/logout.php" class="btn btn-primary" type="" name="">Logout</a>
                    </span>

                  <?php else: ?>

                    <h4>Login</h4>
                      <form action="includes/login.php" method="post">
                        <div class="form-group">
                          <input name="username" type="text" class="form-control" placeholder="Enter Username">
                        </div>
                        <div class="input-group">
                          <input name="password" type="password" class="form-control" placeholder="Enter Password">
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="login">Login</button>
                          </span>
                        </div>

                  <?php endif; ?>

                </div>

                <!-- Blog Categories Well -->
                <div class="well">

                <?php

                    $query = "SELECT * FROM categories ";
                    $select_categories_sidebar = mysqli_query($connection, $query);
                ?>

                    <h4>Post Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                while($row = mysqli_fetch_assoc($select_categories_sidebar)){
                                    $cat_title = $row["cat_title"];
                                    $cat_id = $row["cat_id"];
                                    echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</li>";
                                };

                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <?php
                    include "widgets.php";
                ?>

            </div>
