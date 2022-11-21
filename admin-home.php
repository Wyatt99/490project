<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
?>
<!--php ends-->
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Home</title>

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
<h1 class='text-center my-4'>Hello <?= strtoupper(substr($_SESSION["name"],0,1)).substr($_SESSION["name"],1,) ?>, welcome back!</h1> <!--to confirm session created, will remove/edit later-->

<div class="container mt-3 mt-lg-5 centerContent">
    <div class="row">
		<!--add team-->
        <div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
            <div class="card" style="width: 10rem;">
				<a href="create-teams.php"><img class="card-img-top" src='images/add-team.svg' alt="add team"></a>
				<div class="card-body">
				<h5 class="centerContent" style="color: #1D3461;"><strong>Create Team</strong></h5>
			</div>
        </div>
        </div> <!--col end-->

	<!--view team-->
	<div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
		<div class="card" style="width: 10rem;">
				<a href="update-team.php"><img class="card-img-top" src='images/edit-teams.svg' alt="edit team"></a>
				<div class="card-body">
				<h5 class="centerContent" style="color: #1D3461;"><strong>Edit Teams</strong></h5>
			</div>
		</div>
	</div> <!--col end-->

		<!--announcements-->
		<div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
            <div class="card" style="width: 8rem;">
				<a href="add-announcements.php"><img class="card-img-top" src='images/announcement.svg' alt="add announcements"></a>
				<div class="card-body">
				<h5 class="centerContent" style="color: #1D3461;"><strong>Announcements</strong></h5>
			</div>
        </div>
        </div> <!--col end-->

	<!--schedule-->
	<div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
	<div class="card" style="width: 7.5rem;">
			<a href="team-select.php"><img class="card-img-top" src='images/schedule-teams.svg' alt="schedule teams"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Schedule Practices</strong></h5>
		</div>
	</div>
	</div> <!--col end-->


	<!--view schedule-->
	<div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
		<div class="card" style="width: 8rem;">
			<a href="scheduled-teams.php"><img class="card-img-top" src='images/view-schedule.svg' alt="view schedules"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>View Schedules</strong></h5>
		</div>
		</div>
	</div> <!--col end-->
	

	<!--manage season-->
	<div class="col-12 col-md-6 col-lg-4 mb-2 px-4 centerContent">
		<div class="card" style="width: 7.75rem;">
			<a href="season-manager.php"><img class="card-img-top" src='images/manage-seasons.svg' alt="manage seasons"></a>
		<div class="card-body">
			<h5 class="centerContent" style="color: #1D3461; white-space:nowrap;"><strong>Manage Seasons</strong></h5>
		</div>
		</div>
	</div> <!--col end-->
</div> <!--row end-->
	
    </div> <!--container end-->

<!-- Body ends -->
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>