<?php
#Database
include 'db.php';
ensure_logged_in();

#Query to perform delete

$id=$_GET["id"];
$user=$_GET["user"];
if ($id != 1 && $user != 1){
    mysqli_query($db, "delete from announcements where adminId=$id");
    mysqli_query($db, "delete from Admins where adminId=$id");

    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location:index.php?accountDeleted');
    exit();

} else {
    mysqli_query($db, "delete from announcements where adminId=$id");
    mysqli_query($db, "delete from Admins where adminId=$id");
    header('Location:edit-admin.php?accountDeletedOther');
    exit();
}
    ?>