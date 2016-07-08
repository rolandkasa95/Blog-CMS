<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Webserver Landing Page</title>
    <meta name="generator" content="PuPHPet.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">pre { background: #444; color:#fff; border-style: none; }</style>
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js?"></script><![endif]-->
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div align="right">
            <a href="index.php?action=login"> <?php
                if(session_start() && isset($_SESSION['username'])){
                    echo $_SESSION['username'] . '   Logout';
                }else{
                    echo "Login";
                }
                ?></a>
        </div>
    </div>
</div>
<div class="container">
    <div class="col-md-1">
    </div>
    <div class="col-md-11">
        <h1 style="font-style: italic;"><a href="index.php">Back Home</a></h1><br />
        <?php
        $result = $this->model->showArticle();
        foreach ($result as $items)
            foreach ($items as $key=>$row) {
                if ('title' === $key){
                    echo '<h1>' . $row . '</h1>';
                }elseif ('date' === $key){
                    echo '<h2>' . $row . '</h2>';
                }else{
                    echo '<h4>' . $row . '</h4>';
                }
            }
        $result = $this->model->tagNameDisplay();
        echo "<h5>";
        $i=0;
        foreach($result as $items)
            foreach($items as $key=>$row) {
                if ($i != 0) {
                    echo ",  <a href=index.php?action=tag&name=$row>" . $row . '</a>';
                }else{
                    echo "  <a href=index.php?action=tag&name=$row>" . $row . '</a>'        ;
                }
                $i++;
            }
        echo "</h5>";
        ?>
    </div>
</div>