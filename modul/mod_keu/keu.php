<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_keu/aksi_keu.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>keu </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Keuangan</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
	  				<div class="box box-default">
						<div class="box-body">
							<div class="col-md-12">
								<div class="container">
									<h2> Buku Besar</h2>
									<div id="myTable3" class="table-responsive">
										<table  class="table table-bordered table-striped">
										<thead>
										<tr>
											<th>NO</th>
											<th>ID Perkiraan</th>
											<th>NAMA PERKIRAAN</th>
											<th>JUMLAH</th>
										</tr> 
										</thead>
										<tbody>
										<?php
											$no=1;
											
											$query="select * from jurnal as j
											join perkiraan as p on j.id_perkiraan=p.id_perkiraan  group by j.id_perkiraan order by kode_perkiraan asc";
											$qry=mysql_query($query) or die(mysql_error());
											while ($hasil=mysql_fetch_array($qry)){	
												$a=$hasil['id_perkiraan'];
													
										?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['id_perkiraan']?></td>
												<td><?=$hasil['kode_perkiraan']?>-<?=$hasil['nm_perkiraan']?></td>
												<td>
													<?php
														$jmld=0;
														$jmlk=0;
														$sisa=0;
														$query1=mysql_query("select * from jurnal where id_perkiraan='$a'");
														while($hasil1=mysql_fetch_array($query1)){
															if ($hasil1['dk']=='D'){
																$jmld=$jmld+$hasil1['nominal'];
															}
															if ($hasil1['dk']=='K'){
																$jmlk=$jmlk+$hasil1['nominal'];
															}
															$sisa=$jmld-$jmlk;
														}
													echo number_format("$sisa");
													?>	
													
												</td>
												<td>
													<button type="button" class="btn " onclick="window.open('<?php echo "oklogin.php?module=bukubesarjurnal&kode_perkiraan=$hasil[kode_perkiraan]";?>','_blank');" ><i class="fa fa-eye"></i></button>
												</td>
											</tr>
										<?php
											$no++; } 
										?>
										</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="modul/mod_home/aksi_home.php?module=home&act=save_all"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
					</div>	
			</section>
<script>
$(document).ready(function(){
	$('#myTable').dataTable();
	$('#myTable2').dataTable();
});
</script>
<?php
break;

case "tambah":
?>
	<section class="content-header">
		<h1>keu</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">keu</a></li>
			<li class="active">Form Tambah keu</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah keu</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=keu&act=input">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-2 control-label">Tanggal</label>
										  <div class="col-sm-6">
											<input type="text" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?php echo date("Y-m-d");?>">
										  </div>
										</div>
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-2 control-label">No. Referensi</label>
										  <div class="col-sm-6">
											<input type="text" class="form-control" name="no_ref" placeholder="Input No. Referensi">
										  </div>
										</div>

										<div class="product-item form-group">
										  <div class="col-sm-2">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="nm_perkiraan1" name="nm_perkiraan[]" placeholder="Nama Perkiraan">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="ket[]" placeholder="Keterangan">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="nominal[]" placeholder="Nominal">
										  </div>
										  <div class="col-sm-2">
											<select class="form-control" name="dk[]" >
												<option value="">Debit / Kredit</option>
												<option value="D">Debit</option>
												<option value="K">Kredit</option>
											</select>
										  </div>
										  <div class="col-sm-2">
											<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>
										</div>
											<div id="product"></div>
											<script type="text/javascript">
												var idrow = 1;
												function addMore() {
													idrow++;
													$("#product").append("<div class='product-item form-group'><div class='col-sm-2'><button type='button' class='btn btn-danger pull-right'onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-2'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]'placeholder='Nama Perkiraan'></div><div class='col-sm-2'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");	
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
												function openwindow(idrow) {
													var features = "left=200,top=100,menubar=no,location=no,width=700,height=500,scrollbars=yes,resizable=no";
													var popup = window.open("modul/mod_kode_perkiraan/tabel_kode_perkiraan.php?idrow="+idrow,"",features);
												}
											</script>
											<DIV class="btn-action float-clear" align="center">
												<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
												<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
												<span class="success"><?php if(isset($message)) { echo $message; }?></span>
											</DIV>
									  </div>
									  <!-- /.box-body -->
									  <div class="box-footer">
										<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
									  </div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
break;

case "editspp":

$id_spp = $_GET['id'];
if (empty($id_spp)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from spp where id_spp='$id_spp'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>SPP</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">SPP</a></li>
			<li class="active">Form Edit SPP</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit SPP</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=update">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">No. SPP</label>
								  <div class="col-sm-6">
									<input type="hidden" class="form-control" name="id_spp" value='<?php echo $update['id_spp'];?>'>
									<input type="text" class="form-control" name="no_spp" placeholder="Input No SPP...." value='<?php echo $update['no_spp'];?>'>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Site</label>
									  <div class="col-sm-6">
										<select class="form-control" name="id_site" id="id_site" >
											<option value="">-- Id Site --</option>
											<?php
												$query="select * from site order by id_site asc";
												$qry=mysql_query($query);
												while ($hasil_db=mysql_fetch_array($qry)){
													$id_site_db=$hasil_db['id_site'];
													$nama_site_db=$hasil_db['nama_site'];
													if($update['id_site'] == $id_site_db) {
														?>
															<option value="<?=$id_site_db?>" selected="selected"><?=$nama_site_db?></option>
														<?php
													}
													else {
														?>
															<option value="<?=$id_site_db?>"><?=$nama_site_db?></option>
														<?php
													}
												}
											?>
										</select>
									  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Tanggal</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?php echo date("Y-m-d H:i:s");?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Digunakan Untuk</label>
								  <div class="col-sm-6">
									<select class="form-control" name="id_alat" id="id_alat" >
										<option value="">-- No.Lamb --</option>
										<?php
											$query = "select * from alat order by no_lamb asc";
											$qry = mysql_query($query);
											while ($hasil_db=mysql_fetch_array($qry)){
												$id_alat_db=$hasil_db['id_alat'];
												$no_lamb_db=$hasil_db['no_lamb'];
												if($update['id_alat'] == $id_alat_db) {
													?>
														<option value="<?=$id_alat_db?>" selected="selected"><?=$no_lamb_db?></option>
													<?php
												}else{
													?>
														<option value="<?=$id_alat_db?>"><?=$no_lamb_db?></option>
													<?php
												}
											}
										?>
									</select>
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Kode Status Breakdown</label>
								  <div class="col-sm-6">
									<select class="form-control" name="key_stat" id="key_stat" >
										<option value="">-- Code Status Breakdown --</option>
										<?php
											$query = "select * from kodestatusbd order by kode_stat asc";
											$qry = mysql_query($query);
											while ($hasil_db=mysql_fetch_array($qry)){
												$key_stat_db=$hasil_db['key_stat'];
												$kode_stat_db=$hasil_db['kode_stat'];
												if($update['key_stat'] == $key_stat_db){
													?>
														<option value="<?=$key_stat_db?>" selected="selected"><?=$kode_stat_db?></option>
													<?php
												}
												else {
													?>
														<option value="<?=$key_stat_db?>"><?=$kode_stat_db?></option>
													<?php
												}
											}
										?>
									</select>
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Keterangan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="keterangan" placeholder="Input Keterangan...." value="<?php echo $update['keterangan'];?>">
								  </div>
								</div>
								<?php 
								
								$query2="SELECT sparepart.*, spp_sparepart.qty from spp_sparepart INNER JOIN sparepart ON spp_sparepart.id_sparepart = sparepart.id_sparepart WHERE spp_sparepart.id_spp = '$_GET[id]' order by spp_sparepart.id_spp_sparepart asc";
								$qry2=mysql_query($query2);
								while ($hasil_sprpart=mysql_fetch_array($qry2)){ 
				
								?>
								<div class="product-item form-group">
								  <div class="col-sm-2">
									<input type="checkbox" class="pull-right" name="item_index[]">
								  </div>
								  <div class="col-sm-2">
									<input type="text" class="form-control" name="item_name[]" placeholder="Nama Part" value="<?php echo $hasil_sprpart['item_name'] ?>">
								  </div>
								  <div class="col-sm-2">
									<input type="text" class="form-control" name="part_no[]" placeholder="Part No" value="<?php echo $hasil_sprpart['part_no'] ?>">
								  </div>
								  <div class="col-sm-2">
									<input type="text" class="form-control" name="quantity[]" placeholder="quantity" value="<?php echo $hasil_sprpart['qty'] ?>">
								  </div>
								  <div class="col-sm-2">
									<input type="text" class="form-control" name="satuan[]" placeholder="Satuan" value="<?php echo $hasil_sprpart['satuan'] ?>">
								  </div>
								</div>
								<?php } ?>
							<div id="product"></div>
							<script type="text/javascript">
								function addMore() {
									$("#product").append("<div class='product-item form-group'><div class='col-sm-2'><input type='checkbox' class='pull-right' name='item_index[]'></div><div class='col-sm-2'><input type='text' class='form-control' name='item_name[]' placeholder='Nama Part'></div><div class='col-sm-2'><input type='text' class='form-control' name='part_no[]' placeholder='Part No'></div><div class='col-sm-2'><input type='text' class='form-control' name='quantity[]' placeholder='Quantity'></div><div class='col-sm-2'><input type='text' class='form-control' name='satuan[]' placeholder='Satuan'></div></div>");	
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
							<DIV class="btn-action float-clear">
								<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
								<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
								<span class="success"><?php if(isset($message)) { echo $message; }?></span>
							</DIV>
							</div>
							  <!-- /.box-body -->
							  <div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
							  </div>
							</form>
						</div>
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