<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_subkas/aksi_subkas.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>1.1.01.002 - Kas Kecil Proyek </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">1.1.01.002 - Kas Kecil Proyek</li>
		</ol>
	</section>
	
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
		    
		    
			<div class="box-header with-border">
				<h3 class="box-title">1.1.01.002 - Kas Kecil Proyek</h3>
			</div>
			<!-- /.box-header -->
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="box-body">
								<div class="row">				
									
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
												<!--<tr>
												<td>Nama Account </td>
												<td>:</td>
												<td>
													<span>
														<select class="form-control select2" style="width: 100%;" name="kode_perkiraan">
														<option value="">Pilihan Account</option>
															<?php
																$query=mysql_query("select *, length(p.kode_perkiraan) as jml from perkiraan as p
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
												</tr>-->
												<tr>
													<td><input type="submit" value="Submit"></td>
													<td></td>
													<td></td>
												</tr>
											</tbody>
											</table>
										</form>
									
										
										<form name="submit" action="<?=$aksi?>?module=kas&act=savetoexcel" method="post">
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
												<input type="hidden" name="kode_perkiraan" value="1.1.02.002">
												
												<?php
												$kode_perkiraan='1.1.01.002';
												$query3=mysql_query("select * from perkiraan where id_perkiraan='60'");
												$hasil3=mysql_fetch_array($query3);
												?>
												
												Kode Rekening : <?=$kode_perkiraan?> - <?=$hasil3['nm_perkiraan']?>
												<table id="myTable" class="table table-bordered table-striped">
													<thead bgcolor=#A5B4EC>
														<tr>
															<th>No.</th>
															<th>Tanggal</th>
															<th>No.Reff</th>
															<th>Keterangan</th>
															<th>Debet</th>
															<th>Kredit</th>
															<th>Saldo</th>
															<th>Aksi</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>0</td>
															<td><?=date('d M Y',strtotime($tgl_aw))?></td>
															<td>-</td>
															<td>Saldo Awal </td>
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
															</td>
															<td><?=number_format($saldo_aw)?></td>
															<td></td>
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
															<td><?=$hasil['ket']?></td>
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
															<td>
																<div class="btn-group">
																	<button type="button" class="btn btn-primary" onclick="location.href='<?php echo "?module=kas&act=edit&id=$hasil[id_jurnal]";?>';" ><i class="fa fa-edit"></i></button>																			
																	<button type="button"  class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=kas&act=hapus&id=$hasil[id_jurnal]";?>'; " ><i class="fa fa-trash"></i></button>
																</div>														    
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
							<!-- /.box-body -->
						</div>
						<!-- /.responsiv -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			<!-- /.box-body -->
			<div class="box-footer">
				<div class="col-md-6">
					<a href="?module=kas&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>Tambah Data</button></a>
				</div>

			</div>
			
			<div class="box-header with-border">
				<h3 class="box-title">Print List</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<!-- /.col -->

					<div class="col-md-12">
						<div class="table-responsive">
							<div class="box-body">						
								<table id="myTable3" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Total Nominal</th>
											<th style="min-width:135px;" >Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											$query="SELECT *, sum(nominal) as jml FROM jurnal where id_perkiraan='60' group by no_ref ORDER BY tgl desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_ref']?></td>
														<td><?=number_format($hasil['jml'])?></td>
														<td align="center">
															<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=kas&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>
														</td>
													</tr>
												<?php
												$no++;
											}
										?>
									</tbody>
								</table>
								<!-- /.tabel 1. -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.responsiv -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box box-default -->
	</section>
<script>
$(document).ready(function(){
	$('#myTable').dataTable();
	$('#myTable2').dataTable();
	$('#myTable3').dataTable();
	$('#myTable4').dataTable();
	$('#myTable7').dataTable();
});
</script>
<?php
break;

case "tambah":
?>
	<section class="content-header">
		<h1>1.1.01.002 - Kas Kecil Proyek</h1>
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
				<h3 class="box-title">Input Data</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="table-responsive">
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=kas&act=input">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">Tanggal</label>
										  <div class="col-sm-3">
											<input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?php echo date("Y-m-d");?>">
										  </div>
										</div>
										<div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">No. Jurnal</label>
										  <div class="col-sm-3">
											<input type="text" class="form-control" name="no_jurnal" placeholder="Nomor Jurnal " value="J.<?=date("y.m")?>." >
										  </div>
										</div>
									  <div class="box-body">
										
										<div class="product-item form-group">
							  		  	  <!--<div class="col-sm-2">
										  </div>
								  		  <div class="col-sm-2">
									  		<select class="form-control select2" style="width: 100%;" name="nm_perkiraan[]">
											  <option value="">Pilihan Account</option>
												<?php
													$query=mysql_query("select * from perkiraan order by id_perkiraan asc");
													while ($hasil=mysql_fetch_array($query)){
												?>
													<option value="<?=$hasil['id_perkiraan']?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></option>
												<?php
													}
												?>
							      			</select>
										  </div>	
										  <div class="col-sm-1">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="nm_perkiraan1" name="nm_perkiraan[]" placeholder="Nama Perkiraan" readonly>
										  </div>-->
										  <div class="col-sm-3">
										  <input type="text" class="form-control" name="no_ref[]" placeholder="Referensi">
										  </div>
										  
										  <div class="col-sm-4">
											<input type="text" class="form-control" name="ket[]" placeholder="Keterangan">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="nominal[]" placeholder="Nominal">
										  </div>
										  <div class="col-sm-2">
											<select class="form-control" name="dk[]" placeholder="Uang Masuk/Keluar" >
												<option value="K">Uang Keluar</option>
												<option value="D">Uang Masuk</option>
											</select>
										  </div>
										  <div class="col-sm-1">
											<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>
										</div>
											<div id="product"></div>
											<script type="text/javascript">
												var idrow = 1;
												function addMore() {
													idrow++;
													$("#product").append("<div class='product-item form-group'><div class='col-sm-3'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-4'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value='K'>Uang Keluar</option><option value='D'>Uang Masuk</option></select></div><div class='col-sm-1'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
										  
										  	
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
												$(function () {
													//Initialize Select2 Elements
													$(".select2").select2();
												});
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
		</div>
	</section>
<?php
break;

case "tambahbbk":
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
					<div class="table-responsive">
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=jurnal&act=input_bg_cek">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">Tanggal</label>
										  <div class="col-sm-3">
											<input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?php echo date("Y-m-d");?>">
										  </div>
										</div>
										<div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">No. Jurnal</label>
										  <div class="col-sm-3">
											<input type="text" class="form-control" name="no_jurnal" placeholder="Nomor Jurnal " value="J.<?=date("y.m")?>." >
										  </div>
										</div>
									<?php
										if($_GET['id']==''){
									?>
									  <div class="box-body">
										
										<div class="product-item form-group">
							  		  	  
										  <div class="col-sm-1">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="nm_perkiraan1" name="nm_perkiraan[]" placeholder="Nama Perkiraan" readonly>
										  </div>
										  <div class="col-sm-1">
										  <input type="text" class="form-control" name="no_ref[]" placeholder="Referensi">
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
													$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right' onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-2'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]' placeholder='Nama Perkiraan'></div><div class='col-sm-1'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control' name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
										  
										  	
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
												$(function () {
													//Initialize Select2 Elements
													$(".select2").select2();
												});
											</script>
											<DIV class="btn-action float-clear" align="center">
												<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
												<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
												<span class="success"><?php if(isset($message)) { echo $message; }?></span>
											</DIV>
									  </div>
									<?php
										}else{
									?>			
										<div class="box-body">
										<?php
										
										for ($a = 1; $a <= 2; $a++) {
										
											$x=1;
											$query=mysql_query("select * from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where no_ref='$_GET[id]'");
											while ($hasil=mysql_fetch_array($query)){
											if($a==1){
										?>	
										<div class="product-item form-group">  
										  <div class="col-sm-1">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(<?=$x?>)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-1">
											<input type="text" class="form-control" id="nm_perkiraan<?=$x?>"  name="nm_perkiraan[]" placeholder="Nama Perkiraan" readonly>
										  </div>
										  <div class="col-sm-3">
										  <input type="text" class="form-control" name="no_ref[]" value="BBK-<?=date('Y-m')?>-" placeholder="Referensi">
										  </div>
										  
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="ket[]" value="<?=$hasil[ket]?>" placeholder="Keterangan">
										  </div>
										  
										  <div class="col-sm-1">
										  	<input type="text" class="form-control" name="bgcek[]" value="<?=$hasil[no_ref]?>" placeholder="BG dan Cek">
										  </div>
										  
										  <div class="col-sm-1">
											<input type="text" class="form-control" name="nominal[]" value="<?=$hasil[nominal]?>" placeholder="Nominal">
										  </div>
										  <div class="col-sm-1">
											<select class="form-control" name="dk[]" >
												<option value="<?=$hasil['dk']?>">
												<?php
													if ($hasil['dk']=='D'){
														echo "Debit";
													}else{
														echo "Kredit";
													}
												?>		
												</option>
												<option value="D">Debit</option>
												<option value="K">Kredit</option>
											</select>
										  </div>
										  <div class="col-sm-2">
											<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>
										</div>
										<?php $x++ ; 
											}else{ 
										?>	
										<div class="product-item form-group">  
										  <div class="col-sm-1">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(<?=$x?>)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-1">
											<input type="text" class="form-control" id="nm_perkiraan<?=$x?>"  name="nm_perkiraan[]" placeholder="Nama Perkiraan" value="<?=$hasil[nm_perkiraan]?>" readonly>
										  </div>
										  <div class="col-sm-3">
										  <input type="text" class="form-control" name="no_ref[]" value="<?=$hasil[no_ref]?>" placeholder="Referensi">
										  </div>
										  
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="ket[]" value="<?=$hasil[ket]?>" placeholder="Keterangan">
										  </div>
										  
										  <div class="col-sm-1"><input type="text" class="form-control" name="bgcek[]" value="" placeholder="BG dan Cek"></div>
										  
										  <div class="col-sm-1">
											<input type="text" class="form-control" name="nominal[]" value="<?=$hasil[nominal]?>" placeholder="Nominal">
										  </div>
										  <div class="col-sm-1">
											<select class="form-control" name="dk[]" >
												<option value="D">
												<?php
													if ($hasil['dk']=='D'){
														echo "Kredit";
													}else{
														echo "Debit";
													}
												?>		
												</option>
												<option value="D">Debit</option>
												<option value="K">Kredit</option>
											</select>
										  </div>
										  <div class="col-sm-2">
											<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>
										</div>
										<?php $x++ ; 		
											}}}?>
																
											<div id="product"></div>
											
											<script type="text/javascript">
											var idrow = <?=$x?>;
												function addMore() {
													idrow++;
													$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right'onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-1'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]'placeholder='Nama Perkiraan' readonly></div><div class='col-sm-3'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-1'><input type='text' class='form-control' name='bgcek[]' placeholder='BG dan Cek'></div><div class='col-sm-1'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-1'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-1'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
										  
										  	
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
												$(function () {
													//Initialize Select2 Elements
													$(".select2").select2();
												});
											</script>
											<DIV class="btn-action float-clear" align="center">
												<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
												<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
												<span class="success"><?php if(isset($message)) { echo $message; }?></span>
											</DIV>
									  </div>
									<?php  	
										}
									?>
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
		</div>
		
		
		
			<div class="box-header with-border">
				<h3 class="box-title">Pilih No Cek dan BG untuk yang sudah di cairkan pada bank masing-masing</h3>
			</div>
			<!-- /.box-header -->
			
				<div class="row">
					<div class="table-responsive">
					<div class="col-md-12">	
						<table id="myTable4" class="table table-bordered table-striped">
							<thead>
							<tr>
								<th>NO</th>
								<th>No. Jurnal</th>
								<th>TANGGAL</th>
								<th>NO CEK dan BG</th>
								
							</tr>
							</thead>
							
							<?php
								$no=1;
								$query=mysql_query("select * from jurnal as j 
								join perkiraan as p on j.id_perkiraan = p.id_perkiraan 
								where kode_perkiraan='1.5.03.001' group by no_ref order by tgl desc") or die(mysql_error());
								while ($hasil=mysql_fetch_array($query)){
							?>
							<tr>
								<tr>
									<td><?=$no?></td>
									<td><?=$hasil['no_jurnal']?></td>
									<td><?=$hasil['tgl']?></td>
									<td><?=$hasil['no_ref']?></td>
									<td>
										<button type="button" class="btn btn-info" onclick="location.href='<?php echo "oklogin.php?module=jurnal&act=tambahbbk&id=$hasil[no_ref]";?>';" ><i class="fa fa-plus"></i></button>
									</td>
								</tr>
							</tr>	
							<?php $no++; } ?>	
							
						</table>
					</div>
					</div>
				</div>
			
					
	</section>
	
<?php
break;
		
case "edit":

$id_jurnal = $_GET['id'];
if (empty($id_jurnal)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from jurnal where id_jurnal='$id_jurnal'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>Edit Data</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Edit Data</a></li>
			<li class="active">Form Edit Data</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit Data</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=kas&act=edit">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Tanggal</label>
								  <div class="col-sm-6">
								  	<input type="hidden" class="form-control" name="id_jurnal"  value='<?php echo $update['id_jurnal'];?>'>
									<input type="text" class="form-control" name="tgl"  value="<?php echo $update['tgl'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Referensi</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="no_ref"  value='<?php echo $update['no_ref'];?>'>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Keterangan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="ket"  value="<?php echo $update['ket'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Nominal</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="nominal"  value="<?php echo $update['nominal'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Debet/Kredit</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="dk" value="<?php echo $update['dk'];?>">
									<a style="color: red">** inputka D Untuk Masuk atau K Saja untuk Keluar **</a>
								  </div>
								</div>
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