<html>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>My Blog</h1>
        <div id="header_div">
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
<?php
ob_start();
/**
 * The form
 *
 * Validation and generation
 */
if(isset($_POST['submit']) && $_POST['submit'] === 'Publish'){
    if (!isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
        $valid = new \Validators\insertValidate();
        $result = $valid->validate();
    }
    if(!empty($_POST['tag']) && '' !== $_POST['tag'] && !isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
        $this->model = new \Models\Model();
        $this->model->insertTag();
    }
    if(!empty($_POST['body']) && !empty($_POST['title']) && !isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
        $this->model = new \Models\Model();
        $this->model->insertArticle();
        $this->model->insertArticlesTags();
        $this->model->insertNewTags();
        $title = $_POST['title'];
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        $id = $this->model->getArticleId($title);
        header('Location: index.php?action=articleShow&id='.$id);
    }
}
ob_end_clean();
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 id="h1"><a href="index.php">Back Home</a></h1><hr />
            <div id="content">
                <strong id="strong">
                Please keep in mind: if you add new tags to the article, separate them with a comma! Thank you!
                </strong>
                <h4>
                <?php
                /**
                 * The instantiation itself
                 */
                    $this->model = new \Forms\InsertArticleForm(new \Models\Model());
                ?>
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
                </h4>
            </div>
        </div>
    </div>
</div>
</body>
</html>