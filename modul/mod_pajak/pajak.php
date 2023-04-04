<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_pajak/aksi_pajak.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Content</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>HOME</a></li>
						<li class="active">Laporan System</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Laporan System</h3>
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
														<th>Keterangan</th>
														<th>Nominal</th>
														<th>Total Nominal</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$no=1;
														$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl_aw_a' and '$tgl_ak'  group by no_ref ORDER BY tgl desc";
														$qry=mysql_query($query);
														while ($hasil=mysql_fetch_array($qry)){
															$no_ref=$hasil['no_ref'];
															$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
															$qry2=mysql_query($query2);
															$hasil2=mysql_fetch_array($qry2);
															?>
																<tr>
																	<td><?=$no?></td>
																	<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
																	<td><?=$no_ref?></td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo $hasil_detail['ket']."<br />"; 
																			}
															
																		?>
																	</td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo number_format($hasil_detail['nominal'])."<br />"; 
																			}
															
																		?>
																	</td>
																	<td><?=number_format($hasil['jml'])?></td>
																	<td align="center">
																		<button type="button"  class="btn btn-info" onclick="location.href='<?php echo "?module=pajak&act=view&id=$hasil[no_ref]&tgl=$hasil[tgl]";?>'; " ><i class="fa fa-eye"></i></button>
																		<!--<button type="button" class="btn btn-info" onclick="<?php echo "?module=pajak&act=view&id=$hasil[no_ref]&tgl=$hasil[tgl]"?>"><i class="fa fa-eye"></i></button>
																		<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=pajak&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>-->
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
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.row -->
			<div class="box box-default">		
					
			<div class="box-header with-border">
				<h3 class="box-title">Laporan Pajak</h3>
			</div>		
					
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="col-md-12">
						<div class="table-responsive">
							<div class="box-body">						
								<table id="myTable2" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Reff</th>
											<th>Keterangan</th>
											<th>Nominal</th>
											<th>Total Nominal</th>
											<th style="min-width:135px;" >Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											$query="SELECT *, sum(nominal) as jml FROM pajak where tgl between '$tgl_aw_a' and '$tgl_ak'  group by no_ref  ORDER BY tgl desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
												$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
												$qry2=mysql_query($query2);
												$hasil2=mysql_fetch_array($qry2);
												$no_ref=$hasil['no_ref'];
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$no_ref?></td>
														<td>
															<?php 
																$detail_qry1=mysql_query("select * from pajak where no_ref = '$no_ref'");
																while ($hasil_detail1=mysql_fetch_array($detail_qry1)){
																	echo $hasil_detail1['ket']."<br />"; 
																}
															
															?>
														</td>
														<td>
															<?php 
																$detail_qry1=mysql_query("select * from pajak where no_ref = '$no_ref'");
																while ($hasil_detail1=mysql_fetch_array($detail_qry1)){
																	echo number_format($hasil_detail1['nominal'])."<br />"; 
																}
															
															?>
														</td>
														<td><?=number_format($hasil['jml'])?></td>
														<td align="center">
															<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=pajak&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>
															
															<div class="btn-group">
															<button type="button"  class="btn btn-info" onclick="location.href='<?php echo "?module=pajak&act=edit&id=$hasil[no_ref]&tgl=$hasil[tgl]";?>'; " ><i class="fa fa-edit"></i></button>
															
															<button type="button"  class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=pajak&act=hapus&id=$hasil[no_ref]&tgl=$hasil[tgl]";?>'; " ><i class="fa fa-trash"></i></button>
															</div>
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
			
			</div>	
				</section>
				<script>
					$(function () {
						$("#myTable2").DataTable();
						$("#myTable").DataTable();
					});
				</script>
			<?php
			break;
	  
		case "view":
			?>
				<section class="content-header">
					<h1>VIEV EDIT</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Pajak</a></li>
						<li class="active">View Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">View Edit</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=pajak&act=input">
										<table id="myTable" class="table table-striped">
                						<tbody>
                						<div class="form-group">
										  <label class="col-sm-2 control-label">Tanggal</label>
										  <div class="col-sm-3">
											<input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?=$_GET['tgl']?>" readonly>
										  </div>
										</div>
									 
										<div class="form-group">
										  <label class="col-sm-2 control-label">No. Referensi</label>
										  <div class="col-sm-6">
											<input type="text" class="form-control" name="no_ref" value="<?=$_GET['id']?>" readonly>
										  </div>
										</div>	
                							<?php
												$no=1;
												$jml=0;
												$query1="SELECT * FROM jurnal as j
												JOIN perkiraan as p on j.id_perkiraan=p.id_perkiraan
												WHERE no_ref= '$_GET[id]'";
												$qry1=mysql_query($query1);
												while ($hasil1=mysql_fetch_array($qry1)){
													$tgl=$hasil1['tgl'];
													$nominal=$hasil1['nominal'];
													$jml=$jml+$nominal;
											?>
                											
               											
               							<div class="product-item form-group">
							  		  	
										  <div class="col-sm-1">
											<input type="hidden" class="form-control"  name="id_jurnal[]"  value="<?=$hasil1['id_jurnal']?>" >
										  </div>
										  <div>
											<input type="hidden" class="form-control"  name="id_perkiraan[]" value="<?=$hasil1['id_perkiraan']?>">
										  </div>
										  <div class="col-sm-1">
											<input type="text" class="form-control"  name="no_jurnal[]"  value="<?=$hasil1['no_jurnal']?>" placeholder="No Jurnal" readonly >
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="kode_perkiraan[]" value="<?=$hasil1['kode_perkiraan']?> - <?=$hasil1['nm_perkiraan']?>" readonly>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="ket[]" value="<?=$hasil1['ket']?>">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="nominal[]" value="<?=$hasil1['nominal']?>" >
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="dk[]" value="<?=$hasil1['dk']?>" readonly>
										  </div>
										 </div>
                										<?php
                										$no++;
                									}
                									
                								?>
                								
                						<tbody>
										</table>
										
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
					<h1>VIEW EDIT</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Pajak</a></li>
						<li class="active">View Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">View Edit</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=pajak&act=update">

                						<div class="form-group">
										  <label class="col-sm-2 control-label">Tanggal</label>
										  <div class="col-sm-3">
											<input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?=$_GET['tgl']?>" readonly>
										  </div>
										</div>
									 
										<div class="form-group">
										  <label class="col-sm-2 control-label">No. Referensi</label>
										  <div class="col-sm-6">
											<input type="text" class="form-control" name="no_ref" value="<?=$_GET['id']?>" readonly>
										  </div>
										</div>	
                							<?php
												$no=1;
												$jml=0;
												$query1="SELECT * FROM pajak as pj
												JOIN perkiraan as p on pj.id_perkiraan=p.id_perkiraan
												WHERE no_ref= '$_GET[id]'";
												$qry1=mysql_query($query1);
												while ($hasil1=mysql_fetch_array($qry1)){
													$tgl=$hasil1['tgl'];
													$nominal=$hasil1['nominal'];
													$jml=$jml+$nominal;
											?>
                											
               											
               						<div class="product-item form-group">
							  		  	
										  <div class="col-sm-1">
											<input type="hidden" class="form-control" id="id_jurnal<?=$no?>"  name="id_jurnal[]" value="<?=$hasil1['id_jurnal']?>" >
										  </div>
										  <div>
											<input type="hidden" class="form-control" id="id_perkiraan<?=$no?>"  name="id_perkiraan[]" value="<?=$hasil1['id_perkiraan']?>">
										  </div>
										  <div class="col-sm-1">
											<input type="text" class="form-control" id="no_jurnal<?=$no?>"  name="no_jurnal[]"  value="<?=$hasil1['no_jurnal']?>" placeholder="No Jurnal" readonly >
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="kode_perkiraan<?=$no?>" name="kode_perkiraan[]" value="<?=$hasil1['kode_perkiraan']?> - <?=$hasil1['nm_perkiraan']?>" readonly>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="ket<?=$no?>" name="ket[]" value="<?=$hasil1['ket']?>">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="nominal<?=$no?>" name="nominal[]" value="<?=$hasil1['nominal']?>">
										  </div>
										  <div class="col-sm-1">
											<input type="text" class="form-control" id="dk<?=$no?>" name="dk[]" value="<?=$hasil1['dk']?>" readonly>
										  </div>
										  <!--<div class="col-sm-1">
												<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>-->
									</div>
                										<?php
                										$no++;
                									}
                									
                								?>
                							<div id="product"></div>
											<!--<div class="text-center">
												<button type="button" onclick="addMore();" class="btn btn-default"><i class="fa fa-plus"></i></button>
												<button type="button" onclick="deleteRow();" class="btn btn-default"><i class="fa fa-minus"></i></button>
											</div>-->

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
					
					var idrow = <?=$no?>;
						function addMore() {
							idrow++;
							$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><input type='hidden' class='form-control' id=i'd_jurnal"+idrow+"' name='id_jurnal[]'></div><div><input type='hidden' class='form-control' id='id_perkiraan"+idrow+"' name='id_perkiraan[]'></div><div class='col-sm-1'><input type='text' class='form-control' id='no_jurnal"+idrow+"'  name='no_jurnal[]'  placeholder='No Jurnal' ></div><div class='col-sm-2'><input type='text' class='form-control' id='kode_perkiraan"+idrow+"' name='kode_perkiraan[]'></div><div class='col-sm-2'><input type='text' class='form-control' id='ket"+idrow+"' name='ket[]'></div><div class='col-sm-2'><input type='text' class='form-control' id='nominal"+idrow+"' name='nominal[]'></div><div class='col-sm-1'><input type='text' class='form-control' id='dk"+idrow+"' name='dk[]'></div><div class='col-sm-1'><input type='checkbox' class='pull-left' name='item_index[]'></div></div>");	
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
