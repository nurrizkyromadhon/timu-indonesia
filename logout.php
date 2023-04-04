<?php
session_start();
include "config/koneksi.php";
  $id_users=$_SESSION['id_users'];
  mysql_query("UPDATE users SET status_user='0' WHERE id_users='$id_users'");

  session_destroy();
  echo "<script>alert('Anda telah keluar dari halaman administrator'); window.location.href='index.php';</script>";
?>
