<?
include 'config.php';

$tgl=$_GET['tgl'];
$nm_user=$_GET['nm_user'];
$lokasi=$_GET['lokasi'];
$x=$_GET['coordx'];
$y=$_GET['coordy'];
$img=$_GET['img'];
$ket=$_GET['ket'];


$query="insert into input (tgl, nm_user, lokasi, x, y, img, ket) Values ('$tgl','$nm_user','$lokasi','$x','$y','$img','$ket')";
$sql=mysql_query($query);

?>
<script language="javascript">window.location.href="pointgif2.php"</script>

