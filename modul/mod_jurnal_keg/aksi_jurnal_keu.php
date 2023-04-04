<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";
		$id_user=$_SESSION['id_users'];
		$module=$_GET['module'];
		$act=$_GET['act'];
		$id_pf=$_GET['id_pf'];
		$id_pf_est_cost=$_GET['id'];
		$id_pf_revenue=$_GET['id_revenue'];


		// Input user
		if ($module=='jurnal_keu' AND $act=='tambah_real_cost'){
		
		$tgl_pf_real_cost=$_GET['tgl_real_cost'];
		$category1=$_GET['category1'];
		$category2=$_GET['category2'];
		$status_rc=$_GET['status_rc'];
		$status_keu=$_GET['status_keu'];
		$desc1=$_GET['desc1'];
		$desc2=$_GET['desc2'];
		$desc3=$_GET['desc3'];
		$desc4=$_GET['desc4'];
		$stakeholder=$_GET['stakeholder'];
		$real_cost=$_GET['real_cost'];
				
		$query="INSERT INTO pf_real_cost (id_pf,user_pf_real_cost,id_est_cost,id_revenue,tgl_pf_real_cost,category1,category2,status_rc,status_keu,desc1,desc2,desc3,desc4,stakeholder,real_cost) VALUE ('$id_pf','$id_user','$id_pf_est_cost','$id_pf_revenue','$tgl_pf_real_cost','$category1','$category2','$status_rc','$status_keu','$desc1','$desc2','$desc3','$desc4','$stakeholder','$real_cost')";
		$sql= mysql_query ($query) or die (mysql_error());	

			header('location:../../oklogin.php?module='.$module.'&act=jurnal&id='.$id_pf);
		}

		elseif ($module=='jurnal_keu' AND $act=='update_rc'){

			mysql_query("UPDATE pf_real_cost SET category1 = '$_GET[category1]',
											  	 category2 = '$_GET[category2]', 
											     status_rc = '$_GET[status_rc]',
												 desc1 = '$_GET[desc1]',
												 desc2 = '$_GET[desc2]',
												 desc3 = '$_GET[desc3]',
												 desc4 = '$_GET[desc4]',
												 stakeholder = '$_GET[stakeholder]',
												 real_cost = '$_GET[real_cost]'
						WHERE id_pf_real_cost = $_GET[id]");

			header('location:../../oklogin.php?module='.$module.'&act=jurnal&id='.$id_pf);
		}
		// Update jurnal_keu
		elseif ($module=='jurnal_keu' AND $act=='update_jurnal_keu'){
		
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
		// Update sor
		elseif ($module=='jurnal_keu' AND $act=='update_sor'){
		
			mysql_query("UPDATE pf_sor SET desc_sor = '$_GET[desc_sor]' WHERE id_pf_sor = $_GET[id]");

			header('location:../../oklogin.php?module='.$module);
		}
		//Update Revenue
		elseif ($module=='jurnal_keu' AND $act=='update_revenue'){
		
			mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]' 
									   
						WHERE id_pf_revenue = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		//Update est_cost
		elseif ($module=='jurnal_keu' AND $act=='update_rc'){
		
			mysql_query("UPDATE pf_real_cost SET type_est_cost = '$_GET[type_est_cost]',
									   desc_est_cost = '$_GET[desc_est_cost]',
									   est_cost = '$_GET[est_cost]',
									   qty_est_cost= '$_GET[qty_est_cost]' 
									   
						WHERE id_pf_est_cost = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus data
		elseif ($module=='jurnal_keu' AND $act=='delete_pf_real_cost'){
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM pf_real_cost WHERE  id_pf_real_cost = " .$_GET['id']);
		
			header('location:../../oklogin.php?module='.$module.'&act=jurnal&id='.$id_pf);
		}
		
		//Save to Excel
		elseif ($module=='jurnal_keu' AND $act=='excel'){
			//Start
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=jurnal_keu($date).xls");
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
				<br>
				<h5>REAL CUSTOMER</h5>
				<table>
					<tr>
						<th>NO</th>
						<th>REAL CUSTOMER NAME</th>
						<th>ADDRESS</th>
						<th>PHONE>
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
		elseif ($module=='jurnal_keu' AND $act=='print'){
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
					<h1>Jurnal Keuangan</h1>
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
					<a>REAL CUSTOMER</a>
					<table border="1">
						<tr>
							<th>NO</th>
							<th>REAL CUSTOMER NAME</th>
							<th>ADDRESS</th>
							<th>PHONE>
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
							</p>
									
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
