<?php 
include 'db.php';
include 'user-nav.php';
?>
<!--php ends-->

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Home</title>

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
<body>
    <h1 class="centerContent mt-4">Announcements</h1>
	<?php
	$result = mysqli_query($db, "select * from announcements ORDER BY announcementId DESC");
	if(!$result) {
		die(mysqli_error($db));
	}
	while ($row = $result->fetch_assoc()) {
		$date = date_create($row['announcementDate']);
		$adminQ = $db->query("SELECT username FROM admins WHERE adminId = '$row[adminID]'");
		$adminId = mysqli_fetch_array($adminQ);
		$announcement = $row['announcement'];
		echo "
		<div class='centerContent' style='background-color:#f8d7da; width:350px; padding:15px; margin-top:10px; margin-bottom:10px; margin-left:auto; 
		margin-right:auto; border-radius:4px;'> 
		<p class='mb-2' style='width:350px'><strong>Posted by ".strtoupper(substr($adminId[0],0,1)).substr($adminId[0],1,)." on ".date_format($date,'m-d-Y')."</strong> <br>$announcement</p>
		</div>";
	}
	echo"<br>";
	?>

<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>