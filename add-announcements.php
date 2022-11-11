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
if (isset($_GET['submit'])){
    $announcement = $_GET['announcement'];
    $date = date("Y/m/d");
    $annPrep = $db -> prepare("INSERT INTO announcements(announcement, adminID, announcementDate) VALUES (?, ?, ?)");
    $annPrep -> bind_param("sis", $announcement, $_SESSION['adminId'], $date);
    $annPrep -> execute();
    header("location: add-announcements.php?postSuccess");
    exit();
}
?>

<body>
    <div class='text-center'>
        <h1 class='mt-4'>Add Announcement</h1>
        <?=$promptMessage();?>
        <p>Type an announcement to post: </p>
        </div>

        <form class='mx-auto' id='announcement' action='add-announcements.php' method='GET'>
        <textarea style='height: 150px; width: 350px;' id='announcement' name='announcement'
        required></textarea>
        <br>
        <button class="d-block btn-primary btn-lg btn-block mt-2 ms-auto" type="submit" id='submit' name='submit' value='submit'>Post</button>
        </form>



        
    <!-- Bootstrap JS Bundle with Popper ***needed for navbar collapse*** -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    <footer class="centerContent">Copyright &copy 2022 Cajun Rush Soccer Club</footer>
</html>
