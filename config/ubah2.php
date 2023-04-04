<?php


// definisikan koneksi ke database

$server = "localhost";
$username = "root";
$password = "";
$database = "timudb";

//$password = "afifjuna779971";
//$database = "atmmaini_timudb";



// Koneksi dan memilih database di server

mysql_connect($server,$username,$password) or die("Koneksi gagal");

mysql_select_db($database) or die("Database tidak bisa dibuka");


$query=mysql_query("SELECT * FROM pf_log");


while($hasil=mysql_fetch_array($query)){
    $shipment=$hasil['shipment']; 
    $id_pf_log=$hasil['id_pf_log']; 
    mysql_query ("UPDATE pf_log SET shipment='HANDLING $shipment' WHERE id_pf_log = $id_pf_log AND shipment not like 'HANDLING%'");?>
    
<?php }
// buat variabel untuk validasi dari file fungsi_validasi.php

?>

