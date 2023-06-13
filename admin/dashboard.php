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
                            Welcom to admin dashboard
                            <small><?php echo strtoupper( $_SESSION['username']); ?></small>
                        </h1>
                        
                    </div>
                </div>
                <!-- /.row -->
 <?php

$query = "SELECT * FROM posts WHERE post_status = 'published' ";
$select_all_publish_query = mysqli_query($connection, $query);
$post_publish_count = mysqli_num_rows($select_all_publish_query);


$query = "SELECT * FROM posts WHERE post_status = 'draft' ";
$select_all_draft_query = mysqli_query($connection, $query);
$post_draft_count = mysqli_num_rows($select_all_draft_query);

$query = "SELECT * FROM comments WHERE comment_status = 'unapproved' ";
$unapprove_comment = mysqli_query($connection, $query);
$unapprove_comment_count = mysqli_num_rows($unapprove_comment);

$query = "SELECT * FROM users WHERE user_role = 'subscriber' ";
$select_all_subscriber = mysqli_query($connection, $query);
$sub_count = mysqli_num_rows($select_all_subscriber);



?>




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
                                        <?php

                                        $query = "SELECT * FROM posts";
                                        $select_query = mysqli_query($connection, $query);
                                        $post_count = mysqli_num_rows($select_query);

                                        echo "<div class='huge'>{$post_count}</div>";

                                        ?>




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
                                        <?php

                                        $query = "SELECT * FROM comments";
                                        $select_all_comment = mysqli_query($connection, $query);
                                        $comment_count = mysqli_num_rows($select_all_comment);

                                        echo "<div class='huge'>{$comment_count}</div>";

                                        ?>


                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comment.php">
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
                                        <?php

                                        $query = "SELECT * FROM users";
                                        $select_all_user = mysqli_query($connection, $query);
                                        $users_count = mysqli_num_rows($select_all_user);

                                        echo "<div class='huge'>{$users_count}</div>";

                                        ?>
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
                                        <?php

                                        $query = "SELECT * FROM categories";
                                        $select_all_categories = mysqli_query($connection, $query);
                                        $category_count = mysqli_num_rows($select_all_categories);

                                        echo "<div class='huge'>{$category_count}</div>";

                                        ?>

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

                <div class="row">
                    <script type="text/javascript">
                        google.charts.load('current', {
                            'packages': ['bar']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Data', 'Count'],
<?php
$element_text=['All Posts','Active Post','Draft Post','Comments','Unapprove Comment','Users','users Subscriber','Categories'];
$element_count=[$post_count,$post_publish_count,$post_draft_count,$comment_count,$unapprove_comment_count,$users_count,$sub_count,$category_count];


for($i =0;$i<8;$i++){

    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
}

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
                        }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

                </div>




            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>