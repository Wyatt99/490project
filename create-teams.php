<!DOCTYPE html>
<html lang="en-us">
<html> 
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Create Teams</title>

    <!--Open Sans Font-->
    <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans' />

    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' 
    rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'> 

    <!-- Font Awesome icon library -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css'>

    <!-- custom CSS Stylesheet -->	  
    <link rel='stylesheet' type='text/css' href='styles.css';>
</head>

<!--php outputs body element-->
<?php 
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();
mysqli_report(MYSQLI_REPORT_STRICT);

# variable default values
$error = false;

# post process for when the button submit is activated
if (isset($_POST['addTeamButton'])){

    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    # required fields
    $required = array('teamName', 'ageGroup', 'teamLocation', 'seasonId');

    # checks required fields, sets empty var to true if one is empty
    foreach($required as $field) {
        if (empty($_POST[$field])) {
            $error = true;
        }
    }

    # if fields are empty sets requiredError var, else it moves on
    if ($error) {
        $requiredError="please enter a team name and select all fields";
    } else {
	    $error= false;
        
        #db variables and checks for escape strings
        $teamName= mysqli_real_escape_string(
        $db, $_REQUEST['teamName']);
        $teamLocation = mysqli_real_escape_string(
        $db, $_REQUEST['teamLocation']);
        $ageGroup = mysqli_real_escape_string(
        $db, $_REQUEST['ageGroup']);
        $seasonId = mysqli_real_escape_string(
        $db, $_REQUEST['seasonId']);
        $coachFirstName= mysqli_real_escape_string(
        $db, $_REQUEST['coachFirstName']);
        $coachLastName= mysqli_real_escape_string(
        $db, $_REQUEST['coachLastName']);
        $coachEmail= mysqli_real_escape_string(
        $db, $_REQUEST['coachEmail']);
         
        # get max id num	
		$IdQuery = $db->query("select teamId from team");
		$IdNumber = 0;
        while ($row = $IdQuery->fetch_assoc()) {
            unset($id);
            $id = $row['teamId'];
			if($IdNumber < $id) {
				$IdNumber = $id;
			}
        }
        $IdNumber++;

        #concatenate team data into a capitalized string in the form NSWWOODALL7u/CRUSADERS 
        $teamIdentifier = strtoupper($teamLocation."_".substr($coachFirstName,0,1).$coachLastName."_".$ageGroup)."u/".strtoupper($teamName);
        
        $sql = "INSERT INTO team (teamId, teamIdentifier, teamName, teamLocation, ageGroup, seasonId, coachFirstName, coachLastName, coachEmail)
        VALUES ('$IdNumber','$teamIdentifier','$teamName', '$teamLocation', '$ageGroup', '$seasonId','$coachFirstName','$coachLastName','$coachEmail')";


#ERROR MESSAGE
        # attempts the sql insert, if it fails the uniqueError is set
        if(mysqli_query($db, $sql)){
            ?>
            <script type="text/javascript">
            window.location="create-teams.php?teamAdded";
            </script>
            <?php
        } else {
            
            ?>
            <script type="text/javascript">
            window.location="create-teams.php?duplicateTeam";
            </script>
            <?php
        }

    } 
}
?>
<body>
    <h5 class="text-center" style="color: rgb(31, 107, 214); margin-bottom: -15px; margin-top: 15px;">Active Season: <?=getActiveSeason($db)?></h5>
    <h1 class='text-center mt-4 mb-2'>Add New Team</h1>
    <?=$promptMessage($db);?>

    <container class="centerContent mx-auto mb-3">
        <form style='width:60%;' id='createteams' action='create-teams.php' method='POST'>

        <div class="row align-items-center mt-1 centerContent">

        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
            <span><strong>Team Name</strong></span><br>
            <input class='mt-2' type='text' id='teamName' name='teamName'
            placeholder='Enter a team name' required>
        </div>
        
        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
            <span><strong>Coach First Name</strong></span><br>
            <input class='mt-2' type='text' id='coachFirstName' name='coachFirstName'
            placeholder='Enter coach first name  '>
        </div>
    
        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
            <span><strong>Coach Last Name</strong></span><br>
            <input class='mt-2' type='text' id='coachLastName' name='coachLastName'
            placeholder='Enter coach last name' >
        </div>
    
        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
            <span><strong>Coach Email</strong> (optional)</span><br>
            <input class='mt-2' type='text' id='coachEmail' name='coachEmail'
            placeholder='Enter coach email' >
        </div>
    </div> <!--row end-->

        <?php $result = $db->query("select ageGroup from ageGroup");?>

    <div class="row align-items-center g-3 mt-1 centerContent">

        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
        <span><strong>Age Group</strong></span><br>
        <select class='mt-2' name='ageGroup' required>
        <option value='' disabled selected hidden>Age Group</option>

        <?php
        while ($row = $result->fetch_assoc()) {
            unset($id, $name);
            # the id is the value that gets inserted when selected and submitted
            $id = $row['ageGroup'];
            # change the value inside of the row to populate what you want the 
            # option to be called
            $name = $row['ageGroup']; 
            echo '<option value="'.$id.'">'.$name.'u</option>';
        }?>
        </select>
        </div>
        <?php $result = $db->query("select teamLocation from teamLocation");?>

        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
        <span><strong>Location</strong></span><br>
        <select class='mt-2' name='teamLocation' required>
        <option value='' disabled selected hidden>Location</option>
        <?php
        while ($row = $result->fetch_assoc()) {
            unset($id, $name);
            # see previous comments about these loop vars
            $id = $row['teamLocation'];
            $name = $row['teamLocation']; 
            echo '<option value="'.$id.'">'.$name.'</option>';
        }?>
        </select>
        </div>

        <div class="col-12 col-md-auto mt-2 mt-lg-3 mb-2">
        <span><strong>Season</strong></span><br>
        <select class='mt-2' name='seasonId' required>
        <option value='' disabled selected hidden>Season</option>
        <?php
        $result = $db->query("select seasonId from season");
        # loops through all the seasons 
        while ($row = $result->fetch_assoc()) {
            unset($seasonId);
            # the id is the value that gets inserted when selected and submitted
            $seasonId = $row['seasonId'];
            # change the value inside of the row to populate what you want the 
            # option to be called
            echo '<option value="'.$seasonId.'">'.$seasonId.'</option>';
        }?>
        </select>
        </div>

        <div class='col-12 col-md-auto mt-3 mb-2'>
        <button class="btn-primary btn-sm btn-block mt-0 mt-lg-4" type="submit" id='activateButton' name='addTeamButton' value='addTeamButton'>Add</button>
        </div>
    </div> <!--row ends-->
        </form>
    </container>
    
<!-- Bootstrap JS Bundle with Popper ***needed for navbar collapse*** -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
