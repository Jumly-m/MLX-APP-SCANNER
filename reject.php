<?php
include 'api/config.data';

session_start();

if (!isset($_SESSION['id'])) {
    header('Location:login.php');
    exit();
}

$uid = $_POST['id'];

if (!isset($uid)) {
    echo json_encode(array("statusCode"=>201));
}

if ($uid == $_SESSION['id']) {
    echo json_encode(array("statusCode"=>201));
}

$id = $_SESSION['id'];

$sql = "update reqwithdraw set status = 2,process_by= '$id',update_at=now() where id = '$uid'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode"=>200));
} 
else {
    echo json_encode(array("statusCode"=>201));
}
?>