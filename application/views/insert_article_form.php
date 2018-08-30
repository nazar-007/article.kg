<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавление новой статьи</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>css/articles.css">
</head>
<body>

<a class="link" href='<?php echo base_url()?>'>Назад ко всем статьям</a><br>
<a class="link" href="<?php echo base_url() ?>insert_article_form">Добавить статью</a>

<div class="container">
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <h3 class="centered">Добавление новой статьи</h3>
            <form method="post" action="javascript:void(0)" onsubmit="insertArticle(this)">
                <input type="hidden" class="csrf" name="csrf_test_name" value="<?php echo $csrf_hash?>">
                <label>Заголовок статьи:</label>
                <input type="text" class="form-control" name="article_title">
                <div id="title_error" class="error"></div>
                <label>Теги:</label>
                <input type="text" class="form-control" name="tag_names" data-role="tagsinput"><br>
                <div id="tag_error" class="error"></div>
                <label>Описание статьи</label>
                <textarea class="form-control" name="article_description" rows="10"></textarea>
                <div id="description_error" class="error"></div>
                <button type="submit" class="btn btn-primary center-block">Добавить</button>
            </form>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <h3>Теги</h3>
            <?php
            foreach ($tags as $tag) {
                echo "<h5><a href='" . base_url() . "search_articles/" . $tag->id . "'>" . $tag->tag_name . "</a></h5>";
            }
            ?>
        </div>
    </div>
</div>

<script>

    function insertArticle(context) {
        var form = $(context)[0];
        var all_inputs = new FormData(form);
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>" + "articles/insert_article",
            data: all_inputs,
            dataType: "JSON",
            contentType: false,
            processData: false
        }).done(function (message) {
            $(".csrf").val(message.csrf_hash);
            if (message.title_error) {
                $("#title_error").html(message.title_error);
            } else {
                $("#title_error").html('');
            }

            if (message.tag_error) {
                $("#tag_error").html(message.tag_error);
            } else {
                $("#tag_error").html('');
            }

            if (message.description_error) {
                $("#description_error").html(message.description_error);
            } else {
                $("#description_error").html('');
            }

            if (message.article_success) {
                alert(message.article_success);
                window.location.href = "<?php echo base_url()?>";
            }
        })
    }
</script>

</body>
</html>