<!DOCTYPE html>
<html lang="en">

<?php include "includes/db.php"  ?>
<?php include "includes/header.php"  ?>
<!-- Navigation -->

<?php include "includes/navigation.php"  ?>


<?php

if (isset($_POST['liked'])) {

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //1 =  FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    // 2 = UPDATE - INCREMENTING WITH LIKES

    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");

    // 3 = CREATE LIKES FOR POST

    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
    exit();
}

if (isset($_POST['unliked'])) {

    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];

    //1 =  FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];

    //2 = DELETE LIKES

    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");


    //3 = UPDATE WITH DECREMENTING WITH LIKES

    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");

    exit();
}

?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if (isset($_GET['p_id'])) {

                $the_post_id = $_GET['p_id'];


                $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = '{$the_post_id}' ";
                $send_query = mysqli_query($connection, $view_query);


                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {

                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
                } else {
                    $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
                }

                $select_all_postss_query = mysqli_query($connection, $query);


                if (mysqli_num_rows($select_all_postss_query) < 1) {

                    echo "<h1>No PostS</h1>";
                } else {



                    while ($row = mysqli_fetch_assoc($select_all_postss_query)) {
                        $post_title = $row['post_title'];
                        $post_content = $row['post_content'];
                        $post_image = $row['post_image'];
                        $post_date = $row['post_date'];
                        $post_author = $row['post_user'];


            ?>


                        <h1 class="page-header">
                            Posts

                        </h1>

                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title ?></a>
                        </h2>
                        <p class="lead">
                            All Post by <a href="index.php"><?php echo $post_author ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content ?></p>

                        <hr>
                        <?php

                        if (isLoggedIn()) { ?>


                            <div class="row">
                                <p class="pull-right"><a class="<?php echo userlikthispost($the_post_id) ? 'unliked' : 'liked'; ?>" href=""><span class="glyphicon glyphicon-thumbs-up" data-toggle="tooltip" data-placement="top" title="<?php echo userlikthispost($the_post_id) ? ' I liked this before' : 'Want to like it?'; ?>"></span>
                                        <?php echo userlikthispost($the_post_id) ? ' Unlike' : ' Like'; ?>




                                    </a></p>
                            </div>


                        <?php  } else { ?>

                            <div class="row">
                                <p class="pull-right login-to-post">You need to <a href="/cms/registration.php">Login</a> to like </p>
                            </div>


                        <?php }


                        ?> <div class="row">
                            <p class="pull-right likes">Like: <?php getpotlike($the_post_id); ?></p>
                        </div>

                        <div class="clearfix"></div>




                    <?php }






                    ?>



                    <!-- Blog Comments -->

                    <?php
                    if (isset($_POST['create_comment'])) {
                        // echo $_POST['comment_author'];

                        $the_post_id = $_GET['p_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = $_POST['comment_content'];

                        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {


                            $query = "INSERT INTO comments (comment_post_id,comment_author,comment_email,comment_content,comment_status,comment_date)";
                            $query .= " VALUES ($the_post_id,'$comment_author','$comment_email','$comment_content','unapprove',now())";


                            $create_comment_query = mysqli_query($connection, $query);







                            // $query="UPDATE posts SET post_comment_count= post_comment_count +1";
                            // $query .= " WHERE post_id=$the_post_id";
                            // $query_post_count=mysqli_query($connection,$query);
                        } else {
                            echo "<script>alert('Field cannot be empty')</script>";
                        }
                    }


                    ?>




                    <!-- Comments Form -->
                    <div class="well">
                        <h4>Leave a Comment:</h4>
                        <form action="" method="post" role="form">
                            <div class="form-group">
                                <label for="Author">Author</label>
                                <input type="text" name="comment_author">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" name="comment_email">
                            </div>
                            <div class="form-group">
                                <label for="comment">Your Comment</label>
                                <textarea name="comment_content" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                    <hr>

                    <!-- Posted Comments -->
                    <?php
                    $query = "SELECT * FROM  comments WHERE comment_post_id = $the_post_id";
                    $query .= " AND comment_status = 'approved'";
                    $query .= " ORDER BY comment_id DESC";
                    $select_posts = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_posts)) {
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
                                <h4 class="media-heading"><?php echo $comment_author ?>
                                    <small><?php echo $comment_date ?></small>
                                </h4>
                                <?php echo $comment_content ?>
                            </div>
                        </div>


            <?php
                    }
                }
            } else {
                header("location: index.php");
            }

            ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"  ?>

        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"  ?>

        <script>
            $(document).ready(function() {
                $("[data-toggle='tooltip']").tooltip();
                var post_id = <?php echo $the_post_id; ?>;
                var user_id = <?php echo loginuserid(); ?>;
                $('.liked').click(function() {
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });
                //unlike

                $('.unliked').click(function() {
                    $.ajax({
                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: 'post',
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id
                        }
                    });
                });
            });
        </script>