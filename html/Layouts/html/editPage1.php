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
        <div class="col-md-12">
            <h1 style="text-align: center; font-style: italic;"><a href="index.php">Back Home</a></h1><hr />
            <div id="content">
                <b style="color: red;">
                Please keep in mind: if you add new tags to the article, separate them with a comma! Thank you!
                </b>
                <h4>
                <?php echo $this->model->getStartTag()?>
                <?php foreach($this->model->fields as $field) : ?>
                        <?php echo '<hr />' . $field->getLabelTag();?>
                    <?php
                    $array = $field->getInput();
                    if(is_array($array)){
                        foreach ($array as $item){
                            echo $item;
                        }
                    }else{
                    echo $field->getInput();}?>
                <?php endforeach ?>
                <?php echo $this->model->getEndTag()?>
                <?php
                if(isset($_POST['submit']) && $_POST['submit'] === 'Publish'){
                    $this->model->validate();
                    if(!empty($_POST['tag']) && '' !== $_POST['tag']) {
                        $this->model = new \Models\Model();
                        $this->model->insertTag();
                    }
                    if(!empty($_POST['body']) && !empty($_POST['title'])) {
                        $this->model = new \Models\Model();
                        $this->model->insertArticle();
                        $this->model->insertNewTags();
                        $this->model->insertArticlesTags();
                        header("Location: index.php");
                    }
                    header("Location: index.php");
                    }
                ?>
                </h4>
            </div>
        </div>
    </div>
</div>
</body>
</html>