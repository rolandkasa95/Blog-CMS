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
                <h4>
                <?php echo $this->model->getStartTag()?>
                <?php foreach($this->model->fields as $field) : ?>
                        <?php echo '<hr />' . $field->getLabelTag();?>
                    <?php
                    $array = $field->getInput();
                    if(is_array($array)){
                        $j=1;
                        foreach ($array as $item){
                            $field->name= 'select' . $j;
                            echo $item;
                            $j++;
                        }
                    }else{
                    echo $field->getInput();}?>
                <?php endforeach ?>
                <?php echo $this->model->getEndTag()?>
                <?php
                if(isset($_POST['submit'])){
                    $this->model = new \Models\insertarticleModel();
                    $this->model->insertArticle();
                    $this->model->insertArticlesTags();
                }
                ?>
                </h4>
            </div>
        </div>
    </div>
</div>
</body>
</html>