<?php include "includes/admin_header.php" ?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcom to admin
                            <small>author</small>

                        </h1>




                        <div class="col-xs-6">


                            <?php
                            insert_categories();
                            ?>



                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>

                            </form>



                            <?php
                            //update and include
                            if (isset($_GET['update'])) {
                                $cat_id = $_GET['update'];

                                include "includes/update_category.php";
                            }


                            ?>
                        </div>


                        <div class="col-xs-6">

                            <table class="table table-bordered table-hover ">

                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php // find all categories
                                    findall_categories();

                                    ?>

                                    <?php //delete category
                                    delete_categories();

                                    ?>



                                </tbody>
                            </table>
                        </div>








                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include "includes/admin_footer.php" ?>