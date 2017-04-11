<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package  : Mutiara Islam
 * @author   : Fika Ridaul Maulayya <ridaulmaulayya@gmail.com>
 * @since    : 2017
 * @license  : https://mutiara-islam.id/
 */
class Category extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //load model
        $this->load->model('apps');
    }

    public function index()
    {
        if ($this->apps->apps_id()) {
            //config pagination
            $config['base_url'] = base_url() . 'apps/category/index/';
            $config['total_rows'] = $this->apps->count_users()->num_rows();
            $config['per_page'] = 10;
            //instalasi paging
            $this->pagination->initialize($config);
            //deklare halaman
            $halaman = $this->uri->segment(4);
            $halaman = $halaman == '' ? 0 : $halaman;
            //create data array
            $data = array(
                'title' => 'Category',
                'category' => TRUE,
                'data_category' => $this->apps->index_category($halaman, $config['per_page']),
                'paging' => $this->pagination->create_links()
            );
            if ($data['data_category'] != NULL) {

                $data['category'] = $data['data_category'];

            } else {

                $data['category'] = NULL;

            }
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/category/data');
            $this->load->view('apps/part/footer');
        } else {
            show_404();
            return FALSE;
        }
    }

    public function search()
    {
        if ($this->apps->apps_id()) {
            $limit = 10;
            $this->load->helper('security');
            $keyword = $this->security->xss_clean($_GET['q']);
            $data['keyword'] = strip_tags($keyword);
            $check = strlen(preg_replace('/[^a-zA-Z]/', '', $keyword));
            if (!empty($keyword) && $check > 2) {
                $offset = (isset($_GET['page'])) ? $this->security->xss_clean($_GET['page']) : 0;
                $total = $this->apps->total_search_category($keyword);
                //config pagination
                $config['base_url'] = base_url() . 'apps/category/search?q=' . $keyword;
                $config['total_rows'] = $total;
                $config['per_page'] = $limit;
                $config['page_query_string'] = TRUE;
                $config['use_page_numbers'] = TRUE;
                $config['display_pages'] = TRUE;
                $config['query_string_segment'] = 'page';
                $config['uri_segment'] = 4;
                //instalasi paging
                $this->pagination->initialize($config);

                $data = array(
                    'title' => 'Users',
                    'category' => TRUE,
                    'data_category' => $this->apps->search_index_category(strip_tags($keyword), $limit, $offset),
                    'paging' => $this->pagination->create_links()
                );
                if ($data['data_category'] != NULL) {

                    $data['category'] = $data['data_category'];
                } else {
                    $data['category'] = '';
                }
                //load view with data
                $this->load->view('apps/part/header', $data);
                $this->load->view('apps/part/sidebar');
                $this->load->view('apps/layout/category/data');
                $this->load->view('apps/part/footer');
            } else {
                redirect('apps/category');
            }
        } else {
            show_404();
            return FALSE;
        }
    }

    public function add()
    {
        if ($this->apps->apps_id()) {
            //create data array
            $data = array(
                'title' => 'Add Category',
                'category' => TRUE,
                'type' => 'add'
            );
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/category/add');
            $this->load->view('apps/part/footer');
        } else {
            show_404();
            return FALSE;
        }

    }

    public function edit($id_category)
    {
        if($this->apps->apps_id())
        {
            //get id
            $id_category = $this->encryption->decode($this->uri->segment(4));
            //create data array
            $data = array(
                'title'          => 'Edit Category',
                'category'          => TRUE,
                'type'           => 'edit',
                'data_category'     => $this->apps->edit_category($id_category)->row_array()
            );
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/category/edit');
            $this->load->view('apps/part/footer');
        }else{
            show_404();
            return FALSE;
        }
    }

    public function save()
    {
        if($this->apps->apps_id())
        {

            $type               = $this->input->post("type");
            $id['id_category']  = $this->encryption->decode($this->input->post("id_category"));

            if($type == "add")
            {

                $insert = array(
                    'nama_category' => $this->input->post("nama_category"),
                    'slug'          => url_title(strtolower($this->input->post("nama_category"))),
                    'created_at'    => date("Y-m-d H:i:s"),
                    'updated_at'    => date("Y-m-d H:i:s")
                );

                $this->db->insert("tbl_category", $insert);
                //deklarasi session flashdata
                $this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-check"></i> Data Berhasil Disimpan.
			                                                </div>');
                //redirect halaman
                redirect('apps/category?source=add&utf8=✓');

            }elseif($type == "edit"){

                $update = array(
                    'nama_category' => $this->input->post("nama_category"),
                    'slug'          => url_title(strtolower($this->input->post("nama_category"))),
                    'created_at'    => date("Y-m-d H:i:s"),
                    'updated_at'    => date("Y-m-d H:i:s")
                );

                $this->db->update("tbl_category", $update, $id);
                //deklarasi session flashdata
                $this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-check"></i> Data Berhasil Diupdate.
			                                                </div>');
                //redirect halaman
                redirect('apps/category?source=edit&utf8=✓');

            }else{

                //

            }

        }else{
            show_404();
            return FALSE;
        }
    }

}