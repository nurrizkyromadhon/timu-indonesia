<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_proforma/aksi_aproval.php';
    switch ($_GET[act]) { // Tampil User
        default: 
			// Menentukan tanggal awal bulan dan akhir bulan
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
			?>
			<script>
				$(document).ready(function(){
					$('#myTable').dataTable({
						order: [[1, 'desc']],
					});
				});
			</script>
			<section class="content-header">
				<h1>Aproval Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>1. MJO</li>
					<li class="active">Proforma</li>
				</ol>
			</section>
			
			<!-- Main content -->
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title"><b class="text-blue">Tabel Approval Proforma</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong></h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-9">
								<form name="submit" action="?module=aproval" method="POST">
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
								<div class="col-md-9">
									<table id="myTable" class="table table-responsive table-bordered table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NUMBER</th>
												<th>DATE</th>
												<th>JOB ORDER NUMBER</th>
												<th>CUSTOMER</th>
												<th>STATUS</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$query = mysql_query("SELECT * FROM pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc, no_pf desc");
											while ($hasil = mysql_fetch_array($query)) { 
												$id_pf = $hasil['id_pf']; 
											?>
											<tr>
												<td><?= $hasil['no_pf'] ?></td>
												<td><?= $hasil['tgl_pf']?></td>
												<td><b><?= $hasil['no_jo'] ?></b></td>
												<td><?= $hasil['cust_name'] ?></td>
												<td>
													<?php if($hasil['aprove']=="batal"){ ?>
														<b class="text-red">BATAL</b>
													<?php } elseif ($hasil['aprove']=="0"){ ?>
														<b class="text-green">PROFORMA</b>
													
													<?php } else { 
														$queryStatus=mysql_query("SELECT status_ops from pf_log WHERE id_pf=$id_pf");
														while ($hasilStatus = mysql_fetch_array($queryStatus)) {?>
														<b class="text-blue"><?=$hasilStatus['status_ops']?>
													<?php }
													} ?>
												</td>
												<td>	
													<a class="btn bg-light-blue btn-sm" href="?module=aproval&act=show&id=<?= $id_pf ?>"><b>DETAIL</b></a>
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
		<?php break;

		case 'show': ?>
			<section class="content-header">
				<h1>Aproval Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
					<li>1. MJO</li>
					<li class="active">Aproval Proforma</li>
				</ol>
			</section>
			<?php
				$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id]");
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
										<td>PARTY</td>
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
												<!-- Modal -->
												<div class="modal fade" id="pf<?=$id_pf?>" role="dialog">
													<div class="modal-dialog modal-lg" >
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h4 class="text-bold text-green">Edit Proforma</h4>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">

															<div class="modal-body" >
																<div class="col-sm-6">

																		<input type="hidden" name="module" value="aproval">
																		<input type="hidden" name="act" value="update_aproval">
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
																		<label>COMMODITY :</label>
																		<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="commodity" class="form-control" value="<?=$hasil['commodity']?>">
																	</div>
																	<div class="form-group">
																		<label>ROUTE :</label>
																		<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="route_pf" class="form-control" value="<?=$hasil['route_pf']?>">
																	</div>
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
																<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																<button type="submit1" class="btn bg-green">Update</button>
															</div>

															</form>
														</div>
													</div>
												</div>
												<a class="btn bg-black btn-sm" data-toggle="modal" href="#pf<?=$id_pf?>"><span class="fa fa-edit"></a>	
										<?php
										if($hasil['status_ops'] == "APPROVED"){ ?>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=excel&id=<?= $id_pf2 ?>"><span class="fa fa-save"></a>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=print&id=<?= $id_pf2 ?>" target="_blank"><span class="fa fa-print"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=aproved&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Aprove Pertama Akan Membuat Job Order Number Aprove Setelah Unaprove tidak merubah Job Order Number ')"><span class="fa fa-check"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=unaproved&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Unaprove tidak merubah dan menghapus Job Order Number')"><span class="fa fa-mail-reply"></a>
										<a class="btn bg-red btn-sm text-bold" href="<?= $aksi ?>?module=aproval&act=batal&id=<?= $id_pf ?>" onclick="return confirm('Apakah Sudah Yakin Akan dibatalkan !!!')">X</a></p>
										<?php	
										} elseif($hasil['status_ops'] == "SPPB / BE" OR $hasil['status_ops'] == "DELIVERED" OR $hasil['status_ops'] == "INVOICE" OR $hasil['status_ops'] == "PAID") { 
										?>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=excel&id=<?= $id_pf2 ?>"><span class="fa fa-save"></a>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=print&id=<?= $id_pf2 ?>" target="_blank"><span class="fa fa-print"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=forward&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Forward tidak merubah dan menghapus Job Order Number')"><span class="fa fa-mail-forward"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=unaproved&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Unaprove tidak merubah dan menghapus Job Order Number')"><span class="fa fa-mail-reply"></a>
										<a class="btn bg-red btn-sm text-bold" href="<?= $aksi ?>?module=aproval&act=batal&id=<?= $id_pf ?>" onclick="return confirm('Apakah Sudah Yakin Akan dibatalkan !!!')">X</a></p>
										<?php
										}else{
										?>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=excel&id=<?= $id_pf2 ?>"><span class="fa fa-save"></a>
										<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=aproval&act=print&id=<?= $id_pf2 ?>" target="_blank"><span class="fa fa-print"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=aproved&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Aprove Pertama Akan Membuat Job Order Number Aprove Setelah Unaprove tidak merubah Job Order Number ')"><span class="fa fa-check"></a>
										<a class="btn bg-light-blue btn-sm" href="<?= $aksi ?>?module=aproval&act=unaproved&id=<?= $id_pf2 ?>&aprove=<?=$hasil['aprove']?>&no_jo=<?=$hasil['no_jo']?>&tgl_aprove=<?=$hasil['tgl_aprove']?>" onclick="return confirm('Unaprove tidak merubah dan menghapus Job Order Number')"><span class="fa fa-mail-reply"></a>
										<a class="btn bg-red btn-sm text-bold" href="<?= $aksi ?>?module=aproval&act=batal&id=<?= $id_pf ?>" onclick="return confirm('Apakah Sudah Yakin Akan dibatalkan !!!')">X</a></p>
										<?php
										}
										?>
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
									$total_revenue_real=0;				
									$query4 = mysql_query("select * from pf_revenue where $id_data=$id_pf order by id_pf_revenue asc");
									while ($hasil4 = mysql_fetch_array($query4)) { 	
										$id_pf_revenue=$hasil4['id_pf_revenue'];
										$total_revenue_real += $hasil4['qty_revenue'] * $hasil4['revenue']
									?>	
									<tr>					
										<td><?=$no_job?></td>
										<td><?=$hasil4['type_revenue']?></td>
										<td><?=$hasil4['desc_revenue']?></td>
										<td><?=$hasil4['qty_revenue']?></td>
										<td><?=$hasil4['revenue']?></td>
										<td><?=$hasil4['qty_revenue'] * $hasil4['revenue']?></td>
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
									$total_est_cost_real=0;						
									$query5 = mysql_query("select * from pf_est_cost where $id_data=$id_pf order by id_pf_est_cost asc");
									while ($hasil5 = mysql_fetch_array($query5)) { 
										$id_pf_est_cost=$hasil5['id_pf_est_cost'];
										$total_est_cost_real += $hasil5['qty_est_cost'] * $hasil5['est_cost']
									?>
									<tr>				
										<td><?=$no_job2?></td>
										<td><?=$hasil5['type_est_cost']?></td>
										<td><?=$hasil5['desc_est_cost']?></td>
										<td><?=$hasil5['qty_est_cost']?></td>
										<td><?=$hasil5['est_cost']?></td>
										<td><?=$hasil5['qty_est_cost'] * $hasil5['est_cost']?></td>
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
								<h5><a><strong>TABEL KEGIATAN KEUANGAN JO NOMER : <?= $hasil['no_jo'] ?></strong></a></h5>
								<?php
									$type1=mysql_query("select * from pf_real_cost where $id_data=$id_pf");
									$hasil_type1=mysql_fetch_array($type1);
								?>
								<table class="table table-hover table-responsive">
									<tr class="bg-gray">
										<th>NO</th>
										<th>DATE</th>
										<th>NO REFF</th>										
										<th>TYPE COST</th>
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
	}
}
?>
