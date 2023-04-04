<?
include 'config.php';
?>
<script type="text/javascript">
function showCoords(event) {
    var x = event.clientX;
    var y = event.clientY;
    var coords1 =  x ;
	var coords2 =  y ;
    document.getElementById("coordx").innerHTML = coords1;
	document.getElementById("coordy").innerHTML = coords2;
	document.myform.coordx.value = coords1;
	document.myform.coordy.value = coords2;
}
</script>
<div style="width:900px; height: 500px; position:absolute; top:0; left:0; "><img src="images/siteplan1.jpg" onclick="showCoords(event)" width="100%" height="550" />
  <?
$query="select * from input ";
$qry=mysql_query($query);
while ($hasil=mysql_fetch_array($qry)){
$x1=$hasil['x'];
$x=$x1-5;
$y1=$hasil['y'];
$y=$y1-15;
$nm_user=$hasil['nm_user'];
$lokasi=$hasil['lokasi'];
$no=$hasil['no'];

$img=$hasil['img'];
?>
<div style="position: absolute; top: <?=$y?>; left: <?=$x?>;">
<a href="pointgif3.php?no=<?=$no?>"><img src="images/<?=$img?>" width="10" height="15"></a>
</div>
<?  } ?>  
</div>

<div style="width:390px; padding: 10px; border: 1px solid red; position: absolute; top: 10; right: 10px; text-align: center;">
<table width="100%">
<?
$no=$_GET['no'];
$query="select * from input where no='$no'";
$qry=mysql_query($query);
$hasil=mysql_fetch_array($qry);
$tgl=$hasil['tgl'];
$lokasi=$hasil['lokasi'];
$harga=$hasil['harga'];
$bokingfee=$hasil['bokingfee'];
$dp=$hasil['dp'];
$finance=$hasil['finance'];
$nm_user=$hasil['nm_user'];
$ket=$hasil['ket'];


?>
<tr>
  <td colspan="2" align="center"><img src="images/images.jpg" width="155" height="122" /><br /> Foto Update Per Tanggal xxxx<p><p></td>
</tr>
<tr>
  <td width="48%">Lokasi Block </td>
  <td width="52%">:
    <?=$lokasi?></td>
</tr>
<tr>
  <td>Harga Rumah </td>
  <td>: <?=$harga?> </td>
</tr>
<tr>
  <td>Nama User</td>
  <td>: <?=$nm_user?> </td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
  <td>Created ...........</td>
  <td>:</td>
</tr>
<tr>
<td>Keterangan</td>
<td>: <?=$ket?></td>
</tr>
</table>
</div>
<div style="width:98%; border:1px solid black; position:absolute; bottom:10px; right:10px; left:10px;">
<table width="100%">
<tr>
<td>Total Rumah Dijual : xxx</td>
<td></td>
<td></td>
</tr>
<tr>
<td>Total Rumah Proses Followup : xxx</td>
<td></td>
<td></td>
</tr>
<tr>
<td>Total Rumah Proses Angsuran DP : xxx</td>
<td></td>
<td></td>
</tr>
<tr>
<td>Total Rumah Proses AJB : xxx</td>
<td></td>
<td></td>
</tr>
</table>
</div>