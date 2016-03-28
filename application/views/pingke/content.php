<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://pingendo.github.io/pingendo-bootstrap/themes/default/bootstrap.css" rel="stylesheet" type="text/css">
</head>
<body>

<script type="text/javascript">
	function star(){

	window.open('<?=pingke_url()?>/pingke_index/star/','Window','width=600,height=400,top=100')    
	}

	function reply (id1, id2){
		var text = document.getElementById(id1)
		if(text.style.display=="inline"){
			text.style.display="none";
		}else{
			text.style.display="inline";
		}			
		
		var subtn = document.getElementById(id2);
		if(subtn.style.display=="inline"){
			subtn.style.display="none";
		}else{
			subtn.style.display="inline";
		}	
	}

</script>
</head>

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
		</div>
	</div>
	<br>
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="jumbotron">
				<h1>
					<?php echo $course_name;?>
				</h1>
				<p>
					<?php 

						echo "这门课由";
						echo $teacher_name;
						echo "老师教，";
						echo "共有";
						echo $people;
						echo "名同学打分,";
						echo "评分为";
						echo $score;

					?>
				</p>
				<p>

<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"  href="<?=pingke_url()?>/pingke_index/star/<?=$pig?>">
   点我打分
</button>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" 
   aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm">
      <div class="modal-content">
  
      </div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>
				</p>
			</div>
	  <br>
	  <legend></legend>
      <div class="row">

<!--
    <div class="col-md-12">
        <h4>nickname</h4>
        <pre style="font-size:18">there is content</pre>		
		<a id='#12' href="javascript:void(0)" onclick="reply('#11','#13')" style="float:right;">reply</a><br />
		<textarea id="#11" cols="120%" rows="5" name="reply"  style="margin-left:20%;" hidden>here is reply</textarea><br />        
		<button id='#13' type="submit" class="btn btn-default" style="float:right;display:none;">submit</button>
		<p style="clear:both;">&nbsp;<p>
		<legend></legend>
    </div>
-->

      	<?php if($comment1):?>
        <div class="col-md-12">
          <h4><?php echo $nickname1;?></h4>
          <pre style="font-size:18"> <?php echo $content1;?></pre>
          <legend></legend>
        </div>
    	<?php endif;?>
    	<?php if($comment2):?>
        <div class="col-md-12">
          <h4><?php echo $nickname2;?></h4>
          <pre style="font-size:18"> <?php echo $content2;?></pre>
          <legend></legend>
        </div>
        <?php endif;?>
        <?php if($comment3):?>
        <div class="col-md-12">
          <h4><?php echo $nickname3;?></h4>
          <pre style="font-size:18"> <?php echo $content3;?></pre>
          <legend></legend>
        </div>
        <?php endif;?>
        <?php if($comment4):?>
        <div class="col-md-12">
          <h4><?php echo $nickname4;?></h4>
          <pre style="font-size:18"><?php echo $content4;?></pre>
          <legend></legend>
        </div>
        <?php endif;?>
        <?php if($comment5):?>
        <div class="col-md-12">
          <h4><?php echo $nickname5;?></h4>
          <pre style="font-size:18"> <?php echo $content5;?></pre>
          <legend></legend>
        </div>
    	<?php endif;?>
    	<?php if($comment6):?>
        <div class="col-md-12">
          <h4><?php echo $nickname6;?></h4>
          <pre style="font-size:18">  <?php echo $content6;?></pre>
          <legend></legend>

        </div>
        <?php endif;?>
    </div>

      <div class="row">
			<div class="row clearfix">
				<div class="col-md-4 column">
				</div>
				<div class="col-md-4 column">
					<ul class="pagination">
						<li>
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $pre;
							 	echo "/";
							 	?>>Prev</a>
						</li>
						<?php if($page1):?>
						<li 
 							<?php if($current_page == $page1):?>
						    class = "active"
						    <?php endif;?>				
						    >
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $page1;
							 	echo "/";
							 	?>><?php echo $page1;?></a>
						</li>
					    <?php endif;?>
					    <?php if($page2):?>
						<li 
						 	<?php if($current_page == $page2):?>
						    class = "active"
						    <?php endif;?>	
						    >
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $page2;
							 	echo "/";
							 	?>><?php echo $page2;?></a>
						</li>
						<?php endif;?>
						<?php if($page3):?>
						<li
 							<?php if($current_page == $page3):?>
						    class = "active"
						    <?php endif;?>	
						>
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $page3;
							 	echo "/";
							 	?>><?php echo $page3;?></a>
						</li>
						<?php endif;?>
						<?php if($page4):?>
						<li
 							<?php if($current_page == $page4):?>
						    class = "active"
						    <?php endif;?>	
						>
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $page4;
							 	echo "/";
							 	?>><?php echo $page4;?></a>
						</li>
						<?php endif;?>
						<?php if($page5):?>
						<li
 							<?php if($current_page == $page5):?>
						    class = "active"
						    <?php endif;?>	
						>
							 <a href=<?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $page5;
							 	echo "/";
							 	?>><?php echo $page5;?></a>
						</li>
						<?php endif;?>
						<li>
							 <a href= <?php echo pingke_url()."/pingke_index/content/";
							 	echo $course_tea_id;
							 	echo "/";
							 	echo $next;
							 	echo "/";
							 	?>>Next</a>
						</li>
					</ul>
				</div>
				<div class="col-md-4 column">
				</div>
			</div>
		</div>
<div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="page-header">
            <h1>发表评论</h1>
          </div>
        </div>
        <div class="col-md-4"></div>
      </div>
      <div class="row" draggable="true">
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <form method="post" enctype="multipart/form-data" role="form" action = "<?=pingke_url()?>/pingke_index/addcomment/
          <?php echo $course_tea_id;?>
          ">
            <div class="form-group">
              <label class="control-label" for="exampleInputPassword1">内容</label>
              <br>
              <textarea cols="56" rows="5" name="content">这里恰好十八个字，不管你信不，反正我信了。</textarea>
            </div>
            <button type="submit" class="btn btn-default">发表</button>
          </form>
        </div>
        <div class="col-md-4"></div>
      </div>
	</div>
</div>
</body></html>