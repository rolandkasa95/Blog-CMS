<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div id="header_div">
            <a href="index.php?action=login"> <?php
                if(session_start() && isset($_SESSION['username'])){
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
                    echo '<h1 id="article_h1">' . $row . '</h1>';
                }elseif ('date' === $key){
                    echo '<h2>' . $row . '</h2>';
                }else{
                    print '<h4>' .  $row . '</h4>';
                }
            }
        $result = $this->model->tagNameDisplay();
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