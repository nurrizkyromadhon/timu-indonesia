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
		if ($module=='pajak' AND $act=='input'){
			if (isset($_POST['tanggal'])) {
				$user=$_SESSION['username'];
				$id_jurnal=$_POST['id_jurnal'];
				$tgl_jurnal=$_POST['tanggal'];
				$no_jurnal=$_POST['no_jurnal'];
				$no_ref=$_POST['no_ref'];
				$id_perkiraan=$_POST['id_perkiraan'];
				
				
				//$nm_perkiraan=$_POST['nm_perkiraan'];
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
					for($x=0; $x < count($id_perkiraan); $x++) {
					
						
						$query = "INSERT INTO pajak (user,id_jurnal, tgl, no_jurnal, no_ref, id_perkiraan, ket, nominal, dk)VALUES('$user','$id_jurnal[$x]','$tgl_jurnal','$no_jurnal[$x]','$no_ref','$id_perkiraan[$x]','$ket[$x]','$nominal[$x]', '$dk[$x]')";
						$qry=mysql_query($query) or die(mysql_error());
						}
					} 
					header('location:../../oklogin.php?module='.$module);
				}
	
	    // Save excel
		elseif ($module=='pajak' AND $act=='save_excel'){	
		    
		    $tgl1=$_GET['tgl1'];
		    $tgl2=$_GET['tgl2'];
		    $date=date('Ymd');
		    
		    header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=BKK_bKM_BBK_BBM($date).xls");
		    ?>
		                            <table border="1" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>No.</th>
														<th>Tanggal</th>
														<th>No.Reff</th>
														<th>Keterangan</th>
														<th>Nominal</th>
														<th>Total Nominal</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$no=1;
														$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl1' AND '$tgl2' group by no_ref ORDER BY tgl desc";
														$qry=mysql_query($query);
														while ($hasil=mysql_fetch_array($qry)){
															$no_ref=$hasil['no_ref'];
															$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
															$qry2=mysql_query($query2);
															$hasil2=mysql_fetch_array($qry2);
															?>
																<tr>
																	<td><?=$no?></td>
																	<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
																	<td><?=$no_ref?></td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo $hasil_detail['ket']."<br />"; 
																			}
															
																		?>
																	</td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo num($hasil_detail['nominal'])."<br />"; 
																			}
															
																		?>
																	</td>
																	<td><?=num($hasil['jml'])?></td>
																</tr>
															<?php
															$no++;
														}
													?>
												</tbody>
											</table>
		                                <?php
		                               header('location:../../oklogin.php?module='.$module); 
		    
		}	
	
		// Update user
		elseif ($module=='pajak' AND $act=='update'){
			if (isset($_POST['tanggal'])) {
				
				$user=$_SESSION['username'];
				$id_jurnal=$_POST['id_jurnal'];
				$tgl=$_POST['tanggal'];
				$no_ref=$_POST['no_ref'];
				$ket=$_POST['ket'];
				$nominal=$_POST['nominal'];
				
				/*$kode_perkiraan=substr($_POST['kode_perkiraan'],10,0);
				
					for($a=0; $a < count($no_ref); $a++) {
						$qry_id=mysql_query("Select id_perkiraan from perkiraan where kode_perkiraan='$kode_perkiraan'");
						$hasil_id=mysql_fetch_array($qry_id);
						$id_perkiraan=$hasil_id['id_perkiraan'];
					}*/
				
				}
			for($x=0; $x < count($id_jurnal); $x++) {
			$query = "UPDATE pajak SET 	user	= '$user[$x]',
										ket		= '$ket[$x]', 
										nominal = '$nominal[$x]'
					 WHERE id_jurnal = '$id_jurnal[$x]'";
			$sql = mysql_query ($query) or die (mysql_error());
			}
			$query = "DELETE FROM pajak WHERE  id_jurnal = '$_POST[id_jurnal]'";
			$sql = mysql_query ($query) or die (mysql_error());
			
			/*for($x=0; $x < count($no_ref); $x++) {
					$query = "INSERT INTO pajak (user,id_jurnal, tgl, no_jurnal, no_ref, id_perkiraan, ket, nominal, dk)VALUES('$user','$id_jurnal[$x]','$tgl_jurnal','$no_jurnal[$x]','$no_ref','$id_perkiraan[$x]','$ket[$x]','$nominal[$x]', '$dk[$x]')";
					$qry=mysql_query($query) or die(mysql_error());
			}*/
			
			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus SPP
		elseif ($module=='pajak' AND $act=='hapus'){
			mysql_query("DELETE FROM pajak WHERE no_ref='$_GET[id]' and tgl='$_GET[tgl]'");
			header('location:../../oklogin.php?module='.$module);
		}

		// cetak SPP
		elseif ($module=='pajak' AND $act=='cetakkeu'){
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
							if ($substrref=="BKK"){
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
												$query="SELECT * FROM pajak as j
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
