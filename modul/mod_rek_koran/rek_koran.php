<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_rek_koran/aksi_rek_koran.php';
    switch ($_GET[act]) { // Tampil User
        default: 
			// Menentukan tanggal awal bulan dan akhir bulan
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw= date('Y-m-01', strtotime($hari_ini. ''));
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
				<section class="content-header">
					<h1>Saldo Bank</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. Saldo Bank</li>
						<li class="active">Saldo Bank Terakhir</li>
					</ol>
				</section>
				
				<!-- Main content -->
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<!-- Modal -->
							<div class="modal fade" id="keu2<?=$id_pf_real_cost?>" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content" style="color: black;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"></button>
											<h4 class="text-bold text-green">Tambah Saldo Bank</h4>
										</div>
										<form name="submit" action="<?=$aksi?>?module=rek_koran&act=tambah_saldo" method="POST" >
										<div class="modal-body" >
											
											<div class="form-group">
												<label>Tanggal:</label>
												<input type="text" class="form-control" name="date" value="<?=date('Y-m-d')?>" >
											</div>																
											<div class="form-group">
												<label>Nama Bank:</label>
												<select class="form-control" name="nm_bank" required>
													<option value="">- SELECT -</option>
													<?php
														$query4=mysql_query("SELECT * from bank");
														while($hasil4=mysql_fetch_array($query4)){
													?>
														<option name="name_real_user" value="<?=$hasil4['nama_bank']?>"><?=$hasil4['nama_bank']?></option>
														<?php } ?>	
												</select>
											</div>
											<div class="form-group">
												<label>Saldo Akhir:</label>
												<input type="text" class="form-control" name="saldo" placeholder="Tanpa titik dan koma" >
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
							<a class="btn bg-blue btn-sm" data-toggle="modal" href="#keu2<?=$id_pf_real_cost?>"><i class="fa fa-plus"></i></a>
							<h3 class="box-title text-bold text-blue">TAMBAH SALDO BANK</h3>
						</div>
						<div class="box-body">
						<div class="row">
							<div class="col-md-12">
								<div class="box-header with-border">
								<h3 class="box-title"><span class="text-blue text-bold">Tabel Saldo Bank</span> dari tgl <b><?=$tgl_aw_str?></b> s/d <b><?=$tgl_ak_str?></b></h3>
							</div>
							<div class="box-body">
								<form name="submit" action="?module=rek_koran" method="POST">
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
							</div>
						</div>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="table-responsive">
									<div class="col-md-12">
										<div class="col-md-6">
											<table id="myTable" class="table table-striped table-responsive table-bordered">
												<thead class="bg-blue">
													<tr>
														<th>NO</th>
														<th>TANGGAL</th>
														<th>NAMA BANK</th>
														<th>SALDO</th>
														<th>AKSI</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$no_saldo=1;
													$qry_saldo1=mysql_query("select * from saldo_bank  order by id desc");		
													$hsltglrow=mysql_fetch_array($qry_saldo1);
													$hsltglak=$hsltglrow['tgl'];	
													$tglawblninput=date('Y-m-01',strtotime($hsltglak));	
															
													$qry_saldo=mysql_query("select * from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' order by tgl desc");

													while($hsl_saldo=mysql_fetch_array($qry_saldo)) {
														$tglsaldo=$hsl_saldo['tgl'];

														if ($hsl_saldo['tgl']==date('Y-m-d')) {?>
														<tr>
															<td><?=$no_saldo?></td>
															<td><?=$tglsaldo?></td>
															<td><?=$hsl_saldo['nm_bank']?></td>
															<td>
																<?=number_format($hsl_saldo['saldo'])?> 
																
															</td>
															<td>
																<!-- Modal -->
																<div class="modal fade" id="edit<?=$hsl_saldo['id']?>" role="dialog">
																	<div class="modal-dialog">
																		<!-- Modal content-->
																		<div class="modal-content" style="color: black;">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal"></button>
																				<h5>EDIT SALDO</h5>
																			</div>
																			<form name="submit2" action="<?=$aksi?>?module=rek_koran&act=update_saldo" method="POST" >
																			<div class="modal-body" >
																																		
																				<div class="form-group">
																					<label>Saldo</label>
																					<input type="hidden" name="id" value="<?=$hsl_saldo['id']?>">
																					<input type="text" class="form-control" name="saldo" value="<?=$hsl_saldo['saldo']?>" >
																				</div>
																				
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																				<button type="submit2" name="bupload" class="btn btn-success">Edit</button>
																			</div>
																			</form>
																		</div>
																	</div>
																</div>
																<a class="btn btn-default btn-sm" data-toggle="modal" href="#edit<?=$hsl_saldo['id']?>"><span class="fa fa-edit"></span></a>
															</td>
														</tr>
													<?php    											
													}else{?>
													<tr>
														<td><?=$no_saldo?></td>
														<td><?=$tglsaldo?></td>
														<td><?=$hsl_saldo['nm_bank']?></td>
														<td><?=number_format($hsl_saldo['saldo'])?></td>
														<td></td>
													</tr>
													<?php } $no_saldo++; } ?> 
												</tbody>
											</table>
										</div>
										<div class="col-md-6">

											<table id="myTable1" class="table table-striped table-bordered">
												<thead class="bg-light-blue"> 
													<tr>
														<th>NO</th>
														<th>TANGGAL</th>	
														<th>TOTAL SALDO BANK</th>
														<th>BBM</th>
														<th>BBK</th>	
														<th>SALDO</th>
													</tr>
												</thead>

												<tbody>
													<?php
													$no=1;
														
														
														$qry=mysql_query("select *,sum(saldo) as jml_saldo from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' group by tgl order by tgl DESC");
														while($hsl=mysql_fetch_array($qry)){
															$tgl_saldo=$hsl['tgl'];
															$jml_saldo=$hsl['jml_saldo'];
													?>
													<tr>
														<td><?=$no?></td>
														<td><?=$tgl_saldo?></td>
														<td><?=number_format($jml_saldo)?></td>
														<td>
															<?php
															$jml_bbm='0';
															$qrybbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBM%' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo'");
															while($hsl_bbm=mysql_fetch_array($qrybbm)){
																$bbm=$hsl_bbm['real_cost'];
																$jml_bbm=$jml_bbm+$bbm;
															}
															echo number_format($jml_bbm);
															?>
														</td>
														<td>
														<?php
															$jml_bbk=0;
															$qrybbk=mysql_query("select * from pf_real_cost where no_reff_keu like 'BBK%' and no_reff_keu not like '%_AP' and kegiatan not like 'X-%' and tgl_pf_real_cost='$tgl_saldo'");
															while($hsl_bbk=mysql_fetch_array($qrybbk)){
																$bbk=$hsl_bbk['real_cost'];
																$jml_bbk=$jml_bbk+$bbk;
															}
															echo number_format($jml_bbk);
														?>
														</td>
														<td>
															<?php
																$saldo=$jml_saldo+$jml_bbm-$jml_bbk;
																echo number_format($saldo);
															?>
														</td>
															<?php
																$tglkemaren = date('Y-m-d', strtotime('-1 days', strtotime($tgl_saldo)));
															?>
														
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
					<div class="row">
										<div class="box box-body">
											<table id="myTable2" class="table table-striped table-bordered">
												<thead>
													<tr>
														<th>NO</th>
														<th>DATE</th>
														<th>BANK</th>
														<th>INPUTAN SALDO</th>
														<th>KETERANGAN</th>
														<th>VALUE</th>
													</tr>
												</thead>
												<tbody>
													<?php
													    $noB=1;
														$qrytglinputsaldo=mysql_query("select * from saldo_bank where tgl between '$tgl_aw' and '$tgl_ak' order by tgl desc");
														while ($hsltglinputsaldo=mysql_fetch_array($qrytglinputsaldo)){  
															$tglinputsaldo=$hsltglinputsaldo['tgl'];
													?>
														<tr>
															<td><?=$noB?></td>
															<td><?=$tglinputsaldo?></td>
															<td><?=$hsltglinputsaldo['nm_bank']?></td>
															<td class="text-right"><?=number_format($hsltglinputsaldo['saldo'])?></td>
															<td>
																<?php 
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																		?>
																			<p><?=$hslket['no_reff_keu']?> - <?=$hslket['kegiatan']?></p>
																		<?php	
																		}
																	}
																?> 
																<br><b>TOTAL :</b>
																<P><b>SALDO AKHIR : </b></P>
															</td>
															<td class="text-right">
																<?php 
																	$jmlD=0;
																	$jmlK=0;
																	$qrybbkbbm=mysql_query("select * from pf_real_cost where no_reff_keu like 'BB%' and no_reff_keu not like '%AP' and tgl_pf_real_cost = '$tglinputsaldo' ");
																	while ($hslket=mysql_fetch_array($qrybbkbbm)){
																		if ($tglinputsaldo == $hslket['tgl_pf_real_cost'] and $hsltglinputsaldo['nm_bank'] == $hslket['bank']){
																			$nilai=$hslket['real_cost'];
																			$dk=$hslket['dk'];
																			if($dk == 'D'){
																				$jmlD=$jmlD+$nilai;
																			}else{
																				$jmlK=$jmlK+$nilai;
																			}
																		?>
																			<p><?=number_format($hslket['real_cost'])?> - (<?=$hslket['dk']?>)</p>
																		<?php	
																		}
																		$total=$jmlD-$jmlK;
																	} $saldoakh=$hsltglinputsaldo['saldo'] + $total ;
																?>
																<br><b><?=number_format($total)?></b> 
																<p><b><?=number_format($saldoakh)?></b></p>
															</td>
														</tr>
													<?php $noB++; } ?>
												</tbody>

											</table>
										</div>		
						<div class="col-md-4">
							<div class="box box-default">
								<div class="box-header with-border">
									<!-- Modal -->
									<div class="modal fade" id="tambah_bank" role="dialog">
										<div class="modal-dialog">
											<!-- Modal content-->
											<div class="modal-content" style="color: black;">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal"></button>
													<h4 class="text-green text-bold">Tambah Bank</h4>
												</div>
												<form name="submit2" action="<?=$aksi?>?module=rek_koran&act=tambah_bank" method="POST" >
												<div class="modal-body" >
													<div class="form-group">
														<label>Nama Bank</label>
														<input type="text" class="form-control" name="nama_bank" >
													</div>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn bg-gray text-red text-bold" data-dismiss="modal">Close</button>
													<button type="submit2" name="bupload" class="btn bg-green">Tambah</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<button type="button" data-toggle="modal" href="#tambah_bank" class="btn bg-blue btn-sm"><i class="fa fa-plus"></i></button>
									<h3 class="box-title"><a><strong>TAMBAH BANK</strong></a></h3>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="table-responsive">
											<div class="col-md-12">
												<table id="myTable" class="table table-hover table-responsive table-bordered table-hover">
													<thead>
														<tr class="info">
															<th>NO</th>
															<th>BANK</th>
															<th>DATE</th>
															<th>ACT</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$no=1;
														$queryBank=mysql_query("SELECT * from bank");
														while($hasil=mysql_fetch_array($queryBank)) { ?>
														<tr>
															<td><?=$no?></td>
															<td><?=$hasil['nama_bank']?></td>
															<td><?=$hasil['created_date']?></td>
															<td>
																<!-- Modal -->
																<div class="modal fade" id="edit_bank<?=$hasil['id_bank']?>" role="dialog">
																	<div class="modal-dialog">
																		<!-- Modal content-->
																		<div class="modal-content" style="color: black;">
																			<div class="modal-header">
																				<button type="button" class="close" data-dismiss="modal"></button>
																				<h5>EDIT SALDO</h5>
																			</div>
																			<form name="submit2" action="<?=$aksi?>?module=rek_koran&act=edit_bank" method="POST" >
																			<div class="modal-body" >
																																		
																				<div class="form-group">
																					<label>Nama Bank</label>
																					<input type="hidden" name="id_bank" value="<?=$hasil['id_bank']?>">
																					<input type="text" class="form-control" name="nama_bank" value="<?=$hasil['nama_bank']?>" >
																				</div>
																				
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn bg-gray text-blue" data-dismiss="modal">Close</button>
																				<button type="submit2" name="bupload" class="btn bg-green">Edit</button>
																			</div>
																			</form>
																		</div>
																	</div>
																</div>
																<a class="btn bg-light-blue btn-sm" data-toggle="modal" href="#edit_bank<?=$hasil['id_bank']?>"><span class="fa fa-edit"></a>
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
					</div>
					
					<script>
						$(document).ready(function(){
						$('#myTable').dataTable();
						$('#myTable1').dataTable();
						$('#myTable2').dataTable();
						});
					</script>
				</section>		
				
		<?php break;
			
		case 'tambah': ?>
			<b>Tambah</b>
		<?php break;
		
		case 'edit': ?>
			<b>Edit</b>
		<?php break;

		case 'edit_job': ?>
			<b>Edit_Job</b>
		<?php break;
	}
}
?>
