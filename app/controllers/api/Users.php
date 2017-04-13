<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Users extends REST_Controller {

    function __construct($config = 'rest') {

        parent::__construct($config);

        $this->load->database();
    }

    function index_get() {
        $id = $this->get('id_user');
        if ($id == '') {
            $this->db->select('*');
            $quotes = $this->db->get('tbl_users')->result();
        } else {
            $this->db->where('id_user', $id);
            $this->db->select('*');
            $quotes = $this->db->get('tbl_users')->result();
        }
        $this->response($quotes, 200);
    }
}