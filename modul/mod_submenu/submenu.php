<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_submenu/aksi_submenu.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Manajemen Sub Menu</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Sub Menu</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">List Data Sub Menu</h3>
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
								  <th>Sub Menu</th>
								  <th>Menu Utama</th>
								  <th>Link Submenu</th>
								  <th>Aktif</th>
								  <th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$tampil=mysql_query("SELECT *, submenu.aktif as aktifsub FROM submenu,mainmenu WHERE submenu.id_main=mainmenu.id_main");
									$x=1;
									while ($r=mysql_fetch_array($tampil)){
									if($r['id_submain']!=0){
										$sub = mysql_fetch_array(mysql_query("SELECT * FROM submenu WHERE id_sub=".$r['id_submain']));
										$mainmenu = $r['nama_menu']." &gt; ".$sub['nama_sub'];
									} else {
										$mainmenu = $r['nama_menu'];
										}
										?>
										<tr>
											<td><?php echo $x;?></td>
											<td><?php echo $r['nama_sub'];?></td>
											<td><?php echo $mainmenu;?></td>
											<td><?php echo $r['link_sub'];?></td>
											<td><?php echo $r['aktifsub'];?></td>
											<td class='center' width='85'>
												<a class="btn btn-primary btn-sm" href="?module=submenu&act=edit&id=<?=$r['id_sub']?>"><span class="fa fa-edit"></a>
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=submenu&act=hapus&id=<?=$r['id_sub']?>"><span class="fa fa-trash"></a>
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
					<a href="?module=submenu&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
		<h1>Manajemen Sub Menu</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Sub Menu</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=submenu&act=tambah">
						  <div class="box-body">
							<div class="form-group">
							  <label class="col-sm-2 control-label">Nama Sub Menu</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nama_sub" placeholder="Input Nama Submenu....">
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Menu Utama</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="menu_utama">
									<option value=0 selected>Pilih Menu Utama</option>
									<?php
									$tampil=mysql_query("SELECT * FROM mainmenu WHERE aktif='Y' ORDER BY nama_menu");
									while($r=mysql_fetch_array($tampil)){
										?>
										<option value="<?=$r['id_main']?>"><?=$r['nama_menu']?></option>
										<?php
									} ?>
								  </select>
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Sub Menu</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="sub_menu">
									<option value=0 selected>Pilih Sub Menu</option>
									<?php
									$tampil=mysql_query("SELECT * FROM submenu WHERE id_submain=0 AND aktif='Y' ORDER BY nama_sub");
									while($r=mysql_fetch_array($tampil)){
										?>
									  <option value="<?=$r['id_sub']?>"><?=$r['nama_sub']?></option>
									  <?php
									} ?>
								  </select>
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Link Sub Menu</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="link_sub" placeholder="Input Link Sub Menu....">
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
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-8">
									*) Pilih <b>Menu Utama</b> jika ingin membuat Sub Menu dari Menu Utama <br />
									**) Pilih <b>Sub Menu</b> jika ingin membuat Sub Menu dari Sub Menu (hanya berlaku untuk halaman pengunjung)
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
 $edit = mysql_query("SELECT * FROM submenu WHERE id_sub='$_GET[id]'");
 $r    = mysql_fetch_array($edit);
 ?>
	<section class="content-header">
		<h1>Manajemen Sub Menu</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Sub Menu</a></li>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=submenu&act=edit">
							<div class="box-body">
							<div class="form-group">
							  <input type="hidden" name="id" value="<?=$r['id_sub']?>">
							  <label class="col-sm-2 control-label">Nama Sub Menu</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="nama_sub" value="<?=$r['nama_sub'];?>">
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Menu Utama</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="menu_utama">
									<?php
									$tampil=mysql_query("SELECT * FROM mainmenu WHERE aktif='Y' ORDER BY nama_menu");
									if ($r['id_main']==0){
										?>
										<option value=0 selected>Pilih Menu Utama</option>
										<?php
									}
									while($w=mysql_fetch_array($tampil)){
										if ($r['id_main']==0 || ($r['id_main']!=0 && $r['id_submain']!=0)){
										?>
										<option value="<?=$w['id_main']?>" selected><?=$w['nama_menu']?></option>
										<?php
										}
										else{
										?>
										<option value="<?=$w['id_main']?>"><?=$w['nama_menu']?></option>
										<?php
										}
									} ?>
								  </select>
							  </div>
							</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">Sub Menu</label>
							  <div class="col-sm-6">
								  <select class="form-control" name="sub_menu">
									<?php
									$tampil2=mysql_query("SELECT * FROM submenu WHERE id_submain=0 AND aktif='Y' ORDER BY nama_sub");
									if ($r['id_submain']==0){
										?>
										<option value=0 selected>Pilih Sub Menu</option>
										<?php
									}
									while($b=mysql_fetch_array($tampil2)){
										if ($r['id_submain']==$b['id_sub']){
										?>
										<option value="<?=$b['id_sub']?>" selected><?=$b['nama_sub']?></option>
										<?php
										}
										else{
										?>
										<option value="<?=$b['id_sub']?>"><?=$b['nama_sub']?></option>
										<?php
										}
									} ?>
								  </select>
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-2 control-label">Link Sub Menu</label>
							  <div class="col-sm-6">
								<input type="text" class="form-control" name="link_sub" value="<?=$r['link_sub'];?>">
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
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<div class="col-sm-8">
									*) Pilih <b>Menu Utama</b> jika ingin membuat Sub Menu dari Menu Utama <br />
									**) Pilih <b>Sub Menu</b> jika ingin membuat Sub Menu dari Sub Menu (hanya berlaku untuk halaman pengunjung)
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
