<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 id="h1"><a href="index.php?action=adminPanel">Back Home</a></h1><hr />
            <div id="content">
                <h4>
                    <?php
                    $this->model = new \Forms\manageTagsForm(new \Models\Model());
                    /**
                     * the form itself autogenerated
                     */
                    if((isset($_POST['submit']) && $_POST['submit'] === 'Delete') || (isset($_POST['submit']) && $_POST['submit'] === 'Update')){
                        echo "<strong id='strong'>The modify was succesfull</strong>";
                    }
                    if(isset($_POST['delete']) && !empty($_POST['delete'])) {
                        $_SESSION['delete'] = $_POST['delete'];
                    }
                    echo "<h3><strong>The tag which you selected was: <span>" . $_SESSION['delete'] . "</span></strong></h3><hr>";
                    ?>
                    <?php echo $this->model->getStartTag()?>
                    <?php foreach($this->model->fields as $field) : ?>
                        <?php echo  $field->getLabelTag();?>
                        <?php
                        $array = $field->getInput();
                        if(is_array($array)){
                            foreach ($array as $item){
                                echo $item;
                            }
                        }else{
                            echo $field->getInput();}?>
                    <?php endforeach ?>
                    <hr>
                    <?php
                    $this->model = new \Forms\DeleteTagForm(new Models\Model());
                    echo $this->model->getStartTag();
                    foreach($this->model->fields as $field){
                        echo $field->getInput();
                    }
                    ?>
                </h4>
            </div>
        </div>
    </div>
</div>