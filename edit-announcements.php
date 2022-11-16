<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Announcement</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>
<!-- END OF HEADER -->

<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
?>

<?php
$id=$_GET["id"];
$announcement="";


$res=mysqli_query($db, "select * from announcements where announcementId=$id");
while($row=mysqli_fetch_array($res)){
    $announcement=$row["announcement"];
}
?>

<?php
if (isset($_POST["Update"])){

    $announcement=$_POST['announcement'];
    mysqli_query($db, "update announcements set announcement ='$announcement' where announcementId=$id");

    ?>
    <script type="text/javascript">
    window.location="update-announcements.php?updateAnnouncementSuccess";
    </script>
    <?php
    
}
    ?>

<?php
if (isset($_POST["Return"])){
    ?>
    <script type="text/javascript">
    window.location="update-announcements.php";
    </script>
    <?php
}
    ?>
<!-- END OF PHP -->




<!-- START OF BODY -->
<body>
<div class="container mt-3 centerContent">

  <form action="" name = "form1" method = "post">
  <h1 class='centerContent'->Edit Announcement</h1>
    <div class="form-group">
      <label class="mb-1" for="announcement">Edit the announcement below:</label>
	  <textarea class="form-control" style='height: 150px; width: 350px;' id="announcement" name="announcement" 
	  required><?=$announcement?></textarea>
    </div>

    <div class="mt-3">
    <button type="submit" name="Update" class="btn btn-primary mb-3 mb-lg-0">Update</button>
    <button type="submit" name="Return" class="btn btn-secondary mb-3 mb-lg-0">Cancel</button>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
