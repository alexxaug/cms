<?php include "includes/admin_header.php"; ?>
<?php
foreach($_POST as $field => $value) {
  $_POST[$field] = mysqli_real_escape_string($connection, $value);
};
?>
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

                        <?php
                            if(isset($_GET['source'])){
                                $source = $_GET['source'];

                            } else {
                                $source = '';
                            };

                            switch($source){
                                case 'add_post';
                                include 'includes/add_post.php';
                                break;
                                case 'edit_post';
                                include 'includes/edit_post.php';
                                break;
                                default:
                                include 'includes/view_all_comments.php';
                                break;
                            };
                        ?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>

        <?php include "includes/admin_footer.php"; ?>
