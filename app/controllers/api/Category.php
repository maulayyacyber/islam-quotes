<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Category extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->load->database();
    }

    function index_get() {
        $id = $this->get('id_category');
        if ($id == '') {
            $this->db->select('*');
            $quotes = $this->db->get('tbl_category')->result();
        } else {
            $this->db->where('id_category', $id);
            $this->db->select('*');
            $quotes = $this->db->get('tbl_category')->result();
        }
        $this->response($quotes, 200);
    }
}