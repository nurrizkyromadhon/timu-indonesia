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
		if ($module=='kas_bank' AND $act=='print_kas_bank_all'){
            $tgl_aw = $_GET['tgl_aw'];
            $tgl_ak = $_GET['tgl_ak'];
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
            <div>
                <b>LAPORAN KAS BANK TIMU</b><br>
                <b class="text-danger">TABEL KAS BANK SALDO TERAKHIR : Rp. </b>
                <b id='jmlOpcash'></b>                
            </div>
            
			<div class="box-body">
						<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
									<th>NAMA BANK</th>	
									<th>SALDO</th>	
									<th>TOTAL SALDO BANK</th>																														
								</tr>
							</thead>	
							<tbody>
								<?php
													$no=1;
														
														
														$qry=mysql_query("select * from bank where nama_bank != 'Kas Kecil'");
														while($hsl=mysql_fetch_array($qry)){
															$nama_bank=$hsl['nama_bank'];															
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$nama_bank?></td>														
														<td>
															<?php															
															$qrysaldo=mysql_query("select * from saldo_bank where nm_bank = '$nama_bank' and tgl ='$tgl_ak'");
															while($hsl_saldo=mysql_fetch_array($qrysaldo)){
																$saldo=$hsl_saldo['saldo'];																
															}
															echo number_format($saldo);
															?>
														</td>														
														<td>
															<?php							
																$jml_saldo=$jml_saldo+$saldo;									
																echo number_format($jml_saldo);
															?>
														</td>														
														
													</tr>
													<?php $no++; } 
													$jmlSaldoak=number_format($jml_saldo); ?>	
							</tbody>
						</table>                        
			</div>
		</section>
			<!-- JS Print -->
			<script type="text/javascript">
                var x = "<?=$jmlSaldoak?>";
                document.getElementById("jmlOpcash").innerHTML = x ;
				$(function () {				
				window.print();
				});
			</script>   
	<?php 
	break;					
		}

		elseif ($module=='kas_bank' AND $act=='excel'){
			$nama_bank=$_GET['nama_bank'];			
            $tgl_aw=$_GET['tgl_aw'];			
            $tgl_ak=$_GET['tgl_ak'];
            $tgl_str=date('d-M-Y',strtotime($tgl_saldo));
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=KasBank($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
            <div>							
				<h3>Tabel Laporan Kas Bank tanggal <?= $tgl_str ?></h3>
			</div>
			<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
									<th>TANGGAL</th>	
									<th>TOTAL SALDO BANK</th>
									<th>BBM</th>
									<th>BBK</th>	
									<th>SALDO</th>
								</tr>
							</thead>	
							<tbody>
								<?php
													$no=1;
														
														
														$qry=mysql_query("select *,sum(saldo) as jml_saldo from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' and nm_bank = '$nama_bank' group by tgl order by tgl DESC");
														while($hsl=mysql_fetch_array($qry)){
															$tgl_saldo=$hsl['tgl'];
															$jml_saldo=$hsl['jml_saldo'];
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$tgl_saldo?></td>
														<td><?=$jml_saldo?></td>
														<td>
															<?php
															$jml_bbm='0';
															$qrybbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBM%' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo' and bank = '$nama_bank'");
															while($hsl_bbm=mysql_fetch_array($qrybbm)){
																$bbm=$hsl_bbm['real_cost'];
																$jml_bbm=$jml_bbm+$bbm;
															}
															echo $jml_bbm;
															?>
														</td>
														<td>
														<?php
															$jml_bbk=0;
															$qrybbk=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBK%' and no_reff_keu not like '%_AP' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo' and bank = '$nama_bank'");
															while($hsl_bbk=mysql_fetch_array($qrybbk)){
																$bbk=$hsl_bbk['real_cost'];
																$jml_bbk=$jml_bbk+$bbk;
															}
															echo $jml_bbk;
														?>
														</td>
														<td>
															<?php
																$saldo=$jml_saldo+$jml_bbm-$jml_bbk;
																echo $saldo;
															?>
														</td>
															<?php
																$tglkemaren = date('Y-m-d', strtotime('-1 days', strtotime($tgl_saldo)));
															?>
														
													</tr>
													<?php $no++; } ?>
							</tbody>
						</table>
            <div>							
				<h3>Tabel Kegiatan Jurnal Keuangan Bank <?= $nama_bank ?></h3>
			</div>
			<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
									<th>DATE</th>
									<th>BANK</th>
									<th>INPUTAN SALDO</th>
									<th>KETERANGAN</th>
								    <th>VALUE</th>
								</tr>
							</thead>	
							<tbody>
								<?php
													    $noB=1;
														$qrytglinputsaldo=mysql_query("select * from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' and nm_bank = '$nama_bank'order by tgl desc");
														while ($hsltglinputsaldo=mysql_fetch_array($qrytglinputsaldo)){  
															$tglinputsaldo=$hsltglinputsaldo['tgl'];
													?>
														<tr>
															<td><?=$noB?></td>
															<td><?=$tglinputsaldo?></td>
															<td><?=$hsltglinputsaldo['nm_bank']?></td>
															<td class="text-right"><?=$hsltglinputsaldo['saldo']?></td>
															<td>
																<?php 
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																		?>
																			<p><?=$hslket['no_reff_keu']?> - <?=$hslket['kegiatan']?></p>
																		<?php	
																		}
																	}
																?> 
																<br><b>TOTAL :</b>
																<P><b>SALDO AKHIR : </b></P>
															</td>
															<td class="text-right">
																<?php 
																	$jmlD=0;
																	$jmlK=0;
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																			$nilai=$hslket['real_cost'];
																			$dk=$hslket['dk'];
																			if($dk == 'D'){
																				$jmlD=$jmlD+$nilai;
																			}else{
																				$jmlK=$jmlK+$nilai;
																			}
																		?>
																			<p><?=$hslket['real_cost']?> - (<?=$hslket['dk']?>)</p>
																		<?php	
																		}
																		$total=$jmlD-$jmlK;
																	} $saldoakh=$hsltglinputsaldo['saldo'] + $total ;
																?>
																<br><b><?=$total?></b> 
																<p><b><?=$saldoakh?></b></p>
															</td>
														</tr>
													<?php $noB++; } ?>	
							</tbody>
						</table>
		<?php
		}		
		// Update jurnal_keu
		elseif ($module=='kas_bank' AND $act=='print_kas_nama_bank'){
			$nama_bank=$_GET['nama_bank'];			
            $tgl_aw=$_GET['tgl_aw'];			
            $tgl_ak=$_GET['tgl_ak'];	
            $tgl_str=date('d-M-Y',strtotime($tgl_saldo));			
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
            <div>							
				<h3>Tabel Laporan Kas Bank <?= $nama_bank ?></h3>
			</div>
			<div class="box-body">
						<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
									<th>TANGGAL</th>	
									<th>TOTAL SALDO BANK</th>
									<th>BBM</th>
									<th>BBK</th>	
									<th>SALDO</th>									
								</tr>
							</thead>	
							<tbody>
								<?php
													$no=1;
														
														
														$qry=mysql_query("select *,sum(saldo) as jml_saldo from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' and nm_bank = '$nama_bank' group by tgl order by tgl DESC");
														while($hsl=mysql_fetch_array($qry)){
															$tgl_saldo=$hsl['tgl'];
															$jml_saldo=$hsl['jml_saldo'];
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$tgl_saldo?></td>
														<td><?=number_format($jml_saldo)?></td>
														<td>
															<?php
															$jml_bbm='0';
															$qrybbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBM%' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo' and bank = '$nama_bank'");
															while($hsl_bbm=mysql_fetch_array($qrybbm)){
																$bbm=$hsl_bbm['real_cost'];
																$jml_bbm=$jml_bbm+$bbm;
															}
															echo number_format($jml_bbm);
															?>
														</td>
														<td>
														<?php
															$jml_bbk=0;
															$qrybbk=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBK%' and no_reff_keu not like '%_AP' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo' and bank = '$nama_bank'");
															while($hsl_bbk=mysql_fetch_array($qrybbk)){
																$bbk=$hsl_bbk['real_cost'];
																$jml_bbk=$jml_bbk+$bbk;
															}
															echo number_format($jml_bbk);
														?>
														</td>
														<td>
															<?php
																$saldo=$jml_saldo+$jml_bbm-$jml_bbk;
																echo number_format($saldo);
															?>
														</td>
															<?php
																$tglkemaren = date('Y-m-d', strtotime('-1 days', strtotime($tgl_saldo)));
															?>
														
													</tr>
													<?php $no++; } ?>	
							</tbody>
						</table>                        
			</div>
            <div>							
				<h3>Tabel Kegiatan Jurnal Keuangan Bank <?= $nama_bank ?></h3>
			</div>
            <div class="box-body">
						<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
									<th>DATE</th>
									<th>BANK</th>
									<th>INPUTAN SALDO</th>
									<th>KETERANGAN</th>
								    <th>VALUE</th>									
								</tr>
							</thead>	
							<tbody>
								<?php
													    $noB=1;
														$qrytglinputsaldo=mysql_query("select * from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' and nm_bank = '$nama_bank'order by tgl desc");
														while ($hsltglinputsaldo=mysql_fetch_array($qrytglinputsaldo)){  
															$tglinputsaldo=$hsltglinputsaldo['tgl'];
													?>
														<tr>
															<td><?=$noB?></td>
															<td><?=$tglinputsaldo?></td>
															<td><?=$hsltglinputsaldo['nm_bank']?></td>
															<td class="text-right"><?=number_format($hsltglinputsaldo['saldo'])?></td>
															<td>
																<?php 
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																		?>
																			<p><?=$hslket['no_reff_keu']?> - <?=$hslket['kegiatan']?></p>
																		<?php	
																		}
																	}
																?> 
																<br><b>TOTAL :</b>
																<P><b>SALDO AKHIR : </b></P>
															</td>
															<td class="text-right">
																<?php 
																	$jmlD=0;
																	$jmlK=0;
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																			$nilai=$hslket['real_cost'];
																			$dk=$hslket['dk'];
																			if($dk == 'D'){
																				$jmlD=$jmlD+$nilai;
																			}else{
																				$jmlK=$jmlK+$nilai;
																			}
																		?>
																			<p><?=number_format($hslket['real_cost'])?> - (<?=$hslket['dk']?>)</p>
																		<?php	
																		}
																		$total=$jmlD-$jmlK;
																	} $saldoakh=$hsltglinputsaldo['saldo'] + $total ;
																?>
																<br><b><?=number_format($total)?></b> 
																<p><b><?=number_format($saldoakh)?></b></p>
															</td>
														</tr>
													<?php $noB++; } ?>	
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
		}
		// Update sor
		elseif ($module=='kas_bank' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=KasBankAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<b>LAPORAN KAS BANK TIMU</b>            
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>NAMA BANK</th>	
					<th>SALDO</th>	
					<th>TOTAL SALDO BANK</th>								
				</tr>
			</thead>
			<tbody>
                <?php
													$no=1;
														
														
														$qry=mysql_query("select * from bank where nama_bank != 'Kas Kecil'");
														while($hsl=mysql_fetch_array($qry)){
															$nama_bank=$hsl['nama_bank'];															
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$nama_bank?></td>														
														<td>
															<?php															
															$qrysaldo=mysql_query("select * from saldo_bank where nm_bank = '$nama_bank' and tgl ='$tgl_ak'");
															while($hsl_saldo=mysql_fetch_array($qrysaldo)){
																$saldo=$hsl_saldo['saldo'];																
															}
															echo $saldo;
															?>
														</td>														
														<td>
															<?php							
																$jml_saldo=$jml_saldo+$saldo;									
																echo $jml_saldo;
															?>
														</td>														
														
													</tr>
													<?php $no++; } 
													$jmlSaldoak=number_format($jml_saldo); ?>
			</tbody>
			<b class="text-danger">TABEL KAS BANK SALDO TERAKHIR : Rp. <?=$jmlSaldoak?></b>
		</table>        
	<?php
		}
	}
?>
