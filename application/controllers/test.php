<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {
   	function __construct(){
    // this is your constructor
  	    parent::__construct();
       	$this->load->helper('form');
      	$this->load->helper('url');
    	}
	public function index(){
		$db1=$this -> load ->database('pingke',true);
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('user_name','username','required');
		$this -> form_validation -> set_rules('psw1','password1','required');
		$this -> form_validation -> set_rules('psw2','password2','required');
		$this -> form_validation -> set_rules('nick_name','nickname','required');
		if($this -> form_validation -> run() == FALSE){
			$this -> load -> view('pingke/reg');
		}
		else if($this-> input -> post("psw1") != $this -> input ->post("psw2")){
			echo("please check your password");
			$this -> load -> view('pingke/reg');
		}
		else{
			$data = array(
				'username' => $this -> input -> post("user_name"),
				'userpass' => md5($this -> input -> post("psw1")),
				'nickname' => $this -> input -> post("nick_name")
				);
			$query = $db1 -> get_where('user_test',array("username" => $data['username']),1,0);
			$num = 0;
			foreach ($query->result() as $row){
				$num += 1;
			}	
			if($num == 0){
				$db1 -> insert('user_test',$data);
				$this -> load -> view('pingke/log_success');				
				redirect(pingke_url().'/pingke_index/');
			}
			else{
				echo("Your username has been used.");
				$this -> load -> view('pingke/reg');
			}
		}
	}
	public function log(){
		$db1=$this -> load ->database('pingke',true);
		$this -> load -> library('form_validation');
		$this -> form_validation -> set_rules('username','username','required');
		$this -> form_validation -> set_rules('psw1','password','required');
		if($this -> form_validation -> run() == FALSE){
			$this -> load -> view('pingke/login');
		}
		else{
			$data = array('username' => $this -> input -> post("username"),
				   		  'userpass' => md5($this -> input -> post("psw1"))
				   		  );
			$data['userpass'] = substr($data['userpass'],0,strlen($data['userpass'])-2); 
            $newdata = array(  
                        'username'  =>  $data ['username'] ,  
                        'userip'     => $_SERVER['REMOTE_ADDR'],  
                        'luptime'   =>time()  
                );  
		$query = $db1 -> get_where('user_test',array("username" => $data['username']),1,0);
		if($query->num_rows() == 0){
			$this->load->view('pingke/login');
		}
			foreach($query->result() as $row){
				if($row->userpass == $data['userpass']){
					$this->load->library('session');
					$newdata["nickname"] = $row ->nickname;
					$this -> session -> set_userdata($newdata);
					redirect(pingke_url().'/pingke_index/');
				}
				else{ 
					$this -> load -> view('pingke/login');
				}
			}
		}
	}
	public function logout(){
		$unset_data = array('username','userip','luptime');
		$this -> load -> library('session');
		$pig =  $this -> session -> userdata('username');
		$this -> session -> unset_userdata("username");
		redirect(pingke_url().'/pingke_index/');
	}
	public function check(){
		$this -> load -> library('session');
		$name = $this -> session -> userdata('username');
		echo $name;
		if(strlen($name)>=1){
			echo "you have login";
		}
		else{
			echo "not login";
		}
	}
	public function change(){
		$db1=$this -> load ->database('pingke',true);
		$data = array(
				'name' => '谢异',
				'school_id' => 51303097
			);
		$db1 -> update('teacher',$data,array('id' => 1));
		echo "success!";
	}
}