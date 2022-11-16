<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Manage Announcements</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
	<!-- Font Awesome icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>

<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
?>
<!--php ends-->

<body>

    <h1 class="centerContent mt-4 mb0">Manage Announcements</h1>
    <?=$promptMessage()?>
    <a href="add-announcements.php" style="display:block; text-decoration:none" class="mt-0 mx-auto">Post a new announcement</a>
	<?php
	$result = mysqli_query($db, "select * from announcements ORDER BY announcementId DESC");
	if(!$result) {
		die(mysqli_error($db));
	}
	while ($row = $result->fetch_assoc()) {
		$date = date_create($row['announcementDate']);
		$adminQ = $db->query("SELECT username FROM admins WHERE adminId = '$row[adminID]'");
		$adminId = mysqli_fetch_array($adminQ);
		echo "<div class='centerContent'>".date_format($date,"m-d-Y")."</div>";
		$announcement = $row['announcement'];
		echo "
		<div class='centerContent' style='background-color:#f8d7da; width:350px; padding:15px; margin-top:10px; margin-bottom:10px; margin-left:auto; 
		margin-right:auto; border-radius:4px;'> 
		<p class='mb-2' style='width:350px'><strong>Posted by $adminId[0]</strong> <br>$announcement</p>
        <div class = 'centerContent'>
        "
        ?> 

        <a href="edit-announcements.php?id=<?php echo $row["announcementId"];?>"> <button type="button" class= "btn btn-sm"><i class="fa fa-pencil icon-cog" style="color:green"></i></button></a>
        <a href="delete-announcements.php?id=<?php echo $row["announcementId"];?> "onclick="return confirm('Are you sure you want to delete this announcement made on <?php echo $row['announcementDate']?>? ANNOUNCEMENT: <?php echo $row['announcement'] ?>')">
        <button type="button" class= "btn btn-sm"><i class="fa fa-trash icon-cog" style="color:red"></i> </button> </a>
        
        <?php
        echo"</div>";
		echo"</div>";
	}
	    ?>
	

<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>