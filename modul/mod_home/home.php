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
			// Menentukan tanggal awal bulan dan akhir bulan
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw= date('Y-m-d', strtotime("-5 day", strtotime($hari_ini)));
				$tgl_ak= date('Y-m-d', strtotime(" ", strtotime($hari_ini)));
				$tgl_aw2= date('Y-m-01', strtotime($hari_ini. ' '));
				$tgl_ak2= date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
				$tgl_aw_str2=date('01-M-Y',strtotime($tgl_aw2));
				$tgl_ak_str2=date('d-M-Y',strtotime($tgl_ak2));

			}else{
				$tgl_aw=$_POST['tgl_aw'];
				$tgl_ak=$_POST['tgl_ak'];
				$tgl_aw2=$_POST['tgl_aw2'];
				$tgl_ak2=$_POST['tgl_ak2'];
				
				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
				$tgl_aw_str2=date('d-M-Y',strtotime($tgl_aw2));
				$tgl_ak_str2=date('d-M-Y',strtotime($tgl_ak2));
			}
			if (empty($_POST['tgl_aw2'])){				
				$tgl_aw2= date('Y-m-01', strtotime($hari_ini. '-1 month'));
				$tgl_ak2= date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str2=date('01-M-Y',strtotime($tgl_aw2));
				$tgl_ak_str2=date('d-M-Y',strtotime($tgl_ak2));

			}else{				
				$tgl_aw2=$_POST['tgl_aw2'];
				$tgl_ak2=$_POST['tgl_ak2'];
				
				$tgl_aw_str2=date('d-M-Y',strtotime($tgl_aw2));
				$tgl_ak_str2=date('d-M-Y',strtotime($tgl_ak2));
			}
			?>
			<!--<meta http-equiv="refresh" content="10" />-->

			<script type="text/javascript">
				$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
				
				$("#responsecontainer").load("response.php");
						var refreshId = setInterval(function(){
							$("#responsecontainer").load('response.php?randval='+ Math.random());
							}, 1000);
				});
				
					
					$(function () {
						$("#myTable").DataTable();
						$("#myTable1").DataTable();
						$("#myTable2").DataTable();
					});
				
			</script>

				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active"></li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div id="responsecontainer"></div>	

				  	<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><b class="text-blue">Tabel Search Jurnal Operasioanal</b> dari tgl <strong><?=$tgl_aw_str2?></strong> s/d <strong><?=$tgl_ak_str2?></strong></h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-9">
								<form name="submit" action="?module=home" method="POST">
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_aw2">
									</div>
									
									<div class="col-md-2">
										<h4>Sampai : </h4>
									</div>
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_ak2">
									</div>
									
									<div class="col-md-1">
										<button class="btn bg-gray btn-md text-blue" type="submit"><b>OK</b></button>
									
									</div>
								</form>
							</div>
						</div>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-12">
									<table id="myTable" class="table table-responsive table-bordered table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NUMBER</th>
												<th>DATE</th>
												<th>JOB ORDER NUMBER</th>
												<th>STATUS</th>
												<th>CUSTOMER NAME</th>
												<th>PARTY</th>
												<th>NOMOR AJU</th>
												<th>NOMOR BL</th>
												<th>NO KONTAINER</th>																								
												<th>NO SEAL</th>
												<th>NO POLISI</th>												
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											//$query = mysql_query("SELECT * FROM pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc, no_pf desc");
											$query = mysql_query("SELECT * from jurnal_ops as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join detail on rc.id_jurnal_ops=detail.id_jurnal_ops
											WHERE date_ops between '$tgl_aw2' and '$tgl_ak2' and
											no_kontainer !=''									
											order by tgl_detail desc");
											while ($hasil = mysql_fetch_array($query)) { 
												$id_pf = $hasil['id_pf'];
												$id_pf_log = $hasil['id_pf_log'];
												$id_jurnal_ops = $hasil['id_jurnal_ops'];
											?>
											<tr>
												<td><?= $no ?></td>
												<td><?= $hasil['no_pf'] ?></td>
												<td><?= $hasil['tgl_detail']?></td>
												<td><b><?= $hasil['no_jo'] ?></b></td>
												<td><b class="text-blue"><?= $hasil['status_ops'] ?></b></td>
												<td><?= $hasil['cust_name'] ?></td>
												<td>
													<?php 
														$noparty =0;
														$qryparty = mysql_query("SELECT * from pf_qty where id_pf_log = $id_pf_log");
														while ($hasilparty = mysql_fetch_array($qryparty)) {  ?>
															<?= $hasilparty['qty'] ?> X <?= $hasilparty['type1'] ?><br>														
													<?php	}
													?>	
													
												</td>
												<td><?= $hasil['aju_number'] ?></td>
												<td><?= $hasil['bl_number'] ?></td>
												<td><?= $hasil['no_kontainer'] ?></td>																								
												<td><?= $hasil['no_seal'] ?></td>
												<td><?= $hasil['nopol'] ?></td>
												<td>	
													<a class="btn bg-light-blue btn-sm" href="?module=home&act=showdetail&id=<?= $id_pf ?>&id_pf_log=<?= $id_pf_log ?>&id_jurnal_ops=<?= $id_jurnal_ops ?>"><b>DETAIL</b></a>													
												</td>
											</tr>
										<?php $no++;}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					</div>

					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold mt-15">KEGIATAN KEUANGAN</h3>							
						</div>
						<div class="box-header with-border">
							<h3 class="box-title"><b class="text-blue">Tabel Kegiatan Keuangan</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
						</div>
							<div class="box-body">
								<form name="submit" action="?module=jurnal_keu2" method="POST">
									<div class="col-md-3">
										<input class="form-control" type="date" name="tgl_aw">
									</div>
									
									<div class="col-md-1">
										<h4>Sampai : </h4>
									</div>
									<div class="col-md-3">
										<input class="form-control" type="date" name="tgl_ak">
									</div>
									<div class="col-md-1">
										<h4 class="box-title text-blue text-bold mt-15">Tampilan</h4>
									</div>																		
									<div class="col-md-2">
										<select class="form-control" name="categoryJu" required>
											<option value="SEMUA" selected>SEMUA</option>
											<option value="JO">JO</option>
											<option value="NONJO">NON JO</option>
											<option value="ALL">ALL REAL COST</option>
										</select>
									</div>
									<div class="col-md-1">
										<button class="pull-right btn bg-gray text-blue text-bold" type="submit">OK</button>
									</div>
								</form>
							</div>						

						<div class="box-body">
							<div class="row">
								<div class="tabel-responsive">
									<div class="col-md-12">
									<table id="myTable2" class="table table-bordered table-hover">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>NO REFF</th>
												<th>JO NUMBER</th>
												<th>NO INVOICE</th>
												<th>TYPE COST</th>
												<th>KEGIATAN</th>
												<th>STAKEHOLDER</th>
												<th>BUKTI</th>
												<th>VALUE</th>												
												<th>File dan Gambar</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$tampil = $_POST['categoryJu'];
											
											$no_real_cost=1;
											$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
												order by id_pf_real_cost desc");
											
											if ($tampil == 'JO') {
												$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and no_jo !=''
												order by id_pf_real_cost desc");
											}elseif ($tampil == 'ALL') {
												$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice												
												order by id_pf_real_cost desc");
											}else {
												$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
												order by id_pf_real_cost desc");
											}
											if ($tampil == 'NONJO') {
												$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and no_jo =''
												order by id_pf_real_cost desc");
											}
												
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
													$id_pf_real_cost=$hasil4['id_pf_real_cost'];
													$id_est_cost=$hasil4['id_est_cost'];
													$id_revenue=$hasil4['id_revenue'];
													$id_pf_log=$hasil4['id_pf_log'];
													$bl = $hasil4['bl'];
													
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_real_cost']?></td>
												<td><?=$hasil4['no_reff_keu']?></td>
												<td><?=$hasil4['no_jo']?></td>
												<td><?=$hasil4['no_invoice']?></td>
												<td><?=$hasil4['category1']?></td>
												
												<td><?=$hasil4['kegiatan']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td><?=$hasil4['bukti']?></td>
												<td><?=number_format($hasil4['real_cost'])?></td>
												<td>
													<a class="btn bg-gray text-blue btn-sm" onclick="location.href='<?php echo '?module=home&act=tambah_image&id='.$id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
												
												
												
											</tr>
											<?php $no_real_cost++; } ?>	
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				<script>
					if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
					}
				</script>
		<?php		
		break;

		case 'showdetail': 
	$id_pf=$_GET['id'];?>
	<section class="content-header">
		<h1>Detail Jurnal Operasional</h1>
		<ol class="breadcrumb">
				<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="oklogin.php?module=jurnal_operasional">Jurnal Operasional</a></li>				
				<li class="active">Detail Jurnal Operasional</li>
		</ol>
	</section>
	<?php
		$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id] and log_pf='0'");
		$id_pf;
		$hasil;
		$id_data;
		if (mysql_num_rows($queryData)==0) {
			$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil = mysql_fetch_array($query)) or die(mysql_error());
			echo("<script>console.log('TIDAK ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf';
			$id_pf = $hasil['id_pf'];
			$id_pf2 = $hasil['id_pf'];  
		} elseif(mysql_num_rows($queryData)!=0) {
			($hasil = mysql_fetch_array($queryData)) or die(mysql_error());
			echo("<script>console.log('ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf_log';
			$id_pf = $hasil['id_pf_log'];
			$id_data_pf = 'id_pf';
			$idPf = $hasil['id_pf'];
			$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
			$id_pf2 = $hasil2['id_pf'];
			$status2 = $hasil2['status_ops'];
			if($status2 == '0'){
				$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
				$id_pf2 = $hasil2['id_pf'];
			}
		}

	?>
	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border"></div>
			<div class="bg-blue">
				<div class="box-body">
					<div class="col-md-5 nopadding">
						<table style="width:100%" >
							<tr>
								<td>NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['no_pf'] ?></td>		
							</tr>
							<tr>
								<td>DATE</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER NAME</td>	
								<td>:</td>
								<td><?= $hasil['cust_name'] ?></td>		
							</tr>
							<tr>
								<td style="vertical-align:top">ADDRESS</td>	
								<td style="vertical-align:top">:</td>
								<td><?= $hasil['address_pf'] ?></td>		
							</tr>
							<tr>
								<td>SHIPMENT</td>	
								<td>:</td>
								<td><?= $hasil['shipment'] ?></td>		
							</tr>
							<tr>
								<td>COMMODITY</td>
								<td>:</td>
								<td><?= $hasil['commodity'] ?></td>		
							</tr>
							<tr>
								<td>ROUTE</td>	
								<td>:</td>
								<td><?= $hasil['route_pf'] ?></td>		
							</tr>
							<tr>
								<td>CREDIT TERM</td>	
								<td>:</td>
								<td><?= $hasil['ct'] ?> HARI</td>		
							</tr>
							<tr>
								<td>SALES</td>	
								<td width=15>:</td>
								<td><?= $hasil['sales'] ?> </td>		
							</tr>
							<tr>
								<td>SHIPPING/FORWARDING</td>	
								<td>:</td>
								<td><?= $hasil['sf'] ?></td>		
							</tr>
							<tr>
								<td>VESSEL/VOYAGE</td>	
								<td>:</td>
								<td><?= $hasil['vv'] ?></td>		
							</tr>
						</table>
					</div>	
					<div class="col-md-5">
						<table style="width:100%">
							<tr>
								<td>JOB ORDER NUMBER</td>	
								<td width=15>:</td>
								<td><?= $hasil['no_jo'] ?></td>		
							</tr>												
							<tr>
								<td>CUSTOMER REFF</td>	
								<td>:</td>
								<td><?= $hasil['cust_ref'] ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER CODE</td>	
								<td>:</td>
								<td><?= $hasil['cust_code'] ?></td>		
							</tr>
							<tr>
								<td>PIC</td>	
								<td>:</td>
								<td><?= $hasil['pic'] ?></td>		
							</tr>
							<tr>
								<td>PHONE</td>	
								<td>:</td>
								<td><?= $hasil['phone'] ?></td>		
							</tr>
							<tr>
								<td>ETB/ETD</td>	
								<td>:</td>
								<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
							</tr>				
							<tr>
								<td>OPEN STACK</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['openstack'])) ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME CONTAINER</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctc']))  ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME DOCUMENT</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>		
							</tr>
							<tr>
								<td>B/L NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['bl_number'] ?> </td>		
							</tr>
							<tr>
								<td>AJU NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['aju_number'] ?> </td>		
							</tr>
						</table>				
					</div>
					<div class="col-md-2">
						<table>
							<tr>
								<td>								
								</td>
							</tr>
							<tr>
								<td align="center">
									<?php
										if($hasil['aprove']=="batal"){
									?>
										<img src="images/aproved/batal.png" width="150" height="150">

									<?php } elseif ($hasil['aprove']=="0"){ ?>

										<h2>PROFORMA</h2>
									<?php	
									}elseif ($hasil['aprove']==42){
									?>	
										<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif ($hasil['aprove']=="1"){
									?>    
									<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif($hasil['aprove']=="BILL"){
									?>
										<h2>BILL</h2>
									<?php	
									}else{
									?>
										<h2><?=$hasil['aprove']?></h2>
									<?php
									}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="bg-default">
				<div class="box-body">
					<div class="row mb-3">
						<div class="col-sm-6">
							<h5><a><strong>PARTY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>QTY</th>
								</tr>
								<?php
									$numQtyData=1;
									$query3 = mysql_query("SELECT * from pf_qty where $id_data=$id_pf");
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numQtyData?></td>
											<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
										</tr>
									<?php
									$numQtyData++;
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>DATE</th>
									<th>QTY</th>
									<th>FROM/TO</th>
								</tr>
								<?php
									$numPudelData=1;
									$query3 = mysql_query("SELECT * from pf_pudel where $id_data=$id_pf");
									while ($hasilPudel = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numPudelData?></td>
											<td><?=$hasilPudel['pudel_date']?></td>
											<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
											<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
										</tr>
									<?php
									$numPudelData ++;
									}
								?>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>REQUEST</th>
								</tr>
								<?php
									$no_sor=1;
									$query1 = mysql_query("select * from pf_sor where $id_data=$id_pf");
									while ($hasil1=mysql_fetch_array($query1)){
										$id_pf_sor=$hasil1['id_pf_sor'];
									?>
										<tr>
											<td><?=$no_sor?></td>
											<td><?=$hasil1['desc_sor']?></td>
										</tr>
									<?php 
									$no_sor++; 
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>REAL CUSTOMER</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>NAME</th>
								</tr>
								<?php
									$no_ru=1;
										$query1 = mysql_query("select * from real_user where $id_data=$id_pf");
										while ($hasil1=mysql_fetch_array($query1)){
											$id_real_user=$hasil1['id_real_user'];
									?>
									<tr>
										<td><?=$no_ru?></td>
										<td><?=$hasil1['name_real_user']?></td>
									</tr>
								<?php 
									$no_ru++;
									}
								?>
							</table>
						</div>
					</div>

					<!--- JURNAL OPS --->
					<div class="table-order mt-2">
															<h5><a><strong>TABLE LAPORAN JURNAL OPERASIONAL</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>DATE</th>
																	<th>TYPE</th>
																	<th>TYPE ALL IN RATE</th>
																	<th>STATUS OPERASIONAL</th>
																	<th>DESCRIPTION</th>
																	<th>QUANTITY</th>																	
																	<th>DETAIL KONTAINER</th>
																</tr>
															
																<?php
																$no_ops=1;	
																$no_detail=1;
																$queryOps = mysql_query("SELECT * from jurnal_ops where id_pf_log=$id_pf");
																while ($hasilOps = mysql_fetch_array($queryOps)) { 	
																	$id_jurnal_ops=$hasilOps['id_jurnal_ops'];
																?>	
																<tr>					
																	<td><?=$no_ops?></td>
																	<td><?=$hasilOps['date_ops']?></td>
																	<td><?=$hasilOps['type_ops']?></td>
																	<td><?=$hasilOps['type2_ops']?></td>
																	<td><?=$hasilOps['status_ops']?></td>
																	<td><?=$hasilOps['desc_ops']?></td>
																	<td><?=$hasilOps['qty']?> X <?=$hasilOps['qty_type1']?> <?=$hasilOps['qty_type2']?></td>																
																	<td>
																	<?php
																		$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
																		$hasildetail = mysql_fetch_array($queryDetail);
																		$id_detail= $hasildetail['id_detail'];
																	?>
																		<a class="btn btn-info btn-sm" href="?module=home&act=detail_jurnal&id=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&type_ops=<?=$hasilOps['type_ops']?>" ><span class="fa fa-info"></i></a>																		
																	</td>	
																</tr>

																<?php
																	$no_ops++; 
																}?>	
															</table>
														</div>

						

				</div>
			</div>
		</div>		
	</section>
<?php break;
	case 'detail_jurnal': 
			$id_pf = $_GET['id'];
			$id_pf_log = $_GET['id_log'];
			$id_jurnal_ops = $_GET['ops_id'];
			$type_rev=$_GET['type_ops'];
			?>
			<?php
				$query = mysql_query("SELECT * FROM jurnal_ops where id_jurnal_ops=$id_jurnal_ops");
				$hasil = mysql_fetch_array($query);
				$type_ops = $hasil['type_ops'];
				$type_ops2 = $hasil['type2_ops'];
				$queryLog = mysql_query("SELECT * FROM pf_log where id_pf=$id_pf");
				$hasilLog = mysql_fetch_array($queryLog);
				$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
				$hasilD = mysql_fetch_array($queryDetail);
				$id_pf_log = $hasilLog['id_pf_log'];
			?>	
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Document</title>
			</head>
			<body>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
						<li class="active">Detail Jurnal Operasional</li>
					</ol>
				</section>
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Detail Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						
						<div class="box-body">							
							<div class="row mt-2">
								<div class="col-md-12">
									<?php if ($type_ops=='TRANSPORTATION CHARGES' or $type_ops=='ALL IN RATE' or $type_ops=='') { ?>
									<h5><a><label>DETAIL KONTAINER</label></a></h5>
									<div class="table-responsive">
										<table id="myTable3" class="table table-bordered table-responsive table-hover">
											<thead>
												<tr class="info">
													<th>NO</th>
													<th>DATE</th>
													<th>NOMOR KONTAINER</th>
													<th>NOMOR SEAL</th>
													<th>NOPOL</th>
													<th>DRIVER </th>
													<th>CONTACT</th>
													<th>STAKEHOLDER</th>													
												</tr>
											</thead>
											<tbody>
												<?php
													$no=1;
													$querydetail=mysql_query("SELECT * from detail where id_jurnal_ops=$id_jurnal_ops");
													while ($hasildetail=mysql_fetch_array($querydetail)){
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasildetail['tgl_detail']?></td>
													<td><?=$hasildetail['no_kontainer']?></td>
													<td><?=$hasildetail['no_seal']?></td>
													<td><?=$hasildetail['nopol']?></td>
													<td><?=$hasildetail['nm_driver']?></td>
													<td><?=$hasildetail['hp_driver']?></td>
													<td><?=$hasildetail['stakeholder']?></td>
													
												</tr>
												<?php $no++; } ?>
											</tbody>
											
										</table>
									</div>
									<?php
										}
									?>
									<a><label>FILE DAN GAMBAR</label></a>
									<form name="submit1" action="<?=$aksi?>" method="GET">
									<div class="row box-body">
										<input type="hidden" name="module" value="jurnal_operasional">
										<input type="hidden" name="act" value="hapus_gambar">
										<input type="hidden" name="id_pf" value="<?=$id_pf?>">
										<input type="hidden" name="type_ops" value="<?=$type_ops?>">
										<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
										<input type="hidden" name="id_pf_operasional" value="<?=$id_jurnal_ops?>">
										<?php
											$query=mysql_query("SELECT * from images_db where id_jurnal_ops=$id_jurnal_ops");
											while ($hasil=mysql_fetch_array($query)){
												$id_images_db=$hasil['id_images_db'];
											?>	
											<div class="kotak col-md-3 checkbox-wrapper">	
												<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	
												<!--<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/> -->
												<a href="images/data_op/<?=$hasil['nm_file']?>" target="_blank">
													<?=$hasil['nm_file']?>
												</a>												
											</div>  
										<?php } ?>   
									</div>
									<div class="box-tools pull-right">
									<!--<button type="submit2" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar&id=<?=$id_images_db?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&gambar<?=$hasil['nm_file']?>"><span class="fa fa-trash"></a>-->
									</div>
									</form>
									
								</div>
							</div>
						</div>
					</div>			
				</section>			
			</body>
			</html>
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

$id_jurnal = $_GET['id'];
if (empty($id_jurnal)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from jurnal where id_jurnal='$id_jurnal'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>Edit Data</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Edit Data</a></li>
			<li class="active">Form Edit Data</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit Data</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=home&act=edit">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Tanggal</label>
								  <div class="col-sm-6">
								  	<input type="hidden" class="form-control" name="id_jurnal"  value='<?php echo $update['id_jurnal'];?>'>
									<input type="text" class="form-control" name="tgl"  value="<?php echo $update['tgl'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Referensi</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="no_ref"  value='<?php echo $update['no_ref'];?>'>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Keterangan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="ket"  value="<?php echo $update['ket'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Nominal</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="nominal"  value="<?php echo $update['nominal'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Debet/Kredit</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="dk" value="<?php echo $update['dk'];?>">
									<a style="color: red">** inputka D atau K Saja **</a>
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
	
	case "list_proforma":
	?>
    <section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel cancel Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU NUmber</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='0' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
<?php
	break;
	
	case "detail":
?>
                <section class="content-header">
					<h1>DETAIL MJO</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. MJO</li>
						<li class="active">DETAIL MJO</li>
					</ol>
				</section>
				<?php
				$id_pf = $_GET['id']; 
				$no = 1;
				$queryd = mysql_query("SELECT * FROM pf where id_pf=$id_pf");
				$hasild = mysql_fetch_array($queryd);
					
				?>	
				<!-- Main content -->
				<section class="content">
					
				  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<!--<button type="button" class="btn btn-default btn-sm" onclick="location.href='<?php echo '?module=aproval&act=tambah'; ?>';" ><i class="fa fa-plus"></i></button>
						<h3 class="box-title"> - Tambah Proforma</h3>-->
					</div>
						<!-- /.box-header -->
			
					<div class="bg-primary">
						<div class="box-body">
							
						<div class="col-md-5">
							<table style="width:100%" >
								<tr>
									<td>NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['no_pf'] ?></td>		
								</tr>
								<tr>
									<td>DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['tgl_pf'])) ?></td>		
								</tr>
								<tr>
									<td>CUSTOMER NAME</td>	
									<td>:</td>
									<td><?= $hasild['cust_name'] ?></td>		
								</tr>
								<tr>
									<td style="vertical-align:top">ADDRESS</td>	
									<td style="vertical-align:top">:</td>
									<td><?= $hasild['address_pf'] ?></td>		
								</tr>
								<tr>
									<td>SHIPMENT</td>	
									<td>:</td>
									<td><?= $hasild['shipment'] ?></td>		
								</tr>
								<tr>
									<td>QUANTITY</td>	
									<td>:</td>
									<td><?= $hasild['qty_pf'] ?> - <?=$hasild['type_qty']?></td>		
								</tr>
								<tr>
									<td>ROUTE</td>	
									<td>:</td>
									<td><?= $hasild['route_pf'] ?></td>		
								</tr>
								<tr>
									<td>PU/DEL DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['pudel_date']))  ?> </td>		
								</tr>
								<tr>
									<td>PU/DEL LOCAtION</td>	
									<td>:</td>
									<td><?= $hasild['pudel_location'] ?> </td>		
								</tr>
								<tr>
									<td>CREDIT TERM</td>	
									<td>:</td>
									<td><?= $hasild['ct'] ?> HARI</td>		
								</tr>
								<tr>
									<td>SALES</td>	
									<td width=15>:</td>
									<td><?= $hasild['sales'] ?> </td>		
								</tr>
								<tr>
									<td style="vertical-align:top" width=35%>SPECIAL ORDER REQUES - 
										
									</td>

									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
										?>
											<?=$no_sor?>. <?=$hasil1['desc_sor']?><br>

										<?php $no_sor++; } ?>
									</td>
								</tr>
							</table>
						</div>	
						<div class="col-md-5">
							<table style="width:100%">
								<tr>
									<td>JOB ORDER NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['no_jo'] ?></td>		
								</tr>												
								<tr>
									<td>CUSTOMER REFF</td>	
									<td>:</td>
									<td><?= $hasild['cust_ref'] ?></td>		
								</tr>
								<tr>
									<td>CUSTOMER CODE</td>	
									<td>:</td>
									<td><?= $hasild['cust_code'] ?></td>		
								</tr>
								<tr>
									<td>PIC</td>	
									<td>:</td>
									<td><?= $hasild['pic'] ?></td>		
								</tr>
								<tr>
									<td>PHONE</td>	
									<td>:</td>
									<td><?= $hasild['phone'] ?></td>		
								</tr>
								<tr>
									<td>SHIPPING/FORWARDING</td>	
									<td>:</td>
									<td><?= $hasild['sf'] ?></td>		
								</tr>
								<tr>
									<td>VESSEL/VOYAGE</td>	
									<td>:</td>
									<td><?= $hasild['vv'] ?></td>		
								</tr>
								<tr>
									<td>ETB/ETD</td>	
									<td>:</td>
									<td><?=date("d M y ", strtotime($hasild['etb'])) ?>/<?=date("d M y", strtotime($hasild['etd'])) ?></td>		
								</tr>
								<?php
									if($hasild['shipment']!="EMKL IMPORT"){
								?>					
								<tr>
									<td>OPEN STACK</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['openstack'])) ?> </td>		
								</tr>
								<tr>
									<td>CLOSING TIME CONTAINER</td>	
									<td>:</td>
									<td><?=date("d M y h:i:s", strtotime($hasild['ctc']))  ?> </td>		
								</tr>
								<tr>
									<td>CLOSING TIME DOCUMENT</td>	
									<td>:</td>
									<td><?=date("d M y h:i:s", strtotime($hasild['ctd'])) ?> </td>		
								</tr>
									<?php }?> 
									<?php 
									if($hasild['shipment']!="EMKL IMPORT"){ ?>
								<tr>
									<td>B/L NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['bl_number'] ?> </td>		
								</tr>
								<tr>
									<td>AJU NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['aju_number'] ?> </td>		
								</tr>
									<?php } ?>
									<tr>
									<td style="vertical-align:top">REAL CUSTOMER - 
											
									</td>
									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_ru=1;
											$query1 = mysql_query("select * from real_user where id_pf=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_real_user=$hasil1['id_real_user'];
										?>
											<?=$no_ru?>. <?=$hasil1['name_real_user']?>
										<?php $no_ru++; } ?>
									</td>
								</tr>		
							</table>				
						</div>

						<div class="col-md-2">
							<table>
								<tr>
									<td>
								
									</td>
								</tr>
								<tr>
									<td align="center">
										<?php
											if($hasild['aprove']=="batal"){
										?>
											<img src="images/aproved/batal.png" width="150" height="150">

										<?php } elseif ($hasild['aprove']=="0"){ ?>

											<h2>PROFORMA</h2>
										<?php	
										}elseif ($hasild['aprove']=="42"){
										?>	
											<img src="images/aproved/aproved.png" width="150" height="150">
										<?php	
										}elseif($hasild['aprove']=="BILL"){
										?>
											<h2>BILL</h2>
										<?php	
										}else{
										?>
											<h2>PAID</h2>
										<?php
										}
										?>
									</td>
								</tr>
							</table>
						</div>
					
						</div>				
					</div>
						
					<!--<div class="bg-default">
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									
									<?php
										$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf");
										$hasil_type1=mysql_fetch_array($type1);
										$type_revenue=$hasil_type1['type_revenue'];
									?>
									<bold><?=$type_revenue?> </bold> </p>
									<a>
										<bold>TABLE REVENUE</bold>
									</a>
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>REVENUE</th>
											<th>QTY</th>
											<th>SUM</th>
										</tr>
									
										<?php
										$no_job=1;	
										$sum_revenue=0;		
										$total_revenue=0;				
										$query2 = mysql_query("select * from pf_revenue where id_pf=$id_pf order by id_pf_revenue asc");
										while ($hasil2 = mysql_fetch_array($query2)) { 	
											$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
											$id_pf_revenue=$hasil2['id_pf_revenue'];
										?>	
										<tr>					
											<td><?=$no_job?></td>
											<td><?=$hasil2['type2_revenue']?></td>
											<td><?=$hasil2['desc_revenue']?></td>
											<td><?=number_format($hasil2['revenue'])?></td>
											<td><?=$hasil2['qty_revenue']?></td>
											<td><?=number_format($sum_revenue)?></td>
											
										</tr>

										<?php
											$total_revenue=$total_revenue+$sum_revenue;
											$no_job++; 
										}?>	
									</table>
								</div>	

								<div class="col-md-6">
									<bold>-</bold></p>
									<a>
										<bold>TABLE EST COST</bold> 
									</a>
									
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>EST COST</th>
											<th>QTY</th>
											<th>SUM</th>
										</tr>
										<?php
										$no_job2=1;	
										$sum_est_cost=0;
										$total_est_cost=0;						
										$query3 = mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost asc");
										while ($hasil3 = mysql_fetch_array($query3)) { 
											$sum_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost']; 
											$id_pf_est_cost=$hasil3['id_pf_est_cost'];
										?>
										<tr>				
											<td><?=$no_job2?></td>
											<td><?=$hasil3['type_est_cost']?></td>
											<td><?=$hasil3['desc_est_cost']?></td>
											<td><?=number_format($hasil3['est_cost'])?></td>
											<td><?=$hasil3['qty_est_cost']?></td>
											<td><?=number_format($sum_est_cost)?></td>
											
										</tr>	
										<?php
											$total_est_cost=$total_est_cost+$sum_est_cost ; 					
											$no_job2++; 
										}?>	
									</table>	
								</div>	

							</div>
							<div class="row">
								<div class="col-md-6">
									<label>ESTIMASI PROFIT AND LOST</label>	
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>ITEM</th>
											<th>TOTAL</th>
										</tr>
										<tr>
											<td>1</td>
											<td>TOTAL REVENUE</td>
											<td><?=number_format($total_revenue)?></td>
										</tr>
										<tr>
											<td>2</td>
											<td>TOTAL EST COST</td>
											<td><?=number_format($total_est_cost)?></td>
										</tr>
										<tr>
											<td></td>
											<td>PROFIT AND LOST</td>
											<td><?=number_format($total_revenue-$total_est_cost)?></td>
										</tr>

									</table>
								</div>		
							</div>
						</div>
					</div>-->
      			</div>
				</section> 	
				
				<section class="content">
					<div class="box box-default">
						<div class="box-header">
							<h3 class="box-title">TABEL JURNAL OPERASIONAL</h3>
						</div>
						<div class="box-body">
						
							
							<div class="col-sm-12">
							<!-- /.col -->
							<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>STATUS</th>
												<th>TYPE</th>
												<th>DESCRIPTION 1</th>
												<th>DESCRIPTION 2</th>
												<th>STAKE HOLDER</th>
												<th>IMAGES</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("select * from pf_operasional as pfo 
												join pf on pfo.id_pf = pf.id_pf
												where pfo.id_pf=$id_pf
												order by id_pf_operasional desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
												$id_pf_operasional=$hasil4['id_pf_operasional'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_operasional']?></td>
												<td><?=$hasil4['no_jo']?></td>
												<td><?=$hasil4['status_pf_operasional']?></td>
												<td><?=$hasil4['desc1']?></td>
												<td><?=$hasil4['desc2']?></td>
												<td><?=$hasil4['desc3']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td>
													<a class="btn btn-primary" onclick="location.href='<?php echo '?module=home&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
											<?php $no_real_cost++; } ?>	
											</tr>
										</tbody>
									</table>
							</div>
						</div>	
							<div class="col-sm-6">
								<div class="tabel-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>KEGIATAN</th>
												<th>KATEGORY</th>
												<th>DESCRIPTION</th>
												<th></th>
												<th>STAKEHOLDER</th>
												<th>VALUE</th>
												<th>STATUS INV</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query5=die("select * from pf_real_cost as rc
												join pf on rc.id_pf=pf.id_pf 
												join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												where rc.id_pf=$id_pf
												order by id_pf_real_cost desc");
												while($hasil5=mysql_fetch_array($query5) or die(mysql_error())){
													$id_pf_real_cost=$hasil5['id_pf_real_cost'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil5['tgl_pf_real_cost']?></td>
												<td><?=$hasil5['no_jo']?></td>
												<td><?=$hasil5['kegiatan']?></td>
												<td><?=$hasil5['category1']?></td>
												<td><?=$hasil5['type_est_cost']?></td>
												<td><?=$hasil5['desc_est_cost']?></td>
												<td><?=$hasil5['stakeholder']?></td>
												<td><?=number_format($hasil5['real_cost'])?></td>
												<td><?=$hasil5['status_keu']?></td>
												
												<td>
													<a class="btn btn-primary" onclick="location.href='<?php echo '?module=home&act=tambah_image&id='.$id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
											</tr>
											<?php $no_real_cost++; } ?>	
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>

				
<?php
	break;
	case 'tambah_image':
				$id_pf_real_cost=$_GET['id'];
				$query=mysql_query("select * from pf_real_cost as prc
				join users on prc.user_pf_real_cost=users.id_users
				left join pf on prc.id_pf=pf.id_pf
				where id_pf_real_cost=$id_pf_real_cost");
				$hasil=mysql_fetch_array($query);
				$id_pf=$hasil['id_pf'];
				$id_pf_real_cost=$hasil['id_pf_real_cost'];
				$id_est_cost=$hasil['id_est_cost'];
				$id_revenue=$hasil['id_revenue'];
				
			?>
			<section class="content-header">
				<h1>JURNAL KEUANGAN</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2&act=jurnal&id=<?=$id_pf?>">Form Jurnal Keuangan</a></li>
					<li class="active">Form Tambah Images</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Galery Images</h3>
						<!-- Modal -->
						
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">	
								<!-- form start -->
							<form name="submit2" action="<?=$aksi?>?module=jurnal_keu2&act=hapus_gambar" method="POST">	
								<div class="box-body">
									<h4>NOMOR REFERENSI : <?=$hasil['no_reff_keu']?></h4>
									<h4>JOB ORDER NUMBER : <?=$hasil['no_jo']?></h4>
									<h4>DESCRIPTION : <?=$hasil['kegiatan']?></h4>
										<style>
										.kotak {
											border: 4px solid #575D63;
											margin: 10px;
											padding: 5px;
											width: 250px;
										}
										.img{
											width: 250px;
										}
										</style>
									<?php
									$id_pf_real_cost=$hasil['id_pf_real_cost'];
									$query=mysql_query("select * from images_db where id_pf_real_cost='$id_pf_real_cost' and id_pf='$id_pf'");
									while ($hasil=mysql_fetch_array($query)){
										$id_images_db=$hasil['id_images_db'];
										
									?>	
									<div class="kotak col-md-3 checkbox-wrapper">	
										<input type="hidden" name="id_pf_real_cost" value="<?=$hasil['id_pf_real_cost']?>">
										<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/>
										<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>">	<br> <a href="images/data_op/<?=$hasil['nm_file']?>" target='blank'> <?=$hasil['nm_file']?> </a>
									</div>  
								<?php } ?>   
								</div>	
								
								<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
								<script type="text/javascript">
									$(function() {
									$('.check_all').click(function() {
										$('.chk_boxes1').prop('checked', this.checked);
									});
									});
								</script>
							</form>	
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php 
		break;
	case "list_aprove":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel Aprove Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU Number</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='42' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	  	
<?php
	break;
	case "list_cancel":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel cancel Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU NUmber</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='batal' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
<?php
	break;
	case "list_total":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel total Proforma</label>
			</div>
			<div class="box box-body">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>NO</th>
							<th>DATE</th>
							<th>PROFORMA NUMBER</th>
							<th>JO NUMBER</th>
							<th>B/L NUMBER</th>
							<th>AJU NUMBERr</th>
							<th>CUSTOMER NAME</th>
							<!--<th>Status</th>-->
							<th>STATUS</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf order by tgl_pf");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<!--<td><?=$hasil['aprove']?></td>-->
							<td>
							<?php
								$query5=mysql_query("select status_pf_operasional from pf_operasional where id_pf=$hasil[id_pf] and id_pf_operasional!='' order by id_pf_operasional desc limit 1 ");
								$hasil5=mysql_fetch_array($query5);
								echo $hasil5['status_pf_operasional'];
							?>
							</td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
	<?php
	break;
	}
}
?>
