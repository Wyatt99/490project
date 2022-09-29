<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';
ensure_logged_in();

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
            $insertSuccess="Season has been added";
        } else {
            $notUniqueError="This season already exists";
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
            $requiredError = "Please select a season";
        }else{
            #check for escape strings, shouldn't be possible as both option is drop down
            $yearToActive= mysqli_real_escape_string(
                $db, $_REQUEST['inactiveSeason']);
    
                # set the current active season to inactive and set the new season as active
                $sql = "UPDATE season SET seasonStatus = 0 WHERE seasonStatus = 1";
                $sql2 = "UPDATE season SET seasonStatus = 1 WHERE seasonId = '$yearToActive' ";
                $test = mysqli_query($db, $sql);
    
                # attempts the sql insert, if it fails the uniqueError is set
                if(mysqli_query($db, $sql2)){
                    $activeSuccess="Season has been set to active. All other seasons are set to inactive";
                } else {
                    $inactiveError="Error. Season was not set to active";
                }
        }
    }


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
        # prints errors
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: red;color: white; text-align: center;'>"
            .$notUniqueError.
        "</div>";
        # prints success message
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: green;color: white; text-align: center;'>"
            .$insertSuccess.
        "</div>";

        echo "<h3 style='margin-left: 10px;margin-top: 15px'>Select Active Season</h3>";
        # Form for enabling the active season
        echo "<form style='margin-left: 15px' id='seasonmanager' action='season-manager.php' method='POST'>";
        # selects the inactive seasons
        $result = $db->query("select seasonId from season where seasonStatus = 0");
        echo "<span>Inactive Seasons</span><br>";
        echo "<select name='inactiveSeason'>";
        echo "<option value='' disabled selected hidden>Inactive Season</option>";

        # loops through all the records from ageGroup table
        while ($row = $result->fetch_assoc()) {
            unset($id);
            # the id is the value that gets inserted when selected and submitted
            $id = $row['seasonId'];
            # change the value inside of the row to populate what you want the 
            # option to be called
            echo "<option value='$id'>$id</option>";
        }
        echo "</select><br><br>";

        # submit button for setting the active season
        echo "<input class='Add navbar-dark navbar-brand ' type='submit' id='activateButton' name='activateButton' value='Activate'>";
        echo "</form>";
        # prints errors
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: red;color: white; text-align: center;'>"
            .$inactiveError.$requiredError.
        "</div>";
        # prints success message
        echo "<div style='margin-left: 10px; margin-top:10px; width: 15%;background-color: green;color: white; text-align: center;'>"
            .$activeSuccess.
        "</div>";
    echo "</div>";
echo "</body>";
echo "</html>";
?> 