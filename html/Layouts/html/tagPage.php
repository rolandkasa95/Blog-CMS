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
                /**
                 * Listing the article names ordereb by the tag name which was
                 * selected by the user
                 */
                $result = $this->model->getArticlesByTagName();
                foreach ($result as $items) {
                    foreach ($items as $key => $value)
                        if ('title' === $key) {
                            echo "<hr /><p style='padding: 5px 10px 10px 5px'><a href=index.php?action=articleShow&id=" . $this->model->getArticleId($value) . " >" . $value . '</a><br /></p>';
                        }
                }
                ?>
                <hr />
            <h2>
        </div>
    </div>
</div>