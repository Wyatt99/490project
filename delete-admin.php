<?php
#Database
include 'db.php';
ensure_logged_in();

#Query to perform delete
$id=$_GET["id"];
if ($id != 1){
    mysqli_query($db, "delete from announcements where adminId=$id");
    mysqli_query($db, "delete from Admins where adminId=$id");

    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location:index.php?accountDeleted');
    exit();
} else {
    ?>
    <script type="text/javascript">
    window.location="edit-admin.php?masterCantBeDeleted";
    </script>
    <?php
}
    ?>