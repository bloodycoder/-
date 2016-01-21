<html><head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
    </head><body>
    <div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="/pingke_index/">评课网</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					</ul>
					<form method = "post" action = "/pingke_index/search/" class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder = "输入课程名字" name = "course"/>
						</div> <button type="submit" class="btn btn-default" >搜索</button>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<li>
							 <a href="/test/">注册</a>
						</li>
						<li>
							 <a href="/test/log/">登录</a>
						</li>
						<li>
							 <a href="#">关于我们</a>
						</li>
					</ul>
				</div>
			</nav>

<div class="section"><div class="container">
	<?php echo validation_errors();?>
	<div class="row"><div class="col-md-12"><form class="form-horizontal" role="form" method = "post"><div class="form-group">
		<div class="col-sm-2"><label for="inputEmail3" class="control-label">用户名</label></div><div class="col-sm-10">
		<input type="text" class="form-control" id="inputEmail3" name = "user_name"></div></div><div class="form-group">
		<div class="col-sm-2"><label for="inputEmail3" class="control-label">昵称</label></div><div class="col-sm-10">
		<input type="text" class="form-control" id="inputEmail3" name = "nick_name"></div></div><div class="form-group">
		<div class="col-sm-2"><label for="inputPassword3" class="control-label" >密码</label></div><div class="col-sm-10">
		<input type="password" name = "psw1" class="form-control" id="inputPassword3" placeholder="Password">
		<br>
		<input type="password" name = "psw2" class="form-control" id="inputPassword3" placeholder="Password again">
	</div></div><div class="form-group">
		<div class="col-sm-offset-2 col-sm-10"></div></div>
		<div class="form-group"><div class="col-sm-offset-2 col-sm-10"><button type="submit" class="btn btn-default">注册</button></div></div></form></div></div></div></div></body></html>