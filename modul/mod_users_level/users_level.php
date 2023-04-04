<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_users_level/aksi_users_level.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>User Level</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Users Level</li>
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
									<table id="example1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>no</th>
												<th>User Level</th>
												<th>User Level Key</th>
												<th>aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=1;
												$tampil = mysql_query("SELECT * FROM users_level ORDER BY users_level");
												while ($r=mysql_fetch_array($tampil)){
													?>
														<tr>
															<td><?=$no?></td>
															<td><?=$r['users_level']?></td>
															<td><?=$r['users_level_key']?></td>
															<td>
																<a class="btn btn-primary btn-sm" href="?module=userslevel&act=edit&id=<?=$r['id_users_level']?>" ><span class="fa fa-edit"></a>
																<a class="btn btn-danger btn-sm"href="<?=$aksi?>?module=userslevel&act=hapus&id=<?=$r['id_users_level']?>"><span class="fa fa-trash"></a>
															</td>
														</tr>
													<?php
													$no++;
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
								<a href="?module=userslevel&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
					<h1>User Level</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Users Level</a></li>
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
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=userslevel&act=input">
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-2 control-label">User Level</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="users_level" placeholder="Input User Level ....">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">User Level Key</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="users_level_key" placeholder="Input User Level Key ....">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Modul</label>
												<div class="col-sm-6">
													<select class="form-control select2" multiple="multiple" name="id_modul[]" data-placeholder="Pilih Modul ...." style="width: 100%;">
														<?php
															$list=mysql_query("SELECT * FROM modul");
															while($r=mysql_fetch_array($list)) {
																?>
																	<option value="<?=$r['id_modul']?>"><?=$r['nama_modul']?></option>
																<?php
															}
														?>
													</select>
												</div>
											</div>
										</div>
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
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
		
		case "edit":
			$edit=mysql_query("SELECT * FROM users_level WHERE id_users_level='$_GET[id]'");
			$r=mysql_fetch_array($edit);
			?>
				<section class="content-header">
					<h1>User Level</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Users Level</a></li>
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
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=userslevel&act=update">
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-2 control-label">User Level</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="users_level" value="<?=$r['users_level']?>" placeholder="Input User Level ....">
													<input type="hidden" class="form-control" name="id" value="<?=$r['id_users_level']?>" placeholder="Input User Level ....">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">User Level Key</label>
												<div class="col-sm-6">
													<input type="text" class="form-control" name="users_level_key" value="<?=$r['users_level_key']?>" placeholder="Input User Level Key....">
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Modul</label>
												<div class="col-sm-6">
													<select class="form-control select2" name="id_modul[]" multiple="multiple" data-placeholder="Pilih Modul" style="width: 100%;">
														<?php
															$list=mysql_query("SELECT * FROM modul");
															while($r=mysql_fetch_array($list)) {
																$check=mysql_query("SELECT id_modul FROM permission WHERE id_users_level = '$_GET[id]'");
																$flag=false;
																while($c=mysql_fetch_array($check)) {
																	if($r['id_modul'] == $c['id_modul']){
																		$flag=true;
																	}
																}																
																if($flag){												
																	?>
																		<option value="<?=$r['id_modul']?>" selected="selected"><?=$r['nama_modul']?></option>
																	<?php
																}
																else {
																	?>
																		<option value="<?=$r['id_modul']?>"><?=$r['nama_modul']?></option>
																	<?php
																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
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
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
	}
}
?>
