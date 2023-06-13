<?php

if (isset($_POST['create_user'])) {
    //this for traying the create_post action if it exists;

    //echo $user_firstname = $_POST['user_firstname'];

    $user_firstname = $_POST['user_firstname'];


    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];

    $user_password = $_POST['user_password'];

    $user_password=password_hash($user_password,PASSWORD_BCRYPT,array('cost' => 10));

    $query = "INSERT INTO users(username,user_password,user_firstname,user_lastname,user_role,user_email)";
    $query .= "VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_role}','{$user_email}')";


    $query_create_user = mysqli_query($connection, $query);


    confirmQuery($query_create_user);
    echo "<div class='alert alert-success'>Successfully created: <a href='users.php' class='btn btn-primary'>View Users</a></div>";
}






?>







<form action="" method="POST" enctype="multipart/form-data">



    <div class="form_group">
        <label for="title">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <hr>
    <div class="form_group">
        <label for="post_Status">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <hr>
    <div class="form_group">

        <select name="user_role" id="user_role">

            <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>





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
            <input type="text" class="form-control" name="username">
        </div>
        <hr>

        <div class="form_group">
            <label for="post_Tags">Email</label>
            <input type="email" class="form-control" name="user_email">
        </div>
        <hr>
        <div class="form_group">
            <label for="post_Content">Password</label>
            <input type="text" class="form-control" name="user_password">

        </div>
        <hr>
        <div class="form_group">

            <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
        </div>

</form>