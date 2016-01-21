w<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->helper('url');
		$this->load->view('welcome_message');
	}
	
	//数据缓存测试页面
	public function cache(){
	
		$post = $this->input->post();
		
		//返回结果
		$result = '';
			
		//如果有数据提交
		if( $post )
		{
			//加载cache类
			$this->load->driver('cache');
			
			if( $post['key1'] ) //写入测试
			{
				$result = '写入缓存成功，可进行读取测试';
				//判断缓存方式
				switch( $post['cache1'] )
				{
					case 'memcache': //使用memcache缓存
						$this->cache->memcached->save( $post['key1'], $post['value1'], intval($post['expire1']) );
						break;
					case 'kvdb': //使用memcache缓存
						$this->cache->kvdb->save( $post['key1'], $post['value1'], intval($post['expire1']) );
						break;
					default:
						$result = '写入缓存失败，请输入正确的key和value';
				}
			}else if( $post['key2'] ) //读取测试
			{
				//判断缓存方式
				switch( $post['cache2'] )
				{
					case 'memcache': //使用memcache缓存
						$result = $this->cache->memcached->get_metadata( $post['key2'] );
						break;
					case 'kvdb': //使用memcache缓存
						$result = $this->cache->kvdb->get_metadata( $post['key2'] );
						break;
					default:
						$result = '读取缓存失败，请输入正确参数';
				}
				if( empty($result) )
				{
					$result = "不存在此key 或 数据已过期";
				}
			}
		}
		
		$data['result'] = $result;
		
		$this->load->view('welcome_cache',$data);
		
	}
	
	//验证码类
	public function vcode(){
		$this->load->helper('captcha');
		$cap = create_captcha();
		$data['word'] = $cap['word']; //验证码答案 (大写 数字)
		$data['image'] = $cap['image']; //验证码图片URL ( 80*20 )
		
		$this->load->view('welcome_vcode',$data);
	}
	
	//修改日志和代码示例
	public function log(){
		$this->load->view('welcome_log');
	}
		
	//图像处理 测试
	/*public function imagetest(){
		$config['source_image'] = 'public/test/old.jpg';
		 $config['new_image'] = 'public/test/new.jpg';
		 $config['maintain_ratio'] = TRUE;
		 $config['width'] = 250;
		 $config['height'] = 100;

		 $this->load->library('image_lib', $config); 
		 $this->image_lib->resize();

	}*/
		
	//数据库手动缓存测试 
	public function dbcache(){
		$this->load->database();
		$this->db->cache_on();
		$query = $this->db->get("comments");
		foreach($query->result() as $row )
		{
			echo $row->d;
		}
		//print_r($query);
	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */