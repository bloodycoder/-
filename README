参考：
https://code.google.com/p/ci-sae/
https://github.com/wkii/CodeIgniter-for-SAE
 

修改日志： 
-----------------------------------------------------------
支持主从数据库 读写分离
-----------------------------------------------------------
1.使用扩展Loader形式, 加载适配SAE的驱动 application\core\SAE_Loader.php
2.精简数据库驱动 application\database\drivers 仅留下mysql
3.修改配置 application\config\database.php，适应SAE环境
4.修改数据库驱动 application\database\DB_driver.php 
   修改初始化和simple_query函数。自动判断SQL语句的读或写，进行连接主或从数据库。
5.修改mysql驱动 application\database\drivers\mysql\mysql_driver.php
   修改db_connect()函数，使其支持 连接的主从数据库。 
6.修改数据库缓存驱动, 使用KVDB进行缓存 application\database\DB_cache.php
	修改write, read 和 delete 函数, 使其支持KVDB缓存. 
	
-----------------------------------------------------------
缓存类   支持memcache和kvdb
-----------------------------------------------------------
----------数据缓存----------
1.修改memcache驱动  application\libraries\Cache\drivers\Cache_memcached.php 
2.添加kvdb驱动   application\libraries\Cache\drivers\Cache_kvdb.php
3.删除文件缓存
4.删除apc缓存
 
使用示例：
$this->load->driver('cache');
$this->cache->kvdb->save('key1','value1',0);
$this->cache->memcached->save('key2','value2',0);
echo $this->cache->kvdb->get('key1');
echo $this->cache->memcached->get('key2');
 
----------页面缓存----------
扩展Output核心页面缓存类 application\core\SAE_Output.php

1.修改扩展类前缀为"SAE_"   application\config\config.php
	$config['subclass_prefix'] = 'SAE_';
2.修改 application\core\SAE_Output.php
    扩展_write_cache和_display_cache两个函数 
 
使用代码:
只需要将下面的代码放入你的任何一个控制器(controller)的方法(function)内：
$this->output->cache(n);

更多使用参考 http://codeigniter.org.cn/user_guide/general/caching.html

----------Cache相关配置----------
以下针对配置文件为 application\config\config.php
	1.key的前缀可通过修改值 $config['cache_path']，对memcache和kvdb的数据缓存、文件缓存有效。
		若为空(默认)，则默认前缀为'system_cache_'。即 $this->cache->kvdb->save('key', 'value', 10)，实际存储的key为'system_cache_key'。
	2.页面缓存默认使用kvdb方式，可修改 $config['sae_output_cache'] 设置缓存方式，可配置三种值，分别为：
		(1) '' ：即使使用了 $this->output->cache(n); 也不会缓存
		(2) 'kvdb' ：使用 KVDB 缓存 (默认) (需要开启SAE KVDB服务)
		(3) 'memcache'：使用 memcache 缓存 (需要开启SAE Memcache服务)
	3.系统默认ttl (缓存过期时间)为60秒，若ttl设置为0，则数据永不过期。memcache和kvdb同样适用。
	
注意，由于kvdb方式没有过期删除机制，现修改为自动判断是否过期，若过期则删除。

-----------------------------------------------------------
Email类
-----------------------------------------------------------
使用SAE原生Mail类重构此部分代码。

因为SAE Mail暂只支持SMTP协议，且无密送功能，故删除以下参数：
	useragent, mailpath, smtp_timeout, charset(默认强制utf8，否则中文会乱码), priority, crlf, bcc_batch_mode, bcc_batch_size
	
增加以下参数：
	tls, compress, callback_url  (参数说明见 http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a116)
	
修改“添加附件”方法
public function attach($filename, $file_path)
	$filename 为附件的文件名，如"pic.jpg" (文件支持类型见 http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a291)
	$file_path 为文件的URL, 如 "http://ww4.sinaimg.cn/thumbnail/6310d41cjw1e1g85nxi1lj.jpg"
	
添加"quick_send" 方法，方便快速发送邮件。此方法自动忽略其他参数。且仅支持发送content_type为TEXT）
public function quick_send($to, $subject, $msgbody, $smtp_user, $smtp_pass, $smtp_host='', $smtp_port=25, $smtp_tls=false)

更多使用参考 http://apidoc.sinaapp.com/__filesource/fsource_sae__saemail.class.php.html#a200
 
使用示例：
$this->load->library('email');      
$config = array();      
$config['smtp_host'] = 'smtp.sina.com';      
$config['smtp_user'] = 'test@sina.com';      
$config['smtp_pass'] = 'test';     
//$config['tls'] = TRUE;  //Gmail需要加密连接，其他一般不需设置     
$config['compress'] = 'my_pic'; //压缩所有附件为zip包，且命名为"my_pic.zip"     

$this->email->initialize($config);
$this->email->from('test@sina.com');
$this->email->to('10000@qq.com');
$this->email->subject('hello');
$this->email->message('你好');
$this->email->attach('pic1.jpg','http://example.com/pic1.jpg');
$this->email->attach('pic2.jpg','http://example.com/pic2.jpg');
$this->email->send();

//快速发送邮件，如果smtp邮箱为常见邮箱(sina,gmail,163,265,netease,qq,sohu,yahoo) 不需配置smtp_host等参数
$this->load->library('email');
$this->email->initialize();
$this->email->quick_send('10000@qq.com', '测试邮件', '测试', 'test@sina.com', 'test');

-----------------------------------------------------------
文件上传类
----------------------------------------------------------- 
偏好设置中$config['upload_path'] 必须使用SAE中设定的storage名称（storage服务需开启和设置），
如已经有一个名为"public"的storage，则为：$config['upload_path'] = 'public'，其他的设置不变。
可以支持文件夹，格式为：$config['upload_path'] = 'public/demo', "public"为storage名，"demo"为文件夹名。若只给出Storage名，则上传到根目录
上传成功后， $this->upload->data()新增"file_url"属性，为文件URL链接。
 
使用示例：
$config['upload_path'] = 'public/demo';  //上传文件保存位置
$config['allowed_types'] = 'gif|jpg|png';  //支持文件类型
$config['encrypt_name'] = true;   //随机文件名
 
$this->load->library('upload', $config);  
if (! $this->upload->do_upload()) {  
   print_r($this->upload->display_errors());  
   $data['error'] = array('error' => $this->upload->display_errors());  
   print_r($data['error']);  
} else {  
   $data = $this->upload->data();  
   echo $data['file_url']; //上传文件成功后的URL路径 
}
 
----------------------------------------------------------- 
图像处理
-----------------------------------------------------------
待处理图片需放在Storage下，偏好设置注意：
1.$config['image_library']（自动强制使用'gd2'） 
2.$config['source_image'] = '/public/test/source.jpg'; 	必须为 storage名/文件夹(可选)/文件名 格式 
3.$config['new_image'] = '/public/test/new.png'; 	必须为 storage名/文件夹(可选)/文件名 格式 
4.$config['wm_overlay_path'] = '/public/test/wm.png';	必须为 storage名/文件夹(可选)/文件名 格式 

使用示例：
$config['source_image'] = '/public/test/source.jpg';
$config['new_image'] = '/public/test/new.jpg';
$config['maintain_ratio'] = TRUE;
$config['width'] = 250;
$config['height'] = 100;

$this->load->library('image_lib', $config); 
$this->image_lib->resize();
 
-----------------------------------------------------------
验证码类
-----------------------------------------------------------
使用原生SAE Vcode服务, 生成的验证码为大写字母和数字的结合, image大小80*20.  
注意:
create_captcha()初始化不需提供参数, 返回一个数组, array('word'=>正确的验证码,'image'=>验证码图片URL);

使用示例：
$this->load->helper('captcha');
$cap = create_captcha();
echo $cap['word']; //验证码答案 (大写 数字)
echo $cap['image']; //验证码图片URL ( 80*20 )

-----------------------------------------------------------
文件辅助类
-----------------------------------------------------------
由于SAE下不支持写操作, 所以禁用 涉及写操作的 write 和 delete 函数
application\helpers\file_helper.php

-----------------------------------------------------------
扩展 Storage辅助类
-----------------------------------------------------------
新增 application\helpers\storage_helper.php 辅助类, 提供常用对Storage的读写操作 (另此辅助类 同时服务于 application\libraries下的 Image_lib 和 Upload)
写操作: s_write 
读操作: s_read
删除操作: s_delete
更多参考源码 application\helpers\storage_helper.php

使用示例：
$this->load->helper('storage'); //加载storage辅助类
$data = 'hello world';
s_write('public/test.txt', $data); //写入到domain为public下的 test.txt. 支持文件夹, 例如 'public/dir/test.txt'

----------------------------------------------------------- 
日志类
-----------------------------------------------------------
替换CI日志类为原生SAE日志类，application\libraries\Log.php
使用示例：
log_message('error','your messages');
log_message('debug','your messages');
（需在配置文件中 手动打开log模式 $config['log_threshold']，默认为关闭）

查看方法: 
SAE应用管理的日志中心, 选择"debug"中进行查看.
 
-----------------------------------------------------------
删除SAE不支持的类
-----------------------------------------------------------
zip类
迁移类
FTP类 