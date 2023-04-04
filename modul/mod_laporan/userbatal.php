<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_home/aksi_home.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Nasabah Batal</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
								<h2>User Batal dan Pindah</h2>
										<div class="row">
									  <div class="table-responsive">
									  <form name="submit" action="<?=$aksi?>?module=hut_user&act=lunas"&id='<?$id_hutang?>' method="post" >
									  <table id="myTable1" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>Referensi</th>
										  <th>TANGGAL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>SISA HUTANG</th>
										  <th>MARKETING</th>
										  <th>AKSI</th>
										  <th>CEK LUNAS</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *, sum(hutang) as hut, sum(terbayar) as byr, max(tgl_transaksi) as tgl, h.status from hut_user as h
										join nasabah as n on h.id_nasabah=n.id_nasabah
										
										where h.status!='batal'
										group by h.id_nasabah
										
										order by tgl_transaksi desc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											$hut=$hasil['hut'];
											$byr=$hasil['byr'];
											$sisa_hut=$hut-$byr;
											$id_hutang=$hasil['id_hutang'];
											$id_nasabah=$hasil['id_nasabah'];
											$tgl1=$hasil['tgl'];
											$tgl2=date('Y-m-d', strtotime('+30 days', strtotime($tgl1)));
											
										if (strtotime(date("Y-m-d")) <= strtotime($tgl2) or $sisa_hut=='0'){
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['referensi']?></td>
											<td><?=$hasil['tgl']?></td>
											<td><?=$hasil['coord']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=number_format($sisa_hut)?></td>
											<td><?=$hasil['marketing']?></td>
											<td>
											<button type="button" class="btn btn-default" onclick="location.href='<?php echo "?module=hut_user&act=tambah&id=$id_nasabah";?>';" ><i class="fa fa-eye"></i></button>
											</td>
											<td align="center">
												<input type="checkbox" name="cek[]" value="<?=$id_nasabah?>">
											</td>
										  </tr>
									  <?php
										    
										}else{
									  ?>
										  <tr style="color: red">
											<td><?=$no?></td>
											<td><?=$hasil['referensi']?></td>
											<td><?=$hasil['tgl_transaksi']?></td>
											<td><?=$hasil['coord']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=number_format($sisa_hut)?></td>
											<td><?=$hasil['marketing']?></td>
											<td>
											<button type="button" class="btn btn-default" onclick="location.href='<?php echo "?module=hut_user&act=tambah&id=$id_nasabah";?>';" ><i class="fa fa-eye"></i></button>
											</td>
											<td align="center">
												<input type="checkbox" name="cek[]" value="<?=$id_hutang?>">
											</td>
										  </tr>  
									  <?php
										}
										 $no++; }
									  ?>
									  </tbody>
									</table>
									<center><input type="submit" value="Submit Lunas"></center>
									</form>
									</div>
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<!--<a href="<?=$aksi?>?module=home&act=save_kosong"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>>-->
							</div>
						</div>
						<!-- /.box-footer -->
				</section>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
	
	
					<?php
						}

			break;
		
}
?>
