<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Team Scheduler</title>

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
include 'db.php'; //connect to database
include 'admin-nav.php';
ensure_logged_in();

if (!isset($_SESSION['parkId'])) {
	$_SESSION['parkId'] = $_GET['id'];
	$_SESSION['parkName'] = $_SESSION['parkId'] == 1 ? "Moore Park" : "Youngsville Sports Complex";
}

if (isset($_GET['submit']) 
&& (!empty($_GET['field']))
&& (!empty($_GET['section']))
&& (!empty($_GET['day']))
&& (!empty($_GET['startTime']))
&& (!empty($_GET['endTime']))) {
	$field = $_GET['field'];
	$section = $_GET['section'];
	$day = $_GET['day'];
	$startTime = $_GET['startTime'];
	$endTime = $_GET['endTime'];

	$teamIdQuery = $db->query("SELECT teamId FROM team WHERE teamIdentifier LIKE '$_SESSION[team]'");
	$teamIdStmnt = mysqli_fetch_all($teamIdQuery);
	$teamId = $teamIdStmnt[0][0];

	$practicePrep = $db -> prepare("INSERT INTO practice(fieldId, fieldSection, teamId, startTime, endTime, day, adminId) VALUES (?, ?, ?, ?, ?, ?, ?)");
	$practicePrep -> bind_param("isisssi", $field, $section, $teamId, $startTime, $endTime, $day, $_SESSION['adminId']);
	$practicePrep -> execute();
	header("location: team-select.php?practiceSuccess");
	unset($_SESSION['parkId']);
	unset($_SESSION['parkName']);
	unset($_SESSION['team']);
	exit();
}

?>
<!--php ends-->

<body>
	<h1 class="mt-4 mb-2  text-center"><?=$_SESSION['parkName']?></h1>
	<h3 class="subText  text-center ">Practice Scheduler</h3> 
	
<container class="centerContent w-40">
	<form method="GET" action="scheduler.php" style="overflow-x:hidden">
	
	<div class="row align-items-center g-3 mt-1 px-4 centerContent">
	<p class='text-center mt-0'><strong>Team: <?=$_SESSION['team']?></strong></p>

		<!--day-->
		<div class="col-lg-auto col-12 mt-3  mt-lg-3 mb-0">
			<label for="day" class="form-label"><strong>Day</strong></label>
			<select class="form-control " name='day' id='day' style="appearance:listbox;" required>
				<option value="" disabled selected hidden>Select</option> 
				<option value='Monday'>Monday</option>
				<option value='Tuesday'>Tuesday</option>
				<option value='Wednesday'>Wednesday</option>
				<option value='Thursday'>Thursday</option>
				<option value='Friday'>Friday</option>
				<option value='Saturday'>Saturday</option>
				<option value='Sunday'>Sunday</option>
			</select>
		</div>

		<!--field-->
        <div class="col-lg-auto col-12">
			<label for="field" class="form-label"><strong>Field</strong></label>
				<select class="form-control" name="field" id="field" style="appearance:listbox;" required>
				<option value="" disabled selected hidden>Select</option> 
				<?=fieldSelect($db, $_SESSION['parkId'])?>
			</select>
        </div>

		<!--field section-->
        <div class="col-lg-auto col-12 ">

			<label for="section" class="form-label"><strong>Section</strong></label>
				<select class="form-control" name="section" id="section" style="appearance:listbox;" required>
				<option value="" disabled selected hidden>Select</option> 
				<option value="Left">Left</option>
				<option value="Right">Right</option>
				<option value="Center">Center</option>
				</select>
        </div>

		<!--start time-->
		<div class="col-lg-auto col-3">
			<label for="startTime" class="form-label" style="display:block" required><strong>Start Time</strong></label>
			<input type="time" name='startTime' id="startTime">
		</div>

		<!--end time-->
		<div class="col-lg-auto col-3 mx-sm-0 mx-2">
			<label for="endTime" class="form-label" style="display:block" required><strong>End Time</strong></label>
			<input type="time" name='endTime' id="endtTime">
		</div>
				
		<!--submit-->
		<div class="col-lg-1 col-3 contentCenter">
			<button class="btn-primary btn-lg btn-block mt-3" type="submit" name='submit' id='submit' value='submit'>Submit</button>
		</div>

    </div> <!--row ends-->
</form>
</container>
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>

<!-- time select 12hr format 

		<div class="col-lg-auto col-12 ">
		<select class="form-control mt-2 mt-lg-0" id='startHr' style="appearance:listbox;">
					<option value="" disabled selected hidden>Hour</option> 
					<option value='1'>01</option>
					<option value='2'>02</option>
					<option value='3'>03</option>
					<option value='4'>04</option>
					<option value='5'>05</option>
					<option value='6'>06</option>
					<option value='7'>07</option>
					<option value='8'>08</option>
					<option value='9'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
				</select>
				</div>

				<div class="col-lg-auto col-12 mt-0">
				<select class="form-control mt-2 mt-lg-0" id='startMin' style="appearance:listbox;">
					<option value="" disabled selected hidden>Minute</option> 
					<option value='00'>00</option>
					<option value='15'>15</option>
					<option value='30'>30</option>
					<option value='45'>45</option>
				</select>
				</div>

				<div class="col-lg-auto col-12 mt-0">
				<select class="form-control mt-2 mt-lg-0" id='startAM-PM' style="appearance:listbox;">
					<option value="" disabled selected hidden>AM/PM</option> 
					<option value='AM'>AM</option>
					<option value='PM'>PM</option>
				</select>
-->