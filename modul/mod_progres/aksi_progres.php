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
if ($module=='progres' AND $act=='hapus'){
  mysql_query("DELETE FROM progres WHERE id_progres='$_GET[id]'");
  header('location:../../oklogin.php?module='.$module);
}

// Input modul
elseif ($module=='progres' AND $act=='tambah'){

  // Input data modul
  mysql_query("INSERT INTO progres(tgl_progres,nm_pemborong,ob,id_coord_progres,prosen_progres,ket) VALUES ('$_POST[tgl_progres]','$_POST[nm_pemborong]','$_POST[ob]','$_POST[id_coord]','$_POST[prosen_progres]','$_POST[ket]')");
      
								
								
 header('location:../../oklogin.php?module='.$module);
}

// Update modul
elseif ($module=='progres' AND $act=='edit'){
$id=$_POST['id'];
  mysql_query("UPDATE progres SET tgl_progres = '$_POST[tgl_progres]',nm_pemborong='$_POST[nm_pemborong]',ob='$_POST[ob]',id_coord_progres = '$_POST[id_coord]',prosen_progres = '$_POST[prosen_progres]',ket = '$_POST[ket]'
                                  WHERE id_progres = '$id'");

				  
						  
header('location:../../oklogin.php?module='.$module);
}
}
?>
