<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fenye_test extends CI_Controller {
	public function index(){
$this->load->library('pagination');

$config['base_url'] = 'http://1.bloodycoder.sinaapp.com/index.php/fenye_test/';
$config['total_rows'] = 200;
$config['per_page'] = 20;

$this->pagination->initialize($config);

echo $this->pagination->create_links();
	}
}