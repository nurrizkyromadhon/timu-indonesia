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
		if ($module=='site' AND $act=='input'){
			if (isset($_POST['nama_site'])) {
				$nama_site=$_POST['nama_site'];
				$alamat=$_POST['alamat'];
				$dibuat=$_POST['dibuat'];
				$jab1=$_POST['jab1'];
				$disetujui=$_POST['disetujui'];
				$jab2=$_POST['jab2'];
				$diketahui=$_POST['diketahui'];
				$jab3=$_POST['jab3'];
				$tambahan=$_POST['tambahan'];
				$jab4=$_POST['jab4'];
				$kode=$_POST['kode'];
			}
			if (empty($nama_site)){
					echo "Nomor Nama Site Belom Terisi ... !";
					echo "<br/>";
				}else {
					$query = "INSERT INTO site (nama_site, alamat, dibuat, jab1, disetujui, jab2, diketahui, jab3, tambahan, jab4, kode)VALUES('$nama_site','$alamat','$dibuat','$jab1','$disetujui','$jab2','$diketahui','$jab3','$tambahan','$jab4','$kode')";
					$sql = mysql_query ($query) or die (mysql_error());
					header('location:../../media.php?module='.$module);
				}
		}

		// Update user
		elseif ($module=='site' AND $act=='update'){
			if (isset($_POST['id_site'])){
				$id_site=$_POST['id_site'];
				$nama_site=$_POST['nama_site'];
				$alamat=$_POST['alamat'];
				$dibuat=$_POST['dibuat'];
				$jab1=$_POST['jab1'];
				$disetujui=$_POST['disetujui'];
				$jab2=$_POST['jab2'];
				$diketahui=$_POST['diketahui'];
				$jab3=$_POST['jab3'];
				$tambahan=$_POST['tambahan'];
				$jab4=$_POST['jab4'];
				$kode=$_POST['kode'];
			}
			$query = "UPDATE site SET 
									nama_site  = '$nama_site', 
									alamat 		= '$alamat',
									dibuat 	 	= '$dibuat',
									jab1 	 	= '$jab1',
									disetujui 	= '$disetujui',
									jab2 	 	= '$jab2',
									diketahui 	= '$diketahui',
									jab3 	 	= '$jab3',
									tambahan 	= '$tambahan',
									jab4 	 	= '$jab4',
									kode		= '$kode'
									WHERE id_site = '$id_site'";
									
			
			$sql = mysql_query ($query) or die (mysql_error());
			
			header('location:../../media.php?module='.$module);
		}

		// Hapus SPP
		elseif ($module=='site' AND $act=='hapus'){
			mysql_query("DELETE FROM site WHERE id_site='$_GET[id]'");
			header('location:../../media.php?module='.$module);
		}
	}
?>
