<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_coordinat/aksi_coordinat.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Coordinat</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Pilih Perumahan Yang akan di Spek</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<table id="myTable" class="table table-bordered table-striped">
										<thead>
											<tr>
												<Th>No</Th>
												<Th>Block</Th>	
												<Th>X</Th>
												<Th>Y</Th>
												<Th>id_indikasi</Th>
											</tr>
										</thead>
										<?php
											$no='1';
											$query=(mysql_query("select * from coord order by id_coord asc "));
												while ($hasil=mysql_fetch_array($query)){
										?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['block']?></td>
												<td><?=$hasil['x']?></td>
												<td><?=$hasil['y']?></td>
												<td><?=$hasil['id_indikasi']?></td>
											</tr>
											<?php
											$no++ ; }
											?>
									</table>
								
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=profil_perush&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="<?=$aksi?>?module=coordinat&act=save_coord"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</section>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>

<?php
	}
}
?>
