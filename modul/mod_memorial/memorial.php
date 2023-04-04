<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_memorial/aksi_memorial.php";
switch($_GET[act]){
	// Tampil User
default:
?>
	<section class="content-header">
		<h1>memorial </h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">memorial</li>
		</ol>
	</section>
	
	<!-- Main content -->
	<section class="content">
	  <!-- SELECT2 EXAMPLE -->
		<div class="box box-default">
		    
		    
			<div class="box-header with-border">
				<h3 class="box-title">List memorial</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			    <div class="box-body" style="background: #C7C5C5">	    				
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

									<td><input type="submit" value="Submit"></td>
									<td></td>
									<td></td>
								</tr>
							  </tbody>
							</table>
							</form>
				  		</div>
							<?php
							$no=1;
							// Menentukan tanggal awal bulan dan akhir bulan
							$hari_ini = date("Y-m-d");
							if (empty($_POST['tgl_aw'])){
							    $tgl_aw = date('Y-m-01', strtotime('-1 month', strtotime($hari_ini)));
								$tgl_aw_a= date('Y-m-01', strtotime($hari_ini));
								$tgl_ak = date('Y-m-t', strtotime($hari_ini));

							}else{
								$tgl_aw_a=$_POST['tgl_aw'];
								$tgl_ak=$_POST['tgl_ak'];

							}
								$tgl1=date('Y-m-d',strtotime($tgl_aw_a));
								$tgl2=date('Y-m-d',strtotime($tgl_ak));
							?>	
								<h3>Periode : <?=date('d-M-Y',strtotime($tgl1))?> s/d <?=date('d-M-Y',strtotime($tgl2))?></h3>  
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="box-body">						
								<table id="myTable" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Perkiraan</th>
											<th>Keterangan</th>
											<th>No BG dan CEK</th>
											<th>Debet</th>
											<th>Kredit</th>
											<th style="min-width:135px;" >Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											$query="SELECT * FROM memorial where tgl between '$tgl_aw_a' and '$tgl_ak' ORDER BY tgl desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
												$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
												$qry2=mysql_query($query2);
												$hasil2=mysql_fetch_array($qry2);
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_ref']?></td>
														<td><?php echo $hasil2['kode_perkiraan']." - " .$hasil2['nm_perkiraan']; ?></td>
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
															<td align="right"><?=number_format($hasil['nominal'])?></td>
															
														<?php
														}
														?>
														<td align="center">
														<?php
															if($hasil['status']=='0'){
														?>
															<div class="btn-group">
															<?php
															if ($hasil['aproval']==''){
															?>	
															<button type="button" class="btn btn-primary" onclick="location.href='<?php echo "?module=jurnal&act=edit&id=$hasil[id_jurnal]";?>';" ><i class="fa fa-edit"></i></button>
															
															<button type="button"  class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=jurnal&act=hapus&id=$hasil[id_jurnal]";?>'; " ><i class="fa fa-trash"></i></button>
															<?php }else{ echo "$hasil[aproval]";} ?>
															</div>
															<?php
															}
														?>
														</td>
													</tr>
												<?php
												$no++;
											}
										?>
									</tbody>
								</table>
								<!-- /.tabel 1. -->
								<script>
                                    $(document).ready(function(){
                                    	$('#myTable').dataTable();
                                    });
                                </script>
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
			<div class="box-footer">
				<div class="col-md-6">
					<a href="?module=jurnal&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>
				</div>
				
			<!--	<div class="col-md-6 text-right" >
					<a href="?module=jurnal&act=tambahbbk"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus" _blank></i>BBK Cek dan BG</button></a>
				</div> -->
			</div>
			
			<div class="box-header with-border">
				<h3 class="box-title">Print List</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<h3>Periode : <?=date('d-M-Y',strtotime($tgl1))?> s/d <?=date('d-M-Y',strtotime($tgl2))?></h3> 
					<div class="col-md-6">
						<div class="table-responsive">
							<div class="box-body">						
								<table id="myTable2" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Jurnal</th>
											<th>Total Nominal</th>
											<th style="min-width:135px;" >Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl_aw_a' and '$tgl_ak' group by no_jurnal ORDER BY no_jurnal desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
												$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
												$qry2=mysql_query($query2);
												$hasil2=mysql_fetch_array($qry2);
												
												if ($hasil['no_jurnal']!=''){
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														
														<td><?=$hasil['no_jurnal']?></td>
														<td><?=number_format($hasil['jml'])?></td>
														<td align="center">
															<button type="button" class="btn " onclick="window.open('<?php echo "$aksi?module=jurnal&act=editform&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-eye"></i></button>
															<a href="?module=jurnal&act=view_jurnal&id=<?=$hasil['no_jurnal']?>"><button type="button" class="btn btn-default"><i class="fa fa-eyes"></i>View</button></a>
														</td>
													</tr>
												<?php
												$no++;
											}}
										?>
									</tbody>
								</table>
								<!-- /.tabel 1. -->
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.responsiv -->
					</div>
					<div class="col-md-6">
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
											<th>Aprove</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											$query="SELECT * FROM jurnal where tgl between '$tgl_aw_a' and '$tgl_ak' group by no_ref ORDER BY tgl desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
											    $aproval=$hasil['aproval'];
												$no_ref=$hasil['no_ref'];
												$query1=mysql_query("select * from jurnal where no_ref= '$hasil[no_ref]'");
												$jml=0;
												while ($hasil1=mysql_fetch_array($query1)){
												    if(($hasil1['id_perkiraan']!='73')or($hasil1['dk']!='D')){
													    $jml=$jml+$hasil1['nominal'];
												    }
												}

												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_ref']?></td>
														<td><?=number_format($jml)?></td>
														<td align="center">
														<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=jurnal&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>
														</td>
														<td>
														    <?php
														    if($aproval=='admin'){
														    ?>
														    <i class="fa fa-check"></i>
														    <?php
														    }
														    ?>
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
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=jurnal&act=input">
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
										  	 <?php
										    $query=mysql_query("select * from jurnal order by no_jurnal ASC");
										    $no_j=1;
										    while($hasil=mysql_fetch_array($query)){
										       $no_jurnal=$hasil['no_jurnal']; 
										       $no_j=substr("$no_jurnal",8);
										       $no_j=$no_j+1;
										    }
										    
										    ?>
										    <input type="text" class="form-control" name="no_jurnal" placeholder="Nomor Jurnal " value="J.<?=date("y.m")?>.<?=$no_j?>" readonly>
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
										  </div>-->	
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
													$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right'onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-2'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]'placeholder='Nama Perkiraan'></div><div class='col-sm-1'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
										  
										  	
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
    										        <?php
    										        $x++ ; 
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
            										<?php 
            										$x++ ; 		
    											    }
    											}
											}
											?>
																
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
								where j.id_perkiraan='73' group by no_ref order by tgl desc") or die(mysql_error());
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

case "view_jurnal":
?>
						<div class="table-responsive">
							<div class="box-body">						
								<table id="tableJurnal" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Jurnal</th>
											<th>Kode Perkiraan</th>
											<th>Referensi</th>
											<th>Keterangan</th>
											<th>Nominal</th>
											<th>DK</th>
										</tr>
									</thead>
									<tbody>
										<?php
										    $no_jurnal=$_GET['id'];
											$no=1;
											$query=mysql_query("SELECT * FROM jurnal as j join perkiraan as p ON  j.id_perkiraan=p.id_perkiraan where no_jurnal='$no_jurnal'");
											while($h=mysql_fetch_array($query)){
												
										?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($h['tgl']))?></td>
														<td><?=$h['no_jurnal']?></td>
														<td><?=$h['kode_perkiraan']?>-<?=$h['nm_perkiraan']?></td>
														<td><?=$h['no_ref']?></td>
														<td><?=$h['ket']?></td>
														<td><?=number_format($h['nominal'])?></td>
														<td><?=$h['dk']?></td>
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
                    <script>						
                    $(document).ready(function(){
                    	$('#tableJurnal').dataTable();
                    
                    });
                    </script>
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
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=jurnal&act=edit">
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
									<a style="color: red">** inputka D atau K Saja **</a>
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