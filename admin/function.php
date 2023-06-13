<?php


//===== DATABASE HELPER FUNCTIONS =====//

function redirect($location){


    header("Location:" . $location);
    exit;

}

function query($query){
    global $connection;
    $result=mysqli_query($connection,$query);
    return $result;
} 

function fetchrecord($result){
   
    return mysqli_fetch_array($result);
}

function count_records($result){
    return mysqli_num_rows($result);
}
//===== END DATABASE HELPERS =====//

 function isLoggedIn(){

        if(isset($_SESSION['user_role'])){
    
            return true;
    
    
        }
    
    
       return false;
    
    }


function loginuserid(){
    if(IsLoggedIn()){
        $result=query("SELECT * FROM users WHERE username='" .$_SESSION['username']. "'");
        $user=fetchrecord($result);
        if(mysqli_num_rows($result) >= 1){
            return $user['user_id'];


        }
    }
    return false;
}   

function userlikthispost($post_id=''){
    $result=query("SELECT * FROM likes WHERE user_id =" .loginuserid()." AND post_id ={$post_id}");
    return mysqli_num_rows($result) >=1 ? true : false;

}
function getpotlike($post_id){

    $result=query("SELECT * FROM likes WHERE post_id=$post_id");
    echo mysqli_num_rows($result);

}

function confirmQuery($result)
{
    global $connection;

    if (!$result) {

        die("QUERY Failed" . mysqli_error($connection));
    }
}

function users_online()
{

    if (isset($_GET['onlineusers'])) {

        global $connection;
        if (!$connection) {

            session_start();
            include("../includes/db.php");

            $session = session_id();
            $time = time();
            $time_out_in_sec = 05;
            $time_out = $time - $time_out_in_sec;

            $query = "SELECT * FROM users_online WHERE session='$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session,time) VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session='$session'");
            }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time >'$time_out'");
            echo $count_users = mysqli_num_rows($users_online_query);
        }
    }
}
users_online();

function insert_categories()
{

    global $connection;

    if (isset($_POST['submit'])) {
        //    echo  $cat_title=$_POST['cat_title'];
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "this field should not be empty";
        } else {

            $query = "INSERT INTO categories(cat_title)";
            $query .= " VALUES ('{$cat_title}')";
            $create_category = mysqli_query($connection, $query);

            if (!$create_category) {
                die("Couldn't create category" . mysqli_error($connection));
            }
        }
    }
}

function findall_categories()
{

    global $connection;


    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];


        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?update={$cat_id}'>Update</a></td>";
        echo "</tr>";
    }
}


function delete_categories()
{


    global $connection;

    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id= $the_cat_id";
        $delete_query = mysqli_query($connection, $query);
        //here to when click delete button delete it directly without refreshing the page
        header("location:categories.php");
    }
}

//===== AUTHENTICATION HELPERS =====//
function is_admin()
{
    global $connection;

    if(isLoggedIn()){
        $query = "SELECT user_role FROM users WHERE user_id =".$_SESSION['user_id']."";
        $result = mysqli_query($connection, $query);
    
        $row = fetchrecord($result);
        if ($row['user_role'] == 'admin') {
    
            return true;
        } else {
    
            return false;
        }



    }
    return false;
   
}
//===== END AUTHENTICATION HELPERS =====//

//===== USER SPECIFIC HELPERS=====//
function get_all_user_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loginuserid()."");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loginuserid()."");

}
function get_all_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loginuserid()."");
}
function get_all_user_published_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loginuserid()." AND post_status='published'");
}

function get_all_user_draft_posts(){
    return query("SELECT * FROM posts WHERE user_id=".loginuserid()." AND post_status='draft'");
}

function get_all_user_approved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loginuserid()." AND comment_status='approved'");
}




function get_all_user_unapproved_posts_comments(){
    return query("SELECT * FROM posts
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loginuserid()." AND comment_status='unapproved'");
}

//===== END USER SPECIFIC HELPERS=====//
function username_exits($username)
{
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);



    if (mysqli_num_rows($result) > 0) {

        return true;
    } else {
        return false;
    }
}

function email_exits($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);



    if (mysqli_num_rows($result) > 0) {

        return true;
    } else {
        return false;
    }
}


function reigster_user($username, $email, $password)
{
    global $connection;




   




        $username = mysqli_real_escape_string($connection, $username);
        $email = mysqli_real_escape_string($connection, $email);
        $password = mysqli_real_escape_string($connection, $password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));


        $query = "INSERT INTO users(username,user_email,user_password,user_role) ";
        $query .= "VALUES('{$username}','{$email}','{$password}','subscriber')";


        $register_user_query = mysqli_query($connection, $query);
        if (!$register_user_query) {
            die("Could not connect to the database server " . mysqli_error($connection));
        }
        //$message="your form has been submitted";


    }


function login_user($username, $password)
{

    global $connection;

   


    $username =mysqli_escape_string($connection, $username);
    $password = mysqli_escape_string($connection, $password);


    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {
        echo "Error " . mysqli_error($connection);
    }


    while ($row = mysqli_fetch_array($select_user_query)) {

         $db_id = $row['user_id'];
         $db_username = $row['username'];
          $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
          $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];
    
       
    
      }  
      if (password_verify($password, $db_user_password)) {
        $_SESSION['user_id']=$db_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

       header("location: ../admin");
    }
    else
     {
        header("include: ../index.php");
    }
    
   
   

}
?>