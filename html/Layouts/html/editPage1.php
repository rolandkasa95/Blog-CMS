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
                    echo "Login";
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
                    if('Please Select the Tags' === $field->label){
                        for ($j=0;$j<3;$j++){
                            $field->name= 'tags' . $j;
                            echo $field->getInput();
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