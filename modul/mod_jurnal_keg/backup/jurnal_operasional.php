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
				$tgl_aw= date('Y-m-01', strtotime($hari_ini));
				$tgl_ak= date('Y-m-t', strtotime($hari_ini));
				$newDate = date('Y-m-d', strtotime($tgl_aw. ' - 1 months'));

				$tgl_aw_str=date('01-M-Y',strtotime($newDate));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

			} else {
				$tgl_aw=$_POST['tgl_aw'];
				$tgl_ak=$_POST['tgl_ak'];

				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
			}
		?>
			<script>
			$(document).ready(function(){
				$('#myTable').dataTable();
				$('#myTable1').dataTable();
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
					<div class="box-header with-border">
						<h3 class="box-title">Tabel JurnalOperasional dari tgl <?=$tgl_aw_str?> s/d <?=$tgl_ak_str?></h3>
					</div>
					<div class="box" align="center">
					<div class="box-body">
						<form name="submit" action="?module=jurnal_operasional" method="POST">
							<div class="col-md-2">
								<input class="form-control" type="date" name="tgl_aw">
							</div>
							
							<div class="col-md-2">
								<h4>Sampai Dengan : </h4>
							</div>
							<div class="col-md-2">
								<input class="form-control" type="date" name="tgl_ak">
							</div>
							
							<div class="col-md-1">
								<input class="padding-top-2" type="submit" value="OK">
							</div>
						</form>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-6">
									<table id="myTable" class="table table-hover table-responsive">
										<thead>
											<tr class="info">
												<th>NO</th>
												<th>PROFORMA NUMBER</th>
												<th>JOB ORDER NUMBER</th>
												<th>CUSTOMER NAME</th>
												<th>STATUS</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no=1;
											$query=mysql_query("select * from pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by tgl_pf desc , no_pf desc");
											while($hasil=mysql_fetch_array($query)){
												if(!empty($hasil['aprove'])and $hasil['aprove']!='batal' ){
													$id_pf=$hasil['id_pf'];
											?>
											<tr>
												<td><?=$no?></td>
												<td><?=$hasil['no_pf']?></td>
												<td><b><?=$hasil['no_jo']?></b></td>
												<td><?=$hasil['cust_name']?></td>
												<td><?=$hasil['status_ops']?></td>
												<td>
													<a class="btn btn-info btn-sm" href="?module=jurnal_operasional&act=detail&id=<?=$id_pf?>" >DETAIL</i></a>
												</td>
											</tr>
											<?php $no++; } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(document).ready(function(){
							$('#myTable').dataTable();
						});
					</script>
				</div>
			</section>	
			
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel jurnal Operasional dari tgl <?=$tgl_aw_str?> s/d <?=$tgl_ak_str?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- /.col -->
							<div class="table-responsive">
								<div class="col-md-12">
									<table id="myTable1" class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>CUSTOMER NAME</th>
												<th>TYPE</th>
												<th>DESCRIPTION 1</th>
												<th>DESCRIPTION 2</th>
												<th>STAKE HOLDER</th>
												<th>ACTION</th>
												<th>IMAGES</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("select * from pf_operasional as pfo 
												join pf on pfo.id_pf = pf.id_pf
												where tgl_pf_operasional between '$tgl_aw' and '$tgl_ak'
												order by id_pf_operasional desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
												$id_pf_operasional=$hasil4['id_pf_operasional'];
												$id_pf2=$hasil4['id_pf'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_operasional']?></td>
												<td><?=$hasil4['no_jo']?></td>
												<td><?=$hasil4['cust_name']?></td>
												<td><?=$hasil4['desc1']?></td>
												<td><?=$hasil4['desc2']?></td>
												<td><?=$hasil4['desc3']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td>
													<!-- Modal -->
													<div class="modal fade" id="operasional<?=$id_pf_operasional?>" role="dialog">
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
																		<input type="hidden" name="act" value="update_pf_operasional">
																		<input type="hidden" name="id" value="<?=$id_pf_operasional?>">
																		<input type="text" class="form-control" name="tgl_pf_operasional" value="<?=$hasil4['tgl_pf_operasional']?>" readonly>
																	</div>
																	<div class="form-group">
																		<label>STATUS :</label>
																		<select class="form-control" name="status_pf_operasional" required>
																			<option value="<?=$hasil4['status_pf_operasional']?>"><?=$hasil4['status_pf_operasional']?></option>
																			<option value="SPPB">SPPB</option>
																			<option value="NPE">NPE</option>
																			<option value="SPJM">SPJM</option>
																			<option value="DELIVERED">DELIVERED</option> 
																		</select>
																	</div>
																	<div class="form-group">
																		<label>Type :</label>
																		<select class="form-control" name="desc1">
																			<option value="<?=$hasil4['desc1']?>"><?=$hasil4['desc1']?></option>
																			<option value="SHIPPING/FORWARDING CHARGES"> SHIPPING/FORWARDING CHARGES </option>
																			<option value="PORT CHARGES"> PORT CHARGES </option>
																			<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																			<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																			<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																			<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																		</select>
																	</div>
																	<div class="form-group">
																		<label>DESCRIPTION 1 :</label>
																		<input type="text" onkeyup="this.value = this.value.toUpperCase()" class="form-control" name="desc2" value="<?=$hasil4['desc2']?>" requaired>
																	</div>	
																	<div class="form-group">
																		<label>DESCRIPTION 2 :</label>
																		<textarea onkeyup="this.value = this.value.toUpperCase()" class="form-control" name="desc3" requaired><?=$hasil4['desc3']?></textarea>
																	</div>	
																	<div class="form-group">
																		<label>STAKE HOLDER :</label>
																		<select class="form-control" name="stakeholder">
																			<option value="<?=$hasil4['stakeholder']?>"><?=$hasil4['stakeholder']?></option>
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
													<a class="btn btn-primary btn-sm" data-toggle="modal" href="#operasional<?=$id_pf_operasional?>"><span class="fa fa-edit"></a>	
													<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=delete_pf_operasional&id=<?=$id_pf_operasional?>"><span class="fa fa-trash"></a>

												</td>
												<td>
													<a class="btn btn-primary" onclick="location.href='<?php echo '?module=jurnal_operasional&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
													<button type="button" class="btn btn-primary btn-sm" onclick="location.href='<?php echo '?module=jurnal_operasional&act=detail&id='.$id_pf2.'&id_pf_operasional='.$id_pf_operasional; ?>';" >DETAIL</i></button>
												</td>
											<?php $no_real_cost++; } ?>	
											</tr>
										</tbody>
									</table>		
													
								</div>
							</div>
						</div>
					</div>
				</div>
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
						$query = mysql_query("SELECT * FROM pf_log where id_pf=$id_pf order by log_pf desc");
						$hasil = mysql_fetch_array($query);
						$id_pf_log = $hasil['id_pf_log'];
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
								<div class="col-md-12">
									<a><label>INFORMATION PROFORMA</label></a>
									<div class="row">
										<div class="col-sm-12">
											<div class="box box-content">
												<div class="row">
													<div class="col-md-6">
														<!--- PROFORMA --->
														<div class="table-proforma">
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
																	<td><strong>NOMOR AJU</strong></td>
																	<td>:</td>
																	<td><strong><?=$hasil['aju_number']?></strong></td>
																</tr>
																<tr>
																	<td><strong>NOMOR BL</strong></td>
																	<td>:</td>
																	<td><strong><?=$hasil['bl_number']?></strong></td>
																</tr>
																<tr>
																	<td><strong>STATUS</strong></td>
																	<td>:</td>
																	<td><strong><?=$hasil['status_ops']?></strong></td>
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
																				<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="aju_number">
																			</div>
																			<div class="form-group">
																				<label>NOMOR BL</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="bl_number">
																			</div>
																			<div class="form-group">
																				<label>STATUS</label>
																				<select id="type-revenue-0" class="form-control" name="status_ops" required onchange="checkRevTypeValue(this.value, 0)">
																					<option value="APPROVED"> APPROVED </option>
																					<option value="SPPB / BE"> SPPB / BE </option>
																					<option value="DELIVERED"> DELIVERED </option>
																				</select>																			
																			</div>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit1" class="btn btn-success">Tambah</button>
																		</div>
																		</form>
																	</div>
																</div>
															</div>

															<a class="btn btn-primary text-white btn-sm" data-toggle="modal" href="#proforma">EDIT</a>
															<a class="btn btn-info text-white btn-sm" data-toggle="modal" href="#proforma">DETAIL</a>
														</div>
														<div class="table-order mt-2">
															<h5><a><strong>TABLE ORDER</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>TYPE</th>
																	<th>DESCRIPTION</th>
																	<th>ACTION</th>
																</tr>
															
																<?php
																$no_job=1;	
																$total_revenue=0;				
																$query2 = mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");
																while ($hasil2 = mysql_fetch_array($query2)) { 	
																	$id_pf_revenue=$hasil2['id_pf_revenue'];
																?>	
																<tr>					
																	<td><?=$no_job?></td>
																	<td><?=$hasil2['type_revenue']?></td>
																	<td><?=$hasil2['desc_revenue']?></td>
																	<td>
																		<a class="btn btn-primary btn-sm" href="?module=jurnal_operasional&act=jurnal&id=<?=$id_pf?>&id_pf_log=<?=$id_pf_log?>&id_rev=<?=$id_pf_revenue?>" >JURNAL</i></a>
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
																				<select class="form-control" name="desc_revenue" required>
																					<option value=""> - PILIH DESC REVENUE -</option>
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
																				</select>
																			</div>
																			<div class="form-group">
																				<label>DESCRIPTION 2</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_revenue2" placeholder="isi jika opsi ... dipilih">
																			</div>
																			<div class="form-group">
																				<div class="row">
																					<div class="col-sm-4">
																					<label>QUANTITY</label>
																						<select class="form-control" name="qty_id[]" autofocus required>
																							<option value="">- PILIH -</option>
																							<?php
																								$queryQty=mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																									while ($hasilQty=mysql_fetch_array($queryQty)){
																									?>
																										<option value="<?=$hasilQty['id_pf_qty']?>"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></option>
																									<?php
																								} 
																							?>
																							<?php
																								$queryPudel=mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																									while ($hasilPudel=mysql_fetch_array($queryPudel)){
																									?>
																										<option value="<?=$hasilPudel['id_pf_pudel']?>"><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?> - <?=$hasilPudel['pudel_from']?>/<?=$hasilPudel['pudel_to']?></option>
																									<?php
																								} 
																							?>
																						</select>
																					</div>
																					<div class="col-sm-4">
																						<label>RATE</label>
																						<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="rate[]" placeholder="(IDR) tanpa titik, koma" required>
																					</div>
																					<div class="col-sm-2">
																						<label>PPN</label>
																						<select class="form-control" name="ppn[]" autofocus required>
																							<option value="0">0%</option>
																							<option value="11" >11%</option>
																							<option value="1.1">1.1%</option>
																						</select>
																					</div>
																					<div class="col-sm-2">
																						<label>PPH</label>
																						<select class="form-control" name="pph[]" autofocus required>
																							<option value="0">0%</option>
																							<option value="2" >2%</option>
																						</select>
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
																							<div class="col-sm-4">
																							<label>QUANTITY</label>
																								<select class="form-control" name="qty_id[]" autofocus required>
																									<option value="">- PILIH -</option>
																									<?php
																										$queryQty=mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																											while ($hasilQty=mysql_fetch_array($queryQty)){
																											?>
																												<option value="<?=$hasilQty['id_pf_qty']?>"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></option>
																											<?php
																										} 
																									?>
																									<?php
																										$queryPudel=mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
																											while ($hasilPudel=mysql_fetch_array($queryPudel)){
																											?>
																												<option value="<?=$hasilPudel['id_pf_pudel']?>"><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?> - <?=$hasilPudel['pudel_from']?>/<?=$hasilPudel['pudel_to']?></option>
																											<?php
																										} 
																									?>
																								</select>
																							</div>
																							<div class="col-sm-4">
																								<label>RATE</label>
																								<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="rate[]" placeholder="(IDR) tanpa titik, koma" required>
																							</div>
																							<div class="col-sm-2">
																								<label>PPN</label>
																								<select class="form-control" name="ppn[]" autofocus required>
																									<option value="0">0%</option>
																									<option value="11" >11%</option>
																									<option value="1.1">1.1%</option>
																								</select>
																							</div>
																							<div class="col-sm-2">
																								<label>PPH</label>
																								<select class="form-control" name="pph[]" autofocus required>
																									<option value="0">0%</option>
																									<option value="2" >2%</option>
																								</select>
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
															<a class="btn btn-info text-white btn-sm" data-toggle="modal" href="#add_revenue">+ ORDER</a>
														</div>

														<div class="table-order mt-2">
															<h5><a><strong>TABLE JURNAL OPERASIONAL</strong></a></h5>
															<table class="table table-bordered table-hover table-responsive">
																<tr class="info">
																	<th>NO</th>
																	<th>TYPE</th>
																	<th>DESCRIPTION</th>
																	<th>PARTY</th>
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
																	<td><?=$hasilOps['type_ops']?></td>
																	<td><?=$hasilOps['desc_ops']?></td>
																	<td>4<?=$hasilOps['qty']?> X <?=$hasilOps['qty_type1']?> <?=$hasilOps['qty_type2']?></td>
																	<td>
																		<a class="btn btn-info btn-sm" href="?module=jurnal_operasional&act=detail_jurnal&id=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>" ><span class="fa fa-info"></i></a>
																		<a class="btn btn-primary btn-sm" href="?module=jurnal_operasional&act=jurnal&id=<?=$id_pf?>&id_log=<?=$id_pf_log?>&ops_id=<?=$id_jurnal_ops?>" ><span class="fa fa-edit"></i></a>
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
														<h5><a><strong>TABLE QUANTITY</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>QTY</th>
																<th>ACTION</th>
															</tr>
															<?php
																$numQtyData=1;
																$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
																while ($hasilQty = mysql_fetch_array($query3)) { ?>
																	<tr>
																		<td><?=$numQtyData?></td>
																		<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
																		<td>
																		<?php
																			if(empty($hasil['aprove'])){ ?>
																				<a class="btn btn-info btn-sm" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
																				<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		<?php } ?>
																		</td>
																	</tr>
																<?php
																$numQtyData++;
																}
															?>
														</table>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#add_revenue">+ QUANTITY</a>

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
																while ($hasilPudel = mysql_fetch_array($query3)) { ?>
																	<tr>
																		<td><?=$numPudelData?></td>
																		<td><?=$hasilPudel['pudel_date']?></td>
																		<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
																		<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
																		<td>
																			<a class="btn btn-info btn-sm" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
																			<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		</td>
																	</tr>
																<?php $numPudelData++;
																}
															?>
														</table>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#add_revenue">+ PICKUP DELIVERY</a>

														<!--- COST --->
														<h5><a><strong>TABLE EST COST</strong></a></h5>
														<table class="table table-bordered table-hover">
															<tr class="info">
																<th>NO</th>
																<th>TYPE</th>
																<th>DESCRIPTION</th>
																<th>QUANTITY</th>
																<th>RATE</th>
																<th>ACTION</th>
															</tr>
															<?php
																$numCostData=1;
																$queryCost = mysql_query("SELECT * from pf_est_cost where id_pf_log=$id_pf_log");
																while ($hasilCost = mysql_fetch_array($queryCost)) { 
																	$id_pf_est_cost=$hasilCost['id_pf_est_cost'];
																	?>
																	<tr>
																		<td><?=$numCostData?></td>
																		<td><?=$hasilCost['type_est_cost']?></td>
																		<td><?=$hasilCost['desc_est_cost']?></td>
																		<td>
																		<?php 
																			$queryQtyCost = mysql_query("SELECT qty, type1, type2 FROM pf_pudel_qty WHERE id_pf_est_cost=$id_pf_est_cost");
																			while ($hasilQtyCost = mysql_fetch_array($queryQtyCost)) { ?>
																				<?=$hasilQtyCost['qty']?> X <?=$hasilQtyCost['type1']?> <?=$hasilQtyCost['type2']?>
																				<br />
																			<?php } ?>
																		</td>
																		<td>
																		<?php 
																			$queryRateCost = mysql_query("SELECT rate, qty FROM pf_pudel_qty WHERE id_pf_est_cost=$id_pf_est_cost");
																			while ($hasilRateCost = mysql_fetch_array($queryRateCost)) { 
																				$total_est_cost=$total_est_cost+($hasilRateCost['rate']*$hasilRateCost['qty']); ?>
																				<?=number_format($hasilRateCost['rate']*$hasilRateCost['qty'])?>
																				<br />
																			<?php } ?>
																		</td>
																		<td>
																			<a class="btn btn-primary btn-sm" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
																			<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																		</td>
																	</tr>
																<?php $numCostData++;
																}
															?>
														</table>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#add_revenue">+ PICKUP DELIVERY</a>
														
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
																$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
																while ($hasil1=mysql_fetch_array($query1)){
																	$id_pf_sor=$hasil1['id_pf_sor'];
																?>
																	<tr>
																		<td><?=$no_sor?></td>
																		<td><?=$hasil1['desc_sor']?></td>
																		<td>
																		<?php
																			if(empty($hasil['aprove'])){ ?>
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
																							<div class="modal-body" >
																								<div class="form-group">
																									<input type="hidden" name="module" value="proforma">
																									<input type="hidden" name="act" value="update_sor">
																									<input type="hidden" name="id" value="<?=$id_pf_sor?>">
																									<input type="hidden" name="id_pf" value="<?=$id_pf?>">

																									<label>Description :</label>
																									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_sor" class="form-control" value="<?=$hasil1['desc_sor']?>">
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
																				<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_sor&id=<?= $id_pf_sor ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																				
																		<?php } ?>
																		</td>
																	</tr>
																<?php 
																$no_sor++; 
																}
															?>
														</table>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#add_revenue">+ SPECIAL ORDER</a>

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
																	$query1 = mysql_query("select * from real_user where id_pf=$id_pf");
																	while ($hasil1=mysql_fetch_array($query1)){
																		$id_real_user=$hasil1['id_real_user'];
																?>
																<tr>
																	<td><?=$no_ru?></td>
																	<td><?=$hasil1['name_real_user']?></td>
																	<td>
																	<?php
																		if(empty($hasil['aprove'])){ ?>
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
																								<input type="hidden" name="module" value="proforma">
																								<input type="hidden" name="act" value="update_ru">
																								<input type="hidden" name="id" value="<?=$id_real_user?>">
																								<input type="hidden" name="id_pf" value="<?=$id_pf?>">

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
																			<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
																	<?php } ?>
																	</td>
																</tr>
															<?php 
																$no_ru++;
																}
															?>
														</table>
														<a class="btn btn-info text-white btn-sm mb-2" data-toggle="modal" href="#add_revenue">+ REAL CUSTOMER</a>
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

		case 'jurnal':
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$id_rev=$_GET['id_rev'];
			?>
				<!DOCTYPE html>
				<html>
				<section class="content-header">
					<h1>Jurnal Operasional</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_operasional&act=detail&id=<?=$id_pf?>">Detail Proforma</a></li>
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
								<div class="col-md-6">
									<form name="jurnal_ops" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_jurnal_ops"method="POST" enctype="multipart/form-data">	
										<!-- /.box-header -->
										<div class="box-body row">
											<div class="col-sm-12">
												<div class="form-group">
													<input type="hidden" name="id_pf" value="<?=$id_pf?>" >
													<input type="hidden" name="id_pf_log" value="<?=$id_pf_log?>">
													<div class="row">
														<div class="col-sm-4">
															<lable>DATE</lable>
															<input type="text" name="date_ops" class="form-control" value="<?=date('Y-m-d')?>" readonly>
														</div>
														<div class="col-sm-4">
															<lable>TYPE</lable>
															<input type="text" name="type_ops" class="form-control" value="<?=$hasilRev['type_revenue']?>" readonly>
														</div>
														<div class="col-sm-4">
															<lable>DESCRIPTION</lable>
															<input type="text" name="description" class="form-control" value="<?=$hasilRev['desc_revenue']?>" readonly>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>QUANTITY</label>
													<div class="row">
														<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty" required></div>
														<div class="col-sm-4">
															<select class="form-control" name="qty_type1" autofocus required>
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
															<select class="form-control" name="qty_type2" autofocus required>
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
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_kontainer[]" class="form-control">
												</div>
												<div class="form-group">
													<label>NO SEAL</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_seal[]" class="form-control">
												</div>
												<div class="form-group">
													<label>NO POLISI</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="no_pol[]" class="form-control">
												</div>
												<div class="form-group">
													<label>NAMA DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="nm_driver[]" class="form-control">
												</div>
												<div class="form-group">
													<label>CONTACT DRIVER</label>
													<input oninput="this.value = this.value.toUpperCase()" type="text" name="contact[]" class="form-control">
												</div>
												<div class="form-group">
													<label>STAKE HOLDER :</label>
													<select class="form-control" name="stakeholder[]">
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
													<input type="file" name="nm_file">
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
												<td>REAL CUSTOMER</td>
												<td>:</td>
												<td>
													<?php
														$norc=1;
														$queryrc=mysql_query("select * from real_user where id_pf_log=$id_pf_log");
														while($hasilrc=mysql_fetch_array($queryrc)){
													?>
													<?=$norc?>. <?=$hasilrc['name_real_user']?><br>
													<?php $norc++; } ?>
												</td>
											</tr>
											<tr>
												<td>SHIPMENT</td>
												<td>:</td>
												<td><?=$hasil['shipment']?></td>
											</tr>
											<tr>
												<td>QUANTITY</td>
												<td>:</td>
												<td>
												<?php
													$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
													if (mysql_num_rows($query3)==0) { ?>
														<?=$hasil['qty_pf']?>
													<?php 	
													} else {
														while ($hasilQty = mysql_fetch_array($query3)) { ?>
															<p class="nopadding"><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></p>
														<?php
														}
													} 
												?>
												</td>
											</tr>
											<?php
												$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
												$num = 1;
												while ($hasilPudel = mysql_fetch_array($query3)) { ?>
											<tr>
												<td class="align-start">PICK UP DELIVERY #<?=$num ?></td>
												<td class="align-start">:</td>
												<td>
													<div class="row">
														<div class="col-sm-3">
															<p class="nopadding">DATE</p>
														</div>
														<div class="col-sm-6">
															<p class="nopadding">: <?=$hasilPudel['pudel_date']?></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-3">
															<p class="nopadding">QTY</p>
														</div>
														<div class="col-sm-6">
															<p class="nopadding">: <?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-3">
															<p class="nopadding">FROM</p>
														</div>
														<div class="col-sm-3">
															<p class="nopadding">: <?=$hasilPudel['pudel_from']?></p>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-3">
															<p class="nopadding">TO</p>
														</div>
														<div class="col-sm-3">
															<p class="nopadding">: <?=$hasilPudel['pudel_to']?></p>
														</div>
													</div>
												</td>
											</tr>
											<?php
												$num++;
											} ?>
											<tr>
												<td>SPECIAL REQUEST</td>
												<td>:</td>
												<td>
													<?php
														$no_sor=1;
														$querysor=mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
														while($hasilsor=mysql_fetch_array($querysor)){
													?>
													<?=$no_sor?>. <?=$hasilsor['desc_sor']?><br>
													<?php $no_sor++; } ?>
												</td>
											</tr>
											<tr>
												<td>STATUS</td>
												<td>:</td>
												<td><?=$hasil['status_ops']?></td>
											</tr>
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
		?>
			<?php
				$query = mysql_query("SELECT * FROM jurnal_ops where id_jurnal_ops=$id_jurnal_ops");
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
							<h3 class="box-title">Detail Jurnal Operasional</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-md-4">
								<a><label>DETAIL OPERASIONAL</label></a>
									<div class="box box-content">
										<table class="table">
											<tr>
												<td>TYPE</td>
												<td>:</td>
												<td><?=$hasil['type_ops']?></td>
											</tr>
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
										</table>
									</div>
									<a><label>FORM DETAIL KONTAINER</label></a>
									<div class="box box-content">
										<form name="submit" action="<?=$aksi?>" method="GET">	
											<div class="row">
												<div class="mt-1 col-sm-12">
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label>DATE</label>
																<input type="hidden" name="id_pf" value="<?=$_GET['id']?>" >
																<input type="hidden" name="module" value="jurnal_operasional" >
																<input type="hidden" name="act" value="tambah_detail" >
																<input type="hidden" name="id_pf_operasional" value="<?=$_GET['id_pf_operasional']?>">
																<input type="text" name="tgl_detail" class="form-control" value="<?=date('Y-m-d')?>" readonly>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>DETAIL 1</label>
																<input type="text" name="no_kontainer" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>DETAIL 2</label>
																<input type="text" name="no_seal" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>DETAIL 3</label>
																<input type="text" name="nopol" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>DETAIL 4</label>
																<input type="text" name="nm_driver" class="form-control">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>DETAIL 5</label>
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
													<input class="btn btn-primary" type="submit" value="SUBMIT"> 
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="col-md-8">
									<a><label>DETAIL KONTAINER</label></a>
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
																		<h5>Edit All In Rate</h5>
																	</div>
																	<form name="submit1" action="<?=$aksi?>" method="GET">
																	<div class="modal-body" >
																		<div class="form-group">
																			<label>DATE :</label>
																			<input type="hidden" name="module" value="jurnal_operasional">
																			<input type="hidden" name="act" value="update_detail">
																			<input type="hidden" name="id" value="<?=$hasildetail['id_detail']?>">
																			<input type="hidden" name="id_pf" value="<?=$hasildetail['id_pf_detail']?>">
																			<input type="hidden" name="id_pf_operasional" value="<?=$hasildetail['id_pf_operasional']?>">
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
														<a class="btn btn-primary btn-sm" data-toggle="modal" href="#detail<?=$hasildetail['id_detail']?>"><span class="fa fa-edit"></a>	
														<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=delete_detail&id=<?=$hasildetail['id_detail']?>&id_pf_operasional=<?=$hasildetail['id_pf_operasional']?>&id_pf=<?=$hasildetail['id_pf_detail']?>"><span class="fa fa-trash"></a>
													</td>
												</tr>
												<?php $no++; } ?>
											</tbody>
											
										</table>
									</div>
									<a><label>FILE DAN GAMBAR</label></a>
									<div class="row box-body">
									<?php
										$query=mysql_query("SELECT * from images_db where id_jurnal_ops=$id_jurnal_ops");
										while ($hasil=mysql_fetch_array($query)){
											$id_images_db=$hasil['id_images_db'];
										?>	
										<div class="kotak col-md-3 checkbox-wrapper">	
											<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	<?=$hasil['nm_file']?> 
											<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/>
										</div>  
									<?php } ?>   
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									
								</div>
							</div>
						</div>
					</div>			
				</section>			
			</body>
			</html>
		<?php
		break;

		case 'tambah_image':
			$id_pf_operasional=$_GET['id'];

			$query=mysql_query("select * from pf_operasional as pfo
			join pf on pfo.id_pf=pf.id_pf
			where id_pf_operasional=$id_pf_operasional");
			$hasil=mysql_fetch_array($query);
			$id_pf=$hasil['id_pf'];
			
		?>
			<section class="content-header">
				<h1>Jurnal Operasional</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_operasional">Jurnal operasional</a></li>
					<li><a href="oklogin.php?module=jurnal_operasional&act=jurnal&id=<?=$id_pf?>">Form Jurnal operasional</a></li>
					<li class="active">Form Tambah Images</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Galery Images</h3>
						<!-- Modal -->
						<div class="modal fade" id="operational<?=$id__est_cost?>" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content" style="color: black;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"></button>
											<h5>Tambah Images</h5>
										</div>
										<form name="submit" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_images" method="POST" enctype="multipart/form-data">
										<div class="modal-body" >
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="id_pf_operasional" value="<?=$id_pf_operasional?>">
											</div>																
											<div class="form-group">
												<label>DATE:</label>
												<input type="text" class="form-control" name="tgl_pf_operasional" value="<?=date('Y-m-d')?>" readonly>
											</div>
											<div class="form-group">
												<input type="file" name="nm_file">
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											<button type="submit" name="bupload" class="btn btn-success">Tambah</button>
										</div>
										</form>
									</div>
								</div>
							</div>
							<a class="btn btn-default btn-sm" data-toggle="modal" href="#operational<?=$id_pf_est_cost?>">+</a>
						
						</div>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">	
								<!-- form start -->
							<form name="submit2" action="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar" method="POST">	
								<div class="box-body">
									<h4>JOB ORDER NUMBER : <?=$hasil['no_jo']?></h4></p>
									<h4>JOB ORDER : <?=$hasil['desc1']?></h4></p>
									<h4>DESCRIPTION : <?=$hasil['desc2']?></h4>
										<style>
										.kotak {
											border: 4px solid #575D63;
											margin: 10px;
											padding: 5px;
											width: 250px;
										}
										.img{
											width: 250px;
										}
										</style>
									<?php
									$query=mysql_query("select * from images_db where id_pf=$id_pf  and id_pf_operasional=$id_pf_operasional");
									while ($hasil=mysql_fetch_array($query)){
										$id_images_db=$hasil['id_images_db'];
									?>	
									<div class="kotak col-md-3 checkbox-wrapper">	
										<input type="hidden" name="id_pf_operasional" value="<?=$hasil['id_pf_operasional']?>">
										<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/>
										<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	<?=$hasil['nm_file']?> 
									</div>  
								<?php } ?>   
								</div>	
								<div class="box-tools pull-right">
									<button type="submit2" class="btn btn-danger"><i class="fa fa-trash"></i></button>
								</div>
								<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
								<script type="text/javascript">
									$(function() {
									$('.check_all').click(function() {
										$('.chk_boxes1').prop('checked', this.checked);
									});
									});
								</script>
							</form>	
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php 
		break;
		
		case 'edit': ?>
			<section class="content-header">
				<h1>Jurnal_keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">jurnal_keu</a></li>
					<li class="active">Form Edit jurnal_keu</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Edit jurnal_keu</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- /.col -->
							<div class="table-responsive">
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?= $aksi ?>?module=jurnal_keu&act=update">
										<div class="box-body">
											<?php
           $query = mysql_query(
               "select * from pf_job join pf on pf_job.id_pf=pf.id_pf where pf_job.id_pf=$_GET[id]"
           );
           ($hasil = mysql_fetch_array($query)) or die(mysql_error());
           ?>
											<input type="hidden" name="id" value="<?= $_GET[id] ?>">
											<div class="row with-border">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">NOMOR PPL</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="no_jurnal_keu" placeholder="Input Nomor...." value="<?= $hasil[
                   'no_pf'
               ] ?>" readonly>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">DATE</label>
														<div class="col-sm-6">
															<input type="date" class="form-control" name="date"  value="<?= $hasil[
                   'tgl_pf'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPPER/CONSIGNEE</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="shipper" value="<?= $hasil[
                   'shipper'
               ] ?>"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ETH/ETD</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="eth" value="<?= $hasil[
                   'eth'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SALES</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="sales" value="<?= $hasil[
                   'sales'
               ] ?>"  autofocus required>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">ROUTE</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="route_pf" value="<?= $hasil[
                   'route_pf'
               ] ?>" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">QUANTITY</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="qty" value="<?= $hasil[
                   'qty'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPMENT</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="shipment" value="<?= $hasil[
                   'shipment'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="pudel_location" value="<?= $hasil[
                   'pudel_location'
               ] ?>" autofocus required >
														</div>
													</div>
												</div>
											</div>
											


												<!-- /.box-body -->
											<div class="box-footer">
												<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
											</div>
										</div>	
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php break;

		case 'detail': ?>
			<section class="content-header">
				<h1>Detail Kontainer</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">jurnal_operasional</a></li>
					<li class="active">Form Detail Kontainer </li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">

			<!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
				<form name="submit" action="<?=$aksi?>" method="GET">	
					<div class="box-header with-border">
						<h3 class="box-title">Form Detail Kontainer</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="col-sm-6">
						<div class="form-group">
							<lable>DATE</lable>
							<input type="hidden" name="id_pf" value="<?=$_GET['id']?>" >
							<input type="hidden" name="module" value="jurnal_operasional" >
							<input type="hidden" name="act" value="tambah_detail" >
							<input type="hidden" name="id_pf_operasional" value="<?=$_GET['id_pf_operasional']?>">
							<input type="text" name="tgl_detail" class="form-control" value="<?=date('Y-m-d')?>" readonly>
						</div>
						<div class="form-group">
							<lable>DETAIL 1</lable>
							<input type="text" name="no_kontainer" class="form-control">
						</div>
						<div class="form-group">
							<lable>DETAIL 2</lable>
							<input type="text" name="no_seal" class="form-control">
						</div>
						<div class="form-group">
							<lable>DETAIL 3</lable>
							<input type="text" name="nopol" class="form-control">
						</div>
						<div class="form-group">
							<lable>DETAIL 4</lable>
							<input type="text" name="nm_driver" class="form-control">
						</div>
						<div class="form-group">
							<lable>DETAIL 5</lable>
							<input type="text" name="hp_driver" class="form-control">
						</div>
						<div class="form-group">
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
						</div>
					</div>
					<div class="box-footer">
						<input type="submit" value="SUBMIT"> 
					</div>
				</form>
				</div>
			</section>

			<section class="content">
				<div class="box box-default">
					<div class="box-body">
						<div class="table-responsive">
							<table id="myTable3" class="table table-striped">
								<thead>
									<tr>
										<th>NO</th>
										<th>DATE</th>
										<th>DETAIL 1</th>
										<th>DETAIL 2</th>
										<th>DETAIL 3</th>
										<th>DETAIL 4</th>
										<th>DETAIL 5</th>
										<th>STAKEHODER</th>
										<th>ACTION</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$no=1;
										$querydetail=mysql_query("select * from detail 
										where id_pf_detail=$_GET[id] and id_pf_operasional=$_GET[id_pf_operasional] order by id_detail desc");
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
															<h5>Edit All In Rate</h5>
														</div>
														<form name="submit1" action="<?=$aksi?>" method="GET">
														<div class="modal-body" >
															<div class="form-group">
																<label>DATE :</label>
																<input type="hidden" name="module" value="jurnal_operasional">
																<input type="hidden" name="act" value="update_detail">
																<input type="hidden" name="id" value="<?=$hasildetail['id_detail']?>">
																<input type="hidden" name="id_pf" value="<?=$hasildetail['id_pf_detail']?>">
																<input type="hidden" name="id_pf_operasional" value="<?=$hasildetail['id_pf_operasional']?>">
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
											<a class="btn btn-primary btn-sm" data-toggle="modal" href="#detail<?=$hasildetail['id_detail']?>"><span class="fa fa-edit"></a>	
											<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_operasional&act=delete_detail&id=<?=$hasildetail['id_detail']?>&id_pf_operasional=<?=$hasildetail['id_pf_operasional']?>&id_pf=<?=$hasildetail['id_pf_detail']?>"><span class="fa fa-trash"></a>
										</td>
									</tr>
									<?php $no++; } ?>
								</tbody>
								
							</table>
						</div>
					</div>
					
				</div>
			</section>
		<?php break;

		case 'edit_job': ?>
			<section class="content-header">
				<h1>jurnal_keu</h1>
				<ol class="breadcrumb">
					<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="#">jurnal_keu</a></li>
					<li class="active">Form Edit Job</li>
				</ol>
			</section>
			
				<!-- Main content -->
				<section class="content">
			
				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Edit Job</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="table-responsive">
									<div class="col-md-12">	
										<!-- form start -->
										<form class="form-horizontal" method="POST" action="<?= $aksi ?>?module=jurnal_keu&act=update">
											<div class="box-body">
												<?php
            $query = mysql_query(
                "select * from pf_job join pf on pf_job.id_pf=pf.id_pf where pf_job.id_pf=$_GET[id]"
            );
            ($hasil = mysql_fetch_array($query)) or die(mysql_error());
            ?>
												<input type="hidden" name="id" value="<?= $_GET[id] ?>">
												<div class="row with-border">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label">NOMOR PPL</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="no_jurnal_keu" placeholder="Input Nomor...." value="<?= $hasil[
                    'no_pf'
                ] ?>" readonly>
															</div>
														</div>  
														<div class="form-group">
															<label class="col-sm-3 control-label">DATE</label>
															<div class="col-sm-6">
																<input type="date" class="form-control" name="date"  value="<?= $hasil[
                    'tgl_pf'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SHIPPER/CONSIGNEE</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="shipper" value="<?= $hasil[
                    'shipper'
                ] ?>"  autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">ETH/ETD</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="eth" value="<?= $hasil[
                    'eth'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SALES</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="sales" value="<?= $hasil[
                    'sales'
                ] ?>"  autofocus required>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label">ROUTE</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="route_pf" value="<?= $hasil[
                    'route_pf'
                ] ?>" autofocus required>
															</div>
														</div>  
														<div class="form-group">
															<label class="col-sm-3 control-label">QUANTITY</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="qty" value="<?= $hasil[
                    'qty'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SHIPMENT</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="shipment" value="<?= $hasil[
                    'shipment'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
															<div class="col-sm-6">
																<input type="text" class="form-control" name="pudel_location" value="<?= $hasil[
                    'pudel_location'
                ] ?>" autofocus required >
															</div>
														</div>
													</div>
												</div>
												
	
												<div class="row with-border">
													<label class="col-sm-1 control-label">NO :</label>
													<label class="col-sm-5 control-label">DESCRIPTION :</label>
													<label class="col-sm-2 control-label">REVENUE (IDR) :</label>
													<label class="col-sm-2 control-label">EST COST (IDR) :</label>
													<label class="col-sm-2 control-label">REAL COST (IDR) :</label>
												</div>	
	
												<?php
            $query = mysql_query("select * from pf_job where id_pf=$_GET[id]");
            while ($hasil = mysql_fetch_array($query)) { ?>
														<div class="product-item form-group">
															<div class="col-sm-1">
															<input type="text" class="form-control" name="no_job[]" value="<?= $hasil[
                   'no_pf_job'
               ] ?>">
															</div>
															<div class="col-sm-5">
																<input type="text" class="form-control" name="desc[]"value="<?= $hasil[
                    'desc_pf_job'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input type="text" class="form-control" name="revenue[]" value="<?= $hasil[
                    'revenue'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input type="text" class="form-control" name="cost[]"value="<?= $hasil[
                    'cost'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input type="checkbox" class="pull-left" name="item_index[]">
															</div>
														</div>
												<?php }
            ?>
												
														<div class="product-item form-group">
															<div class="col-sm-1">
															<input type="text" class="form-control" name="no_job[]" placeholder="No Job">
															</div>
															<div class="col-sm-5">
																<input type="text" class="form-control" name="desc[]" placeholder="Description">
															</div>
															<div class="col-sm-2">
																<input type="text" class="form-control" name="revenue[]" placeholder="Revenue tanpa titik, koma">
															</div>
															<div class="col-sm-2">
																<input type="text" class="form-control" name="cost[]" placeholder="cost tanpa titik, koma">
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
																	$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><input type='text' class='form-control' name='no_job[]' placeholder='No Job'></div><div class='col-sm-5'><input type='text' class='form-control'name='desc[]' placeholder='Description'></div><div class='col-sm-2'><input type='text' class='form-control' name='revenue[]' placeholder='Revenue tanpa titik, koma'></div><div class='col-sm-2'><input type='text' class='form-control' name='cost[]' placeholder='Cost tanpa titik,koma'></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
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
	
															<div class="btn-action float-clear" align="center">
																<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
																<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
																<span class="success"><?php if (isset($message)) {
                    echo $message;
                } ?></span>
															</div>
													<!-- /.box-body -->
												<div class="box-footer">
													<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
												</div>
											</div>	
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php break;}
}
?>
