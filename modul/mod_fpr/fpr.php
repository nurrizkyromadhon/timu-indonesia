<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_fpr/aksi_fpr.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Pembatalan</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
				
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Pembatalan</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Kavling Sudah Terjual</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <table id="myTable1" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
										  <th>Batal</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi!='1'
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											$id_nasabah=$hasil['id_nasabah'];
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td align="right"><?=number_format($hasil['harga_jual'])?></td>
											<td align="right"><?=number_format($hasil['kpr'])?></td>
											<td align="right"><?=number_format($hasil['um'])?></td>
											<td>
												<button type="button" class="btn btn-blue" onclick="location.href='<?php echo "?module=fpr&act=tambah&id=$id_nasabah";?>';" ><i class="fa fa-print"></i></button>
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
					<h1>Penerimaan Berkas User dari Marketing</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Document User</a></li>
						<li class="active">Form input Documen</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Document</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=batal&act=batal">
										<div class="col-md-6">	
										<H3 align="center">Document :</H3>
												<div class="box-body">
													<div class="form-group">
														<label class="col-sm-5 control-label">Tanggal Terima:</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="tgl" value="<?=date('Y-m-d')?>" />
														</div>
													</div>											
													<div class="form-group">
														<label class="col-sm-5 control-label">Blok Kavling :</label>
														<div class="col-sm-5">
															<?php
																$qry0=mysql_query("Select * from nasabah where id_nasabah='$_GET[id]';");
																$hasil0=mysql_fetch_array($qry0); 
															?>
														  <input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>">	
														  <input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama User :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="tipe" value="<?=$hasil0['nama_user']?>" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Jenis Type :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="tipe" value="<?=$hasil0['type_rumah']?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Harga Jual :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga" value="<?=number_format($hasil0['harga_jual'])?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">KPR :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="disc" value="<?=number_format($hasil0['kpr'])?>" id='koma'  />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Nomor Pembatalan :</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="no_batal" />
														</div>
													</div>		
													<div class="form-group">
														<label class="col-sm-5 control-label">Keterangan :</label>
														<div class="col-sm-5">
														  <textarea name="ket_batal" class="form-control" rows="3" placeholder="Enter ..."></textarea>
														</div>
													</div>	
													<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>					
												</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>
				</div>
				</section>
				<script>
				  $(function () {
					$(".select2").select2();
				  });
					
				  $(document).ready(function(){
					$('#koma').maskMoney({precision:0});
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
