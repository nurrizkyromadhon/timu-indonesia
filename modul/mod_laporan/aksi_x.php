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
		if ($module=='x' AND $act=='print_x'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];	
			$kategori=$_GET['kategori'];
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
			<div class="box-header with-border">							
				<h3 class="box-title text-blue text-bold">Tabel Laporan X kategori <?= $kategori ?></h3>
			</div>
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
														$qry=mysql_query("select * from pf_real_cost                                              
                                                		where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'X' and category2 = '$kategori'");
														while($hsl=mysql_fetch_array($qry)){															
															$category=$hsl['category1'];															
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
													<?php $no++; } 
													$jmlSaldoak=number_format($saldo); ?>
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

		elseif ($module=='x' AND $act=='excel'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];	
			$kategori=$_GET['kategori'];
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=XKategori($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
			<div class="box-header with-border">							
				<h3 class="box-title text-blue text-bold">Tabel Laporan X kategori <?= $kategori ?></h3>
			</div>
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
														$qry=mysql_query("select * from pf_real_cost                                              
                                                		where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'X' and category2 = '$kategori'");
														while($hsl=mysql_fetch_array($qry)){															
															$category=$hsl['category1'];															
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
													<?php $no++; } 
													$jmlSaldoak=number_format($saldo); ?>
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
		elseif ($module=='x' AND $act=='print_x_all'){
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
						<p>LAPORAN X TIMU</p>
                        <b class="text-danger">TABEL X SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>KATEGORI</th>
								<th>SALDO X</th>	
								<th>TOTAL SALDO X</th>	
							</tr>
						</thead>
						<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_real_cost                                              
                                                where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category2 IN('BBK','BKK','BBM','BKM') and category1 = 'X' group by category2");
                                                while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
													$kategori = $hsl_oc['category2'];                                                    
                                                    $jml_rc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    
                                                    $qryjml_rc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category2 = '$kategori' and category1 = 'X'");
                                                    while ($hsljml_rc=mysql_fetch_array($qryjml_rc)){
                                                        $jml_rc=$jml_rc+$hsljml_rc['real_cost'];
                                                    }                                                                                                         
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_oc['category2']?> - <?=$hsl_oc['category1']?></td>                                                                                                
                                                <td><?=number_format($jml_rc);?></td>
                                                <td>
													<?php
													if ($kategori == 'BBK' or $kategori == 'BKK') {
														$saldo_ak=$saldo_ak+$jml_rc;
													}else{
														$saldo_ak=$saldo_ak-$jml_rc;
													}
													echo number_format($saldo_ak);
													?>
												</td>                                                
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak); 
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
		elseif ($module=='x' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=XAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<p>LAPORAN X TIMU</p>
            <b class="text-danger">TABEL X </b>
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>KATEGORI</th>
					<th>SALDO X</th>		
					<th>TOTAL SALDO X</th>		
				</tr>
			</thead>
			<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_real_cost                                              
                                                where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category2 IN('BBK','BKK','BBM','BKM') and category1 = 'X' group by category2");
                                                while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
													$kategori = $hsl_oc['category2'];                                                    
                                                    $jml_rc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    
                                                    $qryjml_rc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category2 = '$kategori' and category1 = 'X'");
                                                    while ($hsljml_rc=mysql_fetch_array($qryjml_rc)){
                                                        $jml_rc=$jml_rc+$hsljml_rc['real_cost'];
                                                    }                                                                                                         
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_oc['category2']?> - <?=$hsl_oc['category1']?></td>                                                                                                
                                                <td><?=number_format($jml_rc);?></td>
                                                <td>
													<?php
													if ($kategori == 'BBK' or $kategori == 'BKK') {
														$saldo_ak=$saldo_ak+$jml_rc;
													}else{
														$saldo_ak=$saldo_ak-$jml_rc;
													}
													echo number_format($saldo_ak);
													?>
												</td>                                                
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak); 
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
