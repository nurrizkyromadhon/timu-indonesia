<div style="width:300px; padding: 10px; border: 1px solid red; position: absolute; top: 0; left: 0; text-align: center;">
<form name="myform" name="submit" action="pointgif2_save.php">

Koordinat :<br />
<input type="text" name="coordx" id="coordx" size="5" ><br>
<input type="text" name="coordy" id="coordy" size="5" ><br>
Tanggal :<br>
<input type="text" name="tgl" id="tgl"><br>
Nama User:<br> 
<input type="text" name="nm_user" id="nm_user"><br />
Lokasi :<br />
<input type="text" name="lokasi" id="lokasi" /><br />
Keterangan :<br />
<input type="text" name="ket" id="ket" /> <br>
Pilih Gambar :<br>
</p>
<input type="radio" name="img" <?php if (isset($img) && $img=="jual.png") echo "checked";?>  value="jual.png">jual
<input type="radio" name="img" <?php if (isset($img) && $img=="legalitas.png") echo "checked";?>  value="legalitas.png">legalitas
<input type="radio" name="img" <?php if (isset($img) && $img=="serahterima.png") echo "checked";?>  value="serahterima.png">serahteima<br>

<input type="submit" name="submit" value="Simpan"><br> 

</form>
</div>