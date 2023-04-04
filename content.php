<?php
	include "config/koneksi.php";
	include "config/library.php";
	include "config/fungsi_indotgl.php";
	include "config/fungsi_combobox.php";
	include "class_paging.php";

	$content = mysql_query("SELECT * FROM permission, modul WHERE permission.id_modul = modul.id_modul AND permission.id_users_level = ".$_SESSION['id_users_level']);
	$flag=true;
	while ($r=mysql_fetch_array($content)){
		if ($_GET['module']==$r['key_modul']){
			include "modul/".$r['link_modul'];
			$flag=false;
		}
	}
	// Apabila modul tidak ditemukan
	if($flag){
	  echo "<p><b>MODUL BELUM ADA ATAU BELUM LENGKAP</b></p>";
	}
?>
