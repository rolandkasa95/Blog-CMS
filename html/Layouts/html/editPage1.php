<html>
<body>
<div id="content">
    <?php echo $this->model->getStartTag()?>
    <?php foreach($this->model->fields as $field) : ?>
        <?php if(isset($field->label)) : ?>
            <?php echo $field->getLabelTag();?>
        <?php endif ?>
        <?php echo $field->getInput() . '</br>'?>
    <?php endforeach ?>
    <?php echo $this->model->getEndTag()?>
</div>
</body>
</html>