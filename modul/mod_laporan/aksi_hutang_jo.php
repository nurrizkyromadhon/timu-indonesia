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
		if ($module=='hutang_jo' AND $act=='print_hutang_jo'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];
            $nama_ven=$_GET['nama_ven'];
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
							<h3 class="box-title">HUTANG VENDOR <?=$nama_ven?></h3>
						</div>
			<div class="box-body">
										<table border=1;>
                                            <thead class="bg-blue">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>DATE</th>
                                                    <th>JO NUMBER</th>
                                                    <th>NO REFF HUT</th>                                                                                                        
													<th>D</th>
													<th>DUE DATE</th>
													<th>PAYMENT DATE BBK</th>                                                                                                        
													<th>NO REFF BBK</th>                                                                                                                                                            
													<th>K</th>                                                                                                                                                            
                                                    <th>SELISIH</th>										
                                                    <th>PAYMENT DATE HUT</th>										
                                                    <th>NO REFF HUT</th>										
                                                    <th>K</th>										
                                                    <th>HUTANG</th>										
                                                    <th>SALDO HUTANG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                    join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by tgl_pf ");
                                                    while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                        $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                        $id_pf_log= $hsl_oc['id_pf_log'];
                                                        $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];
                                                        $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                        $selisih = 0;
                                                        $saldo_oc2 = 0;
                                                        $saldo_ob2 = 0;
                                                        $hutang = 0;
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf']?></td>
                                                    <td><?=$hsl_oc['no_jo']?></td>                                                    
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>													
                                                    <td>
                                                        <?php                                                        
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
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
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['tgl_pf_real_cost']?> <br>
														<?php } 
														?> 
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['no_reff_keu']?> <br>
														<?php } 
														?> 														
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=number_format($hsl_oc2['real_cost'])?> <br>
														<?php 
															$saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                            $saldo_ob2=$hsl_oc2['real_cost']; 
														}
                                                        
														?> 														
													</td>                                                                                                                                                           
                                                    <td>
                                                        <?php
                                                        
                                                        $selisih = $saldo_oc2-$saldo_ob2;
                                                        echo number_format($selisih);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['tgl_pf_real_cost']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['no_reff_keu']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=number_format($hsl_hut['real_cost'])?> <br>
														<?php 
                                                            $hutang = $hsl_hut['real_cost'];
                                                        } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php                                                     
                                                        $saldo_hut=$saldo_oc2-$saldo_ob2 - $hutang;
                                                        $saldo_ak=$saldo_ak+$saldo_hut;
                                                        echo number_format($saldo_hut);
                                                        ?>
                                                    </td>
                                                    <td><?=number_format($saldo_ak)?></td>
                                                </tr>
                                                <?php $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak);  ?>
                                                <script>
                                                    var x = "<?=$jmlSaldoak?>";
                                                    document.getElementById("jmlhut").innerHTML = x ;
                                                </script>
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

		elseif ($module=='hutang_jo' AND $act=='excel'){
			$tgl_aw=$_GET['tgl_aw'];
			$tgl_ak=$_GET['tgl_ak'];
			$nama_ven=$_GET['nama_ven'];
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=HutangJo($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		?>
        <div class="box-header with-border">
							<h3 class="box-title">HUTANG VENDOR <?=$nama_ven?></h3>
						</div>
										<table border=1;>
                                            <thead class="bg-blue">
                                                <tr>
                                                    <th>NO</th>
                                                    <th>DATE</th>
                                                    <th>JO NUMBER</th>
                                                    <th>NO REFF HUT</th>                                                                                                        
													<th>D</th>
													<th>DUE DATE</th>
													<th>PAYMENT DATE BBK</th>                                                                                                        
													<th>NO REFF BBK</th>                                                                                                                                                            
													<th>K</th>                                                                                                                                                            
                                                    <th>SELISIH</th>										
                                                    <th>PAYMENT DATE HUT</th>										
                                                    <th>NO REFF HUT</th>										
                                                    <th>K</th>										
                                                    <th>HUTANG</th>										
                                                    <th>SALDO HUTANG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                    join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by tgl_pf ");
                                                    while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                        $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                        $id_pf_log= $hsl_oc['id_pf_log'];
                                                        $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];
                                                        $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                        $selisih = 0;
                                                        $saldo_oc2 = 0;
                                                        $saldo_ob2 = 0;
                                                        $hutang = 0;
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf']?></td>
                                                    <td><?=$hsl_oc['no_jo']?></td>                                                    
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>													
                                                    <td>
                                                        <?php                                                        
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
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
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['tgl_pf_real_cost']?> <br>
														<?php } 
														?> 
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['no_reff_keu']?> <br>
														<?php } 
														?> 														
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['real_cost']?> <br>
														<?php 
															$saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                            $saldo_ob2=$hsl_oc2['real_cost']; 
														}
                                                        
														?> 														
													</td>                                                                                                                                                           
                                                    <td>
                                                        <?php
                                                        
                                                        $selisih = $saldo_oc2-$saldo_ob2;
                                                        echo $selisih;
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['tgl_pf_real_cost']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['no_reff_keu']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['real_cost']?> <br>
														<?php 
                                                            $hutang = $hsl_hut['real_cost'];
                                                        } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php                                                     
                                                        $saldo_hut=$saldo_oc2-$saldo_ob2 - $hutang;
                                                        $saldo_ak=$saldo_ak+$saldo_hut;
                                                        echo $saldo_hut;
                                                        ?>
                                                    </td>
                                                    <td><?=$saldo_ak?></td>
                                                </tr>
                                                <?php $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak);  ?>
                                                <script>
                                                    var x = "<?=$jmlSaldoak?>";
                                                    document.getElementById("jmlhut").innerHTML = x ;
                                                </script>
                                            </tbody>
                                        </table>
		<?php
		}
		// Update jurnal_keu
		elseif ($module=='hutang_jo' AND $act=='print_hutang_jo_all'){
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
						<p>LAPORAN HUTANG TIMU</p>
                        <b class="text-danger">TABEL HUTANG SALDO TERAKHIR : Rp. </b>
                        <b id='jmlOpcash'></b>
                    </div>    
					<table id="myTable" border='1'">
						<thead class="bg-blue">
							<tr>
								<th>NO</th>
								<th>VENDOR</th>																								
								<th>HUTANG</th>
                                <th>SALDO HUTANG</th>																		
							</tr>
						</thead>
						<tbody>
                                            <?php
                                            $no=1;
                                                $qry_ven=mysql_query("select * from data_vendor");                                                
                                                while ($hsl_ven=mysql_fetch_array($qry_ven)){
                                                    $nama_ven = $hsl_ven['nm_vendor'];                                                    
                                                    $jml_oc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    $saldo_ob=0;                                                    
                                                    $saldo_hut2=0;
                                                    $selisih = 0;
                                                    $saldo_oc2 = 0;
                                                    $saldo_ob2 = 0;
                                                    
                                                        $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                        join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                        where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by id_pf_real_cost ");
                                                        while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                                                                                        
                                                            $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                            $id_pf_log= $hsl_oc['id_pf_log'];
                                                            $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                            $rc= $hsl_oc['real_cost'];
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
                                                            $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];

                                                            $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														    while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){																													
															    $saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                                $saldo_ob2=$hsl_oc2['real_cost'];
                                                            }

                                                            $selisih = $saldo_oc2-$saldo_ob2;
                                                            $qry_hut=mysql_query("select * from pf_real_cost																																							                                
                                                                where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
                                                            while ($hsl_hut = mysql_fetch_array($qry_hut)){                                                                                                                            
                                                                $saldo_hut2=$saldo_hut2+$hsl_hut['real_cost'];
                                                            }
                                                            
                                                            
                                                        }
                                                        $saldo_ak=$saldo_oc - $saldo_ob - $saldo_hut2;                                                                                                
                                                        $saldo_ak3=$saldo_hut2;                                                                                                
                                                        $saldo_ak2=$saldo_ak2+$saldo_ak; 
                                                    
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_ven['nm_vendor']?></td>
                                                <td><?=number_format($saldo_ak)?></td>
                                                <td><?=number_format($saldo_ak2)?></td>                                                                                                
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak2); 
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
		elseif ($module=='hutang_jo' AND $act=='excel_all'){
		$tgl_aw=$_GET['tgl_aw'];
		$tgl_ak=$_GET['tgl_ak'];
		$date=date('ymd');
		
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=HutangAll($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Cache-Control: max-age=0");
	?>
		<div>
			<p>LAPORAN HUTANG TIMU</p>
            <b class="text-danger">TABEL HUTANG </b>
        </div>    
		<table id="myTable" border='1'">
			<thead class="bg-blue">
				<tr>
					<th>NO</th>
					<th>VENDOR</th>																								
					<th>HUTANG</th>
                    <th>SALDO HUTANG</th>															
				</tr>
			</thead>
			<tbody>
                                            <?php
                                            $no=1;
                                                $qry_ven=mysql_query("select * from data_vendor");                                                
                                                while ($hsl_ven=mysql_fetch_array($qry_ven)){
                                                    $nama_ven = $hsl_ven['nm_vendor'];                                                    
                                                    $jml_oc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    $saldo_ob=0;                                                    
                                                    $saldo_hut2=0;
                                                    $selisih = 0;
                                                    $saldo_oc2 = 0;
                                                    $saldo_ob2 = 0;
                                                    
                                                        $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                        join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                        where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by id_pf_real_cost ");
                                                        while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                                                                                        
                                                            $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                            $id_pf_log= $hsl_oc['id_pf_log'];
                                                            $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                            $rc= $hsl_oc['real_cost'];
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
                                                            $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];

                                                            $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														    while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){																													
															    $saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                                $saldo_ob2=$hsl_oc2['real_cost'];
                                                            }

                                                            $selisih = $saldo_oc2-$saldo_ob2;
                                                            $qry_hut=mysql_query("select * from pf_real_cost																																							                                
                                                                where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
                                                            while ($hsl_hut = mysql_fetch_array($qry_hut)){                                                                                                                            
                                                                $saldo_hut2=$saldo_hut2+$hsl_hut['real_cost'];
                                                            }
                                                            
                                                            
                                                        }
                                                        $saldo_ak=$saldo_oc - $saldo_ob - $saldo_hut2;                                                                                                
                                                        $saldo_ak3=$saldo_hut2;                                                                                                
                                                        $saldo_ak2=$saldo_ak2+$saldo_ak; 
                                                    
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_ven['nm_vendor']?></td>
                                                <td><?=$saldo_ak?></td>
                                                <td><?=$saldo_ak2?></td>                                                                                                
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak2); 
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
