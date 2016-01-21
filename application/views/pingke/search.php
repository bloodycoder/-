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
						<?php  if($is_login == 1): ?>	
								<li>
									<a href="#"><?php echo $nickname;?>，您好</a>
								</li>	
						<li>
							 <a href="/test/logout/">登出</a>
						</li>
						<li>
							 <a href="#">关于我们</a>
						</li>
						<?php else:?>
						<li>
							 <a href="/test/">注册</a>
						</li>
						<li>
							 <a href="/test/log/">登录</a>
						</li>
						<li>
							 <a href="#">关于我们</a>
						</li>
						<?php endif;?>

					</ul>
				</div>
			</nav>
						<?php  if($noteacher == 1): ?>	
							    <?php echo
								'<br>
									';
									echo $course_name;
									echo $judge_root;
									echo $username;
									echo '
									这门课暂时没有教师哦。<br>
									你可以请求管理员添加教师。
								'
								;?>
						<?php endif;?>
			<?php foreach ($info as $items):?>
				<?php echo 
			'<div class="row clearfix">
				<div class="col-md-12 column">
					<h2>';
						echo $items["course_name"];
						echo
					'</h2>
					<p>
					';
						echo "教学老师:";
					    echo $items["teacher_name"];
					    echo "<br>";
					    echo "共有";
					    echo $items["people"];
					    echo "人打分，评分为";
					    echo $items["score"];
					echo
					'
					</p>
					<p>
						 <a class="btn" href="';echo "/pingke_index/content/";echo $items['sid'];echo "/1";echo ' ">查看详细 »</a>
					</p>
				</div>
			</div>'
				;?>
			<?php endforeach;?>
						<?php  if($judge_root == 1): ?>	
						    <?php echo
							'<p>
								 <a class="btn btn-primary btn-large" href="';
								 echo '/pingke_index/add/';
 								 echo $course_id;
								  echo '">增加老师</a>
							</p>'
							;?>
						<?php endif;?>
		</div>
	</div>
</div>
</body></html>