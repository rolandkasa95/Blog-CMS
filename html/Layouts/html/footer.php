<footer class="footer">
    <div class="container">
        <div class="row">
            <ul class="pager">
                <?php
                if(isset($_GET['offset'])) {
                    ?>
                    <div class="col-md-6">
                        <?php
                        $offset = (int)$_GET['offset'];
                        if (0 !== $offset) {
                            echo "<li class='previous'><a href=index.php?offset=" . --$offset . ">Previous Articles</a></li>";
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php
                        ob_start();
                        $offset = (int)$_GET['offset'];
                        $articles->setLimit(5*++$offset);
                        $articles->getWithLimitation();
                        ob_end_clean();
                        if (!empty($articles->articleArray)){
                            $offset = (int)$_GET['offset'];
                            echo "<li class='next'><a href=index.php?offset=" . ++$offset . ">Next Articles</a></li>";
                        }
                        ?>
                    </div>
                    <?php
                }else{
                ?>
                <div class="col-md-12">
                    <?php
                    echo "<li class='next'><a href=index.php?offset=" . ++$offset . ">Next Articles</a></li>";
                    }
                    ?>
            </ul>
        </div>
    </div>
    </div>
</footer>