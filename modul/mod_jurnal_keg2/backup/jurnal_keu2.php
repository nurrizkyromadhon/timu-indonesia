<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_jurnal_keg2/aksi_jurnal_keu2.php';
    switch ($_GET[act]) { 
		default: 
			// Menentukan tanggal awal bulan dan akhir bulan
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw_10 = date('Y-m-d h:i:s', strtotime('-1 month', strtotime($hari_ini)));
				$tgl_aw= date('Y-m-01', strtotime($hari_ini));
				$tgl_ak= date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str=date('01-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

			}else{
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
					$('#myTable2').dataTable();
				});
				$(function () {
				$(".select2").select2();
				});
				
			</script>
			<div class="wraper">
				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. JURNAL</li>
						<li class="active">Jurnal Keuangan</li>
					</ol>
				</section>
				
				<!-- Main content -->
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-default">
								<div class="row">
									<div class="col-md-6">
										<div class="box-header with-border">
											<h3 class="box-title"><b class="text-blue">JURNAL KEUANGAN JO</b></h3>
										</div>

										<div class="box-body">
											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBK'; ?>';" ><h3 class="text-red text-bold">BBK</h3></button>									
														<div class="info-box-content">
														<span class="info-box-text">Total BBK Bulan ini</span>
														<span class="info-box-number">xxx</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
													<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBM'; ?>';" ><h3 class="text-green text-bold">BBM</h3></button>
														<div class="info-box-content">
														<span class="info-box-text">Total BBM Bulan ini</span>
														<span class="info-box-number">xxx</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
													<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=HUT'; ?>';" ><h3 class="text-black text-bold">HUT</h3></button>
														<div class="info-box-content">	
															<span class="info-box-text">Saldo Hutang</span>
															<span class="info-box-number">xxx</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
													<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=PIUT'; ?>';" ><h3 class="text-yellow text-bold">PIUT</h3></button>
														<div class="info-box-content">	
															<span class="info-box-text">Saldo Piutang</span>
															<span class="info-box-number">xxx</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="box-header with-border">
											<h3 class="box-title"><b class="text-blue">JURNAL KEUANGAN NON JO</b></h3>
										</div>

										<div class="box-body">
											<div class="row">
												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBK'; ?>';" ><h3 class="text-blue text-bold">CASH</h3></button>									
														<div class="info-box-content">
															<span class="info-box-text">Total CASH Bulan ini</span>
															<span class="info-box-number">xxx</span>
														</div>
														<!-- /.info-box-content -->
													</div>
												<!-- /.info-box -->
												</div>
												<!-- /.col -->

												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
													<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBM'; ?>';" ><h3 class="text-black text-bold">HUT</h3></button>
														<div class="info-box-content">
															<span class="info-box-text">Saldo Hutang</span>
															<span class="info-box-number">xxx</span>
														</div>
														<!-- /.info-box-content -->
													</div>
													<!-- /.info-box -->
												</div>
												<!-- /.col -->

												<div class="col-md-6 col-sm-6 col-xs-12">
													<div class="info-box">
													<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BKK'; ?>';" ><h3 class="text-yellow text-bold">PIUT</h3></button>
														<div class="info-box-content">
															<span class="info-box-text">Saldo Piutang</span>
															<span class="info-box-number">xxx</span>
														</div>
														<!-- /.info-box-content -->
													</div>
													<!-- /.info-box -->
												</div>
												<!-- /.col -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold mt-15">KEGIATAN KEUANGAN</h3>
							<div class="pull-right">
								<a href="<?=$aksi?>?module=jurnal_keu2&act=excel"><button type="button" class="btn bg-gray text-blue text-bold"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>

						<div class="box-header with-border row">
							<div class="col-md-6">
								<h3 class="box-title"><b class="text-blue">Tabel Kegiatan Keuangan</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
							</div>
							<div class="col-md-6">
								<form name="submit" action="?module=jurnal_keu2" method="POST">
									<div class="col-md-1"></div>
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
										<button class="pull-right btn bg-gray text-blue text-bold" type="submit">OK</button>
									</div>
								</form>
							</div>
						</div>

						<div class="box-body">
							<div class="row">
								<div class="tabel-responsive">
									<div class="col-md-12">
									<table id="myTable" class="table table-bordered table-hover">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>NO REFF</th>
												<th>NO INVOICE</th>
												<th>JO NUMBER</th>
												<th>TYPE</th>
												<th>DESCRIPTION</th>
												<th>KATEGORY</th>
												<th>KEGIATAN</th>
												<th>STAKEHOLDER</th>
												<th>BUKTI</th>
												<th>VALUE</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("SELECT * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
												order by id_pf_real_cost desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
													$id_pf_real_cost=$hasil4['id_pf_real_cost'];
													$id_est_cost=$hasil4['id_est_cost'];
													$id_revenue=$hasil4['id_revenue'];
													$id_pf=$hasil4['id_pf'];
													
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_real_cost']?></td>
												<td><?=$hasil4['no_reff_keu']?></td>
												<td><?=$hasil4['no_invoice']?></td>
												<td><?=$hasil4['no_jo']?></td>

												<?php
												if(!empty($id_est_cost)){
												?>
													<td><?=$hasil4['type_est_cost']?></td>
													<td><?=$hasil4['desc_est_cost']?></td>
												<?php }else{ ?>
													<td><?=$hasil4['type_revenue']?> <?=$hasil4['type2_revenue']?></td>
													<td><?=$hasil4['desc_revenue']?></td>	
												<?php } ?>	
												<td><?=$hasil4['category1']?></td>
												<td><?=$hasil4['kegiatan']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td><?=$hasil4['bukti']?></td>
												<td><?=number_format($hasil4['real_cost'])?></td>
												
												
												<td>
													<!-- Modal -->
													<div class="modal fade" id="jurnal_keu2<?=$id_pf_real_cost?>" role="dialog">
														<div class="modal-dialog modal-lg">
															<!-- Modal content-->
															<div class="modal-content" style="color: black;">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal"></button>
																	<h3>Edit Jurnal Keuangan</h3>
																</div>
																<form name="submit1" action="<?=$aksi?>" method="get">
																<div class="modal-body" >
																	<div class="form-group">
																		<input type="hidden" name="module" value="jurnal_keu2">
																		<input type="hidden" name="act" value="update_rc">
																		<input type="hidden" name="id" value="<?=$id_pf_real_cost?>">
																		<input type="hidden" name="id_pf" value="<?=$id_pf?>">

																		<label>DATE :</label><br>
																		<input type="date" class="form-control" name="tgl_pf_real_cost" value="<?=$hasil4['tgl_pf_real_cost']?>" >
																	</div>
																	<br>
																	<div class="form-group">
																		<label>REFF :</label><br>
																		<input type="text" class="form-control" name="no_reff_keu" class="form-control" value="<?=$hasil4['no_reff_keu']?>">
																	</div>
																	<br>
																	<div class="form-group">
																		<label>JOB NUMBER :</label><br>
																		<?php
																		if(!empty($id_est_cost)){
																		?>
																		<input type="text" class="form-control" value="<?=$hasil4['no_jo']?> | <?=$hasil4['type_est_cost']?> | <?=$hasil4['desc_est_cost']?> | <?=number_format($hasil4['est_cost'])?>" size="100" readonly>
																		<?php }else{ ?>
																		
																		<input type="text" class="form-control" value="<?=$hasil4['no_jo']?> | <?=$hasil4['type2_revenue']?> | <?=$hasil4['desc_revenue']?> | <?=number_format($hasil4['revenue'])?>" size="100" readonly>	
																		<?php
																		} ?>
																		
																		<!--<select class="form-control" name="id_est_cost">
																		<option value="<?=$hasil4['id_est_cost']?>"><?=$no?>. <?=$hasil4['no_jo']?> | <?=$hasil4['type_est_cost']?> | <?=$hasil4['desc_est_cost']?> | <?=number_format($hasil4['est_cost'])?></option>-->
																		<?php
																		/*	$no=1;
																			$qry=mysql_query("select * from pf_est_cost as pec join pf on pec.id_pf=pf.id_pf where cek_est_cost='0' and no_jo!=''  order by no_jo asc");                            
																			while($hasil=mysql_fetch_array($qry)){
																				$no_jo=$hasil['no_jo'];
																				$cust_name=$hasil['cust_name'];
																				$type_est_cost=$hasil['type_est_cost'];
																				$desc_est_cost=$hasil['desc_est_cost'];
																				$est_cost=$hasil['est_cost'];
																				$qty_est_cost=$hasil['qty_est_cost'];
																				$jml_est_cost=$est_cost*$qty_est_cost;*/
																				
																		?>
																		<!--	<option value="<?=$hasil['id_est_cost']?>"><?=$no?>. <?=$hasil['no_jo']?> | <?=$type_est_cost?> | <?=$desc_est_cost?> | <?=number_format($est_cost)?></option>-->
																			<?php// $no++; } ?>	
																		</select>
																	</div>
																	<br>
																	
																	<div class="form-group">
																		<label>CATEGORY :</label><br>
																		<select class="form-control" name="category1">
																			<option value="<?=$hasil4['category1']?>"><?=$hasil4['category1']?></option>
																			<option value="OP KAS">OP KAS</option>
																			<option value="OP AP">OP AP</option>
																			<option value="OP AR">OP AR</option>
																			<option value="OVERHEAD">OVERHEAD</option>
																			<option value="MUTASI">MUTASI</option>
																			<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
																			<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
																			<option value="HUTANG USAHA">HUTANG USAHA</option>
																			<option value="HUTANG LAIN">HUTANG LAIN</option>
																			<option value="PIUTANG">PIUTANG</option>
																			<option value="PIUTANG LAIN">PIUTANG LAIN</option>
																			<option value="PENJUALAN">PENJUALAN</option>
																		</select>
																	</div>
																	
																	<br>

																	<div class="form-group">
																		<label>KEGIATAN</label><br>
																		<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan" value="<?=$hasil4['kegiatan']?>" class="form-control" size="100" >
																	</div><br>
																	<div class="form-group">
																	<label>STAKE HOLDER:</label><br>
																	<select class="form-control" name="stakeholder">
																		<option value="">-SELECT STAKE HOLDER-</option>
																		<option><b>VENDOR</b></option>
																		<?php 
																		$nov=1;
																			$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
																			while($hslv=mysql_fetch_array($qryv)){
																		?>
																		<option value="<?=$hslv['nm_vendor']?>"><?=$nov?>. <?=$hslv['nm_vendor']?></option>
																		<?php $nov++; } ?>
																		<option><b>REAL CUSTOMER</b></option>
																		<?php 
																		$nov=1;
																			$qryv=mysql_query("select * from data_cust order by nm_cust asc");
																			while($hslv=mysql_fetch_array($qryv)){
																		?>
																		<option value="<?=$hslv['nm_cust']?>"><?=$nov?>. <?=$hslv['nm_cust']?></option>
																		<?php $nov++; } ?>
																		<option><b>CUSTOMER</b></option>
																		<?php 
																		$nov=1;
																			$qryv=mysql_query("select * from pf group by cust_name");
																			while($hslv=mysql_fetch_array($qryv)){
																		?>
																		<option value="<?=$hslv['cust_name']?>"><?=$nov?>. <?=$hslv['cust_name']?></option>
																		<?php $nov++; } ?>
																			
																	</select>
																	</div>
																	<br>
																	<div class="form-group">
																		<label>BUKTI :</label><br>
																		<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti" value="<?=$hasil4['bukti']?>" class="form-control">
																	</div>
																	<br>
																	<div class="form-group">
																		<label>Real Cost :</label><br>
																		<input type="text" name="real_cost" class="form-control" value="<?=$hasil4['real_cost']?>">
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
													<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#jurnal_keu2<?=$id_pf_real_cost?>"><span class="fa fa-edit"></a>	
													<a class="btn bg-gray text-red btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=delete_pf_real_cost&id=<?=$id_pf_real_cost?>&id_est_cost=<?=$id_est_cost?>" onclick="return confirm('Sudah Yakin Mau di Hapus')">
														<span class="fa fa-trash">
													</a>
													<a class="btn bg-gray text-blue btn-sm" onclick="location.href='<?php echo '?module=jurnal_keu2&act=tambah_image&id='.$id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
											</tr>
											<?php $no_real_cost++; } ?>	
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>	
			</div>
		<?php 
		break;
		case 'BBK':
			$bulan=date('n');
			$type="BBK";
			$date=date('ym');
			$query=mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BBK%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],7);
			$bulankemaren=substr($hasil['no_reff_keu'],5,2);
			$bulanini=date('m');

			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";
				
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
					$('#myTable2').dataTable();
				});
			</script>

			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
					<li class="active">Form Input BBK</li>
				</ol>
			</section>
		
			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">FORM INPUT BBK</h3>
						
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?=$aksi?>?module=jurnal_keu2&act=tambah_jurnal_keu2" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_jurnal_keu2">
											<input type="hidden" name="act2" value="BBK">
											<input type="hidden" name="dk" value="K">
											<label>BBK NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
										</div>
									</div>
								</div>

								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-lg-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-lg-1">	
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_est_cost0" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-lg-1">
											<label>TYPE :</label>
											<select class="form-control" name="category1[]">
												<option value="OP CASH">OP CASH</option>
												<option value="HUTANG">HUTANG</option>
											</select>
										</div>
										<div class="col-lg-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-lg-2">
											<label>VENDOR :</label>
											<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
											<datalist id="data">
												<?php 
												$nov=1;
													$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
													while($hslv=mysql_fetch_array($qryv)){
												?>
												<option value="<?=$hslv['nm_vendor']?>">
												<?php $nov++; } ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php 
												$nov=1;
													$qryv=mysql_query("select * from data_cust order by nm_cust asc");
													while($hslv=mysql_fetch_array($qryv)){
												?>
												<option value="<?=$hslv['nm_cust']?>">
												<?php $nov++; } ?>
												<option><b>CUSTOMER</b></option>
												<?php 
												$nov=1;
													$qryv=mysql_query("select * from pf group by cust_name");
													while($hslv=mysql_fetch_array($qryv)){
												?>
												<option value="<?=$hslv['cust_name']?>">
												<?php $nov++; } ?>
													
											</datalist>
										</div>
										<div class="col-lg-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-lg-2">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
													$query4=mysql_query("SELECT * from bank");
													while($hasil4=mysql_fetch_array($query4)){
												?>
													<option name="name_real_user" value="<?=$hasil4['nama_bank']?>"><?=$hasil4['nama_bank']?></option>
													<?php } ?>	
											</select>
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>
								
								<script type='text/javascript'>
									var bbkRow = 1;
									function addMore() {
										$("#product").append(`
											<div class="mt-15 product-item row bbk-${bbkRow}">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(${bbkRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_est_cost${bbkRow}" name="id_pf_est_cost[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-sm-1">
													<select class="form-control" name="category1[]">
														<option value="OP CASH">OP CASH</option>
														<option value="OP AP">OP AP</option>
													</select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
													<datalist id="data">
														<option>VENDOR</option>
														<?php
															$nov=1;
															$qryv=mysql_query("SELECT * from data_vendor order by nm_vendor asc");
															while($hslv=mysql_fetch_array($qryv)){?>
																<option value="<?=$hslv['nm_vendor']?>"><?php $nov++; 
															} ?>
																<option>REAL CUSTOMER</option>
														<?php
															$nov=1;
															$qryv=mysql_query("SELECT * from data_cust order by nm_cust asc");
															while($hslv=mysql_fetch_array($qryv)){?>
																<option value="<?=$hslv['nm_cust']?>">
																<?php $nov++;
															} ?>
																<option>CUSTOMER</option>
															<?php
															$nov=1;
															$qryv=mysql_query("SELECT * from pf group by cust_name asc");
															while($hslv=mysql_fetch_array($qryv)){?>
																<option value="<?=$hslv['cust_name']?>"><?php $nov++; 
															} ?>
													</datalist>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>
												<div class="col-sm-1">
													<select class="form-control" name="bank[]" required>
														<option value="">Pilih</option>
														<?php
															$query4=mysql_query("SELECT * from bank");
															while($hasil4=mysql_fetch_array($query4)){
														?>
															<option name="name_real_user" value="<?=$hasil4['nama_bank']?>"><?=$hasil4['nama_bank']?></option>
															<?php } ?>	
													</select>
												</div>
												<div class="col-sm-1">
													<input class="mt-1" type="file" name="nm_file${bbkRow}[]" multiple>
												</div>
											</div>
										`);
										bbkRow++;
									}
									$(function () {
									$(".select").select2();
									$("#select").select2();
									})


									function deleteRow() {
										if (bbkRow > 1) {
											$(`.bbk-${bbkRow - 1}`).remove();
											bbkRow--;
										}
									}
									function openwindow(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open("modul/mod_jurnal_keg/tabel_est_cost.php?idrow="+idrow,"",features);
									}
								</script>
							
								<div class="btn-action float-clear" align="center">	
									<input class="btn bg-gray text-bold text-blue" type="button" name="add_item" value="+" onClick="addMore();" />
									<input class="btn bg-gray text-bold text-red" type="button" name="del_item" value="-" onClick="deleteRow();" />
								</div>
								
								<div class="box-footer">
									<button type="submit1" class="btn bg-blue text-bold pull-right">SUBMIT</button>
								</div>
							</div>	
						</div>						
					</form>
				</div>

				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Proforma</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=BBK" method="POST">
								<div class="col-md-1"></div>
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
									<button class="pull-right btn bg-gray btn-md text-blue" type="submit"><b>OK</b></button>
								</div>
							</form>
						</div>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="tabel-responsive">
								<div class="col-md-12">
								<table id="myTable2" class="table table-striped table-bordered">
									<thead class="bg-blue">
										<tr>
											<th>NO</th>
											<th>DATE</th>
											<th>NO REFF</th>
											<th>JO NUMBER</th>
											<th>TYPE</th>
											<th>KATEGORY</th>
											<th>KEGIATAN</th>
											<th></th>
											<th>STAKEHOLDER</th>
											<th>BUKTI</th>
											<th>VALUE</th>
											<th>BANK</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$no_real_cost=1;
											$query4=mysql_query("SELECT * from pf_real_cost as rc
											left join pf on rc.id_pf=pf.id_pf 
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like 'BBK%'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
												$id_pf_real_cost=$hasil4['id_pf_real_cost'];
										?>
										<tr>
											<td><?=$no_real_cost?></td>
											<td><?=$hasil4['tgl_pf_real_cost']?></td>
											<td><?=$hasil4['no_reff_keu']?></td>
											<td>
												<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>
												<?=$hslrc['no_jo']?><br>
												<?php } ?>
											</td>

											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												join pf on rc.id_pf=pf.id_pf 
												left join pf_est_cost as ec on rc.id_pf=ec.id_pf
												where no_reff_keu='$hasil4[no_reff_keu]'group by id_est_cost
												");
												while ($hslrc=mysql_fetch_array($rc)){
													$ec=mysql_query("select * from pf_est_cost where id_pf_est_cost='$hslrc[id_est_cost]'");
													$hslec=mysql_fetch_array($ec);
												?>	
												<?=$hslec['type_est_cost']?><br>
												<?php } ?>
											</td>
											<td>

											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=$hslrc['category1']?><br>
												<?php } ?>
											</td>
											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>
												<?=$hslrc['kegiatan']?><br>
												<?php } ?>
											</td>
											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=$hslrc['desc_est_cost']?><br>
												<?php } ?>
											</td>
											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=$hslrc['stakeholder']?><br>
												<?php } ?>
											</td>
											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=$hslrc['bukti']?><br>
												<?php } ?>
											</td>
											<td>
											<?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=number_format($hslrc['real_cost'])?><br>
												<?php } ?>
											</td>
											<td><?php
												$rc=mysql_query("select * from pf_real_cost as rc
												left join pf on rc.id_pf=pf.id_pf 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
												while ($hslrc=mysql_fetch_array($rc)){
												?>	
												<?=$hslrc['bank']?><br>
												<?php } ?>
											</td>
											<td>
												<a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&reff=<?=$type?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
											</td>
										</tr>
										<?php $no_real_cost++; } ?>	
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
		case 'BBM':
			$bulan=date('n');
			$type="BBM";
			$date=date('ym');
			$query=mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BBM%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],7);
			$bulankemaren=substr($hasil['no_reff_keu'],5,2);
			$bulanini=date('m');
	
			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";

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
						$('#myTable2').dataTable();
					});
				</script>

				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
						<li class="active">Form Input BBM</li>
					</ol>
				</section>
			
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">FORM INPUT BBM</h3>
							
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<form name="submit1" action="<?=$aksi?>" method="GET">
							<div class="box-body">
								<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="hidden" name="module" value="jurnal_keu2">
												<input type="hidden" name="act" value="tambah_jurnal_keu2">
												<input type="hidden" name="act2" value="BBM">
												<input type="hidden" name="dk" value="D">
												<label>BBM NUMBER :</label>
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>"  readonly>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>DATE :</label>
												<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
											</div>
										</div>
									</div>
												
									<div class="form-group" id="product">
										<div class="row">
											<div class="col-sm-1 w-content">
												<label>JO :</label>
												<br>
												<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(1)"><span class="fa fa-search"></button>
											</div>
											<div class="col-sm-1">	
												<label>JO NUMBER</label>
												<input type="text" class="form-control" id="id_pf_revenue1" name="id_pf_revenue[]" placeholder="Job Order " readonly>
											</div>
											<div class="col-sm-1">
												<label>TYPE :</label>
												<input class="form-control" list="data" name="category1[]" id="pilih" placeholder="Searching Kategori ......">
												<datalist id="data">
													<option value="OP AR">OP AR</option>
													<option value="PIUTANG">PIUTANG</option>
													<option value="MUTASI">MUTASI</option>
													<option value="X">X</option>
													<option value="HUTANG LAIN">HUTANG LAIN</option>
													<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
													<?php
													$qry_inv=mysql_query("select * from pf_invoice group by no_invoice order by no_invoice asc");
													while($hsl_inv=mysql_fetch_array($qry_inv)){$no_inv=$hsl_inv['no_invoice'];$id_inv=$hsl_inv['id_pf_invoice'];	
													?>
													<option value="<?=$no_inv?>"><?=$no_inv?></option>
													<?php	
													}
													?>
												</datalist>
											</div>
											<div class="col-sm-2">
												<label>KEGIATAN :</label>
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
											</div>
											<div class="col-sm-2">
												<label>VENDOR :</label>
												<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
												<datalist id="data">
													<option><b>VENDOR</b></option>
													<?php 
													$nov=1;
														$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
														while($hslv=mysql_fetch_array($qryv)){
													?>
													<option value="<?=$hslv['nm_vendor']?>">
													<?php $nov++; } ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php 
													$nov=1;
														$qryv=mysql_query("select * from data_cust order by nm_cust asc");
														while($hslv=mysql_fetch_array($qryv)){
													?>
													<option value="<?=$hslv['nm_cust']?>">
													<?php $nov++; } ?>
													<option><b>CUSTOMER</b></option>
													<?php 
													$nov=1;
														$qryv=mysql_query("select * from pf group by cust_name");
														while($hslv=mysql_fetch_array($qryv)){
													?>
													<option value="<?=$hslv['cust_name']?>">
													<?php $nov++; } ?>
														
												</datalist>
											</div>
											<div class="col-sm-1">
												<label>BUKTI :</label>
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
											</div>
											<div class="col-sm-2">
												<label>COST :</label>
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
											</div>
											<div class="col-lg-1">
												<label>BANK :</label>
												<select class="form-control" name="bank[]" required>
													<option value="">Pilih</option>
													<?php
														$query4=mysql_query("SELECT * from bank");
														while($hasil4=mysql_fetch_array($query4)){
													?>
														<option name="name_real_user" value="<?=$hasil4['nama_bank']?>"><?=$hasil4['nama_bank']?></option>
														<?php } ?>	
												</select>
											</div>
											<div class="col-lg-1">
												<label>FILE :</label>
												<input class="mt-1" type="file" name="nm_file0[]" multiple>
											</div>
										</div>
									</div>
									<script type='text/javascript'>
										var idrow = 1;
										function addMore() {
											idrow++;
											$("#product").append('<div class="box-body"><div class="product-item form-group"><div class="col-sm-1"><button type="button" class="btn btn-danger pull-right" onclick="openwindow('+idrow+')"><span class="fa fa-search"></button></div><div class="col-sm-1"><input type="text" class="form-control" id="id_pf_revenue'+idrow+'" name="id_pf_revenue[]" placeholder="Job Order" readonly></div><div class="col-sm-2"><input class="form-control" list="data" name="category1[]" id="pilih" placeholder="Searching Kategori ......"><datalist id="data"><option value="OP AR">OP AR</option><option value="PIUTANG">PIUTANG</option><option value="MUTASI">MUTASI</option><option value="X">X</option><option value="HUTANG LAIN">HUTANG LAIN</option><option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option><?php $qry_inv=mysql_query("select * from pf_invoice group by no_invoice order by no_invoice");while($hsl_inv=mysql_fetch_array($qry_inv)){$no_inv=$hsl_inv['no_invoice'];$id_inv=$hsl_inv['id_pf_invoice'];?><option value="<?=$no_inv?>"><?=$no_inv?></option><?php } ?></datalist></div><div class="col-sm-3"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control"></div><div class="col-sm-2"><input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching ....."><datalist id="data"><option>VENDOR</option><?php $nov=1;$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_vendor']?>"><?php $nov++; } ?> <option>REAL CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from data_cust order by nm_cust asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_cust']?>"><?php $nov++; } ?><option>CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from pf group by cust_name asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['cust_name']?>"><?php $nov++; } ?></datalist></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control"></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control"></div><div class="col-sm-1"><input type="checkbox" class="pull-center" name="item_index[]" ></div></div></div>');				
											$(function () { $(".select".idrow).select2()});
										}
										$(function () {
										$(".select").select2();
										})
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
											var popup = window.open("modul/mod_jurnal_keg/tabel_revenue.php?idrow="+idrow,"",features);
										}
									</script>
								
									<div class="btn-action float-clear" align="center">	
										<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
										<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
									</div>
									
									<div class="box-footer">
										<button type="submit1" class="btn btn-success pull-right">SUBMIT</button>
									</div>
								</div>
							</div>							
						</form>
				</section>	
	
				<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
								<div class="box-tools pull-right">
							
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
							</div>

							<div class="box-header with-border row">
								<div class="col-md-6">
									<h3 class="box-title"><b class="text-blue">Tabel Proforma</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
								</div>
								<div class="col-md-6">
									<form name="submit" action="?module=jurnal_keu2&act=BBM" method="POST">
										<div class="col-md-1"></div>
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
											<button class="pull-right btn bg-gray btn-md text-blue" type="submit"><b>OK</b></button>
										</div>
									</form>
								</div>
							</div>
	
							<div class="box-body">
								<div class="row">
									<div class="tabel-responsive">
										<div class="col-md-12">
										<table id="myTable2" class="table table-striped table-bordered">
											<thead class="bg-blue">
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>DESCRIPTION</th>
													<th>TYPE</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>BANK</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost=1;
													$query4=mysql_query("SELECT * from pf_real_cost as rc
													left join pf on rc.id_pf=pf.id_pf 
													left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
													where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
													no_reff_keu like 'BBM%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
													while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
														$id_pf_real_cost=$hasil4['id_pf_real_cost'];
												?>
												<tr>
													<td><?=$no_real_cost?></td>
													<td><?=$hasil4['tgl_pf_real_cost']?></td>
													<td><?=$hasil4['no_reff_keu']?></td>
													<td>
														<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['no_jo']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														left join pf_revenue as ec on rc.id_pf=ec.id_pf
														where no_reff_keu='$hasil4[no_reff_keu]'group by id_revenue
														");
														while ($hslrc=mysql_fetch_array($rc)){
															$ec=mysql_query("select * from pf_revenue where id_pf_revenue='$hslrc[id_revenue]'");
															$hslec=mysql_fetch_array($ec);
														?>	
														<?=$hslec['desc_revenue']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['category1']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['kegiatan']?><br>
														<?php } ?>
													</td>
													
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['stakeholder']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bukti']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=number_format($hslrc['real_cost'])?><br>
														<?php } ?>
													</td>
													<td><?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bank']?><br>
														<?php } ?>
													</td>
													<td>	
														<a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&reff=<?=$type?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
												<?php $no_real_cost++; } ?>	
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						$(document).ready(function(){
								$('#myTable2').dataTable();
						</script>
					</section>				
	
			<?php	
		break;			
		case 'BKK':
			$bulan=date('n');
			$type="BKK";
			$date=date('ym');
			$query=mysql_query("select * from pf_real_cost where  no_reff_keu like 'BKK%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],7);
			$bulankemaren=substr($hasil['no_reff_keu'],5,2);
			$bulanini=date('m');
	
			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";
			?>
	
				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
						<li class="active">Form Input BKK</li>
					</ol>
				</section>
			
				<!-- Main content -->
				<section class="content">
			
				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">FORM INPUT BKK</h3>
							
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<!-- /.box-header -->
						<form name="submit1" action="<?=$aksi?>" method="GET">
						<div class="box-body">
						
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<input type="hidden" name="module" value="jurnal_keu2">
									<input type="hidden" name="act" value="tambah_jurnal_keu2">
									<input type="hidden" name="act2" value="BKK">
									<input type="hidden" name="dk" value="K">
									<label>BKK NUMBER :</label>
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>"  readonly>
								</div>
								<div class="form-group">
									<label>DATE :</label>
									<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
	
						<div class="box-body">
							<div class="product-item form-group">
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
								</div>
								<div class="col-sm-1">	
									<input type="text" class="form-control" id="id_pf_est_cost1" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
								</div>
								<div class="col-sm-2">
									<select class="form-control" name="category1[]">
										<option value="OP KAS">OP KAS</option>
										<option value="OVERHEAD">OVERHEAD</option>
										<option value="MUTASI">MUTASI</option>
										<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
									</select>
								</div>
								<div class="col-sm-3">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
								</div>
								<div class="col-sm-2">
								<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
								<datalist id="data">
									<option><b>VENDOR</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_vendor']?>">
									<?php $nov++; } ?>
									<option><b>REAL CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_cust order by nm_cust asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_cust']?>">
									<?php $nov++; } ?>
									<option><b>CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from pf group by cust_name");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['cust_name']?>">
									<?php $nov++; } ?>
										
								</datalist>
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
								</div>
								<div class="col-sm-1">
									<input type="checkbox" class="pull-left" name="item_index[]" >
								</div>
							</div>
						</div>		
							<div id='product'></div>
							<script type='text/javascript'>
								var idrow = 1;
								function addMore() {
									idrow++;
									$("#product").append('<div class="box-body"><div class="product-item form-group"><div class="col-sm-1"><button type="button" class="btn btn-danger pull-right" onclick="openwindow('+idrow+')"><span class="fa fa-search"></button></div><div class="col-sm-1"><input type="text" class="form-control" id="id_pf_est_cost'+idrow+'" name="id_pf_est_cost[]" placeholder="Job Order" readonly></div><div class="col-sm-2"><select class="form-control" name="category1[]"><option value="OP KAS">OP KAS</option><option value="OVERHEAD">OVERHEAD</option><option value="MUTASI">MUTASI</option><option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option></select></div><div class="col-sm-3"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control"></div><div class="col-sm-2"><input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching ....."><datalist id="data"><option>VENDOR</option><?php $nov=1;$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_vendor']?>"><?php $nov++; } ?> <option>REAL CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from data_cust order by nm_cust asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_cust']?>"><?php $nov++; } ?><option>CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from pf group by cust_name asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['cust_name']?>"><?php $nov++; } ?></datalist></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control"></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control"></div><div class="col-sm-1"><input type="checkbox" class="pull-center" name="item_index[]" ></div></div></div>');				
									
								}
								$(function () {
								$(".select").select2();
								})
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
									var popup = window.open("modul/mod_jurnal_keg/tabel_est_cost.php?idrow="+idrow,"",features);
								}
							</script>
						
							<div class="btn-action float-clear" align="center">	
								<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
								<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
							</div>
							
							<div class="box-footer">
								<button type="submit1" class="btn btn-success pull-right">SUBMIT</button>
							</div>
						</div>							
						</form>
				</section>	
	
				<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
								<div class="box-tools pull-right">
							
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
							</div>
	
							<div class="box-body">
								<div class="row">
									<div class="tabel-responsive">
										<div class="col-md-12">
										<table id="myTable2" class="table table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>DESCRIPTION</th>
													<th>KATEGORY</th>
													<th>KEGIATAN</th>
													<th></th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost=1;
													$query4=mysql_query("select * from pf_real_cost as rc
													left join pf on rc.id_pf=pf.id_pf 
													left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
													where no_reff_keu like 'BKK%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
													while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
														$id_pf_real_cost=$hasil4['id_pf_real_cost'];
												?>
												<tr>
													<td><?=$no_real_cost?></td>
													<td><?=$hasil4['tgl_pf_real_cost']?></td>
													<td><?=$hasil4['no_reff_keu']?></td>
													<td>
														<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['no_jo']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														left join pf_est_cost as ec on rc.id_pf=ec.id_pf
														where no_reff_keu='$hasil4[no_reff_keu]'group by id_est_cost
														");
														while ($hslrc=mysql_fetch_array($rc)){
															$ec=mysql_query("select * from pf_est_cost where id_pf_est_cost='$hslrc[id_est_cost]'");
															$hslec=mysql_fetch_array($ec);
														?>	
														<?=$hslec['type_est_cost']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['category1']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['kegiatan']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['desc_est_cost']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['stakeholder']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bukti']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=number_format($hslrc['real_cost'])?><br>
														<?php } ?>
													</td>
													<td>	
														<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
												<?php $no_real_cost++; } ?>	
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						$(document).ready(function(){
								$('#myTable2').dataTable();
						</script>
					</section>				
	
			<?php	
		break;	
		case 'BKM':
			$bulan=date('n');
			$type="BKM";
			$date=date('ym');
			$query=mysql_query("select * from pf_real_cost where  no_reff_keu like 'BKM%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],7);
			$bulankemaren=substr($hasil['no_reff_keu'],5,2);
			$bulanini=date('m');
	
			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";
			?>
	
				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
						<li class="active">Form Input BKM</li>
					</ol>
				</section>
			
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">FORM INPUT BKM</h3>
							
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<form name="submit1" action="<?=$aksi?>" method="GET">
						<div class="box-body">
						
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<input type="hidden" name="module" value="jurnal_keu2">
									<input type="hidden" name="act" value="tambah_jurnal_keu2">
									<input type="hidden" name="act2" value="BKM">
									<input type="hidden" name="dk" value="D">
									<label>BKM NUMBER :</label>
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>"  readonly>
								</div>
								<div class="form-group">
									<label>DATE :</label>
									<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
	
						<div class="box-body">
							<div class="product-item form-group">
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
								</div>
								<div class="col-sm-1">	
									<input type="text" class="form-control" id="id_pf_revenue1" name="id_pf_revenue[]" placeholder="Job Order " readonly>
								</div>
								<div class="col-sm-2">
									<select class="form-control" name="category1[]">
										<option value="OP AR">OP AR</option>
										<option value="PIUTANG">PIUTANG</option>
										<option value="MUTASI">MUTASI</option>
										<option value="HUTANG LAIN">HUTANG LAIN</option>
										<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
									</select>
								</div>
								<div class="col-sm-3">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
								</div>
								<div class="col-sm-2">
								<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
								<datalist id="data">
									<option><b>VENDOR</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_vendor']?>">
									<?php $nov++; } ?>
									<option><b>REAL CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_cust order by nm_cust asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_cust']?>">
									<?php $nov++; } ?>
									<option><b>CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from pf group by cust_name");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['cust_name']?>">
									<?php $nov++; } ?>
										
								</datalist>
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
								</div>
								<div class="col-sm-1">
									<input type="checkbox" class="pull-left" name="item_index[]" >
								</div>
							</div>
						</div>		
							<div id='product'></div>
							<script type='text/javascript'>
								var idrow = 1;
								function addMore() {
									idrow++;
									$("#product").append('<div class="box-body"><div class="product-item form-group"><div class="col-sm-1"><button type="button" class="btn btn-danger pull-right" onclick="openwindow('+idrow+')"><span class="fa fa-search"></button></div><div class="col-sm-1"><input type="text" class="form-control" id="id_pf_revenue'+idrow+'" name="id_pf_revenue[]" placeholder="Job Order" readonly></div><div class="col-sm-2"><select class="form-control" name="category1[]"><option value="OP AR">OP AR</option><option value="PIUTANG">PIUTANG</option><option value="MUTASI">MUTASI</option><option value="HUTANG LAIN">HUTANG LAIN</option><option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option></select></div><div class="col-sm-3"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control"></div><div class="col-sm-2"><input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching ....."><datalist id="data"><option>VENDOR</option><?php $nov=1;$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_vendor']?>"><?php $nov++; } ?> <option>REAL CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from data_cust order by nm_cust asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_cust']?>"><?php $nov++; } ?><option>CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from pf group by cust_name asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['cust_name']?>"><?php $nov++; } ?></datalist></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control"></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control"></div><div class="col-sm-1"><input type="checkbox" class="pull-center" name="item_index[]" ></div></div></div>');				
									
								}
								$(function () {
								$(".select").select2();
								})
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
									var popup = window.open("modul/mod_jurnal_keg/tabel_revenue.php?idrow="+idrow,"",features);
								}
							</script>
						
							<div class="btn-action float-clear" align="center">	
								<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
								<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
							</div>
							
							<div class="box-footer">
								<button type="submit1" class="btn btn-success pull-right">SUBMIT</button>
							</div>
						</div>							
						</form>
				</section>	
	
				<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
								<div class="box-tools pull-right">
							
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
							</div>
	
							<div class="box-body">
								<div class="row">
									<div class="tabel-responsive">
										<div class="col-md-12">
										<table id="myTable2" class="table table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>DESCRIPTION</th>
													<th>KATEGORY</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost=1;
													$query4=mysql_query("select * from pf_real_cost as rc
													left join pf on rc.id_pf=pf.id_pf 
													left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
													
													where no_reff_keu like 'BKM%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
													while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
														$id_pf_real_cost=$hasil4['id_pf_real_cost'];
												?>
												<tr>
													<td><?=$no_real_cost?></td>
													<td><?=$hasil4['tgl_pf_real_cost']?></td>
													<td><?=$hasil4['no_reff_keu']?></td>
													<td>
														<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['no_jo']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														left join pf_revenue as ec on rc.id_pf=ec.id_pf
														where no_reff_keu='$hasil4[no_reff_keu]'group by id_revenue
														");
														while ($hslrc=mysql_fetch_array($rc)){
															$ec=mysql_query("select * from pf_revenue where id_pf_revenue='$hslrc[id_revenue]'");
															$hslec=mysql_fetch_array($ec);
														?>	
														<?=$hslec['desc_revenue']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['category1']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['kegiatan']?><br>
														<?php } ?>
													</td>
													
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['stakeholder']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bukti']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														left join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=number_format($hslrc['real_cost'])?><br>
														<?php } ?>
													</td>
													<td>	
														<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&reff=<?=$type?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
												<?php $no_real_cost++; } ?>	
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						$(document).ready(function(){
								$('#myTable2').dataTable();
						</script>
					</section>				
	
			<?php	
		break;
		case 'HUT':
			$bulan=date('n');
			$type="HUT";
			$date=date('ym');
			$query=mysql_query("select * from pf_real_cost where  no_reff_keu like 'HUT%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],7);
			$bulankemaren=substr($hasil['no_reff_keu'],5,2);
			$bulanini=date('m');
	
			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";
			?>
	
				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
						<li class="active">Form Input HUTANG</li>
					</ol>
				</section>
			
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">FORM INPUT HUTANG</h3>
							
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<form name="submit1" action="<?=$aksi?>" method="GET">
						<div class="box-body">
						
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<input type="hidden" name="module" value="jurnal_keu2">
									<input type="hidden" name="act" value="tambah_jurnal_keu2">
									<input type="hidden" name="act2" value="HUT">
									<input type="hidden" name="dk" value="D">
									<label>HUT NUMBER :</label>
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>"  readonly>
								</div>
								<div class="form-group">
									<label>DATE :</label>
									<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
	
						<div class="box-body">
							<div class="product-item form-group">
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
								</div>
								<div class="col-sm-1">	
									<input type="text" class="form-control" id="id_pf_est_cost1" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
								</div>
								<div class="col-sm-2">
									<select class="form-control" name="category1[]">
										<option value="OP AP">OP AP</option>
										<option value="X">X</option>
										<option value="HUTANG LAIN">HUTANG LAIN</option>
									</select>
								</div>
								<div class="col-sm-3">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
								</div>
								<div class="col-sm-2">
								<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
								<datalist id="data">
									<option><b>VENDOR</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_vendor']?>">
									<?php $nov++; } ?>
									<option><b>REAL CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_cust order by nm_cust asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_cust']?>">
									<?php $nov++; } ?>
									<option><b>CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from pf group by cust_name");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['cust_name']?>">
									<?php $nov++; } ?>
										
								</datalist>
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
								</div>
								<div class="col-sm-1">
									<input type="checkbox" class="pull-left" name="item_index[]" >
								</div>
							</div>
						</div>		
							<div id='product'></div>
							<script type='text/javascript'>
								var idrow = 1;
								function addMore() {
									idrow++;
									$("#product").append('<div class="box-body"><div class="product-item form-group"><div class="col-sm-1"><button type="button" class="btn btn-danger pull-right" onclick="openwindow('+idrow+')"><span class="fa fa-search"></button></div><div class="col-sm-1"><input type="text" class="form-control" id="id_pf_est_cost'+idrow+'" name="id_pf_est_cost[]" placeholder="Job Order" readonly></div><div class="col-sm-2"><select class="form-control" name="category1[]"><option value="OP AP">OP AP</option><option value="X">X</option><option value="HUTANG LAIN">HUTANG LAIN</option></select></div><div class="col-sm-3"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control"></div><div class="col-sm-2"><input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching ....."><datalist id="data"><option>VENDOR</option><?php $nov=1;$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_vendor']?>"><?php $nov++; } ?> <option>REAL CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from data_cust order by nm_cust asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_cust']?>"><?php $nov++; } ?><option>CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from pf group by cust_name asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['cust_name']?>"><?php $nov++; } ?></datalist></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control"></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control"></div><div class="col-sm-1"><input type="checkbox" class="pull-center" name="item_index[]" ></div></div></div>');				
									$(function () { $(".select".idrow).select2()});
								}
								$(function () {
								$(".select").select2();
								})
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
									var popup = window.open("modul/mod_jurnal_keg/tabel_est_cost_hut.php?idrow="+idrow,"",features);
								}
							</script>
						
							<div class="btn-action float-clear" align="center">	
								<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
								<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
							</div>
							
							<div class="box-footer">
								<button type="submit1" class="btn btn-success pull-right">SUBMIT</button>
							</div>
						</div>							
						</form>
				</section>	
	
				<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
								<div class="box-tools pull-right">
							
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
							</div>
	
							<div class="box-body">
								<div class="row">
									<div class="tabel-responsive">
										<div class="col-md-12">
										<table id="myTable2" class="table table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>DESCRIPTION</th>
													<th>KATEGORY</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost=1;
													$query4=mysql_query("select * from pf_real_cost 													
													where no_reff_keu like 'HUT%' 
													order by id_pf_real_cost desc");
													while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
														$id_pf_real_cost=$hasil4['id_pf_real_cost'];
												?>
												<tr>
													<td><?=$no_real_cost?></td>
													<td><?=$hasil4['tgl_pf_real_cost']?></td>
													<td><?=$hasil4['no_reff_keu']?></td>
													<td>
														<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['no_jo']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														left join pf_est_cost as ec on rc.id_pf=ec.id_pf
														where no_reff_keu='$hasil4[no_reff_keu]'group by id_revenue
														");
														while ($hslrc=mysql_fetch_array($rc)){
															$ec=mysql_query("select * from pf_est_cost where id_pf_est_cost='$hslrc[id_est_cost]'");
															$hslec=mysql_fetch_array($ec);
														?>	
														<?=$hslec['desc_est_cost']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['category1']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['kegiatan']?><br>
														<?php } ?>
													</td>
													
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['stakeholder']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bukti']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=number_format($hslrc['real_cost'])?><br>
														<?php } ?>
													</td>
													<td>	
														<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&reff=<?=$type?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
												<?php $no_real_cost++; } ?>	
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						$(document).ready(function(){
								$('#myTable2').dataTable();
						</script>
					</section>				
	
			<?php	
		break;
		case 'PIUT':
			$bulan=date('n');
			$type="PIUT";
			$date=date('ym');
			$query=mysql_query("select * from pf_real_cost where  no_reff_keu like 'PIUT%' order by no_reff_keu desc limit 1");
			$hasil=mysql_fetch_array($query);
			$urut=substr($hasil['no_reff_keu'],8);
			$bulankemaren=substr($hasil['no_reff_keu'],6,2);
			$bulanini=date('m');
	
			if ($bulankemaren!=$bulanini && $urut != 001){
				$urut=0;
			}
				$urut=$urut+1;
				$no_urut=sprintf("%03s", $urut);
				$no_reff_keu="$type$date$no_urut";
			?>
	
				<section class="content-header">
					<h1>Jurnal Keuangan</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
						<li class="active">Form Input PIUTANG</li>
					</ol>
				</section>
			
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">FORM INPUT PIUTANG</h3>
							
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<form name="submit1" action="<?=$aksi?>" method="GET">
						<div class="box-body">
						
						<div class="box-body">
							<div class="col-md-6">
								<div class="form-group">
									<input type="hidden" name="module" value="jurnal_keu2">
									<input type="hidden" name="act" value="tambah_jurnal_keu2">
									<input type="hidden" name="act2" value="PIUT">
									<input type="hidden" name="dk" value="D">
									<label>PIUT NUMBER :</label>
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="no_reff_keu" class="form-control" value="<?=$no_reff_keu?>"  readonly>
								</div>
								<div class="form-group">
									<label>DATE :</label>
									<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
	
						<div class="box-body">
							<div class="product-item form-group">
								<div class="col-sm-1">
									<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
								</div>
								<div class="col-sm-1">	
									<input type="text" class="form-control" id="id_pf_invoice1" name="id_pf_invoice[]" placeholder="NO INVOICE " readonly>
								</div>
								<div class="col-sm-2">
									<select class="form-control" name="category1[]">
										<option value="PENJUALAN">PENJUALAN</option>
										<option value="PIUTANG">PIUTANG</option>
										<option value="PIUTANG LAIN">PIUTANG LAIN</option>
									</select>
								</div>
								<div class="col-sm-3">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
								</div>
								<div class="col-sm-2">
								<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
								<datalist id="data">
									<option><b>VENDOR</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_vendor']?>">
									<?php $nov++; } ?>
									<option><b>REAL CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from data_cust order by nm_cust asc");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['nm_cust']?>">
									<?php $nov++; } ?>
									<option><b>CUSTOMER</b></option>
									<?php 
									$nov=1;
										$qryv=mysql_query("select * from pf group by cust_name");
										while($hslv=mysql_fetch_array($qryv)){
									?>
									<option value="<?=$hslv['cust_name']?>">
									<?php $nov++; } ?>
										
								</datalist>
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
								</div>
								<div class="col-sm-1">
									<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
								</div>
								<div class="col-sm-1">
									<input type="checkbox" class="pull-left" name="item_index[]" >
								</div>
							</div>
						</div>		
							<div id='product'></div>
							<script type='text/javascript'>
								var idrow = 1;
								function addMore() {
									idrow++;
									$("#product").append('<div class="box-body"><div class="product-item form-group"><div class="col-sm-1"><button type="button" class="btn btn-danger pull-right" onclick="openwindow('+idrow+')"><span class="fa fa-search"></button></div><div class="col-sm-1"><input type="text" class="form-control" id="no_invoice'+idrow+'" name="no_invoice[]" placeholder="Job Order" readonly></div><div class="col-sm-2"><select class="form-control" name="category1[]"><option value="PENJUALAN">PENJUALAN</option><option value="PIUTANG">PIUTANG</option><option value="PIUTANG LAIN">PIUTANG LAIN</option><option value="MUTASI">MUTASI</option><option value="PENJUALAN">PENJUALAN</option></select></div><div class="col-sm-3"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control"></div><div class="col-sm-2"><input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching ....."><datalist id="data"><option>VENDOR</option><?php $nov=1;$qryv=mysql_query("select * from data_vendor order by nm_vendor asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_vendor']?>"><?php $nov++; } ?> <option>REAL CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from data_cust order by nm_cust asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['nm_cust']?>"><?php $nov++; } ?><option>CUSTOMER</option><?php $nov=1;$qryv=mysql_query("select * from pf group by cust_name asc");while($hslv=mysql_fetch_array($qryv)){?><option value="<?=$hslv['cust_name']?>"><?php $nov++; } ?></datalist></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control"></div><div class="col-sm-1"><input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control"></div><div class="col-sm-1"><input type="checkbox" class="pull-center" name="item_index[]" ></div></div></div>');				
									$(function () { $(".select".idrow).select2()});
								}
								$(function () {
								$(".select").select2();
								})
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
									var popup = window.open("modul/mod_jurnal_keg/tabel_invoice.php?idrow="+idrow,"",features);
								}
							</script>
						
							<div class="btn-action float-clear" align="center">	
								<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore();" />
								<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow();" />
							</div>
							
							<div class="box-footer">
								<button type="submit1" class="btn btn-success pull-right">SUBMIT</button>
							</div>
						</div>							
						</form>
				</section>	
	
				<section class="content">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title">TABEL KEGIATAN KEUANGAN</h3>
								<div class="box-tools pull-right">
							
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
							</div>
	
							<div class="box-body">
								<div class="row">
									<div class="tabel-responsive">
										<div class="col-md-12">
										<table id="myTable21" class="table table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>DESCRIPTION</th>
													<th>KATEGORY</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost=1;
													$query4=mysql_query("select * from pf_real_cost 
													where no_reff_keu like 'PIUT%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
													while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
														$id_pf_real_cost=$hasil4['id_pf_real_cost'];
												?>
												<tr>
													<td><?=$no_real_cost?></td>
													<td><?=$hasil4['tgl_pf_real_cost']?></td>
													<td><?=$hasil4['no_reff_keu']?></td>
													<td>
														<?php
														$rc=mysql_query("select * from pf_invoice as inv
														join pf on inv.id_pf=pf.id_pf 
														where id_pf_invoice='$hasil4[id_pf_invoice]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['no_jo']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														left join pf_revenue as ec on rc.id_pf=ec.id_pf
														where no_reff_keu='$hasil4[no_reff_keu]'group by id_revenue
														");
														while ($hslrc=mysql_fetch_array($rc)){
															$ec=mysql_query("select * from pf_revenue where id_pf_revenue='$hslrc[id_revenue]'");
															$hslec=mysql_fetch_array($ec);
														?>	
														<?=$hslec['desc_revenue']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost as rc
														join pf on rc.id_pf=pf.id_pf 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['category1']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>
														<?=$hslrc['kegiatan']?><br>
														<?php } ?>
													</td>
													
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['stakeholder']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=$hslrc['bukti']?><br>
														<?php } ?>
													</td>
													<td>
													<?php
														$rc=mysql_query("select * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc=mysql_fetch_array($rc)){
														?>	
														<?=number_format($hslrc['real_cost'])?><br>
														<?php } ?>
													</td>
													<td>	
														<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=print&id=<?=$id_pf_real_cost?>&id_pf=<?=$hasil4['id_pf']?>&reff=<?=$type?>&no_reff_keu=<?=$hasil4['no_reff_keu']?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
												<?php $no_real_cost++; } ?>	
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<script>
						$(document).ready(function(){
								$('#myTable21').dataTable();
						</script>
					</section>				
	
			<?php	
		break;
		case 'tambah_image':
				$id_pf_real_cost=$_GET['id'];
				$query=mysql_query("select * from pf_real_cost as prc
				join users on prc.user_pf_real_cost=users.id_users
				left join pf on prc.id_pf=pf.id_pf
				where id_pf_real_cost=$id_pf_real_cost");
				$hasil=mysql_fetch_array($query);
				$id_pf=$hasil['id_pf'];
				$id_pf_real_cost=$hasil['id_pf_real_cost'];
				$id_est_cost=$hasil['id_est_cost'];
				$id_revenue=$hasil['id_revenue'];
				
			?>
			<section class="content-header">
				<h1>JURNAL KEUANGAN</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2&act=jurnal&id=<?=$id_pf?>">Form Jurnal Keuangan</a></li>
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
						<div class="modal fade" id="keu2<?=$id_pf_real_cost?>" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content" style="color: black;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"></button>
											<h5>Tambah Images</h5>
										</div>
										<form name="submit" action="<?=$aksi?>?module=jurnal_keu2&act=tambah_images" method="POST" enctype="multipart/form-data">
										<div class="modal-body" >
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="id_est_cost" value="<?=$id_est_cost?>">
												<input type="hidden" name="id_revenue" value="<?=$id_revenue?>">
												<input type="hidden" name="id_pf_real_cost" value="<?=$id_pf_real_cost?>">
											</div>																
											<div class="form-group">
												<label>DATE:</label>
												<input type="text" class="form-control" name="tgl_pf_real_cost" value="<?=date('Y-m-d')?>" readonly>
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
							<a class="btn btn-default btn-sm" data-toggle="modal" href="#keu2<?=$id_pf_real_cost?>">+</a>
						
						</div>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">	
								<!-- form start -->
							<form name="submit2" action="<?=$aksi?>?module=jurnal_keu2&act=hapus_gambar" method="POST">	
								<div class="box-body">
									<h4>NOMOR REFERENSI : <?=$hasil['no_reff_keu']?></h4>
									<h4>JOB ORDER NUMBER : <?=$hasil['no_jo']?></h4>
									<h4>DESCRIPTION : <?=$hasil['kegiatan']?></h4>
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
									$id_pf_real_cost=$hasil['id_pf_real_cost'];
									$query=mysql_query("select * from images_db where id_pf_real_cost='$id_pf_real_cost' and id_pf='$id_pf' and id_est_cost='$id_est_cost'");
									while ($hasil=mysql_fetch_array($query)){
										$id_images_db=$hasil['id_images_db'];
										
									?>	
									<div class="kotak col-md-3 checkbox-wrapper">	
										<input type="hidden" name="id_pf_real_cost" value="<?=$hasil['id_pf_real_cost']?>">
										<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/>
										<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>">	<br> <a href=images/data_op/<?=$hasil['nm_file']?> target='blank'> <?=$hasil['nm_file']?> </a>
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

	}
}
?>
