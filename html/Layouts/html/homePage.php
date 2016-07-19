<body>
    <div class="container">
        <div class="jumbotron">
            <h1>My Blog</h1>
            <div align="right">
                <a href="index.php?action=login"><?php
                    if (isset($_GET['offset'])) {
                        $offset = (int)$_GET['offset'];
                    }
                    if(isset($_SESSION)){
                        echo $_SESSION['username'] . '   Logout';
                    }
                    elseif(session_start()  && isset($_SESSION['username'])) {
                        echo $_SESSION['username'] . '   Logout';
                    }else{
                        echo "Login";
                    }
                    ?></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12">
            <h2>
            <?php
            /**
             * Listing the articles descendently
             */
            if(isset($_SESSION['username'])){
                echo "<a href='index.php?action=insert'>Insert Article<a/>";
            }
            if(isset($_GET['offset'])){
                $result = $this->model->getArticles($offset * 5);
            }else{
                $result = $this->model->getArticles(0);
            }
            echo "<hr />";
            foreach($result as $row => $key)
            {
                if(isset($_SESSION['username'])) {
                    echo "<a href='index.php?action=edit&id=" . $this->model->getArticleId($row) . "'><div style='font-size: x-small; float: right; width: 30px;height: 30px; background-color: greenyellow'></div></a>";
                }
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br /><hr />';
            }
            ?>
                <hr />
            <h2>
        </div>
        <div class="col-md-6">
            <?php
            if (isset($offset) && 1 === $offset){
                ?>
                <p style="text-align: left"><a href="index.php">Previous 5 articles</a></p>
                <?php
            }else
                ?>
            <?php
                if(isset($offset) && 1 != $offset ){
            ?>
            <p style="text-align: left"><a href="index.php?offset=<?php echo --$offset ?>">Previous 5 articles</a></p>
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
                    <p style="text-align: right"><a href="index.php?offset=<?php echo ++$offset ?>">Next 5 articles</a>
                    </p>
                <?php } else { ?>
                    <p style="text-align: right"><a href="index.php?offset=1">Next 5 articles</a></p>
                <?php }
            }
            ?>
        </div>
    </div>
</body>
</html>

