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
						order: [[2, 'desc']],
					});
				});
			</script>
			<section class="content-header">
				<h1>Proforma</h1>
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
						<button type="button" class="btn bg-blue text-white btn-sm" onclick="location.href='<?php echo '?module=proforma&act=tambah'; ?>';" ><i class="fa fa-plus"></i></button>
						<h3 class="box-title text-blue text-bold">TAMBAH PROFORMA</h3>
					</div>
					<div class="box-header with-border">
						<h3 class="box-title"><b class="text-blue">Tabel Proforma</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="col-md-9">
								<form name="submit" action="?module=proforma" method="POST">
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
										<button class="pull-left btn bg-gray btn-md text-blue" type="submit"><b>OK</b></button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-8">
									<table id="myTable" class="table table-responsive table-bordered table-hover">
										<thead>
											<tr class="bg-blue">
												<th>NO</th>
												<th>NUMBER</th>
												<th>DATE</th>
												<th>NO JO</th>
												<th>CUSTOMER</th>
												<th>STATUS</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$query = mysql_query("SELECT * FROM pf where tgl_pf between '$tgl_aw' and '$tgl_ak' order by id_pf desc");
											while ($hasil = mysql_fetch_array($query)) { 
												$id_pf = $hasil['id_pf']; 
											?>
											<tr>
												<td><?= $no?></td>
												<td><?= $hasil['no_pf'] ?></td>
												<td><?= $hasil['tgl_pf']?></td>
												<td><?=$hasil['no_jo']?></td>
												<td><?= $hasil['cust_name'] ?></td>
												<td>
													<?php if($hasil['aprove']=="batal"){ ?>
														<b class="text-red">BATAL</b>
													<?php } elseif ($hasil['aprove']=="0"){ ?>
														<b class="text-green">PROFORMA</b>
													<?php } else { 
														$queryStatus=mysql_query("SELECT status_ops from pf_log WHERE id_pf=$id_pf");
														while ($hasilStatus = mysql_fetch_array($queryStatus)) {?>
														<b class="text-blue"><?=$hasilStatus['status_ops']?></b>
													<?php }
													} ?>
												</td>
												<td>
													<a class="btn bg-light-blue btn-sm" href="?module=proforma&act=show&id=<?= $id_pf ?>"><b>DETAIL</b></a>
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=proforma&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=proforma&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
				<h1>Form Tambah Proforma</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=proforma">Proforma</a></li>
					<li class="active">Form Tambah Proforma</li>
				</ol>
			</section>
		
			<!-- Main content -->
			<section class="content">
			<form class="form-horizontal" name="submit" method="POST" action="<?= $aksi ?>?module=proforma&act=input">

				<!---------- DATA SHIPMENT ---------->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Data Shipping</h3>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-12">	
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
																url: 'modul/mod_proforma/getData.php?act=auto',
																data: {nm_cust: customer, shipment: shipment},
																dataType: 'json',
																success:function(result){
																	if (result.rev === undefined || result.cost === undefined) return;
																	
																	console.log(result);
																	$('#commodity').val(result.pf.commodity);
																	if (result.pf.route_pf) {
																		$('#route_pf0').val(result.pf.route_pf.split('/')[0]);
																		$('#route_pf1').val(result.pf.route_pf.split('/')[1]);
																	}
																	$('#ct').val(result.pf.ct);
																	$('#sales').val(result.pf.sales);
																	$('#sf').val(result.pf.sf);
																	$('#vv').val(result.pf.vv);

																	if (result.cost !== undefined) 
																		for (let i = 0; i < result.cost.length; i++) {
																			let incrementCostRow = (i + 1) - costRow;
																			if (incrementCostRow > 0) addMore2();
																			else if (incrementCostRow < 0) deleteRow2();
																			$(`.type-cost-${i}`).val(result.cost[i].type_est_cost);
																			$(`.desc-cost-${i}`).val(result.cost[i].desc_est_cost);
																			$(`.cost-rate-${i}`).val(result.cost[i].est_cost);
																			$(`.cost-qty-${i}`).val(result.cost[i].qty_est_cost);
																		}
																	
																	if (result.rev !== undefined)
																		for (let i = 0; i < result.rev.length; i++) {
																			let incrementRevRow = (i + 1) - revRow;
																			if (incrementRevRow > 0) addMore1();
																			else if (incrementRevRow < 0) deleteRow1();
																			$(`.rev-type-${i}`).val(result.rev[i].type_revenue);
																			$(`.rev-desc-${i}`).val(result.rev[i].desc_revenue);
																			$(`.rev-rate-${i}`).val(result.rev[i].revenue);
																			$(`.rev-qty-${i}`).val(result.rev[i].qty_revenue);
																		}
																}
															});
														}
														$('#shipment').change(() => retrieveProformaData());
														$('#nm_cust').change(() => retrieveProformaData());
												});
												</script>

												<div class="form-group">
													<label class="col-sm-3 control-label">CREDIT TERM</label>
													<div class="col-sm-6">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="ct" id="ct" placeholder="Isi Hanya Angka"  autofocus required>
													</div>
												</div>
												<div class="form-group">
													<label class="col-sm-3 control-label">SALES</label>
													<div class="col-sm-6">
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="sales" id="sales" autofocus required>
													</div>
												</div>

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
														<div class="col-sm-5"><input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" id="route_pf1" name="route_pf1" autofocus required></div>
														</div>
													</div>
												</div>
												
												<div class="form-group">
													<label class="col-sm-3 control-label">SHIPPING / <br>FORWARDING</label>
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
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<!---------- Quantity ---------->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Party</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-sm-12">	
											<div class="box-body">	
												<div class="form-group row">
													<div class="col-sm-6">
														<label>QTY</label>
														<input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(this.value)" type="text" placeholder="Isi Hanya Angka" class="form-control pf_qty pf_qty_0" name="party_pf0[]" required>
													</div>
													<div class="col-sm-6">
														<label>TYPE 1</label>
														<input onchange="changeQtyType1Value(0, this.value)" class="form-control pf_qty_type1_0" list="type_qty" name="party_pf1[]" id="pilih" placeholder="- PILIH -">
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
														<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(0, this.value)" type="text" class="form-control pf_qty_desc1_0" name="party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
													</div>
													
												</div>

												<div id="party"></div>

												<div class="btn-action float-clear" align="left">
													<input class="btn btn bg-gray text-bold btn-sm btn-sm" type="button" name="add_item" value="+ PARTY" onClick="addMoreParty();" />
													<input class="btn btn bg-red text-bold text-white btn-sm btn-sm" type="button" name="del_item" value="- PARTY" onClick="deleteRowParty();" />
												</div>

												<script type="text/javascript">
													var qtyRow = 1;
													function addMoreParty() {
														$("#party").append(`
														<div class="form-group qty-item-${qtyRow}">
															<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyValue(this.value)" type="text" placeholder="Isi Hanya Angka" class="form-control pf_qty pf_qty_${qtyRow}" name="party_pf0[]" autofocus required></div>
															<div class="col-sm-6">
																<input onchange="changeQtyType1Value(${qtyRow}, this.value)" list="type_qty" class="form-control pf_qty_type1_${qtyRow}" name="party_pf1[]" placeholder="- PILIH -">
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
																<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyDesc1Value(${qtyRow}, this.value)" type="text" class="form-control pf_qty_desc1_${qtyRow}" name="party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
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
													function changeQtyValue(value) {
														//$(`.rev-qty`).val(value);
														//$(`.cost-qty`).val(value);
														// $(`#pudel-qty-${index}`).val(value);
													}
													function changeQtyType1Value(index, value) {
														$(`.rev-qty-type1-${index}`).val(value).change();
														$(`.cost-qty-type1-${index}`).val(value).change();
														// $(`#pudel-qty-type1-${index}`).val(value).change();
													}
													function changeQtyDesc1Value(index, value) {
														$(`.rev-qty-desc1-${index}`).val(value.toUpperCase());
														$(`.cost-qty-desc1-${index}`).val(value.toUpperCase());
														// $(`#pudel-qty-desc1-${index}`).val(value.toUpperCase());
													}
													function changeQtyType2Value(index, value) {
														$(`.rev-qty-type2-${index}`).val(value).change();
														$(`.cost-qty-type2-${index}`).val(value).change();
														// $(`#pudel-qty-type2-${index}`).val(value).change();
													}
													function changeQtyDesc2Value(index, value) {
														$(`.rev-qty-desc2-${index}`).val(value.toUpperCase());
														$(`.cost-qty-desc2-${index}`).val(value.toUpperCase());
														// $(`#pudel-qty-desc2-${index}`).val(value.toUpperCase());
													}						
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
					<div class="col-md-8">
						<!---------- PUDEL ---------->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Pickup Delivery</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">	
											<div class="box-body">
												<div class="form-group row">
													<div class="col-sm-3">
														<label>DATE</label>
														<input onkeyup="this.value = this.value.toUpperCase()" type="datetime-local" class="form-control" name="pudel_date0[]" autofocus required>
													</div>
													<div class="col-sm-5">
														<label>QTY</label>
														<div class="row">
															<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyPudel(0, this.value)" placeholder="Angka" type="text" id="pudel-qty-0" class="form-control" name="pudel_party_qty[]" autofocus required></div>
															<div class="col-sm-4">
																<input onchange="changeType1Pudel(0, this.value)" class="form-control" list="type_pudel" id="pudel-qty-type1-0" name="pudel_party_pf1[]" placeholder="- PILIH -">
																<datalist id="type_pudel">																	
																	<option value="20FT" >20FT</option>
																	<option value="40FT">40FT</option>
																	<option value="45FT">45FT</option>
																	<option value="TRUCK">TRUCK</option>																	
																	<option value="">...</option>
																</datalist>
																<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc1Pudel(0, this.value)" type="text" id="pudel-qty-desc1-0" class="form-control" name="pudel_party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
															<div class="col-sm-4">
																<input onchange="changeType2Pudel(0, this.value)" class="form-control" list="type_pudel2" id="pudel-qty-type2-0" name="pudel_party_pf2[]" placeholder="- PILIH -">
																<datalist id="type_pudel2">
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
																	<option value="">...</option>
																</datalist>
																<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc2Pudel(0, this.value)" type="text" id="pudel-qty-desc2-0" class="form-control" name="pudel_party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
															</div>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="row">
															<div class="col-sm-6"><label>FROM</label></div>
															<div class="col-sm-6"><label>TO</label></div>
														</div>
														<div class="row">
															<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeFromPudel(0, this.value)" type="text" class="form-control pf_pudel_from_0" name="pudel_route_from_pf[]" autofocus required></div>
															<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeToPudel(0, this.value)" type="text" class="form-control pf_pudel_to_0" name="pudel_route_to_pf[]" autofocus required></div>
														</div>
													</div>
												</div>

												<div id="pudel"></div>

												<div class="btn-action float-clear" align="left">
													<input class="btn bg-gray text-bold btn-sm" type="button" name="add_item" value="+ PUDEL" onClick="addMorePudel();" />
													<input class="btn bg-red text-bold text-white btn-sm" type="button" name="del_item" value="- PUDEL" onClick="deleteRowPudel();" />
												</div>

												<script type="text/javascript">
													var pudelRow = 1;
													function addMorePudel() {
														$("#pudel").append(`
														<div class="form-group row pudel-item-${pudelRow}">
															<div class="col-sm-3">
																<input onkeyup="this.value = this.value.toUpperCase()" type="datetime-local" class="form-control" name="pudel_date0[]" autofocus required>
															</div>
															<div class="col-sm-5">
																<div class="row">
																	<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeQtyPudel(${pudelRow}, this.value)" placeholder="Angka" type="text" id="pudel-qty-${pudelRow}" class="form-control" name="pudel_party_qty[]" autofocus required></div>
																	<div class="col-sm-4">
																		<input onchange="changeType1Pudel(${pudelRow}, this.value)" class="form-control" list="type_pudel" id="pudel-qty-type1-${pudelRow}" name="pudel_party_pf1[]" placeholder="- PILIH -">
																		<datalist id="type_pudel">
																			<option value="">- PILIH -</option>
																			<option value="20FT" >20FT</option>
																			<option value="40FT">40FT</option>
																			<option value="45FT">45FT</option>
																			<option value="TRUCK">TRUCK</option>
																			<option value="">...</option>
																		</datalist>
																		<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc1Pudel(${pudelRow}, this.value)" type="text" id="pudel-qty-desc1-${pudelRow}" class="form-control" name="pudel_party_pf1_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																	<div class="col-sm-4">
																	<input onchange="changeType2Pudel(${pudelRow}, this.value)" class="form-control" list="type_pudel2" id="pudel-qty-type2-${pudelRow}" name="pudel_party_pf2[]" placeholder="- PILIH -">
																		<datalist id="type_pudel2">
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
																			<option value="">...</option>
																		</datalist>
																		<div hidden class="col-sm-7"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeDesc2Pudel(${pudelRow}, this.value)"  type="text" id="pudel-qty-desc2-${pudelRow}" class="form-control" name="pudel_party_pf2_desc[]" placeholder="isi jika opsi ... dipilih" autofocus></div>
																	</div>
																</div>
															</div>
															<div class="col-sm-4">
																<div class="row">
																	<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeFromPudel(${pudelRow}, this.value)" type="text" class="form-control pf_pudel_from_${pudelRow}" name="pudel_route_from_pf[]" autofocus required></div>
																	<div class="col-sm-6"><input onkeyup="this.value = this.value.toUpperCase()" oninput="changeToPudel(${pudelRow}, this.value)" type="text" class="form-control pf_pudel_to_${pudelRow}" name="pudel_route_to_pf[]" autofocus required></div>
																</div>
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
													function changeQtyPudel(index, value) {
														$(`.rev-qty`).val(value);
														$(`.cost-qty`).val(value);
														$(`.rev-qty-${index}.tp`).val(value);
														$(`.cost-qty-${index}.tp`).val(value);
													}
													function changeType1Pudel(index, value) {
														$(`.rev-qty-type1-${index}.tp`).val(value).change();
														$(`.cost-qty-type1-${index}.tp`).val(value).change();
													}
													function changeDesc1Pudel(index, value) {
														$(`.rev-qty-desc1-${index}.tp`).val(value.toUpperCase());
														$(`.cost-qty-desc1-${index}.tp`).val(value.toUpperCase());
													}
													function changeType2Pudel(index, value) {
														$(`.rev-qty-type2-${index}.tp`).val(value).change();
														$(`.cost-qty-type2-${index}.tp`).val(value).change();
													}
													function changeDesc2Pudel(index, value) {
														$(`.rev-qty-desc2-${index}.tp`).val(value.toUpperCase());
														$(`.cost-qty-desc2-${index}.tp`).val(value.toUpperCase());
													}
												</script>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<!---------- SPECIAL ORDER ---------->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Special Order</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">	
											<div class="box-body">								
													<div id="product0"></div>

													<script type="text/javascript">
														var sorRow = 0;
														function addMore0() {
															$("#product0").append(`<div class='sor-item-${sorRow} product-item form-group'><div class='col-sm-12'><input oninput="this.value = this.value.toUpperCase()" type='text' class='form-control' name='desc_sor[]' placeholder='DESCRIPTION'></div><div class='col-sm-2'></div></div>`);
															sorRow++;
														}
														function deleteRow0() {
															if (sorRow > 0) {
																$(`.sor-item-${sorRow - 1}`).remove();
																sorRow--;
															}
														}
													</script>

													<div class="btn-action float-clear" align="left">
														<input class="btn bg-light-blue text-bold text-white btn-sm" type="button" name="add_item" value="+ ORDER" onClick="addMore0();" />
														<input class="btn bg-red text-bold text-white btn-sm" type="button" name="del_item" value="- ORDER" onClick="deleteRow0();" />
													</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<!---------- REAL CUSTOMER ------------>
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Real Customer</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">	
											<div class="box-body">
												<script type="text/javascript"> 
													function ruChangeValue(index, nm_cust){
														$.ajax({
															type: "GET",
															url: 'modul/mod_proforma/getData.php?act=auto_ru',
															data: {nm_cust: nm_cust},
															dataType: 'json',
															success:function(result){
																$(`#ru_alamat_cust_${index}`).val(result.alamat_cust);
																$(`#ru_code_${index}`).val(result.code_cust);
																$(`#ru_pic_${index}`).val(result.pic_cust);
																$(`#ru_reff_${index}`).val(result.reff_cust);
																$(`#ru_phone_${index}`).val(result.phone_cust);
															}
														});
													};
												</script>
													
												<div id="real-user"></div>

												<script type="text/javascript">
													var ruRow = 1;
													function addReal() {
														$("#real-user").append(`
														<div class="ru-item-${ruRow} form-group row">
															<div class="col-sm-2">
																<select class="form-control" id="nm_cust" name="ru_name[]" onchange="ruChangeValue(${ruRow}, this.value)">
																	<option value="">- SELECT -</option>
																	<?php
																		$query_ru=mysql_query("select * from data_cust");
																		while($hasil_ru=mysql_fetch_array($query_ru)){
																	?>
																	<option value="<?=$hasil_ru['nm_cust']?>"><?=$hasil_ru['nm_cust']?></option>
																	<?php } ?>
																</select>													
															</div>
															<div class="col-sm-2">
																<textarea onkeyup="this.value = this.value.toUpperCase()"  class="form-control" name="ru_address[]" id="ru_alamat_cust_${ruRow}"  placeholder="ADDRESS" autofocus></textarea>									
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control" name="ru_ref[]" id="ru_reff_${ruRow}"  placeholder="CUSTOMER REF" autofocus required>
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ru_code[]" id="ru_code_${ruRow}"  placeholder="CUSTOMER CODE" class="form-control">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ru_pic[]" id="ru_pic_${ruRow}"  placeholder="PIC" class="form-control">
															</div>
															<div class="col-sm-2">
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="ru_phone[]" id="ru_phone_${ruRow}"  placeholder="PHONE" class="form-control">
															</div>
														</div>
														`);
														ruRow++;
													}
													function deleteReal() {
														if (ruRow > 0) {
															$(`.ru-item-${ruRow - 1}`).remove();
															soruRowrRow--;
														}
													}
												</script>

												<div class="btn-action float-clear" align="left">
													<input class="btn bg-light-blue text-bold text-white btn-sm" type="button" name="add_item" value="+ REAL CUSTOMER" onClick="addReal();" />
													<input class="btn bg-red text-bold text-white btn-sm" type="button" name="del_item" value="- REAL CUSTOMER" onClick="deleteReal();" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<!---------- REVENUE ---------->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Est Revenue</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">	
											<div class="box-body">
												<script type="text/javascript"> 
													function checkRevTypeValue(value, id){
														if (value == "TRANSPORTATION CHARGES") {
															$(`.revenue-index-${id} .from-to`).show();
														} else {
															$(`.revenue-index-${id} .from-to`).hide(); 
														}
													};
												</script>

												<div class="product-item-rev-0 mb-2">
													<div class="form-group">
														<div class="col-sm-4">
															<label>TYPE</label>
															<select id="type-revenue-0" class="form-control rev-type-0" name="type_revenue[]" required onchange="checkRevTypeValue(this.value, 0)">
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
														<div class="col-sm-4 nopadding-left">
															<label>DESCRIPTION</label>
															<input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control rev-desc-0" name="desc_rev[]" required>
														</div>
														<div class="col-sm-2 nopadding-left">
															<label>QTY</label>
															<input oninput="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty rev-qty-0" name="qty_rev[]" required>
														</div>
														<div class="col-sm-2 nopadding-left">
															<label>RATE</label>
															<input oninput="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-rate-0 rev-rate-0-0" name="rate_rev[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
														</div>
													</div>
													<div class="border-w"></div>
												</div>
														
												<div id="product1"></div>

												<script type="text/javascript">
													var revRow = 1;
													function addMore1() {
														$("#product1").append(`
														<div class="product-item-rev-${revRow} mb-2">
															<div class="form-group">
																<div class="col-sm-4">
																	<label>TYPE</label>
																	<select id="type-revenue-${revRow}" class="form-control rev-type-${revRow}" name="type_revenue[]" required onchange="checkRevTypeValue(this.value, ${revRow})">
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
																<div class="col-sm-4 nopadding-left">
																	<label>DESCRIPTION</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-desc-${revRow}" name="desc_rev[]" required>
																</div>
																<div class="col-sm-2 nopadding-left">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control rev-qty rev-qty-${revRow}" name="qty_rev[]" required>
																</div>
																<div class="col-sm-2 nopadding-left">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control rev-rate-${revRow}" name="rate_rev[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="border-w"></div>
														</div>
														`);
														revRow++;
													}
													function deleteRow1() {
														if (revRow >= 1) {
															$(`.product-item-rev-${revRow - 1}`).remove();
															revRow--;
														}
													}
												</script>
												
												<div class="btn-action float-clear" align="left">
													<input class="btn bg-light-blue text-bold text-white btn-sm" type="button" name="add_item" value="+ REVENUE" onClick="addMore1();" />
													<input class="btn bg-red text-bold text-white btn-sm" type="button" name="del_item" value="- REVENUE" onClick="deleteRow1();" />
													<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<!---------- COST ---------->
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">Data Est Cost</h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="table-responsive">
										<div class="col-md-12">	
											<div class="box-body">	
												<script type="text/javascript"> 
													function checkEstTypeValue(value, id){
														if (value == "TRANSPORTATION CHARGES") {
															$(`.cost-index-${id} .from-to`).show(); 
															
														} else {
															$(`.cost-index-${id} .from-to`).hide(); 
														}
													};
												</script>

												<div class="product-item mb-2">
													<div class="form-group">
														<div class="col-sm-4">
															<label>TYPE</label>
															<select id="type-cost-0" class="form-control type-cost-0" name="type_est_cost[]" onchange="checkEstTypeValue(this.value, 0)" autofocus required>
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
														<div class="col-sm-4 nopadding-left">
															<label>DESCRIPTION</label>
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control desc-cost-0" name="desc_est_cost[]">
														</div>
														<div class="col-sm-2 nopadding-left">
															<label>QTY</label>
															<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty cost-qty-0" name="qty_cost[]" autofocus required>
														</div>
														<div class="col-sm-2 nopadding-left">
															<label>RATE</label>
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-rate-0" name="rate_cost[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
														</div>
													</div>

													<div class="border-w"></div>
												</div>
														
												<div id="product2"></div>

												<script type="text/javascript">
													var costRow = 1;
													function addMore2() {
														$("#product2").append(`
														<div class="product-item-cost-${costRow} mb-2">
															<div class="form-group">
																<div class="col-sm-4">
																	<label>TYPE</label>
																	<select id="type-cost-${costRow}" class="form-control type-cost-${costRow}" name="type_est_cost[]" onchange="checkEstTypeValue(this.value, ${costRow})" autofocus required>
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
																<div class="col-sm-4 nopadding-left">
																	<label>DESCRIPTION</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control desc-cost-${costRow}" name="desc_est_cost[]">
																</div>
																<div class="col-sm-2 nopadding-left">
																	<label>QTY</label>
																	<input onkeyup="this.value = this.value.toUpperCase()" type="text" class="form-control cost-qty cost-qty-${costRow}" name="qty_cost[]" autofocus required>
																</div>
																<div class="col-sm-2 nopadding-left">
																	<label>RATE</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control cost-rate-${costRow}" name="rate_cost[]" placeholder="(IDR) tanpa titik, koma" autofocus required>
																</div>
															</div>
															<div class="border-w"></div>
														</div>
														`);
														costRow++;
													}
													function deleteRow2() {
														if (costRow >= 1) {
															$(`.product-item-cost-${costRow - 1}`).remove();
															costRow--;
														}
													}
												</script>

												<div class="btn-action float-clear" align="left">
													<input class="btn bg-light-blue text-bold text-white btn-sm" type="button" name="add_item" value="+ EST COST" onClick="addMore2();" />
													<input class="btn bg-red text-bold text-white btn-sm" type="button" name="del_item" value="- EST COST" onClick="deleteRow2();" />
													<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="box box-default">
					<div class="box-body">
						<div class="row">
							<div class="table-responsive">
								<div class="col-md-12">	
									<div class="box-footer">
										<input type="hidden" id="save-rate" name="save_rate" value="y">
										<button type="submit" class="btn bg-blue text-bold pull-right">Submit</a>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</form>
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
				$addBtnColor = 'btn bg-blue btn-sm';
				$borderColor = 'info';

				$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil = mysql_fetch_array($query)) or die(mysql_error());
				$id_pf = $hasil['id_pf']; 
			?>				
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border"></div>
					<div class="bg-blue">
						<div class="box-body">
							<div class="row">
								<div class="col-md-5">
									<table style="width:100%">
										<tr>
											<td>NUMBER</td>	
											<td width=15>:</td>
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
											<td><?= $hasil['ct'] ?> </td>		
										</tr>
										<tr>
											<td>SALES</td>	
											<td>:</td>
											<td><?= $hasil['sales'] ?> </td>		
										</tr>
										
									</table>
								</div>
								<div class="col-md-5">
									<table style="width:100%">
									    <tr>
											<td>JO NUMBER</td>	
											<td width=15>:</td>
											<td><?= $hasil['no_jo'] ?></td>		
										</tr>
										<tr>
											<td>CUSTOMER REFF</td>	
											<td width=15>:</td>
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
																<h4 class="text-bold text-green">Edit Proforma</h4>
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
												<?php } ?>
												<a class="btn bg-gray text-black btn-sm" href="<?= $aksi ?>?module=proforma&act=excel&id=<?= $id_pf ?>"><span class="fa fa-save"></a>
												<a class="btn bg-gray text-black btn-sm" href="<?= $aksi ?>?module=proforma&act=print&id=<?= $id_pf ?>" target="_blank"><span class="fa fa-print"></a>
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
					</div>
					<div class="bg-default">
						<div class="box-body">
							<div class="row mb-3">
								<div class="col-sm-6">
									<h5><a><strong>PARTY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="<?=$borderColor?>">
											
											<th>QTY</th>
											<th>ACTION</th>
										</tr>
										<?php
											$numQtyData=1;
											$query3 = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
											while ($hasilQty = mysql_fetch_array($query3)) { 
												$id_pf_qty = $hasilQty['id_pf_qty'];
											?>
											
												<tr>
													
													<td><?=$hasilQty['qty']?> X <?=$hasilQty['type1']?> <?=$hasilQty['type2']?></td>
													<td>
													<?php
														if(empty($hasil['aprove'])) { ?>
															<!-- Modal -->
															<div class="modal fade" id="qty<?=$id_pf?>" role="dialog">
																<div class="modal-dialog modal-lg" >
																	<!-- Modal content-->
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h4 class="text-bold text-green">Edit Party</h4>
																		</div>
																		<form name="submitQty" action="<?=$aksi?>" method="get">
																			<input type="hidden" name="module" value="proforma">
																			<input type="hidden" name="act" value="update_qty">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<div class="modal-body" >
																				<div class="form-group">
																					<?php
																						$num = 1;
																						$queryQty = mysql_query("SELECT * from pf_qty where id_pf=$id_pf");
																						while ($hasilQtyEdit = mysql_fetch_array($queryQty)) { ?>
																						<label>PARTY #<?=$num?></label>
																						<div class="row">																							
																							<div class="col-sm-5 nopadding-right"><label>QTY</label><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_qty[]" class="form-control" value="<?=$hasilQtyEdit['qty']?>"></div>
																							<div class="col-sm-1 mt-1"><br><label class="control-label nopadding">X</label></div>
																							<div class="col-sm-5 nopadding"><label>TYPE</label><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type0[]" class="form-control" value="<?=$hasilQtyEdit['type1']?>"></div>
																							<!--<div class="col-sm-4"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="party_type1[]" class="form-control" value="<?=$hasilQtyEdit['type2']?>"></div>-->
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
															<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#qty<?=$id_pf?>"><span class="fa fa-edit"></a>	
															<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_qty&id=<?= $id_pf_qty ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
													<?php } ?>
													</td>
												</tr>
											<?php
											$numQtyData++;
											}
										?>
									</table>
									<?php
										if(empty($hasil['aprove'])){ ?>
										<!-- Modal -->
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
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="tambah_qty">
															<input type="hidden" name="id" value="<?=$id_pf?>">

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
										<a class="<?=$addBtnColor?>" data-toggle="modal" href="#qty_plus<?=$id_pf?>">+ PARTY</a>
										<?php } ?>
								</div>
								<div class="col-sm-6">
									<h5><a><strong>PICK UP DELIVERY</a></strong></h5>
									<table class="table table-bordered table-hover">
										<tr class="<?=$borderColor?>">
											<th>NO</th>
											<th>DATE</th>
											<th>QTY</th>
											<th>FROM/TO</th>
											<th>ACTION</th>
										</tr>
										<?php
											$numPudelData=1;
											$query3 = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
											while ($hasilPudel = mysql_fetch_array($query3)) { 
												$id_pf_pudel= $hasilPudel['id_pf_pudel'] ?>
												<tr>
													<td><?=$numPudelData?></td>
													<td><?=$hasilPudel['pudel_date']?></td>
													<td><?=$hasilPudel['qty']?> X <?=$hasilPudel['type1']?> <?=$hasilPudel['type2']?></td>
													<td><?=$hasilPudel['pudel_from']?> / <?=$hasilPudel['pudel_to']?></td>
													<td>
													<?php
														if(empty($hasil['aprove'])){ ?>
															<!-- Modal -->
															<div class="modal fade" id="pudel<?=$id_pf?>" role="dialog">
																<div class="modal-dialog modal-lg" >
																	<!-- Modal content-->
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h4 class="text-bold text-green">Edit Pick Up Delivery</h4>
																		</div>
																		<form name="submitQty" action="<?=$aksi?>" method="get">
																			<input type="hidden" name="module" value="proforma">
																			<input type="hidden" name="act" value="update_pudel">
																			<input type="hidden" name="id" value="<?=$id_pf?>">
																			<div class="modal-body" >
																				<div class="form-group">
																				<?php 	
																					$num = 1;
																					$queryPudel = mysql_query("SELECT * from pf_pudel where id_pf=$id_pf");
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
															<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#pudel<?=$id_pf?>"><span class="fa fa-edit"></a>	
															<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_pudel&id=<?= $id_pf_pudel ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
													<?php } ?>
													</td>
												</tr>
											<?php $numPudelData ++;
											}
										?>
									</table>
									<?php
										if(empty($hasil['aprove'])){ ?>
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
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="tambah_pudel">
															<input type="hidden" name="id" value="<?=$id_pf?>">
															
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
										<a class="<?=$addBtnColor?>" data-toggle="modal" href="#pudel_plus<?=$id_pf?>">+ PICK UP DELIVERY</a>
										<?php } ?>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<h5><a><strong>SPECIAL ORDER REQUEST</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="<?=$borderColor?>">
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
																			<h4 class="text-bold text-green">Edit Special Order Request</h4>
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
																			<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																			<button type="submit" class="btn bg-green">Update</button>
																		</div>
																		</form>
																	</div>
																</div>
															</div>	
															<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#sor<?=$id_pf_sor?>"><span class="fa fa-edit"></a>	
															<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_sor&id=<?= $id_pf_sor ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
															
													<?php } ?>
													</td>
												</tr>
											<?php 
											$no_sor++; 
											}
										?>
										
									</table>
									<?php
										if(empty($hasil['aprove'])){
										?>
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
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="tambah_sor">
															<input type="hidden" name="id" value="<?=$id_pf?>">

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
										<a class="<?=$addBtnColor?>" data-toggle="modal" href="#sor_plus<?=$id_pf?>">+ SPECIAL ORDER</a>
									<?php } ?>
								</div>
								<div class="col-sm-6">
									<h5><a><strong>REAL CUSTOMER</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="<?=$borderColor?>">
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
																		<h4 class="text-bold text-green">Edit Real Customer</h4>
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
																		<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
																		<button type="submit" class="btn bg-green">Update</button>
																	</div>
																	</form>
																</div>
															</div>
														</div>
														<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#ru_edit<?=$id_real_user?>"><span class="fa fa-edit"></a>	
														<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_ru&id=<?= $id_real_user ?>&id_pf=<?= $id_pf ?>"><span class="fa fa-trash"></a>
												<?php } ?>
												</td>
											</tr>
										<?php 
											$no_ru++;
											}
										?>
									</table>
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
															<h4 class="text-bold text-green">Tambah Real Customer</h4>
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
															<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
															<button type="submit" class="btn bg-green">Tambah</button>
														</div>
														</form>
													</div>
												</div>
											</div>
											<a class="<?=$addBtnColor?>" data-toggle="modal" href="#ru_plus<?=$id_pf?>">+ REAL CUSTOMER</a>
										<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<div class="row">
							<div class="col-md-6 mb-3">
								<h5><a><strong>TABLE EST REVENUE</strong></a></h5>
								<table class="table table-hover table-responsive table-bordered">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
										<th>ACT</th>
									</tr>
								
									<?php
									$no_job=1;	
									$total_revenue=0;				
									$query2 = mysql_query("SELECT * FROM pf_revenue WHERE id_pf=$id_pf ORDER BY id_pf_revenue ASC");
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
										<td>
											<?php
												if(empty($hasil['aprove'])){
											?>
											<!-- Modal -->
											<div class="modal fade" id="revenue1<?=$id_pf_revenue?>" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content" style="color: black;">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal"></button>
															<h4 class="text-bold text-green">Edit Revenue</h4>
														</div>
														<form name="submit1" action="<?=$aksi?>" method="get">
														<div class="modal-body" >
															<input type="hidden" name="module" value="proforma">
															<input type="hidden" name="act" value="update_revenue">
															<input type="hidden" name="id" value="<?=$id_pf_revenue?>">
															<input type="hidden" name="id_pf" value="<?=$id_pf?>">
															<div class="form-group">
																<label>Type Revenue :</label>
																<select class="form-control" name="type_revenue">
																	<option value="<?=$hasil2['type_revenue']?>"><?=$hasil2['type_revenue']?></option>
																	<option value="ALL IN RATE">ALL IN RATE</option>
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
																<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control" value="<?=$hasil2['qty_revenue']?>">
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
											<a class="btn bg-blue btn-sm" data-toggle="modal" href="#revenue1<?=$id_pf_revenue?>"><span class="fa fa-edit"></a>	
											<a class="btn bg-red btn-sm" href="<?=$aksi?>?module=proforma&act=delete_revenue&id=<?=$id_pf_revenue?>&id_pf=<?=$id_pf?>"><span class="fa fa-trash"></a>
												<?php } ?>
										</td>
									</tr>

									<?php
										$no_job++; 
									}?>	
								</table>
								<?php
										if(empty($hasil['aprove'])) {
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
													<input type="hidden" name="module" value="proforma">
													<input type="hidden" name="act" value="tambah_revenue">
													<input type="hidden" name="id" value="<?=$id_pf?>">
													<input type="hidden" name="id_pf" value="<?=$id_pf?>">
													<div class="form-group">
														<label>Category :</label>
														<select class="form-control" name="type_revenue">
															<option value=""> - PILIH CATEGORY - </option>
															<option value="ALL IN RATE">ALL IN RATE</option>
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
														<label>Qty :</label>
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_revenue" class="form-control">
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn bg-gray text-red text-boldt" data-dismiss="modal">Close</button>
													<button type="submit1" class="btn bg-green">Tambah</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<a class="<?=$addBtnColor?>" data-toggle="modal" href="#revenue<?=$id_pf?>">TAMBAH REVENUE</a>	
									<?php } ?>
							</div>	

							<div class="col-md-6 mb-3">
								<h5><a><strong>TABLE EST COST</strong></a></h5>
								<table class="table table-hover table-responsive table-bordered">
									<tr class="bg-gray">
										<th>NO</th>
										<th>TYPE</th>
										<th>DESCRIPTION</th>
										<th>QTY</th>
										<th>RATE</th>
										<th>VALUE</th>
										<th>ACT</th>
									</tr>
									<?php
									$no_job2=1;	
									$total_est_cost=0;						
									$query3 = mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost asc");
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
															<h4 class="text-bold text-green">Edit Est Cost</h4>
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
											<a class="btn bg-blue btn-sm" data-toggle="modal" href="#est_cost<?=$id_pf_est_cost?>"><span class="fa fa-edit"></a>
											<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=proforma&act=delete_est_cost&id=<?=$id_pf_est_cost?>&id_pf=<?=$id_pf?>"><span class="fa fa-trash"></a>
												<?php } ?> 
										</td>
									</tr>	
									<?php
										$no_job2++; 
									}?>	
								</table>
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
													<h4 class="text-bold text-green">Tambah Est Cost</h4>
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
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="qty_est_cost" class="form-control">
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
													<button type="submit1" class="btn bg-green">Tambah</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<a class="<?=$addBtnColor?>" data-toggle="modal" href="#est_cost1<?=$id_pf?>">TAMBAH COST</a>
									<?php } ?>
							</div>	

						</div>
						<div class="row">
							<div class="col-md-6">
								<a><label>PROFIT/LOST EST COST</label></a>
								<table class="table table-striped">
									<tr class="bg-grey">
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
			</section>
		<?php break;
	}
}
?>
