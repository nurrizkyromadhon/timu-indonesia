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
			}
			if (empty($nama_site)){
					echo "Nomor Nama Site Belom Terisi ... !";
					echo "<br/>";
				}else {
					$query = "INSERT INTO site (nama_site, alamat)VALUES('$nama_site','$alamat')";
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
			}
			$query = "UPDATE site SET 
									nama_site  = '$nama_site', 
									alamat 	 = '$alamat' 
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
