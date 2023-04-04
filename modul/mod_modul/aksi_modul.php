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

// Hapus modul
if ($module=='modul' AND $act=='hapus'){
  mysql_query("DELETE FROM modul WHERE id_modul='$_GET[id]'");
  header('location:../../oklogin.php?module='.$module);
}

// Input modul
elseif ($module=='modul' AND $act=='tambah'){
  // Cari angka urutan terakhir
  $u=mysql_query("SELECT * FROM modul");
  $d=mysql_fetch_array($u);
  $urutan=$d[urutan]+1;
  
  // Input data modul
  mysql_query("INSERT INTO modul(nama_modul,
                                 key_modul,
                                 link_modul,
                                 aktif) 
	                       VALUES('$_POST[nama_modul]',
                                '$_POST[key_modul]',
                                '$_POST[link_modul]',
                                '$_POST[aktif]')");
  header('location:../../oklogin.php?module='.$module);
}

// Update modul
elseif ($module=='modul' AND $act=='edit'){
  mysql_query("UPDATE modul SET nama_modul = '$_POST[nama_modul]',
                                key_modul       = '$_POST[key_modul]',
                                link_modul       = '$_POST[link_modul]',
                                aktif      = '$_POST[aktif]'
                          WHERE id_modul   = '$_POST[id]'");
  header('location:../../oklogin.php?module='.$module);
}
}
?>
