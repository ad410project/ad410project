<div class="container-fluid">
    <nav class="navbar fixed-top navbar-expand-sm bg-light justify-content-end">
        <a class="navbar-brand" href="?controller=static&action=landing"><img src="views/images/Fun_LogoBanner.png" alt="Logo" class="logo-banner"></a>
        <ul class="navbar-nav">
            <?php
            // Initialize the session
            session_start();
            //3.1.4 if the user is logged in Greets the user with message
            if (isset($_SESSION['emailAddress'])) {
                echo '<li class="nav-item"><a class="nav-link" href="?controller=dynamic&action=home">Home</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="?controller=dynamic&action=userProfile">Profile</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="?controller=dynamic&action=logout">Logout</a></li>';
            } else {
                //3.2 When the user visits the page first time, simple login form will be displayed.
                echo '<li class="nav-item"><a class="nav-link" href="?controller=dynamic&action=registration">Sign Up</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="?controller=dynamic&action=login">Login</a></li>';
            }
            ?>
        </ul>
    </nav>
</div>
