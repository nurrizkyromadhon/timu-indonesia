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
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Neraca</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
				
				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
					<div class="row">  
					  <div class="col-sm-12 col-lg-12">
						<p class="lead text-muted">Laporan Rugi/Laba dan Neraca</p>
						<div class="tabbable">
						  <ul class="nav nav-tabs">
							<li class="active"><a href="#tab11" data-toggle="tab">RUGI LABA</a></li>
							<li><a href="#tab12" data-toggle="tab">NERACA</a></li>
						  </ul>
						  <div class="tab-content">
							<div class="tab-pane active" id="tab11">
							<div class="box">
							<div class="box-header with-border">
								<h3 class="box-title">PERHITUNGAN RUGI LABA</h3>
							</div>
						<div class="row">
				  			
					  		<div class="col-md-6">
									<table class="table table-bordered table-striped">
										<thead>
											<tr bgcolor="#BFB7B7">
												<th>PERHITUNGAN RUGI LABA</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>2.1 - PENDAPATAN</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '2.1%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa8=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa8=$jmld-$jmlk;
															}
													}
												$totalpend=$totalpend+$sisa8;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa8)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH PENDAPATAN</strong></td>
											  	<td align="right"><strong><?=number_format($totalpend)?></strong></td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>2.2 - BIAYA</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '2.2%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa9=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa9=$jmld-$jmlk;
															}
													}
												$totalby=$totalby+$sisa9;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa9)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH BIAYA</strong></td>
											  	<td align="right"><strong><?=number_format($totalby)?></strong></td>
											</tr>
											<tr>
												<td align="right"><strong>(JUMLAH PENDAPATAN) - (JUMLAH BIAYA)</strong></td>
											  	<td align="right"><strong><?=number_format($totalpend+$totalby)?></strong></td>
											</tr>
											
										</tbody>
										
									</table>
								</div>
					    </div>
							</div>
							</div>
							<div class="tab-pane" id="tab12">
						<div class="box-header with-border">
							<h3 class="box-title">NERACA</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
						
							<div class="row">
								<!-- /.col -->
								<div class="col-md-6">
									<table class="table table-bordered table-striped">
										<thead>
											<tr bgcolor="#BFB7B7">
												<th>AKTIVA</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.1 - AKTIVA LANCAR</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.1%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa1=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa1=$jmld-$jmlk;
															}
													}
												$totalal=$totalal+$sisa1;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa1)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH AKTIVA LANCAR</strong></td>
											  	<td align="right"><strong><?=number_format($totalal)?></strong></td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.2 - AKTIVA TETAP</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.2%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa2=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa2=$jmld-$jmlk;
															}
													}
												$totalat=$totalat+$sisa2;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa2)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH AKTIVA TETAP</strong></td>
											  	<td align="right"><strong><?=number_format($totalat)?></strong></td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.3 - AKUMULASI </h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.3%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa3=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa3=$jmld-$jmlk;
															}
													}
												$totalakum=$totalakum+$sisa3;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa3)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH AKUMULASI</strong></td>
											  	<td align="right"><strong><?=number_format($totalakum)?></strong></td>
											</tr>
										</tbody>
										
									</table>
								</div>
								<!-- /.box-body -->
								<div class="col-md-6">
								  <table class="table table-bordered table-striped">
									  <thead>
											<tr bgcolor="#BFB7B7">
												<th>KEWAJIBAN DAN EKUITAS</th>
												<th></th>
											</tr>
									</thead>
										<tbody>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.5 - HUTANG JANGKA PENDEK</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.5%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa5=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa5=$jmld-$jmlk;
															}
													}
												$totalhutpen=$totalhutpen+$sisa5;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa5)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH HUTANG JANGKA PENDEK</strong></td>
											  	<td align="right"><strong><?=number_format($totalhutpen)?></strong></td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.6 - HUTANG JANGKA PANJANG</h4></td>
											</tr>
											<?php
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.6%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa6=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa6=$jmld-$jmlk;
															}
													}
												$totalhutpan=$totalhutpan+$sisa6;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa6)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH HUTANG JANGKA PANJANG</strong></td>
											  	<td align="right"><strong><?=number_format($totalhutpan)?></strong></td>
											</tr>
											<tr>
												<td colspan="2" bgcolor="#EBBFE9"><h4>1.7 - EKUITAS</h4></td>
											</tr>
											<?PHP
												$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan where kode_perkiraan like '1.7%'  order by kode_perkiraan asc ");
												while ($hasil=mysql_fetch_array($query)){
													
												$id=$hasil['kode_perkiraan'];
												if ($hasil['jml']>='6' ){
													$sisa7=0;
													$jmld=0;
													$jmlk=0;
													$query_jml=mysql_query("select *, j.nominal, j.dk from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$id%'");
													
													while ($hasil_jml=mysql_fetch_array($query_jml)){
														
														$nominal=$hasil_jml['nominal'];
															if($hasil['jml']=='10' ){
																
																if ($hasil_jml['dk']=='D'){
																	$jmld=$jmld+$nominal;
																}
																 
																if ($hasil_jml['dk']=='K'){
																	$jmlk=$jmlk+$nominal;
																}
																	$sisa7=$jmld-$jmlk;
															}
													}
												$totaleku=$totaleku+$sisa7;
											?>
											<tr>
												<td><a href="?module=neraca&act=view&id=<?=$id?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></a></td>
												<td align="right"><?=number_format($sisa7)?></td>
											</tr>
											<?php		
												}
											}
											?>
											<tr>
												<td align="right"><strong>JUMLAH EKUITAS</strong></td>
											  	<td align="right"><strong><?=number_format($totaleku)?></strong></td>
											</tr>
											<tr> 
												<td  bgcolor="#EBBFE9"><h4>2. RUGI / LABA BERJALAN</h4></td>
												<td  align="right" bgcolor="#EBBFE9"><?=number_format($totalpend+$totalby)?></td>
											</tr>
										</tbody>
										
								  </table>
							  </div>
							</div>
							<div class="row">
								<div class="col-md-6">
								<table class="table table-bordered table-striped">
									<tr>
										<td align="right"><strong>TOTAL AKTIVA</strong></td>
										<td align="right"><strong><?=number_format($totalal+$totalat+$totalakum)?></strong></td>
									</tr>
								</table>
								</div>
									
								<div class="col-md-6">
								<table class="table table-bordered table-striped">
									<tr>
										<td align="right"><strong>TOTAL KEWAJIBAN DAN EKUITAS</strong></td>
										<td align="right"><strong><?=number_format($totalhutpen+$totalhutpan+$totaleku+$totalpend+$totalby)?></strong></td>
									</tr>
								</table>
								</div>
							</div>
							<!-- /.box -->
						</div>
							</div>
						  </div>
						</div>
					  </div>				  
					</div>			
					
					

						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href=""><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
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
				case "view":
			
			$kode=$_GET['id'];
			
			$qry=mysql_query("select * from perkiraan where kode_perkiraan='$kode'");
			$hsl=mysql_fetch_array($qry);
			?>
			
				<section class="content-header">
					<h1>HOME</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Neraca</a></li>
						<li class="active">view</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">View <?=$kode?> - <?=$hsl['nm_perkiraan']?></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-10">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=input">
										<div class="box-body">
											<div class="table-responsive">
												<table class="table table-bordered table-striped">
													<thead>
													<tr>
														<th>No</th>
														<th>Tanggal</th>
														<th>Referensi</th>
														<th>Kode Perkiraan</th>
														<th>Keterangan</th>
														<th>Nominal</th>
														<th>D/K</th>
														<th>Saldo</th>
														
													</tr>
													</thead>
													<tbody>
														<?php
															$no=0;
															$query=mysql_query("select * from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where kode_perkiraan like '$kode%'");
															while ($hasil=mysql_fetch_array($query)){
																if ($hasil['dk']=='D'){
																	$saldo=$saldo+$hasil['nominal'];
																}else if ($hasil['dk']=='K'){
																	$saldo=$saldo-$hasil['nominal'];
																}
														?>
												
														<tr>
															<td><?=$no?></td>
															<td><?=$hasil['tgl']?></td>
															<td><?=$hasil['no_ref']?></td>
															<td>
																<?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?>
															</td>
															<td><?=$hasil['ket']?></td>
															<td align="right"><?=number_format($hasil['nominal'])?></td>
															<td><?=$hasil['dk']?></td>
															<td><?=number_format($saldo)?></td>
															
														</tr>
														<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
										<div class="box-footer">
											<!--<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>-->
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
