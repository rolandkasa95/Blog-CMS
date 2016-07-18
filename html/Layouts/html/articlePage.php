<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div align="right">
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
        <h1 style="text-align: center; font-style: italic;"><a href="index.php">Back Home</a></h1><hr /><hr />
        <?php
        $result = $this->model->showArticle();
        foreach ($result as $key=>$row){
                if ('title' === $key){
                    echo '<h1 style="text-align: center">' . $row . '</h1>';
                }elseif ('date' === $key){
                    echo '<h2>' . $row . '</h2>';
                }else{
                    print '<h4>' .  $row . '</h4>';
                }
            }
        $result = $this->model->tagNameDisplay();
        echo "<h5>";
        $i=0;
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