<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package  : Mutiara Islam
 * @author   : Fika Ridaul Maulayya <ridaulmaulayya@gmail.com>
 * @since    : 2017
 * @license  : https://mutiara-islam.id/
 */

class Quotes extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    public function index()
    {
        $query = $this->db->select('a.id_quotes,a.judul_quotes,a.category_id,a.slug,a.images,a.created_at,a.user_id, b.id_category, b.nama_category, c.id_user,c.nama_user')
            ->from('tbl_quotes a')
            ->join('tbl_category b', 'a.category_id = b.id_category')
            ->join('tbl_users c', 'a.user_id = c.id_user')
            ->order_by('a.id_quotes', 'DESC');
        $hasil = $this->db->get()->result();

        //parse json object array
        echo json_encode(array('quotes' => $hasil));

        exit;
    }

    /*
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
    */
}