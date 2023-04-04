<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_siteplan/siteplan_view.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Coordinat</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Pilih Perumahan Yang akan di Spek</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
								
								<table width="100%">
								<?php
									$n=0;
									$query="select * from profil order by lokasi asc";
									$qry=mysql_query($query);
									while ($hasil=mysql_fetch_array($qry)){
									$no_nm_perush=$hasil['id_profil'];
									$siteplant=$hasil['siteplant'];
									$nm_perush=$hasil['nm_perush'];
									$nm_perumh=$hasil['nm_perumh'];
									$nm_lokasi=$hasil['lokasi'];
									$warna = ($n%2==1)?"#ffffff":"#efefef";
								?>
								  <tr bgcolor="<?=$warna?>">
									<td align="center"><a href="<?=$aksi?>?siteplant=<?=$siteplant?>&no=<?=$no_nm_perush?>"><h2><?=$nm_perumh?>-<?=$nm_lokasi?></h2></a>
									<p>&nbsp;</p></td>
								  </tr>
								  <? $n++; } ?>
								</table>
								
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<a href="../mod_coordinat/?module=profil_perush&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</section>
				<script>
					$(function () {
						$("#example1").DataTable();
					});
				</script>
			<?php
			break;
	  
		case "tambah":
			?>
				<section class="content-header">
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
						<li class="active">Form Tambah</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Tambah</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=input">
										<div class="box-body">
<iframe width='100%' height="100%">
<?php
	include '../../config/koneksi.php';
	$siteplant=$_POST['siteplant'];
	$query="select * from profil where siteplant='$siteplant' ";
	$qry=mysql_query($query);
	while ($hasil=mysql_fetch_array($qry)){
		$no_nm_perush=$hasil['id_profil'];
		$nm_perumh=$hasil['nm_perumh'];
		$nm_perush=$hasil['nm_perush'];
	}
?>
	<link rel="stylesheet" href="../mod_coordinat/pop.css">
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

<? //-------------------------------------------------- posisi gambar siteplan ?>       

<div style="width:1200; height: 700; position:absolute; top:0; left:0; border: 1px solid black; border-bottom:1px solid black;">
	<img src="images/nm_perush/siteplan/<?=$siteplant?>" onClick="showCoords(event); document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block';" width="100%" height="100%" />
</div>

<?php   // -------------------- Mengambil data dari tabel coord untuk penempatan gambar indikasi
	$query="select * from coord where siteplant='$siteplant' ";
	$qry=mysql_query($query);
	while ($hasil=mysql_fetch_array($qry)){
		$x1=$hasil['x'];
		$x=$x1-5;
		$y1=$hasil['y'];
		$y=$y1-15;
		//$nm_user=$hasil['nm_user'];
		$lokasi=$hasil['lokasi'];
		$no=$hasil['no'];
		$img=$hasil['img'];
?> 
<!---------------------------------------------------- Menempatkan gambar indikasi -->
		<div style="position:absolute; left: <?=$x?>; top: <?=$y?>; ">
			<a href="../mod_coordinat/pointgif2_view.php?no=<?=$no?>&nm_perush=<?=$nm_perush?>">
			  <img src="../../images/<?=$img?>" width="15" height="15" >
			</a>    
		</div>

<?php
} ?>

<!------------------------------------------------ Form input data Kavling popup -->
<div id="light" class="white_content">
	<form name="myForm" action="../mod_coordinat/input_coord_save.php"><p>
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
	</form>        
</div>
<div id="fade" class="black_overlay"></div>

<a href="../../oklogin.php?module=home" style="position:relative">Home</a> | <a href="../../oklogin.php?module=input_spek_kavling" style="position:relative">Pilih Nama Perumahan</a>  
												
</iframe>
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
				<script>
				  $(function () {
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
		
		case "edit":
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
						<li class="active">Form Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Edit</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=update">
										<div class="box-body">
											Form Edit SPP
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
				<script>
				  $(function () {
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
	}
}
?>
