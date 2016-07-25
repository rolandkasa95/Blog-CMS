<html lang="en">
<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
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