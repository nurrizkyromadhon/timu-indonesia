<?php
include'config/koneksi.php';
$query=mysql_query("select * from coord 
join users on coord.id_users=users.id_users 
join profil on coord.id_profil=profil.id_profil
where coord.id_profil='1'");
while ($hasil=mysql_fetch_array($query)){
	$id_coord=$hasil['id_coord'];
	$username=$hasil['username'];
	$x=$hasil['x'];
	$y=$hasil['y'];
	$tgl=$hasil['tgl'];
	$img=$hasil['img'];
?>
<?=$tgl?> - <?=$id_coord?> - <?=$x?> - <?=$y?> - <?=$img?> - <?=$username?> <br>
<?	
}
?>
