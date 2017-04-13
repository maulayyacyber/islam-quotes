<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Quotes extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->load->database();
    }

    function index_get() {
        $id = $this->get('id_quotes');
        if ($id == '') {
            $this->db->select('a.id_quotes,a.judul_quotes,a.category_id,a.slug,a.images,a.created_at,a.user_id, b.id_category, b.nama_category, c.id_user,c.nama_user')
                ->from('tbl_quotes a')
                ->join('tbl_category b','a.category_id = b.id_category')
                ->join('tbl_users c','a.user_id = c.id_user')
                ->order_by('a.id_quotes','DESC');
            $quotes = $this->db->get()->result();
        } else {
            $this->db->where('id_quotes', $id);
            $this->db->select('a.id_quotes,a.judul_quotes,a.category_id,a.slug,a.images,a.created_at,a.user_id, b.id_category, b.nama_category, c.id_user,c.nama_user')
                ->from('tbl_quotes a')
                ->join('tbl_category b','a.category_id = b.id_category')
                ->join('tbl_users c','a.user_id = c.id_user')
                ->order_by('a.id_quotes','DESC');
            $quotes = $this->db->get()->result();
        }
        $this->response($quotes, 200);
    }
}