<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_proforma/aksi_catatan.php';
    switch ($_GET[act]) { // Tampil User
        default: 
			// Menentukan tanggal awal bulan dan akhir bulan
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw_10 = date('Y-m-d h:i:s', strtotime('-1 month', strtotime($hari_ini)));
				$tgl_aw= date('Y-m-01', strtotime($hari_ini));
				$tgl_ak= date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str=date('01-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

			} else {
				$tgl_aw=$_POST['tgl_aw'];
				$tgl_ak=$_POST['tgl_ak'];
				$tgl_aw_select=date('Y-m-d',strtotime($tgl_aw));
				$tgl_ak_select=date('Y-m-d',strtotime($tgl_ak));
				
				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
			}
			$tgl1=date('Y-m-d',strtotime($tgl_aw));
			$tgl2=date('Y-m-d',strtotime($tgl_ak));
			$today=date('d-M-Y',strtotime($hari_ini)); 
		?>
			<script>
				$(document).ready(function(){
					$('#myTable').dataTable({
						order: [[1, 'desc']],
					});
				});
			</script>
			<section class="content-header">
				<h1>Catatan Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>1. MJO</li>
					<li class="active">Catatan Proforma</li>
				</ol>
			</section>
			
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel Catatan Perubahan Proforma dari tgl <?=$tgl_aw_str?> s/d <?=$tgl_ak_str?></h3>
					</div>
					<div class="box-body">
						<form name="submit" action="?module=catatan" method="POST">
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
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-8">
									<table id="myTable" class="table table-striped">
										<thead>
											<tr>
												<th>NUMBER</th>
												<th>DATE</th>
												<th>STATUS</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$query = mysql_query("SELECT * FROM pf where aprove != '0' and tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc, no_pf desc");
											while ($hasil = mysql_fetch_array($query)) { 
												$id_pf = $hasil['id_pf']; 
											?>
											<tr>
												<td><?= $hasil['no_pf'] ?></td>
												<td><?= $hasil['tgl_pf']?></td>
												<td>
													<?php if($hasil['aprove']=="batal"){ ?>
														<b>BATAL</b>
													<?php } elseif ($hasil['aprove']=="0"){ ?>
														<b>PROFORMA</b>
													<?php } else { ?>	
														<b>APPROVED</b>
													<?php } ?>
												</td>
												<td>
													<!-- Modal -->
													<div class="modal fade" id="pf<?=$id_pf?>" role="dialog">
														<div class="modal-dialog modal-lg" >
															<!-- Modal content-->
															<div class="modal-content" style="color: black;">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal"></button>
																	<h5>Edit Proforma</h5>
																</div>
																<form name="submit1" action="<?=$aksi?>" method="get">
																	<div class="modal-body">
																		<div class="col-sm-6">
																			<input type="hidden" name="module" value="catatan">
																			<input type="hidden" name="act" value="update_proforma">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<div>
																				<label class="head-label-margin">NUMBER :</label>
																				<input type="text" class="form-control w-full" name="no_pf" value="<?=$hasil['no_pf']?>" readonly >
																			</div>
																			<div>
																				<label class="head-label-margin">DATE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="tgl_pf" class="form-control w-full" value="<?=$hasil['tgl_pf']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">CUSTOMER NAME :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="cust_name" class="form-control w-full" value="<?=$hasil['cust_name']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">ADDRESS :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="address_pf" class="form-control w-full" value="<?=$hasil['address_pf']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">SHIPMENT :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="shipment" class="form-control w-full" value="<?=$hasil['shipment']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">QUANTITY :</label>
																				<?php
																					$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
																					if (mysql_num_rows($query3)==0) { ?>
																						<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_pf" class="form-control w-full" value="<?=$hasil['qty_pf']?>">
																						<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type_qty" class="form-control w-full" value="<?=$hasil['type_qty']?>">
																					<?php 	
																					} else {
																						$num = 1;
																						while ($hasilQty = mysql_fetch_array($query3)) { ?>
																						<div class="row">
																							<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_qty[]" class="form-control w-full" value="<?=$hasilQty['qty']?>"></div>
																							<div class="col-sm-1 mt-1"><label class="control-label nopadding">X</label></div>
																							<div class="col-sm-4 nopadding"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type0[]" class="form-control w-full" value="<?=$hasilQty['type1']?>"></div>
																							<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type1[]" class="form-control w-full" value="<?=$hasilQty['type2']?>"></div>
																							<input type="hidden" name="qty_pf" value="<?=$hasil['qty_pf']?>">
																							<input type="hidden" name="type_qty" value="<?=$hasil['type_qty']?>">
																						</div>
																						<?php
																						$num++;
																						}
																					} 
																				?>
																			</div>
																			<div>
																				<label class="head-label-margin">COMMODITY :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="commodity" class="form-control w-full" value="<?=$hasil['commodity']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">ROUTE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="route_pf" class="form-control w-full" value="<?=$hasil['route_pf']?>">
																			</div>
																			<?php
																				$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
																				if (mysql_num_rows($query3)==0) { ?>
																			<div>
																				<label class="head-label-margin">PU/DEL DATE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_date" class="form-control w-full" value="<?=$hasil['pudel_date']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">PU/DEL LOCATION :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_location" class="form-control w-full" value="<?=$hasil['pudel_location']?>">
																			</div>
																			<?php 	
																			} else {
																				$num = 1;
																				while ($hasilQty = mysql_fetch_array($query3)) { ?>
																			<div class="form-group">
																				<label class="head-label-margin">PU/DEL #<?=$num?></label>
																				<div class="row">
																					<div class="col-sm-12"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_date0[]" class="form-control w-full" value="<?=$hasilQty['pudel_date']?>"></div>
																					<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_qty[]" class="form-control w-full" value="<?=$hasilQty['qty']?>"></div>
																					<div class="col-sm-1 mt-1"><label class="control-label nopadding">X</label></div>
																					<div class="col-sm-4 nopadding"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type0[]" class="form-control w-full" value="<?=$hasilQty['type1']?>"></div>
																					<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type1[]" class="form-control w-full" value="<?=$hasilQty['type2']?>"></div>
																					<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_from[]" class="form-control w-full" value="<?=$hasilQty['pudel_from']?>"></div>
																					<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_to[]" class="form-control w-full" value="<?=$hasilQty['pudel_to']?>"></div>
																				</div>
																			</div>
																					<?php
																					$num++;
																					}
																				} 
																			?>
																			<div>
																				<label class="head-label-margin">CREDIT TERM :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ct" class="form-control w-full" value="<?=$hasil['ct']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">SALES :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="sales" class="form-control w-full" value="<?=$hasil['sales']?>">
																			</div>
																		</div>

																		<div class="col-sm-6">
																			<div>
																				<label class="head-label-margin">CUSTOMER REF :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control w-full" name="cust_ref" value="<?=$hasil['cust_ref']?>" >
																			</div>
																			<div>
																				<label class="head-label-margin">CUSTOMER CODE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="cust_code" class="form-control w-full" value="<?=$hasil['cust_code']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">PIC :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pic" class="form-control w-full" value="<?=$hasil['pic']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">PHONE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="phone" class="form-control w-full" value="<?=$hasil['phone']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">SHIPPING/FORWARDING :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="sf" class="form-control w-full" value="<?=$hasil['sf']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">VESEL/VOYAGE :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="vv" class="form-control w-full" value="<?=$hasil['vv']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">ETB / ETD :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="etb" class="form-control w-full" value="<?=$hasil['etb']?>">
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="etd" class="form-control w-full" value="<?=$hasil['etd']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">B/L NUMBER :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bl_number" class="form-control w-full" value="<?=$hasil['bl_number']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">AJU NUMBER :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="aju_number" class="form-control w-full" value="<?=$hasil['aju_number']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">OPEN STACK :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="openstack" class="form-control w-full" value="<?=$hasil['openstack']?>">
																			</div>
																			<div >
																				<label class="head-label-margin">CLOSING TIME CONTINER :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ctc" class="form-control w-full" value="<?=$hasil['ctc']?>">
																			</div>
																			<div>
																				<label class="head-label-margin">CLOSING TIME DOCUMENT :</label>
																				<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ctd" class="form-control w-full" value="<?=$hasil['ctd']?>">
																			</div>
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
													<a class="btn btn-primary btn-sm" data-toggle="modal" href="#pf<?=$id_pf?>"><span class="fa fa-edit"></a>	
													<a class="btn btn-default btn-sm" href="?module=catatan&act=show&id=<?= $id_pf ?>"><span class="fa fa-info"></a>
													<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
													<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
												</td>
											</tr>
										<?php $no++;}?>
										</tbody>
									</table>
								</div>
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
		<?php break;

		case 'show': ?>
			<section class="content-header">
				<h1>Catatan Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>1. MJO</li>
					<li class="active">Catatan Proforma</li>
				</ol>
			</section>
			<?php
				$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil = mysql_fetch_array($query)) or die(mysql_error());
				$id_pf = $hasil['id_pf']; 
			?>
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border"></div>			
					<div class="bg-primary">
						<div class="box-body">
							
						<div class="col-md-5">
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
									<td class="align-start">QUANTITY</td>	
									<td class="align-start">:</td>
									<td>
										<?php
											$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
											if (mysql_num_rows($query3)==0) { ?>
												<?= $hasil['qty_pf'] ?> <?=$hasil['type_qty']?>
											<?php 	
											} else {
												$num = 1;
												while ($hasilQty = mysql_fetch_array($query3)) { ?>
													<p class="nopadding"><?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
												<?php
												$num++;
												}
											} 
										?>
									</td>
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
								<?php
									$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
									if (mysql_num_rows($query3)==0) { ?>
								<tr>
									<td>PU/DEL DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
								</tr>
								<tr>
									<td>PU/DEL LOCATION</td>	
									<td>:</td>
									<td>
										<?= $hasil['pudel_location'] ?>
									</td>		
								</tr>
								<?php 	
								} else {
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
												<p class="nopadding">: <?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></p>
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
									}
								} ?>
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
									<td style="vertical-align:top" width=35%>SPECIAL ORDER REQUEST - 
										<!-- Modal -->
										<div class="modal fade" id="sor_plus<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h5>Tambah Special Order Request</h5>
													</div>
													<form name="submit" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="tambah_sor">
															<input type="hidden" name="id" value="<?=$id_pf?>">

															<label>Description :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_sor" class="form-control" value="<?=$hasil1['desc_sor']?>">
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-success">Tambah</button>
													</div>
													</form>
												</div>
											</div>
										</div>
										
										<a class="btn btn-default btn-sm" data-toggle="modal" href="#sor_plus<?=$id_pf?>">+</a>	
										
									</td>

									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
										?>
											<?=$no_sor?>. <?=$hasil1['desc_sor']?>

										
										
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
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="update_sor">
															<input type="hidden" name="id_pf_sor" value="<?=$id_pf_sor?>">
															<input type="hidden" name="id" value="<?=$id_pf?>">

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
										<a class="btn" data-toggle="modal" href="#sor<?=$id_pf_sor?>"><span class="fa fa-edit"></a>	
										<a class="btn" href="<?= $aksi ?>?module=catatan&act=delete_sor&id=<?=$id_pf?>&id_pf_sor=<?=$id_pf_sor?>" style="color: red;">X</a>
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
									<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
								</tr>
								<?php
									if($hasil['shipment']!="EMKL IMPORT"){
								?>					
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
									<?php }?> 
									<?php 
									if($hasil['shipment']!="EMKL IMPORT"){ ?>
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
									<?php } ?>
									<tr>
									<td style="vertical-align:top">REAL CUSTOMER - 
								
											<!-- Modal -->
											<div class="modal fade" id="ru_plus<?=$id_pf?>" role="dialog">
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
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="tambah_ru">
															<input type="hidden" name="id" value="<?=$id_pf?>">

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
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-success">Tambah</button>
													</div>
													</form>
												</div>
											</div>
										</div>
										<a class="btn btn-default" data-toggle="modal" href="#ru_plus<?=$id_pf?>">+</a>	
									
									</td>
									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_ru=1;
											$query1 = mysql_query("select * from real_user where id_pf=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_real_user=$hasil1['id_real_user'];
										?>
											<?=$no_ru?>. <?=$hasil1['name_real_user']?>
										
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
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="update_ru">
															<input type="hidden" name="id_real_user" value="<?=$id_real_user?>">
															<input type="hidden" name="id" value="<?=$id_pf?>">

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
										<a class="btn" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
										<a class="btn" href="<?= $aksi ?>?module=catatan&act=delete_ru&id=<?=$id_pf?>&id_real_user=<?= $id_real_user ?>" style="color: red;">X</a>
											
										
										</br>
										<?php $no_ru++; } ?>
									</td>
								</tr>		
							</table>				
						</div>

						<div class="col-md-2">
							<table>
								<tr>
									<td>
										
									<!-- Modal -->
									<div class="modal fade" id="pf<?=$id_pf?>" role="dialog">
										<div class="modal-dialog modal-lg" >
											<!-- Modal content-->
											<div class="modal-content" style="color: black;">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"></button>
													<h5>Edit Proforma</h5>
												</div>
												<form name="submit1" action="<?=$aksi?>" method="get">

												<div class="modal-body" >
													<div class="col-sm-6">

															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="update_proforma">
															<input type="hidden" name="id" value="<?=$id_pf?>">
														
														<div class="form-group">
															<label>NUMBER :</label>
															<input  type="text" class="form-control" name="no_pf" value="<?=$hasil['no_pf']?>" readonly >
														</div>
														<div class="form-group">
															<label>DATE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="tgl_pf" class="form-control" value="<?=$hasil['tgl_pf']?>">
														</div>
														<div class="form-group">
															<label>CUSTOMER NAME :</label>
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="cust_name" class="form-control" value="<?=$hasil['cust_name']?>">
														</div>
														<div class="form-group">
															<label>ADDRESS :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="address_pf" class="form-control" value="<?=$hasil['address_pf']?>">
														</div>
														<div class="form-group">
															<label>SHIPMENT :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="shipment" class="form-control" value="<?=$hasil['shipment']?>">
														</div>
														<div class="form-group">
															<label>QUANTITY :</label><br>
															<?php
																$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
																if (mysql_num_rows($query3)==0) { ?>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_pf" class="form-control" value="<?=$hasil['qty_pf']?>">
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type_qty" class="form-control" value="<?=$hasil['type_qty']?>">
																<?php 	
																} else {
																	$num = 1;
																	while ($hasilQty = mysql_fetch_array($query3)) { ?>
																	<div class="row">
																		<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_qty[]" class="form-control" value="<?=$hasilQty['qty']?>"></div>
																		<div class="col-sm-1 mt-1"><label class="control-label nopadding">X</label></div>
																		<div class="col-sm-4 nopadding"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type0[]" class="form-control" value="<?=$hasilQty['type1']?>"></div>
																		<div class="col-sm-4 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type1[]" class="form-control" value="<?=$hasilQty['type2']?>"></div>
																		<input type="hidden" name="qty_pf" value="<?=$hasil['qty_pf']?>">
																		<input type="hidden" name="type_qty" value="<?=$hasil['type_qty']?>">
																	</div>
																	<?php
																	$num++;
																	}
																} 
															?>
														</div>
														<div class="form-group">
															<label>COMMODITY :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="commodity" class="form-control" value="<?=$hasil['commodity']?>">
														</div>
														<div class="form-group">
															<label>ROUTE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="route_pf" class="form-control" value="<?=$hasil['route_pf']?>">
														</div>
														<?php
															$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
															if (mysql_num_rows($query3)==0) { ?>
														<div class="form-group">
															<label>PU/DEL DATE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_date" class="form-control" value="<?=$hasil['pudel_date']?>">
														</div>
														<div class="form-group">
															<label>PU/DEL LOCATION :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_location" class="form-control" value="<?=$hasil['pudel_location']?>">
														</div>
														<?php 	
														} else {
															$num = 1;
															while ($hasilQty = mysql_fetch_array($query3)) { ?>
														<div class="form-group">
															<label>PU/DEL #<?=$num?></label>
															<div class="row">
																<div class="col-sm-12"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_date0[]" class="form-control" value="<?=$hasilQty['pudel_date']?>"></div>
																<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_qty[]" class="form-control" value="<?=$hasilQty['qty']?>"></div>
																<div class="col-sm-1 mt-1"><label class="control-label nopadding">X</label></div>
																<div class="col-sm-4 nopadding"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type0[]" class="form-control" value="<?=$hasilQty['type1']?>"></div>
																<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_type1[]" class="form-control" value="<?=$hasilQty['type2']?>"></div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_from[]" class="form-control" value="<?=$hasilQty['pudel_from']?>"></div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pudel_to[]" class="form-control" value="<?=$hasilQty['pudel_to']?>"></div>
															</div>
														</div>
																<?php
																$num++;
																}
															} 
														?>
														<div class="form-group">
															<label>CREDIT TERM :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ct" class="form-control" value="<?=$hasil['ct']?>">
														</div>
														<div class="form-group">
															<label>SALES :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="sales" class="form-control" value="<?=$hasil['sales']?>">
														</div>
													</div>
										
													<div class="col-sm-6">
														<div class="form-group">
															<label>CUSTOMER REF :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="cust_ref" value="<?=$hasil['cust_ref']?>" >
														</div>
														<div class="form-group">
															<label>CUSTOMER CODE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="cust_code" class="form-control" value="<?=$hasil['cust_code']?>">
														</div>
														<div class="form-group">
															<label>PIC :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="pic" class="form-control" value="<?=$hasil['pic']?>">
														</div>
														<div class="form-group">
															<label>PHONE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="phone" class="form-control" value="<?=$hasil['phone']?>">
														</div>
														<div class="form-group">
															<label>SHIPPING/FORWARDING :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="sf" class="form-control" value="<?=$hasil['sf']?>">
														</div>
														<div class="form-group">
															<label>VESEL/VOYAGE :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="vv" class="form-control" value="<?=$hasil['vv']?>">
														</div>
														<div class="form-group">
															<label>ETB / ETD :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="etb" class="form-control" value="<?=$hasil['etb']?>">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="etd" class="form-control" value="<?=$hasil['etd']?>">
														</div>
														<div class="form-group">
															<label>B/L NUMBER :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bl_number" class="form-control" value="<?=$hasil['bl_number']?>">
														</div>
														<div class="form-group">
															<label>AJU NUMBER :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="aju_number" class="form-control" value="<?=$hasil['aju_number']?>">
														</div>
														<div class="form-group">
															<label>OPEN STACK :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="openstack" class="form-control" value="<?=$hasil['openstack']?>">
														</div>
														<div class="form-group">
															<label>CLOSING TIME CONTINER :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ctc" class="form-control" value="<?=$hasil['ctc']?>">
														</div>
														<div class="form-group">
															<label>CLOSING TIME DOCUMENT :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ctd" class="form-control" value="<?=$hasil['ctd']?>">
														</div>
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
									<a class="btn btn-primary btn-sm" data-toggle="modal" href="#pf<?=$id_pf?>"><span class="fa fa-edit"></a>  
									<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
									<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
										}elseif ($hasil['aprove']==47){
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
							<div class="row">
								<div class="col-md-6">
									
									<?php
										$type1=mysql_query("select * from pf_revenue where id_pf=$id_pf");
										$hasil_type1=mysql_fetch_array($type1);
										$type_revenue=$hasil_type1['type_revenue'];
									?>
									<bold><?=$type_revenue?> </bold> </p>
									<a>
										<bold>TABLE REVENUE</bold>

										<?php
										/*	if($_SESSION['id_users_level']=='23' || $_SESSION['id_users_level']=='1'){ */
										?>
										<!-- Modal -->
										<div class="modal fade" id="revenue<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h5>Tambah Tabel Revenue</h5>
													</div>
													<form name="submit1" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="tambah_revenue">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															
															<label>Type Revenue :</label>
															<select class="form-control" name="type_revenue">
																<option value="ALL IN RATE">ALL IN RATE</option>
																<option value="AS ORDER">AS ORDER</option>
															</select>
														</div>
														<div class="form-group">
															
														</div>
														<div class="form-group">
														<label>Category :</label>
															<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type2_revenue" class="form-control" value="<?=$hasil2['type2_revenue']?>">-->
															
															<select class="form-control" name="type2_revenue">
																<option value=""> - DIPILIH JIKA AS ORDER -</option>
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
															<label>Description :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_revenue" class="form-control">
														</div>
														<div class="form-group">
															<label>Revenue :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="revenue" class="form-control">
														</div>
														<div class="form-group">
															<label>QUANTITY :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control">
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
										<a class="btn btn-default btn-sm" data-toggle="modal" href="#revenue<?=$id_pf?>">+</a>	
											<?php /* } */ ?>
									</a>

									<table class="table table-striped">
										<tr>
										<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>FROM/TO</th>
											<th>QTY</th>
											<th>PPN</th>
											<th>PPH</th>
											<th>REVENUE</th>
											<th>SUM</th>
											<th>ACT</th>
										</tr>
									
										<?php
										$no_job=1;	
										$sum_revenue=0;		
										$total_revenue=0;				
										$query2 = mysql_query("select * from pf_revenue where id_pf=$id_pf order by id_pf_revenue asc");
										while ($hasil2 = mysql_fetch_array($query2)) { 	
											$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
											$id_pf_revenue=$hasil2['id_pf_revenue'];
										?>	
										<tr>					
											<td><?=$no_job?></td>
											<td><?=$hasil2['type2_revenue']?></td>
											<td><?=$hasil2['desc_revenue']?></td>
											<td><?=$hasil2['from_revenue']?>/<?=$hasil2['to_revenue']?></td>
											<td><?=$hasil2['qty_revenue']?>X<?=$hasil2['qty_type1_rev']?><?=$hasil2['qty_type2_rev']?></td>
											<td><?=$hasil2['ppn_revenue']?>%</td>
											<td><?=$hasil2['pph_revenue']?>%</td>
											<td><?=number_format($hasil2['revenue'])?></td>
											<td><?=number_format($sum_revenue)?></td>
											<td>
												<?php
												/*	if($_SESSION['id_users_level']=='23' || $_SESSION['id_users_level']=='1'){ */
												?>
												<!--<a class="btn btn-primary btn-sm" href="?module=aproval&act=edit&id=<?= $hasil['id_pf']?>"><span class="fa fa-edit"></a>-->
												<!-- Modal -->
												<div class="modal fade" id="revenue1<?=$id_pf_revenue?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edit All In Rate</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																<div class="form-group">
																	<input type="hidden" name="module" value="catatan">
																	<input type="hidden" name="act" value="update_revenue">
																	<input type="hidden" name="id_pf_revenue" value="<?=$id_pf_revenue?>">
																	<input type="hidden" name="id" value="<?=$id_pf?>">

																	<label>Type Revenue :</label>
																	<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="type_revenue" value="<?=$hasil2['type_revenue']?>" readonly >-->
																	<select class="form-control" name="type_revenue">
																		<option value="<?=$hasil2['type_revenue']?>"><?=$hasil2['type_revenue']?></option>
																		<option value="ALL IN RATE">ALL IN RATE</option>
																		<option value="AS ORDER">AS ORDER</option>
																	</select>
																</div>
																
																<div class="form-group">
																<label>Category :</label>
																	<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type2_revenue" class="form-control" value="<?=$hasil2['type2_revenue']?>">-->
																	
																	<select class="form-control" name="type2_revenue">
																		<option value="<?=$hasil2['type2_revenue']?>"><?=$hasil2['type2_revenue']?></option>
																		<option value="">- PILIH JIKA ALL IN RATE - </option>
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
																	<label>Description :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_revenue" class="form-control" value="<?=$hasil2['desc_revenue']?>">
																</div>
																<div class="form-group">
																	<label>Revenue :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="revenue" class="form-control" value="<?=$hasil2['revenue']?>">
																</div>
																<div class="form-group">
																	<label>QUANTITY :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control" value="<?=$hasil2['qty_revenue']?>">
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
												<a class="btn btn-primary btn-sm" data-toggle="modal" href="#revenue1<?=$id_pf_revenue?>"><span class="fa fa-edit"></a>	
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=catatan&act=delete_revenue&id=<?=$id_pf?>&id_pf_revenue=<?=$id_pf_revenue?>"><span class="fa fa-trash"></a>
													<?php /*} */?>
											</td>
										</tr>

										<?php
											$total_revenue=$total_revenue+$sum_revenue;
											$no_job++; 
										}?>	
									</table>
								</div>	

								<div class="col-md-6">
									<bold>-</bold></p>
									<a>
										<bold>TABLE EST COST</bold> 
										<?php
										/*	if($_SESSION['id_users_level']=='23' || $_SESSION['id_users_level']=='1'){ */
										?>
										<!-- Modal -->
										<div class="modal fade" id="est_cost1<?=$id_pf?>" role="dialog">
											<div class="modal-dialog">
												<!-- Modal content-->
												<div class="modal-content" style="color: black;">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal"></button>
														<h5>Tambah Tabel Estimasi Cost</h5>
													</div>
													<form name="submit1" action="<?=$aksi?>" method="get">
													<div class="modal-body" >
														<div class="form-group">
															<input type="hidden" name="module" value="catatan">
															<input type="hidden" name="act" value="tambah_est_cost">
															<input type="hidden" name="id" value="<?=$id_pf?>">
														</div>
														<div class="form-group">
															
														</div>
														<div class="form-group">
														<label>Category :</label>
															<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type2_revenue" class="form-control" value="<?=$hasil2['type2_revenue']?>">-->
															
															<select class="form-control" name="type_est_cost">
																<option value=""> - PILIH CATEGORY - </option>
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
															<label>Description :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_est_cost" class="form-control">
														</div>
														<div class="form-group">
															<label>Revenue :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="est_cost" class="form-control">
														</div>
														<div class="form-group">
															<label>QUANTITY :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_est_cost" class="form-control">
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
										<a class="btn btn-default btn-sm" data-toggle="modal" href="#est_cost1<?=$id_pf?>">+</a>
											<?php /* } */ ?>
									</a>
									
									<table class="table table-striped table-responsive">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>FROM/TO</th>
											<th>QTY</th>
											<th>PPH</th>
											<th>PPN</th>
											<th>EST COST</th>
											<th>SUM</th>
											<th>ACT</th>
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
											<td><?=$hasil3['from_est_cost']?>/<?=$hasil3['to_est_cost']?></td>
											<td><?=$hasil3['qty_est_cost']?>X<?=$hasil3['qty_type1_est_cost']?><?=$hasil3['qty_type2_est_cost']?></td>
											<td><?=$hasil3['ppn_est_cost']?>%</td>
											<td><?=$hasil3['pph_est_cost']?>%</td>
											<td><?=number_format($hasil3['est_cost'])?></td>
											<td><?=number_format($sum_est_cost)?></td>
											<td>
												<?php 
												/*	if($_SESSION['id_users_level']=='23' || $_SESSION['id_users_level']=='1'){ */
												?>
												<!-- Modal -->
												<div class="modal fade" id="est_cost_edit<?=$id_pf_est_cost?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edit Est Cost</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																<div class="form-group">
																	<input type="hidden" name="module" value="catatan">
																	<input type="hidden" name="act" value="update_est_cost">
																	<input type="hidden" name="id_pf_est_cost" value="<?=$id_pf_est_cost?>">
																	<input type="hidden" name="id" value="<?=$id_pf?>">

																	<!--<label>Type  :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="type_revenue" value="<?=$hasil3['type_revenue']?>" readonly >-->
																</div>
																<div class="form-group">
																<label>Category :</label>
																	<!--<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="type_revenue" class="form-control" value="<?=$hasil3['type_revenue']?>">-->
																	
																	<select class="form-control" name="type_est_cost">
																		<option value="<?=$hasil3['type_est_cost']?>"><?=$hasil3['type_est_cost']?></option>
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
																	<label>Description :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_est_cost" class="form-control" value="<?=$hasil3['desc_est_cost']?>">
																</div>
																<div class="form-group">
																	<a><label>EST COST :</label></a>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="est_cost" class="form-control" value="<?=$hasil3['est_cost']?>">
																</div>
																<div class="form-group">
																	<label>QUANTITY :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_est_cost" class="form-control" value="<?=$hasil3['qty_est_cost']?>">
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
												<a class="btn btn-primary btn-sm" data-toggle="modal" href="#est_cost_edit<?=$id_pf_est_cost?>"><span class="fa fa-edit"></a>
												<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=catatan&act=delete_est_cost&id=<?=$id_pf?>&id_pf_est_cost=<?=$id_pf_est_cost?>"><span class="fa fa-trash"></a>
													<?php /*} */?> 
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
									<label>PROFIT AND LOST</label>	
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
									<label>CATATAN PERUBAHAN</label>	
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>DATE</th>
											<th>ACTION</th>
										</tr>
										<?php
											$query3 = mysql_query("SELECT * from pf_log where id_pf=$id_pf");
											while ($hasilQty = mysql_fetch_array($query3)) { ?>
												<input type="hidden" name="type_qty" value="<?=$hasil['type_qty']?>">
												<tr>
													<td>
													<?php
														if($hasilQty['log_pf'] == 0) { ?>
															APPROVED
														<?php 
														} else { ?>
															<?=$hasilQty['log_pf']?>
														<?php }
													?>
													</td>
													<td><?=$hasilQty['tgl_pf']?></td>
													<td>
														<a class="btn btn-default btn-sm" href="?module=catatan&act=show_log&id=<?= $hasilQty['id_pf_log'] ?>"><span class="fa fa-info"></a>
														<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
														<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=print_log&id_log=<?= $hasilQty['id_pf_log'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php
											}
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php break;
		
		case 'show_log': ?>
			<?php
				$query = mysql_query("SELECT * FROM pf_log where id_pf_log=$_GET[id]");
				($hasil = mysql_fetch_array($query)) or die(mysql_error());
				$id_pf_log = $hasil['id_pf_log']; 
			?>
			<section class="content-header">
				<h1>Catatan Proforma
					<?php
						if ($hasil['log_pf'] == 0) { ?>
							Approved
						<?php } else { ?>
							Perubahan <?=$hasil['log_pf']?>
						<?php } ?>
					</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>1. MJO</li>
					<li class="active">Catatan Proforma</li>
				</ol>
			</section>
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border"></div>			
					<div class="bg-primary">
						<div class="box-body">
							
						<div class="col-md-5">
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
									<td class="align-start">QUANTITY</td>	
									<td class="align-start">:</td>
									<td>
										<?php
											$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
											if (mysql_num_rows($query3)==0) { ?>
												<?= $hasil['qty_pf'] ?> <?=$hasil['type_qty']?>
											<?php 	
											} else {
												$num = 1;
												while ($hasilQty = mysql_fetch_array($query3)) { ?>
													<p class="nopadding"><?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
												<?php
												$num++;
												}
											} 
										?>
									</td>
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
								<?php
									$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
									if (mysql_num_rows($query3)==0) { ?>
								<tr>
									<td>PU/DEL DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
								</tr>
								<tr>
									<td>PU/DEL LOCATION</td>	
									<td>:</td>
									<td>
										<?= $hasil['pudel_location'] ?>
									</td>		
								</tr>
								<?php 	
								} else {
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
												<p class="nopadding">: <?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></p>
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
									}
								} ?>
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
									<td style="vertical-align:top" width=35%>SPECIAL ORDER REQUEST </td>
									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
										?>
											<?=$no_sor?>. <?=$hasil1['desc_sor']?>
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
									<td><?=date("d M y ", strtotime($hasil['etb'])) ?>/<?=date("d M y", strtotime($hasil['etd'])) ?></td>		
								</tr>
								<?php
									if($hasil['shipment']!="EMKL IMPORT"){
								?>					
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
									<?php }?> 
									<?php 
									if($hasil['shipment']!="EMKL IMPORT"){ ?>
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
									<?php } ?>
									<tr>
									<td style="vertical-align:top">REAL CUSTOMER</td>
									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_ru=1;
											$query1 = mysql_query("select * from real_user where id_pf_log=$id_pf_log");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_real_user=$hasil1['id_real_user'];
										?>
											<?=$no_ru?>. <?=$hasil1['name_real_user']?>
										<?php $no_ru++; } ?>
									</td>
								</tr>		
							</table>				
						</div>

						<div class="col-md-2">
							<table>
								<tr>
									<td>
										<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
										<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=catatan&act=print_log&id_log=<?= $id_pf_log?>" target="_blank"><span class="fa fa-print"></a>
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
										}elseif ($hasil['aprove']==47){
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
							<div class="row">
								<div class="col-md-6">
									
									<?php
										$type1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");
										$hasil_type1=mysql_fetch_array($type1);
										$type_revenue=$hasil_type1['type_revenue'];
									?>
									<bold><?=$type_revenue?> </bold> </p>
									<a>
										<bold>TABLE REVENUE</bold>
									</a>

									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>FROM/TO</th>
											<th>QTY</th>
											<th>PPN</th>
											<th>PPH</th>
											<th>REVENUE</th>
											<th>SUM</th>
										</tr>
									
										<?php
										$no_job=1;	
										$sum_revenue=0;		
										$total_revenue=0;				
										$query2 = mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log order by id_pf_revenue asc");
										while ($hasil2 = mysql_fetch_array($query2)) { 	
											$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
											$id_pf_revenue=$hasil2['id_pf_revenue'];
										?>	
										<tr>					
											<td><?=$no_job?></td>
											<td><?=$hasil2['type2_revenue']?></td>
											<td><?=$hasil2['desc_revenue']?></td>
											<td><?=$hasil2['from_revenue']?>/<?=$hasil2['to_revenue']?></td>
											<td><?=$hasil2['qty_revenue']?>X<?=$hasil2['qty_type1_rev']?><?=$hasil2['qty_type2_rev']?></td>
											<td><?=$hasil2['ppn_revenue']?>%</td>
											<td><?=$hasil2['pph_revenue']?>%</td>
											<td><?=number_format($hasil2['revenue'])?></td>
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
									<a>
										<bold>TABLE EST COST</bold> 
									</a>
									
									<table class="table table-striped table-responsive">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>FROM/TO</th>
											<th>QTY</th>
											<th>PPH</th>
											<th>PPN</th>
											<th>EST COST</th>
											<th>SUM</th>
										</tr>
										<?php
										$no_job2=1;	
										$sum_est_cost=0;
										$total_est_cost=0;						
										$query3 = mysql_query("select * from pf_est_cost where id_pf_log=$id_pf_log order by id_pf_est_cost asc");
										while ($hasil3 = mysql_fetch_array($query3)) { 
											$sum_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost']; 
											$id_pf_est_cost=$hasil3['id_pf_est_cost'];
										?>
										<tr>				
											<td><?=$no_job2?></td>
											<td><?=$hasil3['type_est_cost']?></td>
											<td><?=$hasil3['desc_est_cost']?></td>
											<td><?=$hasil3['from_est_cost']?>/<?=$hasil3['to_est_cost']?></td>
											<td><?=$hasil3['qty_est_cost']?>X<?=$hasil3['qty_type1_est_cost']?><?=$hasil3['qty_type2_est_cost']?></td>
											<td><?=$hasil3['ppn_est_cost']?>%</td>
											<td><?=$hasil3['pph_est_cost']?>%</td>
											<td><?=number_format($hasil3['est_cost'])?></td>
											<td><?=number_format($sum_est_cost)?></td>
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
									<label>PROFIT AND LOST</label>	
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
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php break;
    }
}
?>
