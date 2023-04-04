<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";

		$module=$_GET['module'];
		$act=$_GET['act'];
		$date=date('Y-m-d');

		// Save Terjual Excel
		if ($module=='home' AND $act=='save_belom_terjual'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_user($date).xls");
?>	
								<label>KAVLING BELOM TERJUAL</label>
								 <table border="1">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>FPR</th>
										  <th>PPJB</th>
										  <th>OB</th>
										  <th>HARGA JUAL</th>
										  <th>DISCOUNT</th>
										  <th>CASHBACK</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *,n.um,n.kpr,n.cb,n.disc from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										left join harga as h on n.id_harga=h.id_harga
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi ='1'
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['tipe']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['harga']?></td>
											<td><?=$hasil['disc']?></td>
											<td><?=$hasil['cb']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
<?php			
		}
		
		// Save Kosong Excel
		elseif ($module=='home' AND $act=='save_kosong'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_Rumah($date).xls");
?>			
								  <label>KAVLING SUDAH TERJUAL</label>
									  <table border="1">
									  <thead>
									  <tr>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>FPR</th>
										  <th>OB</th>
										  <th>TYPE</th>
										  <th>HARGA JUAL</th>
										  <th>DISCOUNT</th>
										  <th>CASHBACK</th>
										  <th>KPR</th>
										  <th>UM</th>
										  <th>TGL BELI</th>
										  <th>TGL REAL</th>
										  <th>REAL dan BLOM AKAD</th>
									  </tr> 
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select *,n.um,n.kpr,n.cb,n.disc,n.harga_jual from nasabah as n
										
										join coord as c on n.id_cord=c.id_coord 
										left join harga as h on n.id_harga=h.id_harga
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi!='1'
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['harga_jual']?></td>
											<td><?=$hasil['disc']?></td>
											<td><?=$hasil['cb']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
											<td><?=$hasil['tgl_beli']?></td>
											<td><?=$hasil['tgl_real']?></td>
											<td>
												<?php
										  		if($hasil['id_indikasi']==3){
												?>	
										  			Belum Akad
										  		<?php 
												}else if($hasil['id_indikasi']==5) {
												?>
													Real
												<?php	
												}
										  		?>
											</td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
<?php									

		}
		
		// Save Kosong Excel
		elseif ($module=='home' AND $act=='save_all'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_user($date).xls");
?>
								<table border="1">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>FPR</th>
										  <th>PPJB</th>
										  <th>OB</th>
										  <th>HARGA JUAL</th>
										  <th>DISCOUNT</th>
										  <th>CASHBACK</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *,n.um,n.kpr,n.cb,n.disc from nasabah as n
										
										join coord as c on n.id_cord=c.id_coord 
										left join harga as h on n.id_harga=h.id_harga
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['harga']?></td>
											<td><?=$hasil['disc']?></td>
											<td><?=$hasil['cb']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
<?php			
		}
		
		// Update hasil Cek control
		elseif ($module=='home' AND $act=='update_cek'){
			$cekitem=$_POST['cek_item'];
			
			for($a=0; $a < count($cekitem); $a++) {
				mysql_query("update jurnal set status = '1' WHERE  id_jurnal = " .$cekitem[$a]);
			}
			
			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='userslevel' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM users_level WHERE  id_users_level = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
