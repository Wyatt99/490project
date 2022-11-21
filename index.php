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

<div class="container mt-3 centerContent">
    <div class="row centerContent">
	<div class="col-12 order-1 order-md-1 order-lg-1 mb-1">
	<h2 class="centerContent mb-3 mb-lg-3" style="color: #1D3461; white-space:nowrap;"><strong>Recent Announcements</strong></h2>
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
		$announcement = $row['announcement'];
		echo "
		<div class='centerContent mb-3' style='background-color:#f8d7da; width:350px; padding:15px; margin-top:10px; margin-bottom:10px; margin-left:auto; 
		margin-right:auto; border-radius:4px;'> 
		<p class='mb-2' style='width:350px'><strong>Posted by ".strtoupper(substr($adminId[0],0,1)).substr($adminId[0],1,)." on "
		.date_format($date,'m-d-Y')."</strong> <br>$announcement</p>
		</div>";
	}
	?>
	<a class="centerContent mb-3" href="view-announcements.php" style="text-decoration:none">View All Announcements</a>
	</div>

	<!--view schedule-->
	<div class="col-12 col-md-6 col-lg-3 order-2 order-md-2 order-lg-2 mt-1 centerContent">
		<div class="card mt-0 mt-lg-2" style="width: 7rem;">
			<a href="view-schedules.php"><img class="card-img-top" src='images/view-schedule.svg' alt="view schedules"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>View Schedules</strong></h5>
		</div>
		</div>
	</div> <!--col end-->

	<!--coaching resources-->
	<div class="col-12 col-md-6 col-lg-3 order-3 order-md-3 order-lg-3 mt-1 centerContent">
		<div class="card mt-0 mt-lg-2" style="width: 10rem;">
			<a href="resources.php"><img class="card-img-top" src='images/whistle.svg' alt="coach resources"></a>
			<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Coaching Resources</strong></h5>
		</div>
		</div>
	</div> <!--col end-->

	<!--announcements-->
	<div class="col-12 col-md-6 col-lg-3 order-4 order-md-4 order-lg-4 mt-1 mt-md-0 centerContent">
	<div class="card" style="width: 8rem;">
		<a href="view-announcements.php"><img class="card-img-top" src='images/announcement.svg' alt="view announcements"></a>
		<div class="card-body">
		<h5 class="centerContent" style="color: #1D3461;"><strong>Announcements</strong></h5>
	</div>
	</div>
	</div> <!--col end-->

<!-- row ends -->
</div>
</div> <!--container end-->

<div class="row centerContent my-3">
<h2 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Park Locations</strong></h2>
<div class="col-12 col-md-6 col-lg-auto order-1 order-md-3 order-lg-3 mb-2">
	<h5  class="subtext centerContent my-2">Moore Park</h5>
    <span> 
        <div class="centerContent my-2" style="border:5px;">
        <iframe width="280" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=280&amp;height=300&amp;hl=en&amp;q=198%20Laser%20Ln,%20Lafayette,%20LA%2070507%20%20Lafayette+(Moore%20Park%20)&amp;t=k&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </span>
	</div>

	<div class="col-12 col-md-6 col-lg-auto order-1 order-md-3 order-lg-3 mb-2">
    <h5 class="subtext centerContent my-2">Youngsville Sports Complex</h5>
    <span>
        <div class="centerContent my-2" style="border:5px;">
        <iframe width="280" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=280&amp;height=300&amp;hl=en&amp;q=801%20Savoy%20Rd,%20Youngsville,%20LA%2070592%20%20Lafayette+(Youngsville%20Sports%20Complex)&amp;t=k&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </span>
		</div>
	</div>

<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent" style='width:100%;'>Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>