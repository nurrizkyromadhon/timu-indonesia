<?php
include '../../config/koneksi.php';
$no=$_GET['no'];
$nm_perush=$_GET['nm_perush'];

$query="select * from nasabah as n
	join coord as c on n.id_cord=c.id_coord 
	join indikasi as i on n.id_indikasi=i.id_indikasi
	join profil as p on n.id_profil=p.id_profil
	where id_coord='$no'";
$qry=mysql_query($query);
$hasil=mysql_fetch_array($qry);
$id_coord=$hasil['id_coord'];
$lokasi=$hasil['lokasi'];
$siteplant=$hasil['siteplant'];
$block=$hasil['block'];
$ls_tanah=$hasil['ls_tanah'];
$type=$hasil['type'];
$ket=$hasil['ket'];
$img=$hasil['img'];
$x=$hasil['x'];
$y=$hasil['y'];
$hock=$hasil['hock'];
?>

<form name="myform" name="submit" id="submit" action="pointgif2_update.php" >
<a href="pointgif.php" style="text-decoration:none" ></a> <a href="pointgif.php" style="text-decoration:none" ><strong> </strong></a>
<?=$nm_perush?>
<table width="200" border="1">
  <tr>
    <td align="center"><img src="images/images.jpg" width="150" height="143"></td>
  </tr>
  <tr>
    <td align="center">Foto Lokasi</td>
  </tr>
</table>
<table width="480" >
  <tr>
    <td width="151">&nbsp;</td>
    <td width="264"><input type="hidden" name="no" value="<?=$no?>" /><input type="hidden" name="siteplant" value="<?=$siteplant?>" /></td>
  </tr>
  <tr>
    <td>Ket / Setatus kavling</td>
    <td>: <input type="text" name="ket" value="<?=$ket?>" /></td>
  </tr>
  <tr>
    <td>Perumahan</td>
    <td>: <input type="text" name="tgl" value="<?=$nm_perumh?>"></td>
  </tr>
  <tr>
    <td>Lokasi </td>
    <td>: 
    <input type="text" name="lokasi" value="<?=$lokasi?>" /></td>
  </tr>
  <tr>
    <td>Block</td>
    <td>: <input type="text" name="block" value="<?=$block?>"> 
      Type : <input type="text" name="type" value="<?=$type?>" size="5" /></td>
  </tr>
  <tr>
    <td>Luas Tanah</td>
    <td>:
    <input type="text" name="ls_tanah" value="<?=$ls_tanah?>">
    <input type="text" name="hock" value="<?=$hock?>" size="5" /></td>
  </tr>
  <tr>
    <td colspan="2">Edit Posisi Gambar ponit x dan y :</td>
  </tr>
  <tr>
    <td colspan="2">x = <input type="text" name="x" value="<?=$x?>" size="10" /> y = <input type="text" name="y" value="<?=$y?>" size="10" /></td>
  </tr>
  <tr>
    <td colspan="2">
    	<Select name="img1" />
            <option value="<?=$img?>"><?=$img?></option>
            <?
			$query="select * from indikasi";
			$qry=mysql_query($query);
			While ($hasil=mysql_fetch_array($qry)){
			$indikasi=$hasil['indikasi'];
			$gambar=$hasil['gambar'];
			?>
            <option value="<?=$gambar?>"><?=$indikasi?></option>
            <? } ?>
        </select>    </td>
  </tr>
  <tr>
    <td><input type="submit" name="submit" value="Update"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>