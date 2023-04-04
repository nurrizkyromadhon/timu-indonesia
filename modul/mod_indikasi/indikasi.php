<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_indikasi/aksi_indikasi.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Indikasi</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Indikasi</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Indikasi</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<table id="myTable" class="table table-bordered table-striped">
									<thead>
									  <tr align="center">
										<th>No</th>
										<th>Keterangan Gambar</th>
										<th>Gambar</th>
										<th>Aksi</th>
									  </tr>
									 </thead>
									  <?
									  $no=1;
									  $query="select * from indikasi";
									  $qry=mysql_query($query);
									  while ($hasil=mysql_fetch_array($qry)){
									  $ket_gambar=$hasil['indikasi'];
									  $icon=$hasil['gambar'];

									  ?>
									  <tr>
										<td><?=$no?></td>
										<td><?=$ket_gambar?></td>
										<td align="center"><img src="images/<?=$icon?>" width="20" height="20"></td>
										<td>
											<button type="button" class="btn" onclick="location.href='<?php echo "?module=indikasi&act=edit&id=$hasil[id_indikasi]";?>'; " ><i class="fa fa-edit"  ></i></button>
																					
											<!--<button type="button" class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=indikasi&act=hapus&id=$hasil[id_indikasi]";?>'; alert('Pastikan Data akan Terhapus')" ><i class="fa fa-trash"  ></i></button>-->
										</td>
									  </tr>
									  <? $no++; } ?>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<a href="?module=indikasi&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
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
					<h1>Gambar Point </h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Gambar Point</a></li>
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
									<form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?=$aksi?>?module=indikasi&act=input">
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-3 control-label">Keterangan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="indikasi">
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Point :</label>
												<div class="col-sm-5">
													<input class="form-control" type="file" name="point" />
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
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
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
									<form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?=$aksi?>?module=indikasi&act=update">
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-3 control-label">Keterangan :</label>
												<div class="col-sm-5">
												<?php
												$query=(mysql_query("select * from indikasi where id_indikasi='$_GET[id]'"));
												$hasil=mysql_fetch_array($query);
												?>
													<input class="form-control" type="text" name="indikasi" value="<?=$hasil['indikasi']?>">
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Point :</label>
												<div class="col-sm-5">
													<input class="form-control" type="file" name="point" value="<?=$hasil['gambar']?>" />
												</div>
											</div>	
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" class="btn btn-primary pull-right">Edit</button>
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
