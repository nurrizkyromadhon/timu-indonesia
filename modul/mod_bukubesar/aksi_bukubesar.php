<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";
		include "../../config/library.php";
		include "../../config/fungsi_thumb.php";
		include "../../config/fungsi_seo.php";

		$module=$_GET['module'];
		$act=$_GET['act'];

		// Input user
		if ($module=='bukubesar' AND $act=='input'){
			if (isset($_POST['tanggal'])) {
				$user=$_SESSION['username'];
				$tgl_jurnal=$_POST['tanggal'];
				$no_ref=$_POST['no_ref'];
				
				$nm_perkiraan=$_POST['nm_perkiraan'];
				$ket=$_POST['ket'];
				$nominal=$_POST['nominal'];
				$dk=$_POST['dk'];
				}
			if (empty($no_ref)){
					echo "$no_acc";
					echo "Nomor Referensi Belom Terisi ... !";
					echo "<br/>"; 
					imap_alerts('kembali');
				}else {
					for($x=0; $x < count($nm_perkiraan); $x++) {
						$query0="SELECT id_perkiraan FROM perkiraan WHERE nm_perkiraan='$nm_perkiraan[$x]'";
						$qry0=mysql_query($query0);
						while ($hasil=mysql_fetch_array($qry0)){
						$id_perkiraan=$hasil['id_perkiraan'];
						
						$query = "INSERT INTO jurnal (user, tgl, no_ref, id_perkiraan, ket, nominal, dk)VALUES('$user','$tgl_jurnal','$no_ref','$id_perkiraan','$ket[$x]','$nominal[$x]', '$dk[$x]')";
						$qry=mysql_query($query) or die(mysql_error());
						}}
					}
					header('location:../../oklogin.php?module='.$module);
				}
	
		// Update user
		elseif ($module=='spp' AND $act=='update'){
			if (isset($_POST['no_spp'])) {
				$id_spp=$_POST['id_spp'];
				$no_spp=$_POST['no_spp'];
				$tgl_spp=$_POST['tanggal'];
				$id_site=$_POST['id_site'];
				$id_alat=$_POST['id_alat'];
				$key_stat=$_POST['key_stat'];
				$keterangan=$_POST['keterangan'];
				
				$satuan=$_POST['satuan'];		
				$item_name=$_POST['item_name'];
				$part_no=$_POST['part_no'];
				$qty=$_POST['quantity'];
			}
			$query = "UPDATE spp SET no_spp  = '$_POST[no_spp]', 
									tgl_spp  = '$_POST[tanggal]', 
									id_site	 = '$_POST[id_site]', 
									id_alat  = '$_POST[id_alat]', 
									key_stat = '$_POST[key_stat]', 
									keterangan 	 = '$_POST[keterangan]', 
									user 	 = '$_SESSION[namalengkap]' 
									WHERE id_spp = '$_POST[id_spp]'";
			$sql = mysql_query ($query) or die (mysql_error());
					
			$query = "DELETE FROM spp_sparepart WHERE  id_spp = '$_POST[id_spp]'";
			$sql = mysql_query ($query) or die (mysql_error());
			
			for($x=0; $x < count($item_name); $x++) {
				if(!empty($item_name[$x]) && !empty($part_no[$x])){
					$query2 = "SELECT id_sparepart from sparepart WHERE item_name = '".$item_name[$x]."' AND part_no = '".$part_no[$x]."' AND satuan = '".$satuan[$x]."'";
            		$qry2=mysql_query($query2);
            		$num_rows = mysql_num_rows($qry2);
            		if($num_rows == 0) {
            			$query3 = "INSERT INTO sparepart (item_name, part_no, satuan)VALUES('".$item_name[$x]."','".$part_no[$x]."','".$satuan[$x]."')";
            			$sql3 = mysql_query ($query3) or die (mysql_error());
            			$id_sparepart = mysql_insert_id();
            		}
            		else {
            			while ($hasil2=mysql_fetch_array($qry2)){
            			    $id_sparepart = $hasil2['id_sparepart'];
            			}
            		}
					if(empty($qty[$x])){
						$qty[$x] = "1";
					}
					$query = "INSERT INTO spp_sparepart (id_spp, id_sparepart, qty)
					VALUES($id_spp, '$id_sparepart','$qty[$x]')";
					$sql = mysql_query ($query) or die (mysql_error());
							
					$query5 = "SELECT id_stock from stock WHERE id_sparepart = '".$id_sparepart."' AND id_site = '".$id_site."'";
            		$qry5=mysql_query($query5);
            		$num_rows2 = mysql_num_rows($qry5);
            		if($num_rows2 == 0) {
            		    $query6 = "INSERT INTO stock (id_sparepart, id_site)VALUES('".$id_sparepart."','".$id_site."')";
        			    $sql6 = mysql_query ($query6) or die (mysql_error());   
            		}
				}
			}
			
			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus SPP
		elseif ($module=='spp' AND $act=='hapus'){
			mysql_query("DELETE FROM spp WHERE id_spp='$_GET[id]'");
			mysql_query("DELETE FROM spp_sparepart WHERE id_spp='$_GET[id]'");
			header('location:../../oklogin.php?module='.$module);
		}

		// cetak SPP
		elseif ($module=='bukubesar' AND $act=='savetoexcel'){
			$date=date('Ymd');
				
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=BukuBesar($date).xls");
			?>
				<div class="box-body">
						
					<?php
						$no=1;
						// Menentukan tanggal awal bulan dan akhir bulan
							$tgl_aw=$_POST['tgl_aw'];
							$tgl_ak=$_POST['tgl_ak'];
							$kode_perkiraan=$_POST['kode_perkiraan'];

					?>
							<h3>Periode : <?=date('d-M-Y',strtotime($tgl_aw))?> s/d <?=date('d-M-Y',strtotime($tgl_ak))?></h3> 
					<?php
	
							$query3=mysql_query("select * from perkiraan where kode_perkiraan='$kode_perkiraan'");
							$hasil3=mysql_fetch_array($query3);
							
					?>
							Kode Rekening : <?=$kode_perkiraan?> - <?=$hasil3['nm_perkiraan']?>
							<table border="1">
									<thead bgcolor=#A5B4EC>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Perkiraan</th>
											<th>Keterangan</th>
											<th>No BG dan CEK</th>
											<th>Debet</th>
											<th>Kredit</th>
											<th>Saldo</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>0</td>
											<td><?=date('d-M-Y',strtotime($tgl_aw))?></td>
											<td></td>
											<td></td>
											<td>Saldo Awal </td>
											<td></td>
											<td></td>
											<td></td>
											<td>
												<?php
													//1. Menentukan saldo awal 
													// Menentukan tanggal mulai start sampai tgl sebelum ( tgl_aw )
													$tgl_sld1=date('2017-01-01');
													$tgl_sld2=date('Y-m-d', strtotime('-1 day', strtotime($tgl_aw)));

													//Jika Kode Perkiraan kosong  
													if ($kode_perkiraan==''){
														//Mencari saldo Jumlah Debet dan kredit untuk 
														$query1=mysql_query("SELECT * FROM jurnal as j 
														join perkiraan as p on j.id_perkiraan=p.id_perkiraan
														where tgl between '$tgl_sld1' and '$tgl_sld2' 
														ORDER BY tgl, no_ref asc");
														while ($hasil1=mysql_fetch_array($query1)){
															error_reporting(0);
															if($hasil1['dk']=='D'){
																$jmld=$jmld+$hasil1['nominal'];
															}else{
																$jmlk=$jmlk+$hasil1['nominal'];
															}
														}
													//jika kode perkiraan terisi 	
													}else{
														//Mencari saldo Jumlah Debet dan kredit untuk 
														$query1=mysql_query("SELECT *,j.nominal as rp FROM jurnal as j 
														join perkiraan as p on j.id_perkiraan=p.id_perkiraan
														where tgl between '$tgl_sld1' and '$tgl_sld2' and kode_perkiraan='$kode_perkiraan'
														ORDER BY tgl, no_ref asc");
														while ($hasil1=mysql_fetch_array($query1)){
															error_reporting(0);
															if($hasil1['dk']=='D'){
																error_reporting(0);
																$jmld=$jmld+$hasil1['rp'];
															}else if($hasil1['dk']=='K'){
																error_reporting(0);
																$jmlk=$jmlk+$hasil1['rp'];
															}
														}
													}
													error_reporting(0);
													//echo "$tgl_sld1";
													//echo " ke $tgl_sld2 <br>";
													$saldo_aw=$jmld-$jmlk;
													
												?>
													<?=$saldo_aw?>
											</td>
										</tr>
										<?php
										if ($kode_perkiraan==''){
											$query=mysql_query("SELECT * FROM jurnal as j 
											join perkiraan as p on j.id_perkiraan=p.id_perkiraan
											where tgl between '$tgl_aw' and '$tgl_ak' 
											ORDER BY tgl, no_ref asc");
										}else{
											$query=mysql_query("SELECT * FROM jurnal as j 
											join perkiraan as p on j.id_perkiraan=p.id_perkiraan
											where tgl between '$tgl_aw' and '$tgl_ak' and kode_perkiraan='$kode_perkiraan'
											ORDER BY tgl, no_ref asc");
										}
											while ($hasil=mysql_fetch_array($query)){
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_ref']?></td>
														<td><?php echo $hasil['kode_perkiraan']." - " .$hasil['nm_perkiraan']; ?></td>
														<td><?=$hasil['ket']?></td>
														<td><?=$hasil['bgcek']?></td>
														<?php
														if ($hasil['dk']=='D'){
														?>
															<td><?=$hasil['nominal']?></td>
															<td></td>
														<?php
														}if ($hasil['dk']=='K'){
														?>
															<td></td>
															<td><?=$hasil['nominal']?></td>
															
														<?php
														}
														?>
														<td>
														<?php
															if($hasil['dk']=='D'){ 
																$saldo=($saldo+$hasil['nominal']);
															}else{
																$saldo=($saldo-$hasil['nominal']);	
															}
															
															$saldoak=$saldo+$saldo_aw;
														?>
														<?=$saldoak?>
														</td>
													</tr>
												<?php
												$no++;
											}
										?>
									</tbody>
						  		</table>
					  		</div>		
				<?
			} 
			
		elseif ($module=='bukubesar' AND $act=='print'){	
    		?>
    		    <html>
                	<head>
                		<title>SURAT PERMINTAAN/PEMBELIAN</title>
                		
                		<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
                		
                		<style type="text/css">
                			@page {
                			  size: A4;
                			  size: portrait; 
                			  margin: 10mm 20mm;
                			}
                			@media print {
                				html, body {
                					width: 210mm !important;
                					height: 297mm !important;
                				}
                				table th, table td {
                					border:1px solid #000;
                					margin:0mm;
                				}
                				table { page-break-inside:auto }
                				tr    { page-break-inside:avoid; page-break-after:auto }
                				thead { display:table-header-group }
                				.akhir {page-break-after: always;}
                			}
                			.container, .container table {
                				width:100%;
                			}
                			.container table tr, .container table tr td, .container table tr th, .container table {
                				margin:0px !important;
                			}
                		</style>
                	</head>
                	<body style="width: 210mm !important; height: 297mm !important;">
                		<h3>CV.SINAR BINTANG TIMUR</h3>
                		<center><h1>SURAT PERMINTAAN/PEMBELIAN</h1></center>
                		<?php
                			$no=1;
                			$query="SELECT *, spp.keterangan as ket_spp from spp left join alat on spp.id_alat=alat.id_alat left join kodestatusbd on spp.key_stat=kodestatusbd.key_stat JOIN site ON spp.id_site = site.id_site WHERE spp.id_spp = $_GET[id] order by spp.id_spp desc";
                			$qry=mysql_query($query);
                			while ($hasil=mysql_fetch_array($qry)){
                				?>
                		
                					<div class="container">
                						<div class="kiri" style="width:60%; float:left;">
                						</div>
                						<div class="kanan" style="width:40%; float:right;">
                							<table>
                								<tr>
                									<td align="right" style="border:none;">No SPP : </td>
                									<td align="left" style="border:none;"><?=$hasil['no_spp']?></td>
                								</tr>
                								<tr>
                									<td align="right" style="border:none;">Tgl SPP : </td>
                									<td align="left" style="border:none;"><?=$hasil['tgl_spp']?></td>
                								</tr>
                								<tr>
                									<td align="right" style="border:none;">Unit Model : </td>
                									<td align="left" style="border:none;"><?=$hasil['nm_alat']?></td>
                								</tr>
                								<tr>
                									<td align="right" style="border:none;">No Lambung : </td>
                									<td align="left" style="border:none;"><?=$hasil['no_lamb']?></td>
                								</tr>
                								<tr>
                									<td align="right" style="border:none;">SITE : </td>
                									<td align="left" style="border:none;"><?=$hasil['nama_site']?></td>
                								</tr>
                							</table>
                						</div>
                						<div style="clear:both;"></div>
                					</div>
                					<p style="margin-bottom:0px;">Kami menetapkan pesanan kami seperti tercantum di bawah ini</p>
                					<div class="container">
                						<table>
                							<thead>
                								<tr>
                									<th>NO</th>
                									<th>NAMA BARANG</th>
                									<th>PART NUMBER</th>
                									<th>QTY</th>
                									<th>SATUAN</th>
                									<th>URGEN STOCK</th>
                									<th>DIORDER OLEH</th>
                								</tr>
                							<thead>
                							<tbody>
                								<?php
                									$jumlah = 0;
                									$no = 1;									
                									$query2="SELECT s.*, ss.qty FROM spp_sparepart as ss JOIN sparepart as s ON ss.id_sparepart = s.id_sparepart WHERE ss.id_spp=".$hasil['id_spp']." ORDER BY ss.id_spp_sparepart ASC ";
                									$qry2=mysql_query($query2);
                									while ($hasil_sprpart=mysql_fetch_array($qry2)){
                										?>
                											<tr>
                												<td><?=$no?></td>
                												<td><?=$hasil_sprpart['item_name']?></td>
                												<td><?=$hasil_sprpart['part_no']?></td>
                												<td><?=$hasil_sprpart['qty']?></td>
                												<td><?=$hasil_sprpart['satuan']?></td>
                												<td><?=$hasil['prioritas']?></td>
                												<td><?=$hasil['user']?></td>
                											</tr>
                										<?php
                										$no++;
                									}
                									while ($no<=10){
                										?>
                											<tr>
                												<td>&nbsp;</td>
                												<td></td>
                												<td></td>
                												<td></td>
                												<td></td>
                												<td></td>
                												<td></td>
                											</tr>
                										<?php
                										$no++;
                									}
                								?>
                							<tbody>
                						</table>
                						<p>Keterangan : <?=$hasil['ket_spp']?></p>
                						<table>							
                							<tr>
                								<td>
                									DIBUAT OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>AJI ARYANDE</u>
                									</br>
                									ADMIN PLAN
                								</td>
                								<td>
                									DISETUJUI OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>
                									PANDI
                									</u>
                									</br>
                									LOGISTIK
                								</td>
                								<td>
                									DIKETAHUI OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>
                									IWAN PRASETYO
                									</u>
                									</br>
                									FORMAN MEKANIK
                								</td>
                								<td>
                									DIKETAHUI OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>
                									ARNOLD MAWUNTU
                									</u>
                									</br>
                									KABAG PLANT
                								</td>
                							</tr>
                							<tr>
                								<td colspan="4">Catatan : </td>
                							</tr>
                						</table>
                					</div>
                				<?php
                			}
                		?>
                
                		<script type="text/javascript">
                			$(function () {				
                				window.print();
                			});
                		</script>
                		<!-- Inner Container End -->
                	</body>
                </html>
    		<?php
		}
	}
?>
