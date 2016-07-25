<div class="container">
    <div class="col-md-12">
        <h1 id="h1"><a href="index.php">Back Home</a></h1><hr /><hr />
        <?php
        /**
         * Getting data from table and listing on the page (articleShow)
         */
        $result = $this->model->showArticle();
        if(empty($result)){
            header('Location: index.php');
        }
        foreach ($result as $key=>$row){
                if ('title' === $key){
                    if(isset($_SESSION['username'])) {
                        echo "<a href='index.php?action=edit&id=" . $this->model->getArticleId($row) . "'><div id=\"edit_div\"'></div></a>";
                        }
                    echo '<h1 id="article_h1">' . $row . '</h1>';
                }elseif ('date' === $key){
                    echo '<h2>' . $row . '</h2>';

                }elseif('imagePath' === $key && !empty($row)){
                    echo "<div class='col-md-6'>";
                    echo "<img src='$row' class='img-responsive'>";
                }else{
                    echo "<div class='col-md-6'>";
                    print '<h4>' .  $row . '</h4>';
                    echo "</div>";
                }

            }
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
</div>