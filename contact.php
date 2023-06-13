<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

<?php 

if(isset($_POST['submit'])){
    


$to="Alimkzsulaiman@gmail.com";
$subject=wordwrap($_POST['subject'],70);
$body=$_POST['body'];
$header="From".$_POST['email'];

mail($to,$subject,$body,$header);
}





?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3" style="margin-top: 100px;">
                <div class="form-wrap">
                <h1>contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6  class='alert alert-success'><?php // echo $message; ?></h6>
                     
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                        <div>
                            <textarea class="form-control"name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
