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
		if ($module=='kas' AND $act=='input'){
			if (isset($_POST['tanggal'])) {
				$user=$_SESSION['username'];
				$tgl_jurnal=$_POST['tanggal'];
				$no_ref=$_POST['no_ref'];
				$no_jurnal=$_POST['no_jurnal'];
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
					for($x=0; $x < count($no_ref); $x++) {
						$id_perkiraan='60';
						$query = "INSERT INTO jurnal (user, tgl, no_jurnal, no_ref, id_perkiraan, ket, nominal, dk)VALUES('$user','$tgl_jurnal','$no_jurnal','$no_ref[$x]','$id_perkiraan','$ket[$x]','$nominal[$x]', '$dk[$x]')";
						$qry=mysql_query($query) or die(mysql_error());
						}
					}
					header('location:../../oklogin.php?module='.$module);
				}
	
		elseif ($module=='kas' AND $act=='input_bg_cek'){
			if (isset($_POST['tanggal'])) {
				$user=$_SESSION['username'];
				$tgl_jurnal=$_POST['tanggal'];
				$no_ref=$_POST['no_ref'];
				$no_jurnal=$_POST['no_jurnal'];
				$nm_perkiraan=$_POST['nm_perkiraan'];
				$ket=$_POST['ket'];
				$bgcek=$_POST['bgcek'];
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
						
						$query = "INSERT INTO jurnal (user, tgl, no_jurnal, no_ref, id_perkiraan, ket, bgcek, nominal, dk)VALUES('$user','$tgl_jurnal','$no_jurnal','$no_ref[$x]','$id_perkiraan','$ket[$x]','$bgcek[$x]','$nominal[$x]', '$dk[$x]')";
						$qry=mysql_query($query) or die(mysql_error());
						}}
					}
					header('location:../../oklogin.php?module='.$module);
				}
		elseif ($module=='kas' AND $act=='edit'){
			
			$query = "UPDATE jurnal SET tgl  = '$_POST[tgl]', 
										no_ref  = '$_POST[no_ref]', 
										ket	 = '$_POST[ket]', 
										nominal  = '$_POST[nominal]', 
										dk = '$_POST[dk]' 
					WHERE id_jurnal = '$_POST[id_jurnal]'";
			$sql = mysql_query ($query) or die (mysql_error());
			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus SPP
		elseif ($module=='kas' AND $act=='hapus'){
			mysql_query("DELETE FROM jurnal WHERE id_jurnal='$_GET[id]'");
			header('location:../../oklogin.php?module='.$module);
		}

        // Cetak Excel
		elseif ($module=='kas' AND $act=='savetoexcel'){
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
							$kode_perkiraan='1.1.01.002';

					?>
							<h3>Periode : <?=date('d-M-Y',strtotime($tgl_aw))?> s/d <?=date('d-M-Y',strtotime($tgl_ak))?></h3> 
					<?php
	
							$query3=mysql_query("select * from perkiraan where id_perkiraan='60'");
							$hasil3=mysql_fetch_array($query3);
							
					?>
							Kode Rekening : <?=$kode_perkiraan?> - <?=$hasil3['nm_perkiraan']?>
							<table border="1">
									<thead bgcolor=#A5B4EC>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Keterangan</th>
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
											<td>Saldo Awal </td>
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
													
											</td>
											<td><?=$saldo_aw?></td>
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
														<td><?=$hasil['ket']?></td>
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
        
		// cetak SPP
		elseif ($module=='kas' AND $act=='cetakkeu'){
			function num($rp){

				if($rp!=0){

					$hasil = number_format($rp, 0, '.', ',');

				}

				else {

					$hasil=0;

				}

			    return $hasil;

			}
    		?>
    		    <html>
                	<head>
                		<title>PERUMAHAN GRAND ALOHA</title>
                		
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
                		<h3>PERUMAHAN GRAND ALOHA</h3>
                		<?php
							$ref=$_GET['id'];
							$substrref=substr($ref,0,3);
							if ($substrref=="BKM"){
						?>
                		<left><h1 style="color: aqua"><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: aqua">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php } 
						else if ($substrref=="BKK"){
						?>
                		<left><h1 style="color: coral"><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: coral">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php } 
							else if ($substrref=="BBK"){
						?>
                		<left><h1 style="color:red"><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: red">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php } 
							else if ($substrref=="BBM"){
						?>
                		<left><h1 style="color: blue"><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: blue">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php } 
								else {
						?>
                		<left><h1><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: blue">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php } 
						?>
						
                							<thead>
                							<tbody>
                							<?php
												$no=1;
												$jml=0;
												$query="SELECT * FROM jurnal as j
												JOIN perkiraan as p on j.id_perkiraan=p.id_perkiraan
												WHERE no_ref= '$_GET[id]'";
												$qry=mysql_query($query);
												while ($hasil=mysql_fetch_array($qry)){
													$tgl=$hasil['tgl'];
													$nominal=$hasil['nominal'];
													$jml=$jml+$nominal;
											?>
                											<tr>
                												<td><?=$no?></td>
                												<td><?=$hasil['nm_perkiraan']?></td>
                												<td><?=$hasil['ket']?></td>
                												<td align="right"><?=num($nominal).".-"?></td>
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
               												</tr>
                										<?php
                										$no++;
                									}
                								?>
                								<tr>
                									<td colspan="3" align="right"> T O T A L</td>
                									<td align="right"><?=num($jml).".-"?></td>
                								</tr>
                							<tbody>
                						</table>
                						<p>Surabaya, Tanggal : <?=date("d M Y", strtotime($tgl))?></p>
                						<table>							
                							<tr>
                								<td width="20%">
                									DIBUAT OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>ROSITANO</u>
                									</br>
                									KEUANGAN
                								</td>
                								<td width="40%">
                									DISETUJUI OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>YUFI AMROZI</u> <a style="margin-left:120;"><u>YOCE</u></a> 
                									</br>
                									</br>
                								</td>
                								<td width="20%">
                									DIKETAHUI OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>
                									MELLY
                									</u>
                									</br>
                									AKUNTAN
                								</td>
                								<td  width="20%">
                									DITERIMA OLEH,
                									</br>
                									</br>
                									</br>
                									</br>
                									<u>
                									.....................
                									</u>
                									</br>
                									Penerima
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
	
?>
