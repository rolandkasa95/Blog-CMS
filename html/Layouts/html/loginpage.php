<div class="container">
    <div class="col-md-1"></div>
    <div class="col-md-8" style="padding-top: 20%; text-align: center">
        <h2>
            <h1>Welcome, please login</h1>
            <?php echo '<p style="position: relative">' . $this->model->getStartTag() . '</p>';?>
            <h4 style="font-style: italic; text-align: right; position: static"><a href="index.php">Back Home</a></h4><br />
            <?php foreach($this->model->getFields() as $field) : ?>
                <?php if(method_exists($field, 'getLabelTag')) : ?>
                    <?php echo $field->getLabelTag();?>
                <?php endif ?>
                <?php echo $field->getInput() . '</br>'?>
            <?php endforeach ?>
            <?php echo $this->model->getEndTag()?>
        <h2>
    </div>
</div>