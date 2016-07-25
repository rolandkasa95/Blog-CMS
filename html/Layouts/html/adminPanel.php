<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h3>
                <strong>If you want to add a new article: <a href='index.php?action=insert'>Insert Article</a></strong><hr />
                <?php
                    $this->model = new Forms\EditTagForm(new Models\Model());
                 echo $this->model->getStartTag()?>
                <?php foreach($this->model->fields as $field) : ?>
                    <?php echo $field->getLabelTag();?>
                    <?php echo $field->getInput();?>
                <?php endforeach ?>
                <?php echo $this->model->getEndTag()?>
                <hr />
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
                echo "<a href='index.php?action=edit&id=" . $this->model->getArticleId($row) . "'><div id='edit_div'></div></a>";
                }
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getArticleId($row) . " >" . $row . '</a><br />';
                echo $key . '<br /><hr />';
                }
            ?>
            </h4>
        </div>
    </div>
</div>
