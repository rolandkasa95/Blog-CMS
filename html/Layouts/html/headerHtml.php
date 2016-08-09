<html lang="en">
<body>
<div class="container">
    <div class="jumbotron">
        <h1><a class="header-reference" href="homePage.php">My Blog<a></h1>
        <div id="header_div">
            <a href="index.php?action=login">
                <?php
                if(PHP_SESSION_ACTIVE !== session_status()) {
                    if (session_start() && isset($_SESSION['username'])) {
                        echo $_SESSION['username'] . '   Logout';
                    } else {
                        echo "Login";
                    }
                }else{
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'] . '   Logout';
                    }
                }
                ?></a>
        </div>
    </div>
</div>