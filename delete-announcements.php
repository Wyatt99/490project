<?php
#Database
include 'db.php';
ensure_logged_in();

#Query to perform delete
$id=$_GET["id"];
mysqli_query($db, "delete from announcements where announcementId=$id");

?>
<!-- script to not travel to new page -->
<script type="text/javascript">
window.location="update-announcements.php?deleteAnnouncementSuccess";
</script>