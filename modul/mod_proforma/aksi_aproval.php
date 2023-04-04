<?php
	session_start();
	function create_initial_log() {
		// Check if initial log exist for aproved proforma
		$hari_ini = date("Y-m-d H:i:s");
		$proformaLog = mysql_query("SELECT * from pf_log where id_pf=$_GET[id]");
		$countProformaLog = mysql_num_rows($proformaLog);

		if ($countProformaLog == 0) {					
			$queryProforma = mysql_query("SELECT * from pf where id_pf=$_GET[id]");
			$proformaId=mysql_fetch_array($queryProforma);

			$queryResultProforma = "INSERT INTO pf_log (id_pf, user_pf, no_pf, no_jo, tgl_pf, cust_name,address_pf, cust_ref, cust_code, pic, phone, shipment, commodity, route_pf, sales, ct, sf, vv, etb, etd, openstack, ctc, ctd, bl_number, log_pf, status_ops, aprove, tgl_aprove)
			VALUES('$proformaId[id_pf]', '$_SESSION[namalengkap]','$proformaId[no_pf]','$proformaId[no_jo]','$proformaId[tgl_pf]','$proformaId[cust_name]','$proformaId[address_pf]','$proformaId[cust_ref]','$proformaId[cust_code]','$proformaId[pic]','$proformaId[phone]','$proformaId[shipment]','$proformaId[commodity]','$proformaId[route_pf]','$proformaId[sales]','$proformaId[ct]','$proformaId[sf]','$proformaId[vv]','$proformaId[etb]','$proformaId[etd]','$proformaId[openstack]','$proformaId[ctc]','$proformaId[ctd]','$proformaId[bl_number]','$countProformaLog','$proformaId[status_ops]','$proformaId[aprove]', '$proformaId[tgl_aprove]')";
			
			$sqlResultProforma = mysql_query ($queryResultProforma) or die (mysql_error());
			$last_id = mysql_insert_id();

			$queryQty = mysql_query("SELECT * from pf_qty where id_pf=$_GET[id]");
			while($hasilQty = mysql_fetch_array($queryQty)) {
				$queryResultQty="INSERT INTO pf_qty (id_pf_log, qty, type1, type2) VALUES ('$last_id','$hasilQty[qty]','$hasilQty[type1]','$hasilQty[type2]')";
				$sqlResultQty= mysql_query ($queryResultQty) or die (mysql_error());
			}

			$queryPudel = mysql_query("SELECT * from pf_pudel where id_pf=$_GET[id]");
			while($hasilPudel = mysql_fetch_array($queryPudel)) {
				$queryResultPudel="INSERT INTO pf_pudel (id_pf_log, pudel_date, qty, type1, type2, pudel_from, pudel_to) VALUES ('$last_id','$hasilPudel[pudel_date]','$hasilPudel[qty]','$hasilPudel[type1]','$hasilPudel[type2]','$hasilPudel[pudel_from]','$hasilPudel[pudel_to]')";
				$sqlResultPudel= mysql_query ($queryResultPudel) or die (mysql_error());
			}

			$queryRu = mysql_query("SELECT * from real_user where id_pf=$_GET[id]");
			while($hasilRu = mysql_fetch_array($queryRu)) {
				$queryResultRu="INSERT INTO real_user (id_pf_log, name_real_user,pic, address_real_user,reff_cust, code_cust, phone_real_user) VALUES ('$last_id','$hasilRu[name_real_user]','$hasilRu[pic]','$hasilRu[address_real_user]','$hasilRu[reff_cust]','$hasilRu[code_cust]','$hasilRu[phone_real_user]')";
				$sqlResultRu= mysql_query ($queryResultRu) or die (mysql_error());
			}

			$querySor = mysql_query("SELECT * from pf_sor where id_pf=$_GET[id]");
			while($hasilSor = mysql_fetch_array($querySor)) {
				$queryResultSor="INSERT INTO pf_sor (id_pf_log, desc_sor) VALUES ('$last_id','$hasilSor[desc_sor]')";
				$sqlResultSor= mysql_query ($queryResultSor) or die (mysql_error());
			}
			
			$queryRevenue = mysql_query("SELECT * from pf_revenue where id_pf=$_GET[id]");
			while($hasilRevenue = mysql_fetch_array($queryRevenue)) {
				$queryResultRevenue="INSERT INTO pf_revenue (id_pf_log, type_revenue, desc_revenue, revenue, qty_revenue) VALUES ('$last_id','$hasilRevenue[type_revenue]','$hasilRevenue[desc_revenue]','$hasilRevenue[revenue]','$hasilRevenue[qty_revenue]')";
				$sqlResultRevenue= mysql_query ($queryResultRevenue) or die (mysql_error());
			}

			$queryEst = mysql_query("SELECT * from pf_est_cost where id_pf=$_GET[id]");
			while($hasilEst = mysql_fetch_array($queryEst)) {
				$queryResultEst="INSERT INTO pf_est_cost (id_pf_log, type_est_cost, desc_est_cost, est_cost, qty_est_cost) VALUES ('$last_id','$hasilEst[type_est_cost]','$hasilEst[desc_est_cost]','$hasilEst[est_cost]','$hasilEst[qty_est_cost]')";
				$sqlResultEst= mysql_query ($queryResultEst) or die (mysql_error());
			}
		}
	}
	
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";

		$module=$_GET['module'];
		$act=$_GET['act'];

		//update proforma untuk aproved dengan input est cost other charge
		if ($module=='aproval' AND $act=='aproved'){
			
			$id_pf=$_GET['id'];
			$tgl_cek=$_GET['tgl_aprove'];
			$tgl_aprove=date('Y-m-d');
			$id_user_pf=$_SESSION['id_users'];

			if($_GET['no_jo']==''){
				$bulan=date('n');
				$lokasi="TIMUSUB";
				$date=date('ym');
				$query=mysql_query("select no_jo from pf order by no_jo desc limit 1");
				$hasil=mysql_fetch_array($query);
				$urut=substr($hasil['no_jo'],11);
				$bulankemaren=substr($hasil['no_jo'],9,2);
				$bulanini=date('m');

				if ($bulankemaren!=$bulanini && $urut != 001){
					$urut=0;
				}
				
				$urut=$urut+1;				
				$no_urut=sprintf("%03s", $urut);
				$no_jo="$lokasi$date$no_urut";
				//echo $no_jo;break;
				mysql_query ("UPDATE pf SET tgl_aprove='$tgl_aprove',aprove='1', no_jo='$no_jo', status_ops='APPROVED' WHERE id_pf = $id_pf ");
				
				create_initial_log();
			} else {
				mysql_query ("UPDATE pf SET aprove='1', status_ops='APPROVED' WHERE id_pf = $id_pf ");
				mysql_query ("UPDATE pf_log SET aprove='1', status_ops='APPROVED' WHERE id_pf = $id_pf ");
			}
			header('location:../../oklogin.php?module='.$module);
		}
		elseif ($module=='aproval' AND $act=='forward'){
			$id_pf=$_GET['id'];
			mysql_query ("UPDATE pf_log SET aprove='1' WHERE id_pf = $id_pf ");
			mysql_query ("UPDATE pf SET aprove='1', status_ops='APPROVED' WHERE id_pf = $id_pf ");
			header('location:../../oklogin.php?module='.$module);
		}
		elseif ($module=='aproval' AND $act=='update_aproval'){
			
			mysql_query("UPDATE pf_log SET no_pf = '$_GET[no_pf]',
									   tgl_pf = '$_GET[tgl_pf]',
									   cust_name = '$_GET[cust_name]',
									   address_pf = '$_GET[address_pf]',
									   cust_ref = '$_GET[cust_ref]',
									   cust_code = '$_GET[cust_code]',
									   pic = '$_GET[pic]',
									   shipment = '$_GET[shipment]',
									   commodity= '$_GET[commodity]',
									   route_pf = '$_GET[route_pf]',
									   sales = '$_GET[sales]',
									   phone = '$_GET[phone]',
									   ct = '$_GET[ct]',
									   sf = '$_GET[sf]',
									   vv = '$_GET[vv]',
									   etb = '$_GET[etb]',
									   etd = '$_GET[etd]',
									   openstack = '$_GET[openstack]',
									   ctc = '$_GET[ctc]',
									   ctd = '$_GET[ctd]'
						WHERE id_pf_log = $_GET[id]") 	or die(mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}
		elseif ($module=='aproval' AND $act=='unaproved'){
			$id_pf=$_GET['id'];
			mysql_query ("UPDATE pf SET aprove='0', status_ops='' WHERE id_pf = $id_pf ");
			mysql_query ("UPDATE pf_log SET aprove='0' WHERE id_pf = $id_pf ");
			
			header('location:../../oklogin.php?module='.$module);
		}
		//update proforma untuk Pembatalan
		elseif ($module=='aproval' AND $act=='batal'){
			$id_pf=$_GET['id'];
			$tgl_aprove=date('Y-m-d');
			$batal="batal";

			mysql_query ("UPDATE pf SET tgl_aprove='$tgl_aprove',aprove='$batal' WHERE id_pf = $id_pf ");
			mysql_query ("UPDATE pf_log SET tgl_aprove='$tgl_aprove',aprove='$batal' WHERE id_pf = $id_pf ");

			header('location:../../oklogin.php?module='.$module);
		}
		//update proforma untuk Finish
		elseif ($module=='aproval' AND $act=='finish'){
			$id_pf=$_GET['id'];
			$tgl_aprove=date('Y-m-d');
			$finish="finish";

			mysql_query ("UPDATE pf SET tgl_aprove='$tgl_aprove',aprove='$finish' WHERE id_pf = $id_pf ");

			header('location:../../oklogin.php?module='.$module);
		}

		//Save to Excel
		elseif ($module=='aproval' AND $act=='excel'){
			//Start
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=Proforma($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		
			$id_pf=$_GET['id'];
			$query=mysql_query("select * from pf_log where id_pf='$id_pf'");
			$hasil=mysql_fetch_array($query);
			$id_pf_log = $hasil['id_pf_log'];

		?>
			
			<body>
			    <lable><h3>NOMOR JO : <?=$hasil['no_jo']?></h3></lable>
				<table class="table" border='1'>
				    <tbody>
						<tr>
							<td colspan="2">NUMBER</td>
							<td colspan="2"><?=$hasil['no_pf']?></td>
							<td colspan="2">CUSTOMER REF</td>
							<td colspan="2"><?=$hasil['cust_ref']?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2" align="left"><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>
							<td colspan="2">CUSTOMER CODE</td>
							<td colspan="2"><?=$hasil['cust_code']?></td>
						</tr>
						<tr>
							<td colspan="2">CUSTOMER NAME</td>
							<td colspan="2"><?=$hasil['cust_name']?></td>
							<td colspan="2">PIC</td>
							<td colspan="2"><?=$hasil['pic']?></td>
						</tr>
						<tr>
							<td colspan="2">ADDRESS</td>
							<td colspan="2"><?=$hasil['address_pf']?></td>
							<td colspan="2">PHONE</td>
							<td colspan="2" align="left"><?=$hasil['phone']?></td>
						</tr>
						<tr>
							<td colspan="2">SHIPMENT</td>
							<td colspan="2"><?=$hasil['shipment']?></td>
							<td colspan="2">SHIPING/FORWARDING</td>
							<td colspan="2"><?=$hasil['sf']?></td>
						</tr>
						<tr>
							<td colspan="2">PARTY</td>
							<td colspan="2" align="top" align="left">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log='$id_pf_log'");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?><br>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td colspan="2">VESEL/VOYAGE</td>
							<td colspan="2"><?=$hasil['vv']?></td>
						</tr>
						<tr>
							<td colspan="2">ROUTE</td>
							<td colspan="2"><?=$hasil['route_pf']?></td>
							<td colspan="2">ETB/ETD</td>
							<td colspan="2"><?= date("d M y", strtotime($hasil['etb'])) ?>/<?= date("d M y", strtotime($hasil['etd'])) ?></td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log='$id_pf_log'");
							if (mysql_num_rows($query3) == 0) { ?>
						<tr>
							<td colspan="2">PU/DEL DATE</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?></td>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL LOCATION</td>
							<td colspan="2"><?=$hasil['pudel_location']?></td>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['ctc'])) ?></td>
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasilPudel['pudel_date'])) ?></td>
							<?php if($num == 1) { ?>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="2">QUANTITY</td>
							<td colspan="2"><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
							<?php if($num == 1) { ?>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['ctc'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="2">FROM</td>
							<td colspan="2"><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td colspan="2">TO</td>
							<td colspan="2"><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							}
						} ?>
						<tr>
							<td colspan="2"></td>
							<td colspan="2"></td>
							<td colspan="2">CLOSING TIME DOCUMent</td>
							<td colspan="2" align="left"><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
						</tr>
						<tr>
							<td colspan="2">CREDIT TERM</td>
							<td colspan="2" align="left"><?=$hasil['ct']?></td>
							<td colspan="2">SALES</td>
							<td colspan="2"><?=$hasil['sales']?></td>
						</tr>	
						<tr>
							<td colspan="2">SPECIAL ORDER REQUEST</td>
						</tr>
						<?php
						$no=1;
							$query1=mysql_query("select * from pf_sor where id_pf_log='$id_pf_log'");
							while ($hasil1=mysql_fetch_array($query1)){
						?>
						<tr>
							<td></td>
							<td><?=$no?>. <?=$hasil1['desc_sor']?></td>
						</tr>
							<?php $no++; } ?>
					</tbody>
				</table>	
				
				<h5>TABEL REVENUE</h5>
				<table border='1'>					
					<tr>
						<th>NO</th>
						<th>DESCRIPTION</th>
						<th>REVENUE</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					<tbody style="border: thick;">
						<?php
							$no_rev=1;
							$total_revenue=0;
							$query2=mysql_query("select * from pf_revenue where id_pf_log='$id_pf_log'");
							while($hasil2=mysql_fetch_array($query2)){
							$total_revenue=$total_revenue+($hasil2['revenue']*$hasil2['qty_revenue']);
						?>
						<tr>
							<td><?=$no_rev?></td>
							<td><?=$hasil2['desc_revenue']?></td>
							<td><?=$hasil2['revenue']?></td>
							<td><?=$hasil2['qty_revenue']?></td>
							<td><?=$hasil2['revenue']*$hasil2['qty_revenue']?></td>
						</tr>
						<?php $no_rev++; } ?>
					</tbody>
				</table>
				</p>
				<th><h5>TABLE EST COST</h5></th>
				<table border='1'>
					<tr>
						<th>NO</th>
						<th>TYPE</th>
						<th>DESCRIPTION</th>
						<th>EST COST</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					</tr>
					<?php
						$no_est_cost=1;
						$total_est_cost=0;
						$query3=mysql_query("select * from pf_est_cost where id_pf_log='$id_pf_log'");
						while($hasil3=mysql_fetch_array($query3)){
						$total_est_cost=$total_est_cost+($hasil3['est_cost']*$hasil3['qty_est_cost']);
					?>
					<tr>
						<td><?=$no_est_cost?></td>
						<td><?=$hasil3['type_est_cost']?></td>
						<td><?=$hasil3['desc_est_cost']?></td>
						<td><?=$hasil3['est_cost']?></td>
						<td><?=$hasil3['qty_est_cost']?></td>
						<td><?=$hasil3['est_cost']*$hasil3['qty_est_cost']?></td>
					</tr>	
					<?php $no_est_cost++; } ?>			
				</table>

				<h5>TABEL P/L EST COST</h5>
				<table border='1'>
					<tr>
						<td>1</td>
						<td colspan="2">REVENUE</td>
						<td><?=$total_revenue?></td>
					</tr>
					<tr>
						<td>2</td>
						<td colspan="2">EST COST</td>
						<td><?=$total_est_cost?></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">PROFIT AND LOST EST COST</td>
						<td align='right'><?=$total_revenue-$total_est_cost?></td>
					</tr>
								
				</table>
			</body>
			<?php
		}
		//Print 
		elseif ($module=='aproval' AND $act=='print'){
			$id_pf=$_GET['id'];			
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../../style.css">
			<title>Print Approved Proforma</title>
		</head>
		<body>
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
			<style type="text/css">
			@page {
			size: Legal;
			size: portrait; 
			margin: 5mm 5mm 5mm;
			font-size:13px;
			}
				#marginkiri{
				margin:10mm 10mm 5mm 20mm;

				}
				#garis{
				border-top: 1px solid #afbcc6;
				border-bottom: 1px solid #eff2f6;
				height: 0px;
				}
			</style>
			<!-- Content Page -->
			<section class="content-header">
				<?php
				$no = 1;
				$query = mysql_query("SELECT * FROM pf_log where id_pf='$id_pf'");
				$hasil = mysql_fetch_array($query);
				$id_pf_log = $hasil['id_pf_log'];
				?>	
				<table class="table">
					<tr>
						<td><h1 class="nomargin-bottom">JOB ORDER NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nomargin-bottom">:</h1></td>
						<td><h1 class="nomargin-bottom"><?=$hasil['no_jo']?></h1></td>
					</tr>
					<tr>
						<td><h1 class="nopadding">B/L NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nopadding">:</h1></td>
						<td><h1 class="nopadding"><?=$hasil['bl_number']?></h1></td>
					</tr>
					<tr>
						<td><h1 class="nomargin-top">AJU NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nomargin-top">:</h1></td>
						<td><h1 class="nomargin-top" ><?=$hasil['aju_number']?></h1></td>
					</tr>
				</table>
				<!-- Main content -->
					<table class="table">
						<tr>
							<td style="width: 20%;">NUMBER</td>
							<td style="width: 2%;">:</td>
							<td style="width: 30%;"><?= $hasil['no_pf'] ?></td>
							<td style="width: 3%;"></td>
							<td style="width: 23%;">CUSTOMER REFF</td>
							<td style="width: 2%;">:</td>
							<td style="width: 20%;"><?= $hasil['cust_ref'] ?></td>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?= date("d M y", strtotime($hasil['tgl_pf']))  ?></td>
							<td></td>
							<td>CUSTOMER CODE</td>
							<td>:</td>
							<td><?= $hasil['cust_code'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">CUSTOMER NAME</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['cust_name'] ?></td>
							<td></td>
							<td>PIC</td> 
							<td>:</td>
							<td><?= $hasil['pic'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">ADDRESS</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['address_pf'] ?></td>
							<td></td>
							<td style="vertical-align:top">PHONE</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['phone'] ?></td>
						</tr>
						<?php
						if ($hasil['shipment']!="HANDLING EMKL IMPORT" && $hasil['shipment']!="EMKL IMPORT") { 
						?>
						<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td class="align-start">PARTY</td>
							<td class="align-start">:</td>
							<td class="align-start">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$num ?>. <?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></p>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td></td>
							<td class="align-start">VESSEL/VOYAGE</td>
							<td class="align-start">:</td>
							<td class="align-start"><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td class="align-start">ETB/ETD</td>
							<td class="align-start">:</td>
							<td><?= date("d M y", strtotime($hasil['etb'])) ?> / <?= date("d M y", strtotime($hasil['etd']))  ?> </td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
							if (mysql_num_rows($query3)==0) { ?>
						<tr>
							<td>PU/DEL DATE</td>	
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
						</tr>
						<tr>
							<td class="align-start">PU/DEL LOCATION</td>	
							<td class="align-start">:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctc']))  ?></td>
						</tr>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td></td>
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_date']?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctc']))  ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>FROM</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td>TO</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							} ?>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
						</tr>
						<?php }
					} else { ?>
							<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td class="align-start">PARTY</td>
							<td class="align-start">:</td>
							<td>
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></p>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td></td>
							<td>VESSEL/VOYAGE</td>
							<td>:</td>
							<td><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td>ETB/ETD</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['etb']))  ?>/<?=date("d M y h:i:s", strtotime($hasil['etd'])) ?></td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
							if (mysql_num_rows($query3)==0) { ?>
						<tr>
							<td>PU/DEL DATE</td>	
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>	
							<td>:</td>
							<td>
								<?= $hasil['pudel_location'] ?>
							</td>		
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
							<?php if($num == 1) {?>
							<td>:</td>
							<td></td>
							<td></td>
							<td>B/L NUMBER</td>
							<td>:</td>
							<td><?= $hasil['bl_number'] ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_date']?></td>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
						</tr>
						<tr>
							<td>FROM</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td>TO</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							}
						} ?>
						<?php } ?>	
						<tr>
							<td>SALES</td>
							<td>:</td>
							<td><?= $hasil['sales'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td colspan="3">SPECIAL ORDER REQUEST :</td>
						</tr>
						<?php
							$no_sor=1;
							$query1 = mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
							while ($hasil1=mysql_fetch_array($query1)){
								$id_pf_sor=$hasil1['id_pf_sor'];
						?>
						<tr>
							<td colspan="10" style="font-size:25px; font-weight:bold; color:red;"><?=$no_sor?>. <?=$hasil1['desc_sor']?></td>
						</tr>
						<?php $no_sor++; }?>
					</table>

					<br>					
						<a>REAL CUSTOMER</a>
						<table border="1">
							<tr>
								<th>NO</th>
								<th>REAL CUSTOMER NAME</th>
								<th>ADDRESS</th>
								<th>PHONE </th>
							</tr>
							<?php
							$no_ru=1;
							$query_ru=mysql_query("select * from real_user where id_pf_log=$id_pf_log");
							while($hasil_ru=mysql_fetch_array($query_ru)){
							?>
							<tr>
								<td><?=$no_ru?></td>
								<td><?=$hasil_ru['name_real_user']?></td>
								<td><?=$hasil_ru['address_real_user']?></td>
								<td><?=$hasil_ru['phone_real_user']?></td>
							</tr>
							<?php $no_ru++; } ?>
						</table>
						
					<br>
					<?php
							$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf");
							$hasil_type1=mysql_fetch_array($type1);
						?>
						<a>REVENUE | <?=$hasil_type1['type_revenue']?></a>
						<table border="1">
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
							$query2 = mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log order by id_pf_revenue asc");
							while ($hasil2 = mysql_fetch_array($query2)) { 	
								$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
								$id_pf_revenue=$hasil2['id_pf_revenue'];
							?>	
							<tr>					
								<td align="center"><?=$no_job?></td>
								<td><?=$hasil2['type2_revenue']?></td>
								<td><?=$hasil2['desc_revenue']?></td>
								<td align="right"><?=number_format($hasil2['revenue'])?></td>
								<td align="center"><?=$hasil2['qty_revenue']?></td>
								<td align="right"><?=number_format($sum_revenue)?></td>
							</tr>

							<?php
								$total_revenue=$total_revenue+$sum_revenue;
								$no_job++; 
							}?>	
						</table>
					<br>					
					<?php
						$type1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");
						$hasil_type1=mysql_fetch_array($type1);
					?>
					<a>DETAIL ORDER :</a> 
					<table border="1">
							<tr>
								<th>NO</th>
								<th>TYPE</th>
								<th>DESCRIPTION</th>
								<th>EST COST</th>
								<th>QTY</th>
								<th>ALL IN RATE</th>
							</tr>
							<?php
							$no_job2=1;	
							$sum_est_cost=0;
							$total_est_cost=0;						
							$query3 = mysql_query("select * from pf_est_cost where id_pf_log=$id_pf_log order by id_pf_est_cost asc");
							while ($hasil3 = mysql_fetch_array($query3)) { 
								$sum_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost']; 
								$id_pf_est_cost=$hasil3['id_pf_est_cost'];
							?>
							<tr>				
								<td align="center"><?=$no_job2?></td>
								<td><?=$hasil3['type_est_cost']?></td>
								<td><?=$hasil3['desc_est_cost']?></td>
								<td align="right"><?=number_format($hasil3['est_cost'])?></td>
								<td align="center"><?=$hasil3['qty_est_cost']?></td>
								<td align="right"><?=number_format($sum_est_cost)?></td>
							</tr>	
							<?php
								$total_est_cost=$total_est_cost+$sum_est_cost ; 					
								$no_job2++; 
							}?>	
						</table>
			</section>			
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
			</body>
		</html>
		<?php
		}
	}
?>
