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

		$module=$_GET['module'];
		$act=$_GET['act'];

		// Input user
		if ($module=='jurnal' AND $act=='input'){
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
					for($x=0; $x < count($nm_perkiraan); $x++) {
						$query0="SELECT id_perkiraan FROM perkiraan WHERE nm_perkiraan='$nm_perkiraan[$x]'";
						$qry0=mysql_query($query0);
						while ($hasil=mysql_fetch_array($qry0)){
						$id_perkiraan=$hasil['id_perkiraan'];
						
						$query = "INSERT INTO jurnal (user, tgl, no_jurnal, no_ref, id_perkiraan, ket, nominal, dk)VALUES('$user','$tgl_jurnal','$no_jurnal','$no_ref[$x]','$id_perkiraan','$ket[$x]','$nominal[$x]', '$dk[$x]')";
						$qry=mysql_query($query) or die(mysql_error());
						}}
					}
					header('location:../../oklogin.php?module='.$module);
				}
	
		elseif ($module=='jurnal' AND $act=='input_bg_cek'){
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
			if (empty($no_ref) and empty($nm_perkiraan)){
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
		elseif ($module=='jurnal' AND $act=='edit'){
			
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
		elseif ($module=='jurnal' AND $act=='hapus'){
			mysql_query("DELETE FROM jurnal WHERE id_jurnal='$_GET[id]'");
			header('location:../../oklogin.php?module='.$module);
		}

		// cetak SPP
		elseif ($module=='jurnal' AND $act=='cetakkeu'){
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
               			    else{
               			?>
                   		<left><h1 style="color: black"><?=$_GET['id']?></h1></left>
                					<div class="container">
                						<table>
                							<thead>
                								<tr style="color: blue">
                									<th>NO</th>
                									<th>NAMA REK</th>
                									<th>KETERANGAN</th>
                									<th>NOMINAL</th>
               									</tr>
               			<?php
               			    }
								
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
													$aproval=$hasil['aproval'];
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
                									<?php
                									if($aproval=='admin'){
                									?>
                									    <p style="margin-left:200;"><img src=../../images/nm_perush/aprove.png width="75" hight="75"></p>
                									<?php 
                									}else{
                									?>  
                									</br>
                									</br>
                									</br>
                									<?php    
                									}
                									?>
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
