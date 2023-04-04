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
		$id_pf=$_POST['id_pf'];
		

		// Input user
		if ($module=='jurnal_keu2' AND $act=='tambah_real_cost'){
		$status_keu=$_POST['status_keu'];
		$id_invoice=$_POST['id_invoice'];
		$id_pf_est_cost=$_POST['id_pf_est_cost'];
		$id_pf_revenue=$_POST['id_pf_revenue'];
		$tgl_pf_real_cost=$_POST['tgl_real_cost'];
		$category1=$_POST['category1'];
		//$category2=$_POST['category2'];
		$kegiatan=$_POST['kegiatan'];
		$stakeholder=$_POST['stakeholder'];
		$real_cost=$_POST['real_cost'];
		
		
		$query="INSERT INTO pf_real_cost (id_pf,user_pf_real_cost,id_est_cost,id_revenue,id_invoice,tgl_pf_real_cost,category1,kegiatan,status_keu,stakeholder,real_cost) VALUE ('$id_pf','$id_user','$id_pf_est_cost','$id_pf_revenue','$id_invoice','$tgl_pf_real_cost','$category1','$kegiatan','$status_keu','$stakeholder','$real_cost')";
		$sql= mysql_query ($query) or die (mysql_error());	

        if(!empty($id_pf_est_cost)){
		    mysql_query("UPDATE pf_est_cost SET cek_est_cost='1' where id_pf_est_cost=$id_pf_est_cost");
		}
		
        if($status_keu!=""){
			mysql_query("UPDATE pf SET aprove='$status_keu' where id_pf=$id_pf");
		}
		
			header('location:../../oklogin.php?module='.$module);
		}

		elseif ($module=='jurnal_keu2' AND $act=='update_rc'){

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
		elseif ($module=='jurnal_keu2' AND $act=='update_jurnal_keu2'){
		
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
		elseif ($module=='jurnal_keu2' AND $act=='update_sor'){
		
			mysql_query("UPDATE pf_sor SET desc_sor = '$_GET[desc_sor]' WHERE id_pf_sor = $_GET[id]");

			header('location:../../oklogin.php?module='.$module);
		}
		//Update Revenue
		elseif ($module=='jurnal_keu2' AND $act=='update_revenue'){
		
			mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]' 
									   
						WHERE id_pf_revenue = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		//Update est_cost
		elseif ($module=='jurnal_keu2' AND $act=='update_rc'){
		
			mysql_query("UPDATE pf_real_cost SET type_est_cost = '$_GET[type_est_cost]',
									   desc_est_cost = '$_GET[desc_est_cost]',
									   est_cost = '$_GET[est_cost]',
									   qty_est_cost= '$_GET[qty_est_cost]' 
									   
						WHERE id_pf_est_cost = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus data
		elseif ($module=='jurnal_keu2' AND $act=='delete_pf_real_cost'){
		    
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM pf_real_cost WHERE  id_pf_real_cost = " .$_GET['id']);
			
			
			header('location:../../oklogin.php?module='.$module);
		}
		
		// Hapus data
		elseif ($module=='jurnal_keu2' AND $act=='hapus_gambar'){
			$check=$_POST["check"];
			$id_pf_real_cost=$_POST['id_pf_real_cost'];
			if(isset($_POST["check"])){
				
				for($x=0; $x < count($check); $x++) {
					mysql_query("DELETE FROM images_db WHERE id_images_db = $check[$x]");	
				}
			}
			
			header('location:../../oklogin.php?module='.$module.'&act=tambah_image&id='.$id_pf_real_cost);
		}
		elseif ($module=='jurnal_keu2' AND $act=='tambah_images'){
			if (isset($_POST['bupload'])){
				$id_pf=$_POST['id_pf'];
				$id_est_cost=$_POST['id_est_cost'];
				$id_pf_real_cost=$_POST['id_pf_real_cost'];
				
				$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg');
				$nm_file=$_FILES['nm_file']['name'];
				$x=explode('.',$nm_file);
				$ext=strtolower(end($x));
				$size=$_FILES['nm_file']['size'];
				$file_tmp=$_FILES['nm_file']['tmp_name'];

				if (in_array($ext,$ext_diperbolehkan)=== true){
					if($size < 10000000){
						move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file);

						$query="INSERT INTO images_db (id_pf, id_est_cost, id_pf_real_cost, nm_file) VALUES ('$id_pf','$id_est_cost','$id_pf_real_cost','$nm_file')";
						$sql= mysql_query ($query) or die (mysql_error());

					}else{
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				}else{
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
				
			}
		
			
			
			header('location:../../oklogin.php?module='.$module.'&act=tambah_image&id=&id='.$id_pf_real_cost);
		}
		//Save to Excel
		elseif ($module=='laporan_all' AND $act=='excel'){
			//Start
			
			$date=date('ymd');
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=jurnal_Laporan_all($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		

		?>
			
			<body>
			<table id="myTable" class="table table-bordered table-striped" border='1'>
									  <thead>

									  <tr>
										  <th>NO</th>
										  <th>DATE</th>
										  <th>NO PPL</th>
										  <th>JO NUMBER</th>
										  <th>CUST NAME</th>
										  <th>SHIPMENT</th>
										  <th>QUANTITY</th>
										  <th>ROUTE</th>
										  <th>AJU NUMBER</th>
										  <th>B/L NUMBER</th>
										  <th>SHIPPING/FORWARDING</th>
										  <th>VESEL/VOY</th>
										  <th>PU/DEL DATE</th>
										  <th>PU/DEL QTY</th>
										  <th>PU/DEL LOCATION</th>
										  <th>REVENUE</th>
										  <th>EST COST</th>
										  <th>REAL REVENUE</th>
										  <th>REAL COST</th>
										  <th>PROFIT/LOST</thz>
										  <th>SALES INSENTIVE</th>
										  <th>NET MARGIN</th>
										  <th>NO INVOICE</th>
										  <th>TGL INVOICE</th>
										  <th>VALUE</th>
										  <th>DPP</th>
										  <th>PPN</th>
										  <th>JML VALUE</th>
										  <th>DOWN PAYMENT</th>
										  <th>NET VALUE</th>
										  <th>CREDIT TERM</th>
										  <th>DUE DATE</th>	
										  <th>PAYMENT DATE</th>
										  <th>VALUE</th>
										  <th>PPH</th>
										  <th>NET VALUE</th>
										  <th>AKSI</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query=mysql_query("select * from pf_log where tgl_pf between '$tgl_aw' and '$tgl_ak' order by tgl_pf desc");
										while ($hasil=mysql_fetch_array($query)){
										?>
										<tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_pf']?></td>
											<td><?=$hasil['no_pf']?></td>
											<td><?=$hasil['no_jo']?></td>
											<td><?=$hasil['cust_name']?></td>
											<td><?=$hasil['shipment']?></td>
											<td>
											    <?php
												$qry_qty=mysql_query("select * from pf_qty where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_qty=mysql_fetch_array($qry_qty)){
												 echo $hsl_qty['qty']. "-" . $hsl_qty['type1']. "<br>";
												}
												?>
											</td>
											<td><?=$hasil['route_pf']?></td>
											<td><?=$hasil['aju_number']?></td>
											<td><?=$hasil['bl_number']?></td>
											<td><?=$hasil['sf']?></td>
											<td><?=$hasil['vv']?></td>
											<td>
											    <?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['pudel_date']. "<br>";
												}
												?>
											</td>
											<td>
											    <?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['qty']. "-" .$hsl_pudel['type1']."-".$hsl_pudel['type2']."<br>";
												}
												?>
											</td>
											<td>
												<?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['pudel_from']. " to " .$hsl_pudel['pudel_to']."<br>";
												}
												?>
											</td>
											<td>
												<?php
												$total_rev='0';
												$qry_rev=mysql_query("select * from pf_revenue where id_pf='$hasil[id_pf]'");
												while ($hsl_rev=mysql_fetch_array($qry_rev)){
													$jml_rev=$hsl_rev['revenue']*$hsl_rev['qty_revenue'];
													$total_rev=$total_rev+$jml_rev;
												}
												echo number_format($total_rev);
												?>
											</td>
											<td>
											<?php
												$total_ec='0';
												$qry_ec=mysql_query("select * from pf_est_cost where id_pf='$hasil[id_pf]'");
												while ($hsl_ec=mysql_fetch_array($qry_ec)){
													$jml_ec=$hsl_ec['est_cost']*$hsl_ec['qty_est_cost'];
													$total_ec=$total_ec+$jml_ec;
												}
												echo number_format($total_ec);
												?>
											</td> 
											<td>
												<?php
												$total_rev='0';
												$qry_rev=mysql_query("select * from pf_revenue where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_rev=mysql_fetch_array($qry_rev)){
													$jml_rev=$hsl_rev['revenue']*$hsl_rev['qty_revenue'];
													$total_rev=$total_rev+$jml_rev;
												}
												echo number_format($total_rev);
												?>
											</td>   
											<td>
												<?php
												$total_rc='0';
												$qry_rc=mysql_query("select * from pf_real_cost as prc join pf_est_cost as pec on prc.id_est_cost=pec.id_pf_est_cost where prc.id_pf_log=$hasil[id_pf_log]");
												while ($hsl_rc=mysql_fetch_array($qry_rc)){
													$jml_rc=$hsl_rc['real_cost'];
													$total_rc=$total_rc+$jml_rc;
												}
												echo number_format($total_rc);
												?>
											</td>   
											<td><?=number_format($total_rev-$total_rc)?></td> 
											<td>
												<?php
												$qry_fee=mysql_query("select * from sales_fee where id_pf_log='$hasil[id_pf_log]'");
												$hsl_fee=mysql_fetch_array($qry_fee);
												echo number_format($hsl_fee['value_sales_fee']);
												?>
											</td> 
											<td>
											<?=number_format($total_rev-$total_rc-$hsl_fee['value_sales_fee'])?>
											</td> 
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													echo $hsl_inv['no_invoice'].'<br>';
												}
												?>
											</td>   
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													echo $hsl_inv['tgl_invoice'].'<br>';
												}
												?>
											</td>    
											<td>
												<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													echo number_format($subtotal).'<br>';
												}
												
												?>
											</td>  
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													echo number_format($dpp).'<br>';
												}
												
												?>
											</td>   
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													echo number_format($ppn).'<br>';
												}
												?>
											</td> 
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													echo number_format($total_inv).'<br>';
												}
												?>
											</td>  
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													echo number_format($dp).'<br>';
												}
												?>
											</td>
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
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
													} 
													$net=$total_inv-$dp;
													echo number_format($net).'<br>';
												}
												?>
											</td>     
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													
													while ($hasil9=mysql_fetch_array($query9)){
														$ct=$hasil9['ct_invoice'];
													} 
													$net=$total_inv-$dp;
													echo ($ct).'<br>';
												}
												?>
											</td> 
											<td>
											<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													
													while ($hasil9=mysql_fetch_array($query9)){
														$ct=$hasil9['ct_invoice'];
														$tgl_inv=$hasil9['tgl_invoice'];
													} 
													$net=$total_inv-$dp;
													echo date("Y-m-d",strtotime("+$ct day",strtotime($tgl_inv))).'<br>'; 
												}
												?>
											</td>     
											 
											<td>
												<?php
												//	$qry_pay_inv=mysql_query("select * from pf_real_cost where id_pf=$hasil['id_pf'] and ");

												?>
											</td>
											<td></td>
											<td></td>  
											<td></td>                 
                                            <!--<td>
                                                <a class="btn btn-primary" onclick="location.href='<?php echo '?module=lap_jurnal_ops&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
                                            </td>-->
										</tr>
										
										
									  <?php
										
										 $no++; }
									  ?>
									  </tbody>
									</table>	
			</body>
			<?php
		}
		//Print 
		elseif ($module=='jurnal_keu2' AND $act=='print'){
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
