<body>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="<?=pingke_url()?>/pingke_index/">评课网</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
					</ul>
					<form method = "post" action = "<?=pingke_url()?>/pingke_index/search/" class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" placeholder = "输入课程名字" name = "course"/>
						</div> <button type="submit" class="btn btn-default" >搜索</button>
					</form>
					<ul class="nav navbar-nav navbar-right">
						<?php  if($is_login == 1): ?>	
								<li>
									<a href="#"><?php echo $nickname;?>，您好</a>
								</li>					
								<li>
								<a href="<?=pingke_url()?>/test/logout/">登出</a>
								</li>
								<li>
								 <a href="#">关于我们</a>
								</li>
						<?php else:?>
								<li>
									 <a href="<?=pingke_url()?>/test/">注册</a>
								</li>
								<li>	
									 <a href="<?=pingke_url()?>/test/log/">登录</a>
								</li>
								<li>
									 <a href="#">关于我们</a>
								</li>
			
						<?php endif;?>

					</ul>
				</div>
			</nav>
			<br>
			<div class="jumbotron">
				<h1>
					课程评测网
				</h1>
				<p>
					在这里可以查看课程评分和教师评分哦。
				</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>