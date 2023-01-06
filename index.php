<?php
include 'api/config.data';

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:login.php');
    exit();
}

$id = $_SESSION['id'];

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $TITLE; ?> | Dashboard</title>
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
                        <a href="../logout.php"><i class="fa fa-sign-out"></i></a>
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">

				<?php 

                // $show_query = "SELECT id,name,email,phone,status FROM qr_user where id <> '$id' order by name";
                // $result = mysqli_query($conn, $show_query);
                // $check = mysqli_num_rows($result);
                // if ($check > 0) {
                //     while ($row = mysqli_fetch_assoc($result)) {
                //         $users[] = $row;
                //     }
                // }

                $sql = "SELECT count(name) as totaluser from users where status = 1";
                $totaluser = mysqli_query($conn, $sql)->fetch_assoc()['totaluser'];

                // $sql = "SELECT count(id) as totalevent from qr_event";
                // $totalevent = mysqli_query($conn, $sql)->fetch_assoc()['totalevent'];

                // $sql = "SELECT count(id) as totalguest from qr_guests";
                // $totalguest = mysqli_query($conn, $sql)->fetch_assoc()['totalguest'];

                $sql = "SELECT IFNULL(count(id),0) as totalnoofscan from scanlog";
                $totalnoofscan = mysqli_query($conn, $sql)->fetch_assoc()['totalnoofscan'];	

                ?>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        <h3><?php echo $totaluser; ?></h3>

                        <p>App Users</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                        <h3><?php echo $totalnoofscan; ?></h3>

                        <p>Total no of scan</p>
                        </div>
                        <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                        </div>
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