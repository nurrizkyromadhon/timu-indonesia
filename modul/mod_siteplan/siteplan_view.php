  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
	include '../../config/koneksi.php';
?><head>
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
		
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	</script>
</head>

<?php
	$siteplant=$_GET['siteplant'];	
?>
<!-- -------------------------------------------------- posisi gambar siteplan  -->     

<div style="width:1200; height: 700; position:absolute; top:0; left:0; border: 1px solid black; border-bottom:1px solid black;">
	<img src="../../images/nm_perush/siteplan/<?=$siteplant?>" onClick="showCoords(event); document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';" width="100%" height="100%" />
</div>
<?php   // -------------------- Mengambil data dari tabel coord untuk penempatan gambar indikasi
$id_profil=$_GET['no'];
$query=mysql_query("select * from nasabah as n
	join coord as c on n.id_cord=c.id_coord 
	join indikasi as i on n.id_indikasi=i.id_indikasi
	join profil as p on n.id_profil=p.id_profil
	where n.id_profil='$id_profil'");
while ($hasil=mysql_fetch_array($query)){
	$title="$hasil[coord] - $hasil[indikasi]";
	$nm_perush=$hasil['nm_perush'];
	$id_coord=$hasil['id_coord'];
	$img=$hasil['gambar'];
	$x1=$hasil['x'];
	$x=$x1-5;		
	$y1=$hasil['y'];
	$y=$y1-15;

?> 
<!---------------------------------------------------- Menempatkan gambar indikasi -->
		<div style="position:absolute; left: <?=$x?>; top: <?=$y?>; ">
			<a href="#" data-toggle="tooltip" title="<?=$title?>" >
			  <img src="../../images/<?=$img?>" width="15" height="15" >
			</a>    
		</div>

<?php
} 

$query=mysql_query("select * from harga as h join coord as c on h.id_coord=c.id_coord
where c.id_profil='$id_profil' and h.status!='Terjual'");
while ($hasil=mysql_fetch_array($query)){
	$id_coord=$hasil['id_coord'];
	$no_blok=$hasil['no_blok'];
	//$img=$hasil['gambar'];
	$x1=$hasil['x'];
	$x=$x1-5;		
	$y1=$hasil['y'];
	$y=$y1-15;
?> 
<!---------------------------------------------------- Menempatkan gambar indikasi -->
		<div style="position:absolute; left: <?=$x?>; top: <?=$y?>; ">
			<a href="#" data-toggle="tooltip" title="<?=$no_blok?> - Siap di Jual">
			  <img src="../../images/rumahsiapjual.png" width="15" height="15" >
			</a>    
		</div>
<?php
} ?>
<!------------------------------------------------ Form input data Kavling popup -->
<div id="light" class="white_content">
-
</div>
<div id="fade" class="black_overlay"></div>

<a href="../../oklogin.php?module=home" style="position:relative">Home</a> | <a href="../../oklogin.php?module=input_spek_kavling" style="position:relative">Pilih Nama Perumahan</a>  


<table style="float:right; position:relative;">
<?php
	$query=mysql_query("select * from indikasi");
	while ($hasil=mysql_fetch_array($query)){	
?>
<tr>
	<td><img src="../../images/<?=$hasil['gambar']?>" width="15" height="15"> :</td>
	<td><?=$hasil['indikasi']?></td>
</tr>
<?php 
	}
?>
</table>

