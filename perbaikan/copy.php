<?php
include "../config/koneksi.php";
$query=mysql_query("SELECT * FROM harga order by id_harga asc");
while ($hasil=mysql_fetch_array($query)){
	mysql_query("update nasabah set disc='$hasil[disc]' where id_harga='$hasil[id_harga]'");
}
?>