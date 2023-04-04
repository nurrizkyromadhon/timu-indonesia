<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_profil_perush/aksi_profil_perush.php";
	?>
		<script type="text/javascript" src="plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />	
	<?php
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Profil Perusahaan</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Profil Perusahaan</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<table id="myTable" class="table table-bordered table-striped">
								  	<thead>
									  <tr align="center">
										<th>No</th>
										<th>Direksi Name</th>
										<th>Corp Name</th>
										<th>Corp address</th>
										<th>City</th>
										<th>City Code</th>
										<th>Bank</th>
										<th>Logo</th>
										<th colspan="2">Aksi</th>
									  </tr>
								    </thead>
								    <tbody>
									  <?
									  $no=1;
									  $query="select * from profil";
									  $qry=mysql_query($query);
									  while ($hasil=mysql_fetch_array($qry)){
									  $i=$hasil['no'];
									  $member0=$hasil['member'];
									  $nm_perush0=$hasil['nm_perush'];
									  $nm_perumh0=$hasil['nm_perumh'];
									  $lokasi0=$hasil['lokasi'];
									  $logo0=$hasil['logo'];
									  $brousr0=$hasil['brosur'];
									  $siteplant0=$hasil['siteplant'];

									  ?>
									  <tr>
										<td  class="td1"><?=$no?></td>
										<td  class="td1"><?=$member0?></td>
										<td  class="td1"><?=$nm_perush0?></td>
										<td  class="td1"><?=$nm_perumh0?></td>
										<td  class="td1"><?=$lokasi0?></td>
										
										<td align="center" >										
											<a class="tumbnail fancybox" rel="ligthbox" href="images/nm_perush/logo/<?=$logo0?>">
											<img class="img-responsive" alt="" src="images/nm_perush/logo/<?=$logo0?>" style="max-width:60px; max-height:30px;"/>
											</a>
										</td>
										
										<td align="center">
											<a class="tumbnail fancybox" rel="ligthbox" href="images/nm_perush/brosur/<?=$brousr0?>">
											<img class="img-responsive" alt="" src="images/nm_perush/brosur/<?=$brousr0?>" style="max-width:60px; max-height:50px;"/>
										</td>
										
										<td align="center"  class="td1">
											<a class="tumbnail fancybox" rel="ligthbox" href="images/nm_perush/siteplan/<?=$siteplant0?>">
											<img class="img-responsive" alt="" src="images/nm_perush/siteplan/<?=$siteplant0?>" style="max-width:60px; max-height:50px;"/>
										</td>
										
										<td align="center"  class="td1">	
										<!-- <button type="button" class="btn btn-primary" onclick="location.href='<?php //echo "?module=profil_perush&act=edit&id=$hasil[no]";?>';" ><i class="fa fa-edit"></i></button> -->
										
										<button type="button" class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=profil_perush&act=hapus&id=$hasil[no]";?>'; alert('Pastikan Data akan Terhapus')" ><i class="fa fa-trash"  ></i></button>
										  </td>
									  </tr>
									  <? $no++; } ?>
									</tbody>  
									</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<a href="?module=profil_perush&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</section>
					<script>
					$(document).ready(function(){
						$('#myTable').dataTable();
					});
					</script>
			<?php
			break;
	  
		case "tambah":
			?>
				<section class="content-header">
					<h1>Profil Perusahaan</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Profil Perusahaan</a></li>
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
									<form class="form-horizontal" method="POST" enctype="multipart/form-data" 
									action="<?=$aksi?>?module=profil_perush&act=input">
									
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-3 control-label">Nama Perusahaan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="nm_perush" />
												</div>
											</div>	

											<div class="form-group">
												<label class="col-sm-3 control-label">Nama Perumahan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="nm_perumh">
												</div>
											</div>	
										  
											<div class="form-group">
												<label class="col-sm-3 control-label">Lokasi Perumahan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="lokasi">
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Logo Perusahaan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="file" name="logo" />
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Brosur (650 x 320) :</label>
												<div class="col-sm-5">
													<input class="form-control"  type="file" name="brosur">
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Siteplant (650 x 320) :</label>
												<div class="col-sm-5">
													<input class="form-control" type="file" name="siteplant">
												</div>
											</div>	
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
					<h1>Form Edit</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#"> Profil Perusahaan</a></li>
						<li class="active">Form Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				<form class="form-horizontal" method="POST" enctype="multipart/form-data" 
									action="<?=$aksi?>?module=profil_perush&act=edit">
					  <?php				
					  $qry=mysql_query("Select * from nm_perush where no='$_GET[id]';");
					  $hasil=mysql_fetch_array($qry);
					  ?>				
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-3 control-label">Nama Perusahaan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="nm_perush" value="<?=$hasil['nm_perush']?>" />
												</div>
											</div>	

											<div class="form-group">
												<label class="col-sm-3 control-label">Nama Perumahan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="nm_perumh" value="<?=$hasil['nm_perumh']?>"/>
												</div>
											</div>	
										  
											<div class="form-group">
												<label class="col-sm-3 control-label">Lokasi Perumahan :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="lokasi" value="<?=$hasil['lokasi']?>"/>
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Logo Perusahaan :</label>
												<div class="col-sm-5">
													<img src="images/nm_perush/logo/<?=$hasil['logo']?>" width="50" height="50"><input class="form-control" type="file" name="logo" value="<?=$hasil['logo']?>" />
												</div>
											</div>	
											
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Brosur (650 x 320) :</label>
												<div class="col-sm-5">
													<img src="images/nm_perush/brosur/<?=$hasil['brosur']?>" width="100" height="50"><input class="form-control"  type="file" name="brosur" value="<?=$hasil['brosur']?>">
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-3 control-label">Gambar Siteplant (650 x 320) :</label>
												<div class="col-sm-5">
													<img src="images/nm_perush/siteplan/<?=$hasil['siteplant']?>"  width="100" height="50" /><input class="form-control" type="file" name="siteplant" value="<?=$hasil['siteplant']?>">
												</div>
											</div>	
									</div>										
										<div class="box-footer">
											<button type="submit" name="submit" class="btn btn-primary pull-right">Edit</button>
										</div>
									</form>
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
