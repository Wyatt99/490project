<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>View Schedules</title>

	<!--Open Sans Font-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
	rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
	
 	<!--<link rel="stylesheet" type="text/css" href="css\bootstrap.css"> if wanted offline-->

	<!-- custom CSS Stylesheet -->	  
    <link rel="stylesheet" type="text/css" href="styles.css";>
</head>
<!-- END OF HEADER -->

<!-- PHP PORTION -->
<?php
#Database
include 'db.php';
include 'user-nav.php';

$res= "Select t.*, p.*, f.*, pa.* FROM team t 
       JOIN practice p ON t.teamId = p.teamId 
       JOIN field f ON f.fieldId = p.fieldId 
       JOIN park pa ON pa.parkId = f.parkId ";

if (isset($_POST['search'])){
    $searchTerm = $_POST['search_box'];

    #create time from searchTerm (MUST be followed by AM or PM)
    $time = date("G:i a", strtotime($searchTerm));
    

    #team info search
    $res .= "WHERE teamIdentifier LIKE '{$searchTerm}%' ";
    $res .= " OR coachFirstName LIKE '{$searchTerm}%'";
    $res .= " OR coachLastName LIKE '{$searchTerm}%'";
    $res .= " OR coachEmail = '{$searchTerm}'"; #maybe not worth including, just requiring exact match for now
    $res .= " OR ageGroup = '{$searchTerm}'";
    $res .= " OR teamName LIKE '{$searchTerm}%'";
    $res .= " OR teamLocation = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, ' ', coachLastName) = '{$searchTerm}'";

    #practice info search
    $res .= " OR day LIKE '{$searchTerm}%'";
    $res .= " OR fieldSection = '{$searchTerm}'"; #depending on what the sections are called can modify this if needed
    $res .= " OR fieldName = '{$searchTerm}'";
    $res .= " OR fieldName = CONCAT('field ', '{$searchTerm}')"; #an option so they dont have to type 'field ' when searching field name
    $res .= " OR parkName LIKE '{$searchTerm}%'";
    $res .= " OR startTime = '{$time}'";
    $res .= " OR endTime = '{$time}'";
}

$searchQuery=mysqli_query($db, $res);
function outputTable($db,$searchQuery){
    while($row=mysqli_fetch_array($searchQuery)){
        $timeQuery = "SELECT * from practice WHERE teamId = $row[teamId]";
        $timeResult = $db->query($timeQuery);
        $time = mysqli_fetch_all($timeResult);
        
        $fieldId = $row['fieldId'];
        $fieldSection = $row['fieldSection'];
        $parkIdRes = "SELECT * FROM field WHERE fieldId=$fieldId";
        $parkIdQuery=mysqli_query($db, $parkIdRes);
        while($parkIdRow=mysqli_fetch_array($parkIdQuery)){
            $parkId = $parkIdRow['parkId'];
            $fieldName = $parkIdRow['fieldName'];
        }
        $parkNameRes= "SELECT parkName FROM park where parkId=$parkId";
        $parkNameQuery=mysqli_query($db, $parkNameRes);
        while($parkNameRow=mysqli_fetch_array($parkNameQuery)){
            $parkName = $parkNameRow['parkName'];
            if ($parkName == "Moore Park") {
                $parkName = "Moore";
            }
            else {
                $parkName = "YSC";
            }
        }
        
        $startTime = $time[0][4];
        $endTime = $time[0][5];
        $day = $time[0][6];
        
        $startTime = date("g:i a", strtotime($startTime));
        $endTime = date("g:i a", strtotime($endTime));
         
        $practiceTime = $startTime." - ".$endTime."<br><strong>".$day."</strong>";

        echo "<tr>";
        echo  "<td><div class='mb-1'>"; echo $row["teamIdentifier"]?></div><a href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=1"> 
        <?php echo "</td>";
        echo "<td>".$practiceTime."</td>";
        echo "<td>".$parkName."<br>".$fieldName."<br>sect: ".$fieldSection."</td>";
        echo"</tr>";
      }
}

if(isset($_POST['filter'])){
    // TODO: work on drop down filtering
}

if (isset($_POST['showAll'])){
    ?>
    <script type="text/javascript">
        window.location="view-schedules.php";
    </script>
    <?php
    }
?>
<!-- END OF PHP PORTION-->

<!-- START OF BODY -->
<body>
<h1 class="text-center my-3">View Schedules</h1>
    <div class="text-center mb-3" >
    <form name="search_form" method="POST" action="view-schedules.php">
        Search: <input type="text" name="search_box" value="" class = "mb-lg-0 mb-2"/>
    <br class="d-md-none">
        <input type="submit" name="search" value="Filter">
        <input type="submit" name="showAll" value="Show All">
    </form>
    </div>

    <?=$promptMessage()?>

    <table class="table table-bordered px-1 mt-1 centerContent smallFont">
    <theadth>
    <tbody>
        <tr class="table-head">
            <th>Team</th>
            <th>Time</th>
            <th>Location</th>
        </tr>
        </thead>
        <?=outputTable($db, $searchQuery)?>
  
    </tbody>
    </table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>