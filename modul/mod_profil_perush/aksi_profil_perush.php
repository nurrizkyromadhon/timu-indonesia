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
		
		$id=$_POST['id'];
		
		$user=$_SESSION['username'];
		$nm_perush=$_POST['nm_perush'];
		$nm_perumh=$_POST['nm_perumh'];
		$lokasi=$_POST['lokasi'];

		$logo_name= $_FILES['logo']['name'];
		$logo_tmp=$_FILES['logo']['tmp_name'];

		$brosur_name= $_FILES['brosur']['name'];
		$brosur_tmp=$_FILES['brosur']['tmp_name'];

		$siteplant_name=$_FILES['siteplant']['name'];
		$siteplant_tmp=$_FILES['siteplant']['tmp_name'];

		// Input user
		if ($module=='profil_perush' AND $act=='input'){

			move_uploaded_file($logo_tmp,"../../images/nm_perush/logo/".$logo_name);
			move_uploaded_file($brosur_tmp,"../../images/nm_perush/brosur/".$brosur_name);
			move_uploaded_file($siteplant_tmp,"../../images/nm_perush/siteplan/".$siteplant_name);

			$sql="insert into nm_perush (member,nm_perush,nm_perumh,lokasi,logo,brosur,siteplant) values ('$user','$nm_perush','$nm_perumh','$lokasi','$logo_name','$brosur_name','$siteplant_name')";
			$res=mysql_query($sql) or die (mysql_error());
			
			header('location:../../oklogin.php?module='.$module);
		}
		// Edit user
		elseif ($module=='profil_perush' AND $act=='edit'){
			
			move_uploaded_file($logo_tmp,"../../images/nm_perush/logo/".$logo_name);
			move_uploaded_file($brosur_tmp,"../../images/nm_perush/brosur/".$brosur_name);
			move_uploaded_file($siteplant_tmp,"../../images/nm_perush/siteplan/".$siteplant_name);
			
			mysql_query("UPDATE nm_perush SET member = '$user', nm_perush = '$nm_perush', nm_perumh = '$nm_perumh', lokasi = '$lokasi', logo = '$logo_name', brosur = '$brosur_name', siteplant = '$siteplant_name' 
			WHERE id_users_level = '$id'");
												 
										
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_POST['id']);
			$id_modul = $_POST['id_modul'];
			
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($_POST[id], '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus user
		elseif ($module=='profil_perush' AND $act=='hapus'){
			mysql_query("DELETE FROM nm_perush WHERE  no = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
