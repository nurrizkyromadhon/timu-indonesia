
<?php
	include '../../config/koneksi.php';
?><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="pop.css">
	<script type="text/javascript">
	function showCoords(event) {
		var x = event.clientX;
		var y = event.clientY;
		var coords1 =  x ;
		var coords2 =  y ;
		document.getElementById("coordx").innerHTML = coords1;
		document.getElementById("coordy").innerHTML = coords2;
		document.myForm.coordx.value = coords1;
		document.myForm.coordy.value = coords2;
	}
	</script>
</head>

<?php
	$siteplant=$_GET['siteplant'];	
	//$query="select * from profil where siteplant='$siteplant' ";
	//$qry=mysql_query($query);
	//while ($hasil=mysql_fetch_array($qry)){
	//	$nm_perumh=$hasil['nm_perumh'];
	//	$nm_perush=$hasil['nm_perush'];
	//}
?>
<!-- -------------------------------------------------- posisi gambar siteplan  -->     

<div style="width:1200; height: 700; position:absolute; top:0; left:0; border: 1px solid black; border-bottom:1px solid black;">
	<img src="../../images/nm_perush/siteplan/<?=$siteplant?>" onClick="showCoords(event); document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';" width="100%" height="100%" />
</div>
<?php   // -------------------- Mengambil data dari tabel coord untuk penempatan gambar indikasi
$id_profil=$_GET['no'];
$query=mysql_query("select * from coord as c join indikasi as i on c.id_indikasi=i.id_indikasi
where id_profil='$id_profil'");
while ($hasil=mysql_fetch_array($query)){
	$id_coord=$hasil['id_coord'];
	$img=$hasil['gambar'];
	$x1=$hasil['x'];
	$x=$x1-5;		
	$y1=$hasil['y'];
	$y=$y1-15;

?> 
<!---------------------------------------------------- Menempatkan gambar indikasi -->
		<div style="position:absolute; left: <?=$x?>; top: <?=$y?>; ">
			<a href="pointgif2_view.php?no=<?=$id_coord?>&nm_perush=<?=$nm_perush?>">
			  <img src="../../images/<?=$img?>" width="15" height="15" >
			</a>    
		</div>

<?php
} ?>

<!------------------------------------------------ Form input data Kavling popup -->
<div id="light" class="white_content">
	<form name="myForm" action="input_coord_save.php"><p>
    	<input type="hidden" name="coordx" id="coordx" size="5" />
        <input type="hidden" name="coordy" id="coordy" size="5" /> <p>
        <input type="hidden" name="siteplant" value="<?=$siteplant?>" /><p>
            
        <strong>Nama Blok Kavling :<p> </strong><input type="text" name="kavling" onFocus="hitung();" /><p>
        <strong>Lebar Tanah :<p> </strong><input type="text" name="lb_tanah" onFocus="hitung();" /><p>
        <strong>Panjang Tanah :<p> </strong><input type="text" name="pj_tanah" /><p>
        <strong>Luas Tanah :<p> </strong><input type="text" name="ls_tanah" /><p>
        <strong>Type :<p> </strong><input type="text" name="type" /> <input name="hock" type="checkbox" value="hock"> Centang Jika Hock<p>
        <strong>Image Indikasi : </strong><p>
        <Select name="img" />
        <option value="">-Pilih-</option>
        <?php
			$query="select * from indikasi";
			$qry=mysql_query($query);
			while ($hasil=mysql_fetch_array($qry)){
				$indikasi=$hasil['indikasi'];
				$gambar=$hasil['gambar'];
		?>
            <option value="<?=$gambar?>"><?=$indikasi?></option>
        <?php 
		}?>
		
            </select><p>
            <input type="hidden" name="nm_perush" value="<?=$nm_perush?>">
            <input type="hidden" name="nm_perumh" value="<?=$nm_perumh?>">
            Ket / Status :<p> <textarea name="ket" rows="1"></textarea><p>
            <input type="submit" name="submit" value="Save">
            <button type="reset">Reset</button>
            <button type="button" onClick="location.reload()">close</button>
	</form>        
</div>
<div id="fade"></div>
<div id="fade" class="black_overlay"></div>

<a href="../../oklogin.php?module=home" style="position:relative">Home</a> | <a href="../../oklogin.php?module=input_spek_kavling" style="position:relative">Pilih Nama Perumahan</a>  


