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
            <h1 style="text-align: center; font-style: italic;"><a href="index.php">Back Home</a></h1><hr /><hr />
            <h2>Select The Tags</h2>
            <?php
                    require "addTags.php";
            ?>
            <hr />
            <textarea name="body" rows="8" cols="80" required form="edit"></textarea>
            <hr />
            <label for="title">Title: </label>
            <input type="text" name="title" value="title" placeholder="Title name...">
            <input type="submit" value="submit" name="submit">
            </form>
            <?php
            if(isset($_POST['submit'])){
                $this->model = new \Models\insertarticleModel();
                $this->model->insertArticle();
                $this->model->insertArticlesTags();
            }
            ?>
        </div>
    </div>
</div>

</body>