<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_marketing/aksi_nasabah.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Nasabah</a></li>
						<li class="active">Nasabah</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
				  	<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">BLOK RUMAH </h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Blok Rumah Sudah Terjual</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <table id="myTable1" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>TANGGAL BELI</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>MARKETING</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
										  <th>TGL REAL</th>
										  <th>STATUS</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select *, n.* from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi!='1'
										order by n.tgl_beli desc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_beli']?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['marketing']?></td>
											<td align="right"><?=number_format($hasil['harga_jual'])?></td>
											<td align="right"><?=number_format($hasil['kpr'])?></td>
											<td align="right"><?=number_format($hasil['um'])?></td>
											<td><?=$hasil['tgl_real']?></td>
											<td>
												<?php
										  		if($hasil['id_indikasi']==3){
												?>	
										  			Belum Akad
										  		<?php 
												}else if($hasil['id_indikasi']==5) {
												?>
													Real
												<?php	
												}
										  		?>
											</td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
									</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="<?=$aksi?>?module=nasabah_marketing&act=save_kosong"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->	
				  
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Blok Rumah Belom Terjual</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Laporan Blok Rumah Belom Terjual</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <table id="myTable" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>FPR</th>
										  <th>PPJB</th>
										  <th>OB</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										left join harga as h on n.id_harga=h.id_harga
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi ='1'
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['tipe']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['harga_net']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
									</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="<?=$aksi?>?module=nasabah_marketing&act=save_belom_terjual"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->
									
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Bok Rumah</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Laporan Semua Blok Rumah</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <table id="myTable2" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>FPR</th>
										  <th>PPJB</th>
										  <th>OB</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['harga_jual']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
									</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="<?=$aksi?>?module=nasabah_marketing&act=save_all"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->				
				</section>
				<script>
					$(function () {
						$("#myTable").DataTable();
						$("#myTable1").DataTable();
						$("#myTable2").DataTable();
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
							<h3 class="box-title">Form Edit</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=update">
										<div class="box-body">
											Form Edit SPP
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
