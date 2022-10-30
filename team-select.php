<!DOCTYPE html>
<html lang="en-us">

<!-- START OF HEADER -->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Select Team</title>

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
include 'admin-nav.php';
ensure_logged_in();
checkForTeams($db);

if(isset($_SESSION['team'])) {
    unset($_SESSION['team']);
}

$res= "SELECT * FROM team LEFT JOIN practice ON team.teamID = practice.teamId";

#currently works with only showing teams who ARE scheduled already
if (isset($_POST['search'])){
    $searchTerm = $_POST['search_box'];
    $res .= " WHERE teamIdentifier = '{$searchTerm}' ";
    $res .= " OR teamName = '{$searchTerm}' ";
    $res .= " OR coachFirstName = '{$searchTerm}'";
    $res .= " OR coachLastName = '{$searchTerm}'";
    $res .= " OR coachEmail = '{$searchTerm}'";
    $res .= " OR ageGroup = '{$searchTerm}'";
    $res .= " OR teamLocation = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, '', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachFirstName, ' ', coachLastName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, '', coachFirstName) = '{$searchTerm}'";
    $res .= " OR CONCAT(coachLastName, ' ', coachFirstName) = '{$searchTerm}'";
    
}

$query=mysqli_query($db, $res);

function outputTable($query){
    while($row=mysqli_fetch_array($query)){
        if (!$row["teamId"]){ #if teamId NOT found in practice database on join, display results
        echo "<tr>";
        echo  "<td>"; echo $row["teamIdentifier"]."</td>";
        echo  "<td>"; ?> <a href="parkselect.php?team=<?php echo $row["teamIdentifier"];?>&update=0"> <button type="button" class= "btn btn-success">Schedule</button></a> <?php echo "</td>"; #update team
        echo"</tr>";
        }
      }
}

if (isset($_POST['showAll'])){
    ?>
        <script type="text/javascript">
        window.location="team-select.php";
        </script>
    <?php
    }
?>

<!-- END OF PHP PORTION-->

<!-- START OF BODY -->
<body>
<h1 class="centerContent my-3">Unscheduled Teams</h1>
<div class="text-center p-2 mb-2" >
<form name="search_form" method="POST" action="team-select.php">
    Search: <input type="text" name="search_box" value="" />
<input type="submit" name="search" value="Filter">
<input type="submit" name="showAll" value="Show All">
</form>
</div>

<div class="col-lg-12 p-2">
<?=$promptMessage()
?>
<table class="table table-bordered mx-lg-2 centerContent">
<tbody>
    <thead>
      <tr>
        <th>Team</th>
        <th>Schedule</th>
      </tr>
      <?=outputTable($query)?>
    </thead>
</tbody>

</table>
    

<?php
if (isset($_POST['addAnnounButton'])){

    if($db === false){
        die("ERROR: Could not connect. ". mysqli_connect_error());
    }
    $announcement= mysqli_real_escape_string(
        $db, $_REQUEST['announcement']);
   
    
    $sql = "INSERT INTO announcements (announcement)
        VALUES ('$announcement')";

        # attempts the sql insert, if it fails the uniqueError is set
        if(mysqli_query($db, $sql)){
            $message="Announcement has been added!";
            echo "<div class='alert alert-success mt-3' role='alert'>".$message."</div>";
        } else {
            if(mysqli_errno($db) == 1062) {
            $message = "This Announcement already exists.";
            echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
            }
        }
}
    echo "<div style='margin-left: 20px;margin-top: 10px'>";    
    echo "<h1 class='mt-2'>Season Manager</h1>";
        echo "<h4 class='mt-3 ml-2'>Add New Season</h4>";
        # Form for adding a new season
        echo "<form style='margin-left: 15px' id='seasonAdd' action='season-manager.php' method='POST'>";
        echo "<span> Spring/Fall </span><br>";
        echo "<select name='seasonSel'>";
        echo "<option value='FALL'>Fall</option>";
        echo "<option value='SPRING'>Spring</option>";
        echo "</select><br><br>";
?>
    
    
    <!--Start weather widget-->
<div id="m-booked-bl-simple-week-vertical-24591">
   <div class="booked-wzs-160-275 weather-customize" style="background-color:#137AE9; width:160px;" id="width1 " >
      <div class="booked-wzs-160-275_in">
         <div class="booked-wzs-160-275-data">
            <div class="booked-wzs-160-275-left-img wrz-18"></div>
            <div class="booked-wzs-160-275-right">
               <div class="booked-wzs-day-deck">
                  <div class="booked-wzs-day-val">
                     <div class="booked-wzs-day-number"><span class="plus">+</span>81</div>
                     <div class="booked-wzs-day-dergee">
                        <div class="booked-wzs-day-dergee-val">&deg;</div>
                        <div class="booked-wzs-day-dergee-name">F</div>
                     </div>
                  </div>
                  <div class="booked-wzs-day">
                     <div class="booked-wzs-day-d"><span class="plus">+</span>88&deg;</div>
                     <div class="booked-wzs-day-n"><span class="plus">+</span>69&deg;</div>
                  </div>
               </div>
               <div class="booked-wzs-160-275-info">
                  <div class="booked-wzs-160-275-city">Lafayette</div>
                  <div class="booked-wzs-160-275-date">Wednesday, 12</div>
               </div>
            </div>
         </div>
         <table cellpadding="0" cellspacing="0" class="booked-wzs-table-160">
            <tr>
               <td class="week-day"> <span class="week-day-txt">Thursday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-18"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>88&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>69&deg;</td>
            </tr>
            <tr>
               <td class="week-day"> <span class="week-day-txt">Friday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-01"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>85&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>65&deg;</td>
            </tr>
            <tr>
               <td class="week-day"> <span class="week-day-txt">Saturday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-06"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>87&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>68&deg;</td>
            </tr>
            <tr>
               <td class="week-day"> <span class="week-day-txt">Sunday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-18"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>86&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>70&deg;</td>
            </tr>
            <tr>
               <td class="week-day"> <span class="week-day-txt">Monday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-18"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>82&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>71&deg;</td>
            </tr>
            <tr>
               <td class="week-day"> <span class="week-day-txt">Tuesday</span></td>
               <td class="week-day-ico">
                  <div class="wrz-sml wrzs-18"></div>
               </td>
               <td class="week-day-val"><span class="plus">+</span>68&deg;</td>
               <td class="week-day-val"><span class="plus">+</span>57&deg;</td>
            </tr>
         </table>
         <div class="booked-wzs-center"> <span class="booked-wzs-bottom-l">7-Day Forecast</span> </div>
      </div>
   </div>
</div>
<script type="text/javascript"> var css_file=document.createElement("link"); var widgetUrl = location.href; css_file.setAttribute("rel","stylesheet"); css_file.setAttribute("type","text/css"); css_file.setAttribute("href",'https://s.bookcdn.com/css/w/booked-wzs-widget-160x275.css?v=0.0.1'); document.getElementsByTagName("head")[0].appendChild(css_file); function setWidgetData_24591(data) { if(typeof(data) != 'undefined' && data.results.length > 0) { for(var i = 0; i < data.results.length; ++i) { var objMainBlock = document.getElementById('m-booked-bl-simple-week-vertical-24591'); if(objMainBlock !== null) { var copyBlock = document.getElementById('m-bookew-weather-copy-'+data.results[i].widget_type); objMainBlock.innerHTML = data.results[i].html_code; if(copyBlock !== null) objMainBlock.appendChild(copyBlock); } } } else { alert('data=undefined||data.results is empty'); } } var widgetSrc = "https://widgets.booked.net/weather/info?action=get_weather_info;ver=7;cityID=3204;type=4;scode=124;ltid=3458;domid=w209;anc_id=34260;countday=undefined;cmetric=0;wlangID=1;color=137AE9;wwidth=160;header_color=ffffff;text_color=333333;link_color=08488D;border_form=1;footer_color=ffffff;footer_text_color=333333;transparent=0;v=0.0.1";widgetSrc += ';ref=' + widgetUrl;widgetSrc += ';rand_id=24591';var weatherBookedScript = document.createElement("script"); weatherBookedScript.setAttribute("type", "text/javascript"); weatherBookedScript.src = widgetSrc; document.body.appendChild(weatherBookedScript) </script>
    <!--End weather widget-->
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
<!-- END OF BODY -->
<footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>