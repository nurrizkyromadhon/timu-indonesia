<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_bukubesar/aksi_bukubesar.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>Buku Besar</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Buku Besar</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Buku Besar</h3>
			</div>
			<!-- /.box-header -->
			<div class="table-responsive">
			<div class="box-body">
				<div class="row">				
						<div class="box-body" style="background:#D7D6D6">
						<form name="submit" action="" method="post"	>	
							<table width="484">
							  <tbody>
								<tr>
								  <td width="140">Mulai Tanggal </td>
								  <td width="10">:</td>
								  <td width="325"><input type="date" name="tgl_aw" ></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>
								<tr>
								  <td>s/d Tanggal</td>
								  <td>:</td>
								  <td><input type="date" name="tgl_ak" ></td>
							    </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>
								<tr>
								  <td>Nama Account </td>
								  <td>:</td>
								  <td>
									 <span>
										<select class="form-control select2" style="width: 100%;" name="kode_perkiraan">
										  <option value="">Pilihan Account</option>
											<?php
												$query=mysql_query("SELECT *, length(p.kode_perkiraan) as jml from perkiraan as p
												join jurnal as j on p.id_perkiraan = j.id_perkiraan group by j.id_perkiraan
												order by kode_perkiraan asc");
												while ($hasil=mysql_fetch_array($query)){
											?>
													<option value="<?=$hasil['kode_perkiraan']?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></option>

											<?php
												}
											?>
										</select>
									  </span>
								  </td>
								</tr>
								<tr>
									<td><input type="submit" value="Submit"></td>
									<td></td>
									<td></td>
								</tr>
							  </tbody>
							</table>
							</form>
				  		</div>
				  		
						<form name="submit" action="<?=$aksi?>?module=bukubesar&act=savetoexcel" method="post">
						<div class="box-body">
						
						<?php
						$no=1;
						// Menentukan tanggal awal bulan dan akhir bulan
						$hari_ini = date("Y-m-d");
						if (empty($_POST['tgl_aw'])){
							$tgl_aw= date('Y-m-01', strtotime($hari_ini));
							$tgl_ak = date('Y-m-t', strtotime($hari_ini));

						}else{
							$tgl_aw=$_POST['tgl_aw'];
							$tgl_ak=$_POST['tgl_ak'];
							
						}
							$tgl1=date('Y-m-d',strtotime($tgl_aw));
							$tgl2=date('Y-m-d',strtotime($tgl_ak));
						?>
						
						
							<h3>Periode : <?=date('d-M-Y',strtotime($tgl_aw))?> s/d <?=date('d-M-Y',strtotime($tgl_ak))?></h3> 
							<!-- Variable yang di gunakan untuk save ke Excel -->
							<input type="hidden" name="tgl_aw" value="<?=$tgl1?>">
							<input type="hidden" name="tgl_ak" value="<?=$tgl2?>">
							<input type="hidden" name="kode_perkiraan" value="<?=$_POST['kode_perkiraan']?>">
						<?
							
							$kode_perkiraan=$_POST['kode_perkiraan'];
							$query3=mysql_query("select * from perkiraan where kode_perkiraan='$kode_perkiraan'");
							$hasil3=mysql_fetch_array($query3);
							
						?>
							Kode Rekening : <?=$kode_perkiraan?> - <?=$hasil3['nm_perkiraan']?>
							<table id="myTable" class="table table-bordered table-striped">
									<thead bgcolor=#A5B4EC>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Perkiraan</th>
											<th>Keterangan</th>
											<th>NO BG dan CEK</th>
											<th>Debet</th>
											<th>Kredit</th>
											<th>Saldo</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>0</td>
											<td><?=date('d M Y',strtotime($tgl_aw))?></td>
											<td>-</td>
											<td>-</td>
											<td>Saldo Awal </td>
											<td>-</td>
											<td>-</td>
											<td>
												<?php
													//1. Menentukan saldo awal 
													// Menentukan tanggal mulai start sampai tgl sebelum ( tgl_aw )
													$tgl_sld1=date('2017-01-01');
													$tgl_sld2=date('Y-m-d', strtotime('-1 day', strtotime($tgl_aw)));

													//Jika Kode Perkiraan kosong  
													if ($kode_perkiraan==''){
														//Mencari saldo Jumlah Debet dan kredit untuk 
														$query1=mysql_query("SELECT * FROM jurnal as j 
														join perkiraan as p on j.id_perkiraan=p.id_perkiraan
														where tgl between '$tgl_sld1' and '$tgl_sld2' 
														ORDER BY tgl, no_ref asc");
														while ($hasil1=mysql_fetch_array($query1)){
															if($hasil1['dk']==D){
																$jmld=$jmld+$hasil1['nominal'];
															}else{
																$jmlk=$jmlk+$hasil1['nominal'];
															}
														}
													//jika kode perkiraan terisi 	
													}else{
														//Mencari saldo Jumlah Debet dan kredit untuk 
														$query1=mysql_query("SELECT * FROM jurnal as j 
														join perkiraan as p on j.id_perkiraan=p.id_perkiraan
														where tgl between '$tgl_sld1' and '$tgl_sld2' and kode_perkiraan='$kode_perkiraan'
														ORDER BY tgl,no_ref asc");
														while ($hasil1=mysql_fetch_array($query1)){
															if($hasil1['dk']==D){
																$jmld=$jmld+$hasil1['nominal'];
															}else if($hasil1['dk']==K){
																$jmlk=$jmlk+$hasil1['nominal'];
															}
														}
													}
													
													//echo "$tgl_sld1";
													//echo " ke $tgl_sld2 <br>";
													$saldo_aw=$jmld-$jmlk;
												?>
													<?=number_format($saldo_aw)?>
											</td>
											<td><?=number_format($saldo_aw)?></td>
										</tr>
										<?php
										if ($kode_perkiraan==''){
											$query=mysql_query("SELECT * FROM jurnal as j 
											join perkiraan as p on j.id_perkiraan=p.id_perkiraan
											where tgl between '$tgl_aw' and '$tgl_ak' 
											ORDER BY tgl, no_ref asc");
										}else{
											$query=mysql_query("SELECT * FROM jurnal as j 
											join perkiraan as p on j.id_perkiraan=p.id_perkiraan
											where tgl between '$tgl_aw' and '$tgl_ak' and kode_perkiraan='$kode_perkiraan'
											ORDER BY tgl, no_ref asc");
										}
											while ($hasil=mysql_fetch_array($query)){
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_ref']?></td>
														<td><?php echo $hasil['kode_perkiraan']." - " .$hasil['nm_perkiraan']; ?></td>
														<td><?=$hasil['ket']?></td>
														<td><?=$hasil['bgcek']?></td>
														<?php
														if ($hasil['dk']==D){
														?>
															<td><?=number_format($hasil['nominal'])?></td>
															<td></td>
														<?php
														}if ($hasil['dk']==K){
														?>
															<td></td>
															<td><?=number_format($hasil['nominal'])?></td>
															
														<?php
														}
														?>
														<td>
														<?php
															if($hasil['dk']==D){ 
																$saldo=($saldo+$hasil['nominal']);
															}else{
																$saldo=($saldo-$hasil['nominal']);	
															}
															
															$saldoak=$saldo+$saldo_aw;
														?>
														<?=number_format($saldoak)?>
														</td>
													</tr>
												<?php
												$no++;
											}
										?>
									</tbody>
						  		</table>
					  		</div>
					  	<div class="text-center">
					  		<button type="submit"><i class="fa fa-fw fa-save"></i> Save to Excel</button>
						</div>
					  </form>
			  			
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!--<div class="box-footer">
				<div class="text-center">
					<a href=" ?module=bukubesar&act=savetoexcel"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-save"></i>&nbsp Save To Excel</button></a>
				</div>
			</div>-->
			<!-- /.box-footer -->
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
<script>
$(document).ready(function(){
	$('#myTable').dataTable();
});
	
$(function () {
	//Initialize Select2 Elements
	$(".select2").select2();
});
</script>

<?php
break;

case "tambah":
?>
	<section class="content-header">
		<h1>JURNAL</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Jurnal</a></li>
			<li class="active">Form Tambah Jurnal</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah Jurnal</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=jurnal&act=input">
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