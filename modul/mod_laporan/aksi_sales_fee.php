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
		$id_pf_log=$_GET['id'];
		

		// Input user
		if ($module=='cost' AND $act=='print_cost_jo'){
			?>
			<section class="content-header">
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
			<style type="text/css">
			@page {
			size: Legal;
			size: landscape; 
			margin: 5mm 5mm 5mm;
			font-size:8px;
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
			<div class="box-body">
						<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
													<th>DATE</th>	
													<th>NO REFF</th>														
													<th>TYPE COST</th>																																								
													<th>KEGIATAN</th>																																								
													<th>STAKEHOLDER</th>																																								
													<th>BUKTI</th>																																								
													<th>VALUE</th>																																								
													<th>TOTAL</th>
								</tr>
							</thead>	
							<tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
                                                    while ($hsl=mysql_fetch_array($qry_oc)){														                                                        
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
														<td><?=$hsl['tgl_pf_real_cost']?></td>														
														<td><?=$hsl['no_reff_keu']?></td>														
														<td><?=$hsl['category1']?></td>														
														<td><?=$hsl['kegiatan']?></td>														
														<td><?=$hsl['stakeholder']?></td>														
														<td><?=$hsl['bukti']?></td>																																																																						
														<td><?=number_format($hsl['real_cost'])?></td>																																																																						
														<td>
															<?php
																$saldo=$saldo+$hsl['real_cost'];
																echo number_format($saldo);
															?>
														</td>
                                                </tr>
                                                <?php $no++; } ?>
                                            </tbody>
						</table>
			</div>
		</section>
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				window.print();
				});
			</script>   
	<?php 
	break;
		
			
		}

		elseif ($module=='op_cash_jo' AND $act=='excel'){
			$id_pf_log=$_GET['id'];
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=OpCash($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
			<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
													<th>DATE</th>	
													<th>NO REFF</th>														
													<th>TYPE COST</th>																																								
													<th>KEGIATAN</th>																																								
													<th>STAKEHOLDER</th>																																								
													<th>BUKTI</th>																																								
													<th>VALUE</th>																																								
													<th>TOTAL</th>
								</tr>
							</thead>	
							<tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
                                                    while ($hsl=mysql_fetch_array($qry_oc)){														                                                        
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
														<td><?=$hsl['tgl_pf_real_cost']?></td>														
														<td><?=$hsl['no_reff_keu']?></td>														
														<td><?=$hsl['category1']?></td>														
														<td><?=$hsl['kegiatan']?></td>														
														<td><?=$hsl['stakeholder']?></td>														
														<td><?=$hsl['bukti']?></td>																																																																						
														<td><?=number_format($hsl['real_cost'])?></td>																																																																						
														<td>
															<?php
																$saldo=$saldo+$hsl['real_cost'];
																echo number_format($saldo);
															?>
														</td>
                                                </tr>
                                                <?php $no++; } ?>
                                            </tbody>
						</table>
		<?php
		}
		elseif ($module=='op_cash_jo' AND $act=='balik_op_kas'){
			$tgl=date("Y-m-d H:i:s");
			$act2=$_GET['act'];
			$id_op_ap=$_GET['id_pf_log'];			
			$op_ap=mysql_query("SELECT * from pf_real_cost as rc 
					left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
					left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost 
					where rc.id_pf_log=$id_op_ap and
					category1 = 'OP CASH' and
					bl = '0'");
			while($hasil_ap=mysql_fetch_array($op_ap)){
				$stakeholder=$hasil_ap['stakeholder'];
				$description=$hasil_ap['desc_est_cost'];
				$no_jo=$hasil_ap['no_jo'];

				mysql_query("UPDATE pf_real_cost SET bl = 1, updated_date='$tgl'
							WHERE id_pf_real_cost='$hasil_ap[id_pf_real_cost]'");				

				$query=mysql_query("INSERT INTO pf_real_cost (id_pf_log, user_pf_real_cost, id_est_cost, tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk,bl) 
									VALUE ('$id_op_ap','$id_user','$hasil_ap[id_est_cost]','$tgl','BIAYA','BBK','PENGAKUAN BIAYA ATAS $hasil_ap[no_reff_keu] JO $no_jo','$hasil_ap[no_reff_keu]_AP','$stakeholder','$hasil_ap[bukti]','$hasil_ap[real_cost]','$hasil_ap[bank]','D','1')") or die (mysql_error());
			}			

			header('location:../../oklogin.php?module='.$module.'&act='.$act);
		}
		// Update jurnal_keu
		elseif ($module=='cost' AND $act=='print_cost_all'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];
		?>
			<section class="content-header">
				<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
				<style type="text/css">
				@page {
				size: Legal;
				size: portrait; 
				margin: 5mm 5mm 5mm;
				font-size:8px;
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
					<div>
						<p>LAPORAN COST TIMU</p>
                        <b class="text-danger">TABEL COST SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>DATE</th>
								<th>JO NUMBER</th>												                                                
								<th>COST</th>
                                <th>SALDO COST</th>																							
							</tr>
						</thead>
						<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_revenue as prc
                                                join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' group by prc.id_pf_log order by tgl_pf asc");
                                                while ($hasil=mysql_fetch_array($qry_oc)){
                                                    if(!empty($hasil['aprove']) and $hasil['aprove']!='batal' ){
														$id_pf=$hasil['id_pf'];
														$id_pf_log=$hasil['id_pf_log'];
														
														//Total Revenue
														$total_revenue=0;
														$jml_revenue=0;                                                        
														$query1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log order by id_pf_revenue desc");
														while($hasil1=mysql_fetch_array($query1)){
															
															$jml_revenue=$hasil1['revenue']*$hasil1['qty_revenue'];
															$total_revenue=$total_revenue+$jml_revenue;                                                            
														}
                                                        $saldo_revenue = $saldo_revenue + $total_revenue;

														//Total Real Cost
														$total_real_cost=0;
														$jml_real_cost=0;
														$query3=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
														while($hasil3=mysql_fetch_array($query3)){
															$jml_real_cost=$hasil3['real_cost'];
															$total_real_cost=$total_real_cost+$jml_real_cost;
														}
                                                        $saldo_rc = $saldo_rc + $total_real_cost;

														$jml_value=0;
														$value=0;
														$query6=mysql_query("select * from sales_fee where id_pf=$id_pf");
														while($hasil6=mysql_fetch_array($query6)){
															$value=$value+$hasil6['value_sales_fee'];
															$jml_value=$jml_value+$value;
														}
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hasil['tgl_pf']?></td>
                                                <td><?=$hasil['no_jo']?></td>                                                                                                
                                                <td>
                                                    
                                                    <?=number_format($total_real_cost)?>
                                                </td>
                                                <td><?=number_format($saldo_rc)?></td>                                                
                                            </tr>
                                            <?php 
                                                $no++; } } 
                                                $jmlSaldoak=number_format($saldo_rc); 
                                            ?>
                                            <script>
                                                var x = "<?=$jmlSaldoak?>";
                                                document.getElementById("jmlOpcash").innerHTML = x ;
                                            </script>
										</tbody>
					</table>
			</section>	
			<script type="text/javascript">
				$(function () {				
				window.print();
				});
			</script> 			
		<?php
		}
		// Update sor
		elseif ($module=='cost' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=OpCashSubAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<p>LAPORAN COST TIMU</p>
            <b class="text-danger">TABEL COST </b>
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
								<th>DATE</th>
								<th>JO NUMBER</th>												                                                
								<th>COST</th>
                                <th>SALDO COST</th>	
				</tr>
			</thead>
			<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_revenue as prc
                                                join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' group by prc.id_pf_log order by tgl_pf asc");
                                                while ($hasil=mysql_fetch_array($qry_oc)){
                                                    if(!empty($hasil['aprove']) and $hasil['aprove']!='batal' ){
														$id_pf=$hasil['id_pf'];
														$id_pf_log=$hasil['id_pf_log'];
														
														//Total Revenue
														$total_revenue=0;
														$jml_revenue=0;                                                        
														$query1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log order by id_pf_revenue desc");
														while($hasil1=mysql_fetch_array($query1)){
															
															$jml_revenue=$hasil1['revenue']*$hasil1['qty_revenue'];
															$total_revenue=$total_revenue+$jml_revenue;                                                            
														}
                                                        $saldo_revenue = $saldo_revenue + $total_revenue;

														//Total Real Cost
														$total_real_cost=0;
														$jml_real_cost=0;
														$query3=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
														while($hasil3=mysql_fetch_array($query3)){
															$jml_real_cost=$hasil3['real_cost'];
															$total_real_cost=$total_real_cost+$jml_real_cost;
														}
                                                        $saldo_rc = $saldo_rc + $total_real_cost;

														$jml_value=0;
														$value=0;
														$query6=mysql_query("select * from sales_fee where id_pf=$id_pf");
														while($hasil6=mysql_fetch_array($query6)){
															$value=$value+$hasil6['value_sales_fee'];
															$jml_value=$jml_value+$value;
														}
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hasil['tgl_pf']?></td>
                                                <td><?=$hasil['no_jo']?></td>                                                                                                
                                                <td>
                                                    
                                                    <?=number_format($total_real_cost)?>
                                                </td>
                                                <td><?=number_format($saldo_rc)?></td>                                                
                                            </tr>
                                            <?php 
                                                $no++; } } 
                                                $jmlSaldoak=number_format($saldo_rc); 
                                            ?>
                                            <script>
                                                var x = "<?=$jmlSaldoak?>";
                                                document.getElementById("jmlOpcash").innerHTML = x ;
                                            </script>
										</tbody>
		</table>
	<?php
		}
	}
?>
