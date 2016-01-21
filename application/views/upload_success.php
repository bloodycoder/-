<html>
<head>
<title>Upload Form</title>
</head>
<body>

<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p>注意：file_url属性为文件URL访问地址</p>
<p>&nbsp;</p>
<p><?php echo anchor('upload', 'Upload Another File!'); ?></p>

</body>
</html>