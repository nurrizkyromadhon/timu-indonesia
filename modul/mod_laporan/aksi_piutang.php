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
		if ($module=='piutang' AND $act=='print_piutang_cust'){
			$nm_cust=$_GET['nm_cust'];
            $tgl_aw=$_GET['tgl_aw'];
            $tgl_ak=$_GET['tgl_ak'];
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
				<h3>Tabel Laporan Piutang Customer <?= $nm_cust ?></h3>
			</div>
			<div class="box-body">
						<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
                                                    <th>DATE</th>
													<th>JO NUMBER</th>
                                                    <th>NO REFF PIUT</th>                                                    
                                                    <th>INV NUMBER</th>
													<th>D</th>
													<th>DUE DATE</th>
													<th>PAYMENT DATE</th>                                                                                                        
													<th>NO REFF BBM</th>                                                                                                                                                            
                                                    <th>K</th>										
                                                    <th>DATE BBK</th>										
                                                    <th>NO REFF BBK</th>										
                                                    <th>BBK</th>										
                                                    <th>SALDO PIUTANG</th>
								</tr>
							</thead>	
							<tbody>
                                                <?php
                                                $no=1;
                                                    $qry_rc=mysql_query("select * from pf_real_cost as prc
													left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
													left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT') order by tgl_pf asc");
                                                    while ($hsl_oc=mysql_fetch_array($qry_rc)){
                                                        $category= $hsl_oc['category1'];
														$no_inv= $hsl_oc['no_invoice'];
														$no_inv2= substr($hsl_oc['no_invoice'],3,13);
														$id_pf_log= $hsl_oc['id_pf_log'];
														$no_reff_keu= $hsl_oc['no_reff_keu'];
														$no_jo = substr($hsl_oc['no_jo'],4,10);
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf']?></td>
													<td><?=$hsl_oc['no_jo']?></td>
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>                                                    
                                                    <td><?=$hsl_oc['no_invoice']?></td>
													<td>
														<?php                                                        
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                    	?>
														<?=number_format($hsl_oc['real_cost'])?>
													</td>
													<td>
                                                        <?php
                                                        $due_date= date('Y-m-d', strtotime($hsl_oc['tgl_pf_real_cost']. '+30 day'));
                                                        echo $due_date;
                                                        ?>
                                                    </td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust'  and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['tgl_pf_real_cost']?> <br>
														<?php } 
														?> 
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['no_reff_keu']?> <br>
														<?php } 
														?> 														
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=number_format($hsl_oc2['real_cost'])?> <br>
														<?php 
															$saldo_ob=$saldo_ob+$hsl_oc2['real_cost']; 
														} 
														?> 														
													</td>																										                                                                                                                                                                                                                
                                                    <?php                                                      
                                                    $saldo_ak=$saldo_oc-$saldo_ob;
                                                    ?>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=$hsl_bbk['tgl_pf_real_cost']?> <br>
														<?php 															 
														} 
														?>
													</td>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=$hsl_bbk['no_reff_keu']?> <br>
														<?php 															 
														} 
														?>
													</td>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=number_format($hsl_bbk['real_cost'])?> <br>
														<?php 															 
														} 
														?>
													</td>
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

		elseif ($module=='piutang' AND $act=='excel'){
			$nm_cust=$_GET['nm_cust'];
            $tgl_aw=$_GET['tgl_aw'];
            $tgl_ak=$_GET['tgl_ak'];
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=PiutangCust($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
			<div>							
				<h3>Tabel Laporan Piutang Customer <?= $nm_cust ?></h3>
			</div>
			<table id="table" border="1">
							<thead class="bg-blue">
								<tr>
									<th>NO</th>
                                                    <th>DATE</th>
													<th>JO NUMBER</th>
                                                    <th>NO REFF PIUT</th>                                                    
                                                    <th>INV NUMBER</th>
													<th>D</th>
													<th>DUE DATE</th>
													<th>PAYMENT DATE</th>                                                                                                        
													<th>NO REFF BBM</th>                                                                                                                                                            
                                                    <th>K</th>										
                                                    <th>DATE BBK</th>										
                                                    <th>NO REFF BBK</th>										
                                                    <th>BBK</th>										
                                                    <th>SALDO PIUTANG</th>
								</tr>
							</thead>	
							<tbody>
                                                <?php
                                                $no=1;
                                                    $qry_rc=mysql_query("select * from pf_real_cost as prc
													left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
													left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT') order by tgl_pf asc");
                                                    while ($hsl_oc=mysql_fetch_array($qry_rc)){
                                                        $category= $hsl_oc['category1'];
														$no_inv= $hsl_oc['no_invoice'];
														$no_inv2= substr($hsl_oc['no_invoice'],3,13);
														$id_pf_log= $hsl_oc['id_pf_log'];
														$no_reff_keu= $hsl_oc['no_reff_keu'];
														$no_jo = substr($hsl_oc['no_jo'],4,10);
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf']?></td>
													<td><?=$hsl_oc['no_jo']?></td>
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>                                                    
                                                    <td><?=$hsl_oc['no_invoice']?></td>
													<td>
														<?php                                                        
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                    	?>
														<?=$hsl_oc['real_cost']?>
													</td>
													<td>
                                                        <?php
                                                        $due_date= date('Y-m-d', strtotime($hsl_oc['tgl_pf_real_cost']. '+30 day'));
                                                        echo $due_date;
                                                        ?>
                                                    </td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust'  and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['tgl_pf_real_cost']?> <br>
														<?php } 
														?> 
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['no_reff_keu']?> <br>
														<?php } 
														?> 														
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log= '$id_pf_log' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_inv' or bukti='$no_inv' or kegiatan LIKE '%$no_inv%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['real_cost']?> <br>
														<?php 
															$saldo_ob=$saldo_ob+$hsl_oc2['real_cost']; 
														} 
														?> 														
													</td>																										                                                                                                                                                                                                                
                                                    <?php                                                      
                                                    $saldo_ak=$saldo_oc-$saldo_ob;
                                                    ?>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=$hsl_bbk['tgl_pf_real_cost']?> <br>
														<?php 															 
														} 
														?>
													</td>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=$hsl_bbk['no_reff_keu']?> <br>
														<?php 															 
														} 
														?>
													</td>
                                                    <td>
														<?php $qry_bbk=mysql_query("select * from pf_real_cost																																							                                
															where category1 in('X','PENGELUARAN LAIN') and category2='BBK' and kegiatan LIKE '%$no_inv2%' and kegiatan LIKE '%$no_jo%'");
														while ($hsl_bbk = mysql_fetch_array($qry_bbk)){ ?>
															<?=$hsl_bbk['real_cost']?> <br>
														<?php 															 
														} 
														?>
													</td>
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
		elseif ($module=='piutang' AND $act=='print_piutang_all'){
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
						<p>LAPORAN PIUTANG TIMU</p>
                        <b class="text-danger">TABEL PIUTANG SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>CUSTOMER</th>																								                                                
								<th>PIUTANG</th>
                                <th>SALDO PIUTANG</th>	
							</tr>
						</thead>
						<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_cust=mysql_query("select * from data_cust");
                                                while ($hsl_cust=mysql_fetch_array($qry_cust)){   
                                                    $nm_cust = $hsl_cust['nm_cust'];
                                                    $jml_piut=0;
                                                    $jml_bbm=0;
                                                    $saldo_piut=0;
                                                    
                                                    $qry_piut=mysql_query("select * from pf_real_cost as prc
                                                	left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
													left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT')");
                                                    while ($hsl_piut=mysql_fetch_array($qry_piut)){
                                                        $jml_piut=$jml_piut+$hsl_piut['real_cost'];
                                                        $no_invoice = $hsl_piut['no_invoice'];
                                                    
                                                    $qry_bbm=mysql_query("select * from pf_real_cost as prc
                                                	join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                	where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_invoice' or bukti='$no_invoice' or kegiatan LIKE '%$no_invoice%')");
                                                    while ($hsl_bbm=mysql_fetch_array($qry_bbm)){
                                                        $jml_bbm=$jml_bbm+$hsl_bbm['real_cost'];
                                                    }                                                                                                                                                         
                                                    }
                                                    $saldo_piut=$jml_piut-$jml_bbm;
                                                    $saldo_ak=$saldo_ak+$saldo_piut;
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$nm_cust?></td>
                                                <td><?=number_format($saldo_piut)?></td>                                                
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
		elseif ($module=='piutang' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=PiutangAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<p>LAPORAN PIUTANG TIMU</p>            
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>CUSTOMER</th>																								                                                
					<th>PIUTANG</th>
                    <th>SALDO PIUTANG</th>	
				</tr>
			</thead>
			<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_cust=mysql_query("select * from data_cust");
                                                while ($hsl_cust=mysql_fetch_array($qry_cust)){   
                                                    $nm_cust = $hsl_cust['nm_cust'];
                                                    $jml_piut=0;
                                                    $jml_bbm=0;
                                                    $saldo_piut=0;
                                                    
                                                    $qry_piut=mysql_query("select * from pf_real_cost as prc
                                                	left join pf_log as pl on prc.id_pf_log=pl.id_pf_log													
													left join pf_invoice as inv on prc.id_pf_invoice=inv.id_pf_invoice                                                    
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and ( category1 like 'PIUTANG' and category2='PIUT')");
                                                    while ($hsl_piut=mysql_fetch_array($qry_piut)){
                                                        $jml_piut=$jml_piut+$hsl_piut['real_cost'];
                                                        $no_invoice = $hsl_piut['no_invoice'];
                                                    
                                                    $qry_bbm=mysql_query("select * from pf_real_cost as prc
                                                	join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                	where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and pl.cust_name = '$nm_cust' and category2='BBM' and (category1='$no_invoice' or bukti='$no_invoice' or kegiatan LIKE '%$no_invoice%')");
                                                    while ($hsl_bbm=mysql_fetch_array($qry_bbm)){
                                                        $jml_bbm=$jml_bbm+$hsl_bbm['real_cost'];
                                                    }                                                                                                                                                         
                                                    }
                                                    $saldo_piut=$jml_piut-$jml_bbm;
                                                    $saldo_ak=$saldo_ak+$saldo_piut;
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$nm_cust?></td>
                                                <td><?=number_format($saldo_piut)?></td>                                                
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
	<?php
		}
	}
?>
