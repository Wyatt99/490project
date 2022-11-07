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
            header("location:create-teams.php?teamAdded");
            exit();
        } else {
            if(mysqli_errno($db) == 1062)
            header("location:create-teams.php?duplicateTeam");
            exit();
        }

    } 
}
?>

<body>
    <div style='margin-left: 20px;margin-top: 10px'>
        <h1 style='margin-left: 10px;margin-top: 15px'>Add New Team</h1>
        <?=$promptMessage();?>

        <form style='margin-left: 15px' id='createteams' action='create-teams.php' method='POST'>
        <span> Team Name </span><br>

        <input class='teamName' type='text' id='teamName' name='teamName'
        placeholder='Enter a team name' required>
        <br><br>
        
        <span> Coach First Name </span><br>
        <input class='coachFirstName' type='text' id='coachFirstName' name='coachFirstName'
        placeholder='Enter coach first name  '>
        <br><br>
    
        <span> Coach Last Name </span><br>
        <input class='coachLastName' type='text' id='coachLastName' name='coachLastName'
        placeholder='Enter coach last name' >
        <br><br>
    
        <span> Coach Email</span><br>
        <input class='coachEmail' type='text' id='coachEmail' name='coachEmail'
        placeholder='Enter coach email' >
        <br><br>


        <?php $result = $db->query("select ageGroup from ageGroup");?>

        <span>Age Group</span><br>
        <select name='ageGroup' required>
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
        </select><br><br>

        <?php $result = $db->query("select teamLocation from teamLocation");?>

        <span>Location</span><br>
        <select name='teamLocation' required>
        <option value='' disabled selected hidden>Location</option>
        <?php
        while ($row = $result->fetch_assoc()) {

            unset($id, $name);
            # see previous comments about these loop vars
            $id = $row['teamLocation'];
            $name = $row['teamLocation']; 
            echo '<option value="'.$id.'">'.$name.'</option>';
        }?>
        </select><br><br>

        <span>Season</span><br>
        <select name='seasonId' required>
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
        </select><br><br>

        <input class='Add navbar-dark navbar-brand ' type='submit' id='addTeamButton' name='addTeamButton' value='Add'>
        </form>

    </div>
        
    <!-- Bootstrap JS Bundle with Popper ***needed for navbar collapse*** -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    <footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
