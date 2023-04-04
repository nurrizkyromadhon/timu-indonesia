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
		if ($module=='op_ap_jo' AND $act=='print_op_ap_jo'){
			$id_pf_log=$_GET['id'];
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
								where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AP','HUT') and prc.no_reff_keu not like 'BBK%'");
									while ($hsl_oc=mysql_fetch_array($qry_oc)){
										$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
								?>
								<tr>
									<td><?=$no?></td>
									<td><?=$hsl_oc['tgl_pf_real_cost']?></td>
									<td><?=$hsl_oc['no_jo']?></td>									
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

		elseif ($module=='op_ap_jo' AND $act=='excel'){
			$id_pf_log=$_GET['id'];
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=OpAp($date).xls");
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
								where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AP','HUT') and prc.no_reff_keu not like 'BBK%'");
									while ($hsl_oc=mysql_fetch_array($qry_oc)){
										$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
								?>
								<tr>
									<td><?=$no?></td>
									<td><?=$hsl_oc['tgl_pf_real_cost']?></td>
									<td><?=$hsl_oc['no_jo']?></td>									
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
		elseif ($module=='op_cash_jo' AND $act=='balik_op_ap'){
			
			$act2=$_POST['act'];
			$id_op_ap=$_POST['id_pf_log'];
			
			$op_ap=mysql_query("SELECT * from pf_real_cost as rc 
					left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
					left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost 
					where rc.id_pf_log=$id_op_ap and
					category1 = 'OP AP' and
					bl = '0'");
			while($hasil_ap=mysql_fetch_array($op_ap)){
				$tgl=date("Y-m-d H:i:s");
				$stakeholder=$hasil_ap['stakeholder'];
				$description=$hasil_ap['desc_est_cost'];
				$no_jo=$hasil_ap['no_jo'];

				mysql_query("UPDATE pf_real_cost SET bl = 1, updated_date='$tgl'
							WHERE id_pf_real_cost='$hasil_ap[id_pf_real_cost]'");				

				$query=mysql_query("INSERT INTO pf_real_cost (id_pf_log, user_pf_real_cost, id_est_cost, tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk,bl) 
									VALUE ('$id_op_ap','$id_user','$hasil_ap[id_est_cost]','$tgl','HUT','HUT','PENGAKUAN HUTANG $description $stakeholder JO $no_jo','$hasil_ap[no_reff_keu]_AP','$stakeholder','$hasil_ap[bukti]','$hasil_ap[real_cost]','$hasil_ap[bank]','K','1')") or die (mysql_error());
			}			

			header('location:../../oklogin.php?module='.$module.'&act='.$act);
		}
		// Update jurnal_keu
		elseif ($module=='op_ap_jo' AND $act=='print_op_ap_jo_all'){
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
						<p>LAPORAN OP AP TIMU</p>
                        <b class="text-danger">TABEL OP AP SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>DATE</th>
								<th>JO NUMBER</th>								
                                <th>NO INVOICE</th>
								<th>OP AP</th>
								<th>SALDO OP AP</th>                                
							</tr>
						</thead>
						<tbody>
                            <?php
                            $no=1;
                            
							$qry_oc=mysql_query("select * from pf_real_cost as prc
							join pf_log as pl on prc.id_pf_log=pl.id_pf_log
							where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and category1 = 'OP AP' group by prc.id_pf_log order by tgl_pf asc");
                                while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                    $op_balik= substr($hsl_oc['no_reff_keu'],10,3);
                                    $id_pf_log=$hsl_oc['id_pf_log'];
                                    $jml_oc=0;
                                    $jml_ob=0;
                                    $saldo_oc=0;
                                    
                                    $qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP AP'");
                                    while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
                                        $jml_oc=$jml_oc+$hsljml_oc['real_cost'];
                                    }
                                    $qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'HUT' and category2 = 'HUT'");
                                    while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
                                        $jml_ob=$jml_ob+$hsljml_ob['real_cost'];
                                    }
                                    $saldo_oc=$jml_oc-$jml_ob; 
                                    $saldo_ak=$saldo_ak+$saldo_oc;
                            ?>
                            <tr>
                                <td><?=$no?></td>
                                <td><?=$hsl_oc['tgl_pf']?></td>
                                <td><?=$hsl_oc['no_jo']?></td>                                
                                <td>
                                <?php
									$inv=mysql_query("SELECT no_invoice from pf_invoice 
									where id_pf_log='$id_pf_log' group by no_invoice ");
									while ($hslrc=mysql_fetch_array($inv)){
									?>
									<?=$hslrc['no_invoice']?><br>
									<?php } ?>
                                </td>
                                <td>
                                    
                                    <?=number_format($saldo_oc)?>
                                </td>
                                <td><?=number_format($saldo_ak)?></td>
                                
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
		elseif ($module=='op_ap_jo' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=OpApSubAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<p>LAPORAN OP AP TIMU</p>
            <b class="text-danger">TABEL OP AP </b>
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>DATE</th>
					<th>JO NUMBER</th>					
                    <th>NO INVOICE</th>
					<th>OP AP</th>
					<th>SALDO OP AP</th>                    	
				</tr>
			</thead>
			<tbody>
                <?php
                $no=1;
                
				$qry_oc=mysql_query("select * from pf_real_cost as prc
				join pf_log as pl on prc.id_pf_log=pl.id_pf_log
				where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and category1 = 'OP AP' group by prc.id_pf_log order by tgl_pf asc");
					while ($hsl_oc=mysql_fetch_array($qry_oc)){
						$op_balik= substr($hsl_oc['no_reff_keu'],10,3);
						$id_pf_log=$hsl_oc['id_pf_log'];
						$jml_oc=0;
						$jml_ob=0;
						$saldo_oc=0;
						
						$qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP AP'");
						while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
							$jml_oc=$jml_oc+$hsljml_oc['real_cost'];
						}
						$qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'HUT' and category2 = 'HUT'");
						while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
							$jml_ob=$jml_ob+$hsljml_ob['real_cost'];
						}
						$saldo_oc=$jml_oc-$jml_ob; 
						$saldo_ak=$saldo_ak+$saldo_oc;
                ?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$hsl_oc['tgl_pf']?></td>
                    <td><?=$hsl_oc['no_jo']?></td>                    
                    <td>
                    <?php
						$inv=mysql_query("SELECT no_invoice from pf_invoice 
						where id_pf_log='$id_pf_log' group by no_invoice ");
						while ($hslrc=mysql_fetch_array($inv)){
						?>
						<?=$hslrc['no_invoice']?><br>
						<?php } ?>
                    </td>
                    <td>
                        
                        <?=$saldo_oc?>
                    </td>
                    <td><?=$saldo_ak?></td>
                    
                </tr>
                <?php 
                    $no++; } 
                ?>
			</tbody>
		</table>
	<?php
		}
	}
?>
