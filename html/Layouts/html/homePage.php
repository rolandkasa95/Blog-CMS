<body>

<div class="container">
    <div class="col-md-12">
        <?php
        if(isset($_SESSION['username'])){
            echo "<h2><a href=\"index.php?action=adminPanel\">Admin Panel</a></h2><hr />";
        }
        ob_start();
        $articles = new \Models\Articles();
        if(isset($_GET['offset'])){
            $offset = (int) $_GET['offset'];
        }else{
            $offset = 0;
        }
        $articles->setLimit(5*$offset);
        $articles->getWithLimitation();
        ob_end_clean();
        foreach($articles->articleArray as $item){
            $article = new \Models\Article();
            $article->setTitle($item['title']);
            $article->setId($article->getByTitle()['article_id']);
            if(isset($_SESSION['username'])) {
                echo "<a href='index.php?action=edit&id=" . $article->getId() . "'><div id=\"edit_div\"'></div></a>";
            }
            echo "<h2><a href=index.php?action=articleShow&id=". $article->getId() . ">" . $item['title'] . "</a></h2>";
            echo "<h4>" .  $item['date'] . "<hr /></h4>";
        }
        ?>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <?php
            if(isset($_GET['offset'])) {
                ?>
                <div class="col-md-6">
                    <?php
                    $offset = (int)$_GET['offset'];
                    if (0 !== $offset) {
                        echo "<h4><a href=index.php?offset=" . --$offset . ">Previous Articles</a></h4>";
                    }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    if (1){
                        $offset = (int)$_GET['offset'];
                        echo "<h4 align='right'><a href=index.php?offset=" . ++$offset . ">Next Articles</a></h4>";
                    }
                    ?>
                </div>
                <?php
            }else{
            ?>
            <div class="col-md-12">
                <?php
                echo "<h4 align='right'><a href=index.php?offset=" . ++$offset . ">Next Articles</a></h4>";
                }
                ?>
            </div>
        </div>
    </div>
</footer>

</body>