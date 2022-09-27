<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';

?>
<html>
    <body>
    <?php
$error = false;
if (isset($_POST['submit'])){

$link = mysqli_connect("localhost",
            "root", "", "cajun_rush_schedule");

if($link === false){
    die("ERROR: Could not connect. "
          . mysqli_connect_error());
}

$required = array('teamName', 'ageGroup', 'teamLocation');

foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

if ($error) {
} else {
	$error= false;

$teamName= mysqli_real_escape_string(
    $link, $_REQUEST['teamName']);
$teamLocation = mysqli_real_escape_string(
    $link, $_REQUEST['teamLocation']);
$ageGroup = mysqli_real_escape_string(
    $link, $_REQUEST['ageGroup']);
$seasonSql = "SELECT * FROM season WHERE seasonStatus=1";
$seasonResult = mysqli_query($link, $seasonSql);

$activeSeason = $seasonResult->fetch_array()[0] ?? '';
$sql = "INSERT INTO team (teamName, teamLocation, ageGroup, seasonId)
        VALUES ('$teamName', '$teamLocation', '$ageGroup', '$activeSeason')";
if(mysqli_query($link, $sql)){
    ;
} else{
    echo "ERROR: data not sent!!!";
}

mysqli_close($link);
} 
}
?>
    <?php
        # start of the form, the current action is create-teams.php
        echo "<form id='createteams' action='create-teams.php' method='POST'>";
        echo "<br><br>";
        echo "<span> Team Name </span><br>";
        echo "<input class='teamName' type='text' id='teamName' name='teamName'
        placeholder='Enter a team name'>
        <br><br>";

            # the database connection 
            $conn = new mysqli('localhost', 'root', '', 'cajun_rush_schedule') 
            or die ('Cannot connect to db');
            # the sql select statement
            $result = $conn->query("select ageGroup from ageGroup");

            echo "<span> Select Age Group</span><br>";
            echo "<select name='ageGroup'>";

            # loops through all the records from ageGroup table
            while ($row = $result->fetch_assoc()) {

                unset($id, $name);
                $id = $row['ageGroup'];
                $name = $row['ageGroup']; 
                echo '<option value="'.$id.'">'.$name.'</option>';
             }

            echo "</select><br><br>";

            # new sql select statement for the teamLocation table
            $result = $conn->query("select teamLocation from teamLocation");
            echo "<span> Select Team Location</span><br>";
            echo "<select name='teamLocation'>";

            # loops through all the records for teamLocation
            while ($row = $result->fetch_assoc()) {

                unset($id, $name);
                $id = $row['teamLocation'];
                $name = $row['teamLocation']; 
                echo '<option value="'.$id.'">'.$name.'</option>';
            }

            echo "</select><br><br>";
            # submit button
            echo "<input class='Add' type='submit' id='submit' name='submit' value='Add'>";
            echo "</form>"
        ?> 
    </body>
</html>