<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>修改日志 &amp; 代码示例</h1>

	<div id="body">
			<p>
			参考源码<br>
			<a href="https://code.google.com/p/ci-sae/" target="_blank">https://code.google.com/p/ci-sae/</a>&nbsp;感谢作者:ogopogo<br>
			<a href="https://github.com/wkii/CodeIgniter-for-SAE" target="_blank">https://github.com/wkii/CodeIgniter-for-SAE</a>&nbsp;感谢作者:Terry<br>
			<br>
			-----------------------------------------------------------<br>
			支持主从数据库 读写分离<br>
			-----------------------------------------------------------<br>
			1.使用扩展Loader形式, 加载适配SAE的驱动 application\core\SAE_Loader.php<br>
			2.精简数据库驱动 application\database\drivers 仅留下mysql<br>
			3.修改配置 application\config\database.php，适应SAE环境<br>
			4.修改数据库驱动 application\database\DB_driver.php <br>
			&nbsp;&nbsp;修改初始化和simple_query函数。自动判断SQL语句的读或写，进行连接主或从数据库。<br>
			5.修改mysql驱动 application\database\drivers\mysql\mysql_driver.php<br>
			&nbsp;&nbsp;修改db_connect()函数，使其支持 连接的主从数据库。 <br>
			6.修改数据库缓存驱动, 使用KVDB进行缓存 application\database\DB_cache.php<br>
			&nbsp;&nbsp;修改write, read 和 delete 函数, 使其支持KVDB缓存. <br>
			 <br>
			-----------------------------------------------------------<br>
			缓存类   支持memcache和kvdb<br>
			-----------------------------------------------------------<br>
			----------数据缓存----------<br>
			1.修改memcache驱动  application\libraries\Cache\drivers\Cache_memcached.php <br>
			2.添加kvdb驱动   application\libraries\Cache\drivers\Cache_kvdb.php<br>
			3.删除文件缓存<br>
			4.删除apc缓存<br>
			5.原生CI的 system\libraries下Cache文件夹可删除<br>
			 <br>
			使用示例：
			<code>
			$this->load->driver('cache');<br>
			$this->cache->kvdb->save('key1','value1',0);<br>
			$this->cache->memcached->save('key2','value2',0);<br>
			echo $this->cache->kvdb->get('key1');<br>
			echo $this->cache->memcached->get('key2');
			</code>
			 <br>
			----------页面缓存----------<br>
			扩展Output核心页面缓存类 application\core\SAE_Output.php<br>
			<br>
			1.修改扩展类前缀为"SAE_"   application\config\config.php<br>
				$config['subclass_prefix'] = 'SAE_';<br>
			2.修改 application\core\SAE_Output.php<br>
				扩展_write_cache和_display_cache两个函数 <br>
			 <br>
			 使用示例：
			<code>
			$this->output->cache(n);
			</code>
			更多使用参考 <a href="http://codeigniter.org.cn/user_guide/general/caching.html" target="_blank">http://codeigniter.org.cn/user_guide/general/caching.html</a><br>
			<br>
			----------Cache相关配置----------<br>
			以下针对配置文件为 application\config\config.php<br>
				1.key的前缀可通过修改值 $config['cache_path']，对memcache和kvdb的数据缓存、文件缓存有效。<br>
					若为空(默认)，则默认前缀为'system_cache_'。即 $this->cache->kvdb->save('key', 'value', 10)，实际存储的key为'system_cache_key'。<br>
				2.页面缓存默认使用kvdb方式，可修改 $config['sae_output_cache'] 设置缓存方式，可配置三种值，分别为：<br>
					(1) '' ：即使使用了 $this->output->cache(n); 也不会缓存<br>
					(2) 'kvdb' ：使用 KVDB 缓存 (默认) (需要开启SAE KVDB服务)<br>
					(3) 'memcache'：使用 memcache 缓存 (需要开启SAE Memcache服务)<br>
				3.系统默认ttl (缓存过期时间)为60秒，若ttl设置为0，则数据永不过期。memcache和kvdb同样适用。<br>
			<br>	
			注意，由于kvdb方式没有过期删除机制，现修改为自动判断是否过期，若过期则删除。<br>
			<br>
			-----------------------------------------------------------<br>
			Email类<br>
			-----------------------------------------------------------<br>
			使用SAE原生Mail类重构此部分代码。<br>
			<br>
			因为SAE Mail暂只支持SMTP协议，且无密送功能，故删除以下参数：<br>
				useragent, mailpath, smtp_timeout, charset(默认强制utf8，否则中文会乱码), priority, crlf, bcc_batch_mode, bcc_batch_size<br>
			<br>
			增加以下参数：<br>
				tls, compress, callback_url  (参数说明见 <a href="http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a116" target="_blank">http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a116</a>)<br>
			<br>	
			修改“添加附件”方法<br>
			public function attach($filename, $file_path)<br>
				$filename 为附件的文件名，如"pic.jpg" (文件支持类型见 <a href="http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a291" target="_blank">http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a291</a>)<br>
				$file_path 为文件的URL, 如 "http://ww4.sinaimg.cn/thumbnail/6310d41cjw1e1g85nxi1lj.jpg"<br>
			<br>	
			添加"quick_send" 方法，方便快速发送邮件。此方法自动忽略其他参数。且仅支持发送content_type为TEXT）<br>
			public function quick_send($to, $subject, $msgbody, $smtp_user, $smtp_pass, $smtp_host='', $smtp_port=25, $smtp_tls=false)<br>
			<br>
			更多使用参考 <a href="http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a200" target="_blank">http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a200</a><br>
			 <br>
			使用示例：
			<code>
			$this->load->library('email');      <br>
			$config = array();      <br>
			$config['smtp_host'] = 'smtp.sina.com';     <br> 
			$config['smtp_user'] = 'test@sina.com';      <br>
			$config['smtp_pass'] = 'test';     <br>
			//$config['tls'] = TRUE;  //Gmail需要加密连接，其他一般不需设置     <br>
			$config['compress'] = 'my_pic'; //压缩所有附件为zip包，且命名为"my_pic.zip"     <br>
			<br>
			$this->email->initialize($config);<br>
			$this->email->from('test@sina.com');<br>
			$this->email->to('10000@qq.com');<br>
			$this->email->subject('hello');<br>
			$this->email->message('你好');<br>
			$this->email->attach('pic1.jpg','http://example.com/pic1.jpg');<br>
			$this->email->attach('pic2.jpg','http://example.com/pic2.jpg');<br>
			$this->email->send();<br>
			<br>
			//快速发送邮件，如果smtp邮箱为常见邮箱(sina,gmail,163,265,netease,qq,sohu,yahoo) 不需配置smtp_host等参数<br>
			$this->load->library('email');<br>
			$this->email->initialize();<br>
			$this->email->quick_send('10000@qq.com', '测试邮件', '测试', 'test@sina.com', 'test');<br>
			</code>
			<br>
			-----------------------------------------------------------<br>
			文件上传类<br>
			----------------------------------------------------------- <br>
			偏好设置中$config['upload_path'] 必须使用SAE中设定的storage名称（storage服务需开启和设置），<br>
			如已经有一个名为"public"的storage，则为：$config['upload_path'] = 'public'，其他的设置不变。<br>
			可以支持文件夹，格式为：$config['upload_path'] = 'public/demo', "public"为storage名，"demo"为文件夹名。若只给出Storage名，则上传到根目录<br>
			上传成功后， $this->upload->data()新增"file_url"属性，为文件URL链接。<br>
			 <br>
			使用示例：
			<code>
			$config['upload_path'] = 'public/demo';  //上传文件保存位置<br>
			$config['allowed_types'] = 'gif|jpg|png';  //支持文件类型<br>
			$config['encrypt_name'] = true;   //随机文件名<br>
			 <br>
			$this->load->library('upload', $config);  <br>
			if (! $this->upload->do_upload()) {  <br>
			   print_r($this->upload->display_errors());  <br>
			   $data['error'] = array('error' => $this->upload->display_errors());  <br>
			   print_r($data['error']);  <br>
			} else { <br> 
			   $data = $this->upload->data();  <br>
			   echo $data['file_url']; //上传文件成功后的URL路径 <br>
			}
			</code>
			 <br>
			----------------------------------------------------------- <br>
			图像处理<br>
			-----------------------------------------------------------<br>
			待处理图片需放在Storage下，偏好设置注意：<br>
			1.$config['image_library']（自动强制使用'gd2'） <br>
			2.$config['source_image'] = '/public/test/source.jpg'; 	必须为 storage名/文件夹(可选)/文件名 格式 <br>
			3.$config['new_image'] = '/public/test/new.png'; 	必须为 storage名/文件夹(可选)/文件名 格式 <br>
			4.$config['wm_overlay_path'] = '/public/test/wm.png';	必须为 storage名/文件夹(可选)/文件名 格式 <br>
			<br>
			使用示例：
			<code>
			$config['source_image'] = '/public/test/source.jpg';<br>
			$config['new_image'] = '/public/test/new.jpg';<br>
			$config['maintain_ratio'] = TRUE;<br>
			$config['width'] = 250;<br>
			$config['height'] = 100;<br>
			<br>
			$this->load->library('image_lib', $config); <br>
			$this->image_lib->resize();
			</code>
			 <br>
			-----------------------------------------------------------<br>
			验证码类<br>
			-----------------------------------------------------------<br>
			使用原生SAE Vcode服务, 生成的验证码为大写字母和数字的结合, image大小80*20.  <br>
			注意:<br>
			create_captcha()初始化不需提供参数, 返回一个数组, array('word'=>正确的验证码,'image'=>验证码图片URL);<br>
			<br>
			使用示例：
			<code>
			$this->load->helper('captcha');<br>
			$cap = create_captcha();<br>
			echo $cap['word']; //验证码答案 (大写 数字)<br>
			echo $cap['image']; //验证码图片URL ( 80*20 )
			</code>
			 <br>
			 -----------------------------------------------------------<br>
			文件辅助类<br>
			-----------------------------------------------------------<br>
			由于SAE下不支持写操作, 所以禁用涉及写操作的 write 和 delete 函数<br>
			application\helpers\file_helper.php<br>
			<br>
			-----------------------------------------------------------<br>
			扩展 Storage辅助类<br>
			-----------------------------------------------------------<br>
			新增 application\helpers\storage_helper.php 辅助类, 提供常用对Storage的读写操作 (另此辅助类 同时服务于 application\libraries下的 Image_lib 和 Upload)<br>
			写操作: s_write <br>
			读操作: s_read<br>
			删除操作: s_delete<br>
			更多参考源码 application\helpers\storage_helper.php, 需自行扩展的请参考文档 <a href="http://apidoc.sinaapp.com/sae/SaeStorage.html" target="_blank">http://apidoc.sinaapp.com/sae/SaeStorage.html</a><br>
			<br>
			使用示例：
			<code>
			$this->load->helper('storage'); //加载storage辅助类<br>
			$data = 'hello world';<br>
			s_write('public/test.txt', $data); //写入到domain为public下的 test.txt. 支持文件夹, 例如 'public/dir/test.txt'
			</code>
			<br>
			----------------------------------------------------------- <br>
			日志类<br>
			-----------------------------------------------------------<br>
			替换CI日志类为原生SAE日志类，application\libraries\Log.php<br>
			使用示例：
			<code>
			log_message('error','your messages');<br>
			log_message('debug','your messages');<br>
			（需在配置文件中 手动打开log模式 $config['log_threshold']，默认为关闭）
			</code>
			<br>
			查看方法: <br>
			SAE应用管理的日志中心, 选择"debug"中进行查看.<br>
			 <br>
			-----------------------------------------------------------<br>
			删除SAE不支持的类<br>
			-----------------------------------------------------------<br>
			zip类<br>
			迁移类<br>
			FTP类 <br>
		</p>
		<p>&nbsp;</p>
		<p><a href="/">返回首页</a></p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>