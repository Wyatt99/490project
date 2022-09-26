<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';

?>
<html>
    <body>
    <?php
        # start of the form, the current action is create-teams.php
        echo "<form id='createteams' action='create-teams.php' method='POST'>";
        echo "<br><br>";
        echo "<span> Team Name </span><br>";
        <input class='teamname' type='text' id='teamname'
        placeholder='Enter a team name'>
        <br><br>

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