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
            $config['base_url'] = base_url() . 'apps/quotes/index/';
            $config['total_rows'] = $this->apps->count_quotes()->num_rows();
            $config['per_page'] = 10;
            //instalasi paging
            $this->pagination->initialize($config);
            //deklare halaman
            $halaman = $this->uri->segment(4);
            $halaman = $halaman == '' ? 0 : $halaman;
            //create data array
            $data = array(
                'title' => 'Quotes',
                'quotes' => TRUE,
                'data_quotes' => $this->apps->index_quotes($halaman, $config['per_page']),
                'paging' => $this->pagination->create_links()
            );
            if ($data['data_quotes'] != NULL) {

                $data['quotes'] = $data['data_quotes'];

            } else {

                $data['quotes'] = NULL;

            }
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/quotes/data');
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
                $total = $this->apps->total_search_quotes($keyword);
                //config pagination
                $config['base_url'] = base_url() . 'apps/quotes/search?q=' . $keyword;
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
                    'title' => 'Quotes',
                    'quotes' => TRUE,
                    'data_quotes' => $this->apps->search_index_quotes(strip_tags($keyword), $limit, $offset),
                    'paging' => $this->pagination->create_links()
                );
                if ($data['data_quotes'] != NULL) {

                    $data['quotes'] = $data['data_quotes'];
                } else {
                    $data['quotes'] = '';
                }
                //load view with data
                $this->load->view('apps/part/header', $data);
                $this->load->view('apps/part/sidebar');
                $this->load->view('apps/layout/quotes/data');
                $this->load->view('apps/part/footer');
            } else {
                redirect('apps/quotes');
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
                'title' => 'Add Quotes',
                'quotes' => TRUE,
                'type' => 'add',
                'select_category' => $this->apps->select_category()
            );
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/quotes/add');
            $this->load->view('apps/part/footer');
        } else {
            show_404();
            return FALSE;
        }

    }

    public function edit($id_quotes)
    {
        if ($this->apps->apps_id()) {
            //get id
            $id_quotes = $this->encryption->decode($this->uri->segment(4));
            //create data array
            $data = array(
                'title' => 'Edit Quotes',
                'quotes' => TRUE,
                'type' => 'edit',
                'select_category' => $this->apps->select_category(),
                'data_quotes' => $this->apps->edit_quotes($id_quotes)->row_array()
            );
            //load view with data
            $this->load->view('apps/part/header', $data);
            $this->load->view('apps/part/sidebar');
            $this->load->view('apps/layout/quotes/edit');
            $this->load->view('apps/part/footer');
        } else {
            show_404();
            return FALSE;
        }
    }

    public function save()
    {
        $type              = $this->input->post("type");
        $id['id_quotes']   = $this->encryption->decode($this->input->post("id_quotes"));
        $check_quotes      = $this->apps->check_one('tbl_quotes', array('judul_quotes' => $this->input->post("judul_quotes")));

        if ($type == "add") {

            if ($check_quotes != FALSE) {
                $this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-exclamation-circle"></i> Error! Judul quotes sudah terdaftar.
			                                                </div>');
                //redirect halaman
                redirect('apps/quotes?source=add&utf8=✓');

            } else {

                //config upload
                $config = array(
                    'upload_path' => realpath('resources/images/quotes/'),
                    'allowed_types' => 'jpg|png|jpeg',
                    'encrypt_name' => TRUE,
                    'remove_spaces' => TRUE,
                    'overwrite' => TRUE,
                    'max_size' => '50000',
                    'max_width' => '50000',
                    'max_height' => '50000'
                );
                //load library upload
                $this->load->library("upload", $config);
                //load library lib image
                $this->load->library("image_lib");

                $this->upload->initialize($config);
                if ($this->upload->do_upload("userfile")) {
                    $data_upload = $this->upload->data();

                    /* PATH */
                    $source = realpath('resources/images/quotes/' . $data_upload['file_name']);
                    $destination_thumb = realpath('resources/images/quotes/thumb/');

                    // Permission Configuration
                    chmod($source, 0777);

                    /* Resizing Processing */
                    // Configuration Of Image Manipulation :: Static
                    $img['image_library'] = 'GD2';
                    $img['create_thumb'] = TRUE;
                    $img['maintain_ratio'] = TRUE;

                    /// Limit Width Resize
                    $limit_thumb = 1920;

                    // Size Image Limit was using (LIMIT TOP)
                    $limit_use = $data_upload['image_width'] > $data_upload['image_height'] ? $data_upload['image_width'] : $data_upload['image_height'];

                    // Percentase Resize
                    if ($limit_use > $limit_thumb) {
                        $percent_thumb = $limit_thumb / $limit_use;
                    }

                    //// Making THUMBNAIL ///////
                    $img['width'] = $limit_use > $limit_thumb ? $data_upload['image_width'] * $percent_thumb : $data_upload['image_width'];
                    $img['height'] = $limit_use > $limit_thumb ? $data_upload['image_height'] * $percent_thumb : $data_upload['image_height'];

                    // Configuration Of Image Manipulation :: Dynamic
                    $img['thumb_marker'] = '';
                    $img['quality'] = '100%';
                    $img['source_image'] = $source;
                    $img['new_image'] = $destination_thumb;

                    // Do Resizing
                    $this->image_lib->initialize($img);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $insert = array(
                        'judul_quotes' => $this->input->post("judul_quotes"),
                        'slug'         => url_title(strtolower($this->input->post("judul_quotes"))),
                        'category_id'  => $this->input->post("category"),
                        'images'       => $data_upload['file_name'],
                        'user_id'      => $this->session->userdata("apps_id"),
                        'created_at'   => date("Y-m-d H:i:s"),
                        'updated_at'   => date("Y-m-d H:i:s")
                    );
                    $this->db->insert("tbl_quotes", $insert);
                    //deklarasi session flashdata
                    $this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-check"></i> Data Berhasil Disimpan.
			                                                </div>');
                    //redirect halaman
                    redirect('apps/quotes?source=add&utf8=✓');
                } else {
                    $this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-exclamation-circle"></i> Data Gagal Disimpan ' . $this->upload->display_errors('') . '
			                                                </div>');
                    redirect('apps/quotes?source=add&utf8=✓');
                }
            }
        }elseif($type == "edit"){


            if (empty($_FILES['userfile']['name'])) {

                $update = array(
                    'judul_quotes' => $this->input->post("judul_quotes"),
                    'slug'         => url_title(strtolower($this->input->post("judul_quotes"))),
                    'category_id'  => $this->input->post("category"),
                    'user_id'      => $this->session->userdata("apps_id"),
                    'updated_at'   => date("Y-m-d H:i:s")
                );
                $this->db->update("tbl_quotes", $update, $id);
                //deklarasi session flashdata
                $this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-check"></i> Data Berhasil Diupdate.
			                                                </div>');
                //redirect halaman
                redirect('apps/quotes?source=add&utf8=✓');

            }else{

                //config upload
                $config = array(
                    'upload_path' => realpath('resources/images/quotes/'),
                    'allowed_types' => 'jpg|png|jpeg',
                    'encrypt_name' => TRUE,
                    'remove_spaces' => TRUE,
                    'overwrite' => TRUE,
                    'max_size' => '50000',
                    'max_width' => '50000',
                    'max_height' => '50000'
                );
                //load library upload
                $this->load->library("upload", $config);
                //load library lib image
                $this->load->library("image_lib");

                $this->upload->initialize($config);
                if ($this->upload->do_upload("userfile")) {
                    $data_upload = $this->upload->data();

                    /* PATH */
                    $source = realpath('resources/images/quotes/' . $data_upload['file_name']);
                    $destination_thumb = realpath('resources/images/quotes/thumb/');
                    $source_old = realpath('resources/images/quotes/thumb/' . $foto_thumbnail . '');

                    // Permission Configuration
                    chmod($source, 0777);

                    /* Resizing Processing */
                    // Configuration Of Image Manipulation :: Static
                    $img['image_library'] = 'GD2';
                    $img['create_thumb'] = TRUE;
                    $img['maintain_ratio'] = TRUE;

                    /// Limit Width Resize
                    $limit_thumb = 1920;

                    // Size Image Limit was using (LIMIT TOP)
                    $limit_use = $data_upload['image_width'] > $data_upload['image_height'] ? $data_upload['image_width'] : $data_upload['image_height'];

                    // Percentase Resize
                    if ($limit_use > $limit_thumb) {
                        $percent_thumb = $limit_thumb / $limit_use;
                    }

                    //// Making THUMBNAIL ///////
                    $img['width'] = $limit_use > $limit_thumb ? $data_upload['image_width'] * $percent_thumb : $data_upload['image_width'];
                    $img['height'] = $limit_use > $limit_thumb ? $data_upload['image_height'] * $percent_thumb : $data_upload['image_height'];

                    // Configuration Of Image Manipulation :: Dynamic
                    $img['thumb_marker'] = '';
                    $img['quality'] = '100%';
                    $img['source_image'] = $source;
                    $img['new_image'] = $destination_thumb;

                    // Do Resizing
                    $this->image_lib->initialize($img);
                    $this->image_lib->resize();
                    $this->image_lib->clear();

                    $update = array(
                        'judul_quotes' => $this->input->post("judul_quotes"),
                        'slug'         => url_title(strtolower($this->input->post("judul_quotes"))),
                        'category_id'  => $this->input->post("category"),
                        'images'       => $data_upload['file_name'],
                        'user_id'      => $this->session->userdata("apps_id"),
                        'updated_at'   => date("Y-m-d H:i:s")
                    );
                    $this->db->update("tbl_quotes", $update, $id);
                    //deklarasi session flashdata
                    $this->session->set_flashdata('notif', '<div class="alert alert-success alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-check"></i> Data Berhasil Diupdate.
			                                                </div>');
                    //redirect halaman
                    redirect('apps/quotes?source=add&utf8=✓');
                } else {
                    $this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-exclamation-circle"></i> Data Gagal Diupdate ' . $this->upload->display_errors('') . '
			                                                </div>');
                    redirect('apps/quotes?source=add&utf8=✓');
                }

            }

        }else{
            $this->session->set_flashdata('notif', '<div class="alert alert-danger alert-dismissible" style="font-family:Roboto">
			                                                    <i class="fa fa-exclamation-circle"></i> Variable Type not value
			                                                </div>');
            redirect('apps/quotes?source=edit&utf8=✓');
        }
    }

}