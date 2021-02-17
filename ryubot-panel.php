?>
<?php
$base = __DIR__.'/ryulogs';
$scan = scandir($base);
?>
<!DOCTYPE html>
<html>
<head>
	<title>:: RyuBot Panel ::</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<style type="text/css">
		html,body{scroll-behavior: smooth;}
		.section{min-height: 700px;height: 100%;margin-top: 100px}
		.navbar-float{position:fixed;left: 0;margin-top: 20%}
		.navbar-float>li{list-style: none;margin: 10px}
		.code{background: #333}.mt-2{margin-top: 20px}
	</style>
	<link rel="stylesheet" type="text/css" href="https://brobin.github.io/hacker-bootstrap/css/hacker.css">
</head>
<body>
	<div class="navbar-float">
	<li><a href="#welcome" class="btn btn-danger">&#x2680;</a></li>
	<li><a href="#statistic" class="btn btn-warning">&#x2681;</a></li>
	<li><a href="#config" class="btn btn-primary">&#x2682;</a></li>
</div>
	<div class="container container-fluid" style="width: 70%">
	
<div class="section" id="welcome">
<center><h1>RyuBot Panel</h1></center>
<hr>
<div class="row">
	<?php
	foreach($scan as $dir){
		if(!preg_match("/log/",$dir))continue;
		?>

	<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6 mt-2">
		<h3><?=$dir;?></h3>
		<textarea class="form-control" style="width: 100%;height: 300px"><?=@file_get_contents($base.'/'.$dir);?></textarea>
	</div>
	<?php
}
?>
</div>
</div>
<div id="statistic" class="section">
<div class="table-responsive">
<table class="table table-hover table-striped">
	<thead>
		<th>No.</th>
		<th>Filename</th>
		<th>Size</th>
		<th>Line count</th>
		<th>Action</th>
	</thead>
	<tbody>
	</tbody>
	<?php
	
	$n=1;
	foreach($scan as $dir){
		if($dir == '.' || $dir =='..' )continue;
		?>
		<tr>
		<td><?=$n++;?></td>
		<td><?=$dir;?></td>
		<td><?=$this->human_filesize(filesize($base.'/'.$dir));?></td>
		<td><?=$this->count_line($base.'/'.$dir);?></td>
		<td>
			<a href="ryulogs/<?=$dir;?>">View</a>|<a href="?ryupanel=delete&file=ryulogs/<?=$dir;?>">Delete</a></td>
	</tr>
	<?php
	}
	?>
	</tbody>
</table>
</div>

</div>
<div id="config" class="section">
	<pre class="code">
	<?php

	print_r(json_encode($this->config,JSON_PRETTY_PRINT));
	?>
</pre>
</div>
</div>
</body>
</html>
			<?php
			if($_GET['ryupanel'] == 'delete')
			{
				@unlink($_GET['file']);
				echo "<script>alert('success');window.location.assign('?ryupanel');</script>";
			}
			?>
