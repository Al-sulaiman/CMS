
<?php include "db.php"; ?>
<?php include "../admin/function.php"; ?>
<?php session_start(); ?>

<?php
if(isset($_POST['login'])){
    login_user($_POST['username'],$_POST['password']);

}



