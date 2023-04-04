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
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-d', strtotime("-5 day", strtotime($hari_ini)));
				$tgl_ak = date('Y-m-d', strtotime(" ", strtotime($hari_ini)));
				$tgl_aw2 = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak2 = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
				$tgl_aw_str2 = date('01-M-Y', strtotime($tgl_aw2));
				$tgl_ak_str2 = date('d-M-Y', strtotime($tgl_ak2));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];
				$tgl_aw2 = $_POST['tgl_aw2'];
				$tgl_ak2 = $_POST['tgl_ak2'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
				$tgl_aw_str2 = date('d-M-Y', strtotime($tgl_aw2));
				$tgl_ak_str2 = date('d-M-Y', strtotime($tgl_ak2));
			}
			if (empty($_POST['tgl_aw2'])) {
				$tgl_aw2 = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak2 = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str2 = date('01-M-Y', strtotime($tgl_aw2));
				$tgl_ak_str2 = date('d-M-Y', strtotime($tgl_ak2));
			} else {
				$tgl_aw2 = $_POST['tgl_aw2'];
				$tgl_ak2 = $_POST['tgl_ak2'];

				$tgl_aw_str2 = date('d-M-Y', strtotime($tgl_aw2));
				$tgl_ak_str2 = date('d-M-Y', strtotime($tgl_ak2));
			}
?>
			<script>
				$(document).ready(function() {
					$('#myTable').dataTable();
					$('#myTable1').dataTable();
					$('#myTable2').dataTable();
					$('#myTable3').dataTable();
				});
				$(function() {
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
													<?php
													$total_bbk = 0;
													$queryBbk = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'BBK%' 
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilBbk = mysql_fetch_array($queryBbk)) {
														$total_bbk += $hasilBbk['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBK'; ?>';">
															<h3 class="text-red text-bold">BBK</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Total BBK Bulan ini</span>
															<span class="info-box-number">
																<?= number_format($total_bbk) ?>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_bbm = 0;
													$queryBbm = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'BBM%' 
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilBbm = mysql_fetch_array($queryBbm)) {
														$total_bbm += $hasilBbm['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BBM'; ?>';">
															<h3 class="text-green text-bold">BBM</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Total BBM Bulan ini</span>
															<span class="info-box-number">
																<?= number_format($total_bbm) ?>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_bkk = 0;
													$queryBkk = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'BKK%' 
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilBkk = mysql_fetch_array($queryBkk)) {
														$total_bkk += $hasilBkk['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BKK'; ?>';">
															<h3 class="text-orange text-bold">BKK</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Total BKK Bulan ini</span>
															<span class="info-box-number">
																<?= number_format($total_bkk) ?>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_bkm = 0;
													$queryBkm = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'BKM%' 
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilBkm = mysql_fetch_array($queryBkm)) {
														$total_bkm += $hasilBkm['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-grey" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BKM'; ?>';">
															<h3 class="text-blue text-bold">BKM</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Total BKM Bulan ini</span>
															<span class="info-box-number">
																<?= number_format($total_bkm) ?>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_hut = 0;
													$queryHut = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'HUT%' 																			
																			and category2='HUT'
																			and bl=0
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilHut = mysql_fetch_array($queryHut)) {
														$total_hut += $hasilHut['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=HUT'; ?>';">
															<h3 class="text-black text-bold">BHUT</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Saldo Hutang</span>
															<span class="info-box-number">
																<?= number_format($total_hut) ?>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_piut = 0;
													$queryPiut = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like 'PIUT%' 
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilPiut = mysql_fetch_array($queryPiut)) {
														$total_piut += $hasilPiut['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=PIUT'; ?>';">
															<h3 class="text-yellow text-bold">BPIUT</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Saldo Piutang</span>
															<span class="info-box-number">
																<?= number_format($total_piut) ?>
															</span>
														</div>
													</div>
												</div>

												<div class="col-md-6 col-sm-6 col-xs-12">
													<?php
													$total_balik = 0;
													$queryBalik = mysql_query("SELECT real_cost from pf_real_cost 
																			where no_reff_keu like '%_AP' or no_reff_keu like '%_AR'
																			and tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'");
													while ($hasilBalik = mysql_fetch_array($queryBalik)) {
														$total_balik += $hasilBalik['real_cost'];
													}
													?>
													<div class="info-box">
														<button type="button" class="info-box-icon keu-box bg-gray" onclick="location.href='<?php echo '?module=jurnal_keu2&act=BALIK_OP'; ?>';">
															<h3 class="text-orange text-bold">BALIK OP</h3>
														</button>
														<div class="info-box-content">
															<span class="info-box-text">Balik OP</span>
															<span class="info-box-number"><?= number_format($total_balik) ?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="box-header with-border">
											<h2 class="box-title"><span class="text-blue text-bold">EDIT / TAMBAH EST COST</span></h2><br>
											<h3 class="box-title"><span class="text-blue text-bold">Tabel Jurnal Operasional JO</span> dari tgl <b><?= $tgl_aw_str2 ?></b> s/d <b><?= $tgl_ak_str2 ?></b></h3>
										</div>
										<div class="box-body">
											<form name="submit" action="?module=jurnal_keu2" method="POST">
												<div class="col-md-4">
													<input class="form-control" type="date" name="tgl_aw2">
												</div>

												<div class="col-md-3">
													<h4>Sampai : </h4>
												</div>
												<div class="col-md-4">
													<input class="form-control" type="date" name="tgl_ak2">
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
																<tr>
																	<th>NO</th>
																	<th>DATE</th>
																	<th>JOB ORDER NUMBER</th>
																	<th>CUSTOMER NAME</th>

																	<th>ACTION</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$no = 1;
																$query = mysql_query("SELECT * from pf_log WHERE tgl_pf between '$tgl_aw2' and '$tgl_ak2' order by tgl_pf desc , no_pf desc");
																while ($hasil = mysql_fetch_array($query)) {
																	$id_pf = $hasil['id_pf'];
																	$id_pf_log = $hasil['id_pf_log'];
																?>
																	<tr>
																		<td><?= $no ?></td>
																		<td><?= $hasil['tgl_pf'] ?></td>
																		<td><b><?= $hasil['no_jo'] ?></b></td>
																		<td><?= $hasil['cust_name'] ?></td>

																		<td>
																			<!-- Modal -->
																			<div class="modal fade" id="est_cost1<?= $id_pf_log ?>" role="dialog">
																				<div class="modal-dialog">
																					<!-- Modal content-->
																					<div class="modal-content" style="color: black;">
																						<div class="modal-header">
																							<button type="button" class="close" data-dismiss="modal"></button>
																							<h4 class="text-bold text-green">Tambah Est Cost</h4>
																						</div>
																						<form name="submit1" action="<?= $aksi ?>" method="get">
																							<div class="modal-body">
																								<div class="form-group">
																									<input type="hidden" name="module" value="jurnal_keu2">
																									<input type="hidden" name="act" value="tambah_est_cost">
																									<input type="hidden" name="id" value="<?= $id_pf_log ?>">
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
																									<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc_est_cost" class="form-control">
																								</div>
																								<div class="form-group">
																									<label>Est Cost :</label>
																									<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="est_cost" class="form-control">
																								</div>
																								<div class="form-group">
																									<label>Quantity :</label>
																									<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="qty_est_cost" class="form-control">
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
																			<a data-toggle="modal" class="btn bg-gray btn-sm text-blue text-bold" href="?module=jurnal_keu2&act=detailestcost&id=<?= $id_pf ?>">DETAIL</i></a>
																		</td>
																	</tr>
																<?php $no++;
																} ?>
															</tbody>
														</table>
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
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold mt-15">KEGIATAN KEUANGAN</h3>
							<div class="pull-right">
								<a href="<?= $aksi ?>?module=jurnal_keu2&act=excel&categoryJu=<?= $_POST['categoryJu'] ?>&tgl_aw=<?= $_POST['tgl_aw'] ?>&tgl_ak=<?= $_POST['tgl_ak'] ?>"><button type="button" class="btn bg-gray text-blue text-bold"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<div class="box-header with-border">
							<h3 class="box-title"><b class="text-blue">Tabel Kegiatan Keuangan</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="box-body">
							<form name="submit" action="?module=jurnal_keu2" method="POST">
								<div class="col-md-3">
									<input class="form-control" type="date" name="tgl_aw">
								</div>

								<div class="col-md-1">
									<h4>Sampai : </h4>
								</div>
								<div class="col-md-3">
									<input class="form-control" type="date" name="tgl_ak">
								</div>
								<div class="col-md-1">
									<h4 class="box-title text-blue text-bold mt-15">Tampilan</h4>
								</div>
								<div class="col-md-2">
									<select class="form-control" name="categoryJu" required>
										<option value="SEMUA" selected>SEMUA</option>
										<option value="JO">JO</option>
										<option value="NONJO">NON JO</option>
										<option value="ALL">ALL REAL COST</option>
									</select>
								</div>
								<div class="col-md-1">
									<button class="pull-right btn bg-gray text-blue text-bold" type="submit">OK</button>
								</div>
							</form>
						</div>

						<div class="box-body">
							<div class="row">
								<div class="tabel-responsive">
									<div class="col-md-12">
										<table id="myTable3" class="table table-bordered table-hover">
											<thead class="bg-blue">
												<tr>
													<th>NO</th>
													<th>DATE</th>
													<th>NO REFF</th>
													<th>JO NUMBER</th>
													<th>NO INVOICE</th>
													<th>TYPE COST</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$tampil = $_POST['categoryJu'];

												$no_real_cost = 1;
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
												order by id_pf_real_cost desc");

												if ($tampil == 'JO') {
													$query4 = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and no_jo !=''
												order by id_pf_real_cost desc");
												} elseif ($tampil == 'ALL') {
													$query4 = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice												
												order by id_pf_real_cost desc");
												} else {
													$query4 = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
												order by id_pf_real_cost desc");
												}
												if ($tampil == 'NONJO') {
													$query4 = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
												left join pf_invoice as inv on rc.id_pf_invoice=inv.id_pf_invoice
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and no_jo =''
												order by id_pf_real_cost desc");
												}

												while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
													$id_pf_real_cost = $hasil4['id_pf_real_cost'];
													$id_est_cost = $hasil4['id_est_cost'];
													$id_revenue = $hasil4['id_revenue'];
													$id_pf_log = $hasil4['id_pf_log'];
													$bl = $hasil4['bl'];

												?>
													<tr>
														<td><?= $no_real_cost ?></td>
														<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
														<td><?= $hasil4['no_reff_keu'] ?></td>
														<td><?= $hasil4['no_jo'] ?></td>
														<td><?= $hasil4['no_invoice'] ?></td>
														<td><?= $hasil4['category1'] ?></td>

														<td><?= $hasil4['kegiatan'] ?></td>
														<td><?= $hasil4['stakeholder'] ?></td>
														<td><?= $hasil4['bukti'] ?></td>
														<td><?= number_format($hasil4['real_cost']) ?></td>


														<td>
															<!-- Modal -->
															<div class="modal fade" id="jurnal_keu2<?= $id_pf_real_cost ?>" role="dialog">
																<div class="modal-dialog modal-lg">
																	<!-- Modal content-->
																	<div class="modal-content" style="color: black;">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal"></button>
																			<h3>Edit Jurnal Keuangan</h3>
																		</div>
																		<form name="submit1" action="<?= $aksi ?>" method="get">
																			<div class="modal-body">
																				<div class="form-group">
																					<input type="hidden" name="module" value="jurnal_keu2">
																					<input type="hidden" name="act" value="update_rc">
																					<input type="hidden" name="type" value="<?= $hasil4['category2'] ?>">
																					<input type="hidden" name="id" value="<?= $id_pf_real_cost ?>">
																					<input type="hidden" name="id_pf" value="<?= $id_pf ?>">

																					<label>DATE :</label><br>
																					<input type="date" class="form-control" name="tgl_pf_real_cost" value="<?= $hasil4['tgl_pf_real_cost'] ?>">
																				</div>
																				<br>
																				<div class="form-group">
																					<label>REFF :</label><br>
																					<input type="text" class="form-control" name="no_reff_keu" class="form-control" value="<?= $hasil4['no_reff_keu'] ?>">
																				</div>
																				<br>
																				<div class="form-group">
																					<label>JOB NUMBER :</label><br>
																					<input class="form-control" list="no_jo" name="id_pf_log" value="<?= $hasil4['no_jo'] ?>" id="pilih" placeholder="Searching JOB NUMBER ....." size="50">
																					<datalist id="no_jo">
																						<?php
																						$qry_jo = mysql_query("SELECT * from pf_log group by no_jo order by no_jo asc");
																						while ($hsl_jo = mysql_fetch_array($qry_jo)) {
																							$no_jo = $hsl_jo['no_jo'];
																							$id_pf_logg = $hsl_jo['id_pf_log'];
																						?>
																							<option value="<?= $no_jo ?>"><?= $no_jo ?></option>
																						<?php
																						}
																						?>
																					</datalist>

																				</div>
																				<br>
																				<div class="form-group">
																					<label>TYPE COST / INV NUMBER :</label><br>
																					<input class="form-control" list="category" name="category1" value="<?= $hasil4['category1'] ?>" id="pilih" placeholder="Searching .....">
																					<datalist id="category">
																						<option value="OP CASH">OP CASH</option>
																						<option value="OP AP">OP AP</option>
																						<option value="OP AR">OP AR</option>
																						<option value="OVERHEAD">OVERHEAD</option>
																						<option value="HUT">HUT</option>
																						<option value="MUTASI">MUTASI</option>
																						<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
																						<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
																						<option value="HUTANG USAHA">HUTANG USAHA</option>
																						<option value="HUTANG LAIN">HUTANG LAIN</option>
																						<option value="PIUTANG">PIUTANG</option>
																						<option value="PIUTANG LAIN">PIUTANG LAIN</option>
																						<option value="PENJUALAN">PENJUALAN</option>
																						<option value="X">X</option>
																						<?php
																						$qry_inv = mysql_query("SELECT * from pf_invoice group by no_invoice order by no_invoice asc");
																						while ($hsl_inv = mysql_fetch_array($qry_inv)) {
																							$no_inv = $hsl_inv['no_invoice'];
																							$id_inv = $hsl_inv['id_pf_invoice'];
																						?>
																							<option value="<?= $no_inv ?>"><?= $no_inv ?></option>
																						<?php
																						}
																						?>
																					</datalist>
																				</div>

																				<br>
																				<?php
																				if ($hasil4['category1'] == 'HUT') {
																					$no_reff2 = $hasil4['id_hut'];
																					$no_hut = $hasil4['no_hut'];
																					$id_hut2 = $hasil4['id_hut2'];

																					$qryhut = mysql_query("SELECT * from pf_real_cost where id_pf_real_cost=$no_hut and category1 ='HUT' and category2='HUT'");
																					$hslhut = mysql_fetch_array($qryhut);
																					$cost_hut = $hslhut['real_cost'];
																					$no_reff = substr($hslhut['no_reff_keu'], 0, 10);
																					$qryhut2 = mysql_query("SELECT * from pf_real_cost where no_reff_keu ='$no_reff' and real_cost ='$cost_hut' and category1 ='OP AP' and category2='HUT'");
																					$hslhut2 = mysql_fetch_array($qryhut2);
																					$id_pf_real_cost_hut = $hslhut2['id_pf_real_cost'];
																					$no_reff_hut2 = $hslhut2['no_reff_keu'];
																				?>
																					<div class="form-group">
																						<label>HUTANG :</label><br>
																						<input class="form-control" list="hutang" name="hut_id" value="<?= $id_hut2 ?>" id="pilih" placeholder="Searching .....">
																						<datalist id="hutang">
																							<?php
																							$query_hut = mysql_query("SELECT * from pf_real_cost where category1 ='HUT' and category2='HUT'");
																							while ($hasil_hut = mysql_fetch_array($query_hut)) {
																								$no_reff2 = $hasil_hut['no_reff_keu'];
																								$id_pf_real_cost_hut2 = $hasil_hut['id_hut2'];
																							?>
																								<option value="<?= $id_pf_real_cost_hut2 ?>"><?php echo "$id_pf_real_cost_hut2" . "-" . "$no_reff2" ?></option>
																							<?php } ?>
																						</datalist>
																					</div><br>
																				<?php
																				}
																				?>

																				<div class="form-group">
																					<label>KEGIATAN</label><br>
																					<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan" value="<?= $hasil4['kegiatan'] ?>" class="form-control" size="100">
																				</div><br>
																				<div class="form-group">
																					<label>STAKE HOLDER:</label><br>
																					<input class="form-control" list="data" name="stakeholder" value="<?= $hasil4['stakeholder'] ?>" id="pilih" placeholder="Searching .....">
																					<datalist id="data">
																						<?php
																						$nov = 1;
																						$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
																						while ($hslv = mysql_fetch_array($qryv)) {
																						?>
																							<option value="<?= $hslv['nm_vendor'] ?>">
																							<?php $nov++;
																						} ?>
																							<option><b>REAL CUSTOMER</b></option>
																							<?php
																							$nov = 1;
																							$qryv = mysql_query("select * from data_cust order by nm_cust asc");
																							while ($hslv = mysql_fetch_array($qryv)) {
																							?>
																								<option value="<?= $hslv['nm_cust'] ?>">
																								<?php $nov++;
																							} ?>
																								<option><b>CUSTOMER</b></option>
																								<?php
																								$nov = 1;
																								$qryv = mysql_query("select * from pf group by cust_name");
																								while ($hslv = mysql_fetch_array($qryv)) {
																								?>
																									<option value="<?= $hslv['cust_name'] ?>">
																									<?php $nov++;
																								} ?>

																					</datalist>

																				</div>
																				<br>
																				<div class="form-group">
																					<label>BUKTI :</label><br>
																					<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti" value="<?= $hasil4['bukti'] ?>" class="form-control">
																				</div>
																				<br>
																				<div class="form-group">
																					<label>Real Cost :</label><br>
																					<input type="text" name="real_cost" class="form-control" value="<?= $hasil4['real_cost'] ?>">
																				</div>
																				<br>
																				<?php
																				$bank = $hasil4['bank'];
																				if (!empty($bank)) { ?>
																					<div class="form-group">
																						<label>BANK :</label><br>
																						<select class="form-control" name="bank" required>
																							<option value="<?= $hasil4['bank'] ?>"><?= $hasil4['bank'] ?></option>
																							<?php
																							$querybank = mysql_query("SELECT * from bank");
																							while ($hasilbank = mysql_fetch_array($querybank)) {
																							?>
																								<option name="name_real_user" value="<?= $hasilbank['nama_bank'] ?>"><?= $hasilbank['nama_bank'] ?></option>
																							<?php } ?>
																						</select>
																					</div>
																				<?php }
																				?>

																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																				<button type="submit1" class="btn btn-success">Update</button>
																			</div>
																		</form>
																	</div>
																</div>
															</div>
															<?php
															if ($bl != 1) { ?>
																<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#jurnal_keu2<?= $id_pf_real_cost ?>"><span class="fa fa-edit"></a>
																<a class="btn bg-gray text-red btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=delete_pf_real_cost&id=<?= $id_pf_real_cost ?>&id_est_cost=<?= $id_est_cost ?>" onclick="return confirm('Sudah Yakin Mau di Hapus')">
																	<span class="fa fa-trash">
																</a>
																<a class="btn bg-gray text-blue btn-sm" onclick="location.href='<?php echo '?module=jurnal_keu2&act=tambah_image&id=' . $id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
															<?php } else { ?>
																<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#jurnal_keu2<?= $id_pf_real_cost ?>"><span class="fa fa-edit"></a>
																<a class="btn bg-gray text-red btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=delete_pf_real_cost&id=<?= $id_pf_real_cost ?>&id_est_cost=<?= $id_est_cost ?>" onclick="return confirm('Sudah Yakin Mau di Hapus')">
																	<span class="fa fa-trash">
																</a>
																<a class="btn bg-gray text-blue btn-sm" onclick="location.href='<?php echo '?module=jurnal_keu2&act=tambah_image&id=' . $id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
															<?php } ?>


														</td>
													</tr>
												<?php $no_real_cost++;
												} ?>
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
		case 'detailestcost':
			$id_pf = $_GET['id']; ?>
			<section class="content-header">
				<h1>Detail Est Cost</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li>Jurnal</li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li class="active">Detail Est Cost</li>
				</ol>
			</section>
			<?php
			$queryData = mysql_query("SELECT * FROM pf_log where id_pf=$_GET[id] and log_pf='0'");
			$id_pf;
			$hasil;
			$id_data;
			if (mysql_num_rows($queryData) == 0) {
				$query = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil = mysql_fetch_array($query)) or die(mysql_error());
				echo ("<script>console.log('TIDAK ADA: " . $hasil . "');</script>");
				$id_data = 'id_pf';
				$id_pf = $hasil['id_pf'];
				$id_pf2 = $hasil['id_pf'];
			} elseif (mysql_num_rows($queryData) != 0) {
				($hasil = mysql_fetch_array($queryData)) or die(mysql_error());
				echo ("<script>console.log('ADA: " . $hasil . "');</script>");
				$id_data = 'id_pf_log';
				$id_pf = $hasil['id_pf_log'];
				$id_data_pf = 'id_pf';
				$idPf = $hasil['id_pf'];
				$query2 = mysql_query("SELECT * FROM pf where id_pf=$_GET[id]");
				($hasil2 = mysql_fetch_array($query2)) or die(mysql_error());
				$id_pf2 = $hasil2['id_pf'];
				$status2 = $hasil2['status_ops'];
				if ($status2 == '0') {
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
								<table style="width:100%">
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
										<td><?= date("d M y ", strtotime($hasil['etb'])) ?>/<?= date("d M y", strtotime($hasil['etd'])) ?></td>
									</tr>
									<tr>
										<td>OPEN STACK</td>
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['openstack'])) ?> </td>
									</tr>
									<tr>
										<td>CLOSING TIME CONTAINER</td>
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['ctc']))  ?> </td>
									</tr>
									<tr>
										<td>CLOSING TIME DOCUMENT</td>
										<td>:</td>
										<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?> </td>
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
											if ($hasil['aprove'] == "batal") {
											?>
												<img src="images/aproved/batal.png" width="150" height="150">

											<?php } elseif ($hasil['aprove'] == "0") { ?>

												<h2>PROFORMA</h2>
											<?php
											} elseif ($hasil['aprove'] == 42) {
											?>
												<img src="images/aproved/aproved.png" width="150" height="150">
											<?php
											} elseif ($hasil['aprove'] == "1") {
											?>
												<img src="images/aproved/aproved.png" width="150" height="150">
											<?php
											} elseif ($hasil['aprove'] == "BILL") {
											?>
												<h2>BILL</h2>
											<?php
											} else {
											?>
												<h2><?= $hasil['aprove'] ?></h2>
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
							<div class="box-header with-border">
								<!-- Modal -->
								<div class="modal fade" id="tambahest" role="dialog">
									<div class="modal-dialog">
										<!-- Modal content-->
										<div class="modal-content" style="color: black;">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"></button>
												<h4 class="text-bold text-green">Tambah Est Cost</h4>
											</div>

											<form name="submit1" action="<?= $aksi ?>" method="get">
												<div class="modal-body">
													<div class="form-group">
														<input type="hidden" name="module" value="jurnal_keu2">
														<input type="hidden" name="act" value="tambah_est_cost">
														<input type="hidden" name="id_pf_log" value="<?= $id_pf ?>">
														<input type="hidden" name="id_pf" value="<?= $idPf ?>">
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
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc_est_cost" class="form-control">
													</div>
													<div class="form-group">
														<label>Est Cost :</label>
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="est_cost" class="form-control">
													</div>
													<div class="form-group">
														<label>Quantity :</label>
														<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="qty_est_cost" class="form-control">
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
								<a class="btn bg-blue btn-sm" data-toggle="modal" href="#tambahest"><i class="fa fa-plus"></i></a>
								<h3 class="box-title text-bold text-blue">TAMBAH EST COST</h3>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<h5><a><strong>TABLE EST COST</strong></a></h5>
									<table class="table table-bordered table-hover">
										<tr class="info">
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>QTY</th>
											<th>RATE</th>
											<th>VALUE</th>
											<th>ACT</th>
										</tr>
										<?php
										$no_job2 = 1;
										$total_est_cost = 0;
										$query3 = mysql_query("select * from pf_est_cost where id_pf_log=$id_pf order by id_pf_est_cost asc");
										while ($hasil3 = mysql_fetch_array($query3)) {
											$id_pf_est_cost = $hasil3['id_pf_est_cost'];
											$total_est_cost += $hasil3['qty_est_cost'] * $hasil3['est_cost']
										?>
											<tr>
												<td><?= $no_job2 ?></td>
												<td><?= $hasil3['type_est_cost'] ?></td>
												<td><?= $hasil3['desc_est_cost'] ?></td>
												<td><?= $hasil3['qty_est_cost'] ?></td>
												<td><?= $hasil3['est_cost'] ?></td>
												<td><?= $hasil3['qty_est_cost'] * $hasil3['est_cost'] ?></td>
												<td>
													<!-- Modal -->
													<div class="modal fade" id="est_cost<?= $id_pf_est_cost ?>" role="dialog">
														<div class="modal-dialog">
															<!-- Modal content-->
															<div class="modal-content" style="color: black;">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal"></button>
																	<h4 class="text-bold text-green">Edit Est Cost</h4>
																</div>
																<form name="submit1" action="<?= $aksi ?>" method="get">
																	<div class="modal-body">
																		<div class="form-group">
																			<input type="hidden" name="module" value="jurnal_keu2">
																			<input type="hidden" name="act" value="update_est_cost">
																			<input type="hidden" name="id" value="<?= $id_pf_est_cost ?>">
																			<input type="hidden" name="id_pf_log" value="<?= $id_pf ?>">
																			<input type="hidden" name="id_pf" value="<?= $idPf ?>">
																			<label>Category :</label>
																			<select class="form-control" name="type_est_cost">
																				<option value="<?= $hasil3['type_est_cost'] ?>"><?= $hasil3['type_est_cost'] ?></option>
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
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="desc_est_cost" class="form-control" value="<?= $hasil3['desc_est_cost'] ?>">
																		</div>
																		<div class="form-group">
																			<label>Est Cost :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="est_cost" class="form-control" value="<?= $hasil3['est_cost'] ?>">
																		</div>
																		<div class="form-group">
																			<label>Quantity :</label>
																			<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="qty_est_cost" class="form-control" value="<?= $hasil3['qty_est_cost'] ?>">
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
													<a class="btn bg-blue btn-sm" data-toggle="modal" href="#est_cost<?= $id_pf_est_cost ?>"><span class="fa fa-edit"></a>
													<a class="btn bg-red btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=delete_est_cost&id=<?= $id_pf_est_cost ?>&id_pf=<?= $idPf ?>"><span class="fa fa-trash"></a>
												</td>
											</tr>
										<?php
											$no_job2++;
										} ?>
									</table>
								</div>

							</div>



						</div>
					</div>
				</div>
			</section>
		<?php break;

		case 'BBK':
			$bulan = date('n');
			$type = "BBK";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BBK%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable').dataTable();
					$('#myTable2').dataTable();
				});
				$(function() {
					$('.select2').select2()
				})
			</script>


			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li class="active">Form Input BBK</li>
				</ol>
			</section>

			<section class="content">
				<!-- OP CASH -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">FORM INPUT BBK</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_op_kas" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_op_kas">
											<input type="hidden" name="act2" value="BBK">
											<input type="hidden" name="dk" value="K">
											<label>BBK NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-lg-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowkas(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-lg-1">
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_est_cost_kas_0" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-lg-1">
											<label>TYPE COST :</label>
											<select class="form-control" name="category1[]" required>
												<option value="">Pilih</option>
												<option value="OP CASH">OP CASH</option>
												<option value="HUT">HUT</option>
												<option value="OVERHEAD">OVERHEAD</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
												<option value="OP AR">OP AR</option>
											</select>
										</div>
										<div class="col-lg-1">
											<label>HUTANG</label>
											<select class="form-control select2" style="width: 100%;" name="hut_id[]" id="pilih">
												<option value=""></option>
												<?php
												$query_hut = mysql_query("SELECT * from pf_real_cost 
													where no_reff_keu like '%_AP' 
													and no_reff_keu like 'HUT%'
													group by no_reff_keu");
												while ($hasil_hut = mysql_fetch_array($query_hut)) {
													$no_reff_hut = $hasil_hut['no_reff_keu'];
													$id_hut = $hasil_hut['id_hut2'];
												?>
													<option value="<?= $id_hut ?>"><?php echo "$id_hut" . "-" . "$no_reff_hut" ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-lg-2">
											<label>STAKEHOLDER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-lg-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-lg-1">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
												$query4 = mysql_query("SELECT * from bank");
												while ($hasil4 = mysql_fetch_array($query4)) {
												?>
													<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
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
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowkas(${bbkRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_est_cost_kas_${bbkRow}" name="id_pf_est_cost[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-lg-1">
												<select class="form-control" name="category1[]" required>
												<option value="">Pilih</option>
												<option value="OP CASH">OP CASH</option>
												<option value="HUT">HUT</option>
												<option value="OVERHEAD">OVERHEAD</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>	
											</select>	
												</div>
												<div class="col-lg-1">
													<select class="form-control select2" style="width: 100%;" name="hut_id[]" id="pilih">
													<option value=""></option>
                                                <?php
												$query_hut = mysql_query("SELECT * from pf_real_cost 
													where no_reff_keu like '%_AP' 
													and no_reff_keu like 'HUT%'
													group by no_reff_keu");
												while ($hasil_hut = mysql_fetch_array($query_hut)) {
													$no_reff_hut = $hasil_hut['no_reff_keu'];
													$id_hut = $hasil_hut['id_hut2'];
												?>
													<option value="<?= $id_hut ?>"><?php echo "$id_hut" . "-" . "$no_reff_hut" ?></option>
												<?php } ?>
                                             </select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                <?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
                                              </select>
													
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>
												<div class="col-sm-1">
													<select class="form-control" name="bank[]" required>
														<option value="">Pilih</option>
														<?php
														$query4 = mysql_query("SELECT * from bank");
														while ($hasil4 = mysql_fetch_array($query4)) {
														?>
															<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
															<?php } ?>	
													</select>
												</div>
												<div class="col-sm-1">
													<input class="mt-1" type="file" name="nm_file${bbkRow}[]" multiple>
												</div>
											</div>
										`);
										$(function() {
											$('.select2').select2()
										})
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
										var popup = window.open(`modul/mod_jurnal_keg/tabel_est_cost.php?idrow=${idrow}&act=kas`, "", features);
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
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar BBK</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
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
												<th>TYPE COST</th>
												<th>ID HUT</th>
												<th>NO HUT</th>
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
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like 'BBK%' 
											and no_reff_keu not like '%_AP'										
											group by no_reff_keu
											order by id_pf_real_cost desc");
											while ($hasil4 = mysql_fetch_array($query4)) {
												$id_pf_real_cost = $hasil4['id_pf_real_cost'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
													<td><?= $hasil4['no_reff_keu'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_jo'] ?><br>
														<?php } ?>
													</td>


													<td>

														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['id_hut2'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['id_hut'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= number_format($hslrc['real_cost']) ?><br>
														<?php } ?>
													</td>
													<td><?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bank'] ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'BKK':
			$bulan = date('n');
			$type = "BKK";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BKK%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable').dataTable();
					$('#myTable2').dataTable();
				});
				$(function() {
					$('.select2').select2()
				})
			</script>

			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li class="active">Form Input BKK</li>
				</ol>
			</section>

			<section class="content">
				<!-- OP CASH -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">FORM INPUT BKK</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_op_kas2" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_op_kas2">
											<input type="hidden" name="act2" value="BKK">
											<input type="hidden" name="dk" value="K">
											<label>BKK NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-lg-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowkas(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-lg-1">
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_est_cost_kas_0" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-lg-1">
											<label>TYPE COST :</label>
											<select class="form-control" name="category1[]" required>
												<option value="">Pilih</option>
												<option value="OP CASH">OP CASH</option>
												<option value="HUT">HUT</option>
												<option value="OVERHEAD">OVERHEAD</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
											</select>
										</div>
										<div class="col-lg-1">
											<label>HUTANG</label>
											<select class="form-control select2" style="width: 100%;" name="hut_id[]" id="pilih">
												<option value=""></option>
												<?php
												$query_hut = mysql_query("SELECT * from pf_real_cost 
													where no_reff_keu like '%_AP' 
													and no_reff_keu like 'HUT%'
													group by no_reff_keu");
												while ($hasil_hut = mysql_fetch_array($query_hut)) {
												?>
													<option value="<?= $hasil_hut['no_reff_keu'] ?>"><?= $hasil_hut['no_reff_keu'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-lg-2">
											<label>STAKEHOLDER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-lg-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-lg-1">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>

								<script type='text/javascript'>
									var bkkRow = 1;

									function addMore() {
										$("#product").append(`
											<div class="mt-15 product-item row bkk-${bkkRow}">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowkas(${bkkRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_est_cost_kas_${bkkRow}" name="id_pf_est_cost[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-lg-1">
												<select class="form-control" name="category1[]" required>
												<option value="">Pilih</option>
												<option value="OP CASH">OP CASH</option>
												<option value="HUT">HUT</option>
												<option value="OVERHEAD">OVERHEAD</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>	
											</select>
												</div>
												<div class="col-lg-1">
													<select class="form-control select2" style="width: 100%;" name="hut_id[]" id="pilih">
											    <option value=""></option>
                                                <?php
												$query_hut = mysql_query("SELECT * from pf_real_cost 
													where no_reff_keu like '%_AP' 
													and no_reff_keu like 'HUT%'
													group by no_reff_keu");
												while ($hasil_hut = mysql_fetch_array($query_hut)) {
												?>
												<option value="<?= $hasil_hut['no_reff_keu'] ?>"><?= $hasil_hut['no_reff_keu'] ?></option>
												<?php } ?>
                                             </select>
												</div>												
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                <?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
												<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
                                              </select>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>												
												<div class="col-sm-1">
													<input class="mt-1" type="file" name="nm_file${bkkRow}[]" multiple>
												</div>
											</div>
										`);
										$(function() {
											$('.select2').select2()
										})
										bkkRow++;
									}

									function deleteRow() {
										if (bkkRow > 1) {
											$(`.bkk-${bkkRow - 1}`).remove();
											bkkRow--;
										}
									}

									function openwindowkas(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open(`modul/mod_jurnal_keg/tabel_est_cost.php?idrow=${idrow}&act=kas`, "", features);
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
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar BKK</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=BKK" method="POST">
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
												<th>TYPE COST</th>
												<th>KEGIATAN</th>
												<th>STAKEHOLDER</th>
												<th>BUKTI</th>
												<th>VALUE</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like 'BKK%'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											while ($hasil4 = mysql_fetch_array($query4)) {
												$id_pf_real_cost = $hasil4['id_pf_real_cost'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
													<td><?= $hasil4['no_reff_keu'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_jo'] ?><br>
														<?php } ?>
													</td>

													<td>

														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= number_format($hslrc['real_cost']) ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'BKM':
			$bulan = date('n');
			$type = "BKM";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BKM%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable2').dataTable();
				});
				$(function() {
					$('.select2').select2()
				});
			</script>

			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li class="active">Form Input BKM</li>
				</ol>
			</section>

			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">FORM INPUT BKM</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_bkm" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_bkm">
											<input type="hidden" name="act2" value="BKM">
											<input type="hidden" name="dk" value="D">
											<label>BKM NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id="product">
									<div class="row">
										<div class="col-sm-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-sm-1">
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_revenue0" name="id_pf_revenue[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-sm-2">
											<label>TYPE COST / INV NUMBER</label>
											<select class="form-control select2" style="width: 100%;" name="id_pf_invoice[]" id="pilih">
												<option value="OP AR">OP AR</option>
												<option value="PIUTANG">PIUTANG</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="HUTANG LAIN">HUTANG LAIN</option>
												<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
												<?php
												$qry_inv = mysql_query("SELECT * from pf_invoice group by no_invoice order by no_invoice asc");
												while ($hsl_inv = mysql_fetch_array($qry_inv)) {
													$no_inv = $hsl_inv['no_invoice'];
													$id_inv = $hsl_inv['id_pf_invoice'];
												?>
													<option value="<?= $no_inv ?>"><?= $no_inv ?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input type="hidden" name="no_inv[]" value="<?= $no_inv ?>">
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>STAKEHOLDER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<option><b>VENDOR</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-1">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>
								<script type='text/javascript'>
									var bkmRow = 1;

									function addMore() {
										$("#product").append(`
											<div class="bkm-${bkmRow} mt-15 product-item row">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(${bkmRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_revenue${bkmRow}" name="id_pf_revenue[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="id_pf_invoice[]" id="pilih">
                                                    <option value="OP AR">OP AR</option>
													<option value="PIUTANG">PIUTANG</option>
													<option value="MUTASI">MUTASI</option>
													<option value="X">X</option>
													<option value="HUTANG LAIN">HUTANG LAIN</option>
													<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
													<?php
													$qry_inv = mysql_query("SELECT * from pf_invoice group by no_invoice order by no_invoice asc");
													while ($hsl_inv = mysql_fetch_array($qry_inv)) {
														$no_inv = $hsl_inv['no_invoice'];
														$id_inv = $hsl_inv['id_pf_invoice'];
													?>
													<option value="<?= $no_inv ?>"><?= $no_inv ?></option>
													<?php
													}
													?>
                                                  </select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                    <option><b>VENDOR</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from pf group by cust_name");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
													<?php $nov++;
													} ?>
                                                  </select>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>												
												<div class="col-lg-1">
													<input class="mt-1" type="file" name="nm_file${bkmRow}[]" multiple>
												</div>
											</div>`);
										$(function() {
											$('.select2').select2()
										})
										bkmRow++;
									}

									function deleteRow() {
										if (bkmRow > 1) {
											$(`.bkm-${bkmRow - 1}`).remove();
											bkmRow--;
										}
									}

									function openwindow(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open("modul/mod_jurnal_keg/tabel_revenue.php?idrow=" + idrow, "", features);
									}
								</script>

								<div class="btn-action float-clear" align="center">
									<input class="btn bg-gray text-bold text-blue" type="button" name="add_item" value="+" onClick="addMore();" />
									<input class="btn bg-gray text-bold text-red" type="button" name="del_item" value="-" onClick="deleteRow();" />
								</div>

								<div class="box-footer">
									<button type="submit1" class="btn bg-blue text-bold pull-right" data-style="zoom-out">SUBMIT</button>
								</div>
							</div>
						</div>
					</form>
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
							<div class="box-tools pull-right">

								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<div class="box-header with-border row">
							<div class="col-md-6">
								<h3 class="box-title"><b class="box-title text-blue text-bold">Tabel Daftar BKM</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
							</div>
							<div class="col-md-6">
								<form name="submit" action="?module=jurnal_keu2&act=BKM" method="POST">
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
													<th>TYPE COST</th>
													<th>KEGIATAN</th>
													<th>STAKEHOLDER</th>
													<th>BUKTI</th>
													<th>VALUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no_real_cost = 1;
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
													left join pf_log on rc.id_pf_log=pf_log.id_pf_log
													left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
													where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
													no_reff_keu like 'BKM%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
												while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
													$id_pf_real_cost = $hasil4['id_pf_real_cost'];
												?>
													<tr>
														<td><?= $no_real_cost ?></td>
														<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
														<td><?= $hasil4['no_reff_keu'] ?></td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['no_jo'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['category1'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['kegiatan'] ?><br>
															<?php } ?>
														</td>

														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['stakeholder'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['bukti'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= number_format($hslrc['real_cost']) ?><br>
															<?php } ?>
														</td>
														<td>
															<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
														</td>
													</tr>
												<?php $no_real_cost++;
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(document).ready(function() {
							$('#myTable2').dataTable();
						});
					</script>
			</section>



		<?php
			break;

		case 'BBM':
			$bulan = date('n');
			$type = "BBM";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BBM%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable2').dataTable();
				});
				$(function() {
					$('.select2').select2()
				});
			</script>

			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
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

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_bbm" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_bbm">
											<input type="hidden" name="act2" value="BBM">
											<input type="hidden" name="dk" value="D">
											<label>BBM NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id="product">
									<div class="row">
										<div class="col-sm-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-sm-1">
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_revenue0" name="id_pf_revenue[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-sm-2">
											<label>TYPE COST / INV NUMBER</label>
											<select class="form-control select2" style="width: 100%;" name="id_pf_invoice[]" id="pilih">
												<option value="OP AR">OP AR</option>
												<option value="PIUTANG">PIUTANG</option>
												<option value="MUTASI">MUTASI</option>
												<option value="X">X</option>
												<option value="HUTANG LAIN">HUTANG LAIN</option>
												<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
												<option value="OVERHEAD">OVERHEAD</option>
												<?php
												$qry_inv = mysql_query("SELECT * from pf_invoice group by no_invoice order by no_invoice asc");
												while ($hsl_inv = mysql_fetch_array($qry_inv)) {
													$no_inv = $hsl_inv['no_invoice'];
													$id_inv = $hsl_inv['id_pf_invoice'];
												?>
													<option value="<?= $no_inv ?>"><?= $no_inv ?></option>
												<?php
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input type="hidden" name="no_inv[]" value="<?= $no_inv ?>">
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>STAKEHOLDER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<option><b>VENDOR</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-1">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
												$query4 = mysql_query("SELECT * from bank");
												while ($hasil4 = mysql_fetch_array($query4)) {
												?>
													<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
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
									var bbmRow = 1;

									function addMore() {
										$("#product").append(`
											<div class="bbm-${bbmRow} mt-15 product-item row">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(${bbmRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_revenue${bbmRow}" name="id_pf_revenue[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="id_pf_invoice[]" id="pilih">
                                                    <option value="OP AR">OP AR</option>
													<option value="PIUTANG">PIUTANG</option>
													<option value="MUTASI">MUTASI</option>
													<option value="X">X</option>
													<option value="HUTANG LAIN">HUTANG LAIN</option>
													<option value="PENERIMAAN LAIN">PENERIMAAN LAIN</option>
													<option value="OVERHEAD">OVERHEAD</option>
													<?php
													$qry_inv = mysql_query("SELECT * from pf_invoice group by no_invoice order by no_invoice asc");
													while ($hsl_inv = mysql_fetch_array($qry_inv)) {
														$no_inv = $hsl_inv['no_invoice'];
														$id_inv = $hsl_inv['id_pf_invoice'];
													?>
													<option value="<?= $no_inv ?>"><?= $no_inv ?></option>
													<?php
													}
													?>
                                                  </select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                    <option><b>VENDOR</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from pf group by cust_name");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
													<?php $nov++;
													} ?>
                                                  </select>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>
												<div class="col-lg-1">
													<select class="form-control" name="bank[]" required>
														<option value="">Pilih</option>
														<?php
														$query4 = mysql_query("SELECT * from bank");
														while ($hasil4 = mysql_fetch_array($query4)) {
														?>
															<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
															<?php } ?>	
													</select>
												</div>
												<div class="col-lg-1">
													<input class="mt-1" type="file" name="nm_file${bbmRow}[]" multiple>
												</div>
											</div>`);
										$(function() {
											$('.select2').select2()
										})
										bbmRow++;
									}

									function deleteRow() {
										if (bbmRow > 1) {
											$(`.bbm-${bbmRow - 1}`).remove();
											bbmRow--;
										}
									}

									function openwindow(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open("modul/mod_jurnal_keg/tabel_revenue.php?idrow=" + idrow, "", features);
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
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
							<div class="box-tools pull-right">

								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<div class="box-header with-border row">
							<div class="col-md-6">
								<h3 class="box-title"><b class="box-title text-blue text-bold">Tabel Daftar BBM</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
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
													<th>TYPE COST</th>
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
												$no_real_cost = 1;
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
													left join pf_log on rc.id_pf_log=pf_log.id_pf_log
													left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
													where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
													no_reff_keu like 'BBM%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
												while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
													$id_pf_real_cost = $hasil4['id_pf_real_cost'];
												?>
													<tr>
														<td><?= $no_real_cost ?></td>
														<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
														<td><?= $hasil4['no_reff_keu'] ?></td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['no_jo'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['category1'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['kegiatan'] ?><br>
															<?php } ?>
														</td>

														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['stakeholder'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['bukti'] ?><br>
															<?php } ?>
														</td>
														<td>
															<?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= number_format($hslrc['real_cost']) ?><br>
															<?php } ?>
														</td>
														<td><?php
															$rc = mysql_query("SELECT * from pf_real_cost as rc
														left join pf_log on rc.id_pf_log=pf_log.id_pf_log
														where no_reff_keu='$hasil4[no_reff_keu]' ");
															while ($hslrc = mysql_fetch_array($rc)) {
															?>
																<?= $hslrc['bank'] ?><br>
															<?php } ?>
														</td>
														<td>
															<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
														</td>
													</tr>
												<?php $no_real_cost++;
												} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(document).ready(function() {
							$('#myTable2').dataTable();
						});
					</script>
			</section>



		<?php
			break;

		case 'HUT':
			$bulan = date('n');
			$type = "HUT";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'HUT%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable2').dataTable();
				});
				$(function() {
					$('.select2').select2()
				});
			</script>
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
						<h3 class="box-title text-blue text-bold">FORM INPUT HUTANG</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_op_ap" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_op_ap">
											<input type="hidden" name="act2" value="HUT">
											<input type="hidden" name="dk" value="D">
											<label>HUT NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id="product">
									<div class="row">
										<div class="col-sm-1 w-content">
											<label>JO :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-sm-1">
											<label>JO NUMBER</label>
											<input type="text" class="form-control" id="id_pf_est_cost0" name="id_pf_est_cost[]" placeholder="Job Order " readonly>
										</div>
										<div class="col-sm-2">
											<label>TYPE COST :</label>
											<select class="form-control" name="category1[]" required>
												<option value="OP AP">OP AP</option>
												<option value="X">X</option>
												<option value="HUTANG LAIN">HUTANG LAIN</option>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>VENDOR / CUSTOMER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<option><b>VENDOR</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-2">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>
							</div>
							<script type='text/javascript'>
								var hutRow = 1;

								function addMore() {
									$("#product").append(`
											<div class="hut-${hutRow} mt-15 product-item row">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(${hutRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_est_cost${hutRow}" name="id_pf_est_cost[]" placeholder="Job Order" readonly>
												</div>
												<div class="col-sm-2">												
													<select class="form-control" name="category1[]" required>
														<option value="OP AP">OP AP</option>													
														<option value="X">X</option>
														<option value="HUTANG LAIN">HUTANG LAIN</option>
													</select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                    <option><b>VENDOR</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from pf group by cust_name");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
													<?php $nov++;
													} ?>
                                                  </select>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>												
												<div class="col-lg-1">
													<input class="mt-1" type="file" name="nm_file${hutRow}[]" multiple>
												</div>
											</div>`);
									$(function() {
										$('.select2').select2()
									})
									hutRow++;
								}

								function deleteRow() {
									if (hutRow > 1) {
										$(`.hut-${hutRow - 1}`).remove();
										hutRow--;
									}
								}

								function openwindow(idrow) {
									var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
									var popup = window.open("modul/mod_jurnal_keg/tabel_est_cost_hut.php?idrow=" + idrow, "", features);
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
					</form>
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar Hutang</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=HUT" method="POST">
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
												<th>TYPE COST</th>
												<th>KEGIATAN</th>
												<th>STAKEHOLDER</th>
												<th>BUKTI</th>
												<th>VALUE</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from pf_real_cost 													
												where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
												no_reff_keu like 'HUT%'
												and no_reff_keu not like '%_AP'
												group by no_reff_keu
												order by id_pf_real_cost desc");
											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_pf_real_cost = $hasil4['id_pf_real_cost'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
													<td><?= $hasil4['no_reff_keu'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
													join pf_log on rc.id_pf_log=pf_log.id_pf_log
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_jo'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
													join pf_log on rc.id_pf_log=pf_log.id_pf_log 
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>

													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost 
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
													where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= number_format($hslrc['real_cost']) ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'PIUT':
			$bulan = date('n');
			$type = "PIUT";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'PIUT%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 8);
			$bulankemaren = substr($hasil['no_reff_keu'], 6, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable21').dataTable();
				});
				$(function() {
					$('.select2').select2()
				});
			</script>
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
						<h3 class="box-title text-blue text-bold">FORM INPUT PIUTANG</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_piut" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act" value="tambah_piut">
											<input type="hidden" name="act2" value="PIUT">
											<input type="hidden" name="dk" value="D">
											<label>PIUT NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff_keu" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>
								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-sm-1 w-content">
											<label>INV :</label>
											<br>
											<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(0)"><span class="fa fa-search"></button>
										</div>
										<div class="col-sm-1">
											<label>INV NUMBER</label>
											<input type="text" class="form-control" id="id_pf_invoice0" name="id_pf_invoice[]" placeholder="NO INVOICE " readonly>
										</div>
										<div class="col-lg-2">
											<label>TYPE :</label>
											<select class="form-control" name="category1[]" required>
												<option value="PENJUALAN">PENJUALAN</option>
												<option value="PIUTANG">PIUTANG</option>
												<option value="PIUTANG LAIN">PIUTANG LAIN</option>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>VENDOR / CUSTOMER :</label>
											<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
												<option><b>VENDOR</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>REAL CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
												<?php $nov++;
												} ?>
												<option><b>CUSTOMER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("SELECT * from pf group by cust_name");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
												<?php $nov++;
												} ?>
											</select>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-1">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>

								<script type='text/javascript'>
									var piutRow = 1;

									function addMore() {
										$("#product").append(`
											<div class="piut-${piutRow} mt-15 product-item row">
												<div class="col-sm-1 w-content">
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindow(${piutRow})"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-1">
													<input type="text" class="form-control" id="id_pf_invoice${piutRow}" name="id_pf_invoice[]" placeholder="NO INVOICE" readonly>
												</div>
												<div class="col-lg-2">
													<select class="form-control" name="category1[]" required>
														<option value="PENJUALAN">PENJUALAN</option>
														<option value="PIUTANG">PIUTANG</option>
														<option value="PIUTANG LAIN">PIUTANG LAIN</option>
													</select>
												</div>
												<div class="col-sm-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-sm-2">
													<select class="form-control select2" style="width: 100%;" name="stakeholder[]" id="pilih">
                                                    <option><b>VENDOR</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_vendor order by nm_vendor asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_vendor'] ?>"><?= $hslv['nm_vendor'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_cust'] ?>"><?= $hslv['nm_cust'] ?></option>
													<?php $nov++;
													} ?>
													<option><b>CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("SELECT * from pf group by cust_name");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['cust_name'] ?>"><?= $hslv['cust_name'] ?></option>
													<?php $nov++;
													} ?>
                                                  </select>
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-sm-1">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="real_cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>												
												<div class="col-lg-1">
													<input class="mt-1" type="file" name="nm_file${piutRow}[]" multiple>
												</div>
											</div>`);
										$(function() {
											$('.select2').select2()
										})
										piutRow++;
									}

									function deleteRow() {
										if (piutRow > 1) {
											$(`.piut-${piutRow - 1}`).remove();
											piutRow--;
										}
									}

									function openwindow(idrow) {
										var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
										var popup = window.open("modul/mod_jurnal_keg/tabel_invoice.php?idrow=" + idrow, "", features);
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
			</section>

			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>
					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar Piutang</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=PIUT" method="POST">
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
									<table id="myTable21" class="table table-striped table-bordered">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>NO REFF</th>
												<th>JO NUMBER</th>
												<th>INV NUMBER</th>
												<th>TYPE OPS</th>
												<th>KEGIATAN</th>
												<th>STAKEHOLDER</th>
												<th>BUKTI</th>
												<th>VALUE</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from pf_real_cost 
													where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
													no_reff_keu like 'PIUT%' 
													group by no_reff_keu
													order by id_pf_real_cost desc");
											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_pf_real_cost = $hasil4['id_pf_real_cost'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
													<td><?= $hasil4['no_reff_keu'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_invoice as inv
														join pf_log on inv.id_pf_log=pf_log.id_pf_log 
														where id_pf_invoice='$hasil4[id_pf_invoice]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_jo'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost as rc
														join pf_invoice on rc.id_pf_invoice=pf_invoice.id_pf_invoice
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_invoice'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost 
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>

													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT * from pf_real_cost
														where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= number_format($hslrc['real_cost']) ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
								$('#myTable21').dataTable();
				</script>
			</section>

		<?php
			break;

		case 'BALIK_OP':
			$bulan = date('n');
			$type = "BBK";
			$date = date('ym');
			$query = mysql_query("SELECT * from pf_real_cost where  no_reff_keu like 'BBK%' order by no_reff_keu desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff_keu'], 7);
			$bulankemaren = substr($hasil['no_reff_keu'], 5, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' '));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable2').dataTable();
				});
			</script>

			<section class="content-header">
				<h1>Jurnal Keuangan</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu">Jurnal Keuangan</a></li>
					<li class="active">Form Input Balik OP</li>
				</ol>
			</section>

			<section class="content">

				<div class="row">
					<div class="col-md-4">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title text-blue text-bold">FORM BALIK OP CASH</h3>

								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
								</div>
							</div>

							<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=balik_op_kas" method="POST" enctype="multipart/form-data">
								<div class="box-body">
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>DATE :</label>
													<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">

													<input type="hidden" name="module" value="jurnal_keu2">
													<input type="hidden" name="act" value="balik_op_kas">
													<input type="hidden" name="act2" value="BALIK_OP">
												</div>
											</div>
										</div>

										<div class="form-group" id='product'>
											<div class="row">
												<div class="col-sm-2">
													<label>JO :</label>
													<br>
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowKas(0)"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-10">
													<label>NO JO (OP CASH)</label>
													<input type="text" class="form-control" id="id_op_kas0" name="id_op_kas" placeholder="Job Order " readonly>
												</div>
											</div>
										</div>

										<script type='text/javascript'>
											var bbkRow = 1;

											function addMore() {
												$("#product").append(`
													<div class="mt-15 product-item row bbk-${bbkRow}">
														<div class="col-sm-1">
															<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowKas(${bbkRow})"><span class="fa fa-search"></button>
														</div>
														<div class="col-sm-11">
															<input type="text" class="form-control" id="id_op_kas${bbkRow}" name="id_op_kas[]" placeholder="Job Order" readonly>
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

											function openwindowKas(idrow) {
												var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
												var popup = window.open("modul/mod_jurnal_keg/tabel_op_kas.php?idrow=" + idrow, "", features);
											}
										</script>



										<div class="box-footer">
											<button type="submit1" class="btn bg-blue text-bold pull-right">SUBMIT</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title text-blue text-bold">FORM BALIK OP AP</h3>

								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
								</div>
							</div>

							<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=balik_op_ap" method="POST" enctype="multipart/form-data">
								<div class="box-body">
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>DATE :</label>
													<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">

													<input type="hidden" name="module" value="jurnal_keu2">
													<input type="hidden" name="act" value="balik_op_ap">
													<input type="hidden" name="act2" value="BALIK_OP">
												</div>
											</div>
										</div>

										<div class="form-group" id='product2'>
											<div class="row">
												<div class="col-sm-2">
													<label>OP :</label>
													<br>
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowAp(0)"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-10">
													<label>NO JO (OP AP)</label>
													<input type="text" class="form-control" id="id_op_ap0" name="id_op_ap" placeholder="Job Order " readonly>
												</div>
											</div>
										</div>

										<script type='text/javascript'>
											var opAp = 1;

											function addMoreAp() {
												$("#product2").append(`
													<div class="mt-15 product-item row opap-${opAp}">
														<div class="col-sm-1">
															<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowAp(${opAp})"><span class="fa fa-search"></button>
														</div>
														<div class="col-sm-11">
															<input type="text" class="form-control" id="id_op_ap${opAp}" name="id_op_ap[]" placeholder="Job Order" readonly>
														</div>
													</div>
												`);
												opAp++;
											}

											function deleteRowAp() {
												if (opAp > 1) {
													$(`.opap-${opAp - 1}`).remove();
													opAp--;
												}
											}

											function openwindowAp(idrow) {
												var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
												var popup = window.open("modul/mod_jurnal_keg/tabel_op_ap.php?idrow=" + idrow, "", features);
											}
										</script>



										<div class="box-footer">
											<button type="submit1" class="btn bg-blue text-bold pull-right">SUBMIT</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-md-4">
						<div class="box box-default">
							<div class="box-header with-border">
								<h3 class="box-title text-blue text-bold">FORM BALIK OP AR</h3>

								<div class="box-tools pull-right">
									<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
								</div>
							</div>

							<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=balik_op_ar" method="POST" enctype="multipart/form-data">
								<div class="box-body">
									<div class="box-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>DATE :</label>
													<input type="text" name="tgl_pf_real_cost" class="form-control" value="<?= date('Y-m-d') ?>">

													<input type="hidden" name="module" value="jurnal_keu2">
													<input type="hidden" name="act" value="balik_op_ar">
													<input type="hidden" name="act2" value="BALIK_OP">
												</div>
											</div>
										</div>

										<div class="form-group" id='product'>
											<div class="row">
												<div class="col-sm-2">
													<label>JO :</label>
													<br>
													<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowAR(0)"><span class="fa fa-search"></button>
												</div>
												<div class="col-sm-10">
													<label>NO JO (OP CASH)</label>
													<input type="text" class="form-control" id="id_op_ar0" name="id_op_ar" placeholder="Job Order " readonly>
												</div>
											</div>
										</div>

										<script type='text/javascript'>
											var bbkRow = 1;

											function addMore() {
												$("#product").append(`
													<div class="mt-15 product-item row bbk-${bbkRow}">
														<div class="col-sm-1">
															<button type="button" class="btn bg-light-blue text-bold" onclick="openwindowAR(${bbkRow})"><span class="fa fa-search"></button>
														</div>
														<div class="col-sm-11">
															<input type="text" class="form-control" id="id_op_kas${bbkRow}" name="id_op_kas[]" placeholder="Job Order" readonly>
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

											function openwindowAR(idrow) {
												var features = "left=200,top=100,menubar=no,location=no,width=960,height=720,scrollbars=yes,resizable=no";
												var popup = window.open("modul/mod_jurnal_keg/tabel_op_ar.php?idrow=" + idrow, "", features);
											}
										</script>



										<div class="box-footer">
											<button type="submit1" class="btn bg-blue text-bold pull-right">SUBMIT</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold mt-15">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>
					<div class="box-header with-border">
						<h3 class="box-title"><b class="text-blue">Tabel Daftar Balik OP</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
					</div>
					<div class="box-body">
						<form name="submit" action="?module=jurnal_keu2&act=BALIK_OP" method="POST">
							<div class="col-md-3">
								<input class="form-control" type="date" name="tgl_aw">
							</div>

							<div class="col-md-1">
								<h4>Sampai : </h4>
							</div>
							<div class="col-md-3">
								<input class="form-control" type="date" name="tgl_ak">
							</div>
							<div class="col-md-1">
								<h4 class="box-title text-blue text-bold mt-15">Tampilan</h4>
							</div>
							<div class="col-md-2">
								<select class="form-control" name="categoryJu" required>
									<option value="SEMUA">SEMUA</option>
									<option value="OP CASH">OP CASH</option>
									<option value="OP AP">OP AP</option>
									<option value="OP AR">OP AR</option>
								</select>
							</div>
							<div class="col-md-1">
								<button class="pull-right btn bg-gray text-blue text-bold" type="submit">OK</button>
							</div>
						</form>
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
												<th>TYPE COST</th>
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
											$tampil = $_POST['categoryJu'];
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like '%_AP' or no_reff_keu like '%_AR'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											if ($tampil == 'OP CASH') {
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like '%_AP' and no_reff_keu like 'BBK%'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											} elseif ($tampil == 'OP AP') {
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like '%_AP' and no_reff_keu like 'HUT%'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											} elseif ($tampil == 'OP AR') {
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like '%_AR' and no_reff_keu like 'BBM%'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											} else {
												$query4 = mysql_query("SELECT * from pf_real_cost as rc
											left join pf_log on rc.id_pf_log=pf_log.id_pf_log
											left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
											where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and
											no_reff_keu like '%_AP' or no_reff_keu like '%_AR'
											group by no_reff_keu
											order by id_pf_real_cost desc");
											}

											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_pf_real_cost = $hasil4['id_pf_real_cost'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
													<td><?= $hasil4['no_reff_keu'] ?></td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['no_jo'] ?><br>
														<?php } ?>
													</td>
													<td>

														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['desc_est_cost'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= number_format($hslrc['real_cost']) ?><br>
														<?php } ?>
													</td>
													<td><?php
														$rc = mysql_query("select * from pf_real_cost as rc
												left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
												where no_reff_keu='$hasil4[no_reff_keu]' ");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bank'] ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'CASH':
			$bulan = date('n');
			$type = "CASHNJO";
			$date = date('ym');
			$query = mysql_query("SELECT * from keu_non_jo where  no_reff like 'CASHNJO%' order by no_reff desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff'], 11);
			$bulankemaren = substr($hasil['no_reff'], 9, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' - 1 months'));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
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
						<h3 class="box-title text-blue text-bold">FORM INPUT KEU NON JO</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_keu_njo" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act2" value="CASH">
											<input type="hidden" name="dk" value="K">
											<label>CASH NJO NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff" class="form-control" value="<?= $no_reff_keu ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_keu" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-lg-2">
											<label>TYPE :</label>
											<select class="form-control" name="category1[]">
												<option value="OVERHEAD">OVERHEAD</option>
												<option value="MUTASI">MUTASI</option>
												<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
											</select>
										</div>
										<div class="col-lg-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-lg-2">
											<label>STAKEHOLDER :</label>
											<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
											<datalist id="data">
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>">
													<?php $nov++;
												} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
														<option value="<?= $hslv['nm_cust'] ?>">
														<?php $nov++;
													} ?>
														<option><b>CUSTOMER</b></option>
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from pf group by cust_name");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
															<option value="<?= $hslv['cust_name'] ?>">
															<?php $nov++;
														} ?>

											</datalist>
										</div>
										<div class="col-lg-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-lg-2">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
												$query4 = mysql_query("SELECT * from bank");
												while ($hasil4 = mysql_fetch_array($query4)) {
												?>
													<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
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
									var cashRow = 1;

									function addMore() {
										$("#product").append(`
											<div class="row mt-15 cash-${cashRow}">
												<div class="col-lg-2">
													<select class="form-control" name="category1[]">
														<option value="OVERHEAD">OVERHEAD</option>
														<option value="MUTASI">MUTASI</option>
														<option value="PENGELUARAN LAIN">PENGELUARAN LAIN</option>
													</select>
												</div>
												<div class="col-lg-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
												</div>
												<div class="col-lg-2">
													<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
													<datalist id="data">
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
														<option value="<?= $hslv['nm_vendor'] ?>">
														<?php $nov++;
														} ?>
														<option><b>REAL CUSTOMER</b></option>
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from data_cust order by nm_cust asc");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
														<option value="<?= $hslv['nm_cust'] ?>">
														<?php $nov++;
														} ?>
														<option><b>CUSTOMER</b></option>
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from pf group by cust_name");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
														<option value="<?= $hslv['cust_name'] ?>">
														<?php $nov++;
														} ?>
															
													</datalist>
												</div>
												<div class="col-lg-1">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
												</div>
												<div class="col-lg-2">
													<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
												</div>
												<div class="col-lg-1">
													<select class="form-control" name="bank[]" required>
														<option value="">Pilih</option>
														<?php
														$query4 = mysql_query("SELECT * from bank");
														while ($hasil4 = mysql_fetch_array($query4)) {
														?>
															<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
															<?php } ?>	
													</select>
												</div>
												<div class="col-lg-1">
													<input class="mt-1" type="file" name="nm_file${cashRow}[]" multiple>
												</div>
											</div>
										`);
										cashRow++;
									}

									function deleteRow() {
										if (cashRow > 1) {
											$(`.cash-${cashRow - 1}`).remove();
											cashRow--;
										}
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
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar BBM</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
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
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from keu_non_jo
											where tgl_keu between '$tgl_aw' and '$tgl_ak' and
											no_reff like 'CASHNJO%'
											group by no_reff
											order by id_keu desc");
											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_keu = $hasil4['id_keu'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_keu'] ?></td>
													<td><?= $hasil4['no_reff'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT category1 from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT kegiatan from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT stakeholder from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bukti from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT cost from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['cost'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bank from keu_non_jo
												where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bank'] ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'HUT_NJO':
			$bulan = date('n');
			$type = "HUTNJO";
			$date = date('ym');
			$query = mysql_query("SELECT * from keu_non_jo where  no_reff like 'HUTNJO%' order by no_reff desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff'], 10);
			$bulankemaren = substr($hasil['no_reff'], 8, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' - 1 months'));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
		?>
			<script>
				$(document).ready(function() {
					$('#myTable2').dataTable();
				});
			</script>
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
						<h3 class="box-title text-blue text-bold">FORM INPUT HUTANG NON JO</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_keu_njo" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act2" value="HUT_NJO">
											<input type="hidden" name="dk" value="K">
											<label>HUT NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_keu" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<div class="form-group" id="product">
									<div class="row">
										<div class="col-sm-2">
											<label>TYPE :</label>
											<select class="form-control" name="category1[]">
												<option value="HUTANG">HUTANG</option>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>VENDOR / CUSTOMER :</label>
											<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
											<datalist id="data">
												<option><b>STAKEHOLDER</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>">
													<?php $nov++;
												} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
														<option value="<?= $hslv['nm_cust'] ?>">
														<?php $nov++;
													} ?>
														<option><b>CUSTOMER</b></option>
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from pf group by cust_name");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
															<option value="<?= $hslv['cust_name'] ?>">
															<?php $nov++;
														} ?>

											</datalist>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-2">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
												$query4 = mysql_query("SELECT * from bank");
												while ($hasil4 = mysql_fetch_array($query4)) {
												?>
													<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>
							</div>
							<script type='text/javascript'>
								var hutRow = 1;

								function addMore() {
									$("#product").append(`
										<div class="row mt-15 hut-${hutRow}">
											<div class="col-sm-2">
												<select class="form-control" name="category1[]">
													<option value="HUTANG">HUTANG</option>
												</select>
											</div>
											<div class="col-sm-2">
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
											</div>
											<div class="col-sm-2">
												<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
												<datalist id="data">
													<option><b>SAKEHOLDER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_vendor'] ?>">
													<?php $nov++;
													} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['nm_cust'] ?>">
													<?php $nov++;
													} ?>
													<option><b>CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from pf group by cust_name");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
													<option value="<?= $hslv['cust_name'] ?>">
													<?php $nov++;
													} ?>
														
												</datalist>
											</div>
											<div class="col-sm-1">
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
											</div>
											<div class="col-sm-2">
												<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
											</div>
											<div class="col-lg-1">
												<select class="form-control" name="bank[]" required>
													<option value="">Pilih</option>
													<?php
													$query4 = mysql_query("SELECT * from bank");
													while ($hasil4 = mysql_fetch_array($query4)) {
													?>
														<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
														<?php } ?>	
												</select>
											</div>
											<div class="col-lg-1">
												<input class="mt-1" type="file" name="nm_file0[]" multiple>
											</div>
										</div>
										`);
									hutRow++;
								}

								function deleteRow() {
									if (hutRow > 1) {
										$(`.hut-${hutRow - 1}`).remove();
										hutRow--;
									}
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
					</form>
				</div>
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar Hutang</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=HUT" method="POST">
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
												<th>TYPE COST</th>
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
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from keu_non_jo
												where tgl_keu between '$tgl_aw' and '$tgl_ak' and
												no_reff like 'HUTNJO%'
												group by no_reff
												order by id_keu desc");
											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_keu = $hasil4['id_keu'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_keu'] ?></td>
													<td><?= $hasil4['no_reff'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT category1 from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT kegiatan from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT stakeholder from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bukti from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT cost from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['cost'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bank from keu_non_jo
													where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bank'] ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
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

		case 'PIUT_NJO':
			$bulan = date('n');
			$type = "PIUTNJO";
			$date = date('ym');
			$query = mysql_query("SELECT * from keu_non_jo where  no_reff like 'PIUT_NJO%' order by no_reff desc limit 1");
			$hasil = mysql_fetch_array($query);
			$urut = substr($hasil['no_reff'], 11);
			$bulankemaren = substr($hasil['no_reff'], 9, 2);
			$bulanini = date('m');

			if ($bulankemaren != $bulanini && $urut != 001) {
				$urut = 0;
			}
			$urut = $urut + 1;
			$no_urut = sprintf("%03s", $urut);
			$no_reff_keu = "$type$date$no_urut";

			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])) {
				$tgl_aw = date('Y-m-01', strtotime($hari_ini . ' - 1 months'));
				$tgl_ak = date('Y-m-t', strtotime($hari_ini));

				$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			} else {
				$tgl_aw = $_POST['tgl_aw'];
				$tgl_ak = $_POST['tgl_ak'];

				$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
				$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
			}
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
						<h3 class="box-title text-blue text-bold">FORM INPUT PIUTANG NON JO</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>

					<form name="submit1" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_keu_njo" method="POST" enctype="multipart/form-data">
						<div class="box-body">
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input type="hidden" name="module" value="jurnal_keu2">
											<input type="hidden" name="act2" value="PIUT">
											<input type="hidden" name="dk" value="D">
											<label>PIUT NJO NUMBER :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="no_reff" class="form-control" value="<?= $no_reff_keu ?>" readonly>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>DATE :</label>
											<input type="text" name="tgl_keu" class="form-control" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>
								<div class="form-group" id='product'>
									<div class="row">
										<div class="col-sm-2">
											<label>TYPE COST :</label>
											<select class="form-control" name="category1[]">
												<option value="PIUTANG">PIUTANG</option>
											</select>
										</div>
										<div class="col-sm-2">
											<label>KEGIATAN :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="kegiatan[]" placeholder="Description" class="form-control">
										</div>
										<div class="col-sm-2">
											<label>VENDOR :</label>
											<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
											<datalist id="data">
												<option><b>VENDOR</b></option>
												<?php
												$nov = 1;
												$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
												while ($hslv = mysql_fetch_array($qryv)) {
												?>
													<option value="<?= $hslv['nm_vendor'] ?>">
													<?php $nov++;
												} ?>
													<option><b>REAL CUSTOMER</b></option>
													<?php
													$nov = 1;
													$qryv = mysql_query("select * from data_cust order by nm_cust asc");
													while ($hslv = mysql_fetch_array($qryv)) {
													?>
														<option value="<?= $hslv['nm_cust'] ?>">
														<?php $nov++;
													} ?>
														<option><b>CUSTOMER</b></option>
														<?php
														$nov = 1;
														$qryv = mysql_query("select * from pf group by cust_name");
														while ($hslv = mysql_fetch_array($qryv)) {
														?>
															<option value="<?= $hslv['cust_name'] ?>">
															<?php $nov++;
														} ?>

											</datalist>
										</div>
										<div class="col-sm-1">
											<label>BUKTI :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
										</div>
										<div class="col-sm-2">
											<label>COST :</label>
											<input onkeyup="this.value = this.value.toUpperCase()" type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
										</div>
										<div class="col-lg-1">
											<label>BANK :</label>
											<select class="form-control" name="bank[]" required>
												<option value="">Pilih</option>
												<?php
												$query4 = mysql_query("SELECT * from bank");
												while ($hasil4 = mysql_fetch_array($query4)) {
												?>
													<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-1">
											<label>FILE :</label>
											<input class="mt-1" type="file" name="nm_file0[]" multiple>
										</div>
									</div>
								</div>

								<div id='product'></div>
								<script type='text/javascript'>
									var piutRow = 1;

									function addMore() {
										$("#product").append(`
												<div class="row mt-15 piut-${piutRow}">
													<div class="col-sm-2">
														<select class="form-control" name="category1[]">
															<option value="PIUTANG">PIUTANG</option>
														</select>
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="kegiatan[]" placeholder="Description" class="form-control">
													</div>
													<div class="col-sm-2">
														<input class="form-control" list="data" name="stakeholder[]" id="pilih" placeholder="Searching .....">
														<datalist id="data">
															<option><b>VENDOR</b></option>
															<?php
															$nov = 1;
															$qryv = mysql_query("select * from data_vendor order by nm_vendor asc");
															while ($hslv = mysql_fetch_array($qryv)) {
															?>
															<option value="<?= $hslv['nm_vendor'] ?>">
															<?php $nov++;
															} ?>
															<option><b>REAL CUSTOMER</b></option>
															<?php
															$nov = 1;
															$qryv = mysql_query("select * from data_cust order by nm_cust asc");
															while ($hslv = mysql_fetch_array($qryv)) {
															?>
															<option value="<?= $hslv['nm_cust'] ?>">
															<?php $nov++;
															} ?>
															<option><b>CUSTOMER</b></option>
															<?php
															$nov = 1;
															$qryv = mysql_query("select * from pf group by cust_name");
															while ($hslv = mysql_fetch_array($qryv)) {
															?>
															<option value="<?= $hslv['cust_name'] ?>">
															<?php $nov++;
															} ?>
																
														</datalist>
													</div>
													<div class="col-sm-1">
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="bukti[]" placeholder=" Bukti " class="form-control">
													</div>
													<div class="col-sm-2">
														<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="cost[]" placeholder=" (IDR) Tanpa Titik koma" class="form-control">
													</div>
													<div class="col-lg-1">
														<select class="form-control" name="bank[]" required>
															<option value="">Pilih</option>
															<?php
															$query4 = mysql_query("SELECT * from bank");
															while ($hasil4 = mysql_fetch_array($query4)) {
															?>
																<option name="name_real_user" value="<?= $hasil4['nama_bank'] ?>"><?= $hasil4['nama_bank'] ?></option>
																<?php } ?>	
														</select>
													</div>
													<div class="col-lg-1">
														<input class="mt-1" type="file" name="nm_file${piutRow}[]" multiple>
													</div>
												</div>
											`);
										piutRow++;
									}

									function deleteRow() {
										if (piutRow > 1) {
											$(`.piut-${piutRow - 1}`).remove();
											piutRow--;
										}
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
			</section>

			<section class="content">
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title text-blue text-bold">TABEL KEGIATAN KEUANGAN</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
						</div>
					</div>
					<div class="box-header with-border row">
						<div class="col-md-6">
							<h3 class="box-title"><b class="text-blue">Tabel Daftar BBM</b> dari tgl <strong><?= $tgl_aw_str ?></strong> s/d <strong><?= $tgl_ak_str ?></strong> </h3>
						</div>
						<div class="col-md-6">
							<form name="submit" action="?module=jurnal_keu2&act=PIUT" method="POST">
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
									<table id="myTable21" class="table table-striped table-bordered">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>NO REFF</th>
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
											$no_real_cost = 1;
											$query4 = mysql_query("SELECT * from keu_non_jo
													where tgl_keu between '$tgl_aw' and '$tgl_ak' and
													no_reff like 'PIUTNJO%'
													group by no_reff
													order by id_keu desc");
											while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
												$id_keu = $hasil4['id_keu'];
											?>
												<tr>
													<td><?= $no_real_cost ?></td>
													<td><?= $hasil4['tgl_keu'] ?></td>
													<td><?= $hasil4['no_reff'] ?></td>
													<td>
														<?php
														$rc = mysql_query("SELECT category1 from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['category1'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT kegiatan from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['kegiatan'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT stakeholder from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['stakeholder'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bukti from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bukti'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT cost from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['cost'] ?><br>
														<?php } ?>
													</td>
													<td>
														<?php
														$rc = mysql_query("SELECT bank from keu_non_jo
														where id_keu=$id_keu");
														while ($hslrc = mysql_fetch_array($rc)) {
														?>
															<?= $hslrc['bank'] ?><br>
														<?php } ?>
													</td>
													<td>
														<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=jurnal_keu2&act=print&id=<?= $id_pf_real_cost ?>&id_pf=<?= $hasil4['id_pf'] ?>&reff=<?= $type ?>&no_reff_keu=<?= $hasil4['no_reff_keu'] ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php $no_real_cost++;
											} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>
					$(document).ready(function() {
								$('#myTable21').dataTable();
				</script>
			</section>

		<?php
			break;

		case 'tambah_image':
			$id_pf_real_cost = $_GET['id'];
			$query = mysql_query("select * from pf_real_cost as prc
				join users on prc.user_pf_real_cost=users.id_users
				left join pf on prc.id_pf=pf.id_pf
				where id_pf_real_cost=$id_pf_real_cost");
			$hasil = mysql_fetch_array($query);
			$id_pf = $hasil['id_pf'];
			$id_pf_real_cost = $hasil['id_pf_real_cost'];
			$id_est_cost = $hasil['id_est_cost'];
			$id_revenue = $hasil['id_revenue'];

		?>
			<section class="content-header">
				<h1>JURNAL KEUANGAN</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2">Jurnal Keuangan</a></li>
					<li><a href="oklogin.php?module=jurnal_keu2&act=jurnal&id=<?= $id_pf ?>">Form Jurnal Keuangan</a></li>
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
						<div class="modal fade" id="keu2<?= $id_pf_real_cost ?>" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content" style="color: black;">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"></button>
										<h5>Tambah Images</h5>
									</div>
									<form name="submit" action="<?= $aksi ?>?module=jurnal_keu2&act=tambah_images" method="POST" enctype="multipart/form-data">
										<div class="modal-body">
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?= $id_pf ?>">
												<input type="hidden" name="id_est_cost" value="<?= $id_est_cost ?>">
												<input type="hidden" name="id_revenue" value="<?= $id_revenue ?>">
												<input type="hidden" name="id_pf_real_cost" value="<?= $id_pf_real_cost ?>">
											</div>
											<div class="form-group">
												<label>DATE:</label>
												<input type="text" class="form-control" name="tgl_pf_real_cost" value="<?= date('Y-m-d') ?>" readonly>
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
						<a class="btn btn-default btn-sm" data-toggle="modal" href="#keu2<?= $id_pf_real_cost ?>">+</a>

					</div>

				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<!-- form start -->
							<form name="submit2" action="<?= $aksi ?>?module=jurnal_keu2&act=hapus_gambar" method="POST">
								<div class="box-body">
									<h4>NOMOR REFERENSI : <?= $hasil['no_reff_keu'] ?></h4>
									<h4>JOB ORDER NUMBER : <?= $hasil['no_jo'] ?></h4>
									<h4>DESCRIPTION : <?= $hasil['kegiatan'] ?></h4>
									<style>
										.kotak {
											border: 4px solid #575D63;
											margin: 10px;
											padding: 5px;
											width: 250px;
										}

										.img {
											width: 250px;
										}
									</style>
									<?php
									$id_pf_real_cost = $hasil['id_pf_real_cost'];
									$query = mysql_query("select * from images_db where id_pf_real_cost='$id_pf_real_cost' and id_pf='$id_pf'");
									while ($hasil = mysql_fetch_array($query)) {
										$id_images_db = $hasil['id_images_db'];

									?>
										<div class="kotak col-md-3 checkbox-wrapper">
											<input type="hidden" name="id_pf_real_cost" value="<?= $hasil['id_pf_real_cost'] ?>">
											<input type="checkbox" name="check[]" value="<?= $id_images_db ?>" />
											<img width="200px" src="images/data_op/<?= $hasil['nm_file'] ?>"> <br> <a href="images/data_op/<?= $hasil['nm_file'] ?>" target='blank'> <?= $hasil['nm_file'] ?> </a>
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