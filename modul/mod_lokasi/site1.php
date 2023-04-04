<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_site/aksi_site.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Site</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Site</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List Site</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<table id="myTable" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>No.</th>
								<th>Nama Site</th>
								<th>Alamat</th>
								<th>Aksi</th>
							</tr>
							</thead>
								<?php
									$no=1;
								
									$query="SELECT * FROM site order by id_site desc";
									$qry=mysql_query($query);
									while ($hasil=mysql_fetch_array($qry)){
										?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['nama_site']?></td>
												<td><?=$hasil['alamat']?></td>
												<td>
													<a class="btn btn-primary btn-sm" href=<?php echo "?module=site&act=edit&id=$hasil[id_site]";?>><span class="fa fa-edit"></a>
													<a class="btn btn-danger btn-sm" href=<?php echo "'$aksi?module=site&act=hapus&id=$hasil[id_site]'";?>><span class="fa fa-trash"></a>
												</td>
											</tr>
										<?php
										$no++;
									}
								?>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<div class="box-footer">
				<div class="text-center">
					<a href="?module=site&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
				</div>
			</div>
			<!-- /.box-footer -->
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
<script>
$(document).ready(function(){
	$('#myTable').dataTable();
});
</script>
<?php
break;

case "tambah":
?>
	<section class="content-header">
		<h1>Site</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">SPP</a></li>
			<li class="active">Form Tambah Site</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah Site</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=site&act=input">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-2 control-label">Nama Site</label>
										  <div class="col-sm-6">
											<input type="text" class="form-control" name="nama_site" placeholder="Input No SPP....">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Alamat</label>
										  <div class="col-sm-6">
											<textarea class="form-control" name="alamat"></textarea>
										  </div>
										</div>
									  </div>
									  <!-- /.box-body -->
									  <div class="box-footer">
										<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
									  </div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
break;

case "edit":

$id_site = $_GET['id'];
if (empty($id_site)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from site where id_site='$id_site'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>Site</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Site</a></li>
			<li class="active">Form Edit Site</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit SPP</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=site&act=update">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama Site</label>
								  <div class="col-sm-6">
									<input type="hidden" class="form-control" name="id_site" value='<?php echo $update['id_site'];?>'>
									<input type="text" class="form-control" name="nama_site" placeholder="Input No SPP...." value='<?php echo $update['nama_site'];?>'>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Site</label>
								  <div class="col-sm-6">
									<textarea class="form-control" name="alamat"><?php echo $update['alamat'];?></textarea>
								  </div>
								</div>
							</div>
							  <!-- /.box-body -->
							  <div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
							  </div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php 
	break;
	}
}
?>