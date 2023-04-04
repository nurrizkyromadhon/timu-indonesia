<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_hut_user/aksi_hut_user.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Hutang User</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">REKAP LAPORAN HUTANG</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Rekap LaporanHutang User</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <form name="submit" action="<?=$aksi?>?module=hut_user&act=lunas" method="post" >
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
										
										where h.status!='batal'and h.status!='lunas' and aproval='OK'
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
											$tgl3=date('Y-m-d', strtotime('+7 days', strtotime($tgl1)));
											
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
												<input type="checkbox" name="cek[]" value="<?=$id_hutang?>">
											</td>
										  </tr>
									  <?php   
										}else{
									  ?>
										  <tr style="color: red">
											<td class="blink"><?=$no?></td>
											<td class="blink"><?=$hasil['referensi']?></td>
											<td class="blink"><?=$hasil['tgl_transaksi']?></td>
											<td class="blink"><?=$hasil['coord']?></td>
											<td class="blink"><?=$hasil['nama_user']?></td>
											<td class="blink"><?=number_format($sisa_hut)?></td>
											<td class="blink"><?=$hasil['marketing']?></td>
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
								
								<!--<a href="<?=$aksi?>?module=hut_user&act=save_rekap"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>-->
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->	
					
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">HUTANG USER</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Data Hutang User</h2>
										</div>
										<div class="row">
									  <div class="table-responsive">
									  <table id="myTable" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>Referensi</th>
										  <th>TANGGAL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>KETERANGAN</th>
										  <th>HUTANG USER</th>
										  <th>BAYAR</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *, h.ket as keterangan from hut_user as h
										join nasabah as n on h.id_nasabah=n.id_nasabah
										join profil_buyer as pb on h.id_buyer=pb.id_buyer 
										order by tgl_transaksi desc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['referensi']?></td>
											<td><?=$hasil['tgl_transaksi']?></td>
											<td><?=$hasil['coord']?></td>
											<td><?=$hasil['nm_buyer']?></td>
											<td><?=$hasil['keterangan']?></td>
											<td><?=number_format($hasil['hutang'])?></td>
											<td><?=number_format($hasil['terbayar'])?></td>

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
								
								<a href="<?=$aksi?>?module=hut_user&act=save_rekap"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->					
					
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Kavling</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="container">
										<div class="row">
											<h2>Laporan Semua Kavling</h2>
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
								
								<a href="<?=$aksi?>?module=home&act=save_all"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
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
					<h1>Pembayaran Angsuran</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Pembayaran Angsuran</a></li>
						<li class="active">Form input Pembayaran</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Input Pembayaran</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-8">	
									<?php
										$no=1;
										$query="select *,h.ket as keterangan, h.status from hut_user as h
										join nasabah as n on h.id_nasabah=n.id_nasabah
										join profil_buyer as pb on h.id_buyer=pb.id_buyer
										where h.id_nasabah ='$_GET[id]' and h.status!='batal'
										order by nama_user asc";
										$qry=mysql_query($query) or die(mysql_error());
										$header=mysql_fetch_array($qry);
									
									?>
								  	  <table id="myTable1" class="table">
								  	  	<tr>
								  	  		<td>Harga Netto :</td>
								  	  		<td><?=number_format($header['harga_jual'])?></td>
								  	  	</tr>
								  	  	<tr>
								  	  		<td>KPR ( <?=$header['bank']?> ) :</td>
								  	  		<td><?=number_format($header['kpr'])?></td>
								  	  	</tr>
								  	  	<tr>
								  	  		<td>Uang Muka</td>
								  	  		<td><?=number_format($header['um'])?></td>
								  	  	</tr>
								  	  </table>
									  <div class="table-responsive">
									  <table id="myTable" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>Referensi</th>
										  <th>TANGGAL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>KETERANGAN</th>
										  <th>HUTANG USER</th>
										  <th>BAYAR</th>
										  <th>SISA</th>
										  <!--<th>AKSI</th>-->
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *,h.ket as keterangan, h.status from hut_user as h
										join nasabah as n on h.id_nasabah=n.id_nasabah
										join profil_buyer as pb on h.id_buyer=pb.id_buyer
										where h.id_nasabah ='$_GET[id]' and h.status!='batal'
										order by nama_user asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											
											if ($hasil[hutang]==0) { 
												$saldo=$saldo+$hasil[hutang]-$hasil[terbayar] ;				 
											} else {
												$saldo=$saldo+$hasil[hutang];
											}
											
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['referensi']?></td>
											<td><?=$hasil['tgl_transaksi']?></td>
											<td><?=$hasil['coord']?></td>
											<td><?=$hasil['nm_buyer']?></td>
											<td><?=$hasil['keterangan']?></td>
											<td><?=number_format($hasil['hutang'])?></td>
											<td><?=number_format($hasil['terbayar'])?></td>
											<td><?=number_format($saldo)?></td>
											<td>
											<?php
										    	if ($no==1){
											?>
												<button type="button" class="btn btn-default" onclick="location.href='<?php echo "?module=hut_user&act=update&id=$hasil[id_hutang]";?>';" ><i class="fa fa-edit"></i></button>
												<?php } ?>
											</td>
										  </tr>
									  <?php
										$no++; }
									  ?>
									  </tbody>
									</table>
									</div>								
								</div>
								<div class="col-md-4">	
								<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=hut_user&act=input">
										<div class="box-body">
										<H3 align="center">Update User :</H3>
												<div class="box-body">
													<div class="form-group">
														<label class="col-sm-4 control-label">Tgl Bayar :</label>
														<div class="col-sm-5">
															<input class="form-control" type="date" name="tgl_transaksi" value="<?=date('Y-m-d')?>" />
														</div>
													</div>											
													<div class="form-group">
														<label class="col-sm-4 control-label">Blok Kavling :</label>
														<div class="col-sm-5">
														<script type="text/javascript" >
														$(document).ready(function(){
															$('#koma').maskMoney({precision:0});
														});
														</script>
															<?php
																$qry0=mysql_query("Select * from nasabah as n 
																where id_nasabah='$_GET[id]';");
																$hasil0=mysql_fetch_array($qry0); 
																?>
														  <input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>" >	
														  <input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-4 control-label">Jenis Type :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="tipe" value="<?=$hasil0['type_rumah']?>" readonly/>
														</div>
													</div>		
													<div class="form-group">
														<label class="col-sm-4 control-label">Nama User :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="tipe" value="<?=$hasil0['nama_user']?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-4 control-label">Referensi :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="referensi" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-4 control-label">Nominal :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="bayar" id="koma" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-4 control-label">Angsuran Ke :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="angsuran_ke" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-4 control-label">Cara Pembayaran :</label>
														<div class="col-sm-5">
															<select class="form-control" name="cara_bayar">
																<option value=""> - Cara Bayar - </option>
																<option value="Cash">Cash</option>
																<option value="Transfer Bank">Transfer Bank</option>
															</select>
														</div>
														<?php
															$query1=mysql_query("select * from profil_buyer where nm_buyer ='$hasil0[nama_user]'");	
															$hasil1=mysql_fetch_array($query1);
														?>
														<input type="hidden" name="id_buyer" value="<?=$hasil1['id_buyer']?>">
													</div>		
													<div class="form-group">
														<label class="col-sm-4 control-label">Keterangan :</label>
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
				</section>
				<script>
				  $(function () {
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
		
		case "update":
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>Edit Hutang Uang Muka </h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Hutang Uang Muka</a></li>
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
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=hut_user&act=update">
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-4 control-label">Edit Hutang Uang Muka :</label>
												<div class="col-sm-5">
													<input class="form-control" type="hidden" name="id_hutang" value="<?=$_GET['id']?>" />
													<?php
														$query=mysql_query("select * from hut_user where id_hutang='$_GET[id]'");
														$hasil=mysql_fetch_array($query);
													?>
													<input type="text" name="hutang" value="<?=$hasil[hutang]?>">
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
