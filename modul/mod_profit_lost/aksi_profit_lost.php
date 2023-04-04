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
		
	
		// Input user
		if ($module=='profit_lost' AND $act=='input_sales_fee'){
			$nm_sales=$_POST['nm_sales'];
			$desc_sales_fee=$_POST['desc_sales_fee'];
			$value_sales_fee=$_POST['value_sales_fee'];
		
		for($x=0; $x < count($desc_sales_fee); $x++) {	
			$query="INSERT INTO sales_fee (id_pf,nm_sales,desc_sales_fee,value_sales_fee) VALUE ('$id_pf','$nm_sales[$x]','$desc_sales_fee[$x]','$value_sales_fee[$x]')";
			$sql= mysql_query ($query) or die (mysql_error());	
		}
			header('location:../../oklogin.php?module='.$module.'&act=pl&id='.$id_pf);
		}

		elseif ($module=='profit_lost' AND $act=='delete_profit_lost'){

			$id_pf=$_GET['id_pf'];
			$id_sales_fee=$_GET['id'];
			mysql_query("DELETE FROM sales_fee WHERE  id_sales_fee = " .$id_sales_fee);

			header('location:../../oklogin.php?module='.$module.'&act=pl&id='.$id_pf);
		}
		// Update jurnal_keu
		elseif ($module=='profit_lost' AND $act=='update_profit_lost'){
			$id_pf=$_GET['id_pf'];
		
			mysql_query("UPDATE sales_fee SET desc_sales_fee = '$_GET[desc_sales_fee]',
									   nm_sales = '$_GET[nm_sales]',
									   value_sales_fee = '$_GET[value_sales_fee]'
						WHERE id_sales_fee = $_GET[id]") 	or die(mysql_error());

			header('location:../../oklogin.php?module='.$module.'&act=pl&id='.$id_pf);
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
		elseif ($module=='profit_lost' AND $act=='status_ops'){
			$id_pf=$_GET['id_pf'];
			$id_pf_log=$_GET['id_pf_log'];
			mysql_query("UPDATE pf_log SET status_ops='COMPLETED' where id_pf_log=$id_pf_log");
			header('location:../../oklogin.php?module='.$module);
		}
		elseif ($module=='profit_lost' AND $act=='saveexcel'){
			//Start
			$id_pf=$_GET['id_pf'];
			$id_pf_log=$_GET['id_pf_log'];	
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=profit_lost($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");

			?>
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
			<!-- Content Page -->
			<div class="box box-default">
            <?php 
                $query=mysql_query("select * from pf where id_pf=$id_pf");
                $hasil = mysql_fetch_array($query);
                
                $rev=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");

        		$est_cost=mysql_query("select * from pf_est_cost where id_pf_log=$id_pf_log");
        
        		$real_cost=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
            ?>
			<div class="box-header with-border">
				<h3 class="box-title"><b>JOB ORDER NUMBER : <?=$hasil['no_jo']?></b></h3>
				<h3 class="box-title"><b>CUSTOMER NAME : <?=$hasil['cust_name']?></b></h3>
			</div>

				<div class="box-body" id="page">
					<div class="table-responsive">
						<div class="col-sm-8">
							<div class="box-header with-border">
								<h3 class="box-title">PROFIT AND LOST</h3>
							</div>
							<table class="table" border="1">
								<thead>
									<tr>
										<td><b>1</b></td>
										<td colspan="4"><b>REVENUE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>DESCRIPTION</th>
										<th>VALUE (IDR)</th>
										<th>QTY</th>
										<th>JUMLAH</th>										
									</tr>
									
								</thead>
								<tbody>
									
									<?php
										//Total Revenue
										$total_revenue=0;
										$jml_revenue=0;
									    $no_rev=1;
									    while($hasilrev=mysql_fetch_array($rev)){
                        					$jml_revenue=$hasilrev['revenue']*$hasilrev['qty_revenue'];
                        					$total_revenue=$total_revenue+$jml_revenue;
									?>
    									<tr>
    									    <td>1.<?=$no_rev?></td>
    									    <td><?=$hasilrev['desc_revenue']?></td>
    									    <td align="right"><?=number_format($hasilrev['revenue'])?></td>
    									    <td align="center"><?=number_format($hasilrev['qty_revenue'])?></td>
    									    <td align="right"><?=number_format($jml_revenue)?></td>
    									</tr>
									<?php $no_rev++; } ?>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL</b></td>
									    <td></td>									    
									    <td align="right"><b><?=number_format($total_revenue)?></b></td>
									</tr>
									
									
									<tr>
										<td><b>2</b></td>
										<td colspan="3"><b>TOTAL REAL COST</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>KEGIATAN</th>
										<th>STAKEHOLDER</th>
										<th>VALUE</th>																				
									</tr>
									<?php
									    $no_rc=1;
										$jml_real_cost=0;
										$total_real_cost=0;
									    while($hasilrealcost=mysql_fetch_array($real_cost)){
                        					$jml_real_cost=$hasilrealcost['real_cost'];
                        					$total_real_cost=$total_real_cost+$jml_real_cost;
									?>
									<tr>
										<td>2.<?=$no_rc?></td>
										<td><?=$hasilrealcost['kegiatan']?></td>
										<td><?=$hasilrealcost['stakeholder']?></td>										
										<td align="right"><?=number_format($hasilrealcost['real_cost'])?></td>
									</tr>
									
								 	<?php $no_rc++; } ?>
								 	<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL VALUE</b></td>									    
									    <td align="right"><b><?=number_format($total_real_cost)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>GROSS PROFIT AND LOST</b></td>									    
									    <td align="right"><b><?=number_format($total_revenue-$total_real_cost)?></b></td>
									</tr>
									<tr>
										<td><b>3</b></td>
										<td colspan="3"><b>SALES FEE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>NAMA SALES FEE</th>
										<th>DESCRIPTION SALES FEE</th>
										<th>VALUE</th>																				
									</tr>
									<?php
									    $no_sf=1;
										$total_sales_fee=0;
										$jml_sales_fee=0;
									    $sales_fee=mysql_query("select * from sales_fee where id_pf=$id_pf");
									    while($hasilsalesfee=mysql_fetch_array($sales_fee)){
                        					$jml_sales_fee=$hasilsalesfee['value_sales_fee'];
                        					$total_sales_fee=$total_sales_fee+$jml_sales_fee;
                        					$id_sales_fee=$hasilsalesfee['id_sales_fee'];
									?>
									<tr>
										<td>3.<?=$no_sf?></td>
										<td><?=$hasilsalesfee['nm_sales']?></td>
										<td><?=$hasilsalesfee['desc_sales_fee']?></td>										
										<td align="right"><?=number_format($jml_sales_fee)?></td>
									</tr>
									
								 	<?php $no_sf++; } ?>
								 	<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL SALES FEE (-)</b></td>									    
									    <td align="right"><b><?=number_format($total_sales_fee)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>NET PROFIT AND LOST</b></td>									    
									    <td align="right"><b><?=number_format($total_revenue-$total_real_cost-$total_sales_fee)?></b></td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
		<?php }
		//Save to Excel
		elseif ($module=='profit_lost' AND $act=='excel'){
			//Start
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=profit_lost($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		
		?>
			
			<body>
                <table border="1">
											<thead>
												<tr>
													<th>NO</th>
													<th>PROFORMA NUMBER</th>
													<th>JOB ORDER NUMBER</th>
													<th>STATUS</th>
													<th>TOTAL REVENUE</th>
													<th>TOTAL EST COST</th>
													<th>TOTAL OP CASH</th>
													<th>TOTAL OP AP</th>
													<th>SALES FEE</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												$query=mysql_query('select * from pf order by tgl_pf desc , no_pf desc');
												while($hasil=mysql_fetch_array($query)){
													if(!empty($hasil['aprove'])and $hasil['aprove']!='batal' ){
														$id_pf=$hasil['id_pf'];
														
														//Total Revenue
														$total_revenue=0;
														$jml_revenue=0;
														$query1=mysql_query("select * from pf_revenue where id_pf=$id_pf order by id_pf_revenue desc");
														while($hasil1=mysql_fetch_array($query1)){
															
															$jml_revenue=$hasil1['revenue']*$hasil1['qty_revenue'];
															$total_revenue=$total_revenue+$jml_revenue;
														}

														//Total Est Cost
														$total_est_cost=0;
														$jml_est_cost=0;
														$query3=mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost desc");
														while($hasil3=mysql_fetch_array($query3)){
															$jml_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost'];
															$total_est_cost=$total_est_cost+$jml_est_cost;
														}

														$jml_value=0;
														$query6=mysql_query("select * from sales_fee where id_pf=$id_pf");
														while($hasil6=mysql_fetch_array($query6)){
															$value=$hasil6['value_sales_fee'];
															$jml_value=$jml_value+$value;
														}
														
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasil['no_pf']?></td>
													<td><b><?=$hasil['no_jo']?></b></td>
													<td>
													<?php
														$query5=mysql_query("select status_pf_operasional from pf_operasional where id_pf=$id_pf and id_pf_operasional!='-' order by id_pf_operasional desc limit 1 ");
														$hasil5=mysql_fetch_array($query5);
													?>
														<?=$hasil5['status_pf_operasional']?>
													</td>
													<td><?=number_format($total_revenue)?></td>
													<td><?=number_format($total_est_cost)?></td>
													<td>
													<?php
														$query4=mysql_query("select sum(real_cost) as jml_real_cost from pf_real_cost where id_pf=$id_pf and category1='OP KAS' and id_est_cost!='0'");
														$hasil4=mysql_fetch_array($query4);
														$total_real_cost=$hasil4['jml_real_cost'];
													?>
														<?=number_format($total_real_cost)?>
													</td>
													<td>
													<?php
														$query4=mysql_query("select sum(real_cost) as jml_real_cost from pf_real_cost where id_pf=$id_pf and category1='OP AP'");
														$hasil4=mysql_fetch_array($query4);
														$total_real_cost=$hasil4['jml_real_cost'];
													?>
														<?=number_format($total_real_cost)?>
													</td>
													<td><?=number_format($jml_value)?></td>
													
												</tr>
												<?php $no++; } } ?>
											</tbody>	
												
										</table>
			</body>
			<?php
		}
		//Print 
		elseif ($module=='profit_lost' AND $act=='print_pl'){
			error_reporting(0); 
			$id_pf=$_GET['id_pf'];
			$id_pf_log=$_GET['id_pf_log'];			
		?>
		
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>

			<style type="text/css">
			@page {
			size: A4;
			size: portrait; 
			margin: 5mm 5mm 5mm;
			font-size:10px;
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
        <div class="box box-default">
            <?php 
                $query=mysql_query("select * from pf where id_pf=$id_pf");
                $hasil = mysql_fetch_array($query);
                
                $rev=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");

        		$est_cost=mysql_query("select * from pf_est_cost where id_pf_log=$id_pf_log");
        
        		$real_cost=mysql_query("select * from pf_real_cost as prc join pf_est_cost as pec on prc.id_est_cost=pec.id_pf_est_cost where prc.id_pf_log=$id_pf_log and no_reff_keu NOT LIKE '%_AP' and no_reff_keu LIKE 'BBK%'");
            ?>
			<div class="box-header with-border">
				<h3 class="box-title"><b>JOB ORDER NUMBER : <?=$hasil['no_jo']?></b></h3>
				<h3 class="box-title"><b>CUSTOMER NAME : <?=$hasil['cust_name']?></b></h3>
			</div>

				<div class="box-body" id="page">
					<div class="table-responsive">
						<div class="col-sm-8">
							<div class="box-header with-border">
								<h3 class="box-title">PROFIT AND LOST</h3>
							</div>
							<table class="table" border="1">
								<thead>
									<tr>
										<td><b>1</b></td>
										<td colspan="4"><b>REVENUE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>DESCRIPTION</th>
										<th>VALUE (IDR)</th>
										<th>QTY</th>
										<th>JUMLAH</th>										
									</tr>
									
								</thead>
								<tbody>
									
									<?php
										//Total Revenue
										$total_revenue=0;
										$jml_revenue=0;
									    $no_rev=1;
									    while($hasilrev=mysql_fetch_array($rev)){
                        					$jml_revenue=$hasilrev['revenue']*$hasilrev['qty_revenue'];
                        					$total_revenue=$total_revenue+$jml_revenue;
									?>
    									<tr>
    									    <td>1.<?=$no_rev?></td>
    									    <td><?=$hasilrev['desc_revenue']?></td>
    									    <td align="right"><?=number_format($hasilrev['revenue'])?></td>
    									    <td align="center"><?=number_format($hasilrev['qty_revenue'])?></td>
    									    <td align="right"><?=number_format($jml_revenue)?></td>
    									</tr>
									<?php $no_rev++; } ?>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL</b></td>
									    <td></td>									    
									    <td align="right"><b><?=number_format($total_revenue)?></b></td>
									</tr>
									
									
									<tr>
										<td><b>2</b></td>
										<td colspan="3"><b>TOTAL REAL COST</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>KEGIATAN</th>
										<th>STAKEHOLDER</th>
										<th>VALUE</th>																				
									</tr>
									<?php
									    $no_rc=1;
										$jml_real_cost=0;
										$total_real_cost=0;
									    while($hasilrealcost=mysql_fetch_array($real_cost)){
                        					$jml_real_cost=$hasilrealcost['real_cost'];
                        					$total_real_cost=$total_real_cost+$jml_real_cost;
									?>
									<tr>
										<td>2.<?=$no_rc?></td>
										<td><?=$hasilrealcost['kegiatan']?></td>
										<td><?=$hasilrealcost['stakeholder']?></td>										
										<td align="right"><?=number_format($hasilrealcost['real_cost'])?></td>
									</tr>
									
								 	<?php $no_rc++; } ?>
								 	<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL VALUE</b></td>									    
									    <td align="right"><b><?=number_format($total_real_cost)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>GROSS PROFIT AND LOST</b></td>									    
									    <td align="right"><b><?=number_format($total_revenue-$total_real_cost)?></b></td>
									</tr>
									<tr>
										<td><b>3</b></td>
										<td colspan="3"><b>SALES FEE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>NAMA SALES FEE</th>
										<th>DESCRIPTION SALES FEE</th>
										<th>VALUE</th>																				
									</tr>
									<?php
									    $no_sf=1;
									    $sales_fee=mysql_query("select * from sales_fee where id_pf=$id_pf");
									    while($hasilsalesfee=mysql_fetch_array($sales_fee)){
                        					$jml_sales_fee=$hasilsalesfee['value_sales_fee'];
                        					$total_sales_fee=$total_sales_fee+$jml_sales_fee;
                        					$id_sales_fee=$hasilsalesfee['id_sales_fee'];
									?>
									<tr>
										<td>3.<?=$no_sf?></td>
										<td><?=$hasilsalesfee['nm_sales']?></td>
										<td><?=$hasilsalesfee['desc_sales_fee']?></td>										
										<td align="right"><?=number_format($jml_sales_fee)?></td>
									</tr>
									
								 	<?php $no_sf++; } ?>
								 	<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL SALES FEE (-)</b></td>									    
									    <td align="right"><b><?=number_format($total_sales_fee)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>NET PROFIT AND LOST</b></td>									    
									    <td align="right"><b><?=number_format($total_revenue-$total_real_cost-$total_sales_fee)?></b></td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
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
