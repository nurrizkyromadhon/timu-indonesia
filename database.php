<?php
include 'config/koneksi.php';

$no = 1;
$qry = mysql_query("SELECT * from pf order by id_pf asc");
while ($hasil = mysql_fetch_array($qry)) {
    echo $no;
    mysql_query("INSERT INTO pf_qty (id_pf_log, type1) VALUES ('$hasil[id_pf]','$hasil[qty_pf]')");
    $no++;
}



?>