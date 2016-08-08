<?php
if(!isset($_SESSION['username']))
    header('Location: index.php');
?>
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
            ob_start();
                $this->model=new \Models\Articles();
                $this->model->setLimit(0);
                $this->model->getWithLimitation();
            ob_end_clean();
                foreach($this->model->articleArray as $result)
                {
                    $this->model = new \Models\Article();
                    $this->model->setId($result['article_id']);
                if(isset($_SESSION['username'])) {
                echo "<a href='index.php?action=edit&id=" . $this->model->getId() . "'><div class='btn btn-success btn-lg glyphicon glyphicon-edit'></div></a>";
                }
                echo "<a href=index.php?action=articleShow&id=" . $this->model->getId() . " >" . $result['title'] . '</a><br />';
                echo $result['date'] . '<br /><hr />';
                }
            ?>
            </h4>
        </div>
    </div>
</div>
