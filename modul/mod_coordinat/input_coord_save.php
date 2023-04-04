<?
include '../../config/koneksi.php';

$tgl		=date('Y-m-d');
$siteplant=$_GET['siteplant'];
$user		=$_SESSION['user'];
$nm_perumh  =$_GET['nm_perumh'];
$nm_perush	=$_GET['nm_perush'];
$lb_tanah	=$_GET['lb_tanah'];
$pj_tanah	=$_GET['pj_tanah'];
$ls_tanah	=$_GET['ls_tanah'];
$hock		=$_GET['hock'];
$block		=$_GET['kavling'];
$type		=$_GET['type'];
$x			=$_GET['coordx'];
$y			=$_GET['coordy'];
$img		=$_GET['img'];
$ket		=$_GET['ket'];

$query="select * from nm_perush where siteplant='$siteplant' ";
$qry=mysql_query($query);
$hasil=mysql_fetch_array($qry);
$lokasi		=$hasil['lokasi'];

$query="insert into coord (user, tgl,nm_perush,nm_perumh,siteplant, lokasi, lb_tanah, pj_tanah, ls_tanah, hock, block, type, x, y, img, ket) Values ('$user','$tgl','$nm_perush','$nm_perumh','$siteplant','$lokasi','$lb_tanah','$pj_tanah','$ls_tanah','$hock','$block','$type','$x','$y','$img','$ket')";
$sql=mysql_query($query);

?>
<script language="javascript">window.location.href="input_coord1.php?siteplant=<?=$siteplant?>"</script>

