<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Поиск статей по тегу</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/articles.css">
</head>
<body>

<a class="link" href='<?php echo base_url()?>'>Назад ко всем статьям</a><br>
<a class="link" href="<?php echo base_url() ?>insert_article_form">Добавить статью</a>

<div class="container">
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <h3 class="centered">Статьи по тегу <?php echo "<span class='current-tag'>". $current_tag_name . "</span>"?></h3>
            <?php
            if (count($articles) == 0) {
                echo "Статей с данным тегом не найдено! :(";
            } else {
                foreach ($articles as $article) {
                    echo "<div class='one-article'>
                    <h3 class='centered'>" . $article->article_title . "</h3>
                    <h6 class='centered'>" . $article->article_date . "</h6>
                    <div class='description'>" . mb_substr($article->article_description, 0, 400) . " ...
                        <a href='" . base_url() . "one_article/" . $article->article_id . "'>Читать статью</a>
                    </div>
                    <div class='tag_field'>
                        <span class='tags'>Теги:</span> ";
                        $this->load->model('article_tags_model');
                        $one_article_tags = $this->article_tags_model->getTagsByArticleId($article->id);
                        foreach ($one_article_tags as $key => $one_article_tag) {
                            echo "<a class='one-article-tags' href='" . base_url() . "search_articles/" . $one_article_tag->tag_id . "'> " . $one_article_tag->tag_name . " </a>";
                            if (($key) != (count($one_article_tags) - 1)) {
                                echo ", ";
                            }
                        }
                        echo "</div>
                </div>";
                }
            }
            ?>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <h3>Теги</h3>
            <?php
            foreach ($tags as $tag) {
                if ($current_id == $tag->id) {
                    echo "<h2 class='current-tag'>" . $tag->tag_name . "</a></h2>";
                } else {
                    echo "<h5><a href='" . base_url() . "search_articles/" . $tag->id . "'>" . $tag->tag_name . "</a></h5>";
                }
            }
            ?>
        </div>
    </div>
</div>

</body>
</html>