<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_agen/aksi_users.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Manajemen Users</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Users</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List Data Users</h3>
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
								  <th>Username</th>
								  <th>Nama Lengkap</th>
								  <th>Lokasi</th>
								  <th>E-mail</th>
								  <th>No.Telp/HP</th>
								  <th>Level</th>
								  <th>Blokir</th>
								  <th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=mysql_query("select * from users as u
									JOIN users_level as ul ON u.id_users_level=ul.id_users_level 
								    where ul.id_users_level='$_SESSION[id_users_level]' ORDER BY username");
									$x=1;
									while ($r=mysql_fetch_array($tampil)){
									?>
										<tr>
											<td><?php echo $x;?></td>
											<td><?php echo $r['username'];?></td>
											<td><?php echo $r['nama_lengkap'];?></td>
											<td><?php echo $r['nama_lokasi'];?></td>
											<td><?php echo $r['email'];?></td>
											<td><?php echo $r['no_telp'];?></td>
											<td><?php echo $r['users_level'];?></td>
											<td><?php echo $r['blokir'];?></td>
											<td class='center' width='85'><a class="btn btn-primary btn-sm" href="?module=manajemen_user_agen&act=edit&id=<?=$r['id_users']?>"><span class="fa fa-edit"></a>
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
					<a href="?module=manajemen_user_agen&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
		<h1>Manajemen Users</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Users</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=manajemen_user_agen&act=tambah">
						  <div class="box-body">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Username</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="username" placeholder="Input Username....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Password</label>
							  <div class="col-sm-6">
								<input type="password" class="form-control" name="password" placeholder="Input Password....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama Lengkap</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nama_lengkap" placeholder="Input Nama Lengkap....">
							  </div>
							</div>
							<!--<div class="form-group">
							  <label class="col-sm-2 control-label">Lokasi</label>
							  <div class="col-sm-6">
								<select class="form-control" name="lokasi" id="lokasi" >
									<option value="">All lokasi</option>
									 <?php
										/*$query="select * from lokasi order by id_lokasi asc";
										$qry=mysql_query($query);
										while ($hasil_db=mysql_fetch_array($qry)){
											$id_lokasi_db=$hasil_db['id_lokasi'];
											$nama_lokasi_db=$hasil_db['nama_lokasi'];
											if($update == $id_lokasi_db) {
												?>
													<option value="<?=$id_lokasi_db?>"><?=$nama_lokasi_db?></option>
												<?php
											}
											else {
												?>
													<option value="<?=$id_lokasi_db?>"><?=$nama_lokasi_db?></option>
												<?php
											}
										}*/
									?>
								</select>
							  </div>
							</div>-->
							<div class="form-group">
							  <label class="col-sm-2 control-label">E-mail</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="email" placeholder="Input E-mail....">
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">No.Telp/HP</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="no_telp" placeholder="Input No.Telp/HP....">
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Level</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="id_users_level">
									<option value=0 selected>Pilih Level</option>
									<?php
									$tampil=mysql_query("SELECT * FROM users_level where id_users_level='$_SESSION[id_users_level]' ORDER BY users_level");
									while($r=mysql_fetch_array($tampil)){
										?>
										<option value="<?=$r['id_users_level']?>"><?=$r['users_level']?></option>
										<?php
									} 
									?>
								  </select>
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
 $edit = mysql_query("SELECT * FROM users WHERE id_users='$_GET[id]'");
 $r    = mysql_fetch_array($edit);
 ?>
	<section class="content-header">
		<h1>Manajemen Users</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Users</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=manajemen_user_agen&act=edit">
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Username</label>
								  <div class="col-sm-6">
									<input type="hidden" name="id" value="<?=$r['id_users'];?>">
									<input type="text" class="form-control" name="username" value="<?=$r['username'] ;?>" disabled>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Password</label>
								  <div class="col-sm-6">
									<input type="password" class="form-control" name="password">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Nama Lengkap</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="nama_lengkap" value="<?=$r['nama_lengkap'];?>">
								  </div>
								</div>
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">E-mail</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="email" value="<?=$r['email'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">No.Telp/HP</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="no_telp" value="<?=$r['no_telp'];?>">
								  </div>
								</div>
								<div class="form-group">
							<label class="col-sm-2 control-label">Level</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="id_users_level">
									<option value=0 selected>Pilih Level</option>
									<?php
									$tampil=mysql_query("SELECT * FROM users_level where id_users_level='$_SESSION[id_users_level]' ORDER BY users_level");
									while($c=mysql_fetch_array($tampil)){
										if($c['id_users_level'] == $r['id_users_level']){
											?>
											<option value="<?=$c['id_users_level']?>" selected><?=$c['users_level']?></option>
											<?php
										}
										else{
											?>
											<option value="<?=$c['id_users_level']?>"><?=$c['users_level']?></option>
											<?php
										}
									} 
									?>
								  </select>
							  </div>
							</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Blokir</label>
								  <div class="radio col-sm-6">
									<?php
										if($r['blokir']=="Y"){
											?>
												<label>
												  <input type="radio" name="blokir" id="blokir1" value="Y" checked>
												  Y
												</label>
												<label>
												  <input type="radio" name="blokir" id="blokir2" value="N">
												  N
												</label>
											<?php
										}
										else{
											?>
												<label>
												  <input type="radio" name="blokir" id="blokir1" value="Y">
												  Y
												</label>
												<label>
												  <input type="radio" name="blokir" id="blokir2" value="N" checked>
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
