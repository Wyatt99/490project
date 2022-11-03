<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Schedules</title>

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
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo "<td>".$practiceTime."</td>";
        echo "<td>".$parkName."<br>".$fieldName."</td>";

        echo "<td>".$fieldSection."</td>";
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
<h1 class="centerContent my-3">View Schedules</h1>
    <div class="text-center p-2 mb-2" >
    <form name="search_form" method="POST" action="view-schedules.php">
        Search: <input type="text" name="search_box" value="" class = "mb-lg-0 mb-2"/>
    <br class="d-md-none">
        <input type="submit" name="search" value="Filter">
        <input type="submit" name="showAll" value="Show All">
    </form>
    </div>

    <?=$promptMessage()?>

    <div class="centerContent tableView">
    <table class="table table-bordered mx-l-2 centerContent smallFont">
    <tbody>
        <thead>
        <tr>
            <th>Team</th>
            <th>Time</th>
            <th>Park/Field </th>
            <th>Sect.</th>
        </tr>
        <?=outputTable($db, $searchQuery)?>
        </thead>
    </tbody>
    </table>
    </div>
    <h3  class="centerContent my-3">Moore Park</h3>
    <span> 
        <div class="centerContent my-3" style="border:5px;">
        <iframe width="280" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=280&amp;height=300&amp;hl=en&amp;q=198%20Laser%20Ln,%20Lafayette,%20LA%2070507%20%20Lafayette+(Moore%20Park%20)&amp;t=k&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </span>
    <h3  class="centerContent my-3">Youngsville Sports Complex</h3>
    <span>
        <div class="centerContent my-3" style="border:5px;">
        <iframe width="280" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" id="gmap_canvas" src="https://maps.google.com/maps?width=280&amp;height=300&amp;hl=en&amp;q=801%20Savoy%20Rd,%20Youngsville,%20LA%2070592%20%20Lafayette+(Youngsville%20Sports%20Complex)&amp;t=k&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
        </div>
    </span>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>