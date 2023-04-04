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
<div style="width:900px; height: 550px; position:absolute; top:0; left:0; border: 1px solid black; border-bottom:1px solid black;"><img src="images/siteplan1.jpg" onclick="showCoords(event)" width="100%" height="550" />
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
<div style="position: absolute; left: <?=$x?>; top: <?=$y?>; ">
<a href="pointgif2_view.php?no=<?=$no?>"><img src="images/<?=$img?>" width="10" height="15"></a>
</div>
<?  } ?>  
</div>

<div style="width:300px; padding: 10px; border: 1px solid red; position: absolute; top: 10; right: 10px; text-align: center;">
<form name="myform" name="submit" action="pointgif2_save.php">
Koordinat :<br />
<input type="text" name="coordx" id="coordx" size="5" />
<br>
<input type="text" name="coordy" id="coordy" size="5" />
<br>
Tanggal :<br>
<input type="text" name="tgl" id="tgl" />
<br>
Nama User:<br> 
<input type="text" name="nm_user" id="nm_user"><br />
Lokasi :<br />
<input type="text" name="lokasi" id="lokasi" /><br />
Keterangan :<br />
<input type="text" name="ket" id="ket" />
<br>
Pilih Gambar :<br>
</p>
<input type="radio" name="img" <?php if (isset($img) && $img=="data.png") echo "checked";?>  value="data.png">data
<input type="radio" name="img" <?php if (isset($img) && $img=="jual.png") echo "checked";?>  value="jual.png">jual
<input type="radio" name="img" <?php if (isset($img) && $img=="legalitas.png") echo "checked";?>  value="legalitas.png">legalitas
<input type="radio" name="img" <?php if (isset($img) && $img=="serahterima.png") echo "checked";?>  value="serahterima.png">serahteima <br>
<input type="submit" name="submit" value="Simpan" />
<br> 


</form>
</div>