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