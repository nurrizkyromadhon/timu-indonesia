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
		if ($module=='coordinat' AND $act=='save_coord'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_user($date).xls");
?>
									<table border="1">
										<thead>
											<tr>
												<Th>No</Th>
												<Th>Block</Th>	
												<Th>X</Th>
												<Th>Y</Th>
												<Th>id_indikasi</Th>
											</tr>
										</thead>
										<?php
											$no='1';
											$query=(mysql_query("select * from coord order by id_coord asc "));
												while ($hasil=mysql_fetch_array($query)){
										?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['block']?></td>
												<td><?=$hasil['x']?></td>
												<td><?=$hasil['y']?></td>
												<td><?=$hasil['id_indikasi']?></td>
											</tr>
											<?php
											$no++ ; }
											?>
									</table>
<?php			
		}
		
		// Save Kosong Excel
		elseif ($module=='home' AND $act=='save_kosong'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_Rumah($date).xls");
?>			
									  <table border="1">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>TYPE</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select * from nasabah as n
										join harga as h on n.id_harga=h.id_harga
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
											if($hasil['nama_user']==''){
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['tipe']?></td>
											<td><?=$hasil['harga']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } }
									  ?>
									  </tbody>
									</table>
<?php									

		}

		// Update user
		elseif ($module=='userslevel' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM users_level WHERE  id_users_level = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
