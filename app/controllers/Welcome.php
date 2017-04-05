<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package  : Mutiara Islam
 * @author   : Fika Ridaul Maulayya <ridaulmaulayya@gmail.com>
 * @since    : 2017
 * @license  : https://mutiara-islam.id/license/
 */
class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}
}
