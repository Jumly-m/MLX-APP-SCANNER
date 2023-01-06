<?php
include 'api/config.data';

session_start();

if (isset($_SESSION['id'])) {
    header('Location:index.php');
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $TITLE; ?> | Log in</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/"><img height="60px" src="img/logo.png" alt="Logo"></a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php



        if (isset($_POST['submit'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            if (!empty($email) && !empty($password)) {
                $password = md5($password);
                $sql = "select id,name,email,status from users WHERE email = '$email' AND password = '$password' and status = '2'";

                $result = mysqli_query($conn, $sql);
                $have_user = mysqli_num_rows($result);

                if ($have_user == 1) { # Have User
                    $result = $result->fetch_assoc();
                    $id = $result['id'];
                    $name = $result['name'];
                    $email = $result['email'];
                    $status = $result['status'];

                    $_SESSION['id'] = $id;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['status'] = $status;
                    ?>
                    <script>
                        window.location.href = '/index.php';
                    </script>
                    <?php


                } else {
                    echo "<div class=\"alert alert-warning\" role=\"alert\">
                      No User Found 
                    </div>";
                }
            } else {
                echo "<div class=\"alert alert-warning\" role=\"alert\">
                      Please Fill All The Input Field
                    </div>";
            }
        }

        ?>

        <form method="post" action="">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit">Sign In</button>
                </div>
            </div>
        </form>
        <br>

    </div>
</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>
</html>
