<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_jurnal_keg/aksi_jurnal_operasional.php';
    switch ($_GET[act]) { // Tampil User
		default: 
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw= date('Y-m-01', strtotime($hari_ini. ' - 1 months'));
				$tgl_ak= date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str=date('01-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

			} else {
				$tgl_aw=$_POST['tgl_aw'];
				$tgl_ak=$_POST['tgl_ak'];

				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
			}
			if (empty($_POST['tgl_nops_aw'])){
				$tgl_nops_aw= date('Y-m-01', strtotime($hari_ini. ' '));
				$tgl_nops_ak= date('Y-m-t', strtotime($hari_ini));

				$tgl_nops_aw_str=date('01-M-Y',strtotime($tgl_nops_aw));
				$tgl_nops_ak_str=date('d-M-Y',strtotime($tgl_nops_ak));

			} else {
				$tgl_nops_aw=$_POST['tgl_nops_aw'];
				$tgl_nops_ak=$_POST['tgl_nops_ak'];

				$tgl_nops_aw_str=date('d-M-Y',strtotime($tgl_nops_aw));
				$tgl_nops_ak_str=date('d-M-Y',strtotime($tgl_nops_ak));
			}
			?>
			<script>
			$(document).ready(function(){
				$('#myTable').dataTable();
				$('#myTable2').dataTable();
				$('#myTable3').dataTable();
			});
			</script>	
			<section class="content-header">
				<h1>Jurnal Operasional</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>Jurnal</li>
					<li class="active">Jurnal Operasional</li>
				</ol>
			</section>
			
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="row">
						<div class="col-md-6">
							<div class="box-header with-border">
								<h3 class="box-title"><span class="text-blue text-bold">Tabel Jurnal Operasional JO</span> dari tgl <b><?=$tgl_aw_str?></b> s/d <b><?=$tgl_ak_str?></b></h3>
							</div>
							<div class="box-body">
								<form name="submit" action="?module=jurnal_operasional" method="POST">
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_aw">
									</div>
									
									<div class="col-md-3">
										<h4>Sampai : </h4>
									</div>
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_ak">
									</div>
									
									<div class="col-md-1">
										<button class="text-blue text-bold bg-gray btn" type="submit">OK</button>
									</div>
								</form>
							</div>

							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">
											<table id="myTable" class="table table-hover table-responsive table-bordered">
												<thead class="bg-blue">
													<tr >
														<th>NO</th>
														<th>DATE</th>
														<th>JOB ORDER NUMBER</th>
														<th>CUSTOMER NAME</th>
														<th>STATUS</th>
														<th>ACTION</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no=1;
													$query=mysql_query("SELECT * from pf_log WHERE tgl_pf between '$tgl_aw' and '$tgl_ak' order by tgl_pf desc , no_pf desc");
													while($hasil=mysql_fetch_array($query)){
														$id_pf=$hasil['id_pf'];
														$id_pf_log=$hasil['id_pf_log'];																
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$hasil['tgl_pf']?></td>
														<td><b><?=$hasil['no_jo']?></b></td>
														<td><?=$hasil['cust_name']?></td>
														<td><b class="text-blue"><?=$hasil['status_ops']?></b></td>
														<td>
															<a class="btn bg-gray btn-sm text-blue text-bold" href="?module=jurnal_operasional&act=detail&id=<?=$id_pf?>" >DETAIL</i></a>
														</td>
													</tr>
													<?php $no++; } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">						
							<div class="box-header with-border">
								<h3 class="box-title"><span class="text-blue text-bold">Tabel Jurnal Operasional Non JO</span> dari tgl <b><?=$tgl_nops_aw_str?></b> s/d <b><?=$tgl_nops_ak_str?></b></h3>
								<div class="box-tools pull-right">
									<a class="btn bg-blue text-bold btn-sm" href="?module=jurnal_operasional&act=tambah_nonoperasional"><i class="fa fa-plus"></i></a>
								</div>
							</div>
							<div class="box-body">
								<form name="submit" action="?module=jurnal_operasional" method="POST">
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_nops_aw">
									</div>
									
									<div class="col-md-3">
										<h4>Sampai Dengan : </h4>
									</div>
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_nops_ak">
									</div>
									
									<div class="col-md-1">
										<button class="text-blue text-bold bg-gray btn" type="submit">OK</button>
									</div>
								</form>
							</div>

							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">
											<table id="myTable2" class="table table-hover table-bordered table-responsive">
												<thead class="bg-light-blue">
													<tr>
														<th>NO</th>
														<th>DATE</th>
														<th>DESCRIPTION</th>
														<th>KEGIATAN</th>
														<th>ACTION</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$no=1;
													$query=mysql_query("SELECT * from jurnal_non_ops WHERE date_nops between '$tgl_nops_aw' and '$tgl_nops_ak' order by date_nops desc");
													while($hasil=mysql_fetch_array($query)){
														$id_jurnal_nops = $hasil['id_jurnal_nops'];
													?>
													<tr>
														<td><?=$no?> - <?=$id_jurnal_nops?></td>
														<td><?=$hasil['date_nops']?></td>
														<td><?=$hasil['desc_nops']?></td>
														<td><?=$hasil['kegiatan']?></td>
														<td>
															<a class="btn bg-gray text-blue text-bold btn-sm" href="?module=jurnal_operasional&act=detail_jurnal_nops&id_jurnal_nops=<?=$id_jurnal_nops?>" >DETAIL</i></a>
														</td>
													</tr>
													<?php $no++; } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>

			</section>
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><b class="text-blue">Tabel Search Jurnal Operasioanal</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong></h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-9">
								<form name="submit" action="?module=jurnal_operasional" method="POST">
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_aw">
									</div>
									
									<div class="col-md-2">
										<h4>Sampai : </h4>
									</div>
									<div class="col-md-4">
										<input class="form-control" type="date" name="tgl_ak">
									</div>
									
									<div class="col-md-1">
										<button class="btn bg-gray btn-md text-blue" type="submit"><b>OK</b></button>
									
									</div>
								</form>
							</div>
						</div>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-12">
									<table id="myTable3" class="table table-responsive table-bordered table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NUMBER</th>
												<th>DATE</th>
												<th>JOB ORDER NUMBER</th>												
												<th>NOMOR AJU</th>
												<th>NOMOR BL</th>
												<th>NO KONTAINER</th>																								
												<th>NO SEAL</th>
												<th>NO POLISI</th>												
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											//$query = mysql_query("SELECT * FROM pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc, no_pf desc");
											$query = mysql_query("SELECT * from jurnal_ops as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join detail on rc.id_jurnal_ops=detail.id_jurnal_ops
											WHERE date_ops between '$tgl_aw' and '$tgl_ak' and
											no_kontainer !=''									
											order by date_ops desc");
											while ($hasil = mysql_fetch_array($query)) { 
												$id_pf = $hasil['id_pf']; 
											?>
											<tr>
												<td><?= $no ?></td>
												<td><?= $hasil['no_pf'] ?></td>
												<td><?= date('d-M-Y',strtotime($hasil['tgl_detail']))?></td>
												<td><b><?= $hasil['no_jo'] ?></b></td>												
												<td><?= $hasil['aju_number'] ?></td>
												<td><?= $hasil['bl_number'] ?></td>
												<td><?= $hasil['no_kontainer'] ?></td>																								
												<td><?= $hasil['no_seal'] ?></td>
												<td><?= $hasil['nopol'] ?></td>
												<td>	
													<a class="btn bg-light-blue btn-sm" href="?module=jurnal_operasional&act=showdetail&id=<?= $id_pf ?>"><b>DETAIL</b></a>													
												</td>
											</tr>
										<?php $no++;}?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<script>
					if ( window.history.replaceState ) {
					window.history.replaceState( null, null, window.location.href );
					}
				</script>
			</section>	
		<?php 
		break;
		
		case 'detail':
			$id_pf=$_GET['id'];
			?>
				<!DOCTYPE html>
				<html>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional">Jurnal Operasional</a></li>
						<li class="active">Detail Proforma</li>
					</ol>
				</section>
			
				<!-- Main content -->
				<section class="content">
			
				<!-- SELECT2 EXAMPLE -->
					<?php
						$query0 = mysql_query("SELECT * FROM pf_log where id_pf=$id_pf");
						$hasil0 = mysql_fetch_array($query0);
						$id_pf_log = $hasil0['id_pf_log'];
					?>	
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Detail Proforma</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!--- PROFORMA --->
								<div class="col-md-12">
									<a><label>INFORMATION PROFORMA</label></a>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-content">
												<div class="row">
													<div class="col-md-6">
														<table class="table">
															<tr>
																<td>JOB ORDER NUMBER</td>
																<td>:</td>
																<td><?=$hasil0['no_jo']?></td>
															</tr>
															<tr>
																<td>CUSTOMER NAME</td>
																<td>:</td>
																<td><?=$hasil0['cust_name']?></td>
															</tr>
															<tr>
																<td>CUSTOMER REFF</td>
																<td>:</td>
																<td><?=$hasil0['cust_ref']?></td>
															</tr>
															<tr>
																<td>ADDRESS</td>
																<td>:</td>
																<td><?=$hasil0['address_pf']?></td>
															</tr>
															<tr>
																<td>PIC</td>
																<td>:</td>
																<td><?=$hasil0['pic']?></td>
															</tr>
															<tr>
																<td>SHIPMENT</td>
																<td>:</td>
																<td><?=$hasil0['shipment']?></td>
															</tr>
															<tr>
																<td><strong>NOMOR AJU</strong></td>
																<td>:</td>
																<td><strong><?=$hasil0['aju_number']?></strong></td>
															</tr>
															<tr>
																<td><strong>NOMOR BL</strong></td>
																<td>:</td>
																<td><strong><?=$hasil0['bl_number']?></strong></td>
															</tr>
															<tr>
																<td><strong>STATUS</strong></td>
																<td>:</td>
																<td><strong><?=$hasil0['status_ops']?></strong></td>
															</tr>
														</table>

														<div class="modal fade" id="proforma" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h5>Edit Info Proforma</h5>
																	</div>
																	<form name="submit1" action="<?=$aksi?>" method="get">
																	<div class="modal-body" >
																		<div class="form-group">
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_status">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">

																			<label>NOMOR AJU</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="aju_number" value=<?=$hasil0['aju_number']?>>
																		</div>
																		<div class="form-group">
																			<label>NOMOR BL</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="bl_number" value=<?=$hasil0['bl_number']?>>
																		</div>
																		<div class="form-group">
																			<label>STATUS</label>
																			<select id="type-revenue-0" class="form-control" name="status_ops" required onchange="checkRevTypeValue(this.value, 0)">
																				<option value="APPROVED"> APPROVED </option>
																				<option value="SPPB / NPE"> SPPB / NPE </option>
																				<option value="SPJM">SPJM</option>
																				<option value="DELIVERED"> DELIVERED </option>
																			</select>																			
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="submit1" class="btn btn-success">Edit</button>
																	</div>
																	</form>
																</div>
															</div>
														</div>

														<a class="btn btn-primary text-white btn-sm" data-toggle="modal" href="#proforma">EDIT</a>
														<a class="btn btn-info text-white btn-sm" data-toggle="modal" href="?module=jurnal_operasional&act=show&id=<?= $id_pf ?>">DETAIL</a>

														<!--- ORDER --->
														<div class="table-order mt-2">
															<h5><a><strong>TABLE REVENUE</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>TYPE</th>
																	<th>DESCRIPTION</th>
																	<th>QTY</th>
																	<th>VALUE</th>
																	<th>ACTION</th>
																</tr>
															
																<?php
																$no_job=1;	
																$total_revenue=0;				
																$query2 = mysql_query("SELECT * from pf_revenue where id_pf_log=$id_pf_log");
																while ($hasil2 = mysql_fetch_array($query2)) { 	
																	$id_pf_revenue=$hasil2['id_pf_revenue'];
																?>	
																<tr>					
																	<td><?=$no_job?></td>
																	<td><?=$hasil2['type_revenue']?></td>
																	<td><?=$hasil2['desc_revenue']?></td>
																	<td>
																		<?=$hasil2['qty_revenue']?>
																	</td>
																	<td><?=$hasil2['revenue']?></td>
																	<td>
														<!-- Modal content-->															
															<div class="modal fade" id="edit_revenue<?=$id_pf_revenue?>" role="dialog">
																<div class="modal-dialog">
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h5>Edit Tabel Order</h5>
																		</div>
																		<form name="submit1" action="<?=$aksi?>" method="get">
																		<div class="modal-body" >
																			<div class="form-group">
																				<input type="hidden" name="module" value="jurnal_operasional">
																				<input type="hidden" name="act" value="edit_revenue">
																				<input type="hidden" name="id" value="<?=$id_pf_log?>">
																				<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																				<input type="hidden" name="id_pf_revenue" value="<?=$id_pf_revenue?>">

																				<label>TYPE</label>
																				<select id="type-revenue-0" class="form-control" name="type_revenue" required>
																					<option value="<?=$hasil2['type_revenue']?>"> <?=$hasil2['type_revenue']?></option>
																					<option value="ALL IN RATE"> ALL IN RATE </option>
																					<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																					<option value="PORT CHARGES"> PORT CHARGES </option>
																					<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																					<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																					<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																					<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																					<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																				</select>
																			</div>
																			<div class="form-group">
																				<label>DESCRIPTION 1</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" list="descrev" type="text" value="<?=$hasil2['desc_revenue']?>" class="form-control" name="desc_revenue" placeholder="- PILIH DESC REVENUE -">
																				<datalist id="descrev">																					
																					<option value="OPS ACT"> OPS ACT </option>
																					<option value="BOOK CNTR"> BOOK CNTR </option>
																					<option value="OVERTIME"> OVERTIME </option>
																					<option value="TOLL AND PARKIR"> TOLL AND PARKIR </option>
																					<option value="EXTEND CLOSING"> EXTEND CLOSING </option>
																					<option value="OPEN CLOSING"> OPEN CLOSING </option>
																					<option value="EARLY OPEN"> EARLY OPEN </option>
																					<option value="PEB DECLARATION"> PEB DECLARATION </option>
																					<option value="PHISICAL CHECK"> PHISICAL CHECK </option>
																					<option value="RE-ADDRESS"> RE-ADDRESS </option>
																					<option value="OCEAN FREIGHT"> OCEAN FREIGHT </option>
																					<option value="DO FEE"> DO FEE </option>
																					<option value="AGENCY FEE"> AGENCY FEE </option>
																					<option value="STORAGE"> STORAGE </option>
																					<option value="HANDLING IN/OUT"> HANDLING IN/OUT </option>
																					<option value="RE-STUFFING"> RE-STUFFING </option>
																					<option value="STEVEDORING"> STEVEDORING </option>
																					<option value="CARGODORING"> CARGODORING </option>
																					<option value="VGM"> VGM </option>
																					<option value="ISPM"> ISPM </option>
																					<option value="COO"> COO </option>
																					<option value="UNDERNAME"> UNDERNAME </option>
																					<option value=""> ... </option>
																				</datalist>
																			</div>																			
																			<div class="form-group">
																				<div class="row">
																					<div class="col-sm-6">
																					<label>QUANTITY</label>
																						<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty_revenue" value="<?=$hasil2['qty_revenue']?>">
																					</div>
																					<div class="col-sm-6">
																						<label>RATE</label>
																						<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="rate" value="<?=$hasil2['revenue']?>" required>
																					</div>																					
																				</div>
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit1" class="btn btn-success">Edit</button>
																		</div>
																		</form>
																	</div>
																</div>
															</div>
																		<a class="btn btn-primary btn-sm" href="?module=jurnal_operasional&act=jurnal&id=<?=$id_pf?>&id_pf_log=<?=$id_pf_log?>&id_rev=<?=$id_pf_revenue?>&type_rev=<?=$hasil2['type_revenue']?>" >JURNAL</i></a>
																		<a class="btn btn-info btn-sm" data-toggle="modal" href="#edit_revenue<?=$id_pf_revenue?>"><span class="fa fa-edit"></a>	
																		<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_revenue&id=<?=$id_pf?>&id_pf_log=<?=$id_pf_log?>&id_rev=<?=$id_pf_revenue?>"><span class="fa fa-trash"></a>
																	</td>
																</tr>

																<?php
																	$no_job++; 
																}?>	
															</table>

															<!-- Modal content-->
															<div class="modal fade" id="add_revenue" role="dialog">
																<div class="modal-dialog">
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h5>Tambah Tabel Order</h5>
																		</div>
																		<form name="submit1" action="<?=$aksi?>" method="get">
																		<div class="modal-body" >
																			<div class="form-group">
																				<input type="hidden" name="module" value="jurnal_operasional">
																				<input type="hidden" name="act" value="tambah_revenue">
																				<input type="hidden" name="id" value="<?=$id_pf_log?>">
																				<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																				<input type="hidden" name="qty" value="<?=$hasil2['qty_revenue']?>">

																				<label>TYPE</label>
																				<select id="type-revenue-0" class="form-control" name="type_revenue" required>
																					<option value=""> - PILIH TYPE REVENUE -</option>
																					<option value="ALL IN RATE"> ALL IN RATE </option>
																					<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																					<option value="PORT CHARGES"> PORT CHARGES </option>
																					<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																					<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																					<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																					<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																					<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																				</select>
																			</div>
																			<div class="form-group">
																				<label>DESCRIPTION 1</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" list="descrev" type="text" class="form-control" name="desc_revenue" placeholder="- PILIH DESC REVENUE -">
																				<datalist id="descrev">																					
																					<option value="OPS ACT"> OPS ACT </option>
																					<option value="BOOK CNTR"> BOOK CNTR </option>
																					<option value="OVERTIME"> OVERTIME </option>
																					<option value="TOLL AND PARKIR"> TOLL AND PARKIR </option>
																					<option value="EXTEND CLOSING"> EXTEND CLOSING </option>
																					<option value="OPEN CLOSING"> OPEN CLOSING </option>
																					<option value="EARLY OPEN"> EARLY OPEN </option>
																					<option value="PEB DECLARATION"> PEB DECLARATION </option>
																					<option value="PHISICAL CHECK"> PHISICAL CHECK </option>
																					<option value="RE-ADDRESS"> RE-ADDRESS </option>
																					<option value="OCEAN FREIGHT"> OCEAN FREIGHT </option>
																					<option value="DO FEE"> DO FEE </option>
																					<option value="AGENCY FEE"> AGENCY FEE </option>
																					<option value="STORAGE"> STORAGE </option>
																					<option value="HANDLING IN/OUT"> HANDLING IN/OUT </option>
																					<option value="RE-STUFFING"> RE-STUFFING </option>
																					<option value="STEVEDORING"> STEVEDORING </option>
																					<option value="CARGODORING"> CARGODORING </option>
																					<option value="VGM"> VGM </option>
																					<option value="ISPM"> ISPM </option>
																					<option value="COO"> COO </option>
																					<option value="UNDERNAME"> UNDERNAME </option>
																					<option value=""> ... </option>
																				</datalist>
																			</div>																			
																			<div class="form-group">
																				<div class="row">
																					<div class="col-sm-6">
																					<label>QUANTITY</label>
																						<input onkeyup="this.value = this.value.toUpperCase()" list="qtyrev" type="text" class="form-control" name="qty_id[]" placeholder="- PILIH QUANTITY -">
																						<datalist id="qtyrev">
																							<option value="">- PILIH -</option>
																							<?php
																								$queryQty=mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																									while ($hasilQty=mysql_fetch_array($queryQty)){
																									?>
																										<option value="<?=$hasilQty['qty']?>"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></option>
																									<?php
																								} 
																							?>
																							<?php
																								$queryPudel=mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																									while ($hasilPudel=mysql_fetch_array($queryPudel)){
																									?>
																										<option value="<?=$hasilPudel['qty']?>"><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?> - <?=$hasilPudel['pudel_from']?>/<?=$hasilPudel['pudel_to']?></option>
																									<?php
																								} 
																							?>
																						</datalist>
																					</div>
																					<div class="col-sm-6">
																						<label>RATE</label>
																						<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="rate[]" placeholder="(IDR) tanpa titik, koma" required>
																					</div>																					
																				</div>
																			</div>
																			
																			<div id="quantity"></div>

																			<div class="form-group">
																				<div class="btn-action float-clear" align="left">
																					<input class="btn btn btn-info text-white btn-sm btn-sm" type="button" name="add_item" value="+ QUANTITY" onClick="addMoreParty();" />
																					<input class="btn btn btn-danger text-white btn-sm btn-sm" type="button" name="del_item" value="- QUANTITY" onClick="deleteRowParty();" />
																				</div>
																			</div>

																			<script type="text/javascript">
																				var qtyRow = 1;
																				function addMoreParty() {
																					$("#quantity").append(`
																					<div class="form-group qty-item-${qtyRow}">
																						<div class="row">
																							<div class="col-sm-6">
																							<label>QUANTITY</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" list="qtyrev" type="text" class="form-control" name="qty_id[]" placeholder="- PILIH QUANTITY -">
																						<datalist id="qtyrev">
																							<option value="">- PILIH -</option>
																							<?php
																								$queryQty=mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																									while ($hasilQty=mysql_fetch_array($queryQty)){
																									?>
																										<option value="<?=$hasilQty['qty']?>"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></option>
																									<?php
																								} 
																							?>
																							<?php
																								$queryPudel=mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																									while ($hasilPudel=mysql_fetch_array($queryPudel)){
																									?>
																										<option value="<?=$hasilPudel['qty']?>"><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?> - <?=$hasilPudel['pudel_from']?>/<?=$hasilPudel['pudel_to']?></option>
																									<?php
																								} 
																							?>
																						</datalist>
																							</div>
																							<div class="col-sm-6">
																								<label>RATE</label>
																								<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="rate[]" placeholder="(IDR) tanpa titik, koma" required>
																							</div>
																							
																						</div>
																					</div>
																					`);
																					qtyRow++;
																				}
																				function deleteRowParty() {
																					if (qtyRow > 1) {
																						$(`.qty-item-${qtyRow - 1}`).remove();
																						qtyRow--;
																					}
																				}					
																			</script>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit1" class="btn btn-success">Tambah</button>
																		</div>
																		</form>
																	</div>
																</div>
															</div>
															<?php
																$id_rev=$_GET['id_rev'];
																$queryRev = mysql_query("SELECT * FROM pf_revenue where id_pf_revenue=$id_rev");
																$hasilRev = mysql_fetch_array($queryRev);
															?>	
															
															<a class="btn btn-info text-white btn-sm" data-toggle="modal" href="#add_revenue">+ ORDER</a>
														</div>

														<!--- JURNAL OPS --->
														<div class="table-order mt-2">
															<h5><a><strong>TABLE LAPORAN JURNAL OPERASIONAL</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>DATE</th>
																	<th>TYPE</th>
																	<th>TYPE ALL IN RATE</th>
																	<th>DESCRIPTION</th>
																	<th>QUANTITY</th>
																	<th>ACTION</th>
																</tr>
															
																<?php
																$no_ops=1;	
																$queryOps = mysql_query("SELECT * from jurnal_ops where id_pf_log=$id_pf_log");
																while ($hasilOps = mysql_fetch_array($queryOps)) { 	
																	$id_jurnal_ops=$hasilOps['id_jurnal_ops'];
																?>	
																<tr>					
																	<td><?=$no_ops?></td>
																	<td><?=$hasilOps['date_ops']?></td>
																	<td><?=$hasilOps['type_ops']?></td>
																	<td><?=$hasilOps['type2_ops']?></td>
																	<td><?=$hasilOps['desc_ops']?></td>
																	<td><?=$hasilOps['qty']?> X <?=$hasilOps['qty_type1']?> <?=$hasilOps['qty_type2']?></td>
																	<td>
																	<?php
																		$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
																		$hasildetail = mysql_fetch_array($queryDetail);
																		$id_detail= $hasildetail['id_detail'];
																	?>
																		<a class="btn btn-info btn-sm" href="?module=jurnal_operasional&act=detail_jurnal&id=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&type_ops=<?=$hasilOps['type_ops']?>" ><span class="fa fa-info"></i></a>
																		<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_jurnal_ops&id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>"><span class="fa fa-trash"></a>
																		<!--<a class="btn btn-primary btn-sm" href="?module=jurnal_operasional&act=edit_laporan_jurnal&id=<?=$id_pf?>&id_pf_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_detail=<?=$id_detail?>" ><span class="fa fa-edit"></i></a>--->
																	</td>
																</tr>

																<?php
																	$no_ops++; 
																}?>	
															</table>
														</div>
													</div>
													<div class="col-md-6">
														
														<!--- PARTY --->
														<h5><a><strong>TABLE PARTY</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>QTY</th>
																<th>ACTION</th>
															</tr>
															<?php
																$numQtyData=1;
																$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																while ($hasilQty = mysql_fetch_array($query3)) { 
																	$id_pf_qty=$hasilQty['id_pf_qty'] ?>
																	<tr>
																		<td><?=$numQtyData?></td>
																		<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
																		<td>
																				<!-- Modal -->
															<div class="modal fade" id="qty<?=$id_pf_log?>" role="dialog">
																<div class="modal-dialog modal-lg" >
																	<!-- Modal content-->
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h4 class="text-bold text-green">Edit Party</h4>
																		</div>
																		<form name="submitQty" action="<?=$aksi?>" method="get">
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_qty">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																			<input type="hidden" name="id_pf_qty" value="<?=$id_pf_qty?>">
																			<div class="modal-body" >
																				<div class="form-group">
																					<?php
																						$num = 1;
																						$queryQty = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																						while ($hasilQtyEdit = mysql_fetch_array($queryQty)) { ?>
																						<label>PARTY #<?=$num?></label>
																						<div class="row">
																						<div class="col-sm-5 nopadding-right"><label>QTY</label><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_qty[]" class="form-control" value="<?=$hasilQtyEdit['qty']?>"></div>
																							<div class="col-sm-1 mt-1"><br><label class="control-label nopadding">X</label></div>
																							<div class="col-sm-5 nopadding"><label>TYPE</label><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type0[]" class="form-control" value="<?=$hasilQtyEdit['type1']?>"></div>																							
																						</div>
																						<?php
																						$num++;
																						} 
																					?>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																				<button type="submitQty" class="btn bg-green">Update</button>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
																				<a class="btn btn-info btn-sm" data-toggle="modal" href="#qty<?=$id_pf_log?>"><span class="fa fa-edit"></a>	
																				<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_qty&id=<?= $id_pf_qty ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		
																		</td>
																	</tr>
																<?php
																$numQtyData++;
																}
															?>
														</table>
																<div class="modal fade" id="qty_plus<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h4 class="text-bold text-green">Tambah Party</h4>
													</div>
													<form name="submit" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="jurnal_operasional">
															<input type="hidden" name="act" value="tambah_qty">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">

															<div class="form-group row">
																<div class="col-sm-6">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(this.value)" type="text" placeholder="Isi Hanya Angka" class="form-control pf_qty pf_qty_0" name="party_pf0" required>
																</div>
																<div class="col-sm-6">
																	<label>TYPE 1</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyType1Value(this.value)" list="type_qty" type="text" placeholder="- PILIH -" class="form-control pf_qty_type1_0" name="party_pf1" required>
																	<datalist id="type_qty">
																		<option value="">- PILIH -</option>
																		<option value="20FT" >20FT</option>
																		<option value="40FT">40FT</option>
																		<option value="45FT">45FT</option>
																		<option value="PACKAGE">PACKAGE</option>
																		<option value="PALLET" >PALLET</option>
																		<option value="CARTON">CARTON</option>
																		<option value="M3">M3</option>
																		<option value="MT">MT</option>
																		<option value="RT" >RT</option>
																		<option value="DOC" >DOC</option>
																		<option value="">...</option>
																	</datalist>
																	<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(0, this.value)" type="text" class="form-control pf_qty_desc1_0" name="party_pf1_desc" placeholder="isi jika opsi ... dipilih" autofocus></div>
																</div>																
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
														<button type="submit" class="btn bg-green">Tambah</button>
													</div>
													</form>
												</div>
											</div>
										</div>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#qty_plus<?=$id_pf?>">+ PARTY</a>

														<!--- PUDEL --->
														<h5><a><strong>TABLE PICKUP DELIVERY</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>DATE</th>
																<th>QTY</th>
																<th>FROM/TO</th>
																<th>ACTION</th>
															</tr>
															<?php																
																$numPudelData=1;
																$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																
																while ($hasilPudel = mysql_fetch_array($query3)) { 
																	$id_pf_pudel=$hasilPudel['id_pf_pudel'] ?>
																	<tr>
																		<td><?=$numPudelData?></td>
																		<td><?=$hasilPudel['pudel_date']?></td>
																		<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
																		<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
																		<td>
																			<!-- Modal -->
															<div class="modal fade" id="pudel<?=$id_pf_log?>" role="dialog">
																<div class="modal-dialog modal-lg" >
																	<!-- Modal content-->
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h4 class="text-bold text-green">Edit Pick Up Delivery</h4>
																		</div>
																		<form name="submitQty" action="<?=$aksi?>" method="get">
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_pudel">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																			<input type="hidden" name="id_pf_pudel" value="<?=$id_pf_pudel?>">
																			<div class="modal-body" >
																				<div class="form-group">
																				<?php 	
																					$num = 1;
																					$queryPudel = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																					while ($hasilQty = mysql_fetch_array($queryPudel)) { ?>
																				<div class="form-group">
																					<label>PU/DEL #<?=$num?></label>
																					<div class="row">
																					<div class="col-sm-12">
																							<label>DATE</label>
																							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_date0[]" class="form-control" value="<?=$hasilQty['pudel_date']?>"></div>
																						<div class="col-sm-3 nopadding-right">
																							<label>QTY</label>
																							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_qty[]" class="form-control" value="<?=$hasilQty['qty']?>">
																						</div>
																						<div class="col-sm-1 mt-1"><br><label class="control-label nopadding">X</label></div>
																						<div class="col-sm-4 nopadding">
																							<label>TYPE 1</label>
																							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type0[]" class="form-control" value="<?=$hasilQty['type1']?>">
																						</div>
																						<div class="col-sm-4">
																							<label>TYPE 2</label>
																							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type1[]" class="form-control" value="<?=$hasilQty['type2']?>">
																						</div>
																						
																						<div class="col-sm-12">
																							<div class="row">
																								<div class="col-sm-6"><label>FROM</label></div>
																								<div class="col-sm-6"><label>TO</label></div>
																							</div>
																							<div class="row">
																								<div class="col-sm-6">
																									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_from[]" class="form-control" value="<?=$hasilQty['pudel_from']?>">
																								</div>
																								<div class="col-sm-6">
																									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_to[]" class="form-control" value="<?=$hasilQty['pudel_to']?>">
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																					<?php
																					$num++;
																					}
																				?>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																				<button type="submitQty" class="btn bg-green">Update</button>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
																			<a class="btn btn-info btn-sm" data-toggle="modal" href="#pudel<?=$id_pf_log?>"><span class="fa fa-edit"></a>	
																			<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_pudel&id=<?= $id_pf_pudel ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		</td>
																	</tr>
																<?php $numPudelData++;
																}
															?>
														</table>
														<!-- Modal -->
										<div class="modal fade" id="pudel_plus<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h4 class="text-bold text-green">Tambah Pick Up Delivery</h4>
													</div>
													<form name="submit" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="jurnal_operasional">
															<input type="hidden" name="act" value="tambah_pudel">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
															
															<div class="form-group row">
																<div class="col-sm-12">
																	<label>DATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="datetime-local" class="form-control" name="pudel_date0" autofocus required>
																</div>
																<div class="col-sm-12">
																	<label>QTY</label>
																	<div class="row">
																		<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyPudel(0, this.value)" placeholder="Angka" type="text" id="pudel-qty-0" class="form-control" name="pudel_party_qty" autofocus required></div>
																		<div class="col-sm-4">
																			<input class="form-control" list="type_pudel" id="pudel-qty-type1-0" name="pudel_party_pf1" placeholder="- PILIH -">
																			<datalist id="type_pudel">																				
																				<option value="20FT" >20FT</option>
																				<option value="40FT">40FT</option>
																				<option value="45FT">45FT</option>
																				<option value="TRUCK">TRUCK</option>																	
																				<option value="">...</option>
																			</datalist>
																			<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc1Pudel(0, this.value)" type="text" id="pudel-qty-desc1-0" class="form-control" name="pudel_party_pf1_desc" placeholder="isi jika opsi ... dipilih" autofocus></div>
																		</div>
																		<div class="col-sm-4">
																		<input class="form-control" list="type_pudel2" id="pudel-qty-type2-0" name="pudel_party_pf2" placeholder="- PILIH -">
																			<datalist id="type_pudel2">																				
																				<option value="STD" >STD</option>
																				<option value="HC">HC</option>
																				<option value="RF">RF</option>
																				<option value="FR">FR</option>
																				<option value="OT">OT</option>
																				<option value="FUSO BOX">FUSO BOX</option>
																				<option value="FUSO">FUSO</option>
																				<option value="CDD BOX">CDD BOX</option>
																				<option value="CDD" >CDD</option>
																				<option value="PICK UP BOX">PICK UP BOX</option>
																				<option value="PICK UP">PICK UP</option>
																				<option value="PICK UP 300 BOX">PICK UP 300 BOX</option>
																				<option value="PICK UP 300" >PICK UP 300</option>
																				<option value="WING BOX">WING BOX</option>
																				<option value="TRONTON BOX">TRONTON BOX</option>
																				<option value="TRONTON">TRONTON</option>
																				<option value="DUMP TRUCK" >DUMP TRUCK</option>
																				<option value="">...</option>
																			</datalist>
																			<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc2Pudel(0, this.value)" type="text" id="pudel-qty-desc2-0" class="form-control" name="pudel_party_pf2_desc" placeholder="isi jika opsi ... dipilih" autofocus></div>
																		</div>
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="row">
																		<div class="col-sm-6"><label>FROM</label></div>
																		<div class="col-sm-6"><label>TO</label></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeFromPudel(0, this.value)" type="text" class="form-control pf_pudel_from_0" name="pudel_route_from_pf" autofocus required></div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeToPudel(0, this.value)" type="text" class="form-control pf_pudel_to_0" name="pudel_route_to_pf" autofocus required></div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
														<button type="submit" class="btn bg-green">Tambah</button>
													</div>
													</form>
												</div>
											</div>
										</div>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#pudel_plus<?=$id_pf?>">+ PICKUP DELIVERY</a>
														
														<!--- SOR --->
														<h5><a><strong>TABLE SPECIAL ORDER</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>REQUEST</th>
																<th>ACTION</th>
															</tr>
															<?php
																$no_sor=1;
																$query1 = mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
																while ($hasil1=mysql_fetch_array($query1)){
																	$id_pf_sor=$hasil1['id_pf_sor'];
																?>
																	<tr>
																		<td><?=$no_sor?></td>
																		<td><?=$hasil1['desc_sor']?></td>
																		<td>
																				<!-- Modal -->
																				<div class="modal fade" id="sor<?=$id_pf_sor?>" role="dialog">
																					<div class="modal-dialog">
																						<!-- Modal content-->
																						<div class="modal-content" style="color: black;">
																							<div class="modal-header">
																								<button type="button" class="close" data-dismiss="modal"></button>
																								<h5>Edit Special Order Request</h5>
																							</div>
																							<form name="submit" action="<?=$aksi?>" method="get">
																							<input type="hidden" name="module" value="jurnal_operasional">
																							<input type="hidden" name="act" value="update_sor">
																							<input type="hidden" name="id" value="<?=$id_pf?>">
																							<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																							<div class="modal-body" >
																								<div class="form-group">
																									
																									<?php 	
																					$num = 1;
																					$queryPudel = mysql_query("SELECT * from pf_sor where id_pf_log=$id_pf_log");
																					while ($hasilQty = mysql_fetch_array($queryPudel)) { ?>
																				<div class="form-group">
																				<label>Description #<?=$num?>:</label>
																					<div class="row">
																					<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_sor[]" class="form-control" value="<?=$hasilQty['desc_sor']?>">
																					</div>
																				</div>
																					<?php
																					$num++;
																					}
																				?>
																								</div>
																							</div>
																							<div class="modal-footer">
																								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																								<button type="submit" class="btn btn-success">Update</button>
																							</div>
																							</form>
																						</div>
																					</div>
																				</div>	
																				<a class="btn btn-info btn-sm" data-toggle="modal" href="#sor<?=$id_pf_sor?>"><span class="fa fa-edit"></a>	
																				<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_sor&id=<?= $id_pf_sor ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		</td>
																	</tr>
																<?php 
																$no_sor++; 
																}
															?>
														</table>
														<!-- Modal -->
										<div class="modal fade" id="sor_plus<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h4 class="text-bold text-green">Tambah Special Order Request</h4>
													</div>
													<form name="submit" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="jurnal_operasional">
															<input type="hidden" name="act" value="tambah_sor">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">

															<label>Description :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_sor" class="form-control" value="<?=$hasil1['desc_sor']?>">
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
														<button type="submit" class="btn bg-green">Tambah</button>
													</div>
													</form>
												</div>
											</div>
										</div>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#sor_plus<?=$id_pf?>">+ SPECIAL ORDER</a>

														<!--- REAL CUSTOMER --->
														<h5><a><strong>TABLE REAL CUSTOMER</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>NAME</th>
																<th>ACTION</th>
															</tr>
															<?php
																$no_ru=1;
																	$query1 = mysql_query("select * from real_user where id_pf_log=$id_pf_log");
																	while ($hasil1=mysql_fetch_array($query1)){
																		$id_real_user=$hasil1['id_real_user'];
																?>
																<tr>
																	<td><?=$no_ru?></td>
																	<td><?=$hasil1['name_real_user']?></td>
																	<td>
																			<!-- Modal -->
																			<div class="modal fade" id="ru_edit<?=$id_real_user?>" role="dialog">
																				<div class="modal-dialog">
																					<!-- Modal content-->
																					<div class="modal-content" style="color: black;">
																						<div class="modal-header">
																							<button type="button" class="close" data-dismiss="modal"></button>
																							<h5>Edit Real Customer</h5>
																						</div>
																						<form name="submit" action="<?=$aksi?>" method="get">
																						<div class="modal-body" >
																							<div class="form-group">
																								<input type="hidden" name="module" value="jurnal_operasional">
																								<input type="hidden" name="act" value="update_ru">
																								<input type="hidden" name="id" value="<?=$id_pf?>">
																								<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">

																								<label>REAL CUSTOMER NAME  :</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="name_real_user" class="form-control" value="<?=$hasil1['name_real_user']?>">
																							</div>
																							<div class="form-group">
																								<label>ADDRESS</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="address_real_user" class="form-control" value="<?=$hasil1['address_real_user']?>">
																							</div>
																							<div class="form-group">
																								<label>CUSTOMER REFF</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="reff_cust" class="form-control" value="<?=$hasil1['reff_cust']?>">
																							</div>
																							<div class="form-group">
																								<label>CUSTOMER CODE</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="code_cust" class="form-control" value="<?=$hasil1['code_cust']?>">
																							</div>
																							<div class="form-group">
																								<label>PIC NAME</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pic" class="form-control" value="<?=$hasil1['pic']?>">
																							</div>
																							<div class="form-group">
																								<label>PHONE</label>
																								<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="phone_real_user" class="form-control" value="<?=$hasil1['phone_real_user']?>">
																							</div>
																						</div>
																						<div class="modal-footer">
																							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																							<button type="submit" class="btn btn-success">Update</button>
																						</div>
																						</form>
																					</div>
																				</div>
																			</div>
																			<a class="btn btn-info btn-sm" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
																			<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																	
																	</td>
																</tr>
															<?php 
																$no_ru++;
																}
															?>
														</table>
														<!-- Modal -->
											<div class="modal fade" id="ru_plus<?=$id_pf?>" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content" style="color: black;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal"></button>
															<h4 class="text-bold text-green">Tambah Real Customer</h4>
														</div>
														<form name="submit" action="<?=$aksi?>" method="get">
														<div class="modal-body" >
															<div class="form-group">
																<input type="hidden" name="module" value="jurnal_operasional">
																<input type="hidden" name="act" value="tambah_ru">
																<input type="hidden" name="id" value="<?=$id_pf?>">
																<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">

																<label>REAL CUSTOMER NAME :</label>
																
																<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="name_real_user" class="form-control">-->
																<select class="form-control" id="nm_cust" name="name_real_user" onchange="changeValue(this.value)" required>
																	<option value="">- SELECT -</option>
																	<?php
																		$query4=mysql_query("select * from data_cust");
																		$jsArray = "var prdName = new Array();";
																		while($hasil4=mysql_fetch_array($query4)){
																	?>
																		<option name="name_real_user" value="<?=$hasil4['nm_cust']?>"><?=$hasil4['nm_cust']?></option>
																		<?php 
																		$jsArray .= "prdName['" . $hasil4['nm_cust'] . "'] = {alamat_cust:'" . addslashes($hasil4['alamat_cust']) . "',reff_cust:'" . addslashes($hasil4['reff_cust']) . "',code_cust:'" . addslashes($hasil4['code_cust']) . "',pic_cust:'".addslashes($hasil4['pic_cust'])."',phone_cust:'".addslashes($hasil4['phone_cust'])."'};\n";
																		} 
																		?>	
																</select>
																
															</div>
															<div class="form-group">
																<label>CUSTOMER REFF</label>
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="reff_cust" id="reff_cust" class="form-control">
															</div>
															<div class="form-group">
																<label>CUSTOMER CODE</label>
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="code_cust" id="code_cust" class="form-control">
															</div>
															<div class="form-group">
																<label>ADDRESS</label>
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="address_real_user" id="alamat_cust" class="form-control">
															</div>
															<div class="form-group">
																<label>PIC NAME</label>
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pic" id="pic_cust" class="form-control">
															</div>
															<div class="form-group">
																<label>PHONE</label>
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="phone_real_user" id="phone_cust" class="form-control">
															</div>
															<script type="text/javascript"> 
																<?php echo $jsArray; ?>
																function changeValue(id){
																	document.getElementById('alamat_cust').value = prdName[id].alamat_cust;
																	document.getElementById('reff_cust').value = prdName[id].reff_cust;
																	document.getElementById('code_cust').value = prdName[id].code_cust;
																	document.getElementById('pic_cust').value = prdName[id].pic_cust;
																	document.getElementById('phone_cust').value = prdName[id].phone_cust;
																};
															</script>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
															<button type="submit" class="btn bg-green">Tambah</button>
														</div>
														</form>
													</div>
												</div>
											</div>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#ru_plus<?=$id_pf?>">+ REAL CUSTOMER</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				
			<?php 
		break;
		case 'show': 
			$id_pf=$_GET['id'];?>
			<section class="content-header">
				<h1>Detail Information Proforma</h1>
				<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional">Jurnal Operasional</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?= $id_pf ?>">Detail Proforma</a></li>
						<li class="active">Detail Information Proforma</li>
				</ol>
			</section>
			<?php
				$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id] and log_pf='0'");
				$id_pf;
				$hasil;
				$id_data;
				if (mysql_num_rows($queryData)==0) {
					$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
					($hasil = mysql_fetch_array($query)) or die(mysql_error());
					echo("<script>console.log('TIDAK ADA: " . $hasil . "');</script>");
					$id_data = 'id_pf';
					$id_pf = $hasil['id_pf'];
					$id_pf2 = $hasil['id_pf'];  
				} elseif(mysql_num_rows($queryData)!=0) {
					($hasil = mysql_fetch_array($queryData)) or die(mysql_error());
					echo("<script>console.log('ADA: " . $hasil . "');</script>");
					$id_data = 'id_pf_log';
					$id_pf = $hasil['id_pf_log'];
					$id_data_pf = 'id_pf';
					$idPf = $hasil['id_pf'];
					$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
					($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
					$id_pf2 = $hasil2['id_pf'];
					$status2 = $hasil2['status_ops'];
					if($status2 == '0'){
						$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
						($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
						$id_pf2 = $hasil2['id_pf'];
					}
				}

			?>
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border"></div>
					<div class="bg-blue">
						<div class="box-body">
							<div class="col-md-5 nopadding">
								<table style="width:100%" >
									<tr>
										<td>NUMBER</td>	
										<td>:</td>
										<td><?= $hasil['no_pf'] ?></td>		
									</tr>
									<tr>
										<td>DATE</td>	
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>		
									</tr>
									<tr>
										<td>CUSTOMER NAME</td>	
										<td>:</td>
										<td><?= $hasil['cust_name'] ?></td>		
									</tr>
									<tr>
										<td style="vertical-align:top">ADDRESS</td>	
										<td style="vertical-align:top">:</td>
										<td><?= $hasil['address_pf'] ?></td>		
									</tr>
									<tr>
										<td>SHIPMENT</td>	
										<td>:</td>
										<td><?= $hasil['shipment'] ?></td>		
									</tr>
									<tr>
										<td>COMMODITY</td>
										<td>:</td>
										<td><?= $hasil['commodity'] ?></td>		
									</tr>
									<tr>
										<td>NO JO</td>
										<td>:</td>
										<td><?= $hasil['qty_pf'] ?></td>		
									</tr>
									<tr>
										<td>ROUTE</td>	
										<td>:</td>
										<td><?= $hasil['route_pf'] ?></td>		
									</tr>
									<tr>
										<td>CREDIT TERM</td>	
										<td>:</td>
										<td><?= $hasil['ct'] ?> HARI</td>		
									</tr>
									<tr>
										<td>SALES</td>	
										<td width=15>:</td>
										<td><?= $hasil['sales'] ?> </td>		
									</tr>
									<tr>
										<td>SHIPPING/FORWARDING</td>	
										<td>:</td>
										<td><?= $hasil['sf'] ?></td>		
									</tr>
									<tr>
										<td>VESSEL/VOYAGE</td>	
										<td>:</td>
										<td><?= $hasil['vv'] ?></td>		
									</tr>
								</table>
							</div>	
							<div class="col-md-5">
								<table style="width:100%">
									<tr>
										<td>JOB ORDER NUMBER</td>	
										<td width=15>:</td>
										<td><?= $hasil['no_jo'] ?></td>		
									</tr>												
									<tr>
										<td>CUSTOMER REFF</td>	
										<td>:</td>
										<td><?= $hasil['cust_ref'] ?></td>		
									</tr>
									<tr>
										<td>CUSTOMER CODE</td>	
										<td>:</td>
										<td><?= $hasil['cust_code'] ?></td>		
									</tr>
									<tr>
										<td>PIC</td>	
										<td>:</td>
										<td><?= $hasil['pic'] ?></td>		
									</tr>
									<tr>
										<td>PHONE</td>	
										<td>:</td>
										<td><?= $hasil['phone'] ?></td>		
									</tr>
									<tr>
										<td>ETB/ETD</td>	
										<td>:</td>
										<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
									</tr>				
									<tr>
										<td>OPEN STACK</td>	
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['openstack'])) ?> </td>		
									</tr>
									<tr>
										<td>CLOSING TIME CONTAINER</td>	
										<td>:</td>
										<td><?=date("d M y h:i:s", strtotime($hasil['ctc']))  ?> </td>		
									</tr>
									<tr>
										<td>CLOSING TIME DOCUMENT</td>	
										<td>:</td>
										<td><?=date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>		
									</tr>
									<tr>
										<td>B/L NUMBER</td>	
										<td>:</td>
										<td><?= $hasil['bl_number'] ?> </td>		
									</tr>
									<tr>
										<td>AJU NUMBER</td>	
										<td>:</td>
										<td><?= $hasil['aju_number'] ?> </td>		
									</tr>
								</table>				
							</div>
							<div class="col-md-2">
								<table>
									<tr>
										<td>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=excel&id=<?= $id_pf2 ?>"><span class="fa fa-save"></a>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_operasional&act=print&id=<?= $id_pf2 ?>" target="_blank"><span class="fa fa-print"></a>
										</td>
									</tr>
									<tr>
										<td align="center">
											<?php
												if($hasil['aprove']=="batal"){
											?>
												<img src="images/aproved/batal.png" width="150" height="150">

											<?php } elseif ($hasil['aprove']=="0"){ ?>

												<h2>PROFORMA</h2>
											<?php	
											}elseif ($hasil['aprove']==42){
											?>	
												<img src="images/aproved/aproved.png" width="150" height="150">
											<?php
											}elseif ($hasil['aprove']=="1"){
											?>    
											<img src="images/aproved/aproved.png" width="150" height="150">
											<?php
											}elseif($hasil['aprove']=="BILL"){
											?>
												<h2>BILL</h2>
											<?php	
											}else{
											?>
												<h2>PAID</h2>
											<?php
											}
											?>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>

					<div class="bg-default">
						<div class="box-body">
							<div class="row mb-3">
								<div class="col-sm-6">
									<h5><a><strong>PARTY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>QTY</th>
										</tr>
										<?php
											$numQtyData=1;
											$query3 = mysql_query("SELECT * from pf_qty where $id_data=$id_pf");
											while ($hasilQty = mysql_fetch_array($query3)) { ?>
												<tr>
													<td><?=$numQtyData?></td>
													<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
												</tr>
											<?php
											$numQtyData++;
											}
										?>
									</table>
								</div>
								<div class="col-sm-6">
									<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>DATE</th>
											<th>QTY</th>
											<th>FROM/TO</th>
										</tr>
										<?php
											$numPudelData=1;
											$query3 = mysql_query("SELECT * from pf_pudel where $id_data=$id_pf");
											while ($hasilPudel = mysql_fetch_array($query3)) { ?>
												<tr>
													<td><?=$numPudelData?></td>
													<td><?=$hasilPudel['pudel_date']?></td>
													<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
													<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
												</tr>
											<?php
											$numPudelData ++;
											}
										?>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>REQUEST</th>
										</tr>
										<?php
											$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where $id_data=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
											?>
												<tr>
													<td><?=$no_sor?></td>
													<td><?=$hasil1['desc_sor']?></td>
												</tr>
											<?php 
											$no_sor++; 
											}
										?>
									</table>
								</div>
								<div class="col-sm-6">
									<h5><a><strong>REAL CUSTOMER</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>NAME</th>
										</tr>
										<?php
											$no_ru=1;
												$query1 = mysql_query("select * from real_user where $id_data=$id_pf");
												while ($hasil1=mysql_fetch_array($query1)){
													$id_real_user=$hasil1['id_real_user'];
											?>
											<tr>
												<td><?=$no_ru?></td>
												<td><?=$hasil1['name_real_user']?></td>
											</tr>
										<?php 
											$no_ru++;
											}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-md-6">
								<h5><a><strong>TABLE EST REVENUE</strong></a></h5>
								<?php
									$type1=mysql_query("select * from pf_revenue where $id_data_pf=$idPf");
									$hasil_type1=mysql_fetch_array($type1);
								?>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
									</tr>
								
									<?php
									$no_job=1;	
									$total_revenue=0;				
									$query2 = mysql_query("select * from pf_revenue where $id_data_pf=$idPf order by id_pf_revenue asc");
									while ($hasil2 = mysql_fetch_array($query2)) { 	
										$id_pf_revenue=$hasil2['id_pf_revenue'];
										$total_revenue += $hasil2['qty_revenue'] * $hasil2['revenue']
									?>	
									<tr>					
										<td><?=$no_job?></td>
										<td><?=$hasil2['type_revenue']?></td>
										<td><?=$hasil2['desc_revenue']?></td>
										<td><?=$hasil2['qty_revenue']?></td>
										<td><?=$hasil2['revenue']?></td>
										<td><?=$hasil2['qty_revenue'] * $hasil2['revenue']?></td>
									</tr>

									<?php
										$no_job++; 
									}?>	
								</table>
							</div>	

							<div class="col-md-6">
								<h5><a><strong>TABLE EST COST</strong></a></h5>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
									</tr>
									<?php
									$no_job2=1;	
									$sum_est_cost=0;
									$total_est_cost=0;						
									$query3 = mysql_query("select * from pf_est_cost where $id_data_pf=$idPf order by id_pf_est_cost asc");
									while ($hasil3 = mysql_fetch_array($query3)) { 
										$id_pf_est_cost=$hasil3['id_pf_est_cost'];
										$total_est_cost += $hasil3['qty_est_cost'] * $hasil3['est_cost']
									?>
									<tr>				
										<td><?=$no_job2?></td>
										<td><?=$hasil3['type_est_cost']?></td>
										<td><?=$hasil3['desc_est_cost']?></td>
										<td><?=$hasil3['qty_est_cost']?></td>
										<td><?=$hasil3['est_cost']?></td>
										<td><?=$hasil3['qty_est_cost'] * $hasil3['est_cost']?></td>
									</tr>	
									<?php
										$no_job2++; 
									}?>	
								</table>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h5><a><strong>TABLE PERUBAHAN EST REVENUE</strong></a></h5>
								<?php
									$type1=mysql_query("select * from pf_revenue where $id_data=$id_pf");
									$hasil_type1=mysql_fetch_array($type1);
								?>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
									</tr>
								
									<?php
									$no_job=1;	
									$total_revenue=0;				
									$query2 = mysql_query("select * from pf_revenue where $id_data=$id_pf order by id_pf_revenue asc");
									while ($hasil2 = mysql_fetch_array($query2)) { 	
										$id_pf_revenue=$hasil2['id_pf_revenue'];
										$total_revenue += $hasil2['qty_revenue'] * $hasil2['revenue']
									?>	
									<tr>					
										<td><?=$no_job?></td>
										<td><?=$hasil2['type_revenue']?></td>
										<td><?=$hasil2['desc_revenue']?></td>
										<td><?=$hasil2['qty_revenue']?></td>
										<td><?=$hasil2['revenue']?></td>
										<td><?=$hasil2['qty_revenue'] * $hasil2['revenue']?></td>
									</tr>

									<?php
										$no_job++; 
									}?>	
								</table>
							</div>	

							<div class="col-md-6">
								<h5><a><strong>TABLE PERUBAHAN EST COST</strong></a></h5>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
									</tr>
									<?php
									$no_job2=1;	
									$sum_est_cost=0;
									$total_est_cost=0;						
									$query3 = mysql_query("select * from pf_est_cost where $id_data=$id_pf order by id_pf_est_cost asc");
									while ($hasil3 = mysql_fetch_array($query3)) { 
										$id_pf_est_cost=$hasil3['id_pf_est_cost'];
										$total_est_cost += $hasil3['qty_est_cost'] * $hasil3['est_cost']
									?>
									<tr>				
										<td><?=$no_job2?></td>
										<td><?=$hasil3['type_est_cost']?></td>
										<td><?=$hasil3['desc_est_cost']?></td>
										<td><?=$hasil3['qty_est_cost']?></td>
										<td><?=$hasil3['est_cost']?></td>
										<td><?=$hasil3['qty_est_cost'] * $hasil3['est_cost']?></td>
									</tr>	
									<?php
										$no_job2++; 
									}?>	
								</table>	
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
							<a><label>PROFIT/LOST EST COST</label></a>
								<table class="table table-striped">
									<tr>
										<th>NO</th>
										<th>ITEM</th>
										<th>TOTAL</th>
									</tr>
									<tr>
										<td>1</td>
										<td>TOTAL REVENUE</td>
										<td><?=number_format($total_revenue)?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>TOTAL EST COST</td>
										<td><?=number_format($total_est_cost)?></td>
									</tr>
									<tr>
										<td></td>
										<td>PROFIT AND LOST</td>
										<td><?=number_format($total_revenue-$total_est_cost)?></td>
									</tr>

								</table>
							</div>
							<div class="col-md-6">
							<a><label>PROFIT/LOST PERUBAHAN EST COST</label></a>
								<table class="table table-striped">
									<tr>
										<th>NO</th>
										<th>ITEM</th>
										<th>TOTAL</th>
									</tr>
									<tr>
										<td>1</td>
										<td>TOTAL REVENUE</td>
										<td><?=number_format($total_revenue_real)?></td>
									</tr>
									<tr>
										<td>2</td>
										<td>TOTAL EST COST</td>
										<td><?=number_format($total_est_cost_real)?></td>
									</tr>
									<tr>
										<td></td>
										<td>PROFIT AND LOST</td>
										<td><?=number_format($total_revenue_real-$total_est_cost_real)?></td>
									</tr>

								</table>
							</div>		
						</div>

						<div class="row">
							<div class="col-md-12">
								<h5><a><strong>TABLE REAL COST</strong></a></h5>
								<?php
									$type1=mysql_query("select * from pf_real_cost where $id_data=$id_pf");
									$hasil_type1=mysql_fetch_array($type1);
								?>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>DATE</th>
										<th>NO REFF</th>										
										<th>KATEGORY</th>
										<th>KEGIATAN</th>
										<th>STAKEHOLDER</th>
										<th>BUKTI</th>
										<th>VALUE</th>										
									</tr>
								
									<?php
									$no_job=1;	
									$total_revenue_real=0;				
									$query4 = mysql_query("select * from pf_real_cost where $id_data=$id_pf order by id_pf_real_cost asc");
									while ($hasil4 = mysql_fetch_array($query4)) { 	
										$id_pf_revenue=$hasil4['id_pf_revenue'];
										$total_revenue_real += $hasil4['qty_revenue'] * $hasil4['revenue']
									?>	
									<tr>					
										<td><?=$no_job?></td>
										<td><?=$hasil4['tgl_pf_real_cost']?></td>
										<td><?=$hasil4['no_reff_keu']?></td>
										<td><?=$hasil4['category1']?></td>
										<td><?=$hasil4['kegiatan']?></td>
										<td><?=$hasil4['stakeholder']?></td>
										<td><?=$hasil4['bukti']?></td>
										<td><?=number_format($hasil4['real_cost'])?></td>
									</tr>

									<?php
										$no_job++; 
									}?>	
								</table>
							</div>	
						</div>
						
					</div>
				</div>
			</section>
		<?php break;

case 'showdetail': 
	$id_pf=$_GET['id'];?>
	<section class="content-header">
		<h1>Detail Jurnal Operasional</h1>
		<ol class="breadcrumb">
				<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
				<li><a href="oklogin.php?module=jurnal_operasional">Jurnal Operasional</a></li>				
				<li class="active">Detail Jurnal Operasional</li>
		</ol>
	</section>
	<?php
		$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id] and log_pf='0'");
		$id_pf;
		$hasil;
		$id_data;
		if (mysql_num_rows($queryData)==0) {
			$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil = mysql_fetch_array($query)) or die(mysql_error());
			echo("<script>console.log('TIDAK ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf';
			$id_pf = $hasil['id_pf'];
			$id_pf2 = $hasil['id_pf'];  
		} elseif(mysql_num_rows($queryData)!=0) {
			($hasil = mysql_fetch_array($queryData)) or die(mysql_error());
			echo("<script>console.log('ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf_log';
			$id_pf = $hasil['id_pf_log'];
			$id_data_pf = 'id_pf';
			$idPf = $hasil['id_pf'];
			$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
			$id_pf2 = $hasil2['id_pf'];
			$status2 = $hasil2['status_ops'];
			if($status2 == '0'){
				$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
				$id_pf2 = $hasil2['id_pf'];
			}
		}

	?>
	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border"></div>
			<div class="bg-blue">
				<div class="box-body">
					<div class="col-md-5 nopadding">
						<table style="width:100%" >
							<tr>
								<td>NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['no_pf'] ?></td>		
							</tr>
							<tr>
								<td>DATE</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER NAME</td>	
								<td>:</td>
								<td><?= $hasil['cust_name'] ?></td>		
							</tr>
							<tr>
								<td style="vertical-align:top">ADDRESS</td>	
								<td style="vertical-align:top">:</td>
								<td><?= $hasil['address_pf'] ?></td>		
							</tr>
							<tr>
								<td>SHIPMENT</td>	
								<td>:</td>
								<td><?= $hasil['shipment'] ?></td>		
							</tr>
							<tr>
								<td>COMMODITY</td>
								<td>:</td>
								<td><?= $hasil['commodity'] ?></td>		
							</tr>
							<tr>
								<td>ROUTE</td>	
								<td>:</td>
								<td><?= $hasil['route_pf'] ?></td>		
							</tr>
							<tr>
								<td>CREDIT TERM</td>	
								<td>:</td>
								<td><?= $hasil['ct'] ?> HARI</td>		
							</tr>
							<tr>
								<td>SALES</td>	
								<td width=15>:</td>
								<td><?= $hasil['sales'] ?> </td>		
							</tr>
							<tr>
								<td>SHIPPING/FORWARDING</td>	
								<td>:</td>
								<td><?= $hasil['sf'] ?></td>		
							</tr>
							<tr>
								<td>VESSEL/VOYAGE</td>	
								<td>:</td>
								<td><?= $hasil['vv'] ?></td>		
							</tr>
						</table>
					</div>	
					<div class="col-md-5">
						<table style="width:100%">
							<tr>
								<td>JOB ORDER NUMBER</td>	
								<td width=15>:</td>
								<td><?= $hasil['no_jo'] ?></td>		
							</tr>												
							<tr>
								<td>CUSTOMER REFF</td>	
								<td>:</td>
								<td><?= $hasil['cust_ref'] ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER CODE</td>	
								<td>:</td>
								<td><?= $hasil['cust_code'] ?></td>		
							</tr>
							<tr>
								<td>PIC</td>	
								<td>:</td>
								<td><?= $hasil['pic'] ?></td>		
							</tr>
							<tr>
								<td>PHONE</td>	
								<td>:</td>
								<td><?= $hasil['phone'] ?></td>		
							</tr>
							<tr>
								<td>ETB/ETD</td>	
								<td>:</td>
								<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
							</tr>				
							<tr>
								<td>OPEN STACK</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['openstack'])) ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME CONTAINER</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctc']))  ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME DOCUMENT</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>		
							</tr>
							<tr>
								<td>B/L NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['bl_number'] ?> </td>		
							</tr>
							<tr>
								<td>AJU NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['aju_number'] ?> </td>		
							</tr>
						</table>				
					</div>
					<div class="col-md-2">
						<table>
							<tr>
								<td>								
								</td>
							</tr>
							<tr>
								<td align="center">
									<?php
										if($hasil['aprove']=="batal"){
									?>
										<img src="images/aproved/batal.png" width="150" height="150">

									<?php } elseif ($hasil['aprove']=="0"){ ?>

										<h2>PROFORMA</h2>
									<?php	
									}elseif ($hasil['aprove']==42){
									?>	
										<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif ($hasil['aprove']=="1"){
									?>    
									<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif($hasil['aprove']=="BILL"){
									?>
										<h2>BILL</h2>
									<?php	
									}else{
									?>
										<h2><?=$hasil['aprove']?></h2>
									<?php
									}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="bg-default">
				<div class="box-body">
					<div class="row mb-3">
						<div class="col-sm-6">
							<h5><a><strong>PARTY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>QTY</th>
								</tr>
								<?php
									$numQtyData=1;
									$query3 = mysql_query("SELECT * from pf_qty where $id_data=$id_pf");
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numQtyData?></td>
											<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
										</tr>
									<?php
									$numQtyData++;
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>DATE</th>
									<th>QTY</th>
									<th>FROM/TO</th>
								</tr>
								<?php
									$numPudelData=1;
									$query3 = mysql_query("SELECT * from pf_pudel where $id_data=$id_pf");
									while ($hasilPudel = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numPudelData?></td>
											<td><?=$hasilPudel['pudel_date']?></td>
											<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
											<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
										</tr>
									<?php
									$numPudelData ++;
									}
								?>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>REQUEST</th>
								</tr>
								<?php
									$no_sor=1;
									$query1 = mysql_query("select * from pf_sor where $id_data=$id_pf");
									while ($hasil1=mysql_fetch_array($query1)){
										$id_pf_sor=$hasil1['id_pf_sor'];
									?>
										<tr>
											<td><?=$no_sor?></td>
											<td><?=$hasil1['desc_sor']?></td>
										</tr>
									<?php 
									$no_sor++; 
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>REAL CUSTOMER</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>NAME</th>
								</tr>
								<?php
									$no_ru=1;
										$query1 = mysql_query("select * from real_user where $id_data=$id_pf");
										while ($hasil1=mysql_fetch_array($query1)){
											$id_real_user=$hasil1['id_real_user'];
									?>
									<tr>
										<td><?=$no_ru?></td>
										<td><?=$hasil1['name_real_user']?></td>
									</tr>
								<?php 
									$no_ru++;
									}
								?>
							</table>
						</div>
					</div>

					<!--- JURNAL OPS --->
					<div class="table-order mt-2">
															<h5><a><strong>TABLE LAPORAN JURNAL OPERASIONAL</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>DATE</th>
																	<th>TYPE</th>
																	<th>TYPE ALL IN RATE</th>
																	<th>STATUS OPERASIONAL</th>
																	<th>DESCRIPTION</th>
																	<th>QUANTITY</th>																	
																	<th>DETAIL KONTAINER</th>
																</tr>
															
																<?php
																$no_ops=1;	
																$no_detail=1;
																$queryOps = mysql_query("SELECT * from jurnal_ops where id_pf_log=$id_pf");
																while ($hasilOps = mysql_fetch_array($queryOps)) { 	
																	$id_jurnal_ops=$hasilOps['id_jurnal_ops'];
																?>	
																<tr>					
																	<td><?=$no_ops?></td>
																	<td><?=$hasilOps['date_ops']?></td>
																	<td><?=$hasilOps['type_ops']?></td>
																	<td><?=$hasilOps['type2_ops']?></td>
																	<td><?=$hasilOps['status_ops']?></td>
																	<td><?=$hasilOps['desc_ops']?></td>
																	<td><?=$hasilOps['qty']?> X <?=$hasilOps['qty_type1']?> <?=$hasilOps['qty_type2']?></td>																
																	<td>
																	<?php
																		$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
																		$hasildetail = mysql_fetch_array($queryDetail);
																		$id_detail= $hasildetail['id_detail'];
																	?>
																		<a class="btn btn-info btn-sm" href="?module=jurnal_operasional&act=detail_kontainer&id=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&type_ops=<?=$hasilOps['type_ops']?>" ><span class="fa fa-info"></i></a>																		
																	</td>	
																</tr>

																<?php
																	$no_ops++; 
																}?>	
															</table>
														</div>

				</div>
			</div>
		</div>		
	</section>
<?php break;
case 'detail_kontainer': 
			$id_pf = $_GET['id'];
			$id_pf_log = $_GET['id_log'];
			$id_jurnal_ops = $_GET['ops_id'];
			$type_rev=$_GET['type_ops'];
			?>
			<?php
				$query = mysql_query("SELECT * FROM jurnal_ops where id_jurnal_ops=$id_jurnal_ops");
				$hasil = mysql_fetch_array($query);
				$type_ops = $hasil['type_ops'];
				$type_ops2 = $hasil['type2_ops'];
				$queryLog = mysql_query("SELECT * FROM pf_log where id_pf_log=$id_pf");
				$hasilLog = mysql_fetch_array($queryLog);
				$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
				$hasilD = mysql_fetch_array($queryDetail);
				$id_pf_log = $hasilLog['id_pf_log'];
			?>	
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Document</title>
			</head>
			<body>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
						<li class="active">Detail Jurnal Operasional</li>
					</ol>
				</section>
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Detail Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						
						<div class="box-body">							
							<div class="row mt-2">
								<div class="col-md-12">
									<?php if ($type_ops=='TRANSPORTATION CHARGES' or $type_ops=='ALL IN RATE' or $type_ops=='') { ?>
									<h5><a><label>DETAIL KONTAINER</label></a></h5>
									<div class="table-responsive">
										<table id="myTable3" class="table table-bordered table-responsive table-hover">
											<thead>
												<tr class="info">
													<th>NO</th>
													<th>DATE</th>
													<th>NOMOR KONTAINER</th>
													<th>NOMOR SEAL</th>
													<th>NOPOL</th>
													<th>DRIVER </th>
													<th>CONTACT</th>
													<th>STAKEHOLDER</th>													
												</tr>
											</thead>
											<tbody>
												<?php
													$no=1;
													$querydetail=mysql_query("SELECT * from detail where id_jurnal_ops=$id_jurnal_ops");
													while ($hasildetail=mysql_fetch_array($querydetail)){
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasildetail['tgl_detail']?></td>
													<td><?=$hasildetail['no_kontainer']?></td>
													<td><?=$hasildetail['no_seal']?></td>
													<td><?=$hasildetail['nopol']?></td>
													<td><?=$hasildetail['nm_driver']?></td>
													<td><?=$hasildetail['hp_driver']?></td>
													<td><?=$hasildetail['stakeholder']?></td>
													
												</tr>
												<?php $no++; } ?>
											</tbody>
											
										</table>
									</div>
									<?php
										}
									?>
									<a><label>FILE DAN GAMBAR</label></a>
									<form name="submit1" action="<?=$aksi?>" method="GET">
									<div class="row box-body">
										<input type="hidden" name="module" value="jurnal_operasional">
										<input type="hidden" name="act" value="hapus_gambar">
										<input type="hidden" name="id_pf" value="<?=$id_pf?>">
										<input type="hidden" name="type_ops" value="<?=$type_ops?>">
										<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
										<input type="hidden" name="id_pf_operasional" value="<?=$id_jurnal_ops?>">
										<?php
											$query=mysql_query("SELECT * from images_db where id_jurnal_ops=$id_jurnal_ops");
											while ($hasil=mysql_fetch_array($query)){
												$id_images_db=$hasil['id_images_db'];
											?>	
											<div class="kotak col-md-3 checkbox-wrapper">	
												<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	
												<!--<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/> -->
												<a href="images/data_op/<?=$hasil['nm_file']?>" target="_blank">
													<?=$hasil['nm_file']?>
												</a>												
											</div>  
										<?php } ?>   
									</div>
									<div class="box-tools pull-right">
									<!--<button type="submit2" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar&id=<?=$id_images_db?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&gambar<?=$hasil['nm_file']?>"><span class="fa fa-trash"></a>-->
									</div>
									</form>
									
								</div>
							</div>
						</div>
					</div>			
				</section>			
			</body>
			</html>
		<?php
		break;
		case 'jurnal':
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$id_rev=$_GET['id_rev'];
			$type_rev=$_GET['type_rev'];			
			?>
				<!DOCTYPE html>
				<html>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Operasional</a></li>
						<li class="active">Tambah Jurnal Operasional</li>
					</ol>
				</section>
			
				<!-- Main content -->
				<section class="content">
			
				<!-- SELECT2 EXAMPLE -->
					<?php
						$query = mysql_query("SELECT * FROM pf_log where id_pf_log=$id_pf_log order by log_pf desc");
						$hasil = mysql_fetch_array($query);
						$queryRev = mysql_query("SELECT * FROM pf_revenue where id_pf_revenue=$id_rev");
						$hasilRev = mysql_fetch_array($queryRev);
					?>	
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Tambah Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									<form name="jurnal_ops" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_jurnal_ops"method="POST" enctype="multipart/form-data">	
										<!-- /.box-header -->
										<div class="box-body row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="hidden" name="id_pf" value="<?=$id_pf?>" >
													<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
													<input type="hidden" name="id_jurnal_ops" value="<?=$id_jurnal_ops?>">
													<input type="hidden" name="type_rev" value="<?=$type_rev?>">
													<div class="row">
														<div class="col-sm-6">
															<lable>DATE</lable>
															<input type="text" name="date_ops" class="form-control" value="<?=date('Y-m-d')?>" readonly>
														</div>
														<div class="col-sm-6">
															<lable>TYPE</lable>
															<input type="text" name="type_ops" class="form-control" value="<?=$hasilRev['type_revenue']?>" readonly>
														</div>														
													</div>
												</div>
												<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
													<label>STATUS :</label>
													<select class="form-control" name="status_ops" required>
														<option value="-">-Pilihan Status - </option>
														<option value="SPPB">SPPB</option>
														<option value="NPE">NPE</option>
														<option value="SPJM">SPJM</option>
														<option value="DELIVERED">DELIVERED</option> 
													</select>
													</div>
													<?php
												if ($type_rev=='ALL IN RATE') {
													?>
													<div class="col-sm-6">
														<label>TYPE ALL IN RATE</label>
														<select id="type-revenue-0" class="form-control" name="type_allinrate" required>
															<option value=""> - PILIH TYPE ALL IN RATE -</option>															
															<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
															<option value="PORT CHARGES"> PORT CHARGES </option>
															<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
															<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
															<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
															<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
															<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
														</select>
												</div>
												<?php
												}?>
												
												</div>
												</div>
												<div class="form-group">
												<div class="row">
												<div class="col-sm-6">
													<label>DESCRIPTION</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="description" class="form-control">
												</div>
												<?php
												if ($type_rev=='TRANSPORTATION CHARGES' or $type_rev=='ALL IN RATE') {
													?>
													<div class="col-sm-6">
													<label>QUANTITY</label>
													<div class="row">
														<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty" required></div>
														<div class="col-sm-4">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" list="qty_type1" class="form-control" name="qty_type1" placeholder="- PILIH -" required >
															<datalist id="qty_type1">																
																<option value="20FT" >20FT</option>
																<option value="40FT">40FT</option>
																<option value="45FT">45FT</option>
																<option value="PACKAGE">PACKAGE</option>
																<option value="PALLET" >PALLET</option>
																<option value="CARTON">CARTON</option>
																<option value="M3">M3</option>
																<option value="MT">MT</option>
																<option value="RT" >RT</option>
																<option value="">...</option>
															</datalist>
														</div>
														<div class="col-sm-4">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" list="qty_type2" class="form-control" name="qty_type2" placeholder="- PILIH -" required >
															<datalist id="qty_type2">
																<option value="">- PILIH -</option>
																<option value="STD" >STD</option>
																<option value="HC">HC</option>
																<option value="RF">RF</option>
																<option value="FR">FR</option>
																<option value="OT">OT</option>
																<option value="FUSO BOX">FUSO BOX</option>
																<option value="FUSO">FUSO</option>
																<option value="CDD BOX">CDD BOX</option>
																<option value="CDD" >CDD</option>
																<option value="PICK UP BOX">PICK UP BOX</option>
																<option value="PICK UP">PICK UP</option>
																<option value="PICK UP 300 BOX">PICK UP 300 BOX</option>
																<option value="PICK UP 300" >PICK UP 300</option>
																<option value="WING BOX">WING BOX</option>
																<option value="TRONTON BOX">TRONTON BOX</option>
																<option value="TRONTON">TRONTON</option>
																<option value="DUMP TRUCK" >DUMP TRUCK</option>
																<option value=" ">...</option>
															</datalist>
														</div>
													</div>
												</div>
													<?php
												}
												?>
												</div>
												</div>
												
												<div class="form-group">
													<div class="row">
													<div class="col-sm-6">
													<label>STAKE HOLDER :</label>
													<select class="form-control" name="stakeholder">
														<option value="-">- SELECT -</option>
														<?php
															$queryven=mysql_query("select * from data_vendor");
															while ($hasilven=mysql_fetch_array($queryven)){
														?>
														<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
														<?php
															}
															$query0=mysql_query("select * from data_cust");
															while($hasil0=mysql_fetch_array($query0)){
														?>
														<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
														<?php
															}
														?>
													</select>
													</div>
													<div class="col-sm-6">
														<label>UPLOAD FILE</label>
														<input type="file" name="nm_file[]" multiple>
													</div>
													</div>
												</div>

												<?php
												if ($type_rev=='TRANSPORTATION CHARGES' or $type_rev=='ALL IN RATE') {
													?>
												<div class="form-group">												
													<div class="row">
												<div class="col-sm-6">
													<label>B/L Number</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_bl" class="form-control">
												</div>
												<div class="col-sm-6">
													<label>Aju Number</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_aju" class="form-control">
												</div>
													</div>
												</div><br><br>
												<div class="box-header with-border">
													<h3 class="box-title text-blue text-bold">FORM INPUT DETAIL KONTAINER</h3>
												</div><br>
												<div class="form-group" id='product'>												
													<div class="row">
													
													<div class="col-sm-2">
													<label>NO KONTAINER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_kontainer[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NO SEAL</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_seal[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NO POLISI</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_pol[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NAMA DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_driver[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>CONTACT DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="contact[]" class="form-control">
												</div>												
												
												
													</div>
												</div>
												<script type='text/javascript'>
									var bbkRow = 1;
									function addMore() {
										$("#product").append(`
											<div class="mt-15 product-item row bbk-${bbkRow}">
											<div class="col-sm-2">
													<label>NO KONTAINER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_kontainer[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NO SEAL</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_seal[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NO POLISI</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_pol[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>NAMA DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_driver[]" class="form-control">
												</div>
												<div class="col-sm-2">
													<label>CONTACT DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="contact[]" class="form-control">
												</div>
											</div>
										`);
										bbkRow++;
									}

									function deleteRow() {
										if (bbkRow > 1) {
											$(`.bbk-${bbkRow - 1}`).remove();
											bbkRow--;
										}
									}
									function openwindowkas(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open(`modul/mod_jurnal_keg/tabel_est_cost.php?idrow=${idrow}&act=kas`,"",features);
									}
								</script>
												<div class="btn-action float-clear" align="center">	
													<input class="btn bg-gray text-bold text-blue" type="button" name="add_item" value="+" onClick="addMore();" />
													<input class="btn bg-gray text-bold text-red" type="button" name="del_item" value="-" onClick="deleteRow();" />
												</div>
												<?php
												}
												?>
												
												
											</div>
										</div>
										<div class="box-footer">
											<button type="jurnal_ops" name="bupload" class="btn btn-primary">SUBMIT</a>	
										</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
					<?php
		$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id] and log_pf='0'");
		$id_pf;
		$hasil;
		$id_data;
		if (mysql_num_rows($queryData)==0) {
			$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil = mysql_fetch_array($query)) or die(mysql_error());
			echo("<script>console.log('TIDAK ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf';
			$id_pf = $hasil['id_pf'];
			$id_pf2 = $hasil['id_pf'];  
		} elseif(mysql_num_rows($queryData)!=0) {
			($hasil = mysql_fetch_array($queryData)) or die(mysql_error());
			echo("<script>console.log('ADA: " . $hasil . "');</script>");
			$id_data = 'id_pf_log';
			$id_pf = $hasil['id_pf_log'];
			$id_data_pf = 'id_pf';
			$idPf = $hasil['id_pf'];
			$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
			($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
			$id_pf2 = $hasil2['id_pf'];
			$status2 = $hasil2['status_ops'];
			if($status2 == '0'){
				$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
				$id_pf2 = $hasil2['id_pf'];
			}
		}

	?>
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">INFORMATION PROFORMA</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
			<div class="box-header with-border"></div>
			<div class="bg-blue">
				<div class="box-body">
					<div class="col-md-5 nopadding">
						<table style="width:100%" >
							<tr>
								<td>NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['no_pf'] ?></td>		
							</tr>
							<tr>
								<td>DATE</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER NAME</td>	
								<td>:</td>
								<td><?= $hasil['cust_name'] ?></td>		
							</tr>
							<tr>
								<td style="vertical-align:top">ADDRESS</td>	
								<td style="vertical-align:top">:</td>
								<td><?= $hasil['address_pf'] ?></td>		
							</tr>
							<tr>
								<td>SHIPMENT</td>	
								<td>:</td>
								<td><?= $hasil['shipment'] ?></td>		
							</tr>
							<tr>
								<td>COMMODITY</td>
								<td>:</td>
								<td><?= $hasil['commodity'] ?></td>		
							</tr>
							<tr>
								<td>ROUTE</td>	
								<td>:</td>
								<td><?= $hasil['route_pf'] ?></td>		
							</tr>
							<tr>
								<td>CREDIT TERM</td>	
								<td>:</td>
								<td><?= $hasil['ct'] ?> HARI</td>		
							</tr>
							<tr>
								<td>SALES</td>	
								<td width=15>:</td>
								<td><?= $hasil['sales'] ?> </td>		
							</tr>
							<tr>
								<td>SHIPPING/FORWARDING</td>	
								<td>:</td>
								<td><?= $hasil['sf'] ?></td>		
							</tr>
							<tr>
								<td>VESSEL/VOYAGE</td>	
								<td>:</td>
								<td><?= $hasil['vv'] ?></td>		
							</tr>
						</table>
					</div>	
					<div class="col-md-5">
						<table style="width:100%">
							<tr>
								<td>JOB ORDER NUMBER</td>	
								<td width=15>:</td>
								<td><?= $hasil['no_jo'] ?></td>		
							</tr>												
							<tr>
								<td>CUSTOMER REFF</td>	
								<td>:</td>
								<td><?= $hasil['cust_ref'] ?></td>		
							</tr>
							<tr>
								<td>CUSTOMER CODE</td>	
								<td>:</td>
								<td><?= $hasil['cust_code'] ?></td>		
							</tr>
							<tr>
								<td>PIC</td>	
								<td>:</td>
								<td><?= $hasil['pic'] ?></td>		
							</tr>
							<tr>
								<td>PHONE</td>	
								<td>:</td>
								<td><?= $hasil['phone'] ?></td>		
							</tr>
							<tr>
								<td>ETB/ETD</td>	
								<td>:</td>
								<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
							</tr>				
							<tr>
								<td>OPEN STACK</td>	
								<td>:</td>
								<td><?= date("d M y h:i:s", strtotime($hasil['openstack'])) ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME CONTAINER</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctc']))  ?> </td>		
							</tr>
							<tr>
								<td>CLOSING TIME DOCUMENT</td>	
								<td>:</td>
								<td><?=date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>		
							</tr>
							<tr>
								<td>B/L NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['bl_number'] ?> </td>		
							</tr>
							<tr>
								<td>AJU NUMBER</td>	
								<td>:</td>
								<td><?= $hasil['aju_number'] ?> </td>		
							</tr>
						</table>				
					</div>
					<div class="col-md-2">
						<table>
							<tr>
								<td>								
								</td>
							</tr>
							<tr>
								<td align="center">
									<?php
										if($hasil['aprove']=="batal"){
									?>
										<img src="images/aproved/batal.png" width="150" height="150">

									<?php } elseif ($hasil['aprove']=="0"){ ?>

										<h2>PROFORMA</h2>
									<?php	
									}elseif ($hasil['aprove']==42){
									?>	
										<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif ($hasil['aprove']=="1"){
									?>    
									<img src="images/aproved/aproved.png" width="150" height="150">
									<?php
									}elseif($hasil['aprove']=="BILL"){
									?>
										<h2>BILL</h2>
									<?php	
									}else{
									?>
										<h2><?=$hasil['aprove']?></h2>
									<?php
									}
									?>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

			<div class="bg-default">
				<div class="box-body">
					<div class="row mb-3">
						<div class="col-sm-6">
							<h5><a><strong>PARTY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>QTY</th>
								</tr>
								<?php
									$numQtyData=1;
									$query3 = mysql_query("SELECT * from pf_qty where $id_data=$id_pf");
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numQtyData?></td>
											<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
										</tr>
									<?php
									$numQtyData++;
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>DATE</th>
									<th>QTY</th>
									<th>FROM/TO</th>
								</tr>
								<?php
									$numPudelData=1;
									$query3 = mysql_query("SELECT * from pf_pudel where $id_data=$id_pf");
									while ($hasilPudel = mysql_fetch_array($query3)) { ?>
										<tr>
											<td><?=$numPudelData?></td>
											<td><?=$hasilPudel['pudel_date']?></td>
											<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
											<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
										</tr>
									<?php
									$numPudelData ++;
									}
								?>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>REQUEST</th>
								</tr>
								<?php
									$no_sor=1;
									$query1 = mysql_query("select * from pf_sor where $id_data=$id_pf");
									while ($hasil1=mysql_fetch_array($query1)){
										$id_pf_sor=$hasil1['id_pf_sor'];
									?>
										<tr>
											<td><?=$no_sor?></td>
											<td><?=$hasil1['desc_sor']?></td>
										</tr>
									<?php 
									$no_sor++; 
									}
								?>
							</table>
						</div>
						<div class="col-sm-6">
							<h5><a><strong>REAL CUSTOMER</strong></a></h5>
							<table class="table table-bordered table-hover">
								<tr class="info">
									<th>NO</th>
									<th>NAME</th>
								</tr>
								<?php
									$no_ru=1;
										$query1 = mysql_query("select * from real_user where $id_data=$id_pf");
										while ($hasil1=mysql_fetch_array($query1)){
											$id_real_user=$hasil1['id_real_user'];
									?>
									<tr>
										<td><?=$no_ru?></td>
										<td><?=$hasil1['name_real_user']?></td>
									</tr>
								<?php 
									$no_ru++;
									}
								?>
							</table>
						</div>
					</div>					

				</div>
			</div>
		</div>
				</section>
				
			<?php 
		break;

		case 'detail_jurnal': 
			$id_pf = $_GET['id'];
			$id_pf_log = $_GET['id_log'];
			$id_jurnal_ops = $_GET['ops_id'];
			$type_rev=$_GET['type_ops'];
			?>
			<?php
				$query = mysql_query("SELECT * FROM jurnal_ops where id_jurnal_ops=$id_jurnal_ops");
				$hasil = mysql_fetch_array($query);
				$type_ops = $hasil['type_ops'];
				$type_ops2 = $hasil['type2_ops'];
				$queryLog = mysql_query("SELECT * FROM pf_log where id_pf=$id_pf");
				$hasilLog = mysql_fetch_array($queryLog);
				$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$id_jurnal_ops");
				$hasilD = mysql_fetch_array($queryDetail);
				$id_pf_log = $hasilLog['id_pf_log'];
			?>	
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Document</title>
			</head>
			<body>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
						<li class="active">Detail Jurnal Operasional</li>
					</ol>
				</section>
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Detail Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						
						<div class="box-body">
							<div class="row">
								<?php if ($type_ops=='TRANSPORTATION CHARGES' or $type_ops=='ALL IN RATE' or $type_ops=='') { ?>
									<div class="col-md-6">
									<div class="detail-kontainer">
										<a><label>FORM DETAIL KONTAINER</label></a>
										<form name="submit" action="<?=$aksi?>" method="GET">	
											<div class="row">
												<div class="col-sm-12">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label>DATE</label>
																<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																<input type="hidden" name="type_ops" value="<?=$type_ops?>">
																<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																<input type="hidden" name="id_jurnal_ops" value="<?=$id_jurnal_ops?>">
																<input type="hidden" name="module" value="jurnal_operasional" >
																<input type="hidden" name="act" value="tambah_detail" >
																<input type="text" name="tgl_detail" class="form-control" value="<?=date('Y-m-d')?>" readonly>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>NOMOR KONTAINER</label>
																<input type="text" name="no_kontainer" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>NOMOR SEAL</label>
																<input type="text" name="no_seal" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>NOPOL</label>
																<input type="text" name="nopol" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>DRIVER</label>
																<input type="text" name="nm_driver" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>CONTACT</label>
																<input type="text" name="hp_driver" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>STAKEHOLDER :</label>
																<select class="form-control" name="stakeholder">
																	<option value="-">- SELECT -</option>
																	<?php
																		$queryven=mysql_query("select * from data_vendor");
																		while ($hasilven=mysql_fetch_array($queryven)){
																	?>
																	<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
																	<?php
																		}
																		$query0=mysql_query("select * from data_cust");
																		while($hasil0=mysql_fetch_array($query0)){
																	?>
																	<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
																	<?php
																		}
																	?>
																</select>
															</div>
														</div>
													</div>
													<input class="btn btn-info" type="submit" value="SUBMIT"> 
												</div>
											</div>
										</form>
									</div>
								</div>
								<?php
								}
								?>
								
								<div class="col-md-6">
									<div class="detail-operasional">
										<h5><a><label>DETAIL OPERASIONAL</label></a></h5>
										<table class="table">
											<tr>
												<td>TYPE</td>
												<td>:</td>
												<td><?=$hasil['type_ops']?></td>
											</tr>
											<tr>
												<td>STATUS OPERASIONAL</td>
												<td>:</td>
												<td><?=$hasil['status_ops']?></td>
											</tr>
											<?php
											if (!empty($hasil['type2_ops'])) { ?>
												<tr>
												<td>TYPE ALL IN RATE</td>
												<td>:</td>
												<td><?=$hasil['type2_ops']?></td>
											</tr>
											<?php }
											?>
											<tr>
												<td>DESCRIPTION</td>
												<td>:</td>
												<td><?=$hasil['desc_ops']?></td>
											</tr>
											<tr>
												<td>QUANTITY</td>
												<td>:</td>
												<td><?=$hasil['qty']?> X <?=$hasil['qty_type1']?><?=$hasil['qty_type2']?></td>
											</tr>
											<tr>
												<td>STAKEHOLDER</td>
												<td>:</td>
												<td><?=$hasil['stakeholder']?></td>
											</tr>
										</table>
										<!-- Modal content-->
										<div class="modal fade" id="edit_detail_ops<?=$hasildetail['id_detail']?>" role="dialog">
																<div class="modal-dialog">
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h5>Edit Detail Operasional</h5>
																		</div>
																		<form name="submit1" action="<?=$aksi?>" method="get">
																		<div class="modal-body" >
																			<div class="form-group">
																				<input type="hidden" name="module" value="jurnal_operasional">
																				<input type="hidden" name="act" value="edit_detail_ops">
																				<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																				<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																				<input type="hidden" name="type_rev" value="<?=$type_rev?>">
																				<input type="hidden" name="id_jurnal_ops" value="<?=$id_jurnal_ops?>">
																				<?php
																					if (!empty($type_ops2)) { ?>
																						<lable>TYPE</lable>
																						<input type="text" name="type_ops" class="form-control" value="<?=$type_ops?>" readonly>
																						<label>TYPE ALL IN RATE</label>
																				<select id="type-revenue-0" class="form-control" name="type_ops2"  required>
																					<option value="<?=$hasil['type2_ops']?>"> <?=$hasil['type2_ops']?></option>																					
																					<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																					<option value="PORT CHARGES"> PORT CHARGES </option>
																					<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																					<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																					<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																					<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																					<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																				</select>
																				<?php	
																				}else{ ?>
																				<label>TYPE</label>
																				<select id="type-revenue-0" class="form-control" name="type_ops"  required>
																					<option value="<?=$hasil['type_ops']?>"> <?=$hasil['type_ops']?></option>
																					<option value="ALL IN RATE"> ALL IN RATE </option>
																					<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																					<option value="PORT CHARGES"> PORT CHARGES </option>
																					<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																					<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																					<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																					<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																					<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																				</select>
																				<?php	}
																				?>
																				
																			</div>
																			<div class="form-group">
																			    <label>STATUS OPERASIONAL</label>
																				<input class="form-control" name="status_ops" list="status_ops" id="status" value="<?=$hasil['status_ops']?>" placeholder="- PILIH DESC -" required>
																				<datalist id="status_ops">																					
																					<option value="SPPB">SPPB</option>
																					<option value="NPE">NPE</option>
																					<option value="SPJM">SPJM</option>
																					<option value="DELIVERED">DELIVERED</option> 
																				</datalist>
																			</div>
																			<div class="form-group">
																			    <label>DESCRIPTION</label>
																				<input class="form-control" list="desc" name="description" id="desc" value="<?=$hasil['desc_ops']?>" placeholder="- PILIH DESC -" required>
																				<datalist id="desc">																					
																					<option value="OPS ACT"> OPS ACT </option>
																					<option value="BOOK CNTR"> BOOK CNTR </option>
																					<option value="OVERTIME"> OVERTIME </option>
																					<option value="TOLL AND PARKIR"> TOLL AND PARKIR </option>
																					<option value="EXTEND CLOSING"> EXTEND CLOSING </option>
																					<option value="OPEN CLOSING"> OPEN CLOSING </option>
																					<option value="EARLY OPEN"> EARLY OPEN </option>
																					<option value="PEB DECLARATION"> PEB DECLARATION </option>
																					<option value="PHISICAL CHECK"> PHISICAL CHECK </option>
																					<option value="RE-ADDRESS"> RE-ADDRESS </option>
																					<option value="OCEAN FREIGHT"> OCEAN FREIGHT </option>
																					<option value="DO FEE"> DO FEE </option>
																					<option value="AGENCY FEE"> AGENCY FEE </option>
																					<option value="STORAGE"> STORAGE </option>
																					<option value="HANDLING IN/OUT"> HANDLING IN/OUT </option>
																					<option value="RE-STUFFING"> RE-STUFFING </option>
																					<option value="STEVEDORING"> STEVEDORING </option>
																					<option value="CARGODORING"> CARGODORING </option>
																					<option value="VGM"> VGM </option>
																					<option value="ISPM"> ISPM </option>
																					<option value="COO"> COO </option>
																					<option value="UNDERNAME"> UNDERNAME </option>
																					<option value=""> ... </option>
																				</datalist>
																			</div>
																			<div class="form-group">
																				<label>STAKEHOLDER</label>
																				<select class="form-control" name="stakeholder">
																	<option value="<?=$hasil['stakeholder']?>"><?=$hasil['stakeholder']?></option>
																	<?php
																		$queryven=mysql_query("select * from data_vendor");
																		while ($hasilven=mysql_fetch_array($queryven)){
																	?>
																	<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
																	<?php
																		}
																		$query0=mysql_query("select * from data_cust");
																		while($hasil0=mysql_fetch_array($query0)){
																	?>
																	<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
																	<?php
																		}
																	?>
																</select>
																			</div>
																			<div class="form-group">
																				<div class="row">
																				<div class="col-sm-4">
																				<label>QTY</label>
																					<input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(this.value)" type="text" placeholder="Isi Hanya Angka" class="form-control pf_qty pf_qty_0" name="qty" value="<?=$hasil['qty']?>" required>
																				</div>
																<div class="col-sm-4">
																	<label>TYPE 1</label>
																	<input class="form-control pf_qty_type1_0" list="type1" name="qty_type1" id="pilih"  value="<?=$hasil['qty_type1']?>" autofocus required>
																	<datalist id="type1">
																		<option value="">- PILIH -</option>
																		<option value="20FT" >20FT</option>
																		<option value="40FT">40FT</option>
																		<option value="45FT">45FT</option>
																		<option value="PACKAGE">PACKAGE</option>
																		<option value="PALLET" >PALLET</option>
																		<option value="CARTON">CARTON</option>
																		<option value="M3">M3</option>
																		<option value="MT">MT</option>
																		<option value="RT" >RT</option>
																		<option value="DOC" >DOC</option>
																		<option value=" ">...</option>
																	</datalist>
																	<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(0, this.value)" type="text" class="form-control pf_qty_desc1_0" name="party_pf1_desc" placeholder="isi jika opsi ... dipilih" autofocus></div>
																</div>
																<div class="col-sm-4">
																	<label>TYPE 2</label>
																	<input class="form-control pf_qty_type2_0" list="type2" name="qty_type2" id="pilih"  value="<?=$hasil['qty_type2']?>" autofocus required>
																	<datalist id="type2">
																		<option value="">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OT">OT</option>
																		<option value="FUSO BOX">FUSO BOX</option>
																		<option value="FUSO">FUSO</option>
																		<option value="CDD BOX">CDD BOX</option>
																		<option value="CDD" >CDD</option>
																		<option value="PICK UP BOX">PICK UP BOX</option>
																		<option value="PICK UP">PICK UP</option>
																		<option value="PICK UP 300 BOX">PICK UP 300 BOX</option>
																		<option value="PICK UP 300" >PICK UP 300</option>
																		<option value="WING BOX">WING BOX</option>
																		<option value="TRONTON BOX">TRONTON BOX</option>
																		<option value="TRONTON">TRONTON</option>
																		<option value="DUMP TRUCK" >DUMP TRUCK</option>
																		<option value=" ">...</option>
																	</datalist>
																	<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc2Value(0, this.value)" type="text" class="form-control pf_qty_desc2_0" name="party_pf2_desc" placeholder="isi jika opsi ... dipilih" autofocus></div>
																</div>
																				</div>
																			</div>
																			
																			
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit1" class="btn btn-success">Edit</button>
																		</div>
																		</form>
																	</div>
																</div>
															</div>
										<a class="btn btn-primary btn-sm" data-toggle="modal" href="#edit_detail_ops<?=$hasildetail['id_detail']?>">EDIT</a>	
									</div>
									<div class="mt-2">
										<a><label>TAMBAH FILE DAN IMAGE</label></a>
										<form class="mt-1" name="submit" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_images" method="POST" enctype="multipart/form-data">
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
												<input type="hidden" name="type_ops" value="<?=$type_ops?>">
												<input type="hidden" name="id_jurnal_ops" value="<?=$id_jurnal_ops?>">
												<input type="file" name="nm_file[]" multiple>
											</div>
											<button type="submit" name="bupload" class="btn btn-info">TAMBAH</button>
										</form>
									</div>
								</div>
								
							</div>
							<div class="row mt-2">
								<div class="col-md-12">
									<?php if ($type_ops=='TRANSPORTATION CHARGES' or $type_ops=='ALL IN RATE' or $type_ops=='') { ?>
									<h5><a><label>DETAIL KONTAINER</label></a></h5>
									<div class="table-responsive">
										<table id="myTable3" class="table table-bordered table-responsive table-hover">
											<thead>
												<tr class="info">
													<th>NO</th>
													<th>DATE</th>
													<th>NOMOR KONTAINER</th>
													<th>NOMOR SEAL</th>
													<th>NOPOL</th>
													<th>DRIVER </th>
													<th>CONTACT</th>
													<th>STAKEHOLDER</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$no=1;
													$querydetail=mysql_query("SELECT * from detail where id_jurnal_ops=$id_jurnal_ops");
													while ($hasildetail=mysql_fetch_array($querydetail)){
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasildetail['tgl_detail']?></td>
													<td><?=$hasildetail['no_kontainer']?></td>
													<td><?=$hasildetail['no_seal']?></td>
													<td><?=$hasildetail['nopol']?></td>
													<td><?=$hasildetail['nm_driver']?></td>
													<td><?=$hasildetail['hp_driver']?></td>
													<td><?=$hasildetail['stakeholder']?></td>
													<td>
														<!-- Modal -->
														<div class="modal fade" id="detail<?=$hasildetail['id_detail']?>" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h5>Edit Detail Kontainer</h5>
																	</div>
																	<form name="submit1" action="<?=$aksi?>" method="GET">
																	<div class="modal-body" >
																		<div class="form-group">
																			<label>DATE :</label>
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_detail">
																			<input type="hidden" name="id" value="<?=$hasildetail['id_detail']?>">
																			<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																			<input type="hidden" name="type_ops" value="<?=$type_ops?>">
																			<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																			<input type="hidden" name="id_pf_operasional" value="<?=$id_jurnal_ops?>">
																			<input type="text" class="form-control" name="tgl_detail" value="<?=$hasildetail['tgl_detail']?>" readonly>
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 1</lable>
																			<input type="text" name="no_kontainer" class="form-control" value="<?=$hasildetail['no_kontainer']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 2</lable>
																			<input type="text" name="no_seal" class="form-control" value="<?=$hasildetail['no_seal']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 3</lable>
																			<input type="text" name="nopol" class="form-control" value="<?=$hasildetail['nopol']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 4</lable>
																			<input type="text" name="nm_driver" class="form-control" value="<?=$hasildetail['nm_driver']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 5</lable>
																			<input type="text" name="hp_driver" class="form-control" value="<?=$hasildetail['hp_driver']?>">
																		</div>
																		<div class="form-group">
																			<label>STAKE HOLDER :</label>
																			<select class="form-control" name="stakeholder">
																				<option value="<?=$hasildetail['stakeholder']?>"><?=$hasildetail['stakeholder']?></option>
																				<?php
																					$queryven=mysql_query("select * from data_vendor");
																					while ($hasilven=mysql_fetch_array($queryven)){
																				?>
																				<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
																				<?php
																					}
																					$query0=mysql_query("select * from data_cust");
																					while($hasil0=mysql_fetch_array($query0)){
																				?>
																				<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
																				<?php
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>																		
																		<button type="submit1" class="btn btn-success">Update</button>	
																	</div>
																	</form>
																</div>
															</div>
														</div>
														<!-- Modal -->
														<div class="modal fade" id="view_image<?=$hasildetail['id_detail']?>" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h5>Edit All In Rate</h5>
																	</div>
																	<form name="submit1" action="<?=$aksi?>" method="GET">
																	<div class="modal-body" >
																		<div class="form-group">
																			<label>DATE :</label>
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_detail">
																			<input type="hidden" name="id" value="<?=$hasildetail['id_detail']?>">
																			<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																			<input type="hidden" name="type_ops" value="<?=$type_ops?>">
																			<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
																			<input type="hidden" name="id_pf_operasional" value="<?=$id_jurnal_ops?>">
																			<input type="text" class="form-control" name="tgl_detail" value="<?=$hasildetail['tgl_detail']?>" readonly>
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 1</lable>
																			<input type="text" name="no_kontainer" class="form-control" value="<?=$hasildetail['no_kontainer']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 2</lable>
																			<input type="text" name="no_seal" class="form-control" value="<?=$hasildetail['no_seal']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 3</lable>
																			<input type="text" name="nopol" class="form-control" value="<?=$hasildetail['nopol']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 4</lable>
																			<input type="text" name="nm_driver" class="form-control" value="<?=$hasildetail['nm_driver']?>">
																		</div>
																		<div class="form-group">
																			<lable>DETAIL 5</lable>
																			<input type="text" name="hp_driver" class="form-control" value="<?=$hasildetail['hp_driver']?>">
																		</div>
																		<div class="form-group">
																			<label>STAKE HOLDER :</label>
																			<select class="form-control" name="stakeholder">
																				<option value="<?=$hasildetail['stakeholder']?>"><?=$hasildetail['stakeholder']?></option>
																				<?php
																					$queryven=mysql_query("select * from data_vendor");
																					while ($hasilven=mysql_fetch_array($queryven)){
																				?>
																				<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
																				<?php
																					}
																					$query0=mysql_query("select * from data_cust");
																					while($hasil0=mysql_fetch_array($query0)){
																				?>
																				<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
																				<?php
																					}
																				?>
																			</select>
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="submit1" class="btn btn-success">Update</button>
																	</div>
																	</form>
																</div>
															</div>
														</div>
														<!--<a class="btn btn-info btn-sm" data-toggle="modal" href="#view_image<?=$hasildetail['id_detail']?>" ><span class="fa fa-info"></i></a>-->
														<a class="btn btn-primary btn-sm" data-toggle="modal" href="#detail<?=$hasildetail['id_detail']?>"><span class="fa fa-edit"></a>	
														<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=delete_detail&id=<?=$hasildetail['id_detail']?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&type_ops=<?=$type_ops?>"><span class="fa fa-trash"></a>
													</td>
												</tr>
												<?php $no++; } ?>
											</tbody>
											
										</table>
									</div>
									<?php
										}
									?>
									<a><label>FILE DAN GAMBAR</label></a>
									<form name="submit1" action="<?=$aksi?>" method="GET">
									<div class="row box-body">
										<input type="hidden" name="module" value="jurnal_operasional">
										<input type="hidden" name="act" value="hapus_gambar">
										<input type="hidden" name="id_pf" value="<?=$id_pf?>">
										<input type="hidden" name="type_ops" value="<?=$type_ops?>">
										<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
										<input type="hidden" name="id_pf_operasional" value="<?=$id_jurnal_ops?>">
										<?php
											$query=mysql_query("SELECT * from images_db where id_jurnal_ops=$id_jurnal_ops");
											while ($hasil=mysql_fetch_array($query)){
												$id_images_db=$hasil['id_images_db'];
											?>	
											<div class="kotak col-md-3 checkbox-wrapper">	
												<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	
												<!--<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/> -->
												<a href="images/data_op/<?=$hasil['nm_file']?>" target="_blank">
													<?=$hasil['nm_file']?>
												</a>
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar&id=<?=$id_images_db?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&gambar=<?=$hasil['nm_file']?>"><span class="fa fa-trash"></a> 
											</div>  
										<?php } ?>   
									</div>
									<div class="box-tools pull-right">
									<!--<button type="submit2" class="btn btn-danger"><i class="fa fa-trash"></i></button>
									<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar&id=<?=$id_images_db?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>&id_pf=<?=$id_pf?>&gambar<?=$hasil['nm_file']?>"><span class="fa fa-trash"></a>-->
									</div>
									</form>
									
								</div>
							</div>
						</div>
					</div>			
				</section>			
			</body>
			</html>
		<?php
		break;
		case 'edit_laporan_jurnal':
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$id_rev=$_GET['id_rev'];
			$ops_id=$_GET['ops_id'];
			?>
				<!DOCTYPE html>
				<html>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
						<li class="active">Edit Laporan Jurnal Operasional</li>
					</ol>
				</section>
			
				<!-- Main content -->
				<section class="content">
			
				<!-- SELECT2 EXAMPLE -->
					<?php
						$query = mysql_query("SELECT * FROM pf_log where id_pf_log=$id_pf_log order by log_pf desc");
						$hasil = mysql_fetch_array($query);
						$queryRev = mysql_query("SELECT * FROM pf_revenue where id_pf_revenue=$id_rev");
						$hasilRev = mysql_fetch_array($queryRev);
						$queryJurOps = mysql_query("SELECT * FROM jurnal_ops where id_jurnal_ops=$ops_id");
						$hasilJurOps = mysql_fetch_array($queryJurOps);
						$queryDetail = mysql_query("SELECT * FROM detail where id_jurnal_ops=$ops_id");
						$hasilDetail = mysql_fetch_array($queryDetail);
						$queryImage=mysql_query("SELECT * from images_db where id_jurnal_nops=$ops_id");
						$hasilImage = mysql_fetch_array($queryImage);
					?>	
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Edit Laporan Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<form name="jurnal_ops" action="<?=$aksi?>?module=jurnal_operasional&act=edit_laporan_jurnal"method="POST" enctype="multipart/form-data">	
										<!-- /.box-header -->
										<div class="box-body row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="hidden" name="id_pf" value="<?=$id_pf?>" >
													<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
													<div class="row">
														<div class="col-sm-4">
															<lable>DATE</lable>
															<input type="text" name="date_ops" class="form-control" value="<?=$hasilJurOps['date_ops']?>" readonly>
														</div>
														<div class="col-sm-4">
															<lable>TYPE</lable>
															<input type="text" name="type_ops" class="form-control" value="<?=$hasilJurOps['type_ops']?>" readonly>
														</div>
														<div class="col-sm-4">
															<lable>DESCRIPTION</lable>
															<input type="text" name="description" class="form-control" value="<?=$hasilJurOps['desc_ops']?>" readonly>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>QUANTITY</label>
													<div class="row">
														<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty" value="<?=$hasilJurOps['qty']?>" required></div>
														<div class="col-sm-4">
															<select class="form-control" name="qty_type1" value="<?=$hasilJurOps['qty_type1']?>" autofocus required>
																<option value="">- PILIH -</option>
																<option value="20FT" >20FT</option>
																<option value="40FT">40FT</option>
																<option value="45FT">45FT</option>
																<option value="PACKAGE">PACKAGE</option>
																<option value="PALLET" >PALLET</option>
																<option value="CARTON">CARTON</option>
																<option value="M3">M3</option>
																<option value="MT">MT</option>
																<option value="RT" >RT</option>
																<option value=" ">...</option>
															</select>
														</div>
														<div class="col-sm-4">
															<select class="form-control" name="qty_type2" value="<?=$hasilJurOps['qty_type2']?>" autofocus required>
																<option value="">- PILIH -</option>
																<option value="STD" >STD</option>
																<option value="HC">HC</option>
																<option value="RF">RF</option>
																<option value="FR">FR</option>
																<option value="OT">OT</option>
																<option value="FUSO BOX">FUSO BOX</option>
																<option value="FUSO">FUSO</option>
																<option value="CDD BOX">CDD BOX</option>
																<option value="CDD" >CDD</option>
																<option value="PICK UP BOX">PICK UP BOX</option>
																<option value="PICK UP">PICK UP</option>
																<option value="PICK UP 300 BOX">PICK UP 300 BOX</option>
																<option value="PICK UP 300" >PICK UP 300</option>
																<option value="WING BOX">WING BOX</option>
																<option value="TRONTON BOX">TRONTON BOX</option>
																<option value="TRONTON">TRONTON</option>
																<option value="DUMP TRUCK" >DUMP TRUCK</option>
																<option value=" ">...</option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>NO KONTAINER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_kontainer" class="form-control" value="<?=$hasilDetail['no_kontainer']?>">
												</div>
												<div class="form-group">
													<label>NO SEAL</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_seal" class="form-control" value="<?=$hasilDetail['no_seal']?>">
												</div>
												<div class="form-group">
													<label>NO POLISI</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_pol" class="form-control" value="<?=$hasilDetail['nopol']?>">
												</div>
												<div class="form-group">
													<label>NAMA DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_driver" class="form-control" value="<?=$hasilDetail['nm_driver']?>">
												</div>
												<div class="form-group">
													<label>CONTACT DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="contact" class="form-control" value="<?=$hasilDetail['hp_driver']?>">
												</div>
												<div class="form-group">
													<label>B/L Number</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_bl" class="form-control" value="<?=$hasil['bl_number']?>">
												</div>
												<div class="form-group">
													<label>Aju Number</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_aju" class="form-control" value="<?=$hasil['aju_number']?>">
												</div>
												<div class="form-group">
													<label>STAKE HOLDER :</label>
													<select class="form-control" name="stakeholder" value="<?=$hasilDetail['stakeholder']?>">
														<option value="-">- SELECT -</option>
														<?php
															$queryven=mysql_query("select * from data_vendor");
															while ($hasilven=mysql_fetch_array($queryven)){
														?>
														<option value="<?=$hasilven['nm_vendor']?>"><?=$hasilven['nm_vendor']?></option>
														<?php
															}
															$query0=mysql_query("select * from data_cust");
															while($hasil0=mysql_fetch_array($query0)){
														?>
														<option value="<?=$hasil0['nm_cust']?>"><?=$hasil0['nm_cust']?></option>
														<?php
															}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>UPLOAD FILE</label>
													<input type="file" name="nm_file" value="<?=$hasilImage['nm_file']?>">
												</div>
											</div>
										</div>
										<div class="box-footer">
											<button type="jurnal_ops" name="bupload" class="btn btn-primary">SUBMIT</a>	
										</div>
									</form>
								</div>
								<div class="col-md-6">
									<!----- PROFORMA INFORMATOIN ----->
									<label>INFORMATION PROFORMA</label>
									<div class="box box-content">
										<table class="table">
											<tr>
												<td>JOB ORDER NUMBER</td>
												<td>:</td>
												<td><?=$hasil['no_jo']?></td>
											</tr>
											<tr>
												<td>CUSTOMER NAME</td>
												<td>:</td>
												<td><?=$hasil['cust_name']?></td>
											</tr>
											<tr>
												<td>CUSTOMER REFF</td>
												<td>:</td>
												<td><?=$hasil['cust_ref']?></td>
											</tr>
											<tr>
												<td>ADDRESS</td>
												<td>:</td>
												<td><?=$hasil['address_pf']?></td>
											</tr>
											<tr>
												<td>PIC</td>
												<td>:</td>
												<td><?=$hasil['pic']?></td>
											</tr>
											<tr>
												<td>SHIPMENT</td>
												<td>:</td>
												<td><?=$hasil['shipment']?></td>
											</tr>
											<tr>
												<td>STATUS</td>
												<td>:</td>
												<td><?=$hasil['status_ops']?></td>
											</tr>
										</table>
									</div>
									<h5><a><strong>QUANTITY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>QTY</th>
										</tr>
										<?php
											$numQtyData=1;
											$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
											while ($hasilQty = mysql_fetch_array($query3)) { ?>
												<tr>
													<td><?=$numQtyData?></td>
													<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
												</tr>
											<?php
											$numQtyData++;
											}
										?>
									</table>
									<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>DATE</th>
											<th>QTY</th>
											<th>FROM/TO</th>
										</tr>
										<?php
											$numPudelData=1;
											$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
											while ($hasilPudel = mysql_fetch_array($query3)) { ?>
												<tr>
													<td><?=$numPudelData?></td>
													<td><?=$hasilPudel['pudel_date']?></td>
													<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
													<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
												</tr>
											<?php
											$numPudelData ++;
											}
										?>
									</table>
									<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>REQUEST</th>
										</tr>
										<?php
											$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
											?>
												<tr>
													<td><?=$no_sor?></td>
													<td><?=$hasil1['desc_sor']?></td>
												</tr>
											<?php 
											$no_sor++; 
											}
										?>
									</table>
									<h5><a><strong>REAL CUSTOMER</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>NAME</th>
										</tr>
										<?php
											$no_ru=1;
												$query1 = mysql_query("select * from real_user where id_pf_log=$id_pf_log");
												while ($hasil1=mysql_fetch_array($query1)){
													$id_real_user=$hasil1['id_real_user'];
											?>
											<tr>
												<td><?=$no_ru?></td>
												<td><?=$hasil1['name_real_user']?></td>
											</tr>
										<?php 
											$no_ru++;
											}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>
				
			<?php 
		break;

		case 'tambah_nonoperasional':?>
			<!DOCTYPE html>
			<html>
			<section class="content-header">
				<h1>Jurnal Operasional</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_operasional">Jurnal Operasional</a></li>
					<li class="active">Tambah Jurnal Non Operasional</li>
				</ol>
			</section>
			
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Tambah Jurnal Non Operasional</h3>
					</div>
					<form class="form-horizontal" name="submit" method="POST" action="<?= $aksi ?>?module=jurnal_operasional&act=tambah_jurnal_nops" enctype="multipart/form-data">

					<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-sm-2">
										<label>DATE</label>
										<input type="text" name="date_nops[]" class="form-control" value="<?=date('Y-m-d')?>" readonly>
									</div>
									<div class="col-md-2">
										<label>DESCRIPTION</label>
										<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_nops[]" required>
									</div>
									<div class="col-md-2">
										<label>KEGIATAN</label>
										<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="kegiatan[]" required>
									</div>
									<div class="col-md-2">
										<label>DETAIL</label>
										<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="detail[]" required>
									</div>
									<div class="col-md-2">
										<label>VALUE</label>
										<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="value_nops[]" required>
									</div>
									<div class="col-md-2">
										<label>FILE</label>
										<input type="file" name="nm_file0[]" multiple>
									</div>
								</div>

								<div id="jurnal-nops"></div>

								<script type="text/javascript">
									var jurnalNops = 1;
									function addMoreNops() {
										$("#jurnal-nops").append(`
											<div class="row mt-2 jurnal-nops-item-${jurnalNops}">
												<div class="col-sm-2">
													<label>DATE</label>
													<input type="text" name="date_nops[]" class="form-control" value="<?=date('Y-m-d')?>" readonly>
												</div>
												<div class="col-md-2">
													<label>DESCRIPTION</label>
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_nops[]" required>
												</div>
												<div class="col-md-2">
													<label>KEGIATAN</label>
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="kegiatan[]" required>
												</div>
												<div class="col-md-2">
													<label>DETAIL</label>
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="detail[]" required>
												</div>
												<div class="col-md-2">
													<label>VALUE</label>
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="value_nops[]" required>
												</div>
												<div class="col-md-2">
													<label>FILE</label>
													<input type="file" name="nm_file${jurnalNops}[]" multiple>
												</div>
											</div>
										`);
										jurnalNops++;
									}
									function deleteRowNops() {
										if (jurnalNops > 1) {
											$(`.jurnal-nops-item-${jurnalNops - 1}`).remove();
											jurnalNops--;
										}
									}
								</script>
								<div class="mt-2 btn-action float-clear" align="left">
									<input class="btn btn-info text-white btn-sm" type="button" name="add_item" value="+ JURNAL" onClick="addMoreNops();" />
									<input class="btn btn-danger text-white btn-sm" type="button" name="del_item" value="- JURNAL" onClick="deleteRowNops();" />
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary pull-right">Submit</a>	
					</div>
					</form>
				</div>
			</section>
			</html>
		<?php
		break;

		case 'detail_jurnal_nops': 
			$id_jurnal_nops = $_GET['id_jurnal_nops'];
			?>
			<?php
				$query = mysql_query("SELECT * FROM jurnal_non_ops where id_jurnal_nops=$id_jurnal_nops");
				$hasil = mysql_fetch_array($query);
			?>	
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Document</title>
			</head>
			<body>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
						<li class="active">Detail Jurnal Operasional</li>
					</ol>
				</section>
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Detail Jurnal Non Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						
						<div class="box-body">
							<div class="row">
								<div class="col-md-6">
									<div class="detail-operasional">
										<h5><a><label>DETAIL JURNAL NON OPERASIONAL</label></a></h5>
										<table class="table">
											<tr>
												<td>DATE</td>
												<td>:</td>
												<td><?=$hasil['date_nops']?></td>
											</tr>
											<tr>
												<td>DESCRIPTION</td>
												<td>:</td>
												<td><?=$hasil['desc_nops']?></td>
											</tr>
											<tr>
												<td>KEGIATAN</td>
												<td>:</td>
												<td><?=$hasil['kegiatan']?></td>
											</tr>
											<tr>
												<td>DETAIL</td>
												<td>:</td>
												<td><?=$hasil['detail']?></td>
											</tr>
											<tr>
												<td>VALUE</td>
												<td>:</td>
												<td><?=$hasil['value_nops']?></td>
											</tr>
										</table>
										<!-- Modal -->
														<div class="modal fade" id="nops_edit" role="dialog">
															<div class="modal-dialog">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h4 class="text-bold text-green">Edit Jurnal Non Operasional</h4>
																	</div>
																	<form name="submit" action="<?=$aksi?>" method="get">
																	<div class="modal-body" >
																		<div class="form-group">
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_nonops">
																			<input type="hidden" name="id" value="<?=$id_real_user?>">
																			<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																			<input type="hidden" name="id_jurnal_nops" value="<?=$id_jurnal_nops?>">

																			<label>DESCRIPTION  :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="description" class="form-control" value="<?=$hasil['desc_nops']?>">
																		</div>
																		<div class="form-group">
																			<label>KEGIATAN  :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan" class="form-control" value="<?=$hasil['kegiatan']?>">
																		</div>
																		<div class="form-group">
																			<label>DETAIL  :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="detail" class="form-control" value="<?=$hasil['detail']?>">
																		</div>
																		<div class="form-group">
																			<label>VALUE  :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="value_nops" class="form-control" value="<?=$hasil['value_nops']?>">
																		</div>																		
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																		<button type="submit" class="btn bg-green">Update</button>
																	</div>
																	</form>
																</div>
															</div>
														</div>
										<a class="btn btn-primary btn-sm" data-toggle="modal" href="#nops_edit">EDIT</a>	
									</div>
									<div class="mt-2">
										<a><label>TAMBAH FILE DAN IMAGE</label></a>
										<form class="mt-1" name="submit" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_imagesnon" method="POST" enctype="multipart/form-data">
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="modul" value="jurnal_operasional">
												<input type="hidden" name="act" value="tambah_imagesnon">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
												<input type="hidden" name="id_jurnal_nops" value="<?=$id_jurnal_nops?>">
												<input type="file" name="nm_file[]" multiple>
											</div>
											<button type="submit" name="bupload" class="btn btn-info">TAMBAH</button>
										</form>
									</div>
								</div>
								<div class="col-md-6">
									<a><label>FILE DAN GAMBAR</label></a>
									<div class="row box-body">
										<?php
											$query=mysql_query("SELECT * from images_db where id_jurnal_nops=$id_jurnal_nops");
											while ($hasil=mysql_fetch_array($query)){
												$id_images_db=$hasil['id_images_db'];
											?>	
											<div class="kotak col-md-4 checkbox-wrapper">	
												<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>													
												<?=$hasil['nm_file']?>
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambarnon&id=<?=$id_images_db?>&id_jurnal_nops=<?=$id_jurnal_nops?>&gambar=<?=$hasil['nm_file']?>"><span class="fa fa-trash"></a>  
											</div>  
										<?php } ?>   
									</div>									
								</div>
							</div>
						</div>
					</div>			
				</section>			
			</body>
			</html>
		<?php
		break;
	}
}
?>
