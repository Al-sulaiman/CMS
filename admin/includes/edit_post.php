
<?php 

if(isset($_GET['p_id'])){
//   echo $_GET['p_id'];
 $the_post_id=$_GET['p_id'];
}


$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_user = $row['post_user'];
    $post_category = $row['post_category_id'];
    $post_comment = $row['post_comment_count'];
    $post_tags = $row['post_tags'];
    $post_content=$row['post_content'];

    $post_image = $row['post_image'];
    $post_date = $row['post_date'];
    $post_status = $row['post_status'];


}



if(isset($_POST['update_post'])){

    // echo "hello";
   
   
    $post_user = $_POST['post_user'];
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    
    $post_image = $_FILES['image']['name'];
    //this for know in which plce my images
    $post_image_temp = $_FILES['image']['tmp_name'];
  
    $post_content =$_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    
    
    move_uploaded_file($post_image_temp,"../images/$post_image");

    if(empty($post_image)){

        $query="SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image=mysqli_query($connection,$query);


        confirmQuery($select_image);

        while ($row = mysqli_fetch_assoc($select_image)) {
            $post_image=$row['post_image'];
        }
    }
                                    

    $query="UPDATE posts SET ";
    $query .="post_title ='{$post_title}',";
    $query .="post_category_id ='{$post_category_id}',";
    $query .="post_date = now(),";
    $query .="post_user ='{$post_user}',";
    $query .="post_status ='{$post_status}',";
    $query .="post_tags ='{$post_tags}',";
    $query .="post_content ='{$post_content}',";
    $query .="post_image ='{$post_image}' ";
    $query .= " WHERE post_id  = {$the_post_id} ";


    $update_post=mysqli_query($connection,$query);


    confirmQuery($update_post);
    echo "<div class='alert alert-success'>Posts Updated: <a href='../post.php?p_id=$the_post_id' class='btn btn-primary'>View Posts</a></div>";
}
    ?>


















<form action="" method="POST" enctype="multipart/form-data">



    <div class="form_group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" value="<?php echo $post_title ?>" name="post_title">
    </div>
<hr>
    <div class="form_group">
       <label for="category">Category</label>
    <select name="post_category" id="post_category">

<?php 


$query = "SELECT * FROM categories ";
$select_category = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_category)) {
  $cat_id = $row['cat_id'];
  $cat_title = $row['cat_title'];

  confirmQuery($select_category);

  echo "<option value='{$cat_id}'>{$cat_title}</option>";


}





?>



    </select>


    <hr>
    </div>

    <!-- <div class="form_group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control"  value="<?php echo $post_user ?>" name="post_user">
    </div>
    <hr> -->
    <div class="form_group">
        <label for="users">Users</label>
       
       <select name="post_user" id="post_user">
   <?php   echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
   <?php 
   
   
   $query = "SELECT * FROM users ";
   $select_users = mysqli_query($connection, $query);
   
   while ($row = mysqli_fetch_assoc($select_users)) {
     $user_id = $row['user_id'];
     $username = $row['username'];
   
     confirmQuery($select_users);
   
     echo "<option value='{$username}'>{$username}</option>";
   
   
   }
   
   
   
   
   
   ?>
   
   
   
       </select>

<hr>
    <div class="form_group">
        <label for="Status">Status</label>
        <!-- <label for="post_Status">Post Status</label> -->
        
       <select name="post_status" id="">
       <option value='<?php echo $post_status ?>'><?php echo $post_status; ?></option>

       <?php
          
          if($post_status == 'published' ) {
          
              
    echo "<option value='draft'>Draft</option>";
          
          
          } else {
          
          
    echo "<option value='published'>Publish</option>";
          
          
          }
              
              
              
        ?>
       </select>
    </div>


    <hr>
    <div class="form_group">
    <input type="file" name="image">
     <img  width="100"  src="../images/<?php echo $post_image; ?>" alt="image">
    </div>
    <hr>

    <div class="form_group">
        <label for="post_Tags">Post Tags</label>
        <input type="text" class="form-control"  value="<?php echo $post_tags ?>" name="post_tags">
    </div>
    <hr>
    <div class="form_group">
        <label for="summernote">Post Content</label>
        <textarea name="post_content" class="form-control" id="summernote" cols="30" rows="10"> <?php echo $post_content ?></textarea>
       
    </div>
    <hr>
    <div class="form_group">

        <input type="submit" class="btn btn-primary" name="update_post" value="Update post">
    </div>

</form>
