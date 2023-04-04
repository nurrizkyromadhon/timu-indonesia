<?php
include "../config/koneksi.php";
$no=1;
$query=mysql_query("select * from nasabah as n 
	join indikasi as i on n.id_indikasi=i.id_indikasi 
	join coord as c on n.id_cord=c.id_coord
	join profil as p on n.id_profil=p.id_profil
	where p.lokasi='BLOK A' and nama_user=''  ") or die(mysql_error());
?>
<table class="">
	<tr>
		<th>No</th>
		<th>Nama User</th>
		<th>Blok/Kav</th>
		<th>Kode Warna</th>
	</tr>

<?php
while ($hasil=mysql_fetch_array($query)){
?>
	<tr>
		<td><?=$no?></td>
		<td><?=$hasil['nama_user']?></td>
		<td><?=$hasil['coord']?></td>
		<td><img src="../images/<?=$hasil['gambar']?>" width="15" height="15"></td>
	</tr>

<?php
$no++; }
?>
</table>