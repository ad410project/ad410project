<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <!-- Brand/logo -->
    <a class="navbar-brand" href="?controller=static&action=landing">Kamparoos</a>

    <!-- Links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="?controller=static&action=profile">Profile</a>
        </li>

        <?php
        // Initialize the session
        session_start();
        //3.1.4 if the user is logged in Greets the user with message
        if (isset($_SESSION['emailAddress'])) {
            $emailAddress = $_SESSION['emailAddress'];
            echo '<li class="nav-item"><a href="?controller=static&action=logout">[' . $emailAddress . '] Logout</a></li>';
        } else {
            //3.2 When the user visits the page first time, simple login form will be displayed.
            echo '<li class="nav-item"><a href="?controller=static&action=login">Login</a></li>';
            echo '<li class="nav-item"><a class="nav-link" href="?controller=static&action=registration">Sign Up</a></li>';
        }
        ?>
    </ul>
</nav>