<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_tags_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    public function insertArticleTag($data) {
        $this->db->insert('article_tags', $data);
    }
    public function getTagsByArticleId($article_id) {
        $this->db->select('article_tags.*, tags.tag_name');
        $this->db->from('article_tags');
        $this->db->join('tags', 'article_tags.tag_id = tags.id');
        $this->db->where('article_tags.article_id', $article_id);
        $query = $this->db->get();
        return $query->result();
    }
}