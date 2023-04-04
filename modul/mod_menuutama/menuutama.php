<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_menuutama/aksi_menuutama.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Manajemen Menu Utama</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Menu Utama</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List Data Menu Utama</h3>
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
								  <th>Menu Utama</th>
								  <th>Icon</th>
								  <th>Link</th>
								  <th>Aktif</th>
								  <th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=mysql_query("SELECT * from mainmenu order by nama_menu asc");
									$x=1;
									while ($r=mysql_fetch_array($tampil)){
									?>
										<tr>
											<td><?php echo $x;?></td>
											<td><?php echo $r['nama_menu'];?></td>
											<td><?php echo $r['icon'];?></td>
											<td><?php echo $r['link'];?></td>
											<td><?php echo $r['aktif'];?></td>
											<td class='center' width='85'>
												<a class="btn btn-primary btn-sm" href="?module=menuutama&act=edit&id=<?=$r['id_main']?>"><span class="fa fa-edit"></a>
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=menuutama&act=hapus&id=<?=$r['id_main']?>"><span class="fa fa-trash"></a>
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
					<a href="?module=menuutama&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
		<h1>Manajemen Menu Utama</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Menu Utama</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=menuutama&act=tambah">
						  <div class="box-body">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama Menu</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nama_menu" placeholder="Input Nama Menu....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Icon</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="icon" placeholder="Input Icon....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Link</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="link" placeholder="Input Link....">
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
 $edit = mysql_query("SELECT * FROM mainmenu WHERE id_main='$_GET[id]'");
 $r    = mysql_fetch_array($edit);
 ?>
	<section class="content-header">
		<h1>Manajemen Menu Utama</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Menu Utama</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=menuutama&act=edit">
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama Menu</label>
								  <div class="col-sm-6">
									<input type="hidden" name="id" value="<?=$r['id_main'];?>">
									<input type="text" class="form-control" name="nama_menu" value="<?=$r['nama_menu'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Icon</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="icon" value="<?=$r['icon'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Link</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="link" value="<?=$r['link'];?>">
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
