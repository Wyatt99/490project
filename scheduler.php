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
checkForTeams($db);
mysqli_report(MYSQLI_REPORT_STRICT);
$message="";

$update = $_GET["update"];
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


	if ($update == 1) {
		$teamIdentifier = $_GET["team"];
		
		# get the teamId number from the getter
		$sql = "select * from team where teamIdentifier='$teamIdentifier'";
		$res=mysqli_query($db, $sql);
		while($row=mysqli_fetch_array($res)){
			$teamId=$row["teamId"];
			$teamIdentifier=$row["teamIdentifier"];
		}

		$updateSqlConflict=mysqli_query($db, "select * from practice where teamId=$teamId");

		$res2=mysqli_query($db, "delete from practice where teamId=$teamId");
	}
	# the sql select statement for practice
	$result = $db->query("SELECT * FROM practice");

	$seasonResult = $db->query("SELECT s.seasonId FROM season s, team t WHERE t.seasonId = s.seasonId AND t.teamId=$teamId");
	while ($row = $seasonResult->fetch_assoc()) {
		$season = $row['seasonId'];
	}

	# loops through all the records from practice table
	$timeConflict = 0;
	while ($row = $result->fetch_assoc()) {
		unset($fieldIdCheck, $fieldSectionCheck, $dayCheck, $startTimeCheck, $endTimeCheck);
		$fieldIdCheck = $row['fieldId'];
		$fieldSectionCheck = $row['fieldSection'];
		$dayCheck = $row['day'];
		$startTimeCheck = $row['startTime'];
		$endTimeCheck = $row['endTime'];
		$teamIdCheck = $row['teamId'];
		$time1 = $startTime;
		$time2 = $endTime;
		$time3 = $startTimeCheck;
		$time4 = $endTimeCheck;
		$time3=date('H:i',strtotime($time3));
		$time4=date('H:i',strtotime($time4));
		$seasonResultCheck = $db->query("SELECT s.seasonId FROM season s, team t WHERE t.seasonId = s.seasonId AND t.teamId=$teamIdCheck");
		while ($row = $seasonResultCheck->fetch_assoc()) {
			$seasonCheck = $row['seasonId'];
		}
		if (($seasonCheck == $season)
		&& ($fieldIdCheck == $field) 
		&& ($dayCheck == $day)) {

			if (($time1 < $time4) && ($time2 > $time3)){
				if  ( ($fieldSectionCheck == 'F') 
				&& (($section == 'A') 
				|| ($section == 'B') 
				|| ($section == 'C') 
				|| ($section == 'D')) ){
					$timeConflict = 1;
				} elseif ( ($section == 'F') 
				&& (($fieldSectionCheck == 'A') 
				|| ($fieldSectionCheck == 'B') 
				|| ($fieldSectionCheck == 'C') 
				|| ($fieldSectionCheck == 'D')) ){
					$timeConflict = 1;
				} elseif ($fieldSectionCheck == $section) {
					$timeConflict = 1;
				}
			}
		}		
	}
	
	if ($timeConflict) {
		$message ="<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>Time Conflict!</div>";
		if ($update == 1) {
			while($row=mysqli_fetch_array($updateSqlConflict)){
				$field=$row["fieldId"];
				$section=$row['fieldSection'];
				$teamId=$row['teamId'];
				$startTime=$row['startTime'];
				$endTime=$row['endTime'];
				$day=$row['day'];
				$adminId = $_SESSION['adminId'];

			}
			$updateSql="INSERT into practice (fieldId, fieldSection, teamId, startTime, endTime, day, adminId) VALUES ('$field', '$section', '$teamId', '$startTime', '$endTime', '$day', '$adminId')";
			$res2=mysqli_query($db, $updateSql);
		}
	} else {
		$practicePrep = $db -> prepare("INSERT INTO practice(fieldId, fieldSection, teamId, startTime, endTime, day, adminId) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$practicePrep -> bind_param("isisssi", $field, $section, $teamId, $startTime, $endTime, $day, $_SESSION['adminId']);
		$practicePrep -> execute();
		?>
		<script type="text/javascript">
		window.location="team-select.php?practiceSuccess";
		</script>
		<?php
		unset($_SESSION['parkId']);
		unset($_SESSION['parkName']);
		unset($_SESSION['team']);
		exit();
	}
}
?>
<!--php ends-->

<body>
	<h5 class="text-center" style="color: rgb(31, 107, 214); margin-bottom: -15px; margin-top: 15px;">Active Season: <?=getActiveSeason($db)?></h5>
	<h1 class="mt-4 mb-2 px-2 text-center"><?=$_SESSION['parkName']?></h1>
	<h3 class="subText  text-center ">Practice Scheduler</h3> 
	<?php 

	if ($update == 1){
		$teamIdentifier = $_GET["team"];
		
		# get the teamId number from the getter
		$teamIdsql = "select * from team where teamIdentifier='$teamIdentifier'";
		$res=mysqli_query($db, $teamIdsql);
		while($row=mysqli_fetch_array($res)){
			$teamId=$row["teamId"];
			$teamIdentifier=$row["teamIdentifier"];
		}

		$practiceInfo=mysqli_query($db, "select * from practice where teamId=$teamId");
		while($row=mysqli_fetch_array($practiceInfo)){
			$field=$row["fieldId"];
			$section=$row['fieldSection'];
			$startTime=$row['startTime'];
			$endTime=$row['endTime'];
			$day=$row['day'];

			$startTime = date("g:i a", strtotime($startTime));
			$endTime = date("g:i a", strtotime($endTime));
		}


		$fieldNameGet=mysqli_query($db, "select * from field where fieldId=$field");
		while($row=mysqli_fetch_array($fieldNameGet)){
			$fieldName=$row["fieldName"];
			$parkId = $row["parkId"];
		}
		if ($parkId == 1){
			$parkName = "Moore Park";
		} else {
			$parkName = "Youngsville Sports Complex";
		}

		$practiceInfoData = $parkName.' '.$fieldName.' '.$section.' '.$startTime.'-'.$endTime.' '.$day;
	} else {
		$practiceInfoData = "";
	}


	echo $message; 
	?>
	
<container class="centerContent w-40">
	<form method="GET" action="scheduler.php" style="overflow-x:hidden">
	
	<div class="row align-items-center g-3 mt-1 px-4 centerContent">
	<p class='text-center mt-0'><strong>Team: <?=$_SESSION['team']?></strong></p>
	<?php
	if ($update == 1) {
		?>
		<p class='text-center mt-0'><strong>Current Schedule: <?=$practiceInfoData?></strong></p>
		<?php
	} 
	?>
		<!--day-->
		<div class="col-lg-auto col-12 mt-2  mt-lg-3 mb-0">
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
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="F">F</option>
				</select>
        </div>

		<!--start time-->
		<div class="col-lg-auto col-4 mx-sm-0 mx-2">
			<label for="startTime" class="form-label" style="display:block" required><strong>Start Time</strong></label>
			<input type="time" name='startTime' id="startTime">
		</div>

		<!--end time-->
		<div class="col-lg-auto col-4 mx-sm-0 mx-2">
			<label for="endTime" class="form-label" style="display:block" required><strong>End Time</strong></label>
			<input type="time" name='endTime' id="endtTime">
		</div>

		<input type="hidden" name="update" value="<?=$update;?>" />
		<input type="hidden" name="team" value="<?=$_SESSION['team'];?>" />
				
		<!--submit-->
		<div class="col-lg-1 col-4 mt-4 mt-lg-5 contentCenter">
			<button class="btn-primary btn-lg btn-block " type="submit" name='submit' id='submit' value='submit'>Submit</button>
		</div>

    </div> <!--row ends-->
</form>
</container>
<!-- Bootstrap JS Bundle with Popper **needed for collapsable nav** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>

