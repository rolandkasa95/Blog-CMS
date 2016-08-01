<body>

<div class="container">
    <div class="col-md-12">
        <?php
        $articles = new \Models\Articles();
        $articles->setLimit(0);
        $articles->getWithLimitation();
        foreach($articles->articleArray as $item){
            $article = new \Models\Article();
            $article->setTitle($item['title']);
            if(isset($_SESSION['username'])) {
                echo "<a href='index.php?action=edit&id=" . $article->getByTitle()['article_id'] . "'><div id=\"edit_div\"'></div></a>";
            }
            echo "<h2><a href='index.php?action=articleShow&id='". $article->getByTitle()['article_id'] . ">" . $item['title'] . "</a></h2>";
            echo "<h4>" .  $item['date'] . "<hr /></h4>";
        }
        ?>
    </div>
</div>

</body>