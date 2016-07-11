<body>
<div class="container">
    <div class="jumbotron">
        <h1>You are browsing: <?php echo $_GET['name'] ?></h1>
        <div align="right">
            <a href="index.php?action=login">
                <?php
                if(session_start() && isset($_SESSION['username'])) {
                    echo $_SESSION['username'] . '   Logout';
                }else{
                    echo "Login";
                }
                ?></a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 style="text-align: center; font-style: italic;"><a href="index.php">Back Home</a><hr /></h1>
            <h2>
                <?php
                $result = $this->model->getArticles();
                foreach ($result as $items) {
                    foreach ($items as $item)
                        echo "<hr /><p style='padding: 5px 10px 10px 5px'><a href=index.php?action=articleShow&id=" . $this->model->getArticleId($item) . " >" . $item . '</a><br /></p>';
                }
                ?>
                <hr />
            <h2>
        </div>
    </div>
</div>