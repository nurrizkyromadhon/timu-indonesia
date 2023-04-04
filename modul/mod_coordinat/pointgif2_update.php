<?
include '../../config/koneksi.php';

$no			=$_GET['no'];
$tgl		=date('Y-m-d');
$siteplant 	=$_GET['siteplant'];
$user		=$_GET['user'];
$lokasi		-$_GET['lokasi'];
$ls_tanah	=$_GET['ls_tanah'];
$hock		=$_GET['hock'];
$lokasi		=$_GET['lokasi'];
$block		=$_GET['block'];
$type		=$_GET['type'];
$x			=$_GET['x'];
$y			=$_GET['y'];
$ket		=$_GET['ket'];
$img		=$_GET['img1'];

$query="update coord set user='$user', tgl='$tgl', lokasi='$lokasi', ls_tanah='$ls_tanah', hock='$hock', block='$block', type='$type', x='$x', y='$y', ket='$ket', img='$img' where no = '$no' ";
$sql=mysql_query($query) or die (mysql_error());

?>
<script language="javascript">window.location.href="input_coord1.php?siteplant=<?=$siteplant?>"</script>
