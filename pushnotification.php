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
    <title><?php echo $TITLE; ?> | Push Notification</title>
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
            
            <div class="row">
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Push Notification</h3>
                        </div>
                        <div class="box-body">

                            <div class="form-group">
                                <label for="exampleInputPassword1">Title</label>
                                <input type="text" class="form-control txtTitle" id="exampleInputPassword1" placeholder="Enter Title*" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Message</label>
                                <textarea name="txtMsg" class="form-control txtMsg" placeholder="Your Message *" style="width: 100%; height: 150px;"  required></textarea>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary sendnotification" name="submit">Send Notification</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.3/bootbox.min.js" integrity="sha512-U3Q2T60uOxOgtAmm9VEtC3SKGt9ucRbvZ+U3ac/wtvNC+K21Id2dNHzRUC7Z4Rs6dzqgXKr+pCRxx5CyOsnUzg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    $(document).ready(function() {
        $(document).on("click", ".sendnotification", function() { 
            var txtTitle = $(".txtTitle").val(); 
            var txtMsg = $(".txtMsg").val(); 
            
            if (txtTitle === '' || txtMsg === ''){
                bootbox.alert("Please fillup all the field.");
            } else {
                var $ele = $(this).parent().parent();
                bootbox.confirm("Are you ready to send push notification?", function(result) {
                    if(result){

                        $.ajax({        
                            type : 'POST',
                            url : "https://fcm.googleapis.com/fcm/send",
                            headers : {
                                Authorization : 'key=AAAA-d3lgZ0:APA91bFLWBt69lwECOh2viud5DzNsa5jS9C_e4liFIpvIkSr1MNc7lfMFDaMRPNy0aHTzQFjj1aeTKPZY1QSSJ_8se3ZAJYtbEZPvZJ9PtqOZV2D9oduKNLdLpNnsIKR8gir9eMY2gfx'
                            },
                            contentType : 'application/json',
                            dataType: 'json',
                            data: JSON.stringify({"to": "/topics/broadcast", "notification": {"title":txtTitle,"body":txtMsg}}),
                            success : function(response) {
                                bootbox.alert("Push notification send succesful.");
                                console.log(response);
                            },
                            error : function(xhr, status, error) {
                                console.log(xhr.error);
                                bootbox.alert("Push notification send failed.");              
                            }
                        });

                    }
                });
            }


        });
    });



</script>
</body>
</html>