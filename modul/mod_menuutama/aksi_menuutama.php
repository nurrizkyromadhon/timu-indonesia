<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";
include "../../config/fungsi_seo.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus menu utama
if ($module=='menuutama' AND $act=='hapus'){
  mysql_query("DELETE FROM mainmenu WHERE id_main='$_GET[id]'");
  header('location:../../oklogin.php?module='.$module);
}

// Input menu utama
if ($module=='menuutama' AND $act=='tambah'){
  mysql_query("INSERT INTO mainmenu(nama_menu,icon,link,aktif) VALUES('$_POST[nama_menu]','$_POST[icon]','$_POST[link]','$_POST[aktif]')");
  header('location:../../oklogin.php?module='.$module);
}

// Update menu utama
elseif ($module=='menuutama' AND $act=='edit'){
  mysql_query("UPDATE mainmenu SET nama_menu='$_POST[nama_menu]', icon='$_POST[icon]', link='$_POST[link]', aktif='$_POST[aktif]'
               WHERE id_main = '$_POST[id]'");
  header('location:../../oklogin.php?module='.$module);
}
}
?>
