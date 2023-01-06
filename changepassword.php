<?php
include 'api/config.data';

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:/login.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $TITLE; ?> | Change Password</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->

        <?php include 'logo.php'; ?>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="logout.php"><i class="fa fa-sign-out"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['name']; ?></p>
                    <p><?php echo $_SESSION['email']; ?></p>
                </div>
            </div>


            <!-- Sidebar Menu -->
           <?php include 'sidebar.php'; ?>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <div class="content-wrapper">
        <section class="content container-fluid">
            <?php

            if (isset($_POST['submit'])) {
                $password = mysqli_real_escape_string($conn, $_POST['password']);
                $confirmpassword = mysqli_real_escape_string($conn, $_POST['confirmpassword']);
                $id = $_SESSION['id'];
                if (!empty($password) && !empty($confirmpassword)) {
                    if ($password == $confirmpassword) {
                        $password = md5($password);
                        $sql = "update users set password = '$password' where id = '$id'";
                        if (mysqli_query($conn, $sql)) {
                            echo "<div class=\"alert alert-success\" role=\"alert\">Password updated.</div>";
                        } else {
                            echo "<div class=\"alert alert-warning\" role=\"alert\">
                      Please try again
                    </div>";
                        }
                    } else {
                        echo "<div class=\"alert alert-warning\" role=\"alert\">
                      Password not match.
                    </div>";
                    }
                } else {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">
                      Please Fill All The Input Field
                    </div>";
                }
            }

            ?>


            <div class="row">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Change Password</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="" method="post">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="exampleInputPassword1">New Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                           placeholder="Enter password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword2">Confirm Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword2"
                                           placeholder="Enter password" name="confirmpassword" required>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
    </footer>

</div>
<!-- ./wrapper -->


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>