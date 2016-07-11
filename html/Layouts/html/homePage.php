<body>
    <div class="container">
        <div class="jumbotron">
            <h1>My Blog</h1>
            <div align="right">
                <a href="index.php?action=login"><?php
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
            $result = $this->model->getArticles();
            foreach($result as $row => $key)
            {
                echo "<hr /><a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br />';
            }
            ?>
                <hr />
            <h2>
        </div>
    </div>
</body>

