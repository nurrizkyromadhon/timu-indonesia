<?php
include'../config/koneksi.php';
	$query=mysql_query("select * from harga order by id_harga asc");
	while ($hasil=mysql_fetch_array($query)){
		
		$id_harga=$hasil['id_harga'];
		$block=$hasil['no_blok'];
		
		$query1="update nasabah set id_harga='$id_harga' where coord='$block' ";
		$qry1=mysql_query($query1);
		
			
	}
	
?>