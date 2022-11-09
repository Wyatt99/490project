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
    $announcement = $_POST['announcement'];
    $sql = "INSERT INTO announcements (announcement) VALUES ('$announcement')";
    $db ->query($sql);
}

?>

<body class='centerContent'>
    <div style='margin-left: 20px;margin-top: 10px; align-content: center;'>
        <h1 style='margin-left: 10px;margin-top: 15px; align-content: center;'>Add New Announcement</h1>
        <?=$promptMessage();?>

        <form style='margin-left: 15px; align-content: center;' id='createteams' action='add-announcements.php' method='POST'>
        <span> Type an announcement to post: </span><br>

        <input class='teamName'style='height: 150px; width: 400px;' type='text' id='announcement' name='announcement'
        placeholder='Announcement Message' required>
        <br><br>

        <input class='Add navbar-dark navbar-brand ' type='submit' id='addTeamButton' name='addTeamButton' value='Post'>
        </form>

    </div>
        
    <!-- Bootstrap JS Bundle with Popper ***needed for navbar collapse*** -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    <footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
