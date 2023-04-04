<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_proforma/aksi_proforma.php';
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
				<h1>Proforma <button type="button" class="btn btn-default btn-sm" onclick="location.href='<?php echo '?module=proforma&act=tambah'; ?>';" ><i class="fa fa-plus"></i></button></h1>
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
						<h3 class="box-title">Tambah Proforma</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-default btn-sm" onclick="location.href='<?php echo '?module=proforma&act=tambah'; ?>';" ><i class="fa fa-plus"></i></button>
						</div>
					</div>
					<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Tabel Proforma dari tgl <?=$tgl_aw_str?> s/d <?=$tgl_ak_str?></h3>
					</div>
					<div class="box-body">
						<form name="submit" action="?module=proforma" method="POST">
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
											$query = mysql_query("SELECT * FROM pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc, no_pf desc");
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
													<?php if(empty($hasil['aprove'])){ ?>
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
																				<input type="hidden" name="module" value="proforma">
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
																								<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type0[]" class="form-control w-full" value="<?=$hasilQty['type1']?>"></div>
																								<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type1[]" class="form-control w-full" value="<?=$hasilQty['type2']?>"></div>
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
													 <?php } ?>
													<a class="btn btn-default btn-sm" href="?module=proforma&act=show&id=<?= $id_pf ?>"><span class="fa fa-info"></a>
													<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=proforma&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
													<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=proforma&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
			</section>
			<script>
				if ( window.history.replaceState ) {
				window.history.replaceState( null, null, window.location.href );
				}
			</script>
		<?php break;
			
		case 'tambah': ?>
			<section class="content-header">
				<h1>Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=proforma">Proforma</a></li>
					<li class="active">Form Tambah Proforma</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
		
			  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Form Tambah Proforma</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<!-- /.col -->
							<div class="table-responsive">
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" name="submit" method="POST" action="<?= $aksi ?>?module=proforma&act=input">
										<div class="box-body">

											<div class="row with-border">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">NOMOR PPL</label>
														<div class="col-sm-6">
															<?php
																$bulan = date('n');
																$bulantgl= date('ym');
																$query=mysql_query("select no_pf from pf order by id_pf desc limit 1");
																$hasil=mysql_fetch_array($query);
																$urut=substr($hasil['no_pf'],7);
																$bulankemaren=substr($hasil['no_pf'],5,2);
																$bulanini=date('m');
																
																if ($bulankemaren!=$bulanini && $urut != 001){
																	$urut=0;
																}

																$urut=$urut+1;
																$no_urut=sprintf("%03s", $urut);
																
															?>
															
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="no_pf" value="PJO<?php echo date('ym');?><?=$no_urut?>"readonly>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">DATE</label>
														<div class="col-sm-6">
															<input type="date" class="form-control" name="tgl_pf"  value="<?php echo date('Y-m-d'); ?>" autofocus required>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">CUSTOMER NAME</label>
														<div class="col-sm-6">															
															<select class="form-control" id="nm_cust" name="cust_name" onchange="changeValue(this.value)" required>
																<option value="">- SELECT -</option>
																<?php
																	$query4=mysql_query("select * from data_cust");
																	$jsArray = "var pfcust = new Array();";
																	while($hasil4=mysql_fetch_array($query4)){
																?>
																	<option value="<?=$hasil4['nm_cust']?>"><?=$hasil4['nm_cust']?></option>
																	<?php 
																	 $jsArray .= "pfcust['" . $hasil4['nm_cust'] . "'] = {code_cust:'" . addslashes($hasil4['code_cust']) . "',reff_cust:'" . addslashes($hasil4['reff_cust']) . "',alamat_cust:'" . addslashes($hasil4['alamat_cust']) . "',pic_cust:'".addslashes($hasil4['pic_cust'])."',phone_cust:'".addslashes($hasil4['phone_cust'])."'};\n";
																	} 
																	?>	
															</select>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPMENT</label>
														<div class="col-sm-6">
															<select class="form-control" id="shipment" name="shipment">
																<option value="">- PILIH -</option>
																<option value="HANDLING EMKL EXPORT">HANDLING EMKL EXPORT</option>
																<option value="HANDLING EMKL IMPORT">HANDLING EMKL IMPORT</option>
																<option value="HANDLING EMKL LOCAL">HANDLING EMKL LOCAL</option>
																<option value="COURIER">HANDLING COURIER</option>
															</select>
														</div>
													</div>
													<script>
														$(document).ready(function(){
															function retrieveProformaData(){
																let customer = $('#nm_cust').val();
																let shipment = $('#shipment').val();

																$.ajax({
																	type: "GET",
																	url: 'modul/mod_proforma/getData.php',
																	data: {nm_cust: customer, shipment: shipment},
																	dataType : 'json',
																	success:function(result){
																		$('#commodity').val(result.commodity);
																		if (result.route_pf) {
																			$('#route_pf0').val(result.route_pf.split('/')[0]);
																			$('#route_pf1').val(result.route_pf.split('/')[1]);
																		}
																		$('#ct').val(result.ct);
																		$('#sales').val(result.sales);
																		$('#sf').val(result.sf);
																		$('#vv').val(result.vv);
																	}
																});
															}
															$('#shipment').change(() => retrieveProformaData());
															$('#nm_cust').change(() => retrieveProformaData());
													});
													</script>
													<div class="form-group">
														<label class="col-sm-3 control-label">QUANTITY</label>
														<div class="col-sm-6">
															<div class="row mb-2">
																<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(0, this.value)" type="text" class="form-control" name="party_pf0[]" placeholder="quantity" required></div>
																<div class="col-sm-1"><label class="control-label">X</label></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-5 nopadding-right">
																	<select onchange="changeQtyType1Value(0, this.value)" class="form-control" name="party_pf1[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(0, this.value)" type="text" class="form-control" name="party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-5 nopadding-right">
																	<select onchange="changeQtyType2Value(0, this.value)" class="form-control" name="party_pf2[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc2Value(0, this.value)" type="text" class="form-control" name="party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="border-w"></div>
														</div>
													</div>

													<div id="party"></div>

													<div class="form-group">
														<div class="col-sm-9 btn-action" align="right">
															<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMoreParty();" />
															<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRowParty();" />
														</div>
													</div>

													<script type="text/javascript">
														var qtyRow = 1;
														function addMoreParty() {
															addMorePudel();
															addMoreRevQty(0);
															addMoreCostQty(0);
															$("#party").append(`
															<div class="form-group qty-item-${qtyRow}">
																<label class="col-sm-3 control-label"></label>
																<div class="col-sm-6">
																	<div class="row mb-2">
																		<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(${qtyRow}, this.value)" type="text" class="form-control" name="party_pf0[]" placeholder="quantity" autofocus required></div>
																		<div class="col-sm-1"><label class="control-label">X</label></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-5 nopadding-right">
																			<select onchange="changeQtyType1Value(${qtyRow}, this.value)" class="form-control" name="party_pf1[]">
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(${qtyRow}, this.value)" type="text" class="form-control" name="party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-5 nopadding-right">
																			<select onchange="changeQtyType2Value(${qtyRow}, this.value)" class="form-control" name="party_pf2[]">
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc2Value(${qtyRow}, this.value)" type="text" class="form-control" name="party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="border-w"></div>
																</div>
															</div>
															`);
															qtyRow++;
														}
														function deleteRowParty() {
															if (qtyRow > 1) {
																$(`.qty-item-${qtyRow - 1}`).remove();
																qtyRow--;
																deleteRowPudel();
																deleteRevQtyRow(0);
																deleteCostQtyRow(0);
															}
														}
														function changeQtyValue(index, value) {
															$(`.rev-qty-${index}`).val(value);
															$(`.cost-qty-${index}`).val(value);
															$(`#pudel-qty-${index}`).val(value);
														}
														function changeQtyType1Value(index, value) {
															$(`.rev-qty-type1-${index}`).val(value).change();
															$(`.cost-qty-type1-${index}`).val(value).change();
															$(`#pudel-qty-type1-${index}`).val(value).change();
														}
														function changeQtyDesc1Value(index, value) {
															$(`.rev-qty-desc1-${index}`).val(value.toUpperCase());
															$(`.cost-qty-desc1-${index}`).val(value.toUpperCase());
															$(`#pudel-qty-desc1-${index}`).val(value.toUpperCase());
														}
														function changeQtyType2Value(index, value) {
															$(`.rev-qty-type2-${index}`).val(value).change();
															$(`.cost-qty-type2-${index}`).val(value).change();
															$(`#pudel-qty-type2-${index}`).val(value).change();
														}
														function changeQtyDesc2Value(index, value) {
															$(`.rev-qty-desc2-${index}`).val(value.toUpperCase());
															$(`.cost-qty-desc2-${index}`).val(value.toUpperCase());
															$(`#pudel-qty-desc2-${index}`).val(value.toUpperCase());
														}						
													</script>
													
													<div class="form-group">
													    <label class="col-sm-3 control-label">COMMODITY</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" id="commodity" class="form-control" name="commodity"  autofocus required>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">ROUTE</label>
														<div class="col-sm-6">
															<div class="row">
															<div class="col-sm-5"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" id="route_pf0" name="route_pf0" autofocus required></div>
															<div class="col-sm-1"><label class="control-label">/</label></div>
															<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" id="route_pf1" name="route_pf1" autofocus required></div>
															</div>
														</div>
													</div>   

													<div class="form-group">
														<label class="col-sm-3 control-label">PICK UP / DELVERY</label>
														<div class="col-sm-6">
															<label class="control-label sub-label-margin">DATE</label>
															<input onkeyup="this.value = this.value.toUpperCase()" type="datetime-local" class="form-control" name="pudel_date0[]" autofocus required>
															<label class="control-label sub-label-margin">QTY</label>
															<div class="row mb-2">
																<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-0" class="form-control" name="pudel_party_qty[]" placeholder="quantity" autofocus required></div>
																<div class="col-sm-1"><label class="control-label">X</label></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-5 nopadding-right">
																	<select class="form-control" id="pudel-qty-type1-0" name="pudel_party_pf1[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-desc1-0" class="form-control" name="pudel_party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-5 nopadding-right">
																	<select class="form-control" id="pudel-qty-type2-0" name="pudel_party_pf2[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-desc2-0" class="form-control" name="pudel_party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row">
																<div class="col-sm-6"><label class="control-label sub-label-margin">FROM</label></div>
																<div class="col-sm-6"><label class="control-label sub-label-margin">TO</label></div>
															</div>
															<div class="row">
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeFromPudel(0, this.value)" type="text" class="form-control" name="pudel_route_from_pf[]" autofocus required></div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeToPudel(0, this.value)" type="text" class="form-control" name="pudel_route_to_pf[]" autofocus required></div>
															</div>
															<div class="border-w"></div>
														</div>
													</div>

													<div id="pudel"></div>

													<div class="form-group">
														<div class="col-sm-9 btn-action" align="right">
															<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMorePudel();" />
															<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRowPudel();" />
														</div>
													</div>

													<script type="text/javascript">
														var pudelRow = 1;
														function addMorePudel() {
															$("#pudel").append(`
															<div class="form-group pudel-item-${pudelRow}">
																<label class="col-sm-3 control-label"></label>
																<div class="col-sm-6">
																	<label class="control-label sub-label-margin">DATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="datetime-local" class="form-control" name="pudel_date0[]" autofocus required>
																	<label class="control-label sub-label-margin">QTY</label>
																	<div class="row mb-2">
																		<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-${pudelRow}" class="form-control" name="pudel_party_qty[]" placeholder="quantity" autofocus required></div>
																		<div class="col-sm-1"><label class="control-label">X</label></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-5 nopadding-right">
																			<select class="form-control" id="pudel-qty-type1-${pudelRow}" name="pudel_party_pf1[]" autofocus required>
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-desc1-${pudelRow}" class="form-control" name="pudel_party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-5 nopadding-right">
																			<select class="form-control" id="pudel-qty-type2-${pudelRow}" name="pudel_party_pf2[]" autofocus required>
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" type="text" id="pudel-qty-desc2-${pudelRow}" class="form-control" name="pudel_party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-6"><label class="control-label sub-label-margin">FROM</label></div>
																		<div class="col-sm-6"><label class="control-label sub-label-margin">TO</label></div>
																	</div>
																	<div class="row">
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeFromPudel(${pudelRow}, this.value)" type="text" class="form-control" name="pudel_route_from_pf[]" autofocus required></div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeToPudel(${pudelRow}, this.value)" type="text" class="form-control" name="pudel_route_to_pf[]" autofocus required></div>
																	</div>
																	<div class="border-w"></div>
																</div>
															</div>
															`);
															pudelRow++;
														}
														function deleteRowPudel() {
															if (pudelRow > 1) {
																$(`.pudel-item-${pudelRow - 1}`).remove();
																pudelRow--;
															}
														}
														function changeFromPudel(index, value) {
															$(`.rev-from-${index}`).val(value.toUpperCase());
															$(`.cost-from-${index}`).val(value.toUpperCase());
														}
														function changeToPudel(index, value) {
															$(`.rev-to-${index}`).val(value.toUpperCase());
															$(`.cost-to-${index}`).val(value.toUpperCase());
														}
													</script>

													<div class="form-group">
														<label class="col-sm-3 control-label">CREDIT TERM</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="ct" id="ct" placeholder="Isi Hanya Angka ...."  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SALES</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sales" id="sales" autofocus required>
														</div>
													</div>
												</div>	
												<div class="col-md-6">	
													<div class="form-group">
														<label class="col-sm-3 control-label">ADDRESS</label>
														<div class="col-sm-6">
															<textarea onkeyup="this.value = this.value.toUpperCase()"  class="form-control" name="address_pf" id="alamat_cust" autofocus required></textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CUSTOMER REF</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="cust_ref" id="reff_cust" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">CUSTOMER CODE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="cust_code" id="code_cust" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PIC</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="pic" id="pic_cust" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PHONE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="phone" id="phone_cust"  autofocus required>
														</div>
													</div>

													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPPING/FORWARDING</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sf" id="sf" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">VESSEL/VOYAGE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="vv" id="vv" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ETB/ETD</label>
														<div class="col-sm-3">
															<input type="date" class="form-control" name="etb" autofocus required >
														</div>
														<div class="col-sm-3">
															<input type="date" class="form-control" name="etd" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">OPEN STACK</label>
														<div class="col-sm-6">
															<input type="datetime-local" class="form-control" name="openstack"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CLOSING TIME CONTAINER</label>
														<div class="col-sm-6">
															<input type="datetime-local" class="form-control" name="ctc" autofocus required >
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">CLOSING TIME DOCUMENT</label>
														<div class="col-sm-6">
															<input type="datetime-local" class="form-control" name="ctd"  autofocus >
														</div>
													</div>	
												</div>
												<script type="text/javascript"> 
													<?php echo $jsArray; ?>
													function changeValue(id){
														document.getElementById('alamat_cust').value = pfcust[id].alamat_cust;
														document.getElementById('reff_cust').value = pfcust[id].reff_cust;
														document.getElementById('code_cust').value = pfcust[id].code_cust;
														document.getElementById('pic_cust').value = pfcust[id].pic_cust;
														document.getElementById('phone_cust').value = pfcust[id].phone_cust;
													};
												</script>
											</div>										
											<div class="box">
												<div class="row with-border head-label-margin">
													<label>SPECIAL REQUEST ORDER :</label>
												</div>	

												<div class="product-item form-group">
													<div class="col-sm-5">
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="desc_sor[]" placeholder="Description">
													</div>
													<div class="col-sm-2">
														<input type="checkbox" class="pull-left" name="item_index[]">
													</div>
												</div>
														
													<div id="product0"></div>

													<script type="text/javascript">
														var idrow = 1;
														function addMore0() {
															idrow++;
															$("#product0").append("<div class='product-item form-group'><div class='col-sm-5'><input type='text' class='form-control' name='desc_sor[]' placeholder='Description'></div><div class='col-sm-2'><input type='checkbox' class='pull-left' name='item_index[]'></div></div>");
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
														<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore0();" />
														<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow0();" />
													</div>
											</div>	


											<!---------- REVENUE ---------->
											<div class="box">
												<script type="text/javascript"> 
													function checkRevTypeValue(value, id){
														if (value == "TRANSPORTATION CHARGES") {
															$(`.revenue-index-${id} .from-to`).show(); 
														} else {
															$(`.revenue-index-${id} .from-to`).hide(); 
														}
													};
												</script>
												<div class="row with-border head-label-margin">
													<label>EST REVENUE :</label>
												</div>	

												<div class="product-item-rev-0 mb-4">
													<div class="form-group">
														<div class="col-sm-4">
															<label>DESCRIPTION</label>
															<select id="type-revenue" class="form-control" name="type_revenue[]" required onchange="checkRevTypeValue(this.value, 0)">
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
													</div>

													<div id="rev-qty-product-0" class="form-group revenue-index-0">
														<div class="col-sm-4 product-item-rev-qty0-0">
															<div hidden class="from-to row mb-2">
																<div class="col-sm-6">
																	<label>FROM</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-from-0" name="from_rev0[]" placeholder="From">
																</div>
																<div class="col-sm-6 nopadding-left">
																	<label>TO</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-to-0" name="to_rev0[]" placeholder="To">
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-0" name="qty_rev0[]" placeholder="quantity" required>
																</div>
																<div class="col-sm-6 w-content mt-2">
																	<label class="control-label">X</label>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control rev-qty-type1-0" name="qty_type1_rev0[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc1-0" name="qty_desc1_rev0[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control rev-qty-type2-0" name="qty_type2_rev0[]" autofocus required>
																		<option value=" ">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OT" >OT</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc2-0" name="qty_desc2_rev0[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-12">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_rev0[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>PPN</label>
																	<select class="form-control" name="ppn_rev0[]">
																		<option value="0">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11" >11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<label>PPH</label>
																	<select class="form-control" name="pph_rev0[]">
																		<option value="0">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >2%</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="btn-action float-clear" align="left">
														<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMoreRevQty(0);" />
														<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRevQtyRow(0);" />
														<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
													</div>
													<div class="border-w"></div>
												</div>
												<script type="text/javascript">
													
												</script>
														
												<div id="product1"></div>

												<script type="text/javascript">
													var revRow = 1;
													var qtyRevRow = [1];
													function addMore1() {
														$("#product1").append(`
														<div class="product-item-rev-${revRow} mb-4">
															<div class="form-group">
																<div class="col-sm-4">
																	<label>DESCRIPTION</label>
																	<select id="type-revenue" class="form-control" name="type_revenue[]" required onchange="checkRevTypeValue(this.value, ${idrow})">
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
															</div>

															<div id="rev-qty-product-${revRow}" class="form-group revenue-index-${revRow}">
																<div class="col-sm-4 product-item-rev-qty${revRow}-0">
																	<div hidden class="from-to row mb-2">
																		<div class="col-sm-6">
																			<label>FROM</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-from-0" name="from_rev${revRow}[]" placeholder="From">
																		</div>
																		<div class="col-sm-6 nopadding-left">
																			<label>TO</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-to-0" name="to_rev${revRow}[]" placeholder="To">
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<label>QTY</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-0" name="qty_rev${revRow}[]" placeholder="quantity" autofocus required>
																		</div>
																		<div class="col-sm-6 w-content mt-2">
																			<label class="control-label">X</label>
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<select class="form-control rev-qty-type1-0" name="qty_type1_rev${revRow}[]" autofocus required>
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc1-0" name="qty_desc1_rev${revRow}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<select class="form-control rev-qty-type2-0" name="qty_type2_rev${revRow}[]" autofocus required>
																				<option value=" ">- PILIH -</option>
																				<option value="STD" >STD</option>
																				<option value="HC">HC</option>
																				<option value="RF">RF</option>
																				<option value="FR">FR</option>
																				<option value="OT" >OT</option>
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
																			</select>
																		</div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc2-0" name="qty_desc2_rev${revRow}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-12">
																			<label>RATE</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_rev${revRow}[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<label>PPN</label>
																			<select class="form-control" name="ppn_rev${revRow}[]">
																				<option value="0">- PILIH JIKA DIKENAKAN -</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11" >11%</option>
																			</select>
																		</div>
																		<div class="col-sm-6">
																			<label>PPH</label>
																			<select class="form-control" name="pph_rev${revRow}[]">
																				<option value="0">- PILIH JIKA DIKENAKAN -</option>
																				<option value="1.1" >2%</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="btn-action float-clear" align="left">
																<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMoreRevQty(${revRow});" />
																<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRevQtyRow(${revRow});" />
																<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
															</div>
															<div class="border-w"></div>
														</div>
														`);
														revRow++;
														qtyRevRow.push(1);
													}
													function deleteRow1() {
														if (revRow >= 1) {
															$(`.product-item-rev-${revRow - 1}`).remove();
															revRow--;
														}
													}
													function addMoreRevQty(index) {
														$(`#rev-qty-product-${index}`).append(`
														<div class="col-sm-4 product-item-rev-qty${index}-${qtyRevRow[index]}">
															<div hidden class="from-to row mb-2">
																<div class="col-sm-6">
																	<label>FROM</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-from-${qtyRevRow[index]}" name="from_rev${index}[]" placeholder="From">
																</div>
																<div class="col-sm-6 nopadding-left">
																	<label>TO</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-to-${qtyRevRow[index]}" name="to_rev${index}[]" placeholder="To">
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-${qtyRevRow[index]}" name="qty_rev${index}[]" placeholder="quantity" autofocus required>
																</div>
																<div class="col-sm-6 w-content mt-2">
																	<label class="control-label">X</label>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control rev-qty-type1-${qtyRevRow[index]}" name="qty_type1_rev${index}[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc1-${qtyRevRow[index]}" name="qty_desc1_rev${index}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control rev-qty-type2-${qtyRevRow[index]}" name="qty_type2_rev${index}[]" autofocus required>
																		<option value=" ">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OT" >OT</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty-desc2-${qtyRevRow[index]}" name="qty_desc2_rev${index}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-12">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_rev${index}[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>PPN</label>
																	<select class="form-control" name="ppn_rev${index}[]">
																		<option value="0">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11" >11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<label>PPH</label>
																	<select class="form-control" name="pph_rev${index}[]">
																		<option value="0">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >2%</option>
																	</select>
																</div>
															</div>
														</div>
														`);
														qtyRevRow[index]++;
													}
													function deleteRevQtyRow(index) {
														if (qtyRevRow[index] >= 1) {
															$(`.product-item-rev-qty${index}-${qtyRevRow[index] - 1}`).remove();
															qtyRevRow[index]--;
														}
													}
												</script>
												
												<div class="btn-action float-clear" align="left">
													<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore1();" />
													<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow1();" />
													<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
												</div>
											</div>

											<!---------- EST COST ---------->
											<div class="box">			
												<script type="text/javascript"> 
													function checkEstTypeValue(value, id){
														if (value == "TRANSPORTATION CHARGES") {
															$(`.cost-index-${id} .from-to`).show(); 
														} else {
															$(`.cost-index-${id} .from-to`).hide(); 
														}
													};
												</script>
												<div class="row with-border head-label-margin">
													<label>EST COST :</label>
												</div>	

												<div class="product-item mb-4">
													<div class="form-group">
														<div class="col-sm-4">
															<label>DESCRIPTION</label>
															<select class="form-control" name="type_est_cost[]" onchange="checkEstTypeValue(this.value, 0)" autofocus required>
																<option value=""> - PILIH TYPE EST COST -</option>
																<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																<option value="PORT CHARGES"> PORT CHARGES </option>
																<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
															</select>
														</div>
													</div>

													<div id="cost-qty-product-0" class="form-group cost-index-0">
														<div class="col-sm-4 product-item-0">
															<div hidden class="from-to row mb-2">
																<div class="col-sm-6">
																	<label>FROM</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-from-0" name="from_cost0[]" placeholder="From">
																</div>
																<div class="col-sm-6 nopadding-left">
																	<label>TO</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-to-0" name="to_cost0[]" placeholder="To">
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-0" name="qty_cost0[]" placeholder="quantity" autofocus required>
																</div>
																<div class="col-sm-6 w-content mt-2">
																	<label class="control-label">X</label>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control cost-qty-type1-0" name="qty_type1_cost0[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-desc1-0" name="qty_desc1_cost0[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control cost-qty-type2-0" name="qty_type2_cost0[]" autofocus required>
																		<option value=" ">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OT" >OT</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-desc2-0" name="qty_desc2_cost0[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-12">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_cost0[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>PPN</label>
																	<select class="form-control" name="ppn_cost0[]">
																		<option value="">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<label>PPH</label>
																	<select class="form-control" name="pph_cost0[]">
																		<option value="">- PILIH JIKA DIKENAKAN -</option>
																		<option value="2" >2%</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="btn-action float-clear" align="left">
														<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMoreCostQty(0);" />
														<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteCostQtyRow(0);" />
														<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
													</div>
													<div class="border-w"></div>
												</div>
														
												<div id="product2"></div>
												<script type="text/javascript">
													var costRow = 1;
													var qtyCostRow = [1];
													function addMore2() {
														$("#product2").append(`
														<div class="product-item-cost-${costRow} mb-4">
															<div class="form-group">
																<div class="col-sm-4">
																	<label>DESCRIPTION</label>
																	<select class="form-control" name="type_est_cost[]" onchange="checkEstTypeValue(this.value, ${idrow})" autofocus required>
																		<option value=""> - PILIH TYPE EST COST -</option>
																		<option value="SHIPPING/FORWARDING CHARGESRATE"> SHIPPING/FORWARDING CHARGES </option>
																		<option value="PORT CHARGES"> PORT CHARGES </option>
																		<option value="THIRD PARTY CHARGES"> THIRD PARTY CHARGES </option>
																		<option value="CUSTOMS AND OPERATION CHARGES"> CUSTOMS AND OPERATION CHARGES </option>
																		<option value="DEPO/CFS CHARGES"> DEPO/CFS CHARGES </option>
																		<option value="TRANSPORTATION CHARGES"> TRANSPORTATION CHARGES </option>
																		<option value="OTHERS CHARGES"> OTHERS CHARGES </option>
																	</select>
																</div>
															</div>

															<div id="cost-qty-product-${costRow}" class="form-group cost-index-${costRow}">
																<div class="col-sm-4 product-item-cost-qty${costRow}-0">
																	<div hidden class="from-to row mb-2">
																		<div class="col-sm-6">
																			<label>FROM</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-from-0" name="from_cost${costRow}[]" placeholder="From">
																		</div>
																		<div class="col-sm-6 nopadding-left">
																			<label>TO</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-to-0" name="to_cost${costRow}[]" placeholder="To">
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<label>QTY</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-0" name="qty_cost${costRow}[]" placeholder="quantity" autofocus required>
																		</div>
																		<div class="col-sm-6 w-content mt-2">
																			<label class="control-label">X</label>
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<select class="form-control cost-qty-type1-0" name="qty_type1_cost${costRow}[]" autofocus required>
																				<option value=" ">- PILIH -</option>
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
																			</select>
																		</div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-desc1-0" name="qty_desc1_cost${costRow}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<select class="form-control cost-qty-type2-0" name="qty_type2_cost${costRow}[]" autofocus required>
																				<option value=" ">- PILIH -</option>
																				<option value="STD" >STD</option>
																				<option value="HC">HC</option>
																				<option value="RF">RF</option>
																				<option value="FR">FR</option>
																				<option value="OT" >OT</option>
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
																			</select>
																		</div>
																		<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control  cost-qty-desc2-0" name="qty_desc2_cost${costRow}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-12">
																			<label>RATE</label>
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_cost${costRow}[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																		</div>
																	</div>
																	<div class="row mb-2">
																		<div class="col-sm-6">
																			<label>PPN</label>
																			<select class="form-control" name="ppn_cost${costRow}[]">
																				<option value="">- PILIH JIKA DIKENAKAN -</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11">11%</option>
																			</select>
																		</div>
																		<div class="col-sm-6">
																			<label>PPH</label>
																			<select class="form-control" name="pph_cost${costRow}[]">
																				<option value="">- PILIH JIKA DIKENAKAN -</option>
																				<option value="2" >2%</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
															<div class="btn-action float-clear" align="left">
																<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMoreCostQty(${costRow});" />
																<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteCostQtyRow(${costRow});" />
																<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
															</div>
															<div class="border-w"></div>
														</div>
														`);
														costRow++;
														qtyCostRow.push(1);
													}
													function deleteRow2() {
														if (costRow >= 1) {
															$(`.product-item-cost-${costRow - 1}`).remove();
															costRow--;
														}
													}
													function addMoreCostQty(index) {
														$(`#cost-qty-product-${index}`).append(`
														<div class="col-sm-4 product-item-cost-qty${index}-${qtyCostRow[index]}">
															<div hidden class="from-to row mb-2">
																<div class="col-sm-6">
																	<label>FROM</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-from-${qtyCostRow[index]}" name="from_cost${index}[]" placeholder="From">
																</div>
																<div class="col-sm-6 nopadding-left">
																	<label>TO</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-to-${qtyCostRow[index]}" name="to_cost${index}[]" placeholder="To">
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-${qtyCostRow[index]}" name="qty_cost${index}[]" placeholder="quantity" autofocus required>
																</div>
																<div class="col-sm-6 w-content mt-2">
																	<label class="control-label">X</label>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control cost-qty-type1-${qtyCostRow[index]}" name="qty_type1_cost${index}[]" autofocus required>
																		<option value=" ">- PILIH -</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-desc1-${qtyCostRow[index]}" name="qty_desc1_cost${index}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<select class="form-control cost-qty-type2-${qtyCostRow[index]}" name="qty_type2_cost${index}[]" autofocus required>
																		<option value=" ">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OT" >OT</option>
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
																	</select>
																</div>
																<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty-desc2-${qtyCostRow[index]}" name="qty_desc2_cost${index}[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-12">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="rate_cost${index}[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="row mb-2">
																<div class="col-sm-6">
																	<label>PPN</label>
																	<select class="form-control" name="ppn_cost${index}[]">
																		<option value="">- PILIH JIKA DIKENAKAN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<label>PPH</label>
																	<select class="form-control" name="pph_cost${index}[]">
																		<option value="">- PILIH JIKA DIKENAKAN -</option>
																		<option value="2" >2%</option>
																	</select>
																</div>
															</div>
														</div>
														`);
														qtyCostRow[index]++;
													}
													function deleteCostQtyRow(index) {
														if (qtyCostRow[index] >= 1) {
															$(`.product-item-cost-qty${index}-${qtyCostRow[index] - 1}`).remove();
															qtyCostRow[index]--;
														}
													}
												</script>
												<div class="btn-action float-clear" align="left">
													<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore2();" />
													<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow2();" />
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
		<?php break;
		case 'show': ?>
			<section class="content-header">
				<h1>Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=proforma">Proforma</a></li>
					<li class="active">Detail Proforma</li>
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
								<table style="width:100%">
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
										<td><?= $hasil['ct'] ?> </td>		
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
																<input type="hidden" name="module" value="proforma">
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
											<?php
												if(empty($hasil['aprove'])){
											?>
											<a class="btn btn-default btn-sm" data-toggle="modal" href="#sor_plus<?=$id_pf?>">+</a>	
												<?php } ?>
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
											
											<?php
											if(empty($hasil['aprove'])){
											?>
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
											<a class="btn" data-toggle="modal" href="#sor<?=$id_pf_sor?>"><span class="fa fa-edit"></a>	
											<a class="btn" href="<?= $aksi ?>?module=proforma&act=delete_sor&id=<?= $id_pf_sor ?>&id_pf=<?= $id_pf ?>" style="color: red;">X</a>
											<?php } ?>
											</br>
											<?php $no_sor++; } ?>
										</td>
									</tr>
								</table>
							</div>
							<div class="col-md-5">
								<table style="width:100%">
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
										<td><?= date("d M y ", strtotime($hasil['etb'])) ?> / <?= date("d M y ", strtotime($hasil['etd'])) ?></td>		
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
										<td><?= date("d M y h:i:s", strtotime($hasil['ctc'])) ?> </td>		
									</tr>
									<tr>
										<td>CLOSING TIME DOCUMENT</td>	
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>		
									</tr>
										<?php }else{ ?>
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
										<?php
										if (empty($hasil['aprove'])){
										?>
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
																<input type="hidden" name="module" value="proforma">
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
										<?php } ?>
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
											<?php
												if(empty($hasil['aprove'])){
											?>
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
											<a class="btn" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
											<a class="btn" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>" style="color: red;">X</a>
												
											<?php } ?>
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
										<?php
										if(empty($hasil['aprove'])){
										?>	
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

																<input type="hidden" name="module" value="proforma">
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
																<label>QUANTITY :</label>
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
																			<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type1[]" class="form-control" value="<?=$hasilQty['type2']?>"></div>
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
										<?php } ?>
										<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=proforma&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
										<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=proforma&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
									<a>
										<bold>TABLE REVENUE</bold>

										<?php
											if(empty($hasil['aprove'])){
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
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="tambah_revenue">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															<input type="hidden" name="id_pf" value="<?=$id_pf?>">

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
															<label>Quantity :</label>
															<div class="row">
																<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control"></div>
																<div class="col-sm-1 w-content">
																	<label class="control-label mt-1">X</label>
																</div>
																<div class="col-sm-4 nopadding-left">
																	<select class="form-control" name="qty_type1_rev">
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
																		<option value="">...</option>
																	</select>
																</div>
																<div class="col-sm-4 nopadding-left">
																	<select class="form-control" name="qty_type2_rev">
																		<option value="">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OP" >OP</option>
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
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>From / To</label>
															<div class="row">
																<div class="col-sm-6 nopadding-right">
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="from_revenue" placeholder="From">
																</div>
																<div class="col-sm-6">
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="to_revenue" placeholder="To">
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>PPN / PPH</label>
															<div class="row">
																<div class="col-sm-6 nopadding-right">
																	<select class="form-control" name="ppn_revenue">
																		<option value="">- PPN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<select class="form-control" name="pph_revenue">
																		<option value="">- PPH -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
															</div>
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
											<?php } ?>
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
													if(empty($hasil['aprove'])){
												?>
												<!--<a class="btn btn-primary btn-sm" href="?module=proforma&act=edit&id=<?= $hasil['id_pf']?>"><span class="fa fa-edit"></a>-->
												<!-- Modal -->
												<div class="modal fade" id="revenue1<?=$id_pf_revenue?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edit Revenue</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																<div class="form-group">
																	<input type="hidden" name="module" value="proforma">
																	<input type="hidden" name="act" value="update_revenue">
																	<input type="hidden" name="id" value="<?=$id_pf_revenue?>">
																	<input type="hidden" name="id_pf" value="<?=$id_pf?>">

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
																	<label>Quantity :</label>
																	<div class="row">
																		<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control" value="<?=$hasil2['qty_revenue']?>"></div>
																		<div class="col-sm-1 w-content">
																			<label class="control-label mt-1">X</label>
																		</div>
																		<div class="col-sm-4 nopadding-left">
																			<select class="form-control" name="qty_type1_rev">
																				<option value="<?=$hasil2['qty_type1_rev']?>"><?=$hasil2['qty_type1_rev']?></option>
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
																			</select>
																		</div>
																		<div class="col-sm-4 nopadding-left">
																			<select class="form-control" name="qty_type2_rev">
																				<option value="<?=$hasil2['qty_type2_rev']?>"><?=$hasil2['qty_type2_rev']?></option>
																				<option value="STD" >STD</option>
																				<option value="HC">HC</option>
																				<option value="RF">RF</option>
																				<option value="FR">FR</option>
																				<option value="OP" >OP</option>
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
																			</select>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>From / To</label>
																	<div class="row">
																		<div class="col-sm-6 nopadding-right">
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="from_revenue" placeholder="From" value="<?=$hasil2['from_revenue']?>">
																		</div>
																		<div class="col-sm-6">
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="to_revenue" placeholder="To" value="<?=$hasil2['to_revenue']?>">
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>PPN / PPH</label>
																	<div class="row">
																		<div class="col-sm-6 nopadding-right">
																			<select class="form-control" name="ppn_revenue">
																				<option value="<?=$hasil2['ppn_revenue']?>"><?=$hasil2['ppn_revenue']?>%</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11">11%</option>
																			</select>
																		</div>
																		<div class="col-sm-6">
																			<select class="form-control" name="pph_revenue">
																				<option value="<?=$hasil2['pph_revenue']?>"><?=$hasil2['pph_revenue']?>%</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11">11%</option>
																			</select>
																		</div>
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
												<a class="btn btn-primary btn-sm" data-toggle="modal" href="#revenue1<?=$id_pf_revenue?>"><span class="fa fa-edit"></a>	
												<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=proforma&act=delete_revenue&id=<?=$id_pf_revenue?>&id_pf=<?=$id_pf?>"><span class="fa fa-trash"></a>
													<?php } ?>
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
											if(empty($hasil['aprove'])){
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
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="tambah_est_cost">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															<label>Category :</label>
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
															<label>Est Cost :</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="est_cost" class="form-control">
														</div>
														<div class="form-group">
															<label>Quantity :</label>
															<div class="row">
																<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_est_cost" class="form-control"></div>
																<div class="col-sm-1 w-content">
																	<label class="control-label mt-1">X</label>
																</div>
																<div class="col-sm-4 nopadding-left">
																	<select class="form-control" name="qty_type1_est_cost">
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
																		<option value="">...</option>
																	</select>
																</div>
																<div class="col-sm-4 nopadding-left">
																	<select class="form-control" name="qty_type2_est_cost">
																		<option value="">- PILIH -</option>
																		<option value="STD" >STD</option>
																		<option value="HC">HC</option>
																		<option value="RF">RF</option>
																		<option value="FR">FR</option>
																		<option value="OP" >OP</option>
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
																	</select>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>From / To</label>
															<div class="row">
																<div class="col-sm-6 nopadding-right">
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="from_est_cost" placeholder="From">
																</div>
																<div class="col-sm-6">
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="to_est_cost" placeholder="To">
																</div>
															</div>
														</div>
														<div class="form-group">
															<label>PPN / PPH</label>
															<div class="row">
																<div class="col-sm-6 nopadding-right">
																	<select class="form-control" name="ppn_est_cost">
																		<option value="">- PPN -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
																<div class="col-sm-6">
																	<select class="form-control" name="pph_est_cost">
																		<option value="">- PPH -</option>
																		<option value="1.1" >1.1%</option>
																		<option value="11">11%</option>
																	</select>
																</div>
															</div>
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
											<?php } ?>
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
													if(empty($hasil['aprove'])){
												?>
												<!-- Modal -->
												<div class="modal fade" id="est_cost<?=$id_pf_est_cost?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edits Est Cost</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																<div class="form-group">
																	<input type="hidden" name="module" value="proforma">
																	<input type="hidden" name="act" value="update_est_cost">
																	<input type="hidden" name="id" value="<?=$id_pf_est_cost?>">
																	<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																	<label>Category :</label>
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
																	<label>Est Cost :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="est_cost" class="form-control" value="<?=$hasil3['est_cost']?>">
																</div>
																<div class="form-group">
																	<label>Quantity :</label>
																	<div class="row">
																		<div class="col-sm-3 nopadding-right"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_est_cost" class="form-control" value="<?=$hasil3['qty_est_cost']?>"></div>
																		<div class="col-sm-1 w-content">
																			<label class="control-label mt-1">X</label>
																		</div>
																		<div class="col-sm-4 nopadding-left">
																			<select class="form-control" name="qty_type1_est_cost">
																				<option value="<?=$hasil3['qty_type1_est_cost']?>"><?=$hasil3['qty_type1_est_cost']?></option>
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
																			</select>
																		</div>
																		<div class="col-sm-4 nopadding-left">
																			<select class="form-control" name="qty_type2_est_cost">
																				<option value="<?=$hasil3['qty_type2_est_cost']?>"><?=$hasil3['qty_type2_est_cost']?></option>
																				<option value="STD" >STD</option>
																				<option value="HC">HC</option>
																				<option value="RF">RF</option>
																				<option value="FR">FR</option>
																				<option value="OP" >OP</option>
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
																			</select>
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>From / To</label>
																	<div class="row">
																		<div class="col-sm-6 nopadding-right">
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="from_est_cost" placeholder="From" value="<?=$hasil3['from_est_cost']?>">
																		</div>
																		<div class="col-sm-6">
																			<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="to_est_cost" placeholder="To" value="<?=$hasil3['to_est_cost']?>">
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label>PPN / PPH</label>
																	<div class="row">
																		<div class="col-sm-6 nopadding-right">
																			<select class="form-control" name="ppn_est_cost">
																				<option value="<?=$hasil3['ppn_est_cost']?>"><?=$hasil3['ppn_est_cost']?>%</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11">11%</option>
																			</select>
																		</div>
																		<div class="col-sm-6">
																			<select class="form-control" name="pph_est_cost">
																				<option value="<?=$hasil3['pph_est_cost']?>"><?=$hasil3['pph_est_cost']?>%</option>
																				<option value="1.1" >1.1%</option>
																				<option value="11">11%</option>
																			</select>
																		</div>
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
												<a class="btn btn-primary btn-sm" data-toggle="modal" href="#est_cost<?=$id_pf_est_cost?>"><span class="fa fa-edit"></a>
												<a class="btn btn-danger btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_est_cost&id=<?=$id_pf_est_cost?>&id_pf=<?=$id_pf?>"><span class="fa fa-trash"></a>
													<?php } ?> 
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
											<td>Total Real Cost</td>
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
		<?php break;
	}
}
?>
