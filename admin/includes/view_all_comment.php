<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>author</th>
            <th>comment</th>

            <th>Email</th>
            <th>Status</th>

            <th>In Response To</th>
            <th>Date</th>

            <th>Apperove</th>
            <th>Unapprove</th>
            <th>Delete</th>

        </tr>
    </thead>
    <tbody>
        <?php

        $query = "SELECT * FROM  comments";
        $select_posts = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_posts)) {
            $comment_id = $row['comment_id'];
            $comment_post_id = $row['comment_post_id'];
            $comment_author = $row['comment_author'];
            $comment_content = $row['comment_content'];
            $comment_email = $row['comment_email'];

            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];

            // $post_content=$row['post_content'];




            echo  "<tr>";
            echo  "<td> $comment_id</td>";
            echo  "<td>$comment_author</td>";
            echo  "<td>$comment_content</td>";

           
            echo  "<td>$comment_email</td>";
            echo  "<td>$comment_status</td>";

            //this fuction to bring the name of post and put it inside (in response to)
            $query = "SELECT * FROM  posts  WHERE post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_post_id_query)) {

                $post_id = $row['post_id'];
                $post_title = $row['post_title'];

                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
            }


            echo  "<td>$comment_date</td>";



            echo  "<td><a href='comment.php?approve=$comment_id'>Approve</td>";
            echo  "<td><a href='comment.php?unapprove=$comment_id'>Unapprove</td>";

            echo  "<td><a href='comment.php?delete={$comment_id}'>Delete</td>";
            // echo  "<td><a href='posts.php?source=edit_post&p_id={}'>Edit</td>";
            echo  "</tr>";
        }

        ?>


    </tbody>
</table>


<?php

if (isset($_GET['approve'])) {

    $the_comment_id = $_GET['approve'];

    $query = "UPDATE comments SET comment_status='Approved' WHERE comment_id= $the_comment_id";
    $approve_query = mysqli_query($connection, $query);
    //this is for refreshing page
    header("location: comment.php");
}


if (isset($_GET['unapprove'])) {

    $the_comment_id = $_GET['unapprove'];

    $query = "UPDATE comments SET comment_status='Unapproved' WHERE comment_id= $the_comment_id";
    $unapprove_query = mysqli_query($connection, $query);
    //this is for refreshing page
    header("location: comment.php");
}










if (isset($_GET['delete'])) {

    $the_comment_id = $_GET['delete'];

    $query = "DELETE FROM comments WHERE comment_id= $the_comment_id";
    $delete_query = mysqli_query($connection, $query);
    //this is for refreshing page
    header("location:comment.php");
}


?>