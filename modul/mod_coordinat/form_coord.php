<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_coordinat/aksi_mod_coord.php";
	switch($_GET[act]){
		// Tampil User
		default:
?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Input Coordinat</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">FORM INPUT </h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>INPUT DATA COORDINAT GAMBAR ICON</h2>
										</div>
										<div class="row">
											<div class="table-responsive">
												<form name="myForm" action="input_coord_save.php"><p>
													<input type="hidden" name="coordx" id="coordx" size="5" />
													<input type="hidden" name="coordy" id="coordy" size="5" /> <p>
													<input type="hidden" name="siteplant" value="<?=$siteplant?>" /><p>

													<div class="row">
														<label class="col-sm-2 control-label">Nama Blok Kavling</label>
														<div class="col-sm-7">
														<input type="text" class="form-control" name="kavling" onFocus="hitung();" />
														</div>
													</div></br>

													<div class="row">
														<label class="col-sm-2 control-label">Image Indikasi</label>
														<div class="col-sm-7">
															<Select name="img" class="form-control" />
																<option value="">-Pilih-</option>
																<?php
																	$query="select * from indikasi";
																	$qry=mysql_query($query);
																	while ($hasil=mysql_fetch_array($qry)){
																		$indikasi=$hasil['indikasi'];
																		$id_indikasi=$hasil['indikasi'];
																		$img=$hasil['gambar'];
																?>
																<option value="<?=$id_indikasi?>">
																	<?=$indikasi?>
																</option>
																<?php 
																}?>
															</select>
														</div>
													</div></br>
													<input type="submit" name="submit" value="Save"></br>
												</form>        										<!--- Tempat Tabel --->
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
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
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
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
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=input">
										<div class="box-body">
											FORM TAMBAH
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
							<h3 class="box-title">Form Input</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->

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
