<?php 
include 'db.php'; //connect to database
include 'admin-nav.php';
ensure_logged_in();

$parkId = 2;
$parkName = "Youngsville Sports Complex";


?>
<!--php ends-->

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>YSC Scheduler</title>

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
	<h1 class="mt-4 mb-2 text-lg-start text-center">Youngsville Sports Complex</h1>
	<h3 class="subText text-lg-start text-center ">Practice Scheduler</h3>

	<form method="GET" class="yscScheduleForm">
    <div class="row align-items-center g-3 mt-1">

        <div class="col-lg-auto col-12">
			<label for="ageGroup" class="form-label"><strong>Age Group</strong></label>
				<select class="form-control " id="ageGroup" style="appearance:listbox;">
				<option value="" disabled selected hidden>Select</option> 
				<?=ageGroupSelect($db, $parkId)?>
				</select>
        </div>

        <div class="col-lg-auto col-12 ">
			<div class="form-group">
			<label for="field" class="form-label"><strong>Field</strong></label>
				<select class="form-control" id="field" style="appearance:listbox; ">
				<option value="" disabled selected hidden>Select</option> 
				<?=fieldSelect($db, $parkId)?>
				</select>
			</div>
        </div>


		<!--start time-->
		<p class="mb-0 mb-lg-2 mt-3" style="display:inline"><strong>Start Time</strong></p>
			<div class="col-lg-auto col-12 mt-0">
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
			</div>

			<!--end time-->
		<p class="mb-0 mb-lg-2 mt-3" style="display:inline"><strong>End Time</strong></p>
			<div class="col-lg-auto col-12 mt-0">
			<select class="form-control mt-2 mt-lg-0" id='endtHr' style="appearance:listbox;">
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
			<select class="form-control mt-2 mt-lg-0" id='endMin' style="appearance:listbox;">
				<option value="" disabled selected hidden>Minute</option> 
				<option value='00'>00</option>
				<option value='15'>15</option>
				<option value='30'>30</option>
				<option value='45'>45</option>
			</select>
			</div>

			<div class="col-lg-auto col-12 mt-0">
			<select class="form-control mt-2 mt-lg-0" id='endAM-PM' style="appearance:listbox;">
				<option value="" disabled selected hidden>AM/PM</option> 
				<option value='AM'>AM</option>
				<option value='PM'>PM</option>
			</select>
			</div>

    </div> <!--row ends-->
</form>
</div>
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>