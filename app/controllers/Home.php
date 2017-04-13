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
        //load helper
        $this->load->helper('download');
    }

    public function index()
    {

        $total_data = $this->web->get_all_count();
        $content_per_page = 2;
        $this->data['total_data'] = ceil($total_data->tol_records/$content_per_page);

        $this->load->view('home/part/header.php', $this->data, FALSE);
        $this->load->view('home/layout/home/data.php');
        $this->load->view('home/part/footer.php');

    }

    public function load_more()
    {
        $group_no = $this->input->post('group_no');
        $content_per_page = 2;
        $start = ceil($group_no * $content_per_page);
        $all_content = $this->web->get_all_content($start,$content_per_page);

        if(isset($all_content) && is_array($all_content) && count($all_content)) :

            foreach ($all_content as $key => $content) :
                echo '<div class="card">
                        <div class="card-content">
                            <div class="media">
                                <div class="media-left">
                                    <img class="media-object" src="'.base_url().'resources/images/avatar/'.$content->foto_user.'" style="width:50px; height:50px; border-radius:40px" >
                                </div>
                                <div class="media-body media-middle">
                                    <h4 class="media-heading" style="font-size: 15px"> '.$content->nama_user.'</h4>
                                    <small>2 year ago</small>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-image" style="width: 100%">
                            <span class="card-title"><a href="#!" type="button" class="btn btn-success btn-sm" style="border-radius: 0px;background-color: #00796B;border-color: #00796B"> '.$content->nama_category.'</a></span>
                            <img class="img-responsive" src="'.base_url().'resources/images/quotes/'.$content->images.'" style="width: 100%;height: 100%">
                       
                        </div>
                        <div class="card-content" style="text-align: center">
                            <a href="" class="btn btn-sm btn-success"><i class="fa fa-cloud-download"></i> DOWNLOAD</a>
                        </div>
                    </div>';
            endforeach;

        endif;
        // echo '<pre>'; print_r($this->data['labels_message']); exit;
    }

}