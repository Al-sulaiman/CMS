<?php
include("delete_modal.php");
?>

<?php
if(isset($_POST['checkboxArray'])){
 
    foreach($_POST['checkboxArray'] as $postvalueid){

      //  echo $postvalueid;
     $bulk_options=$_POST['bulk_options'];

  switch($bulk_options){
    case 'published';

  
    $query="UPDATE posts SET post_status= '{$bulk_options}' WHERE  post_id = {$postvalueid} ";
    $update_status_to_pub=mysqli_query($connection,$query);

    break;


    case 'draft';

  
    $query="UPDATE posts SET post_status= '{$bulk_options}' WHERE  post_id = {$postvalueid} ";
    $update_status_to_draft=mysqli_query($connection,$query);

    break;

    case 'delete';

  
    $query="DELETE FROM posts WHERE post_id = {$postvalueid} ";
    $update_status_to_delete=mysqli_query($connection,$query);

    break;

    case 'clone':

        
$query = "SELECT * FROM posts WHERE post_id = {$postvalueid} ";
$select_posts = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_posts)) {
   
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
  
    $post_date = $row['post_date'];
    $post_user = $row['post_user'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_content=$row['post_content'];

    $query="INSERT INTO posts(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status)";
    $query .="VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";


    $query_create_post=mysqli_query($connection,$query);



}
break;
  }

    }
}

?>


<form action="" method="post">
<table class="table table-bordered table-hover">


<div class="row">
    <div class="col-xs-6">
        <div  class="id bulkOptionsContainer">
            <select class="form-control" name="bulk_options" id="">
                <hr>
                <option value="">Select option</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="actions-container">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_posts">Add New One</a>
        </div>
    </div>
</div>
<hr>
             <thead>
                                <tr>
                                    <th><input id="checkallBoxes" name="bulk_options" type="checkbox"></th>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Users</th>
                                    <th>category</th>
                                    <th>comments</th>
                                    <th>tags</th>
                                    <th>image</th>
                                    <th>date</th>
                                    <th>status</th>
                                    <th>View post</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Views</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                                $select_posts = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($select_posts)) {
                                    $post_id = $row['post_id'];
                                    $post_title = $row['post_title'];
                                    $post_author = $row['post_author'];
                                    $post_user = $row['post_user'];
                                    $post_category = $row['post_category_id'];
                                    $post_comment_count = $row['post_comment_count'];
                                    $post_tags = $row['post_tags'];
                                    $post_image = $row['post_image'];
                                    $post_date = $row['post_date'];
                                    $post_status = $row['post_status'];
                                    $post_views_count = $row['post_views_count'];
                                    // $post_content=$row['post_content'];


                                  
     
                                echo  "<tr>";
                                ?>
                            <td><input class="checkBoxes" name=checkboxArray[] type="checkbox" value='<?php echo $post_id ?>'></td>
                                <?php
                                echo  "<td> $post_id</td>";

                                
                                echo  "<td>$post_title</td>";
                                
                                if(!empty($post_author)){
                                
                                
                                echo  "<td>$post_author</td>";
                                }
                                elseif(!empty($post_user)){

                                 echo "<td>$post_user</td>";   
                                }

                              ////////relating categoreies to post and displaying it
                                $query = "SELECT * FROM categories  WHERE cat_id = $post_category";
                                $select_categories = mysqli_query($connection, $query);
                                
                                while ($row = mysqli_fetch_assoc($select_categories)) {
                                $cat_id = $row['cat_id'];
                                $cat_title = $row['cat_title'];
                                echo  "<td>$cat_title</td>";
                              }
///////this is true but its give me warning in output
                            //  $query="SELECT * FROM comments WHERE comment_post_id = $post_id";
                            //  $send_comment_query=mysqli_query($connection,$query);

                            //  $row=mysqli_fetch_array($send_comment_query);
                            //  $comment_id=$row['comment_id'];
                            //  $count_comments=mysqli_num_rows($send_comment_query);

                            //     echo  "<td><a href='post_comment.php?id=$post_id'>$count_comments</a></td>";
/////this code from chatgpt
                            $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                            $send_comment_query = mysqli_query($connection, $query);
                            
                            $count_comments = mysqli_num_rows($send_comment_query);
                            
                            if ($count_comments > 0) {
                                $row = mysqli_fetch_array($send_comment_query);
                                $comment_id = $row['comment_id'] ?? 0; // Use the null coalescing operator to assign 0 if the value is null
                            } else {
                                $comment_id = 0; // Set a default value if no comments exist
                            }
                            
                            echo "<td><a href='post_comment.php?id=$post_id'>$count_comments</a></td>";
                            



                                echo  "<td>$post_tags</td>";
                                echo  "<td><img width='50' src='../images/'$post_image'></td>";
                                echo  "<td>$post_date</td>";
                                echo  "<td>$post_status</td>";
                                
                                echo  "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View post</td>";
                                echo  "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</td>";


                                ?>
                                <form method="POST">
                                    <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
<?php 
                                //  echo  "<td><input  class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";

                                 ?>
                                </form>
                                <?php
                               echo  "<td><a rel='$post_id' href='javascript:void(0)' class='delete-link'>Delete</a></td>";
                                // echo  "<td><a onClick=\"javascript: return confirm('Are Sure You Want To Delete');\" href='posts.php?delete={$post_id}'>Delete</td>";
                                echo "<td><a href='posts.php?reset={$post_id}'>$post_views_count</a></td>";
                                echo  "</tr>"; 
                               
                               
                               
                               
                               
                               
                               
                               
                               
                               
                                }

                                ?>
                                
                                
                            </tbody>
                        </table>
                        </form>

                        <?php
                        
                        if(isset($_GET['delete'])){

                            $the_post_id = $_GET['delete'];

                            $delete_query = "DELETE  FROM posts WHERE post_id= '$the_post_id'";
                            $send_delete_query = mysqli_query($connection, $delete_query);
                            header("location: posts.php");

                        }
                        if(isset($_GET['reset'])){

                            $the_post_id = $_GET['reset'];

                            $query = "UPDATE posts SET post_views_count=0 WHERE post_id= $the_post_id";
                            $reset_query = mysqli_query($connection, $query);
                            header("location: posts.php");

                        }
                        
                        
                        
                        ?>

                        <script>


$(document).ready(function() {

    $(".delete-link").on('click', function(){
        var id=$(this).attr("rel");
        var delete_url= "posts.php?delete="+ id +" ";

        $(".modal-delete").attr("href", delete_url);

        $("#myModal").modal("show");
    });

});
                       

                        </script>