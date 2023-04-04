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

		// Input user
		if ($module=='kode_perkiraan' AND $act=='input'){		 						
			$kode_perkiraan=$_POST['kode_perkiraan'];
			$nm_perkiraan = $_POST['nm_perkiraan'];
			for($x=0; $x < count($nm_perkiraan); $x++) {
				$query = "INSERT INTO perkiraan (kode_perkiraan, nm_perkiraan)
				VALUES('$kode_perkiraan[$x]', '$nm_perkiraan[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='kode_perkiraan' AND $act=='editperkiraan'){
			mysql_query("UPDATE perkiraan SET kode_perkiraan   	= '$_POST[kode_perkiraan]',
										  nm_perkiraan   		= '$_POST[nm_perkiraan]' 
										  WHERE  id_perkiraan  	= '$_GET[id]'");

			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='kode_perkiraan' AND $act=='hapus'){
		    //echo $_GET['id']; break;
			mysql_query("DELETE FROM perkiraan WHERE  id_perkiraan = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
