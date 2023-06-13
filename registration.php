<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

<?php 

if(isset($_GET['lang']) && !empty($_GET['lang'])){

  $_SESSION['lang'] = $_GET['lang'];

  if(isset($_SESSION['lang']) && $_SESSION['lang'] !=$_GET['lang']){


    echo "<script type='text/javascript'>location.reload();</script>";
  }
}
  if(isset($_SESSION['lang'])){

    include "includes/language/" . $_SESSION['lang'] .".php"; 
  }else{
    include "includes/language/en.php"; 
  }



// if(isset($_POST['submit'])){

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    $error=[

        'username'=> '',
        'email'=> '',
        'password'=> ''
    ];
      if(strlen($username) <4){
        $error['username'] = 'username required more than 4 characters';
      }

      if($username == ''){
        $error['username'] = 'can not be empty';
      }

      if(username_exits($username)){
        $error['username'] = 'username already exists';

      }

      if($email == ''){
        $error['email'] = 'can not be empty';
      }

      if(email_exits($username)){
        $error['email'] = 'email already exists ,<a href="index.php">Please log in</a>';
        
      }

      if($password == ''){
        $error['password'] = 'can not be empty';
      }


      foreach($error as $key => $value){

        if(empty($value)){

            unset($error[$key]);
            
           
        }}

        if(empty($error)){

            reigster_user($username,$email,$password);

            login_user($username,$password);
        }
}






?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">

    <form class="navbar-form navbar-right" method="get" action="" id="language_form">
      <select name="lang"  class="form-control" onchange="changelang()" >
        <option value="en" <?php  if(isset($_SESSION['lang']) && $_SESSION['lang'] =='en'){ echo "selected"; } ?>>English</option>
        <option value="es"<?php  if(isset($_SESSION['lang']) && $_SESSION['lang'] =='es'){ echo "selected"; } ?>>Spanish</option>
      </select>
    </form>
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3" style="margin-top: 100px;">
                <div class="form-wrap">
                <h1><?php echo _REGISTER; ?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                     
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME; ?>" autocomplete="on">
                            <p><?php  echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL; ?>">

                            <p><?php  echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD; ?>">
                            <p><?php  echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>


<script>

function changelang(){

  document.getElementById('language_form').submit()
}


</script>