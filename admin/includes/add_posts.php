<?php

if (isset($_POST['create_post'])){
    //this for traying the create_post action if it exists;
   // echo $_POST['title'];

                                    
                                    $post_title = $_POST['post_title'];
                                    $post_category_id = $_POST['post_category'];
                                    $post_user = $_POST['post_user'];
                                    $post_status = $_POST['post_status'];
                                    
                                    $post_image = $_FILES['Image']['name'];
                                    //this for know in which plce my images
                                    $post_image_temp = $_FILES['Image']['tmp_name'];

                                   
                                    $post_tags = $_POST['post_tags'];
                                    $post_content =$_POST['post_content'];  
                                    $post_date = date('d-m-y');
                                    // $post_comment_count=4;

                               //////////////// this to remove my image from current location to my htdocs images folder
                                    move_uploaded_file($post_image_temp,"../images/$post_image");
                                    


                                    $query="INSERT INTO posts(post_category_id,post_title,post_user,post_date,post_image,post_content,post_tags,post_status)";
                                    $query .="VALUES({$post_category_id},'{$post_title}','{$post_user}',now(),'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";


                                    $query_create_post=mysqli_query($connection,$query);


                                    confirmQuery($query_create_post);


                                    echo "<div class='alert alert-success'>Successfully adeed: <a href='posts.php' class='btn btn-primary'>View Posts</a></div>";

}






?>







<form action="" method="POST" enctype="multipart/form-data">



    <div class="form_group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
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

       <div class="form_group">
        <label for="users">Users</label>
       
       <select name="post_user" id="post_user">
   
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

    <!-- <div class="form_group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="post_author">
    </div>
    <hr> -->
    <div class="form_group">
        
        <select name="post_status" id="">
            <option value="draft">Post Status</option>
            <option value="published">Published</option>
            <option value="draft">Draft</option>
        </select>
        
    </div>
    <hr> 
    <div class="form_group">
        <label for="post_Image">Post Image</label>
        <input type="file" name="Image">
    </div>
    <hr>

    <div class="form_group">
        <label for="post_Tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <hr>
    <div class="form_group">
        <label for="summernote">Post Content</label>
        <textarea name="post_content" class="form-control" id="summernote" cols="30" rows="10"></textarea>

    </div>
    <hr>
    <div class="form_group">

        <input type="submit" class="btn btn-primary" name="create_post" value="publish post">
    </div>

</form>