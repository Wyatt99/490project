<header>    
	<!--navigation bar start-->
    <nav class="navbar navbar-expand-lg navbar-dark bg dark">
        <div class="container-fluid">
            <a href="admin-home.php" class="navbar-brand"><img src="images\Cajun Rush Logo-white.png" width="auto" height="30px"></a>

            <!--navbar toggle icon-->
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsable Menu-->
            <div class="collapse navbar-collapse " id="navbarCollapse">
                <div class="navbar-nav">
                <ul class="navbar-nav">
                    <a href="admin-home.php" class="nav-item nav-link">Home</a>
                    <a href="season-manager.php" class="nav-item nav-link">Seasons</a>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" 
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Teams</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="create-teams.php">Create Team</a></li>
                            <li><a class="dropdown-item" href="update-team.php">Edit Teams</a></li>
                            <li><a class="dropdown-item" href="view-teams.php">View Teams</a></li>
                        </ul>
                    </li>


                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" 
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Schedule</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="team-select.php">Schedule Practices</a></li>
                        <li><a class="dropdown-item" href="scheduled-teams.php">View Schedules</a></li>
                    </ul>
                </li>
                </ul>
                </div>
                <div class="navbar-nav ms-auto">         
                    <a href="index.php" class="nav-item nav-link">User Site</a> 
                                        <a href="register.php" class="nav-item nav-link">Register</a>     	
                    <a href="logout.php" class="nav-item nav-link">Log Out</a>
                </div>
            </div>
        </div>
    </nav>
    <!--navigation bar end-->
</header>
