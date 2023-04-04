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
		if ($module=='op_cash_jo' AND $act=='print_op_cash_jo'){
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
									<th>JO NUMBER</th>
									<th>NAMA CUSTOMER</th>
									<th>NO REFF KEUANGAN</th>
									<th>KEGIATAN</th>
									<th>STAKEHOLDER</th>
									<th>D</th>
									<th>K</th>										
									<th>ACTION</th>
								</tr>
							</thead>	
							<tbody>
								<?php
								$no=1;
									$qry_oc=mysql_query("select * from pf_real_cost as prc
									join pf_log as pl on prc.id_pf_log=pl.id_pf_log
									where prc.id_pf_log='$id_pf_log' and no_reff_keu like 'BBK%' and category1 IN ('OP CASH', 'BIAYA')  ");
									while ($hsl_oc=mysql_fetch_array($qry_oc)){
										$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
								?>
								<tr>
									<td><?=$no?></td>
									<td><?=$hsl_oc['tgl_pf_real_cost']?></td>
									<td><?=$hsl_oc['no_jo']?> - <?=$hsl_oc['id_pf_log']?></td>
									<td><?=$hsl_oc['cust_name']?></td>
									<td><?=$hsl_oc['no_reff_keu']?></td>
									<td><?=$hsl_oc['kegiatan']?></td>
									<td><?=$hsl_oc['stakeholder']?></td>
									<?php
										if($op_balik != '_AP'){
											$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
									?>
											<td><?=number_format($hsl_oc['real_cost'])?></td>
											<td></td>
									<?php        
										}else{
											$saldo_ob=$saldo_ob+$hsl_oc['real_cost'];
									?>       
											<td></td>
											<td><?=number_format($hsl_oc['real_cost'])?></td>
									<?php 
									} 
									$saldo_ak=$saldo_oc-$saldo_ob;
									?>
									
									<td><?=number_format($saldo_ak)?></td>
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
									<th>JO NUMBER</th>
									<th>NAMA CUSTOMER</th>
									<th>NO REFF KEUANGAN</th>
									<th>KEGIATAN</th>
									<th>STAKEHOLDER</th>
									<th>D</th>
									<th>K</th>										
									<th>ACTION</th>
								</tr>
							</thead>	
							<tbody>
								<?php
								$no=1;
									$qry_oc=mysql_query("select * from pf_real_cost as prc
									join pf_log as pl on prc.id_pf_log=pl.id_pf_log
									where prc.id_pf_log='$id_pf_log' and no_reff_keu like 'BBK%' and category1 IN ('OP CASH', 'BIAYA')  ");
									while ($hsl_oc=mysql_fetch_array($qry_oc)){
										$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
								?>
								<tr>
									<td><?=$no?></td>
									<td><?=$hsl_oc['tgl_pf_real_cost']?></td>
									<td><?=$hsl_oc['no_jo']?> - <?=$hsl_oc['id_pf_log']?></td>
									<td><?=$hsl_oc['cust_name']?></td>
									<td><?=$hsl_oc['no_reff_keu']?></td>
									<td><?=$hsl_oc['kegiatan']?></td>
									<td><?=$hsl_oc['stakeholder']?></td>
									<?php
										if($op_balik != '_AP'){
											$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
									?>
											<td><?=$hsl_oc['real_cost']?></td>
											<td></td>
									<?php        
										}else{
											$saldo_ob=$saldo_ob+$hsl_oc['real_cost'];
									?>       
											<td></td>
											<td><?=$hsl_oc['real_cost']?></td>
									<?php 
									} 
									$saldo_ak=$saldo_oc-$saldo_ob;
									?>
									
									<td><?=$saldo_ak?></td>
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
		elseif ($module=='gabungan' AND $act=='print_gabungan_all'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];
            $tgl_ak2=$_GET['tgl_ak2'];
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
					<div class="col-md-6">
						<h3 class="box-title"><b class="text-blue">Tabel Laporan Gabungan</b> dari tgl <strong><?=$tgl_aw?></strong> s/d <strong><?=$tgl_ak?></strong> </h3>
					</div>
					<div>                                        
						<b class="text-danger">TOTAL SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>                                        
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>Laporan</th>
								<th>Saldo</th>												                                                								
								<th>Jumlah</th>												                                                																
							</tr>
						</thead>
						<tbody>
											<tr>
												<td>1</td>
												<td>Kas Bank</td>
												<td>
													<?php
													$no=1;																												
														$qry=mysql_query("select * from bank where nama_bank != 'Kas Kecil'");
														while($hsl=mysql_fetch_array($qry)){
															$nama_bank=$hsl['nama_bank'];
															$qrysaldo=mysql_query("select * from saldo_bank where nm_bank = '$nama_bank' and tgl ='$tgl_ak2'");
															while($hsl_saldo=mysql_fetch_array($qrysaldo)){
																$saldo=$hsl_saldo['saldo'];																
															}
															$saldo_kas_bank=$saldo_kas_bank+$saldo;
														}
														echo number_format($saldo_kas_bank);															
													?>
													
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>2</td>
												<td>Type X</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost                                              
														where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log = 0 and category2 IN('BBK','BKK') and category1 = 'X' group by category2");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
															$kategori = $hsl_oc['category2'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = 'BBK' and category1 = 'X'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = 'BBM' and category1 = 'X'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_x=$saldo_x+$saldo_oc;
														}
														echo number_format($saldo_x);
													?>																										
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>3</td>
												<td>Piutang</td>
												<td>
													<?php																										
														$qry_cust=mysql_query("select * from data_cust");
														while ($hsl_cust=mysql_fetch_array($qry_cust)){   
															$nm_cust = $hsl_cust['nm_cust'];
															$jml_piut=0;
															$jml_bbm=0;
															$saldo_piut=0;
															
															$qry_piut=mysql_query("select * from pf_real_cost as prc
															left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
															left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
															where pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT')");
															while ($hsl_piut=mysql_fetch_array($qry_piut)){
																$jml_piut=$jml_piut+$hsl_piut['real_cost'];
																$no_invoice = $hsl_piut['no_invoice'];
															
															$qry_bbm=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log
															where pl.cust_name = '$nm_cust' and category1='$no_invoice' and category2='BBM'");
															while ($hsl_bbm=mysql_fetch_array($qry_bbm)){
																$jml_bbm=$jml_bbm+$hsl_bbm['real_cost'];
															}                                                                                                                                                         
															}
															$saldo_piut=$jml_piut-$jml_bbm;
															$saldo_piutang=$saldo_piutang+$saldo_piut;
														}
															echo number_format($saldo_piutang);
													?>
													
												</td>
												<td></td>												
											</tr>
                                            <tr>
												<td>4</td>
												<td>OP Cash</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'OP CASH' group by prc.id_pf_log order by tgl_pf_real_cost asc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															$id_pf_log=$hsl_oc['id_pf_log'];
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP CASH'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'BIAYA'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_op_cash=$saldo_op_cash+$saldo_oc;
														}
														echo number_format($saldo_op_cash);
													?>
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>5</td>
												<td>OP AP</td>
												<td>
													<?php
													$no=1;
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AP','HUT') and prc.no_reff_keu not like 'BBK%'");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															if($op_balik != '_AP'){
																$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
															}else{
																$saldo_ob=$saldo_ob+$hsl_oc['real_cost'];
																} 
															$saldo_ak2=$saldo_oc-$saldo_ob;
														}
														echo number_format($saldo_ak2);
													?>																											
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>6</td>
												<td></td>												
												<td align="right"><strong>Jumlah :</strong></td>
												<td>
													<?php
														$total1 = $saldo_kas_bank+$saldo_x+$saldo_piutang+$saldo_op_cash+$saldo_op_ap;														
													?>
													<strong><?=number_format($total1);?></strong>
												</td>												
											</tr>
											<tr>
												<td>7</td>
												<td>Hutang</td>
												<td>
													<?php
													$no=1;
														$qry_ven=mysql_query("select * from data_vendor");                                                
														while ($hsl_ven=mysql_fetch_array($qry_ven)){
															$nama_ven = $hsl_ven['nm_vendor'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															$saldo_ob=0;
															
																$qry_oc=mysql_query("select * from pf_real_cost as prc
																join pf_log as pl on prc.id_pf_log=pl.id_pf_log
																where prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by id_pf_real_cost ");
																while ($hsl_oc=mysql_fetch_array($qry_oc)){
																	$no_reff_keu= $hsl_oc['no_reff_keu'];
																	$id_pf_log= $hsl_oc['id_pf_log'];
																	$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];

																	$qry_rc2=mysql_query("select * from pf_real_cost as prc
																	join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
																	where prc.id_pf_log = '$id_pf_log' and prc.id_hut = '$no_reff_keu' and category1='HUT' and category2='BBK'");
																	while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){																													
																		$saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
																	}
																	
																}
																$saldo_ak=$saldo_oc-$saldo_ob;                                                                                                
																$saldo_hutang=$saldo_hutang+$saldo_ak; 
														}
														echo number_format($saldo_hutang);
													?>
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>8</td>
												<td>Hutang Pajak</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost                                              
														where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log = 0 and category2 IN('HUT','BBK') and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%') group by category2 order by category2 desc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
															$kategori = $hsl_oc['category2'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															$saldo_ak2=0;
															if ($kategori == 'HUT') {
																$qryjml_oc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = '$kategori' and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%')");
																while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																	$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
																}
															}
															else {
																$qryjml_ob=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = '$kategori' and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%')");
																while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																	$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
																}
															}															
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_hutang_pajak=$saldo_hutang_pajak+$saldo_oc;
														}
														echo number_format($saldo_hutang_pajak);																
													?>																										
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>9</td>
												<td>OP AR</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'OP AR' group by prc.id_pf_log order by tgl_pf_real_cost asc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															$id_pf_log=$hsl_oc['id_pf_log'];
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP AR'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'DP' and category2 = 'BBM'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_op_ar=$saldo_op_ar+$saldo_oc;
														}
														echo number_format($saldo_op_ar);
													?>
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>10</td>
												<td></td>												
												<td align="right"><strong>Jumlah :</strong></td>
												<td>
													<?php
														$total2 = $saldo_hutang+$saldo_hutang_pajak+$saldo_op_ar;														
														$total_saldo = $total1 - $total2;
													?>
													<strong><?=number_format($total2);?></strong>
												</td>												
											</tr>
																																												
                                            <script>
                                                var x = "<?=number_format($total_saldo)?>";
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
		elseif ($module=='gabungan' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=GabunganAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div class="col-md-6">
			<h3 class="box-title"><b class="text-blue">Tabel Laporan Gabungan</b> dari tgl <strong><?=$tgl_aw?></strong> s/d <strong><?=$tgl_ak?></strong> </h3>
		</div>
		<div>                                        
			<b class="text-danger">TOTAL SALDO TERAKHIR : Rp. </b>
            <b id='jmlOpcash'></b>                                        
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>Laporan</th>
					<th>Saldo</th>												                                                								
					<th>Jumlah</th>												                                                													
				</tr>
			</thead>
			<tbody>
											<tr>
												<td>1</td>
												<td>Kas Bank</td>
												<td>
													<?php
													$no=1;																												
														$qry=mysql_query("select * from bank where nama_bank != 'Kas Kecil'");
														while($hsl=mysql_fetch_array($qry)){
															$nama_bank=$hsl['nama_bank'];
															$qrysaldo=mysql_query("select * from saldo_bank where nm_bank = '$nama_bank' and tgl ='$tgl_ak2'");
															while($hsl_saldo=mysql_fetch_array($qrysaldo)){
																$saldo=$hsl_saldo['saldo'];																
															}
															$saldo_kas_bank=$saldo_kas_bank+$saldo;
														}
														echo $saldo_kas_bank;															
													?>
													
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>2</td>
												<td>Type X</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost                                              
														where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log = 0 and category2 IN('BBK','BKK') and category1 = 'X' group by category2");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
															$kategori = $hsl_oc['category2'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = 'BBK' and category1 = 'X'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = 'BBM' and category1 = 'X'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_x=$saldo_x+$saldo_oc;
														}
														echo $saldo_x;
													?>																										
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>3</td>
												<td>Piutang</td>
												<td>
													<?php																										
														$qry_cust=mysql_query("select * from data_cust");
														while ($hsl_cust=mysql_fetch_array($qry_cust)){   
															$nm_cust = $hsl_cust['nm_cust'];
															$jml_piut=0;
															$jml_bbm=0;
															$saldo_piut=0;
															
															$qry_piut=mysql_query("select * from pf_real_cost as prc
															left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
															left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
															where pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT')");
															while ($hsl_piut=mysql_fetch_array($qry_piut)){
																$jml_piut=$jml_piut+$hsl_piut['real_cost'];
																$no_invoice = $hsl_piut['no_invoice'];
															
															$qry_bbm=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log
															where pl.cust_name = '$nm_cust' and category1='$no_invoice' and category2='BBM'");
															while ($hsl_bbm=mysql_fetch_array($qry_bbm)){
																$jml_bbm=$jml_bbm+$hsl_bbm['real_cost'];
															}                                                                                                                                                         
															}
															$saldo_piut=$jml_piut-$jml_bbm;
															$saldo_piutang=$saldo_piutang+$saldo_piut;
														}
															echo $saldo_piutang;
													?>
													
												</td>
												<td></td>												
											</tr>
                                            <tr>
												<td>4</td>
												<td>OP Cash</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'OP CASH' group by prc.id_pf_log order by tgl_pf_real_cost asc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															$id_pf_log=$hsl_oc['id_pf_log'];
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP CASH'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'BIAYA'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_op_cash=$saldo_op_cash+$saldo_oc;
														}
														echo $saldo_op_cash;
													?>
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>5</td>
												<td>OP AP</td>
												<td>
													<?php
													$no=1;
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AP','HUT') and prc.no_reff_keu not like 'BBK%'");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															if($op_balik != '_AP'){
																$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
															}else{
																$saldo_ob=$saldo_ob+$hsl_oc['real_cost'];
																} 
															$saldo_ak2=$saldo_oc-$saldo_ob;
														}
														echo $saldo_ak2;
													?>																											
												</td>
												<td></td>												
											</tr>
											<tr>
												<td>6</td>
												<td></td>												
												<td align="right"><strong>Jumlah :</strong></td>
												<td>
													<?php
														$total1 = $saldo_kas_bank+$saldo_x+$saldo_piutang+$saldo_op_cash+$saldo_op_ap;														
													?>
													<strong><?=$total1;?></strong>
												</td>												
											</tr>
											<tr>
												<td>7</td>
												<td>Hutang</td>
												<td>
													<?php
													$no=1;
														$qry_ven=mysql_query("select * from data_vendor");                                                
														while ($hsl_ven=mysql_fetch_array($qry_ven)){
															$nama_ven = $hsl_ven['nm_vendor'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															$saldo_ob=0;
															
																$qry_oc=mysql_query("select * from pf_real_cost as prc
																join pf_log as pl on prc.id_pf_log=pl.id_pf_log
																where prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by id_pf_real_cost ");
																while ($hsl_oc=mysql_fetch_array($qry_oc)){
																	$no_reff_keu= $hsl_oc['no_reff_keu'];
																	$id_pf_log= $hsl_oc['id_pf_log'];
																	$saldo_oc=$saldo_oc+$hsl_oc['real_cost'];

																	$qry_rc2=mysql_query("select * from pf_real_cost as prc
																	join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
																	where prc.id_pf_log = '$id_pf_log' and prc.id_hut = '$no_reff_keu' and category1='HUT' and category2='BBK'");
																	while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){																													
																		$saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
																	}
																	
																}
																$saldo_ak=$saldo_oc-$saldo_ob;                                                                                                
																$saldo_hutang=$saldo_hutang+$saldo_ak; 
														}
														echo $saldo_hutang;
													?>
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>8</td>
												<td>Hutang Pajak</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost                                              
														where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log = 0 and category2 IN('HUT','BBK') and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%') group by category2 order by category2 desc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){                                                    
															$kategori = $hsl_oc['category2'];                                                    
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															$saldo_ak2=0;
															if ($kategori == 'HUT') {
																$qryjml_oc=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = '$kategori' and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%')");
																while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																	$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
																}
															}
															else {
																$qryjml_ob=mysql_query("select * from pf_real_cost where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and id_pf_log= '0' and category2 = '$kategori' and (kegiatan LIKE '%PPH%' or kegiatan LIKE '%PPN%')");
																while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																	$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
																}
															}															
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_hutang_pajak=$saldo_hutang_pajak+$saldo_oc;
														}
														echo $saldo_hutang_pajak;																
													?>																										
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>9</td>
												<td>OP AR</td>
												<td>
													<?php
													$no=1;
													
														$qry_oc=mysql_query("select * from pf_real_cost as prc
														join pf_log as pl on prc.id_pf_log=pl.id_pf_log
														where prc.tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and category1 = 'OP AR' group by prc.id_pf_log order by tgl_pf_real_cost asc");
														while ($hsl_oc=mysql_fetch_array($qry_oc)){
															$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
															$id_pf_log=$hsl_oc['id_pf_log'];
															$jml_oc=0;
															$jml_ob=0;
															$saldo_oc=0;
															
															$qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP AR'");
															while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
																$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
															}
															$qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'DP' and category2 = 'BBM'");
															while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
																$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
															}
															$saldo_oc=$jml_oc-$jml_ob; 
															$saldo_op_ar=$saldo_op_ar+$saldo_oc;
														}
														echo $saldo_op_ar;
													?>
												</td>
												<td></td>
												
											</tr>
											<tr>
												<td>10</td>
												<td></td>												
												<td align="right"><strong>Jumlah :</strong></td>
												<td>
													<?php
														$total2 = $saldo_hutang+$saldo_hutang_pajak+$saldo_op_ar;														
														$total_saldo = $total1 - $total2;
													?>
													<strong><?=$total2;?></strong>
												</td>												
											</tr>
																																												
                                            <script>
                                                var x = "<?=number_format($total_saldo)?>";
                                                document.getElementById("jmlOpcash").innerHTML = x ;
                                            </script>
										</tbody>
		</table>
	<?php
		}
	}
?>
