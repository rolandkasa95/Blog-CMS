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
            if(isset($_SESSION['username'])){
                echo "<a href='index.php?action=edit'>Insert Article<a/>";
            }
            if(isset($_GET['offset'])){
                $result = $this->model->getArticles($offset * 5);
            }else{
                $result = $this->model->getArticles(0);
            }
            foreach($result as $row => $key)
            {
                echo "<hr /><a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br />';
            }
            ?>
                <hr />
            <h2>
        </div>
        <div class="col-md-6">
            <?php
                if(isset($offset) && 0 != $offset ){
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

