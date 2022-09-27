<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

# error variables default values
$error = false;
$notUniqueError="";
$requiredError="";

# post process for when the button submit is activated
if (isset($_POST['submit'])){

    # db link
    $link = mysqli_connect("localhost","root", "", "cajun_rush_schedule");

    if($link === false){
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
        $requiredError="please select all fields";
    } else {
	    $error= false;
        
        #db variables and checks for escape strings
        $teamName= mysqli_real_escape_string(
        $link, $_REQUEST['teamName']);
        $teamLocation = mysqli_real_escape_string(
        $link, $_REQUEST['teamLocation']);
        $ageGroup = mysqli_real_escape_string(
        $link, $_REQUEST['ageGroup']);

        # season logic where it selects the active current season to be automatically added into the new team
        $seasonSql = "SELECT * FROM season WHERE seasonStatus=1";
        $seasonResult = mysqli_query($link, $seasonSql);
        $activeSeason = $seasonResult->fetch_array()[0] ?? '';
        $sql = "INSERT INTO team (teamName, teamLocation, ageGroup, seasonId)
        VALUES ('$teamName', '$teamLocation', '$ageGroup', '$activeSeason')";

            # attempts the sql insert, if it fails the uniqueError is set
            if(mysqli_query($link, $sql)){
                ;
            } else{
                $notUniqueError="the team name already exisits in that ageGroup and location for this season";
            }

        # closes the db link for the post process
        mysqli_close($link);
    } 
}

echo "<html>";
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

        # the database connection to populate the ageGroup dropdown
        $conn = new mysqli('localhost', 'root', '', 'cajun_rush_schedule') or die ('Cannot connect to db');
        # the sql select statement
        $result = $conn->query("select ageGroup from ageGroup");

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
            echo '<option value="'.$id.'">'.$name.'</option>';
        }
        echo "</select><br><br>";

        # new sql select statement for the teamLocation table
        $result = $conn->query("select teamLocation from teamLocation");

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
        echo "<input class='Add navbar-dark navbar-brand ' type='submit' id='submit' name='submit' value='Add'>";
        echo "</form>";
        # prints errors
        echo $requiredError.$notUniqueError;
    echo "</div>";
echo "</body>";
echo "</html>";
?> 