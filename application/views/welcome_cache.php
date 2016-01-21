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
	<h1>数据缓存测试</h1>

	<div id="body">
		<form method="post" name="form1">
			<p>写入测试</p>
			<p>Key：<input type="text" name="key1"></p>
			<p>Value：<input type="text" name="value1"></p>
			<p>过期时间(秒)：<input type="text" name="expire1" value="0">&nbsp;设置为0则永不过期</p>
			<p>缓存方式：<input type="radio" name="cache1" value="memcache" checked="checked">Memcache&nbsp;&nbsp;&nbsp;<input type="radio" name="cache1" value="kvdb">KVDB</p>
			<p><input type="submit" value="写入"></p>
			<p>&nbsp;</p>
			<p>读取测试</p>
			<p>Key：<input type="text" name="key2"></p>
			<p>数据位置：<input type="radio" name="cache2" value="memcache" checked="checked">Memcache&nbsp;&nbsp;&nbsp;<input type="radio" name="cache2" value="kvdb">KVDB</p>
			<p><input type="submit" value="读取"></p>
		</form>
		
		<p>&nbsp;</p>
		
		<p>测试结果：</p>
		<code>
		<?php
			if( is_array($result) )
			{
				print_r($result); 
			}
			else
			{
				echo $result;
			}
		?>
		</code>

		<p>&nbsp;</p>
		
		<p><a href="/">返回首页</a></p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>