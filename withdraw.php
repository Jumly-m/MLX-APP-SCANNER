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
                Withdraw Request
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">

                <?php 

                $show_query = "SELECT reqwithdraw.*,users.coin FROM reqwithdraw inner JOIN users on users.id = reqwithdraw.userid where reqwithdraw.status = 0";
                $result = mysqli_query($conn, $show_query);
                $check = mysqli_num_rows($result);
                if ($check > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $requests[] = $row;
                    }
                }

                ?>



                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Balance</th>
                                    <th>Withdraw Amount</th>
                                    <th>Request Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                if ($check > 0) {
                                    foreach ($requests as $request) { ?>
                                        <tr>
                                            <td><?php echo $request['name']; ?></td>
                                            <td><?php echo $request['address']; ?></td>
                                            <td><?php echo $request['coin']; ?></td>
                                            <td><?php echo $request['amount']; ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($request['created_at'])); ?></td>
                                            
                                            
                                            <td><?php 
                                                $status = $request['status'];
                                                if ($status == 0){
                                                    echo "Processing";
                                                } else if ($status == 1){
                                                    echo "Approved";
                                                } else {
                                                    echo "Rejected";
                                                }
                                            ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success approve" data-id="<?=$request['id'];?>"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-sm btn-danger reject" data-id="<?=$request['id'];?>"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>


                                </tbody>

                            </table>
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

<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.3/bootbox.min.js" integrity="sha512-U3Q2T60uOxOgtAmm9VEtC3SKGt9ucRbvZ+U3ac/wtvNC+K21Id2dNHzRUC7Z4Rs6dzqgXKr+pCRxx5CyOsnUzg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function () {
        $('#example1').DataTable()
    })

    $(document).on("click", ".approve", function() { 
        var deleteid =  $(this).attr("data-id")
        var $ele = $(this).parent().parent();
        bootbox.confirm("Are you sure want to approve the request?", function(result) {
            if(result){
                $.ajax({
                    url: "approve.php",
                    type: "POST",
                    cache: false,
                    data:{
                        id: deleteid
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });

    
    $(document).on("click", ".reject", function() { 
        var deleteid =  $(this).attr("data-id")
        var $ele = $(this).parent().parent();
        bootbox.confirm("Are you sure want to reject the request?.", function(result) {
            if(result){
                $.ajax({
                    url: "reject.php",
                    type: "POST",
                    cache: false,
                    data:{
                        id: deleteid
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>