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

			$queryResultProforma = "INSERT INTO pf_log (id_pf, user_pf, no_pf, no_jo, urut_pf, tgl_pf, cust_name,address_pf, cust_ref, cust_code, pic, phone, shipment, qty_pf, commodity, route_pf, pudel_date, pudel_location, sales, ct, sf, vv, etb, etd, openstack, ctc, ctd, bl_number, log_pf, status_ops)
			VALUES('$proformaId[id_pf]', '$_SESSION[namalengkap]','$proformaId[no_pf]','$proformaId[no_jo]','$proformaId[urut_pf]','$proformaId[tgl_pf]','$proformaId[cust_name]','$proformaId[address_pf]','$proformaId[cust_ref]','$proformaId[cust_code]','$proformaId[pic]','$proformaId[phone]','$proformaId[shipment]','$proformaId[qty_pf]','$proformaId[commodity]','$proformaId[route_pf]','$proformaId[pudel_date]','$proformaId[pudel_location]','$proformaId[sales]','$proformaId[ct]','$proformaId[sf]','$proformaId[vv]','$proformaId[etb]','$proformaId[etd]','$proformaId[openstack]','$proformaId[ctc]','$proformaId[ctd]','$proformaId[bl_number]','$countProformaLog','$proformaId[status_ops]')";
			
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
				$queryResultRevenue="INSERT INTO pf_revenue (id_pf_log, type_revenue, type2_revenue, desc_revenue, revenue, qty_revenue, qty_type1_rev, qty_type2_rev, ppn_revenue, pph_revenue, from_revenue, to_revenue) VALUES ('$last_id','$hasilRevenue[type_revenue]','$hasilRevenue[type2_revenue]','$hasilRevenue[desc_revenue]','$hasilRevenue[revenue]','$hasilRevenue[qty_revenue]','$hasilRevenue[qty_type1_rev]','$hasilRevenue[qty_type2_rev]','$hasilRevenue[ppn_revenue]','$hasilRevenue[pph_revenue]','$hasilRevenue[from_revenue]','$hasilRevenue[to_revenue]')";
				$sqlResultRevenue= mysql_query ($queryResultRevenue) or die (mysql_error());
				$rev_id = mysql_insert_id();

				$queryRevPudel = mysql_query("SELECT * from pf_pudel_qty where id_pf_revenue=$hasilRevenue[id_pf_revenue]");
				while($hasilRevPudel = mysql_fetch_array($queryRevPudel)) {
					$queryItem="INSERT INTO pf_pudel_qty (id_pf_revenue, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$rev_id','$hasilRevPudel[from_pudel]','$hasilRevPudel[to_pudel]','$hasilRevPudel[qty]','$hasilRevPudel[type1]','$hasilRevPudel[type2]','$hasilRevPudel[rate]','$hasilRevPudel[ppn]','$hasilRevPudel[pph]')";
					$sqlResultRevenuePudel= mysql_query ($queryItem) or die (mysql_error());
				}
			}

			$queryEst = mysql_query("SELECT * from pf_est_cost where id_pf=$_GET[id]");
			while($hasilEst = mysql_fetch_array($queryEst)) {
				$queryResultEst="INSERT INTO pf_est_cost (id_pf_log, type_est_cost, desc_est_cost, est_cost, qty_est_cost, qty_type1_est_cost, qty_type2_est_cost, ppn_est_cost, pph_est_cost, from_est_cost, to_est_cost) VALUES ('$last_id','$hasilEst[type_est_cost]','$hasilEst[desc_est_cost]','$hasilEst[est_cost]','$hasilEst[qty_est_cost]','$hasilEst[qty_type1_est_cost]','$hasilEst[qty_type2_est_cost]','$hasilEst[ppn_est_cost]','$hasilEst[pph_est_cost]','$hasilEst[from_est_cost]','$hasilEst[to_est_cost]')";
				$sqlResultEst= mysql_query ($queryResultEst) or die (mysql_error());
				$cost_id = mysql_insert_id();

				$queryCostPudel = mysql_query("SELECT * from pf_pudel_qty where id_pf_est_cost=$hasilEst[id_pf_est_cost]");
				while($hasilCostPudel = mysql_fetch_array($queryCostPudel)) {
					$queryItem="INSERT INTO pf_pudel_qty (id_pf_est_cost, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$cost_id','$hasilCostPudel[from_pudel]','$hasilCostPudel[to_pudel]','$hasilCostPudel[qty]','$hasilCostPudel[type1]','$hasilCostPudel[type2]','$hasilCostPudel[rate]','$hasilCostPudel[ppn]','$hasilCostPudel[pph]')";
					$sqlResultCostPudel= mysql_query ($queryItem) or die (mysql_error());
				}
			}
		}
	}

	function create_proforma_log() {
		$hari_ini = date("Y-m-d H:i:s");
		$proformaLog = mysql_query("SELECT * from pf_log where id_pf=$_GET[id]");
		$countProformaLog = mysql_num_rows($proformaLog);
		$queryProforma = mysql_query("SELECT * from pf where id_pf=$_GET[id]");
		$proformaId=mysql_fetch_array($queryProforma);

		$queryResultProforma = "INSERT INTO pf_log (id_pf, user_pf, no_pf, no_jo, urut_pf, tgl_pf, cust_name,address_pf, cust_ref, cust_code, pic, phone, shipment, qty_pf, commodity, route_pf, pudel_date, pudel_location, sales, ct, sf, vv, etb, etd, openstack, ctc, ctd, bl_number, log_pf, status_ops)
		VALUES('$proformaId[id_pf]', '$_SESSION[namalengkap]','$proformaId[no_pf]','$proformaId[no_jo]','$proformaId[urut_pf]','$hari_ini','$proformaId[cust_name]','$proformaId[address_pf]','$proformaId[cust_ref]','$proformaId[cust_code]','$proformaId[pic]','$proformaId[phone]','$proformaId[shipment]','$proformaId[qty_pf]','$proformaId[commodity]','$proformaId[route_pf]','$proformaId[pudel_date]','$proformaId[pudel_location]','$proformaId[sales]','$proformaId[ct]','$proformaId[sf]','$proformaId[vv]','$proformaId[etb]','$proformaId[etd]','$proformaId[openstack]','$proformaId[ctc]','$proformaId[ctd]','$proformaId[bl_number]','$countProformaLog','$proformaId[status_ops]')";
		$sqlResultProforma = mysql_query ($queryResultProforma) or die (mysql_error());
		return mysql_insert_id();
	}

	function create_qty_log($last_id) {
		$queryQty = mysql_query("SELECT * from pf_qty where id_pf=$_GET[id]");
		while($hasilQty = mysql_fetch_array($queryQty)) {
			$queryResultQty="INSERT INTO pf_qty (id_pf_log, qty, type1, type2) VALUES ('$last_id','$hasilQty[qty]','$hasilQty[type1]','$hasilQty[type2]')";
			$sqlResultQty= mysql_query ($queryResultQty) or die (mysql_error());
		}
	}

	function create_pudel_log($last_id) {
		$queryPudel = mysql_query("SELECT * from pf_pudel where id_pf=$_GET[id]");
		while($hasilPudel = mysql_fetch_array($queryPudel)) {
			$queryResultPudel="INSERT INTO pf_pudel (id_pf_log, pudel_date, qty, type1, type2, pudel_from, pudel_to) VALUES ('$last_id','$hasilPudel[pudel_date]','$hasilPudel[qty]','$hasilPudel[type1]','$hasilPudel[type2]','$hasilPudel[pudel_from]','$hasilPudel[pudel_to]')";
			$sqlResultPudel= mysql_query ($queryResultPudel) or die (mysql_error());
		}
	}

	function create_sor_log($last_id) {
		$querySor = mysql_query("SELECT * from pf_sor where id_pf=$_GET[id]");
		while($hasilSor = mysql_fetch_array($querySor)) {
			$queryResultSor="INSERT INTO pf_sor (id_pf_log, desc_sor) VALUES ('$last_id','$hasilSor[desc_sor]')";
			$sqlResultSor= mysql_query ($queryResultSor) or die (mysql_error());
		}
	}

	function create_ru_log($last_id) {
		$queryRu = mysql_query("SELECT * from real_user where id_pf=$_GET[id]");
		while($hasilRu = mysql_fetch_array($queryRu)) {
			$queryResultRu="INSERT INTO real_user (id_pf_log, name_real_user,pic, address_real_user,reff_cust, code_cust, phone_real_user) VALUES ('$last_id','$hasilRu[name_real_user]','$hasilRu[pic]','$hasilRu[address_real_user]','$hasilRu[reff_cust]','$hasilRu[code_cust]','$hasilRu[phone_real_user]')";
			$sqlResultRu= mysql_query ($queryResultRu) or die (mysql_error());
		}
	}

	function create_revenue_log($last_id) {
		$queryRevenue = mysql_query("SELECT * from pf_revenue where id_pf=$_GET[id]");
		while($hasilRevenue = mysql_fetch_array($queryRevenue)) {
			$queryResultRevenue="INSERT INTO pf_revenue (id_pf_log, type_revenue, type2_revenue, desc_revenue) VALUES ('$last_id','$hasilRevenue[type_revenue]','$hasilRevenue[type2_revenue]','$hasilRevenue[desc_revenue]')";
			$sqlResultRevenue= mysql_query ($queryResultRevenue) or die (mysql_error());
			$rev_id = mysql_insert_id();

			$queryRevPudel = mysql_query("SELECT * from pf_pudel_qty where id_pf_revenue=$hasilRevenue[id_pf_revenue]");
			while($hasilRevPudel = mysql_fetch_array($queryRevPudel)) {
				$queryItem="INSERT INTO pf_pudel_qty (id_pf_revenue, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$rev_id','$hasilRevPudel[from_pudel]','$hasilRevPudel[to_pudel]','$hasilRevPudel[qty]','$hasilRevPudel[type1]','$hasilRevPudel[type2]','$hasilRevPudel[rate]','$hasilRevPudel[ppn]','$hasilRevPudel[pph]')";
				$sqlResultRevenuePudel= mysql_query ($queryItem) or die (mysql_error());
			}
		}
	}

	function create_cost_log($last_id) {
		$queryEst = mysql_query("SELECT * from pf_est_cost where id_pf=$_GET[id]");
		while($hasilEst = mysql_fetch_array($queryEst)) {
			$queryResultEst="INSERT INTO pf_est_cost (id_pf_log, type_est_cost, desc_est_cost) VALUES ('$last_id','$hasilEst[type_est_cost]','$hasilEst[desc_est_cost]')";
			$sqlResultEst= mysql_query ($queryResultEst) or die (mysql_error());
			$cost_id = mysql_insert_id();

			$queryCostPudel = mysql_query("SELECT * from pf_pudel_qty where id_pf_est_cost=$hasilEst[id_pf_est_cost]");
			while($hasilCostPudel = mysql_fetch_array($queryCostPudel)) {
				$queryItem="INSERT INTO pf_pudel_qty (id_pf_est_cost, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$cost_id','$hasilCostPudel[from_pudel]','$hasilCostPudel[to_pudel]','$hasilCostPudel[qty]','$hasilCostPudel[type1]','$hasilCostPudel[type2]','$hasilCostPudel[rate]','$hasilCostPudel[ppn]','$hasilCostPudel[pph]')";
				$sqlResultCostPudel= mysql_query ($queryItem) or die (mysql_error());
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
				mysql_query ("UPDATE pf SET tgl_aprove='$tgl_aprove',aprove='$id_user_pf', no_jo='$no_jo', status_ops='APPROVED' WHERE id_pf = $id_pf ");
					
			} else {
				mysql_query ("UPDATE pf SET aprove='$id_user_pf', status_ops='APPROVED' WHERE id_pf = $id_pf ");
			}
			create_initial_log();

			$last_id = create_proforma_log();
			create_qty_log($last_id);
			create_pudel_log($last_id);
			create_sor_log($last_id);
			create_ru_log($last_id);
			create_revenue_log($last_id);
			create_cost_log($last_id);
			
			header('location:../../oklogin.php?module='.$module);
		}
		elseif ($module=='aproval' AND $act=='unaproved'){
			
			$id_pf=$_GET['id'];

					mysql_query ("UPDATE pf SET aprove='0' WHERE id_pf = $id_pf ");

			header('location:../../oklogin.php?module='.$module);
		}
		//update proforma untuk Pembatalan
		elseif ($module=='aproval' AND $act=='batal'){
			$id_pf=$_GET['id'];
			$tgl_aprove=date('Y-m-d');
			$batal="batal";

			mysql_query ("UPDATE pf SET tgl_aprove='$tgl_aprove',aprove='$batal' WHERE id_pf = $id_pf ");

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
			$query=mysql_query("select * from pf where id_pf='$id_pf'");
			$hasil=mysql_fetch_array($query);

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
							<td colspan="2">QUANTITY</td>
							<td colspan="2" align="top" align="left">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?><br>
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
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
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
							$query1=mysql_query("select * from pf_sor where id_pf='$id_pf'");
							while ($hasil1=mysql_fetch_array($query1)){
						?>
						<tr>
							<td></td>
							<td><?=$no?>. <?=$hasil1['desc_sor']?></td>
						</tr>
							<?php $no++; } ?>
					</tbody>
				</table>	
				
				
				<table border='1'>
					<tr>
						<th><h5>TABEL REVENUE</h5></th>
					</tr>
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
							$query2=mysql_query("select * from pf_revenue where id_pf='$id_pf'");
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
						$query3=mysql_query("select * from pf_est_cost where id_pf='$id_pf'");
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
				<table>
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
				$query = mysql_query("SELECT * FROM pf where id_pf='$id_pf'");
				$hasil = mysql_fetch_array($query);
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
							<td class="align-start">QUANTITY</td>
							<td class="align-start">:</td>
							<td class="align-start">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$num ?>. <?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
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
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
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
							<td class="align-start">QUANTITY</td>
							<td class="align-start">:</td>
							<td>
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
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
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
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
							$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
							while ($hasil1=mysql_fetch_array($query1)){
								$id_pf_sor=$hasil1['id_pf_sor'];
						?>
						<tr>
							<td><?=$no_sor?>. <?=$hasil1['desc_sor']?></td>
						</tr>
						<?php $no_sor++; }?>
					</table>

					<br>					
					<?php
						$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf");
						$hasil_type1=mysql_fetch_array($type1);
					?>
					<a>DETAIL ORDER :</a> 
					<table>
						<?php
						$no_job2=1;	
						$sum_est_cost=0;
						$total_est_cost=0;						
						$query3 = mysql_query("select distinct type_est_cost from pf_est_cost where id_pf=$id_pf order by type_est_cost asc");
						while ($hasil3 = mysql_fetch_array($query3)) { 
							$type_est_cost=$hasil3['type_est_cost'];
						?>
						<tr>
							<td style="vertical-align:top"> <?=$no_job2?>. <?=$type_est_cost?></td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top">
								<?php
									$no_job3=1;
									$query4=mysql_query("select * from pf_est_cost where id_pf=$id_pf and type_est_cost='$type_est_cost' order by type_est_cost asc");
									while($hasil4=mysql_fetch_array($query4)){
								?>
								<?=$no_job3?>. <?=$hasil4['desc_est_cost']?><br>
									<?php $no_job3++; } ?>
							</td>	
							
							
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
