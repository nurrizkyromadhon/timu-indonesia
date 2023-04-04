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
		if ($module=='userslevel' AND $act=='input'){
			mysql_query("INSERT INTO users_level(users_level,
										users_level_key) 
								   VALUES('$_POST[users_level]',
										'$_POST[users_level_key]')");
			$last_id = mysql_insert_id();
			$id_modul = $_POST['id_modul'];
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($last_id, '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='userslevel' AND $act=='update'){
			mysql_query("UPDATE users_level SET users_level   		= '$_POST[users_level]',
												users_level_key   	= '$_POST[users_level_key]' 
										WHERE  id_users_level  	= '$_POST[id]'");
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_POST['id']);
			$id_modul = $_POST['id_modul'];
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($_POST[id], '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
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
