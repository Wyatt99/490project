<?php
#Database
include 'db.php';
ensure_logged_in();

#Query to perform delete
$id=$_GET["id"];
mysqli_query($db, "delete from Practice where practiceId=$id");

?>
<!-- script to not travel to new page -->
<script type="text/javascript">
window.location="scheduled-teams.php?deletePracticeSuccess";
</script>