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
<body>


    <h1 class='mt-4 text-center'>Season Manager</h1>
        <!--  Form for adding a new season mt-3 ml-2 -->
        <h3 class="subText  text-center mt-2 mb-3">Add New Season</h3>

        <container class="centerContent w-40">   
        <form id='seasonAdd' action='season-manager.php' method='POST'>
        <div class="row g-3 px-4 centerContent">
            <div class="col-auto mt-2 mb-0">
                <span><strong>Season</strong></span><br>
                <select class='mt-2' name='seasonSel' id='seasonSel'>
                <option value='FALL'>Fall</option>
                <option value='SPRING'>Spring</option>
            </select>
            </div>

   
            <?php
                # Drop down menu for current or next year
                $year = date("Y");
                $nextYear = $year +1;
            ?>

            <div class="col-auto mt-2">
                <span><strong>Year</strong></span><br>
                <select class='mt-2' name='year'>
                <?php
                echo"<option value='$year'>$year</option>";
                echo"<option value='$nextYear'>$nextYear</option>";
                ?>
            </select>
        </div>

        <div class="col-auto mt-4 mb-3">
            <!-- submit button for adding a season -->
            <button class="btn-primary btn-sm btn-block mt-2" type="submit" id='addSeasonButton' name='addSeasonButton' value='Add'>Add</button>
        </div>
    </div>

        <!-- Form for enabling the active season mt-4 ml-2 -->
        <h3 class="subText  text-center mt-3 mb-3">Select Active Season</h3> 
        <form style='margin-left: 15px' id='seasonmanager' action='season-manager.php' method='POST'>
        <div class="row g-3 px-4 centerContent">
            <div class="col-auto mt-2">
                <?php
                # selects the inactive seasons
                $result = $db->query("select seasonId from season where seasonStatus = 0")
                ?>
                <span><strong>Select Active</strong></span><br>
                <select class='mt-2' name='inactiveSeason'>
                <option value='' disabled selected hidden>Select</option>
                
                <?php
                #loops through the seasons table, grabbing inactive seasons
                while ($row = $result->fetch_assoc()) {
                    $id = $row['seasonId'];
                    echo "<option value='$id'>$id</option>";
                }
                ?>
                </select>
            </div>
            <div class="col-auto mt-4 mb-3">
                <!-- submit button for setting the active season -->
                <button class="btn-primary btn-sm btn-block mt-2" type="submit" id='activateButton' name='activateButton' value='Activate'>Select</button>
            </div>
    </div>
        </form>
    </container>
<?php

# post process for when the button for adding a season is clicked
if (isset($_POST['addSeasonButton'])){
    echo "<container class='centerContent w-20 px-sm-10'>";
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
            ?>
            <script type="text/javascript">
            window.location="season-manager.php?seasonAdd";
            </script>
            <?php
        } else {
            if(mysqli_errno($db) == 1062) {
                ?>
                <script type="text/javascript">
                window.location="season-manager.php?seasonConflict";
                </script>
                <?php
            }
        }
            echo "</container>";
    #post process for when the button for when activating a season.
}elseif (isset($_POST['activateButton'])){
    echo "<container class='centerContent w-20 px-sm-10'>";
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
        ?>
        <script type="text/javascript">
        window.location="season-manager.php?noSeasonSelected";
        </script>
        <?php
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

            ?>
            <script type="text/javascript">
            window.location="season-manager.php?seasonChanged";
            </script>
            <?php
            
        } else {
            ?>
            <script type="text/javascript">
            window.location="season-manager.php?seasonError";
            </script>
            <?php

        }
    }
    echo "</container>";
}

?>
<div class="centerContent"><?=$promptMessage($db)?> </div>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
</body>
<footer class='centerContent'>Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
