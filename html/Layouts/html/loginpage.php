<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Webserver Landing Page</title>
    <meta name="generator" content="PuPHPet.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" />
    <style type="text/css">pre { background: #444; color:#fff; border-style: none; }</style>
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js?"></script><![endif]-->
</head>
<div class="container">
    <div class="col-md-1"></div>
    <div class="col-md-8" style="padding-top: 20%; text-align: center">
        <h2>
            <h1>Welcome, please login</h1>
            <?php echo $this->model->getStartTag()?>
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