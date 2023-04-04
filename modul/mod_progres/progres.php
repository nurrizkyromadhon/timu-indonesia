<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_progres/aksi_progres.php";
	
switch($_GET[act]){
	// Tampil User
default:
?>

	<section class="content-header">
		<h1>Progres Pembangunan Rumah</h1>
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
				<h3 class="box-title">List Data Progres Pembangunan Rumah</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<table id="example1" class="table table-bordered table-striped ">
							<thead>
								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Nama Pemborong</th>
									<th>OB</th>
									<th>Blok Rumah</th>
									<th>Progres %</th>
									<th>Keterangan </th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=mysql_query("SELECT * from progres join coord on id_coord_progres=id_coord order by tgl_progres DESC");
									$x=1;
									while ($r=mysql_fetch_array($tampil)){
										?>
											<tr>
												<td><?php echo $x;?></td>
												<td><?php echo $r['tgl_progres'];?></td>
												<td><?php echo $r['nm_pemborong'];?></td>
												<td><?php echo $r['ob'];?></td>
												<td><?php echo $r['block'];?></td>
												<td><?php echo $r['prosen_progres'];?></td>
												<td><?php echo $r['ket'];?></td>
												<td class='center' width='150'>
													<a class="btn btn-primary btn-sm" href="?module=progres&act=edit&id=<?=$r['id_progres']?>"><span class="fa fa-edit"></a>
													<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=progres&act=hapus&id=<?=$r['id_progres']?>"><span class="fa fa-trash"></a>
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
					<a href="?module=progres&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
		<h1>Progress Rumah</h1>
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
						<form class="form-horizontal" method="post" action="<?=$aksi?>?module=progres&act=tambah">
						  <div class="box-body">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Tanggal</label>
							  <div class="col-sm-6">
								<input type="date" class="form-control" name="tgl_progres" >
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama Pemborong</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nm_pemborong" placeholder="Input Nama Pemborong ....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Order Bangunan (OB)</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="ob" placeholder="Input OB ....">
							  </div>
							</div>							
							<div class="form-group">
							  <label class="col-sm-2 control-label">Blok</label>
							  <div class="col-sm-6">
								  <select class="form-control select2" name="id_coord" data-placeholder="Pilih Nama Blok" style="width: 100%;">
									<?php
									$tampil=mysql_query("SELECT * FROM coord ORDER BY id_coord");
									while($r=mysql_fetch_array($tampil)){
										?>
										<option value="<?=$r['id_coord']?>"><?=$r['block']?></option>
										<?php
									} 
									?>
								  </select>
							  </div>
							</div>

							<div class="form-group">
							  <label class="col-sm-2 control-label">Progres %</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="prosen_progres" placeholder="Input progres ....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Keterangan</label>
							  <div class="col-sm-6">
								<textarea class="form-control" name="ket" placeholder="Input Keterangan ...."></textarea>
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
	<script>
		$(function () {
			$(".select2").select2();
		});
	</script>    
<?php
break;
		
case "edit":
 $edit = mysql_query("SELECT * FROM progres join coord on id_coord_progres=id_coord WHERE id_progres='$_GET[id]'");
 $r    = mysql_fetch_array($edit);
 ?>
	<section class="content-header">
		<h1>Progress Pembangunan Rumah</h1>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=progres&act=edit">
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Tgl Progres</label>
								  <div class="col-sm-6">
									<input type="hidden" name="id" value="<?=$r['id_progres'];?>">
									<input type="text" class="form-control" name="tgl_progres" value="<?=$r['tgl_progres'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama Pemborong</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="nm_pemborong" value="<?=$r['nm_pemborong'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Order Bangunan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="ob" value="<?=$r['ob'];?>">
								  </div>
								</div>								
							<div class="form-group">
							  <label class="col-sm-2 control-label">Blok</label>
							  <div class="col-sm-6">
								  <select class="form-control select2" name="id_coord" style="width: 100%;">
                                  <option value="<?=$r['id_coord']?>"><?=$r['block']?></option>
									<?php
									$tampil1=mysql_query("SELECT * FROM coord ORDER BY id_coord");
									while($r1=mysql_fetch_array($tampil1)){
										?>
										<option value="<?=$r1['id_coord']?>"><?=$r1['block']?></option>
										<?php
									} 
									?>
								  </select>
							  </div>
                          </div>    
								<div class="form-group">
								  <label class="col-sm-2 control-label">Prosen Progres</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="prosen_progres" value="<?=$r['prosen_progres'];?>">
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Keterangan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="ket" value="<?=$r['ket'];?>">
								  </div>
								</div>
								
							  </div>
							<!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary pull-right">EDIT</button>
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
