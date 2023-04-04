<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_kode_perkiraan/aksi_kode_perkiraan.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Pembuatan Nama Kode Rekening</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Kode Perkiraan</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=kode_perkiraan&act=input">
						<div class="box-body">
								<!-- /.col -->
								<div class="col-md-6">															
								<H3 class="box-title with-border">Ketentuan Pembuatan Kode Perkiraan </H3>
									<table class="table table-bordered table-striped">
									<tr>
										<th>Kategori I</th>
										<th>Kategori II</th>
										<th>Kategori III</th>
										<th>Kategori IV</th>
									</tr>	
									<tr>
										<td>										
										<?php
											$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan order by kode_perkiraan asc");
											while ($hasil=mysql_fetch_array($query)){
												if ($hasil['jml']==1){
													echo "$hasil[kode_perkiraan]"; 
													echo " $hasil[nm_perkiraan]<br> ";
												}
											}
										?>
										</td>
										<td>
										<?php
											$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan order by kode_perkiraan asc");
											while ($hasil=mysql_fetch_array($query)){
												if ($hasil['jml']==3){
													echo "$hasil[kode_perkiraan] - "; 
													echo " $hasil[nm_perkiraan]<br> ";
												}
											}
										?>
										</td>
										<td>
										<?php
											$query=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan order by kode_perkiraan asc");
											while ($hasil=mysql_fetch_array($query)){
												if ($hasil['jml']==6){
													echo "$hasil[kode_perkiraan] - "; 
													echo " $hasil[nm_perkiraan]<br> ";
												}
											}
										?>
										</td>
										<td><?="Kode yang di pakai untuk Buku Besar" ?></td>
									</tr>	
									</table>
								</div>

								<div class="col-md-6">
								<h3 class="box-title with-border">Input Kode Perkiraan</h3>
								<div class="row"  style="background-color:antiquewhite">
								<div class="box-body" padding="15">	
										<div class="product-item form-group">
										  <div class="col-sm-1">
											<input type="checkbox" class="pull-right" name="item_index[]" >
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="kode_perkiraan[]" placeholder="Kode Perkiraan">
										  </div>
										  <div class="col-sm-9">
											<input type="text" class="form-control" name="nm_perkiraan[]" placeholder="Nama Perkiraan">
										  </div>
										</div>
											<div id="product"></div>
											<script type="text/javascript">
												function addMore() {
													$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><input type='checkbox' class='pull-right' name='item_index[]'></div><div class='col-sm-2'><input type='text' class='form-control' name='kode_perkiraan[]' placeholder='Kode Perkiraan'></div><div class='col-sm-9'><input type='text' class='form-control' name='nm_perkiraan[]' placeholder='Nama Perkiraan'></div></div>");	
												}
												function deleteRow() {
													$('DIV.product-item').each(function(index, item){
														jQuery(':checkbox', this).each(function () {
															if ($(this).is(':checked')) {
																$(item).remove();
															}
														});
													});
												}
											</script>
											<div class="btn-action float-clear">
												<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
												<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
												<span class="success"><?php if(isset($message)) { echo $message; }?></span>
											</div>
											<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
									</div>
									</div>	
								<div class='row'>	
								<H3>Table List, Edit dan Hapus Kode Perkiraan</H3>							
									<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>No</th>
											<th>Kode Perkiraan</th>
											<th>Nama Perkiraan</th>
											<th>Aksi</th>
										</tr>
										</thead>
										<?php
										$no=1;
										$query="select * from perkiraan order by kode_perkiraan ASC";
										$qry=mysql_query($query);
										while ($hasil=mysql_fetch_array($qry)){
											$kode_perkiraan=$hasil['kode_perkiraan'];
											$nm_perkiraan=$hasil['nm_perkiraan'];
										?>
										<tr>
											<td><?=$no?></td>
											<td><?=$kode_perkiraan?></td>
											<td><?=$nm_perkiraan?></td>
											<td> 
												<!--<button type="button" class="btn btn-default btn-flat" onclick="location.href='<?php echo "?module=kode_perkiraan";?>';"><i class="fa fa-eye"></i></button>-->							
											<?php
												if (strlen($kode_perkiraan)>='6'){
											?>
												<button type="button" class="btn btn-default btn-flat" onclick="location.href='<?php echo "?module=kode_perkiraan&act=editperkiraan&id=$hasil[id_perkiraan]";?>';"><i class="fa fa-edit"></i></button>							
												<button type="button" class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=kode_perkiraan&act=hapus&id=$hasil[id_perkiraan]";?>';" ><i class="fa fa-trash"></i></button>
									    	<?php } ?>
										    </td>
										</tr>
										<?php
											$no++ ; 
										}?>
									</table>
								</div>
								</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
					</form>
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
											FORM TAMBAH
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
		
		case "editperkiraan":
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>EDIT PERKIRAAN</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li><a href="#">Kode Perkiraan</a></li>
						<li class="active">Form Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Kode Perkiraan</h3>
						</div>
						<!-- /.box-header -->
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=kode_perkiraan&act=editperkiraan&id=<?=$_GET[id]?>">
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<?php
								$qry1=mysql_query("Select * from perkiraan where id_perkiraan='$_GET[id]'");
								$hasil1=mysql_fetch_array($qry1);
								?>
								<div class="col-md-6" with-border-2 >
								  		<div class="product-item form-group">
										  <div class="col-sm-1">
											<input type="checkbox" class="pull-right" name="item_index" disabled>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="kode_perkiraan" 
											value="<?=$hasil1['kode_perkiraan']?>">
										  </div>
										  <div class="col-sm-9">
											<input type="text" class="form-control" name="nm_perkiraan" 
											value="<?=$hasil1['nm_perkiraan']?>">
										  </div>
										</div>
											<div id="product"></div>
											<div class="box-footer">
												<button type="submit" name="submit" class="btn btn-primary pull-right">Edit</button>
											</div>	
								</div>
								<div class="col-md-6">
									<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>No</th>
											<th>Kode Perkiraan</th>
											<th>Nama Perkiraan</th>
											<th>Aksi</th>
										</tr>
										</thead>
										<?php
										$no=1;
										$query="select * from perkiraan order by kode_perkiraan ASC";
										$qry=mysql_query($query);
										while ($hasil=mysql_fetch_array($qry)){
											$kode_perkiraan=$hasil['kode_perkiraan'];
											$nm_perkiraan=$hasil['nm_perkiraan'];
										?>
										<tr>
											<td><?=$no?></td>
											<td><?=$kode_perkiraan?></td>
											<td><?=$nm_perkiraan?></td>
											<td>
												<button type="button" class="btn btn-default btn-flat" onclick="location.href='<?php echo "?module=kode_perkiraan&act=editperkiraan&id=$hasil[id_perkiraan]";?>';"><i class="fa fa-eye"></i></button>							
											<?php
												if (strlen($kode_perkiraan)>='9'){
											?>              
												<button type="button" class="btn btn-default btn-flat" onclick="location.href='<?php echo "?module=kode_perkiraan&act=editperkiraan&id=$hasil[id_perkiraan]";?>';"><i class="fa fa-edit"></i></button>							
												<button type="button" class="btn btn-danger btn-flat"><i class="fa fa-close (alias)"></i></button>
									    	<?php } ?>
										    </td>
										</tr>
										<?php
											$no++ ; 
										}?>
									</table>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.row -->
						</div>
						<!-- /.box -->
					</form>
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

	}
}
?>
