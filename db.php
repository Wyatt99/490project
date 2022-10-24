<?php
$db = new mysqli('localhost', 'root', '', 'cajun_rush_schedule');

if($db === false){
  die("ERROR: Could not connect. ". mysqli_connect_error());
}

#if no session, start an empty session
if (!isset($_SESSION)) { session_start(); }

#fetch all fields in database and echo each as an option in select input
function fieldSelect ($db, $parkId) {
	$result = $db->query("SELECT * FROM field WHERE parkId = '$parkId'");
    $rows = mysqli_fetch_all($result);
	if ($rows) {
		foreach ($rows as $row) {
      $fieldId = $row[0];
			$fieldName = $row[1];
			echo"<option value='$fieldId'>$fieldName</option>";
		}
	}
}

#fetch all age groups in database and echo each as an option in select input
function checkForTeams ($db) {
	$result = $db->query("SELECT * FROM team");
    $rows = mysqli_fetch_all($result);
	if (!$rows) {
      header("location: create-teams.php?noTeam");
      exit();
		}
	}



#fetch all age groups in database and echo each as an option in select input
function ageGroupSelect ($db) {
	$result = $db->query("SELECT ageGroup FROM ageGroup");
    $rows = mysqli_fetch_all($result);
	if ($rows) {
		foreach ($rows as $row) {
			$ageGroup = $row[0];
			echo"<option value='$ageGroup'>".$ageGroup."u</option>";
		}
	}
}

#fetch all team locations in database and echo each as an option in select input
function teamLocationSelect ($db) {
	$result = $db->query("SELECT teamLocation FROM teamLocation");
    $rows = mysqli_fetch_all($result);
	if ($rows) {
		foreach ($rows as $row) {
			$teamLocation = $row[0];
			echo"<option value='$teamLocation'>".$teamLocation."</option>";
		}
	}
}

#connect to cajun_rush_schedule database if password is correct
function is_password_correct ($name, $password, $db) {
    $inputName = ($name);
    $result = $db->query("SELECT password FROM admins WHERE username = '$inputName'");
    $rows = mysqli_fetch_assoc($result); 
    if ($rows) {
      foreach ($rows as $hash) {
        return password_verify($password, $hash); #returns true
      }

    } else {
      return FALSE;   # user not found
    }
  }

#if $_SESSION['name'] is not set, redirect to login page
function ensure_logged_in() {
    if (!isset($_SESSION["name"])) {
      header("Location: login.php");
      exit();
    }
  }

#message to display if login credentials do not match database, password does not match, or registration is successful
$promptMessage = function() {
  if (isset($_GET['err'])) {
      $message = "Invalid credentials, please try again.";
      echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['errp'])) {
      $message = "Passwords do not match.";
      echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['duplicateAdmin'])) {
    $message = "Admin already exists";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
}
  if (isset($_GET['newAdminSuccess'])) {
      $message = "Registered new admin successfully!";
      echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['updateteamsuccess'])) {
    $message = "Team updated successfully";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['deleteteamsuccess'])) {
    $message = "Team deleted successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['teamAdded'])) {
    $message = "Team added successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['duplicateTeam'])) {
    $message = "Team with the same name, location, and age already exists!";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['practiceSuccess'])) {
    $message = "Team scheduled successfully!";
    echo "<div class='alert alert-success mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
  if (isset($_GET['noTeam'])) {
    $message = "No teams exist, you may add one here!";
    echo "<div class='alert alert-danger mt-3 mx-auto text-center' role='alert'>".$message."</div>";
  }
}
?> 