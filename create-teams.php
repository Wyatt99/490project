<?php 
include 'head.php';
include 'db.php';
include 'admin-nav.php';

?>
<html>
<body>
<span> Team Name </span>
<input class="teamname" type="text" id="teamname" 
placeholder="Enter a team name">
<br>
<?php

$conn = new mysqli('localhost', 'root', '', 'cajun_rush_schedule') 
or die ('Cannot connect to db');

    $result = $conn->query("select ageGroup from ageGroup");

    echo "<html>";
    echo "<body>";
    echo "<select name='ageGroup'>";

    while ($row = $result->fetch_assoc()) {

                  unset($id, $name);
                  $id = $row['ageGroup'];
                  $name = $row['ageGroup']; 
                  echo '<option value="'.$id.'">'.$name.'</option>';

}

    echo "</select>";
    echo "</body>";
    echo "</html>";
?> 
</select>

</html>