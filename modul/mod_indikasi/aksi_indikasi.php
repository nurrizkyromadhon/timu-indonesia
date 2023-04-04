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
		if ($module=='indikasi' AND $act=='input'){
			
			$point_name= $_FILES['point']['name'];
			$point_tmp=$_FILES['point']['tmp_name'];
			mysql_query("INSERT INTO indikasi (indikasi,gambar) VALUES ('$_POST[indikasi]','$point_name')");
			move_uploaded_file($point_tmp,"../../images/".$point_name);
															
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
		elseif ($module=='indikasi' AND $act=='update'){
			
			$point_name= $_FILES['point']['name'];
			$point_tmp=$_FILES['point']['tmp_name'];
			mysql_query("UPDATE indikasi SET indikasi='$_POST[indikasi]', gambar='$point_name' WHERE id_indikasi='$_POST[id]'");
			
			move_uploaded_file($point_tmp,"../../images/".$point_name);
											   
										
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
		elseif ($module=='indikasi' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM indikasi WHERE  id_indikasi = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
