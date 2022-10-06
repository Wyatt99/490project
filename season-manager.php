<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
mysqli_report(MYSQLI_REPORT_STRICT);

# variable default values
$error = false;
$notUniqueError="";
$requiredError="";
$insertSuccess="";
$activeSuccess="";
$inactiveError="";

# post process for when the button for adding a season is clicked
if (isset($_POST['addSeasonButton'])){

    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    #check for escape strings, shouldn't be possible as both options are drop down
    $seasonchoice= mysqli_real_escape_string(
        $db, $_REQUEST['seasonSel']);
    $yearChoice = mysqli_real_escape_string(
        $db, $_REQUEST['year']);
    #Create the season ID by combing season + year
    $seasonId = $seasonchoice." ".$yearChoice;

        # season logic where it selects the active current season to be automatically added into the new team
        $sql = "INSERT INTO season (seasonID, seasonStatus)
        VALUES ('$seasonId', 0)";

        # attempts the sql insert, if it fails the uniqueError is set
        if(mysqli_query($db, $sql)){
            $message="Season has been added!";
            echo "<div class='alert alert-success mt-3' role='alert'>".$message."</div>";
        } else {
            if(mysqli_errno($db) == 1062) {
            $message = "This season already exists.";
            echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
            }
        }
    #post process for when the button for when activating a season.
}elseif (isset($_POST['activateButton'])){
    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }
        
    #season choice cant be empty
    if (empty($_POST['inactiveSeason'])){
        $error = true;
    }else{
        $error = false;
    }

    #if there is an error, print an error message. Otherwise update database
    if($error){
        $message = "Please select a season to set as active.";
        echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
    }else{
        #check for escape strings, shouldn't be possible as both option is drop down
        $yearToActive= mysqli_real_escape_string(
            $db, $_REQUEST['inactiveSeason']);
    
        # set the current active season to inactive and set the new season as active
        $sql = "UPDATE season SET seasonStatus = 0 WHERE seasonStatus = 1";
        $sql2 = "UPDATE season SET seasonStatus = 1 WHERE seasonId = '$yearToActive' ";
        $setActive = mysqli_query($db, $sql);
        $setInactive = mysqli_query($db, $sql2);
    
        # attempts the sql insert, if it fails the uniqueError is set
        if($setActive && $setInactive){
            $message="Season has been set to active! All other seasons are set to inactive.";
            echo "<div class='alert alert-success mt-3' role='alert'>".$message."</div>";
        } else {
            $message="Error. Season was not set to active.";
            echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Season Manager</title>

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
echo "<html>";
echo "<body>";

    echo "<div style='margin-left: 20px;margin-top: 10px'>";    
    echo "<h2>Season Manager</h2>";
        echo "<h3 style='margin-left: 10px;margin-top: 15px'>Add New Season</h3>";
        # Form for adding a new season
        echo "<form style='margin-left: 15px' id='seasonAdd' action='season-manager.php' method='POST'>";
        echo "<span> Spring/Fall </span><br>";
        echo "<select name='seasonSel'>";
        echo "<option value='FALL'>Fall</option>";
        echo "<option value='SPRING'>Spring</option>";
        echo "</select><br><br>";

        # Drop down menu for current or next year
        $year = date("Y");
        $nextYear = $year +1;
        echo "<span>Year</span><br>";
        echo "<select name='year'>";
        echo "<option value='$year'>$year</option>";
        echo "<option value='$nextYear'>$nextYear</option>";
        echo "</select><br><br>";

        # submit button for adding a season
        echo "<input class='Add navbar-dark navbar-brand ' type='submit' id='addSeasonButton' name='addSeasonButton' value='Add'>";
        echo "</form>";

        echo "<h3 style='margin-left: 10px;margin-top: 15px'>Select Active Season</h3>";
        # Form for enabling the active season
        echo "<form style='margin-left: 15px' id='seasonmanager' action='season-manager.php' method='POST'>";
        # selects the inactive seasons
        $result = $db->query("select seasonId from season where seasonStatus = 0");
        echo "<span>Inactive Seasons</span><br>";
        echo "<select name='inactiveSeason'>";
        echo "<option value='' disabled selected hidden>Inactive Season</option>";

        #loops through the seasons table, grabbing inactive seasons
        while ($row = $result->fetch_assoc()) {
            $id = $row['seasonId'];
            echo "<option value='$id'>$id</option>";
        }
        echo "</select><br><br>";

        # submit button for setting the active season
        echo "<input class='Add navbar-dark navbar-brand ' type='submit' id='activateButton' name='activateButton' value='Activate'>";
        echo "</form>";
    echo "</div>";
echo"<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>";
echo "</body>";
echo "</html>";
?> 