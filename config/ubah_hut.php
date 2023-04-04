<?php


// definisikan koneksi ke database

$server = "localhost";
$username = "root";
$password = "";
$database = "timudb";

//$password = "afifjuna779971";
//$database = "atmmaini_timudb";



// Koneksi dan memilih database di server

mysql_connect($server, $username, $password) or die("Koneksi gagal");

mysql_select_db($database) or die("Database tidak bisa dibuka");


$query = mysql_query("SELECT * from pf_log");

$no = 1;
while ($hasil = mysql_fetch_array($query)) {
    $id_pf_log = $hasil['id_pf_log'];
    $no_jo = substr($hasil['no_jo'], 5, 10);
    $query_log = mysql_query("SELECT * from pf_real_cost
					where category1 = 'HUTANG LAIN' AND category2 = 'HUT' and id_pf_log=0 and ((kegiatan LIKE 'HUTANG PPH%' or kegiatan LIKE 'HUTANG PPN%') and kegiatan like '%$no_jo%') order by id_pf_real_cost");
    while ($hasil_log = mysql_fetch_array($query_log)) {
        $id_pf_real_cost = $hasil_log['id_pf_real_cost'];
        echo $no . "-" . $id_pf_real_cost;
        mysql_query("UPDATE pf_real_cost SET id_pf_log='$id_pf_log' WHERE category1 = 'HUTANG LAIN' AND category2 = 'HUT' and id_pf_log=0 and ((kegiatan LIKE 'HUTANG PPH%' or kegiatan LIKE 'HUTANG PPN%') and kegiatan like '%$no_jo%')");
?>
    
<?php $no++;
    }
}
// buat variabel untuk validasi dari file fungsi_validasi.php

?>

