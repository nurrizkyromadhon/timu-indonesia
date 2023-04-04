<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_coordinat/input_coord1.php";
?>
	<section class="content-header">
		<h1>Nama Perumahan</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Nama Perumahan</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<table width="100%">
						<?php
							$n=0;
							$query="select * from nm_perush";
							$qry=mysql_query($query);
							while ($hasil=mysql_fetch_array($qry)){
							$siteplant=$hasil['siteplant'];
							$nm_perush=$hasil['nm_perush'];
							$nm_perumh=$hasil['nm_perumh'];
							$warna = ($n%2==1)?"#ffffff":"#efefef";
						?>
						  <tr bgcolor="<?=$warna?>">
							<td align="center"><a href="<?=$aksi?>?siteplant=<?=$siteplant?>&nm_perumh=<?=$nm_perumh?>"><h2><?=$nm_perumh?></h2></a>
							<p>&nbsp;</p></td>
						  </tr>
						  <? $n++; } ?>
						</table>
					</div>
					<!-- /.coloum -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /. box body -->		
			<div class="box-footer">
				<div class="text-center">
					<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah Data</button></a>
				</div>
			</div>
			<!-- /.box-footer -->
		</div>
		<!-- /.box default -->
	</section>
<?php } ?>



