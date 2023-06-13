<?php include "includes/admin_header.php" ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcom to admin
                            <small>author</small>

                        </h1>
                    <?php 
                    
                    if(isset($_GET['source'])){
                        $source=$_GET['source'];

                      }  else{
                            $source='';
                        }

                        switch($source){

                            case "add_posts";
                            include "includes/add_posts.php";
                            break;

                            case "edit_post";
                            include "includes/edit_post.php";
                            break;

                            case 50;
                            echo "nice 50";
                            break;

                            default ;
                            include "includes/view_all_comment.php";

                        }
                    
                    
                    
                    ?>



                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>