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


$query = mysql_query("SELECT * from pf_real_cost where category1 = 'HUT' and category2 = 'HUT'");


while ($hasil = mysql_fetch_array($query)) {
    $no_reff_keu = $hasil['no_reff_keu'];
    $id_pf_real_cost = $hasil['id_pf_real_cost'];
    $id_pf_log = $hasil['id_pf_log'];
    $real_cost = $hasil['real_cost'];
    $id_est_cost = $hasil['id_est_cost'];
    $id_hut2 = $hasil['id_hut2'];
    $query_hut = mysql_query("SELECT * from pf_real_cost 
					where category1 = 'HUT' and category2 = 'HUT'");
    while ($hasil_hut = mysql_fetch_array($query_hut)) {
        $id_hut22 = $hasil_hut['id_hut2'];
        //mysql_query("UPDATE pf_real_cost SET id_hut2='$id_pf_real_cost' WHERE id_pf_log= '$id_pf_log' and id_est_cost = '$id_est_cost' and no_reff_keu like '$no_reff_keu%' AND real_cost = '$real_cost' and kegiatan like '%$no_jo%' AND category1 = 'HUT' and category2 = 'HUT'"); 
        if ($id_hut2 == $id_hut22) { ?>
            <p><?= $id_pf_real_cost ?></p><br>
<?php }
    }
}
// buat variabel untuk validasi dari file fungsi_validasi.php

?>