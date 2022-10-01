<!DOCTYPE html>
<html lang="en-us">
<html> 
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Admin Home</title>

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

# variable default values
$error = false;
$notUniqueError="";
$requiredError="";
$insertSuccess="";

# post process for when the button submit is activated
if (isset($_POST['addTeamButton'])){

    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }

    # required fields
    $required = array('teamName', 'ageGroup', 'teamLocation');

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

        # season logic where it selects the active current season to be automatically added into the new team
        $seasonSql = "SELECT * FROM season WHERE seasonStatus=1";
        $seasonResult = mysqli_query($db, $seasonSql);
        $activeSeason = $seasonResult->fetch_array()[0] ?? '';
        $sql = "INSERT INTO team (teamName, teamLocation, ageGroup, seasonId)
        VALUES ('$teamName', '$teamLocation', '$ageGroup', '$activeSeason')";

        # attempts the sql insert, if it fails the uniqueError is set
        if(mysqli_query($db, $sql)){
            $insertSuccess="team successfully created";
        } else {
            $notUniqueError="a team name with the same age group, location, and season already exists";
        }
    } 
}

echo "<body>";
    echo "<div style='margin-left: 20px;margin-top: 10px'>";    
    # echo "<h2>Team Manager</h2>";
        echo "<h3 style='margin-left: 10px;margin-top: 15px'>Add New Team</h3>";
        # start of the form, the current action is create-teams.php
        echo "<form style='margin-left: 15px' id='createteams' action='create-teams.php' method='POST'>";
        echo "<span> Team Name </span><br>";
        echo "<input class='teamName' type='text' id='teamName' name='teamName'
        placeholder='Enter a team name'>
        <br><br>";

        # the sql select statement for ageGroup
        $result = $db->query("select ageGroup from ageGroup");

        echo "<span>Age Group</span><br>";
        echo "<select name='ageGroup'>";
        echo "<option value='' disabled selected hidden>Age Group</option>";

        # loops through all the records from ageGroup table
        while ($row = $result->fetch_assoc()) {
            unset($id, $name);
            # the id is the value that gets inserted when selected and submitted
            $id = $row['ageGroup'];
            # change the value inside of the row to populate what you want the 
            # option to be called
            $name = $row['ageGroup']; 
            echo '<option value="'.$id.'">'.$name.'u</option>';
        }
        echo "</select><br><br>";

        # new sql select statement for the teamLocation table
        $result = $db->query("select teamLocation from teamLocation");

        echo "<span>Location</span><br>";
        echo "<select name='teamLocation'>";
        echo "<option value='' disabled selected hidden>Location</option>";
        # loops through all the records for teamLocation
        while ($row = $result->fetch_assoc()) {

            unset($id, $name);
            # see previous comments about these loop vars
            $id = $row['teamLocation'];
            $name = $row['teamLocation']; 
            echo '<option value="'.$id.'">'.$name.'</option>';
        }
        echo "</select><br><br>";

        # submit button
        echo "<input class='Add navbar-dark navbar-brand ' type='submit' id='addTeamButton' name='addTeamButton' value='Add'>";
        echo "</form>";
        # prints errors
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: red;color: white; text-align: center;'>"
            .$requiredError.$notUniqueError.
        "</div>";
        # prints success message
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: green;color: white; text-align: center;'>"
            .$insertSuccess.
        "</div>";
    echo "</div>";
    ?> 
    <!--php ends -->
    
    <!-- Bootstrap JS Bundle with Popper ***needed for navbar collapse*** -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
