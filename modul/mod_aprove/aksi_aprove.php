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
			//$no_job=$_POST['no_job'];
			$tgl_pf=$_POST['tgl_pf'];
			$cust_name=$_POST['cust_name'];
			$address_pf=$_POST['address_pf'];

			$shipment=$_POST['shipment'];
			$qty_pf=$_POST['qty_pf'];
			$type_qty=$_POST['type_qty'];
			$route_pf=$_POST['route_pf'];
			$pudel_date=$_POST['pudel_date'];
			$pudel_location=$_POST['pudel_location'];
			$ct=$_POST['ct'];
			$sales=$_POST['sales'];
			
			$cust_ref=$_POST['cust_ref'];
			$cust_code=$_POST['cust_code'];
			$pic=$_POST['pic'];
			$phone=$_POST['phone'];

			$sf=$_POST['sf'];
			$vv=$_POST['vv'];
			$etb_etd=$_POST['etb_etd'];
			$openstack=$_POST['openstack'];
			$ctc=$_POST['ctc'];
			$ctd=$_POST['ctd'];
			$bl_number=$_POST['bl_number'];
			
		// Data Spesial order request (SOR) 
			$desc_sor=$_POST['desc_sor'];

		// Data pf_revenue
			$type_revenue=$_POST['type_revenue'];
			$type2_revenue=$_POST['type2_revenue'];
			$desc_revenue=$_POST['desc_revenue'];
			$revenue=$_POST['revenue'];
			$qty_revenue=$_POST['qty_revenue'];

		// Data pf_est_cost
			$type_est_cost=$_POST['type_est_cost'];
			$desc_est_cost=$_POST['desc_est_cost'];
			$est_cost=$_POST['est_cost'];
			$qty_est_cost=$_POST['qty_est_cost'];

			$query = "INSERT INTO pf (user_pf, no_pf, tgl_pf, cust_name,address_pf, cust_ref, cust_code, pic, phone, shipment, qty_pf, type_qty, route_pf, pudel_date, pudel_location, sales, ct, sf, vv, etb_etd, openstack, ctc, ctd, bl_number)
			VALUES('$user_pf','$no_pf','$tgl_pf','$cust_name','$address_pf','$cust_ref','$cust_code','$pic','$phone','$shipment','$qty_pf','$type_qty','$route_pf','$pudel_date','$pudel_location','$sales','$ct','$sf','$vv','$etb_etd','$openstack','$ctc','$ctd','$bl_number')";
			$sql = mysql_query ($query) or die (mysql_error());
			$last_id = mysql_insert_id();

			for($x=0; $x < count($desc_sor); $x++) {
				$query="INSERT INTO pf_sor (id_pf, desc_sor) VALUES ('$last_id','$desc_sor[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($type_revenue); $x++) {
				$query="INSERT INTO pf_revenue (id_pf, type_revenue, type2_revenue, desc_revenue, revenue, qty_revenue) VALUES ('$last_id','$type_revenue[$x]','$type2_revenue[$x]','$desc_revenue[$x]','$revenue[$x]','$qty_revenue[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			for($x=0; $x < count($type_est_cost); $x++) {
				$query="INSERT INTO pf_est_cost (id_pf, type_est_cost, desc_est_cost, est_cost, qty_est_cost) VALUES ('$last_id','$type_est_cost[$x]','$desc_est_cost[$x]','$est_cost[$x]','$qty_est_cost[$x]')";
				$sql= mysql_query ($query) or die (mysql_error());
			}

			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
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
									   route_pf = '$_GET[route_pf]',
									   pudel_date = '$_GET[pudel_date]',
									   pudel_location = '$_GET[pudel_location]',
									   sales = '$_GET[sales]',
									   ct = '$_GET[ct]',
									   sf = '$_GET[sf]',
									   vv = '$_GET[vv]',
									   etb_etd = '$_GET[etb_etd]',
									   openstack = '$_GET[openstack]',
									   ctc = '$_GET[ctc]',
									   ctd = '$_GET[ctd]',
									   bl_number = '$_GET[bl_number]'
						WHERE id_pf = $_GET[id]") 	or die(mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}
		// Update user
		elseif ($module=='proforma' AND $act=='update_sor'){
		
			mysql_query("UPDATE pf_sor SET desc_sor = '$_GET[desc_sor]' WHERE id_pf_sor = $_GET[id]");

			header('location:../../oklogin.php?module='.$module);
		}
		//Update Revenue
		elseif ($module=='proforma' AND $act=='update_revenue'){
		
			mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]' 
									   
						WHERE id_pf_revenue = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		//Update est_cost
		elseif ($module=='proforma' AND $act=='update_est_cost'){
		
			mysql_query("UPDATE pf_est_cost SET type_est_cost = '$_GET[type_est_cost]',
									   desc_est_cost = '$_GET[desc_est_cost]',
									   est_cost = '$_GET[est_cost]',
									   qty_est_cost= '$_GET[qty_est_cost]' 
									   
						WHERE id_pf_est_cost = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}
		// Update user
		elseif ($module=='proforma' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM users_level WHERE  id_users_level = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
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
							<td colspan="2" align="left"><?=$hasil['tgl_pf']?></td>
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
							<td colspan="2" align="left"><?=$hasil['qty_pf']?></td>
							<td colspan="2">VESEL/VOYAGE</td>
							<td colspan="2"><?=$hasil['vv']?></td>
						</tr>
						<tr>
							<td colspan="2">ROUTE</td>
							<td colspan="2"><?=$hasil['route_pf']?></td>
							<td colspan="2">ETB/ETD</td>
							<td colspan="2"><?=$hasil['etb_etd']?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL DATE</td>
							<td colspan="2" align="left"><?=$hasil['pudel_date']?></td>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2" align="left"><?=$hasil['openstack']?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL LOCATION</td>
							<td colspan="2"><?=$hasil['pudel_location']?></td>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2" align="left"><?=$hasil['ctc']?></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td colspan="2"></td>
							<td colspan="2">CLOSING TIME DOCUMent</td>
							<td colspan="2" align="left"><?=$hasil['ctd']?></td>
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
							$query2=mysql_query("select * from pf_revenue where id_pf='$id_pf' and type_revenue='ALL IN RATE'");
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
		elseif ($module=='proforma' AND $act=='print'){
			$id_pf=$_GET['id'];			
		?>
		
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
					<h1>Proforma</h1>
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
							<td><?= $hasil['tgl_pf'] ?></td>
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
						if ($hasil['shipment']!="EMKL IMPORT"){ 
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
							<td>QUANTITY</td>
							<td>:</td>
							<td><?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?></td>
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
							<td><?= $hasil['etb_etd'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL DATE</td>
							<td>:</td>
							<td><?= $hasil['pudel_date'] ?></td>
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?= $hasil['openstack'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>
							<td>:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= $hasil['ctc'] ?></td>
						</tr>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= $hasil['ctd'] ?></td>
						</tr>
						<?php } else { ?>
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
							<td>QUANTITY</td>
							<td>:</td>
							<td><?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?></td>
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
							<td><?= $hasil['etb_etd'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL DATE</td>
							<td>:</td>
							<td><?= $hasil['pudel_date'] ?></td>
							<td></td>
							<td>B/L NUMBER</td>
							<td>:</td>
							<td><?= $hasil['bl_number'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>
							<td>:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
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
							<td colspan="3">SPECIAL ORDER REQUEST :</td>
						</tr>
						<?php
							$no_sor=1;
							$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
							while ($hasil1=mysql_fetch_array($query1)){
								$id_pf_sor=$hasil1['id_pf_sor'];
						?>
						<tr>
							<td></td>
							<td colspan="3"><?=$no_sor?>. <?=$hasil1['desc_sor']?></td>
						</tr>
						<?php $no_sor++; }?>
					</table>	
							</p>
									
									<?php
										$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf and type_revenue='ALL IN RATE' ");
										$hasil_type1=mysql_fetch_array($type1);
									?>
									<a>REVENUE | <?=$hasil_type1['type_revenue']?></a>
									<table border="1">
										<tr>
											<th>NO</th>
											<!--<th>TYPE</th>-->
											<th>DESCRIPTION</th>
											<th>REVENUE</th>
											<th>QTY</th>
											<th>SUM</th>
										</tr>
									
										<?php
										$no_job=1;	
										$sum_revenue=0;		
										$total_revenue=0;				
										$query2 = mysql_query("select * from pf_revenue where id_pf=$id_pf and type_revenue='ALL IN RATE' order by id_pf_revenue asc");
										while ($hasil2 = mysql_fetch_array($query2)) { 	
											$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
											$id_pf_revenue=$hasil2['id_pf_revenue'];
										?>	
										<tr>					
											<td align="center"><?=$no_job?></td>
											<!--<td><?=$hasil2['type2_revenue']?></td>-->
											<td><?=$hasil2['desc_revenue']?></td>
											<td align="right"><?=number_format($hasil2['revenue'])?></td>
											<td align="center"><?=$hasil2['qty_revenue']?></td>
											<td align="right"><?=number_format($sum_revenue)?></td>
										</tr>

										<?php
											$total_revenue=$sum_revenue++;
											$no_job++; 
										}?>	
									</table>
									</p>
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
									</p>
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
								</div>		
							</div>
						</div>
					</div>
      			</div>
			</section>		
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
			
			
		<?php
			
		}
	}
?>
