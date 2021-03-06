<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package  : Mutiara Islam
 * @author   : Fika Ridaul Maulayya <ridaulmaulayya@gmail.com>
 * @since    : 2017
 * @license  : https://mutiara-islam.id/
 */
class Home extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('web');
    }

    public function index()
    {
        $this->load->view('home/part/header.php');
        $this->load->view('home/layout/home/data.php');
        $this->load->view('home/part/footer.php');

    }

    public function homepage()
    {
        $this->load->view('home/layout/home/homepage.php');
    }

}