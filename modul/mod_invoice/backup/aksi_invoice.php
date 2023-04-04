<?php
	session_start();
	error_reporting(0);
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

		// Input user
		if ($module=='invoice' AND $act=='tambah_invoice'){
			$id_pf_log=$_POST['id_pf_log'];
			$id_pf_revenue=$_POST['id_pf_revenue'];
			$tgl_invoice=$_POST['tgl_invoice'];
			$no_invoice=$_POST['no_invoice'];
			$id_real_user=$_POST['id_real_user'];
			$ct_invoice=$_POST['ct_invoice'];
			$dpp=$_POST['dpp'];
			$ppn=$_POST['ppn'];
			if (!empty($_POST['checkdp'])) {
				$dp=$_POST['dp'];
			} else {
				
			}

			//echo $ppn; break;

			for($x=0; $x < count($id_pf_revenue); $x++) {	
				if($id_real_user=='0'){
					$id_user_order='rev'.$id_pf_revenue[$x];
				}else{
					$id_user_order=$id_real_user;
				}
				$query="INSERT INTO pf_invoice (id_pf_log,id_user,id_pf_revenue,tgl_invoice,no_invoice,id_real_user,id_user_order,ct_invoice,dpp,ppn,dp) VALUE ('$id_pf_log','$id_user','$id_pf_revenue[$x]','$tgl_invoice','$no_invoice','$id_real_user','$id_user_order','$ct_invoice','$dpp','$ppn','$dp')";
				$sql= mysql_query ($query) or die (mysql_error());	
			}
			mysql_query("UPDATE pf_log SET status_ops = 'INVOICING' WHERE id_pf_log = $id_pf_log") or die(mysql_error());;
			header('location:../../oklogin.php?module='.$module);
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
		elseif ($module=='invoice' AND $act=='delete_invoice'){
			$no_invoice=$_GET['no_invoice'];
			//echo $no_invoice; break;
			mysql_query("DELETE FROM pf_invoice WHERE  no_invoice = '$no_invoice' ");
		
			header('location:../../oklogin.php?module='.$module.'&act=jurnal&id='.$id_pf);
		}
		
		//Save to Excel
		elseif ($module=='invoice' AND $act=='excel'){
			//Start
			$date=date('ymd');
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=invoice($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
			<body>
				<table class="table" border="1">

					<tr>
						<th>NO</th>
						<th>NO. INVOICE</th>
						<th>INVOICE DATE</th>
						<th>SENT DATE</th>
						<th>JOB ORDER NUMBER</th>
						<th>PROFORMA NUMBER</th>
						<th>AJU NUMBER</th>
						<th>B/L NUMBER</th>
						<th>CUSTOMER REFF</th>
						<th>CUSTOMER CODE</th>
						<th>SHIPMENT</th>
						<th>QTY</th>
						<th>ROUTE</th>
						<th>SHIPPING/FORWARDING</th>
						<th>VESSEL/VOYAGE</th>
						<th>CREDIT TERM</th>
						<th>DUE DATE</th>
						<th>BEFORE TAX</th>
						<th>DPP</th>
						<th>PPN</th>
						<th>VALUE</th>
						<th>DATE PAYMENT</th>
						<th>PPH 23</th>
						<th>VALUE</th>
						<th>FINAL BALANCE</th>
					</tr>
					<?php
					$no=1;
						$qry=mysql_query("select * from pf_invoice as pi
						join pf_log on pi.id_pf_log=pf_log.id_pf_log
						join pf_qty on pi.id_pf_log=pf_qty.id_pf_log
						group by no_invoice order by tgl_invoice asc");
						while ($hsl=mysql_fetch_array($qry)){
							$dpp=$hsl['dpp'];
							$ppn=$hsl['ppn'];
							$no_inv=$hsl['no_invoice'];
					?>
					<tr>
						<td><?=$no?></td>
						<td><?=$hsl['no_invoice']?></td>
						<td><?=$hsl['tgl_invoice']?></td>
						<?php
							$sent_inv_date=mysql_query("select * from pf_real_cost as prc
							join pf_invoice as pi on prc.id_pf_invoice=pi.id_pf_invoice
							where no_invoice='$hsl[no_invoice]'");
							$hsl_sid=mysql_fetch_array($sent_inv_date);
							$ct=$hsl['ct'];
							$duedate=date('Y-m-d', strtotime("+$ct days",strtotime($hsl_sid['tgl_pf_real_cost'])));
						?>
						<td><?=$hsl_sid['tgl_pf_real_cost']?></td>
						<td><?=$hsl['no_jo']?></td>
						<td><?=$hsl['no_pf']?></td>
						<td><?=$hsl['aju_number']?></td>
						<td><?=$hsl['bl_number']?></td>
						<td><?=$hsl['cust_ref']?></td>
						<td><?=$hsl['cust_code']?></td>
						<td><?=$hsl['shipment']?></td>
						<?php 
							if ($hsl['qty'] != 0){
						?>
						<td><?=$hsl['qty']?></td>
						<?php }else{
						?>	
							<td><?=$hsl['type1']?></td>
						<?php } ?>
						<td><?=$hsl['route_pf']?></td>
						<td><?=$hsl['sf']?></td>
						<td><?=$hsl['vv']?></td>
						<td><?=$hsl['ct']?></td>
						<?php 
							if (!empty ($hsl_sid['tgl_pf_real_cost'])){
						?>
						<td><?=$duedate?></td>
						<?php }else{
						?>	
							<td></td>
						<?php } ?>
						
						
						<td align='right'>
							<?php
							
								$beforetax=0;
								$val_rev=mysql_query("select * from pf_invoice as pi 
								join pf_revenue as pr on pi.id_pf_revenue=pr.id_pf_revenue 
								where no_invoice='$hsl[no_invoice]'
								");
								while ($hsl_vr=mysql_fetch_array($val_rev)){
									$value=$hsl_vr['revenue']*$hsl_vr['qty_revenue'];
									$beforetax=$beforetax+$value;
									if($dpp=='0' and $ppn!='0'){
										$dpp_val=$beforetax;
									}else{
										$dpp_val=$beforetax*($dpp/100);
									}
									
									$ppn_val=$dpp_val*($ppn/100);
									$aftertax=$beforetax+$ppn_val;
								}
							?>
							<?=number_format($beforetax)?>
						
						</td>
						<td><?=number_format($dpp_val)?></td>
						<td><?=number_format($ppn_val)?></td>
						<td align='right'><?=number_format($aftertax)?></td>

						<?php
							$tgl_byr_inv=mysql_query("select * from pf_real_cost 
							where kegiatan like '%$no_inv%' ");
							$hsl_tbi=mysql_fetch_array($tgl_byr_inv); 
						?>
						<td><?=$hsl_tbi['tgl_pf_real_cost']?></td>

						<td></td>
						<td align='right'><?=number_format($hsl_tbi['real_cost'])?></td>
						<td></td>
					</tr>

					<?php
						$no++; }
					?>			
				</table>	
			</body>
			<?php
		}
		//Print 
		elseif ($module=='invoice' AND $act=='print'){
			$id_invoice=$_GET['id'];
			/*$query=mysql_query("select id_pf_revenue from pf_invoice");
			while ($hasil=mysql_fetch_array($query)){
			    echo $hasil['id_pf_revenue'];
			}
			 break;*/
			?>
		
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
			<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
			<!-- Font Awesome -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
			<!-- Ionicons -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
			<!-- Theme style -->
			<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
			<style type="text/css">
			@page {
			size: Legal;
			size: portrait; 
			margin: 15mm 10mm 15mm;
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
			<section class="invoice">
				<?php
					$query=mysql_query("SELECT * from pf_invoice where id_pf_invoice=$id_invoice");
					$hasil=mysql_fetch_array($query);
					$no_invoice=$hasil['no_invoice'];
					$id_real_user=$hasil['id_real_user'];
					$id_pf_log=$hasil['id_pf_log'];
					$id_pf_revenue=$hasil['id_pf_revenue'];					
				?>
					<!-- title row -->
					<div class="row">
						<div class="col-xs-12">
							<h2 class="page-header">
								<h3>INVOICE</h3>
							</h2>
						</div>
					</div>
					<?php
						$query2=mysql_query("SELECT * from pf_log where id_pf_log=$id_pf_log");
						$hasil2=mysql_fetch_array($query2);
						$no_order=$hasil2['no_pf'];
					?>
					<!-- info row -->
					<div class="row invoice-info">
						<!-- Address -->
						<div class="col-sm-4 invoice-col">
							<b>TO</b>
							<address>
							<?php
							
								if($hasil['id_real_user']!='0'){
									$query1=mysql_query("SELECT * from real_user where id_real_user=$id_real_user");
									$hasil1=mysql_fetch_array($query1);
									$nm_user=$hasil1['name_real_user'];
									$address_real_user=$hasil1['address_real_user'];
									$phone=$hasil1['phone_real_user'];
							?>
								<strong><?=$nm_user?></strong><br>
								<?=$address_real_user?><br>
								
							<?php } 		
								if($hasil['id_real_user']=='0'){
									$query1=mysql_query("SELECT * from pf_log where id_pf_log=$id_pf_log");
									$hasil1=mysql_fetch_array($query1);
									$nm_user=$hasil1['cust_name'];
									$address_user_order=$hasil1['address_pf'];
									
							?>
								<strong><?=$nm_user?></strong><br>
								<?=$address_user_order?><br>
							<?php } ?>
							</address>
						</div>
						<!-- Job Number -->
						<div class="col-sm-4 invoice-col">
							<b>SHIPMENT:</b> <?=$hasil2['shipment']?><br>
							<b>ROUTE:</b> <?=$hasil2['route_pf']?><br>
							<b>SHIPPING/FORWARDING:</b> <?=$hasil2['sf']?><br>
							<b>VESEL/VOYAGE :</b> <?=$hasil2['vv']?><br>
						</div>
						<!-- Pic dan Phone -->
						<div class="col-sm-4 invoice-col">
							<b>INVOICE :<?=$hasil['no_invoice']?></b><br>
							<b>INVOICE DATE:</b> <?=$hasil['tgl_invoice']?> <br>
							<b>JO NUMBER:</b> <?=$hasil2['no_jo']?><br>
							<b>VAT REG NUMBER :</b>01.963.507.7-607.001
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
					<div class="row invoice-info">
						<!-- Shipment -->	
						<div class="col-sm-4 invoice-col">
						<?php
							if($hasil['id_real_user']!='0'){
									$query1=mysql_query("SELECT * from real_user where id_real_user=$id_real_user");
									$hasil1=mysql_fetch_array($query1);		
							?>		
							<b>CUSTOMER REFF: </b><?=$hasil1['reff_cust']?> <br>
							<b>CUSTOMER CODE: </b><?=$hasil1['code_cust']?><br>
							<b>PIC: </b> <?=$hasil1['pic']?><br>
							<b>PHONE: </b> <?=$hasil1['phone_real_user']?>
							<?php } 
							if($hasil['id_real_user']=='0'){
									$query1=mysql_query("SELECT * from pf_log where id_pf_log=$id_pf_log");
									$hasil1=mysql_fetch_array($query1);		
							?>
							<b>CUSTOMER REFF: </b><?=$hasil1['cust_ref']?> <br>
							<b>CUSTOMER CODE: </b><?=$hasil1['cust_code']?><br>		
							<b>PIC: </b> <?=$hasil1['pic']?><br>
							<b>PHONE: </b> <?=$hasil1['phone']?>
							<?php } ?>
						</div>

						<div class="col-sm-4 invoice-col">
							<b>QUANTITY:</b>
							<?php 
							$queryQty = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
							while ($hasilQty = mysql_fetch_array($queryQty)) { ?>
								<?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?>,
							<?php } ?>
							<br>
							<?php
							$numPudelData=1;
							$queryPudel = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
							while ($hasilPudel = mysql_fetch_array($queryPudel)) { ?>
								<b>PU/DEL #<?=$numPudelData?>:</b> <?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?>, <?=$hasilPudel['pudel_from']?>/<?=$hasilPudel['pudel_to']?><br/>
							<?php $numPudelData ++; } ?>
						</div>
						<!-- B/L Number -->
						<div class="col-sm-4 invoice-col">							
							<b>B/L NUMBER:</b> <?=$hasil2['bl_number']?><br>
							<b>AJU NUMBER:</b> <?=$hasil2['aju_number']?><br>
							<?php
							$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
							$hasilct=mysql_fetch_array($query9);
							?>
							<b>CREDIT TERM: </b><?=$hasilct['ct_invoice']?> - Hari<br>
							<b>CURENCY: </b> IDR
						</div>
					<!-- /.col -->
					</div><br>
					<!-- /.row -->

					<!-- Table row -->
					<div class="row">
					<div class="col-xs-12 table-responsive">
						<table border="1" width="100%" class="table-bordered">
						<thead>
						<tr>
							<td><b>DETAIL ORDER</b></td>
							<td align="center"><b>IDR</b></td>
							<td align="center"><b>QTY</b></td>
							<td align="center"><b>AMOUNT</b></td>
						</tr>
						</thead>
						<tbody>
						<?php
							$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
							
							while ($hasil9=mysql_fetch_array($query9)){
								$id_pf_revenue2=$hasil9['id_pf_revenue'];
								$dpp_proc=$hasil9['dpp']/100;
								$ppn_proc=number_format($hasil9['ppn']/100,3);
								$dp=$hasil9['dp'];
								
								

								$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
								$hasil10=mysql_fetch_array($query10);
								$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
								$dpp=$subtotal*$dpp_proc;
								if($hasil9['dpp']==''){
									$ppn=$subtotal*$ppn_proc;
								}else{
									$ppn=$dpp*$ppn_proc;	
								}
								$total_inv=$subtotal+$ppn;
								?>
								<tr>
									<td><?=$hasil10['desc_revenue']?> - <?=$hasil10['pfi.dpp'];?></td>
									<td align="right"><?=number_format($hasil10['revenue'])?></td>
									<td align="center"><?=$hasil10['qty_revenue']?></td>
									<td align="right"><?=number_format($hasil10['revenue']*$hasil10['qty_revenue'])?></td>
								</tr>
							<?php
							}
								include_once('../../fungsi_terbilang2.php');
							?>		
						</tbody>
						</table>
					</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->

					<div class="row">
    					<div class="col-xs-8 pull-left">
    					   <b>DETAIL KONTAINER :</b> <br>
    					        <?php
    					            $queryjurnal = mysql_query("select * from jurnal_ops where id_pf_log=$id_pf_log");
    					            $hasilJur=mysql_fetch_array($queryjurnal);
    					            $typeops = $hasilJur['type2_ops'];
    					            if(empty($typeops)){
    					                $querynk=mysql_query("select * from detail as d 
									    join jurnal_ops as jo on d.id_jurnal_ops=jo.id_jurnal_ops 
									    where type_ops = 'TRANSPORTATION CHARGES' and jo.id_pf_log=$id_pf_log");
    					            }else{
    					                $querynk=mysql_query("select * from detail as d 
									    join jurnal_ops as jo on d.id_jurnal_ops=jo.id_jurnal_ops 
									    where type2_ops = 'TRANSPORTATION CHARGES' and jo.id_pf_log=$id_pf_log");
    					            }
    					            
    					            while ($hasilnk=mysql_fetch_array($querynk)){
    					       ?>
    					            <?=$hasilnk['no_kontainer']?>,

    					       <?php
    					            }
    					       ?>
    					    
    					</div>   
    					
    					<!-- accepted payments column -->
    					<div class="col-xs-4 pull-right">
    						<table class="pull-right">
    							<tr>
    							<th>Subtotal:</th>
    							<td></td>
    							<td align="right"><b><?=number_format($subtotal)?></b></td>
    							</tr>
    							<tr>
    							<?php
    									$qrydpp=mysql_query("select dpp from pf_invoice where no_invoice='$no_invoice'");
    									$hsldpp=mysql_fetch_array($qrydpp);
    								?> 
    							<th>DPP (<?=$hsldpp['dpp']?>%) :</th>
    							<td></td>
    							
    							<td align="right"><?=number_format($dpp)?></td>
    							</tr>
    							
    							<tr>
    								<?php
    									$qryppn=mysql_query("select ppn from pf_invoice where no_invoice='$no_invoice'");
    									$hslppn=mysql_fetch_array($qryppn);
    								?> 
    							<th>PPN (<?=$hslppn['ppn']?>%)</th>
    							<td></td>
    							<td align="right"><?=number_format($ppn)?></td>
    							</tr>
    							
    							<tr>
    							<th>Jumlah:</th>
    							<td></td>
    							<td align="right"><b><?=number_format($total_inv)?></b></td>
    							</tr>
    							<th>Uang Muka :</th>
    							<td></td>
    							<td align="right"><u><b><?=number_format($dp)?></b></u></td>
    							</tr>
    							</tr>
    							<th>TOTAL :</th>
    							<td></td>
    							<td align="right"><u><b><?=number_format($total_inv-$dp)?></b></u></td>
    							</tr>
    						</table>
    					</div>
    					<!-- /.col -->
					</div>
					<div class=row>
						<div class="col-xs-12" >
							<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							<b>SAY :</b> <i font-style: italic > <?=terbilang($total_inv)?> Rupiah- ## </i>
							</p>
						</div>
					</div>
					<div class='row'>
					
						<div class="col-xs-6">
							<i class="lead">Payment Methods:</i>
							<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							Account : PT. TERMINAL INTIMODA UTAMA <br>
							Bank Account : IDR - 2118885758<br>
							Bank Name : BNI KCP Surabaya Wonokromo<br><br>
							Account : PT. TERMINAL INTIMODA UTAMA <br>
							Bank Account : IDR - 140-0005512471<br>
							Bank Name : Bank Mandiri KCP Surabaya Pelabuhan Tanjung Perak<br><br>
							</p>
						</div>

						<div class="col-xs-6">
						<p class="lead">. </p>
						<p align="center" class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
							<br>
							<br>
							<br>
							<br>
							
							<br>
							<br>
							<br>
							<br>
							<b>( Authorized Signature )</b>
						</p>	
						</div>
					<!-- /.col -->
					</div>
					<!-- /.row -->
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
