<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_data_awal/aksi_data_vendor.php';
    switch ($_GET[act]) { // Tampil User
        default: ?>
				<section class="content-header">
					<h1>Data vendoromer</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>3. Data Awal</li>
						<li class="active">Data Vendor</li>
					</ol>
				</section>
				
				<!-- Main content -->
				<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel Vendor
							
							<!-- Modal -->
							<div class="modal fade" id="nm_vendor" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content" style="color: black;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"></button>
											<h5>Tambah Data Vendor</h5>
										</div>
										<form name="submit1" action="<?=$aksi?>" method="get">
										<div class="modal-body" >

											<div class="form-group">
												<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="module" value="data_vendor">
												<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="act" value="tambah_data_vendor">
											</div>																
											<div class="form-group">
												<label>VENDOR NAME :</label>
												<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="nm_vendor">
											</div>
											<div class="form-group">
												<label>ADDRESS :</label>
												<textarea class="form-control" name="alamat_vendor"></textarea>
											</div>
											<div class="form-group">
												<label>VENDOR REFF :</label>
												<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="reff_vendor">
											</div>
											<div class="form-group">
												<label>VENDOR CODE :</label>
												<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="code_vendor">
											</div>
											<div class="form-group">
												<label>PIC :</label>
												<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pic_vendor">
											</div>
											<div class="form-group">
												<label>PHONE :</label>
												<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="phone_vendor">
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
							
						</h3>
						<div class="box-tools pull-right">
							<a class="btn btn-default btn-sm" data-toggle="modal" href="#nm_vendor">+</a>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- /.col -->
							<div class="table-responsive">
								<div class="col-md-12">
									<table class="table table-striped" id="myTable">
										<thead>
											<tr>
												<th>NO</th>
												<th>VENDOR NAME</th>
												<th>ADDRESS</th>
												<th>VENDOR REFF</th>
												<th>VENDOR CODE</th>
												<th>PIC</th>
												<th>PHONE</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_vendor=1;
												$query4=mysql_query("select * from data_vendor");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
													$id_data_vendor=$hasil4['id_data_vendor'];	
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['nm_vendor']?></td>
												<td><?=$hasil4['alamat_vendor']?></td>
												<td><?=$hasil4['reff_vendor']?></td>
												<td><?=$hasil4['code_vendor']?></td>
												<td><?=$hasil4['pic_vendor']?></td>
												<td><?=$hasil4['phone_vendor']?></td>
												<td>
													<!-- Modal -->
												<div class="modal fade" id="data_vendor<?=$id_data_vendor?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edit Data Vendor</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																<div class="form-group">
																	<input type="hidden" name="module" value="data_vendor">
																	<input type="hidden" name="act" value="update_data_vendor">
																	<input type="hidden" name="id_data_vendor" value="<?=$id_data_vendor?>">
																	
																	<label>VENDOR NAME :</label>
																	<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="type_revenue" value="<?=$hasil2['type_revenue']?>" readonly >-->
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="nm_vendor" value="<?=$hasil4['nm_vendor']?>">
																</div>
																
																<div class="form-group">
																	<label>ADDRESS :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="alamat_vendor" value="<?=$hasil4['alamat_vendor']?>">																
																</div>
																<div class="form-group">
																	<label>VENDOR REFF :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="reff_vendor" value="<?=$hasil4['reff_vendor']?>">																
																</div>
																<div class="form-group">
																	<label>VENDOR CODE :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="code_vendor" value="<?=$hasil4['code_vendor']?>">																
																</div>
																<div class="form-group">
																	<label>PIC :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pic_vendor" value="<?=$hasil4['pic_vendor']?>">																
																</div>
																<div class="form-group">
																	<label>PHONE :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="phone_vendor" value="<?=$hasil4['phone_vendor']?>">																
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
												<a class="btn btn-primary btn-sm" data-toggle="modal" href="#data_vendor<?=$id_data_vendor?>"><span class="fa fa-edit"></a>	
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=data_vendor&act=delete_data_vendor&id_data_vendor=<?=$id_data_vendor?>"><span class="fa fa-trash"></a>
												</td>
												
											<?php $no_vendor++; } ?>	
											</tr>
										</tbody>
									</table>		
									<script>
									$(document).ready(function(){
										$('#myTable').dataTable();
									});
									</script>	
									
									<div class="footer">
										<button ></button>
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
		?>
		
			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
					<li class="active">Form Tambah Jurnal Keuangan</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Tambah jurnal Keuangan</h3>
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
									<!-- form start -->
									<?php
									$no = 1;
									$query = mysql_query("SELECT * FROM pf where id_pf=$id_pf order by tgl_pf desc , no_pf desc");
									while ($hasil = mysql_fetch_array($query)) { 
										$id_pf = $hasil['id_pf']; 
									?>	
									<!-- Main content -->
									<section class="content">
										<div class="box box-default" >
											<div class="bg-primary">
												<div class="box-body">
													
												<div class="col-md-5">
													<table style="width:100% ">
														<tr>
															<td>NUMBER</td>	
															<td>:</td>
															<td><?= $hasil['no_pf'] ?></td>		
														</tr>
														<tr>
															<td>DATE</td>	
															<td>:</td>
															<td><?= $hasil['tgl_pf'] ?></td>		
														</tr>
														<tr>
															<td>vendorOMER NAME</td>	
															<td>:</td>
															<td><?= $hasil['vendor_name'] ?></td>		
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
															<td>QUANTITY</td>	
															<td>:</td>
															<td><?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?></td>		
														</tr>
														<tr>
															<td>ROUTE</td>	
															<td>:</td>
															<td><?= $hasil['route_pf'] ?></td>		
														</tr>
														<tr>
															<td>PU/DEL DATE</td>	
															<td>:</td>
															<td><?= $hasil['pudel_date'] ?> </td>		
														</tr>
														<tr>
															<td>PU/DEL LOCAtION</td>	
															<td>:</td>
															<td><?= $hasil['pudel_location'] ?> </td>		
														</tr>
														<tr>
															<td>CREDIt TERM</td>	
															<td>:</td>
															<td><?= $hasil['ct'] ?> </td>		
														</tr>
														<tr>
															<td>SALES</td>	
															<td width=15>:</td>
															<td><?= $hasil['sales'] ?> </td>		
														</tr>
														<tr>
															<td style="vertical-align:top" width=35%>SPECIAL ORDER REQUES </td>
															<td style="vertical-align:top">:</td>
															<td style="vertical-align:top">
																<?php
																$no_sor=1;
																	$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
																	while ($hasil1=mysql_fetch_array($query1)){
																		$id_pf_sor=$hasil1['id_pf_sor'];
																?>
																	<?=$no_sor?>. <?=$hasil1['desc_sor']?></br>
																<?php $no_sor++; } ?>
															</td>
														</tr>
													</table>
												</div>	
												<div class="col-md-5">
													<table style="width:100%">
														<tr>
															<td>JOB ORDER NUMBER</td>	
															<td>:</td>
															<td><?= $hasil['no_jo'] ?></td>		
														</tr>												
														<tr>
															<td>VENDOR REFF</td>	
															<td>:</td>
															<td><?= $hasil['vendor_ref'] ?></td>		
														</tr>
														<tr>
															<td>VENDOR CODE</td>	
															<td>:</td>
															<td><?= $hasil['vendor_code'] ?></td>		
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
															<td>SHIPPING/FORWARDING</td>	
															<td>:</td>
															<td><?= $hasil['sf'] ?></td>		
														</tr>
														<tr>
															<td>VESSEL/VOYAGE</td>	
															<td>:</td>
															<td><?= $hasil['vv'] ?></td>		
														</tr>
														<tr>
															<td>ETB/ETD</td>	
															<td>:</td>
															<td><?= $hasil['etb_etd'] ?></td>		
														</tr>
														<?php
															if($hasil['shipment']!="EMKL IMPORT"){
														?>					
														<tr>
															<td>OPEN STACK</td>	
															<td>:</td>
															<td><?= $hasil['openstack'] ?> </td>		
														</tr>
														<tr>
															<td>CLOSING TIME CONTAINER</td>	
															<td>:</td>
															<td><?= $hasil['ctc'] ?> </td>		
														</tr>
														<tr>
															<td>CLOSING TIME DOCUMENT</td>	
															<td>:</td>
															<td><?= $hasil['ctd'] ?> </td>		
														</tr>
															<?php }else{ ?>
														<tr>
															<td>B/L NUMBER</td>	
															<td>:</td>
															<td><?= $hasil['bl_number'] ?> </td>		
														</tr>
															<?php } ?>
															<tr>
															<td style="vertical-align:top">REAL vendorOMER</td>
															<td style="vertical-align:top">:</td>
															<td style="vertical-align:top">
																<?php
																$no_ru=1;
																	$query1 = mysql_query("select * from real_user where id_pf=$id_pf");
																	while ($hasil1=mysql_fetch_array($query1)){
																		$id_real_user=$hasil1['id_real_user'];
																?>
																	<?=$no_ru?>. <?=$hasil1['name_real_user']?></br>
																<?php $no_ru++; } ?>
															</td>
														</tr>		
													</table>				
												</div>

												<div class="col-md-2">
													<table>
														<tr>
															<td align="center">
															</td>
														</tr>
														<tr>
															<td align="center">
																<?php
																	if($hasil['aprove']=="batal"){
																?>
																	<img src="images/aproved/batal.png" width="150" height="150">

																<?php } elseif ($hasil['aprove']==""){ ?>

																	<h2>PROFORMA</h2>
																<?php	
																}else{
																?>	
																	<img src="images/aproved/aproved.png" width="150" height="150">
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
													<div class="row">
														<div class="col-md-6">
															<?php
																$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf");
																$hasil_type1=mysql_fetch_array($type1);
																$type_revenue=$hasil_type1['type_revenue'];
															?>
															<bold><?=$type_revenue?> </bold> </p>
															<bold>TABLE REVENUE</bold>
															<table class="table table-striped">
																<tr>
																	<th>NO</th>
																	<th>TYPE</th>
																	<th>DESCRIPTION</th>
																	<th>REVENUE</th>
																	<th>QTY</th>
																	<th>SUM</th>
																</tr>
															
																<?php
																$no_job=1;	
																$sum_revenue=0;		
																$total_revenue=0;				
																$query2 = mysql_query("select * from pf_revenue where id_pf=$id_pf and type_revenue='$type_revenue' order by id_pf_revenue asc");
																while ($hasil2 = mysql_fetch_array($query2)) { 	
																	$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
																	$id_pf_revenue=$hasil2['id_pf_revenue'];
																?>	
																<tr>					
																	<td><?=$no_job?></td>
																	<td><?=$hasil2['type2_revenue']?></td>
																	<td><?=$hasil2['desc_revenue']?></td>
																	<td><?=number_format($hasil2['revenue'])?></td>
																	<td><?=$hasil2['qty_revenue']?></td>
																	<td><?=number_format($sum_revenue)?></td>
																</tr>

																<?php
																	$total_revenue=$total_revenue+$sum_revenue;
																	$no_job++; 
																}?>	
															</table>
														</div>	

														<div class="col-md-6">
															<bold>-</bold></p>
															<bold>TABLE EST COST</bold> 
															<table class="table table-striped">
																<tr>
																	<th>NO</th>
																	<th>TYPE</th>
																	<th>DESCRIPTION</th>
																	<th>EST COST</th>
																	<th>QTY</th>
																	<th>JML EST COST</th>
																	<th>JML REAL COST</th>
																	<th>ACTION</th>
																</tr>
																<?php
																$no_job2=1;	
																$sum_est_cost=0;
																$total_est_cost=0;						
																$query3 = mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost asc");
																while ($hasil3 = mysql_fetch_array($query3)) { 
																	$sum_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost']; 
																	$id_pf_est_cost=$hasil3['id_pf_est_cost'];
																?>
																<tr>				
																	<td><?=$no_job2?></td>
																	<td><?=$hasil3['type_est_cost']?></td>
																	<td><?=$hasil3['desc_est_cost']?></td>
																	<td><?=number_format($hasil3['est_cost'])?></td>
																	<td><?=$hasil3['qty_est_cost']?></td>
																	<td><?=number_format($sum_est_cost)?></td>
																	<td>
																		<?php
																			$query=mysql_query("select sum(real_cost) as sum_real_cost from pf_real_cost where id_est_cost=$id_pf_est_cost");
																			$hasil=mysql_fetch_array($query);
																			$sum_real_cost=$hasil['sum_real_cost'];
																		?>
																		<?=number_format($sum_real_cost)?>
																	</td>
																	<td>
																		<!-- Modal -->
																		<div class="modal fade" id="real_cost1<?=$id_pf_est_cost?>" role="dialog">
																			<div class="modal-dialog">
																				<!-- Modal content-->
																				<div class="modal-content" style="color: black;">
																					<div class="modal-header">
																						<button type="button" class="close" data-dismiss="modal"></button>
																						<h5>Tambah Tabel Real Cost</h5>
																					</div>
																					<form name="submit1" action="<?=$aksi?>" method="get">
																					<div class="modal-body" >
																						<div class="form-group">
																							<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="module" value="jurnal_keu">
																							<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="act" value="tambah_real_cost">
																							<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="id" value="<?=$id_pf_est_cost?>">
																							<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="id_pf" value="<?=$id_pf?>">
																						</div>																
																						<div class="form-group">
																							<label>DATE</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="tgl_real_cost" value="<?=date('Y-m-d')?>" readonly>
																						</div>
																						
																						<div class="form-group">
																							<label>CATEGORY 1</label>
																						<select class="form-control" name="category1">
																								<option value="">- SELECT -</option>
																								<option value="OP"> ORDER IN PROCCESS </option>
																								<option value="CASH"> CASH </option>
																								<option value="BANK"> BANK </option>
																								<option value="PIUTANG"> PIUTANG </option>
																								<option value="HUTANG"> HUTANG </option>
																								<option value="HUTANG"> PENDAPATAN </option>
																								<option value="HUTANG"> BIAYA </option>
																							</select>
																						</div>
																						<div class="form-group">
																							<label>CATEGORY 2</label>
																						<select class="form-control" name="category2">
																								<option value="">- SELECT -</option>
																								<option value="OP"> ORDER IN PROCCESS </option>
																								<option value="CASH"> CASH </option>
																								<option value="BANK"> BANK </option>
																								<option value="PIUTANG"> PIUTANG </option>
																								<option value="HUTANG"> HUTANG </option>
																								<option value="HUTANG"> PENDAPATAN </option>
																								<option value="HUTANG"> BIAYA </option>
																							</select>
																						</div>
																						<div class="form-group">
																							<label>STATUS</label>
																							<select class="form-control" name="status_rc">
																								<option value="">- SELECT -</option>
																								<option value="OP"> KELUAR </option>
																								<option value="CASH"> MASUK </option>
																							</select>
																						</div>
																						<div class="form-group">
																							<label>DESCRIPTION 1 :</label>
																							<select class="form-control" name="desc1">
																								<option value="<?=$hasil3['type_est_cost']?>"><?=$hasil3['type_est_cost']?></option>
																								<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																								<option value="PORT CHARGES"> PORT CHARGES </option>
																								<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																								<option value="vendorOMS AND OPERATION CHARGES"> vendorOMS AND OPERATION CHARGES </option>
																								<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																								<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																								<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																							</select>
																						</div>

																						<div class="form-group">
																							<label>DESCRIPTION 2 :</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc2" class="form-control" value="<?=$hasil3['desc_est_cost']?>" readonly>
																						</div>
																						<div class="form-group">
																							<label>DESCRIPTION 3 :</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc3" class="form-control" required>
																						</div>
																						<div class="form-group">
																							<label>DESCRIPTION 4 :</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc4" class="form-control" required>
																						</div>
																						<div class="form-group">
																							<label>STAKEHOLDER :</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="stakeholder" class="form-control" required>
																						</div>
																						<div class="form-group">
																							<label>NOMINAL :</label>
																							<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost" class="form-control" required>
           
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
																		<a class="btn btn-default btn-sm" data-toggle="modal" href="#real_cost1<?=$id_pf_est_cost?>">+</a>
																	</td>
																</tr>		

																<?php
																	$total_est_cost=$total_est_cost+$sum_est_cost ; 					
																	$no_job2++; 
																}?>	
															</table>	
														</div>	

													</div>
													<div class="row">
														<div class="col-md-6">
															<label>Profit and Lost Estimasi Cost</label>	
															<table class="table table-striped">
																<tr>
																	<th>No</th>
																	<th>Item</th>
																	<th>Total</th>
																</tr>
																<tr>
																	<td>1</td>
																	<td>Total Revenue</td>
																	<td><?=number_format($total_revenue)?></td>
																</tr>
																<tr>
																	<td>2</td>
																	<td>Total Estimasi Cost</td>
																	<td><?=number_format($total_est_cost)?></td>
																</tr>
																<tr>
																	<td></td>
																	<td>Profit and Lost Estimasi Cost</td>
																	<td><?=number_format($total_revenue-$total_est_cost)?></td>
																</tr>

															</table>
														</div>		
													</div>
												</div>
											</div>
										</div>
									</section>		
									<?php $no++;}?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel jurnal Keuangan</h3>
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
									<table class="table table-striped" id="myTable">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>CATEGORY D</th>
												<th>CATEGORY K</th>
												<th>SETATUS</th>
												<th>DESC 1</th>
												<th>DESC 2</th>
												<th>DESC 3</th>
												<th>DESC 4</th>
												<th>STAKEHOLDER</th>
												<th>COST</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("select * from pf_real_cost where id_pf=$id_pf order by tgl_pf_real_cost desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_real_cost']?></td>
												<td><?=$hasil4['category1']?></td>
												<td><?=$hasil4['category2']?></td>
												<td><?=$hasil4['status_rc']?></td>
												<td><?=$hasil4['desc1']?></td>
												<td><?=$hasil4['desc2']?></td>
												<td><?=$hasil4['desc3']?></td>
												<td><?=$hasil4['desc4']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td><?=number_format($hasil4['real_cost'])?></td>
											<?php $no_real_cost++; } ?>	
											</tr>
										</tbody>
									</table>		
									<script>
									$(document).ready(function(){
										$('#myTable').dataTable();
										$('#myTable2').dataTable();
										$('#myTable3').dataTable();
										$('#myTable4').dataTable();
										$('#myTable7').dataTable();
									});
									</script>					
								</div>
							</div>
						</div>
					</div>
				</div>		
			</section>
		<?php 
		break;
		case 'tambah': ?>
			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
					<li class="active">Form Tambah Jurnal Keuangan</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Tambah jurnal Keuangan</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- /.col -->
							<div class="table-responsive">
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" name="submit" method="POST" action="<?= $aksi ?>?module=jurnal_keu&act=input">
										<div class="box-body">

											<div class="row with-border">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">NOMOR PPL</label>
														<div class="col-sm-6">
															<?php
																$query=mysql_query("select * from pf order by id_pf desc limit 1");
																$hasil=mysql_fetch_array($query);
																$urut_pf=$hasil['no_pf'];
																$urut=substr("$urut_pf",7);
																$kemaren=date('ymd',strtotime("-1 day", strtotime(date("ymd"))));
																$harikemaren=substr($kemaren,2,2);
																$hariini=date('m');
																if ($harikemaren!=$hariini){
																	$urut=0;
																}
																$urut=$urut+1;
															?>
															<!--<?=$kemaren?></p>
															<?=$hariini?></p>
															<?=$harikemaren?>-->
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="no_pf" value="PPL<?php echo date('ym');?><?=$urut?>"readonly>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">DATE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="tgl_pf"  value="<?php echo date('Y-m-d'); ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">vendorOMER NAME</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="vendor_name"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ADDRESS</label>
														<div class="col-sm-6">
															<textarea  class="form-control" name="address_pf"  autofocus required></textarea>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPMENT</label>
														<div class="col-sm-6">
															<select class="form-control" name="shipment">
																<option value="">- PILIH -</option>
																<option value="EMKL EXPORT" >EMKL EXPORT</option>
																<option value="EMKL IMPORT">EMKL IMPORT</option>
																<option value="EMKL LOCAL">EMKL LOCAL</option>
															</select>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">QUANTITY</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty_pf"  autofocus required>
															
														</div>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="type_qty" placeholder="Type" autofocus required>
														</div>
													</div>
												
													<div class="form-group">
														<label class="col-sm-3 control-label">ROUTE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="route_pf" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">PU/DEL DATE</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pudel_date" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pudel_location" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CREDIT TERM</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="ct"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SALES</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sales"  autofocus required>
														</div>
													</div>
												</div>	
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-sm-3 control-label">vendorOMER REF</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="vendor_ref" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">vendorOMER CODE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="vendor_code" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PIC</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pic" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PHONE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="phone"  autofocus required>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPPING/FORWARDING</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sf" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">VESSEL/VOYAGE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="vv" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ETB/ETD</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="etb_etd" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">OPEN STACK</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="openstack"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CLOSING TIME CONTAINER</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="ctc" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CLOSING TIME DOCUMENT</label>
														<div class="col-sm-3">
															<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="ctd"  autofocus required>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-3 control-label">B/L NUMBER</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="bl_number" autofocus required >
														</div>
													</div>
												</div>
											</div>

											<div class="box">
												<div class="row with-border">
													<label>REAL USER :</label>
												</div>	

												<div class="product-item form-group">
													<div class="col-sm-4">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="name_real_user[]" placeholder="Name Real User">
													</div>
													<div class="col-sm-4">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="address_real_user[]" placeholder="Address">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="phone_real_user[]" placeholder="Phone">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
													</div>
												</div>
														
													<div id="product"></div>

													<script type="text/javascript">
														var idrow = 1;
														function addMore() {
															idrow++;
															$("#product").append("<div class='product-item form-group'><div class='col-sm-4'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='name_real_user[]' placeholder='Name Real User'></div><div class='col-sm-4'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='address_real_user[]' placeholder='Address'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='phone_real_user[]' placeholder='Phone'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='checkbox' class='pull-left' name='item_index[]'></div></div>");
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

													<div class="btn-action float-clear" align="left">
														<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
														<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
														<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
													</div>
											</div>	
											
											<div class="box">
												<div class="row with-border">
													<label>SPECIAL REQUEST ORDER :</label>
												</div>	

												<div class="product-item form-group">
													<div class="col-sm-5">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_sor[]" placeholder="Description">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
													</div>
												</div>
														
													<div id="product0"></div>

													<script type="text/javascript">
														var idrow = 1;
														function addMore0() {
															idrow++;
															$("#product0").append("<div class='product-item form-group'><div class='col-sm-5'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='desc_sor[]' placeholder='Description'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='checkbox' class='pull-left' name='item_index[]'></div></div>");
														}
														
														function deleteRow0() {
															$('DIV.product-item').each(function(index, item){
																jQuery(':checkbox', this).each(function () {
																	if ($(this).is(':checked')) {
																		$(item).remove();
																	}
																});
															});
														}
														
													</script>

													<div class="btn-action float-clear" align="left">
														<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore0();" />
														<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow0();" />
														<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
													</div>
											</div>	

											<div class="box">
											<div class="row with-border">
												<label>REVENUE :</label>
											</div>	

												<div class="product-item form-group">
													<div class="col-sm-2">
														<select class="form-control" name="type_revenue[]">
															<option value="ALL IN RATE"> ALL IN RATE </option>
															<option value="AS ORDER"> AS ORDER </option>
														</select>
													</div>
													<div class="col-sm-3">
														<select class="form-control" name="type2_revenue[]">
															<option value=""> - PILIH JIKA AS ORDER -</option>
															<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
															<option value="PORT CHARGES"> PORT CHARGES </option>
															<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
															<option value="vendorOMS AND OPERATION CHARGES"> vendorOMS AND OPERATION CHARGES </option>
															<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
															<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
															<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
														</select>
													</div>
													<div class="col-sm-3">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_revenue[]" placeholder="Description">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="revenue[]" placeholder="(IDR) tanpa titik, koma">
													</div>
													<div class="col-sm-1">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty_revenue[]" placeholder="qty tanpa titik, koma">
													</div>
													<div class="col-sm-1">
														<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
													</div>
												</div>
														
														<div id="product1"></div>
														<script type="text/javascript">
															var idrow = 1;
															function addMore1() {
																idrow++;
																$("#product1").append("<div class='product-item form-group'><div class='col-sm-2'><select class='form-control' name='type_revenue[]'><option value='ALL IN RATE'> ALL IN RATE </option><option value='AS ORDER'> AS ORDER </option></select></div><div class='col-sm-3'><select class='form-control' name='type2_revenue[]'><option value='SHIPPING/FORWARDING CHARGESRATE'> SHIPPING/FORWARDING CHARGES </option><option value='PORT CHARGES'> PORT CHARGES </option><option value='THIRD PARTY CHARGES'> THIRD PARTY CHARGES </option><option value='vendorOMS AND OPERATION CHARGES'> vendorOMS AND OPERATION CHARGES </option><option value='DEPO/CFS CHARGES'> DEPO/CFS CHARGES </option><option value='TRANSPORTATION CHARGES'> TRANSPORTATION CHARGES </option><option value='OTHERS CHARGES'> OTHERS CHARGES </option></select></div><div class='col-sm-3'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='desc_revenue[]' placeholder='Description'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='revenue[]' placeholder='(IDR) tanpa titik, koma'></div><div class='col-sm-1'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='qty_revenue[]' placeholder='qty tanpa titik, koma'></div><div class='col-sm-1'><input onkeyup="this.value = this.value.toUpperCase()" type='checkbox' class='pull-left' name='item_index[]'></div></div>");
													
															}
															
															function deleteRow1() {
																$('DIV.product-item').each(function(index, item){
																	jQuery(':checkbox', this).each(function () {
																		if ($(this).is(':checked')) {
																			$(item).remove();
																		}
																	});
																});
															}
															
														</script>

														<div class="btn-action float-clear" align="left">
															<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore1();" />
															<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow1();" />
															<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
														</div>
											</div>	
											<div class="box">			
											<div class="row with-border">
												<label>EST COST :</label>
											</div>	

												<div class="product-item form-group">
													<div class="col-sm-3">
														<select class="form-control" name="type_est_cost[]">
															<option value=""> - PILIH TYPE EST COST -</option>
															<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
															<option value="PORT CHARGES"> PORT CHARGES </option>
															<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
															<option value="vendorOMS AND OPERATION CHARGES"> vendorOMS AND OPERATION CHARGES </option>
															<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
															<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
															<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
														</select>
													</div>
													<div class="col-sm-3">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc_est_cost[]" placeholder="Description">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="est_cost[]" placeholder="(IDR) tanpa titik, koma">
													</div>
													<div class="col-sm-1">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty_est_cost[]" placeholder="qty tanpa titik, koma">
													</div>
													<div class="col-sm-1">
														<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
													</div>
												</div>
														
														<div id="product2"></div>
														<script type="text/javascript">
															var idrow = 1;
															function addMore2() {
																idrow++;
																$("#product2").append("<div class='product-item form-group'><div class='col-sm-3'><select class='form-control' name='type_est_cost[]'><option value='SHIPPING/FORWARDING CHARGESRATE'> SHIPPING/FORWARDING CHARGES </option><option value='PORT CHARGES'> PORT CHARGES </option><option value='THIRD PARTY CHARGES'> THIRD PARTY CHARGES </option><option value='vendorOMS AND OPERATION CHARGES'> vendorOMS AND OPERATION CHARGES </option><option value='DEPO/CFS CHARGES'> DEPO/CFS CHARGES </option><option value='TRANSPORTATION CHARGES'> TRANSPORTATION CHARGES </option><option value='OTHERS CHARGES'> OTHERS CHARGES </option></select></div><div class='col-sm-3'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='desc_est_cost[]' placeholder='Description'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='est_cost[]' placeholder='(IDR) tanpa titik, koma'></div><div class='col-sm-1'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='qty_est_cost[]' placeholder='qty tanpa titik, koma'></div><div class='col-sm-1'><input onkeyup="this.value = this.value.toUpperCase()" type='checkbox' class='pull-left' name='item_index[]'></div></div>");
															}
															
															function deleteRow2() {
																$('DIV.product-item').each(function(index, item){
																	jQuery(':checkbox', this).each(function () {
																		if ($(this).is(':checked')) {
																			$(item).remove();
																		}
																	});
																});
															}
															
														</script>

														<div class="btn-action float-clear" align="left">
															<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore2();" />
															<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow2();" />
															<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
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
											<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="id" value="<?= $_GET[id] ?>">
											<div class="row with-border">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">NOMOR PPL</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="no_jurnal_keu" placeholder="Input Nomor...." value="<?= $hasil[
                   'no_pf'
               ] ?>" readonly>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">DATE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="date"  value="<?= $hasil[
                   'tgl_pf'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPPER/CONSIGNEE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="shipper" value="<?= $hasil[
                   'shipper'
               ] ?>"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ETH/ETD</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="eth" value="<?= $hasil[
                   'eth'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SALES</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sales" value="<?= $hasil[
                   'sales'
               ] ?>"  autofocus required>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">ROUTE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="route_pf" value="<?= $hasil[
                   'route_pf'
               ] ?>" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">QUANTITY</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty" value="<?= $hasil[
                   'qty'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPMENT</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="shipment" value="<?= $hasil[
                   'shipment'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pudel_location" value="<?= $hasil[
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
												<input onkeyup="this.value = this.value.toUpperCase()" type="hidden" name="id" value="<?= $_GET[id] ?>">
												<div class="row with-border">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label">NOMOR PPL</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="no_jurnal_keu" placeholder="Input Nomor...." value="<?= $hasil[
                    'no_pf'
                ] ?>" readonly>
															</div>
														</div>  
														<div class="form-group">
															<label class="col-sm-3 control-label">DATE</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="date" class="form-control" name="date"  value="<?= $hasil[
                    'tgl_pf'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SHIPPER/CONSIGNEE</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="shipper" value="<?= $hasil[
                    'shipper'
                ] ?>"  autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">ETH/ETD</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="eth" value="<?= $hasil[
                    'eth'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SALES</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sales" value="<?= $hasil[
                    'sales'
                ] ?>"  autofocus required>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-sm-3 control-label">ROUTE</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="route_pf" value="<?= $hasil[
                    'route_pf'
                ] ?>" autofocus required>
															</div>
														</div>  
														<div class="form-group">
															<label class="col-sm-3 control-label">QUANTITY</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="qty" value="<?= $hasil[
                    'qty'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">SHIPMENT</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="shipment" value="<?= $hasil[
                    'shipment'
                ] ?>" autofocus required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
															<div class="col-sm-6">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pudel_location" value="<?= $hasil[
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
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="no_job[]" value="<?= $hasil[
                   'no_pf_job'
               ] ?>">
															</div>
															<div class="col-sm-5">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc[]"value="<?= $hasil[
                    'desc_pf_job'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="revenue[]" value="<?= $hasil[
                    'revenue'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="cost[]"value="<?= $hasil[
                    'cost'
                ] ?>">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
															</div>
														</div>
												<?php }
            ?>
												
														<div class="product-item form-group">
															<div class="col-sm-1">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="no_job[]" placeholder="No Job">
															</div>
															<div class="col-sm-5">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="desc[]" placeholder="Description">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="revenue[]" placeholder="Revenue tanpa titik, koma">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="cost[]" placeholder="cost tanpa titik, koma">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="checkbox" class="pull-left" name="item_index[]">
															</div>
														</div>
	
															<div id="product"></div>
															<script type="text/javascript">
																var idrow = 1;
																function addMore() {
																	idrow++;
																	$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='no_job[]' placeholder='No Job'></div><div class='col-sm-5'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control'name='desc[]' placeholder='Description'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='revenue[]' placeholder='Revenue tanpa titik, koma'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='text' class='form-control' name='cost[]' placeholder='Cost tanpa titik,koma'></div><div class='col-sm-2'><input onkeyup="this.value = this.value.toUpperCase()" type='checkbox' class='pull-left'name='item_index[]'></div></div>");
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
																<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
																<input onkeyup="this.value = this.value.toUpperCase()" class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
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
