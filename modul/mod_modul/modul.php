<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_modul/aksi_modul.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Manajemen Modul</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Modul</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List Data Modul</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Modul</th>
									<th>Key Modul</th>
									<th>Link Modul</th>
									<th>Aktif</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=mysql_query("SELECT * from modul");
									$x=1;
									while ($r=mysql_fetch_array($tampil)){
										?>
											<tr>
												<td><?php echo $x;?></td>
												<td><?php echo $r['nama_modul'];?></td>
												<td><?php echo $r['key_modul'];?></td>
												<td><?php echo $r['link_modul'];?></td>
												<td><?php echo $r['aktif'];?></td>
												<td class='center' width='85'>
													<a class="btn btn-primary btn-sm" href="?module=modul&act=edit&id=<?=$r['id_modul']?>"><span class="fa fa-edit"></a>
													<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=modul&act=hapus&id=<?=$r['id_modul']?>"><span class="fa fa-trash"></a>
												</td>
											</tr>
										<?php
										$x++;
									}
								?>
							</tbody>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			
			<div class="box-footer">
				<div class="text-center">
					<a href="?module=modul&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
				</div>
			</div>
			<!-- /.box-footer -->
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<script>
		$(function () {
			$("#example1").DataTable();
		});
	</script>
<?php
break;
	  
case "tambah":
?>
	<section class="content-header">
		<h1>Manajemen Modul</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Modul</a></li>
			<li class="active">Form Tambah</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=modul&act=tambah">
						  <div class="box-body">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama Modul</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nama_modul" placeholder="Input Nama Modul....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Key Modul</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="key_modul" placeholder="Input Key Modul....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Link Modul</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="link_modul" placeholder="Input Link Modul....">
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Aktif</label>
							  <div class="radio col-sm-6">
								<label>
								  <input type="radio" name="aktif" id="aktif1" value="Y" checked>
								  Y
								</label>
								<label>
								  <input type="radio" name="aktif" id="aktif2" value="N">
								  N
								</label>
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
	</section>
<?php
break;
		
case "edit":
 $edit = mysql_query("SELECT * FROM modul WHERE id_modul='$_GET[id]'");
 $r    = mysql_fetch_array($edit);
 ?>
	<section class="content-header">
		<h1>Manajemen Modul</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Modul</a></li>
			<li class="active">Form Edit</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Edit</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=modul&act=edit">
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama Modul</label>
								  <div class="col-sm-6">
									<input type="hidden" name="id" value="<?=$r['id_modul'];?>">
									<input type="text" class="form-control" name="nama_modul" value="<?=$r['nama_modul'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Key Modul</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="key_modul" value="<?=$r['key_modul'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Link Modul</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="link_modul" value="<?=$r['link_modul'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Aktif</label>
								  <div class="radio col-sm-6">
									<?php
									if($r['aktif']=="Y"){
										?>
											<label>
											  <input type="radio" name="aktif" id="aktif1" value="Y" checked>
											  Y
											</label>
											<label>
											  <input type="radio" name="aktif" id="aktif2" value="N">
											  N
											</label>
										<?php
									}
									else{
										?>
											<label>
											  <input type="radio" name="aktif" id="aktif1" value="Y">
											  Y
											</label>
											<label>
											  <input type="radio" name="aktif" id="aktif2" value="N" checked>
											  N
											</label>
										<?php
									}
								?>
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
	</section>
<?php
break;
	}
}
?>
