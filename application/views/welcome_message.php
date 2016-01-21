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
	<h1>Welcome to CodeIgniter For SinaAppEngine!</h1>

	<div id="body">
		<p>欢迎使用CodeIgniter 2.1.3 For SAE</p>

		<p>此CI框架适应SAE环境，主要修改如下：&nbsp;&nbsp; <?=anchor('welcome/log','更多修改日志&amp;代码示例')?></p>
		<code>
		1.Mysql数据库 进行了读写的主从分离（主库写、从库读）<br>
		2.数据缓存 与 页面缓存 支持memcache和kvdb两种方式<br>
		3.Email类 使用原生SAE的邮件类<br>
		4.文件上传类 使用Storage保存<br>
		5.图像处理类 仅支持GD2函数<br>
		6.验证码类 使用原生SAE的Vcode类<br>
		7.日志类 使用原生SAE日志中心<br>
		</code>
		
		<p>若需隐藏index.php，在config.yaml中添加以下代码，且修改配置文件 $config['index_page'] = '';</p>
		<code>
			handle:<br>&nbsp;&nbsp;- rewrite: if(!is_dir() &amp;&amp; !is_file() &amp;&amp; path~"/") goto "/index.php/%{QUERY_STRING}"
		</code>

		<p>测试页面</p>
		<code>
			<?=anchor('welcome/cache','数据缓存',array('target'=>'_blank'))?>&nbsp;&nbsp;
			<?=anchor('upload/index','文件上传',array('target'=>'_blank'))?>&nbsp;&nbsp;
			<?=anchor('welcome/vcode','验证码',array('target'=>'_blank'))?>&nbsp;&nbsp;
		</code>
		
		<p>CI手册</p>
		<code>
		<a href="http://ellislab.com/codeigniter/user-guide/index.html" target="_blank">英文版</a>&nbsp;&nbsp;
		<a href="http://codeigniter.org.cn/user_guide/index.html" target="_blank">中文版</a>&nbsp;&nbsp;
		<a href="http://www.kuaipan.cn/file/id_11486280147820426.htm" target="_blank">中文CHM版</a>
		</code>
		<p>相关链接</p>
		<code>
			<a href="http://codeigniter.org.cn/" target="_blank">CI中国</a>&nbsp;&nbsp;
			<a href="http://codeigniter.org.cn/forums/forum.php" target="_blank">CI开发者社区</a>&nbsp;&nbsp;
			<a href="http://sae.sina.com.cn/" title="SinaAppEngine" target="_blank"><img src="http://static.sae.sina.com.cn/image/poweredby/117X12px.gif"></a> 
		</code>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>