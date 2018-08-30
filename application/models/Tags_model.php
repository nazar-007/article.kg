<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    public function getIdByTagName($tag_name) {
        $this->db->where('tag_name', $tag_name);
        $query = $this->db->get('tags');
        $tags = $query->result();
        foreach ($tags as $tag) {
            $id = $tag->id;
            return $id;
        }
    }
    public function getNumRowsByTagName($tag_name) {
        $this->db->where('tag_name', $tag_name);
        $query = $this->db->get('tags');
        return $query->num_rows();
    }
    public function getTags() {
        $query = $this->db->get('tags');
        return $query->result();
    }
    public function getTagNameById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('tags');
        $tags = $query->result();
        foreach ($tags as $tag) {
            $tag_name = $tag->tag_name;
            return $tag_name;
        }
    }
    public function insertTag($data) {
        $this->db->insert('tags', $data);
    }
}