<?php

if(isset($_GET['edit_user'])){
  $the_user_id =  $_GET['edit_user'];


  $query = "SELECT * FROM  users WHERE user_id = $the_user_id";
  $select_users = mysqli_query($connection, $query);

  while ($row = mysqli_fetch_assoc($select_users)) {
      $user_id = $row['user_id'];
      $username = $row['username'];
      $user_password=$row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname = $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];
  }




if (isset($_POST['edit_user'])){
    //this for traying the create_post action if it exists;
   
   //echo $user_firstname = $_POST['user_firstname'];
                                    
                                    $user_firstname = $_POST['user_firstname']; 
                                    

                                    $user_lastname = $_POST['user_lastname'];
                                    $user_role = $_POST['user_role'];
                                    $username = $_POST['username'];
                                    $user_email = $_POST['user_email'];
                                    
                                    // $post_image = $_FILES['Image']['name'];
                                    //this for know in which plce my images
                                    // $post_image_temp = $_FILES['Image']['tmp_name'];

                                   
                                   
                                    $user_password =$_POST['user_password'];  
                                    

                                    if(!empty($user_password)){

                                        $query_password="SELECT user_password FROM users WHERE user_id = $the_user_id ";
                                        $get_user=mysqli_query($connection,$query_password);

                                        $row=mysqli_fetch_array($get_user);
                                        $db_user_password=$row['user_password'];
                                    
                                    if($db_user_password != $user_password){

                                        $hashed_password=password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 12));
                                    }
                                    

                                    $query="UPDATE users SET ";
                                    $query .="user_firstname ='{$user_firstname}', ";
                                    $query .="user_lastname ='{$user_lastname}', ";
                                    $query .="user_role ='{$user_role}', ";
                                    $query .="username ='{$username}', ";
                                    $query .="user_email ='{$user_email}', ";
                                    $query .="user_password ='{$hashed_password}' ";
                                   
                                    $query .= "WHERE user_id  = $the_user_id";
                                
                                
                                    $update_user=mysqli_query($connection,$query);
                                
                                
                                    // confirmQuery($update_user);
                                }}


                            }else{

                                header("location: index.php");

 
                            }
                                    ?>
                                















<form action="" method="POST" enctype="multipart/form-data">



<div class="form_group">
        <label for="title">Firstname</label>
        <input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname">
    </div>
    <hr>
    <div class="form_group">
        <label for="post_Status">Lastname</label>
        <input type="text"  value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname">
    </div>
    <hr> 
    <div class="form_group">
       
       <select name="user_role" id="">

      <option value="<?php echo $user_role;  ?>" ><?php echo $user_role;  ?></option>

      <?php
      
      if($user_role == 'admin'){
        echo "<option value='subscriber'>subscriber</option>";
      }else{
        echo "<option value='admin'>admin</option>";
      }
      
      
      ?>



   

   
  
   
   
  <hr>
       </select>
       <hr>

   
    <!-- <div class="form_group">
        <label for="post_Image">Post Image</label>
        <input type="file" name="Image">
    </div>
    <hr> -->
    <div class="form_group">
        <label for="post_Tags">username</label>
        <input type="text" value="<?php echo $username ?>" class="form-control" name="username">
    </div>
    <hr>

    <div class="form_group">
        <label for="post_Tags">Email</label>
        <input type="email" value="<?php echo $user_email ?>" class="form-control" name="user_email">
    </div>
    <hr>
    <div class="form_group">
        <label for="post_Content">Password</label>
        <input type="text" autocomplete="off" class="form-control" name="user_password">

    </div>
    <hr>
    <div class="form_group">

        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>