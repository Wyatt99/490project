<header>    
	<!--navigation bar start-->
    <nav class="navbar navbar-expand-lg navbar-dark bg dark">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand"><img src="images\Cajun Rush Logo-white.png" width="auto" height="30px"></a>

            <!--navbar toggle icon-->
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsable Menu-->
            <div class="collapse navbar-collapse " id="navbarCollapse">
                <div class="navbar-nav">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                      <a href="view-schedules.php" class="nav-item nav-link">Schedules</a>
                      <a href="resources.php" class="nav-item nav-link">Resources</a>
                      <a href="view-announcements.php" class="nav-item nav-link">Announcements</a>
                </div>
                <div class="navbar-nav ms-auto">
                <?php 
                if (!isset($_SESSION["name"])) {
                    ?>
                    <a href="login.php" class="nav-item nav-link">Admin</a>     	
                    <?php
                } else {
                    
                    ?>
                    <a href="admin-home.php" class="nav-item nav-link">Admin</a>
                    <a href="logout.php" class="nav-item nav-link">Log Out</a>
                    <?php
                }
                ?>         
                </div>
            </div>
        </div>
    </nav>
    <!--navigation bar end-->
</header>