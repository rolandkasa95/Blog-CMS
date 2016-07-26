<div class="container">
    <div class="col-md-12">
        <h1 id="h1"><a href="index.php">Back Home</a></h1><hr /><hr />
        <?php
        /**
         * Getting data from table and listing on the page (articleShow)
         */
        $article = new \Models\Article();
        $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $article->setId($id);
        $result = $article->getById();
        if(empty($result)){
            header('Location: index.php');
        }

        if(isset($_SESSION['username'])) {
            echo "<a href='index.php?action=edit&id=" . $article->getId() . "'><div id=\"edit_div\"'></div></a>";
            }
        echo '<h1 id="article_h1">' . $result['title'] . '</h1>';
        echo '<h2>' . $result['date'] . '</h2>';
        echo "</div>";
        echo "<div class='col-md-6'>";
        print '<h4>' .  $result['body'] . '</h4>';
        echo "</div>";
        echo "<div class=row>";
        echo "<div class='col-md-6'>";
        $imageURL = $result['imagePath'];
        echo "<img src='$imageURL' class='img-responsive'>";

        $result = $this->model->tagNameDisplay();

        echo "<hr>";
        echo "<h5>";
        $i=0;
        /**
         * getting tags and listing them on the page
         */
        foreach($result as $items)
            foreach($items as $key=>$row) {
                if ($i != 0) {
                    echo ",  <a href=index.php?action=tag&name=$row>" . strtolower($row) . '</a>';
                }else{
                    echo "  <a href=index.php?action=tag&name=$row>" . strtolower($row) . '</a>';
                }
                $i++;
            }
        echo "</h5>";
        ?>
</div>