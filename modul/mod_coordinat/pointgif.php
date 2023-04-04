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
	window.open.event('pointgif_pop.php');
}
</script>
<div style="width:900px; height: 600px; position:absolute; top:0; left:0; "><img src="images/siteplan1.jpg" onClick="showCoords(event);" width="100%" height="550"/>
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
//----------------------------------------------------------------- hasil point simbol V
?>
<div style="position: absolute; top: <?=$y?>; left: <?=$x?>;">
<a href="" onClick="window.open('pointgif2_view.php?no=<?=$no?>', 'winpopup', 'toolbar=no,statusbar=no,menubar=no,resizable=no,scrollbars=no,width=350,height=400')"><img src="images/<?=$img?>" width="10" height="15"></a>
</div>
<?  } ?> 
</div>
<div style="width:98%; border:1px solid black; position:absolute; bottom:0px; right:10px; left:10px;">
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
