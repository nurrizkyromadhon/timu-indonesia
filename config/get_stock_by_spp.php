<?php
	include "koneksi.php";
	$query="SELECT id_spp_sparepart, item_name, part_no, satuan, id_site from spp_sparepart INNER JOIN spp ON spp.id_spp = spp_sparepart.id_spp";
	$qry=mysql_query($query);
	while ($hasil=mysql_fetch_array($qry)){
		$query2 = "SELECT id_sparepart from sparepart WHERE item_name = '".$hasil['item_name']."' AND part_no = '".$hasil['part_no']."' AND satuan = '".$hasil['satuan']."'";
		$qry2=mysql_query($query2);
		$num_rows = mysql_num_rows($qry2);
		if($num_rows == 0) {
			$query3 = "INSERT INTO sparepart (item_name, part_no, satuan)VALUES('".$hasil['item_name']."','".$hasil['part_no']."','".$hasil['satuan']."')";
			$sql3 = mysql_query ($query3) or die (mysql_error());
			$id_sparepart = mysql_insert_id();
			$query4 = "UPDATE spp_sparepart SET id_sparepart  = '".$id_sparepart."' WHERE id_spp_sparepart = '".$hasil['id_spp_sparepart']."'";
			$sql4 = mysql_query ($query4) or die (mysql_error());
			
			$query5 = "SELECT id_stock from stock WHERE id_sparepart = '".$id_sparepart."' AND id_site = '".$hasil['id_site']."'";
    		$qry5=mysql_query($query5);
    		$num_rows2 = mysql_num_rows($qry5);
    		if($num_rows2 == 0) {
    		    $query6 = "INSERT INTO stock (id_sparepart, id_site)VALUES('".$id_sparepart."','".$hasil['id_site']."')";
			    $sql6 = mysql_query ($query6) or die (mysql_error());   
    		}
		}
		else {
			while ($hasil2=mysql_fetch_array($qry2)){
				$query3 = "UPDATE spp_sparepart SET id_sparepart  = '".$hasil2['id_sparepart']."' WHERE id_spp_sparepart = '".$hasil['id_spp_sparepart']."'";
				$sql3 = mysql_query ($query3) or die (mysql_error());
				
				$query5 = "SELECT id_stock from stock WHERE id_sparepart = '".$hasil2['id_sparepart']."' AND id_site = '".$hasil['id_site']."'";
        		$qry5=mysql_query($query5);
        		$num_rows2 = mysql_num_rows($qry5);
        		if($num_rows2 == 0) {
        		    $query6 = "INSERT INTO stock (id_sparepart, id_site)VALUES('".$hasil2['id_sparepart']."','".$hasil['id_site']."')";
    			    $sql6 = mysql_query ($query6) or die (mysql_error());   
        		}
			}
		}
	}
?>