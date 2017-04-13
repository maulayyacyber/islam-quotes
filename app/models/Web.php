<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package  : Mutiara Islam
 * @author   : Fika Ridaul Maulayya <ridaulmaulayya@gmail.com>
 * @since    : 2017
 * @license  : https://mutiara-islam.id/
 */
class Web extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_count()
    {
        $sql = "SELECT COUNT(*) as tol_records FROM tbl_quotes as a JOIN tbl_users as b JOIN tbl_category as c ON a.user_id = b.id_user AND a.category_id = c.id_category ORDER BY a.id_quotes DESC";
        $result = $this->db->query($sql)->row();
        return $result;
    }

    public function get_all_content($start,$content_per_page)
    {
        $sql = "SELECT * FROM tbl_quotes as a JOIN tbl_users as b JOIN tbl_category as c ON a.user_id = b.id_user AND a.category_id = c.id_category ORDER BY a.id_quotes DESC LIMIT $start,$content_per_page";
        $result = $this->db->query($sql)->result();
        return $result;
    }
}