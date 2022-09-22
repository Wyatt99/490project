<?php 
include 'head.php'; //html head 
include('db.php'); //connect to database

#if username and password are submitted, create variables
if (isset($_POST["name"]) && isset($_POST["password"])) {
    $name = $_POST["name"];
    $password = $_POST["password"];

#call function in db.php to validate the password
if (is_password_correct($name, $password, $db)) {
    #if existing session, destroy old and start new
    if (isset($_SESSION)) {
      session_destroy();
      session_regenerate_id(TRUE);
      session_start();
    }
    # if user and pass match, remember user info and redirect to home
    $_SESSION["name"] = $name;     
    header("location: admin-home.php");
  }
  #else reload login page with error message
  else {
    header("location: login.php?err");
  }
}

#error message to display if login credentials do not match database
$errorMessage = function() {
    if (isset($_GET['err'])) {
        $message = "Invalid credentials, please try again.";
        echo "<div class='alert alert-danger mt-3' role='alert'>".$message."</div>";
    }
}
?> <!--php ends-->

<body>
    <img src="images\CajunRushLogo.png" class="mx-auto d-flex pt-5 pb-0" width="110px" height="auto" alt="cajun rush logo">
    <div class="d-flex justify-content-center mx-auto">

    <form method="post">
        <h3 class="fw-normal mx-auto d-flex justify-content-center mb-4 mt-4">Admin Login</h3>
        <div class="form-outline mb-2">
            <input type="text" name="name" id="name" class="form-control form-control-lg"/>
            <label class="form-label" for="name">Username</label>
        </div>

        <div class="form-outline mb-2">
            <input type="password" name="password" id="password" class="form-control form-control-lg" />
            <label class="form-label" for="password">Password</label>
        </div>

            <button class="btn-primary btn-lg btn-block" type="submit" name='submit' value='Login'>Login</button>
            <?=$errorMessage()?> <!--call error message function-->
        </form>
        
    </div>
	<!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>