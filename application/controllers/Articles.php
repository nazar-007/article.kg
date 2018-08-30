<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('articles_model');
        $this->load->model('tags_model');
        $this->load->model('article_tags_model');
    }

    public function Index() {
        $data = array (
            'articles' => $this->articles_model->getArticles(),
            'tags' => $this->tags_model->getTags(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('articles', $data);
    }

    public function Insert_article_form() {
        $data = array (
            'tags' => $this->tags_model->getTags(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('insert_article_form', $data);
    }

    public function Insert_article() {
        $article_title = $_POST['article_title'];
        $article_description = $_POST['article_description'];
        $tag_names = $_POST['tag_names'];

        $json_messages = array();

        if ($article_title == '' || $article_description == '' || $tag_names == '') {
            if ($article_title == '') {
                $json_messages['title_error'] = 'Название статьи пусто. Введите название статьи!';
            }
            if ($article_description == '') {
                $json_messages['description_error'] = 'Описание отсутствует. Введите описание статьи!';
            }
            if ($tag_names == '') {
                $json_messages['tag_error'] = 'Теги отсутствуют. Выберите один или несколько тегов!';
            }
        } else {
            $data = array(
                'article_title' => $article_title,
                'article_date' => date('Y-m-d'),
                'article_description' => $article_description
            );
            $this->articles_model->insertArticle($data);
            $insert_article_id = $this->db->insert_id();

            $tag_names = str_replace(" ", '', $tag_names);
            $tag_names = explode(",", $tag_names);

            foreach ($tag_names as $tag_name) {
                $num_rows = $this->tags_model->getNumRowsByTagName($tag_name);
                if ($num_rows == 0) {
                    $data_tags = array(
                        'tag_name' => $tag_name
                    );
                    $this->tags_model->insertTag($data_tags);
                }

                $tag_id = $this->tags_model->getIdByTagName($tag_name);
                $data_article_tags = array(
                    'tag_id' => $tag_id,
                    'article_id' => $insert_article_id
                );
                $this->article_tags_model->insertArticleTag($data_article_tags);
            }

            $json_messages['article_success'] = 'Статья добавлена!';
        }

        exit(json_encode($json_messages));
    }

    public function One_article($id) {
        $data = array (
            'one_article' => $this->articles_model->getOneArticleById($id),
            'tags' => $this->tags_model->getTags(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('one_article', $data);
    }

    public function Search_articles($tag_id) {
        $data = array (
            'current_id' => $tag_id,
            'current_tag_name' => $this->tags_model->getTagNameById($tag_id),
            'tags' => $this->tags_model->getTags(),
            'articles' => $this->articles_model->getArticlesByTagId($tag_id),
            'csrf_hash' => $this->security->get_csrf_hash()
        );
        $this->load->view('search_articles', $data);
    }
}