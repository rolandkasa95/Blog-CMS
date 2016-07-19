<html>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div align="right">
            <a href="index.php?action=login"> <?php
                if(session_start() && isset($_SESSION['username'])){
                    echo $_SESSION['username'] . '   Logout';
                }else{
                    header("Location: index.php?action=login ");
                }
                ?></a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>
                <strong>If you want to add a new article: <a href='index.php?action=insert'>Insert Article</a></strong><hr />
                <strong>If you want to manage some tags: <a href="index.php?action=tags">Manage Tags</a></strong><hr />
            </h3>
        </div>
        <div class="col-md-6">
            <h4>
            <?php
                $this->model = new \Models\Model();
                $result = $this->model->getArticles(0);
                foreach($result as $row => $key)
                {
                if(isset($_SESSION['username'])) {
                echo "<a href='index.php?action=edit&id=" . $this->model->getArticleId($row) . "'><div style='font-size: x-small; float: right; width: 30px;height: 30px; background-color: greenyellow'></div></a>";
                }
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br /><hr />';
                }
            ?>
            </h4>
        </div>
    </div>
</div>
