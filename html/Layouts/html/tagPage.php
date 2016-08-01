<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 id="h1"><a href="index.php">Back Home</a><hr /></h1>
            <h2>
                <?php
                /**
                 * Listing the article names ordereb by the tag name which was
                 * selected by the user
                 */
                $articles = new \Models\Articles();
                $articles->getWithSelectedTag($_GET['name']);
                $result = $articles->articleArray;
                foreach ($result as $items) {
                    foreach ($items as $key => $value)
                        if ('title' === $key) {
                            $article = new \Models\Article();
                            $article->setTitle($value);
                            echo "<hr /><p id='p_tag'><a href=index.php?action=articleShow&id=" . $article->getByTitle()['article_id'] . " >" . $value . '</a><br /></p>';
                        }
                }
                ?>
                <hr />
            <h2>
        </div>
    </div>
</div>