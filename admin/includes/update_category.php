<form action="" method="post">
  <div class="form-group">
    <label for="cat_title">Edit Category</label>


    <?php
    if (isset($_GET['update'])) {
      $cat_id = $_GET['update'];

      $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
      $update_query = mysqli_query($connection, $query);

      while ($row = mysqli_fetch_assoc($update_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];


    ?>


        <input value=<?php if (isset($cat_title)) {
                        echo $cat_title;
                      } ?> class="form-control" type="text" name="cat_title">
    <?php }
    } ?>

    <?php
    if (isset($_POST['update_category'])) {
      $the_cat_title = $_POST['cat_title'];

      $query = "UPDATE  categories SET cat_title='$the_cat_title' WHERE cat_id= {$cat_id}";
      $update_query = mysqli_query($connection, $query);

      if (!$update_query) {
        die("Error updating category" . mysqli_error($connection));
      }
    }


    ?>

  </div>

  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_category" value="Update_Category">
  </div>
</form>