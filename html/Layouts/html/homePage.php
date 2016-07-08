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
                <a href="index.php?action=login">Login|Logout</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-1"></div>
        <div class="col-md-8">
            <h2>
            <?php
            $result = $this->model->getArticles();
            foreach($result as $row => $key)
            {
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br /><br />';
            }
            ?>
                <h2>
        </div>
    </div>
</body>
