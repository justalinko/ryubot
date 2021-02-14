?><!DOCTYPE html>
<html>
<head>
	<title>:: RyuBot Panel ::</title>
	<style type="text/css">
		html,body{background: #eee;color: #444}
		table{width: 60%;margin:  0 auto;}
		table, th, td {border: 1px solid black;border-collapse:collapse;text-align: center;}
	th{background: #000;color: #eee;text-align: center;}
	a{color: #000;text-decoration: none;font-style: italic;}
	</style>
</head>
<body>
<center><h1>RyuBot Panel</h1></center>
<hr>
<table >
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
	$base = __DIR__.'/ryulogs';
	$scan = scandir($base);
	$n=1;
	foreach($scan as $dir){
		if($dir == '.' || $dir =='..' )continue;
		?>
		<tr>
		<td><?=$n++;?></td>
		<td><?=$dir;?></td>
		<td><?=$this->human_filesize(filesize($base.'/'.$dir));?></td>
		<td><?=$this->count_line($base.'/'.$dir);?></td>
		<td><a href="?ryupanel=delete&file=ryulogs/<?=$dir;?>">Delete</a></td>
	<?php
	}
	?>
	</tbody>
</table>
</body>
</html>
			<?php
			if($_GET['ryupanel'] == 'delete')
			{
				@unlink($_GET['file']);
				echo "<script>alert('success');window.location.assign('?ryupanel');</script>";
			}
			?>
