<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_lokasi/aksi_lokasi.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>lokasi</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">lokasi</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List lokasi</h3>
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
								<th>Nama lokasi</th>
								<th>Alamat</th>
								<th>Aksi</th>
							</tr>
							</thead>
								<?php
									$no=1;
								
									$query="SELECT * FROM lokasi order by id_lokasi desc";
									$qry=mysql_query($query);
									while ($hasil=mysql_fetch_array($qry)){
										?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['nama_lokasi']?></td>
												<td><?=$hasil['alamat']?></td>
												<td>
													<a class="btn btn-primary btn-sm" href=<?php echo "?module=lokasi&act=edit&id=$hasil[id_lokasi]";?>><span class="fa fa-edit"></a>
													<a class="btn btn-danger btn-sm" href=<?php echo "'$aksi?module=lokasi&act=hapus&id=$hasil[id_lokasi]'";?>><span class="fa fa-trash"></a>
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
					<a href="?module=lokasi&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
		<h1>lokasi</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">SPP</a></li>
			<li class="active">Form Tambah lokasi</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah lokasi</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=lokasi&act=input">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-2 control-label">Nama lokasi</label>
										  <div class="col-sm-4">
											<input type="text" class="form-control" name="nama_lokasi" placeholder="Input Nama Lokasi">
										  </div>
										</div>
										
										<div class="form-group">
										  <label class="col-sm-2 control-label">Singkatan lokasi</label>
										  <div class="col-sm-4">
											<input type="text" class="form-control" name="kode" placeholder="Singkatan Lokasi">
										  </div>
										</div>
																				
										<div class="form-group">
										  <label class="col-sm-2 control-label">Alamat</label>
										  <div class="col-sm-6">
											<textarea class="form-control" name="alamat"></textarea>
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Di Buat Oleh</label>
										  <div class="col-sm-5">
											<input type="text" class="form-control" name="dibuat" placeholder="Nama">
											<input type="text" class="form-control" name="jab1" placeholder="Jabatan">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Disetujui Oleh</label>
										  <div class="col-sm-5">
											<input type="text" class="form-control" name="disetujui" placeholder="Nama">
											<input type="text" class="form-control" name="jab2" placeholder="Jabatan">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Diketahui Oleh (1)</label>
										  <div class="col-sm-5">
											<input type="text" class="form-control" name="diketahui" placeholder="Nama">
											<input type="text" class="form-control" name="jab3" placeholder="Jabatan">
										  </div>
										</div>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Diketahui Oleh (2)</label>
										  <div class="col-sm-5">
											<input type="text" class="form-control" name="tambahan" placeholder="Nama">
											<input type="text" class="form-control" name="jab4" placeholder="Jabatan">
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

$id_lokasi = $_GET['id'];
if (empty($id_lokasi)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from lokasi where id_lokasi='$id_lokasi'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>lokasi</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">lokasi</a></li>
			<li class="active">Form Edit lokasi</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit Lokasi</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=lokasi&act=update">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama lokasi</label>
								  <div class="col-sm-6">
									<input type="hidden" class="form-control" name="id_lokasi" value='<?php echo $update['id_lokasi'];?>'>
									<input type="text" class="form-control" name="nama_lokasi" placeholder="Input No SPP...." value='<?php echo $update['nama_lokasi'];?>'>
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Singkatan lokasi</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="kode" placeholder="Singkatan Nama lokasi" value="<?php echo $update['kode'];?>">
								  </div>
								</div>	
															
								<div class="form-group">
								  <label class="col-sm-2 control-label">Alamat</label>
								  <div class="col-sm-6">
									<textarea class="form-control" name="alamat"><?php echo $update['alamat'];?></textarea>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Dibuat Oleh</label>
								  <div class="col-sm-5">
									<input type="text" class="form-control" name="dibuat" placeholder="Nama" value="<?php echo $update['dibuat'];?>"><input type="text" class="form-control" name="jab1" placeholder="Jabatan" value="<?php echo $update['jab1'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Disetujui Oleh</label>
								  <div class="col-sm-5">
									<input type="text" class="form-control" name="disetujui" placeholder="Nama" value="<?php echo $update['disetujui'];?>">
									<input type="text" class="form-control" name="jab2" placeholder="Jabatan" value="<?php echo $update['jab2'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Diketahui Oleh (1)</label>
								  <div class="col-sm-5">
									<input type="text" class="form-control" name="diketahui" placeholder="Nama" value="<?php echo $update['diketahui'];?>">
									<input type="text" class="form-control" name="jab3" placeholder="Jabatan" value="<?php echo $update['jab3'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Diketahui Oleh (2)</label>
								  <div class="col-sm-5">
									<input type="text" class="form-control" name="tambahan" placeholder="Nama" value="<?php echo $update['tambahan'];?>">
									<input type="text" class="form-control" name="jab4" placeholder="Jabatan" value="<?php echo $update['jab4'];?>">
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