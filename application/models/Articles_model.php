<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    public function getArticles() {
        $this->db->order_by('article_date DESC');
        $query = $this->db->get('articles');
        return $query->result();
    }

    public function getArticlesByTagId($tag_id) {
        $this->db->select('articles.*, article_tags.tag_id, article_tags.article_id');
        $this->db->from('articles');
        $this->db->join('article_tags', 'article_tags.article_id = articles.id');
        $this->db->where('article_tags.tag_id', $tag_id);
        $this->db->order_by('articles.article_date DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getOneArticleById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('articles');
        return $query->result();
    }

    public function insertArticle($data) {
        $this->db->insert('articles', $data);
    }
}