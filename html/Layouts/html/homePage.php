 <div class="container">
        <div class="col-md-12">
            <h2>
            <?php
            /**
             * Listing the articles descendently
             */
            if(isset($_GET['offset'])) {
                $offset = (int)$_GET['offset'];
            }else{
                $offset=0;
            }
            if(isset($_SESSION['username'])){
                echo "<a href='index.php?action=adminPanel'>Admin Panel<a/>";
            }
            if(isset($_GET['offset'])){
                $results = $this->model->getArticles($offset * 5);
            }else{
                $results = $this->model->getArticles(0);
            }
            echo "<hr />";
            foreach($results as $result)
            {
                $this->model = new \Models\Article();
                $this->model->setId($result['article_id']);
                if(isset($_SESSION['username'])) {
                    echo "<a href='index.php?action=edit&id=" . $this->model->getId() . "'><div id='edit_div'></div></a>";
                }
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getId() . " >" . $result['title'] . '</a><br />';
                echo $result['date'] . '<br /><hr />';
            }
            ?>
                <hr />
            <h2>
        </div>
        <div class="col-md-6">
            <?php
            if (isset($offset) && 1 === $offset){
                ?>
                <p id="p_left"><a href="index.php">Previous 5 articles</a></p>
                <?php
            }else
                ?>
            <?php
                if(isset($offset) && 1 < $offset ){
            ?>
            <p id="p_left"><a href="index.php?offset=<?php echo --$offset ?>">Previous 5 articles</a></p>
            <?php
                }
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $offset = 1;
            if (isset($_GET['offset'])) {
                $offset = (int)$_GET['offset'];
            }
            if(!empty($this->model->getArticles(++$offset*5))) {
                if (isset($_GET['offset']) && 1 <= $offset) {
                     if (isset($_GET['offset'])) {
                        $offset = (int)$_GET['offset'];
                    }
                    ?>
                    <p id="p_right""><a href="index.php?offset=<?php echo ++$offset ?>">Next 5 articles</a>
                    </p>
                <?php } else { ?>
                    <p id="p_right"><a href="index.php?offset=1">Next 5 articles</a></p>
                <?php }
            }
            ?>
        </div>
    </div>
</body>
</html>

