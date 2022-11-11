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
<h1 class='text-center mt-4 '>Cajun Rush <br class="d-md-none">Schedule Viewer</h1>
<div class="container mt-3 mt-lg-5 centerContent">
    <div class="row">

		<!--coaching resources-->
		<div class="col-12 col-md-6 col-lg-4 order-2 order-md-1 order-lg-1 mb-2 px-4 centerContent">
            <div class="card mt-0 mt-lg-2" style="width: 10rem;">
				<a href="resources.php"><img class="card-img-top" src='images/whistle.svg' alt="coach resources"></a>
				<div class="card-body">
				<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Coaching Resources</strong></h5>
			</div>
        </div>
        </div> <!--col end-->

	<!--view schedule-->
	<div class="col-12 col-md-6 col-lg-4 order-3 order-md-2 order-lg-2 mb-2 px-4 centerContent">
		<div class="card mt-0 mt-lg-2" style="width: 7rem;">
			<a href="view-schedules.php"><img class="card-img-top" src='images/view-schedule.svg' alt="view schedules"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>View Schedules</strong></h5>
		</div>
		</div>
	</div> <!--col end-->


	<div class="col-12 col-md-6 col-lg-4 order-1 order-md-3 order-lg-3 mb-2 px-4">
	<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Recent Announcements</strong></h5>

	<?php
	$result = mysqli_query($db, "select * from announcements ORDER BY announcementId DESC LIMIT 2");
	if(!$result) {
		die(mysqli_error($db));
	}
	while ($row = $result->fetch_assoc()) {
		unset($announcement);
		$date = date_create($row['announcementDate']);
		$adminQ = $db->query("SELECT username FROM admins WHERE adminId = '$row[adminID]'");
		$adminId = mysqli_fetch_array($adminQ);
		echo "<div class='mx-auto mx-lg-0'>".date_format($date,"m-d-Y")."</div>";
		$announcement = $row['announcement'];
		echo "
		<div class='centerContent' style='background-color:#f8d7da; width:350px; padding:15px; margin-top:10px; margin-bottom:10px; margin-left:auto; 
		margin-right:auto; border-radius:4px;'> 
		<p class='mb-2' style='width:350px'><strong>Posted by $adminId[0]</strong> <br>$announcement</p>
		</div>";
	}
	?>
	<a class="centerContent" href="view-announcements.php" style="text-decoration:none">View All Announcements</a>

	<!-- needed fieldStatus creation ui, field status attribute, and select statements for field status -->

	<!--<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Field Closures</strong></h5>-->
	<?php
	/* $result = mysqli_query($db, "select * from announcements ORDER BY announcementId DESC LIMIT 2");
	if(!$result) {
		die(mysqli_error($db));
	}
	while ($row = $result->fetch_assoc()) {
		unset($announcement);
		$announcement = $row['announcement'];
		echo "
		<div class='articlePrev mb-4' style='  background-color:#f8d7da; width:400px; padding:15px; margin-left:2%; margin-bottom:1%; border-radius:4px;'> 
		<p class='mb-2' style='width:350px'>$announcement</p>
		</div>";
	}
	*/
	?>
	<br><br>
	</div>

<!-- row ends -->
</div>
</div> <!--container end-->

<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent" style='width:100%;'>Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>