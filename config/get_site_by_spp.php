<?php
	include "koneksi.php";
	$query="SELECT id_spp, site from spp";
	$qry=mysql_query($query);
	while ($hasil=mysql_fetch_array($qry)){
		$query2 = "SELECT id_site from site WHERE nama_site = '".$hasil['site']."'";
		$qry2=mysql_query($query2);
		$num_rows = mysql_num_rows($qry2);
		if($num_rows == 0) {
			$query3 = "INSERT INTO site (nama_site)VALUES('".$hasil['site']."')";
			$sql3 = mysql_query ($query3) or die (mysql_error());
			$id_site = mysql_insert_id();
			$query4 = "UPDATE spp SET id_site  = '".$id_site."' WHERE id_spp = '".$hasil['id_spp']."'";
			$sql4 = mysql_query ($query4) or die (mysql_error());
		}
		else {
			while ($hasil2=mysql_fetch_array($qry2)){
				$query3 = "UPDATE spp SET id_site  = '".$hasil2['id_site']."' WHERE id_spp = '".$hasil['id_spp']."'";
				$sql3 = mysql_query ($query3) or die (mysql_error());
			}
		}
	}
?>