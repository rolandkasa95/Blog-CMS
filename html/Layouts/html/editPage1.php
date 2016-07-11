<?php

USE Forms\Inputs\BaseInput;

?>

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
                    if('tags' === $field->name){
                        for ($j=0;$j<2;$j++){
                            echo $field->getInput();
                        }
                    }
                    ?>
                    <?php echo $field->getInput()?>
                <?php endforeach ?>
                <?php echo $this->model->getEndTag()?>
                </h4>
            </div>
        </div>
    </div>
</div>
</body>
</html>