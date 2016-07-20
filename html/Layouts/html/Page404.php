<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div id='header_div'>
            <a href="index.php?action=login"> <?php
                if(session_start() && isset($_SESSION['username'])){
                    echo $_SESSION['username'] . '   Logout';
                }else{
                    header("Location: index.php?action=login ");
                }
                ?></a>
        </div>
    </div>
</div>
<div class="container">
    <h1>Page Not Found: 404</h1>
</div>