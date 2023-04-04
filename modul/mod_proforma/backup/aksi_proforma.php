<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";

		$module=$_GET['module'];
		$act=$_GET['act'];

		// Input user
		if ($module=='proforma' AND $act=='input'){

			$user_pf=$_SESSION['namalengkap'];
			$no_pf=$_POST['no_pf'];
			$tgl_pf=$_POST['tgl_pf'];
			$cust_name=$_POST['cust_name'];
			$address_pf=$_POST['address_pf'];

			$shipment=$_POST['shipment'];
			$commodity=$_POST['commodity'];
			$route_pf=$_POST['route_pf0'] . '/' . $_POST['route_pf1'];
			$ct=$_POST['ct'];
			$sales=$_POST['sales'];
			
			$cust_ref=$_POST['cust_ref'];
			$cust_code=$_POST['cust_code'];
			$pic=$_POST['pic'];
			$phone=$_POST['phone'];

			$sf=$_POST['sf'];
			$vv=$_POST['vv'];
			$etb=$_POST['etb'];
			$etd=$_POST['etd'];
			$openstack=$_POST['openstack'];
			$ctc=$_POST['ctc'];
			$ctd=$_POST['ctd'];

			// Data pf_Party
			$party_qty=$_POST['party_pf0'];
			$party_type1=$_POST['party_pf1'];
			$party_pf1_desc=$_POST['party_pf1_desc'];
			$party_type2=$_POST['party_pf2'];
			$party_pf2_desc=$_POST['party_pf2_desc'];

			// Data pf_pudel
			$pudel_date0=$_POST['pudel_date0'];
			$pudel_party_qty=$_POST['pudel_party_qty'];
			$pudel_party_pf1=$_POST['pudel_party_pf1'];
			$pudel_party_pf1_desc=$_POST['pudel_party_pf1_desc'];
			$pudel_party_pf2=$_POST['pudel_party_pf2'];
			$pudel_party_pf2_desc=$_POST['pudel_party_pf2_desc'];
			$pudel_route_from_pf=$_POST['pudel_route_from_pf'];
			$pudel_route_to_pf=$_POST['pudel_route_to_pf'];

			// Real User
			$name_real_user=$_POST['ru_name'];
			$address_real_user=$_POST['ru_address'];
			$phone_real_user=$_POST['ru_phone'];
			$ru_ref=$_POST['ru_ref'];
			$ru_code=$_POST['ru_code'];
			$ru_pic=$_POST['ru_pic'];

			// Sor
			$desc_sor=$_POST['desc_sor'];

			// Revenue
			$type_revenue=$_POST['type_revenue'];
			$desc1_revenue=$_POST['desc1_revenue'];
			$desc2_revenue=$_POST['desc2_revenue'];
			$rate_rev=$_POST['rate_rev'];
			$ppn_rev=$_POST['ppn_rev'];
			$pph_rev=$_POST['pph_rev'];

			// Cost
			$type_est_cost=$_POST['type_est_cost'];
			$desc1_est_cost=$_POST['desc1_est_cost'];
			$desc2_est_cost=$_POST['desc2_est_cost'];
			$rate_cost=$_POST['rate_cost'];
			$ppn_cost=$_POST['ppn_cost'];
			$pph_cost=$_POST['pph_cost'];

			$save_rate=$_POST['save_rate'];

			$query = "INSERT INTO pf (user_pf, no_pf, tgl_pf, cust_name, address_pf, cust_ref, cust_code, pic, phone, shipment, commodity, route_pf, sales, ct, sf, vv, etb, etd, openstack, ctc, ctd)
			VALUES('$user_pf','$no_pf','$tgl_pf','$cust_name','$address_pf','$cust_ref','$cust_code','$pic','$phone','$shipment','$commodity','$route_pf','$sales','$ct','$sf','$vv','$etb','$etd','$openstack','$ctc','$ctd')";
			$sql = mysql_query ($query) or die (mysql_error());
			$last_id = mysql_insert_id();

			for($x=0; $x < count($name_real_user); $x++) {
				$query="INSERT INTO real_user (id_pf, name_real_user, address_real_user, phone_real_user, reff_cust, pic, code_cust) VALUES ('$last_id','$name_real_user[$x]','$address_real_user[$x]','$phone_real_user[$x]','$ru_ref[$x]','$ru_pic[$x]','$ru_code[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($party_qty); $x++) {
				$query="INSERT INTO pf_qty (id_pf, qty, type1, type2) VALUES ('$last_id','$party_qty[$x]','$party_type1[$x]$party_pf1_desc[$x]','$party_type2[$x]$party_pf2_desc[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($pudel_date0); $x++) {
				$query="INSERT INTO pf_pudel (id_pf, pudel_date, qty, type1, type2, pudel_from, pudel_to) VALUES ('$last_id','$pudel_date0[$x]','$pudel_party_qty[$x]','$pudel_party_pf1[$x]$pudel_party_pf1_desc[$x]','$pudel_party_pf2[$x]$pudel_party_pf2_desc[$x]','$pudel_route_from_pf[$x]','$pudel_route_to_pf[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($desc_sor); $x++) {
				$query="INSERT INTO pf_sor (id_pf, desc_sor) VALUES ('$last_id','$desc_sor[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($type_revenue); $x++) {
				$from_rev=$_POST['from_rev'.$x];
				$to_rev=$_POST['to_rev'.$x];
				$qty_rev=$_POST['qty_rev'.$x];
				$qty_type1_rev=$_POST['qty_type1_rev'.$x];
				$qty_desc1_rev=$_POST['qty_desc1_rev'.$x];
				$qty_type2_rev=$_POST['qty_type2_rev'.$x];
				$qty_desc2_rev=$_POST['qty_desc2_rev'.$x];
				$rate_rev=$_POST['rate_rev'.$x];
				$ppn_rev=$_POST['ppn_rev'.$x];
				$pph_rev=$_POST['pph_rev'.$x];

				//CHECK IF RATE EXIST
				if ($save_rate == 'y') {
					$query_rate=mysql_query("SELECT * FROM ct_rev_rate WHERE cust_name='$cust_name' AND shipment='$shipment' AND type_rev='$type_revenue[$x]' AND desc_rev='$desc1_revenue[$x]'") or die (mysql_error());
					if (mysql_num_rows($query_rate) == 0) {
						$queryRate = "INSERT INTO ct_rev_rate (cust_name, shipment, type_rev, desc_rev, rate, ppn, pph) VALUES ('$cust_name','$shipment', '$type_revenue[$x]', '$desc1_revenue[$x]', '$rate_rev[0]', '$ppn_rev[0]', '$pph_rev[0]')";
						$sqlRate = mysql_query ($queryRate) or die (mysql_error());
					}
				}

				$query="INSERT INTO pf_revenue (id_pf, type_revenue, desc_revenue, revenue, ppn_revenue, pph_revenue) VALUES ('$last_id','$type_revenue[$x]', '$desc1_revenue[$x]$desc2_revenue[$x]','$rate_rev[0]','$ppn_rev[0]','$pph_rev[0]')";
				$sql= mysql_query ($query) or die (mysql_error());
				$rev_id = mysql_insert_id();

				for($y=0; $y < count($qty_rev); $y++) {
					$queryItem="INSERT INTO pf_pudel_qty (id_pf_revenue, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$rev_id','$from_rev[$y]','$to_rev[$y]','$qty_rev[$y]','$qty_type1_rev[$y]$qty_desc1_rev[$y]','$qty_type2_rev[$y]$qty_desc2_rev[$y]','$rate_rev[$y]','$ppn_rev[$y]','$pph_rev[$y]')";
					$sqlItem= mysql_query ($queryItem) or die (mysql_error());
				}
			}

			for($x=0; $x < count($type_est_cost); $x++) {
				$from_cost=$_POST['from_cost'.$x];
				$to_cost=$_POST['to_cost'.$x];
				$qty_cost=$_POST['qty_cost'.$x];
				$qty_type1_cost=$_POST['qty_type1_cost'.$x];
				$qty_desc1_cost=$_POST['qty_desc1_cost'.$x];
				$qty_type2_cost=$_POST['qty_type2_cost'.$x];
				$qty_desc2_cost=$_POST['qty_desc2_cost'.$x];
				$rate_cost=$_POST['rate_cost'.$x];
				$ppn_cost=$_POST['ppn_cost'.$x];
				$pph_cost=$_POST['pph_cost'.$x];

				$query="INSERT INTO pf_est_cost (id_pf, type_est_cost, desc_est_cost, est_cost, ppn_est_cost, pph_est_cost) VALUES ('$last_id','$type_est_cost[$x]', '$desc1_est_cost[$x]$desc2_est_cost[$x]','$rate_cost[0]','$ppn_cost[0]','$pph_cost[0]')";
				$sql= mysql_query ($query) or die (mysql_error());
				$cost_id = mysql_insert_id();

				for($y=0; $y < count($qty_cost); $y++) {
					$queryItem="INSERT INTO pf_pudel_qty (id_pf_est_cost, from_pudel, to_pudel, qty, type1, type2, rate, ppn, pph) VALUES ('$cost_id','$from_cost[$y]','$to_cost[$y]','$qty_cost[$y]','$qty_type1_cost[$y]$qty_desc1_cost[$y]','$qty_type2_cost[$y]$qty_desc2_cost[$y]','$rate_cost[$y]','$ppn_cost[$y]','$pph_cost[$y]')";
					$sqlItem= mysql_query ($queryItem) or die (mysql_error());
				}
			}

			header("location:../../oklogin.php?module=$module&act=show&id=$last_id");
		}

		//tambah ru
		elseif ($module=='proforma' AND $act=='tambah_ru'){
			$id_pf=$_GET['id'];
			$name_real_user=$_GET['name_real_user'];
			$address_real_user=$_GET['address_real_user'];
			$reff_cust=$_GET['reff_cust'];
			$code_cust=$_GET['code_cust'];
			$pic=$_GET['pic'];
			$phone_real_user=$_GET['phone_real_user'];

			$query="INSERT INTO real_user (id_pf, name_real_user,pic, address_real_user,reff_cust, code_cust, phone_real_user) VALUES ('$id_pf','$name_real_user','$pic','$address_real_user','$reff_cust','$code_cust','$phone_real_user')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}
		//tambah sor
		elseif ($module=='proforma' AND $act=='tambah_sor'){
			$id_pf=$_GET['id'];
			$desc_sor=$_GET['desc_sor'];

			$query="INSERT INTO pf_sor (id_pf, desc_sor) VALUES ('$id_pf','$desc_sor')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}
		//tambah revenue
		elseif ($module=='proforma' AND $act=='tambah_revenue'){
			$id_pf=$_GET['id'];
			$type_revenue=$_GET['type_revenue'];
			$type2_revenue=$_GET['type2_revenue'];
			$desc_revenue=$_GET['desc_revenue'];
			$revenue=$_GET['revenue'];
			$qty_revenue=$_GET['qty_revenue'];
			$qty_type1_rev=$_GET['qty_type1_rev'];
			$qty_type2_rev=$_GET['qty_type2_rev'];
			$from_revenue=$_GET['from_revenue'];
			$to_revenue=$_GET['to_revenue'];
			$ppn_revenue=$_GET['ppn_revenue'];
			$pph_revenue=$_GET['pph_revenue'];

			$query="INSERT INTO pf_revenue (id_pf, type_revenue, type2_revenue, desc_revenue, revenue, qty_revenue, qty_type1_rev, qty_type2_rev, ppn_revenue, pph_revenue, from_revenue, to_revenue) VALUES ('$id_pf','$type_revenue','$type2_revenue','$desc_revenue','$revenue','$qty_revenue','$qty_type1_rev','$qty_type2_rev','$ppn_revenue','$pph_revenue','$from_revenue','$to_revenue')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}
		// tambah est_cost
		elseif ($module=='proforma' AND $act=='tambah_est_cost'){
			$id_pf=$_GET['id'];
			$type_est_cost=$_GET['type_est_cost'];
			$desc_est_cost=$_GET['desc_est_cost'];
			$est_cost=$_GET['est_cost'];
			$qty_est_cost=$_GET['qty_est_cost'];
			$qty_type1_est_cost=$_GET['qty_type1_est_cost'];
			$qty_type2_est_cost=$_GET['qty_type2_est_cost'];
			$from_est_cost=$_GET['from_est_cost'];
			$to_est_cost=$_GET['to_est_cost'];
			$ppn_est_cost=$_GET['ppn_est_cost'];
			$pph_est_cost=$_GET['pph_est_cost'];

			$query="INSERT INTO pf_est_cost (id_pf, type_est_cost, desc_est_cost, est_cost, qty_est_cost, qty_type1_est_cost, qty_type2_est_cost, ppn_est_cost, pph_est_cost, from_est_cost, to_est_cost) VALUES ('$id_pf','$type_est_cost','$desc_est_cost','$est_cost','$qty_est_cost','$qty_type1_est_cost','$qty_type2_est_cost','$ppn_est_cost','$pph_est_cost','$from_est_cost','$to_est_cost')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}

		// Update ru
		else if ($module=='proforma' AND $act=='update_ru'){
		
			mysql_query("UPDATE real_user SET name_real_user = '$_GET[name_real_user]',
											  address_real_user= '$_GET[address_real_user]', 
											  reff_cust='$_GET[reff_cust]',
											  code_cust='$_GET[code_cust]',
											  pic= '$_GET[pic]', 
											  phone_real_user= '$_GET[phone_real_user]'
						WHERE id_real_user = $_GET[id]") or die(mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}
		// Update proforma
		elseif ($module=='proforma' AND $act=='update_proforma'){
		
			mysql_query("UPDATE pf SET no_pf = '$_GET[no_pf]',
									   tgl_pf = '$_GET[tgl_pf]',
									   cust_name = '$_GET[cust_name]',
									   address_pf = '$_GET[address_pf]',
									   cust_ref = '$_GET[cust_ref]',
									   cust_code = '$_GET[cust_code]',
									   pic = '$_GET[pic]',
									   shipment = '$_GET[shipment]',
									   qty_pf = '$_GET[qty_pf]',
									   type_qty = '$_GET[type_qty]',
									   commodity= '$_GET[commodity]',
									   route_pf = '$_GET[route_pf]',
									   pudel_date = '$_GET[pudel_date]',
									   pudel_location = '$_GET[pudel_location]',
									   sales = '$_GET[sales]',
									   phone = '$_GET[phone]',
									   ct = '$_GET[ct]',
									   sf = '$_GET[sf]',
									   vv = '$_GET[vv]',
									   etb = '$_GET[etb]',
									   etd = '$_GET[etd]',
									   openstack = '$_GET[openstack]',
									   ctc = '$_GET[ctc]',
									   ctd = '$_GET[ctd]',
									   bl_number = '$_GET[bl_number]',
									   aju_number = '$_GET[aju_number]'
						WHERE id_pf = $_GET[id]") 	or die(mysql_error());
			
			$qtyQuery = mysql_query("SELECT * from pf_qty where id_pf=$_GET[id]");
			if (mysql_num_rows($qtyQuery) != 0) { 

				$party_qty=$_GET['party_qty'];
				$party_type1=$_GET['party_type0'];
				$party_type2=$_GET['party_type1'];

				$x = 0;
				while($hasilQty = mysql_fetch_array($qtyQuery)) {
					$queryResultQty ="UPDATE pf_qty set qty = '$party_qty[$x]',
											type1 = '$party_type1[$x]',
											type2 = '$party_type2[$x]'
											WHERE id_pf_qty = '$hasilQty[id_pf_qty]'";
					$sqlQty = mysql_query ($queryResultQty) or die (mysql_error());
					$x++;
				}
			}

			$pudelQuery = mysql_query("SELECT * from pf_pudel where id_pf=$_GET[id]");
			if (mysql_num_rows($pudelQuery) != 0) {

				$pudel_date=$_GET['pudel_date0'];
				$pudel_qty=$_GET['pudel_qty'];
				$pudel_type1=$_GET['pudel_type0'];
				$pudel_type2=$_GET['pudel_type1'];
				$pudel_from=$_GET['pudel_from'];
				$pudel_to=$_GET['pudel_to'];

				$y = 0;
				while($hasilPudel = mysql_fetch_array($pudelQuery)) {
					$queryResultPudel ="UPDATE pf_pudel set pudel_date = '$pudel_date[$y]',
											qty = '$pudel_qty[$y]',
											type1 = '$pudel_type1[$y]',
											type2 = '$pudel_type2[$y]',
											pudel_from = '$pudel_from[$y]',
											pudel_to = '$pudel_to[$y]'
											WHERE id_pf_pudel = '$hasilPudel[id_pf_pudel]'";
					$sqlPudel = mysql_query ($queryResultPudel) or die (mysql_error());
					$y++;
				}
			}
			
			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id]");
		}
		// Update sor
		elseif ($module=='proforma' AND $act=='update_sor'){
		
			mysql_query("UPDATE pf_sor SET desc_sor = '$_GET[desc_sor]' WHERE id_pf_sor = $_GET[id]");

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}
		//Update Revenue
		elseif ($module=='proforma' AND $act=='update_revenue'){
		
			mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]',
									   qty_type1_rev= '$_GET[qty_type1_rev]',
									   qty_type2_rev= '$_GET[qty_type2_rev]',
									   from_revenue= '$_GET[from_revenue]',
									   to_revenue= '$_GET[to_revenue]',
									   ppn_revenue= '$_GET[ppn_revenue]',
									   pph_revenue= '$_GET[pph_revenue]'
						WHERE id_pf_revenue = $_GET[id]") or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}

		//Update est_cost
		elseif ($module=='proforma' AND $act=='update_est_cost'){
		
			mysql_query("UPDATE pf_est_cost SET type_est_cost='$_GET[type_est_cost]',
									   desc_est_cost='$_GET[desc_est_cost]',
									   est_cost='$_GET[est_cost]',
									   qty_est_cost='$_GET[qty_est_cost]',
									   qty_type1_est_cost='$_GET[qty_type1_est_cost]',
									   qty_type2_est_cost='$_GET[qty_type2_est_cost]',
									   from_est_cost='$_GET[from_est_cost]',
									   to_est_cost='$_GET[to_est_cost]',
									   ppn_est_cost='$_GET[ppn_est_cost]',
									   pph_est_cost='$_GET[pph_est_cost]'
						WHERE id_pf_est_cost = $_GET[id]") or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}

		// Hapus data
		elseif ($module=='proforma' AND $act=='delete_ru'){
			mysql_query("DELETE FROM real_user WHERE  id_real_user = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}
		elseif ($module=='proforma' AND $act=='delete_sor'){
			mysql_query("DELETE FROM pf_sor WHERE  id_pf_sor = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}
		elseif ($module=='proforma' AND $act=='delete_revenue'){
			mysql_query("DELETE FROM pf_revenue WHERE  id_pf_revenue = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}
		elseif ($module=='proforma' AND $act=='delete_est_cost'){
			mysql_query("DELETE FROM pf_est_cost WHERE  id_pf_est_cost = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=show&id=$_GET[id_pf]");
		}

		//Save to Excel
		elseif ($module=='proforma' AND $act=='excel'){
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
				<table class="table">
				    <tbody>
						<tr>
							<td colspan="2">NUMBER</td>
							<td colspan="2"><?=$hasil['no_pf']?></td>
							<td colspan="2">CUSTOMER REF</td>
							<td colspan="2"><?=$hasil['cust_ref']?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2" align="left"><?=date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>
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
							<td colspan="2"><?=$hasil['etb']?> / <?=$hasil['etd']?></td>
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
							<td colspan="2">CLOSING TIME DOCUMENT</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
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
				<br>
				<h5>REAL CUSTOMER</h5>
				<table>
					<tr>
						<th>NO</th>
						<th>REAL CUSTOMER NAME</th>
						<th>ADDRESS</th>
						<th>PHONE </th>
					</tr>
					<?php
					$no_ru=1;
					$query_ru=mysql_query("select * from real_user where id_pf=$id_pf");
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
				
				<table>
					<tr>
						<th><h5>TABEL REVENUE</h5></th>
					</tr>
					<tr>
						<th><h5>ALL IN RATE</h5></th>
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
				<table>
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
		elseif ($module=='proforma' AND $act=='print') {
			$id_pf=$_GET['id'];			
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../../style.css">
			<title>Print Proforma</title>
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
			#garis {
				border-top: 1px solid #afbcc6;
				border-bottom: 1px solid #eff2f6;
				height: 0px;
			}
			</style>
			<!-- Content Page -->
			<section class="content-header">
					<h1>PROFORMA JOB ORDER</h1>
				<?php
				$no = 1;
				$query = mysql_query("SELECT * FROM pf where id_pf='$id_pf'");
				$hasil = mysql_fetch_array($query);
				?>	
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
						$query_ru=mysql_query("select * from real_user where id_pf=$id_pf");
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
						$query2 = mysql_query("select * from pf_revenue where id_pf=$id_pf order by id_pf_revenue asc");
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
					<a>EST COST</a> 
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
						$query3 = mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost asc");
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

					<br>
					<a>P/L ESTIMASI COST</a>	
					<table border="1">
						<tr>
							<th>NO</th>
							<th>DESCRIPTION</th>
							<th>TOTAL</th>
						</tr>
						<tr>
							<td align="center">1</td>
							<td>Total Revenue</td>
							<td align="right"><?=number_format($total_revenue)?></td>
						</tr>
						<tr>
							<td align="center">2</td>
							<td>Total Estimasi Cost</td>
							<td align="right"><?=number_format($total_est_cost)?></td>
						</tr>
						<tr>
							<td></td>
							<td>Profit and Lost Estimasi Cost</td>
							<td align="right"><?=number_format($total_revenue-$total_est_cost)?></td>
						</tr>

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
