<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_invoice/aksi_invoice.php';
    switch ($_GET['act']) { // Tampil User
        default: ?>
				<section class="content-header">
					<h1>CREATE INVOICE</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. JURNAL</li>
						<li class="active">INVOCIE</li>
					</ol>
				</section>
				
				<!-- Main content -->
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">JOB ORDER NUMBER</h3>
						</div>

						<div class="box-body">
							<div class="col-lg-6">
								<div class="tabel-responsive">
								<?php	
									$query=mysql_query("select * from pf_invoice order by id_pf_invoice desc limit 1");
									$hasil=mysql_fetch_array($query);
									$urut_inv=$hasil['no_invoice'];
									$bulankemaren=substr("$urut_inv",6,2);
									$bulanini=date('m');
									$urut=substr("$urut_inv",9);
	
									if ($bulankemaren!=$bulanini && $urut != 001){
										$urut='0';
									}
									$urut=$urut+1;
									$no_urut=sprintf("%03s", $urut);

									//echo $no_urut; break;
								?>
									<table id="myTable" class="table table-striped">
											<thead>
												<tr>
													<th>NO</th>
													<th>JOB ORDER NUMBER</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												$query=mysql_query('select * from pf order by no_jo desc');
												while($hasil=mysql_fetch_array($query)){
													
														$id_pf=$hasil['id_pf'];
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasil['no_jo']?></td>
													
													<td>
													<!-- Modal -->
													<div class="modal fade" id="invoice<?=$id_pf?>" role="dialog">
														<form name="submit1" action="<?=$aksi?>?module=invoice&act=tambah_invoice" method="POST">
															<div class="modal-dialog modal-lg">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h5>TAMBAH INVOICE</h5>
																	</div>
																	<div class="row">
																		<div class="modal-body" >
																			<div class="col-sm-6">
																				<input type="hidden" name="id_pf" value="<?=$id_pf?>">
																				<input type="hidden" name="id_pf_revenue" value="<?=$id_pf_revenue?>">
																				<div class="form-group col-sm-6">
																					<label>DATE :</label><br>
																					<input type="text" class="form-control" value="<?=date('Y-m-d')?>" name="tgl_invoice" readonly>
																				</div>
																				
																				<div class="form-group col-sm-6">
																					<label>NO. INVOICE :</label><br>
																					<input type="text" class="form-control" name="no_invoice" value="INV-<?=date('ym')?>-<?=$no_urut?>" readonly>
																				</div>
																			
																				<div class="form-group col-sm-6">
																					<label>CREDIT TERM :</label><br>
																					<input type="text" class="form-control" name="ct_invoice" >
																				</div><br>
																				<div class="form-group col-sm-6">
																					<label>DOWN PAYMENT :</label><br>
																					<input type="text" class="form-control" name="dp">
																				</div><br>
																				<div class="form-group col-sm-6">
																					<input type="checkbox"  name="dpp" value="10"> - <label>DPP 10%</label>
																				</div>
																				<div class="form-group col-sm-6">
																					
																					<input type="checkbox"  name="ppn" value="11" > - <label>PPN 11%</label>
																				</div>
																				<br>
																			</div>
																			<div class="col-sm-6">
																				<div class="form-group">
																				<label>CUSTOMER OR REAL CUSTOMER INVOICE :</label><br>						
																					<select class="form-control" name="id_real_user">
																						<?php
																							$query0=mysql_query("select * from pf where id_pf=$id_pf");
																							$hasil0=mysql_fetch_array($query0);
																						?>
																						<option value="0"><?=$hasil0['cust_name']?></option>
																						<?php
																						$query5=mysql_query("select * from real_user where id_pf=$id_pf");
																						while ($hasil5=mysql_fetch_array($query5)){
																						?>
																						<option value="<?=$hasil5['id_real_user']?>"><?=$hasil5['name_real_user']?></option>
																						<?php
																						}
																						?>
																					</select>
																				</div><br>
																							
																				<div class="form-group">
																				<label><b>REVENUE : </b></label><br>
																				<?php
																					$query6=mysql_query("select * from pf_revenue where id_pf=$id_pf");
																						while ($hasil6=mysql_fetch_array($query6)){
																						?>
																							<input type="checkbox" name="id_pf_revenue[]" value="<?=$hasil6['id_pf_revenue']?>"> <?=$hasil6['type2_revenue']?> - <?=$hasil6['desc_revenue']?> - <?=number_format($hasil6['revenue']*$hasil6['qty_revenue'])?><br>
																						<?php
																						} 
																						?>
																				</div>
																			</div>
																		</div><br><br>
																	</div>
																	<div class="row" align="center">
																		<div class="form-group modal-footer">
																			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																			<button type="submit1" class="btn btn-success">Tambah</button>
																		</div>
																	</div>
																</div>
															</div>
														</form>
													</div>
														<a class="btn btn-default btn-sm" data-toggle="modal" href="#invoice<?=$id_pf?>" align="center">CREATE INVOICE</a>
													</td>
												</tr>
												<?php $no++; }  ?>
											</tbody>	
												
									</table>
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
							<h3 class="box-title">TABEL INVOICE</h3>
							<div class="box-tools pull-right">
							<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=invoice&act=excel&id=<?=$id_pf_real_cost?>">Save Excel</a>
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div class="col-lg-12">
								<div class="tabel-responsive">
									<table id="myTable1" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>NO.</th>
													<th>DATE</th>
													<th>JOB ORDER NUMBER</th>
													<th>NO. INVOICE</th>
													<th>CUSTOMER NAME</th>
													<th>REVENUE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
											<?php 
												$no=1;
												$query7=mysql_query("select * from pf_invoice as pfi
												inner join pf on pfi.id_pf=pf.id_pf
												group by no_invoice
												order by id_pf_invoice desc, no_jo desc ");
												while($hasil7=mysql_fetch_array($query7)){
												$no_invoice=$hasil7['no_invoice'];	
												$id_pf=$hasil7['id_pf'];
												$id_real_user=$hasil7['id_real_user'];	
												$id_pf_revenue=$hasil7['id_pf_revenue'];
												$id_pf_invoice=$hasil7['id_pf_invoice'];
												$id_rev=$hasil7['id_user_order'];
												$id_user_order=substr($id_rev,4);
												$rev=substr($id_rev,0,3);
												
											?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasil7['tgl_invoice']?></td>
													<td><b><?=$hasil7['no_jo']?></b></td>
													<td><?=$hasil7['no_invoice']?></td>
													<?php
													if($id_real_user=='0'){
														
														$query8=mysql_query("select * from pf where id_pf=$id_pf");
														$hasil8=mysql_fetch_array($query8);
													?>	
														<td><?=$hasil8['cust_name']?></td>
														
														<td>
															<?php 
																$query9=mysql_query("select * from pf_invoice as pfi 
																join pf_revenue as pfv on pfi.id_pf_revenue=pfv.id_pf_revenue
																where pfi.no_invoice='$no_invoice'");
																while ($hasil9=mysql_fetch_array($query9)){
															
																echo $hasil9['type2_revenue'].' - '.$hasil9['desc_revenue'].' - '.number_format($hasil9['revenue']).' x '.$hasil9['qty_revenue'].'<br>';
																}
															?>
															
														</td>
													<?php
													} else {
														$query8=mysql_query("select * from real_user where id_real_user=$id_real_user");
														$hasil8=mysql_fetch_array($query8);
													?>	
														<td><?=$hasil8['name_real_user']?></td>
														<td>
															<?php 
																$query9=mysql_query("select * from pf_invoice as pfi 
																join pf_revenue as pfv on pfi.id_pf_revenue=pfv.id_pf_revenue
																where pfi.no_invoice='$no_invoice'");
																while ($hasil9=mysql_fetch_array($query9)){
															
																echo $hasil9['type2_revenue'].' - '.$hasil9['desc_revenue'].' - '.number_format($hasil9['revenue']).' x '.$hasil9['qty_revenue'].'<br>' ;
																}
															?>
															
														</td>
													<?php
													}
													?>
													
													<td>
													<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=invoice&act=delete_invoice&no_invoice=<?=$hasil7['no_invoice']?>"><span class="fa fa-trash"></a>	
													<a class="btn btn-default btn-sm" href="<?= $aksi ?>?module=invoice&act=print&id=<?= $id_pf_invoice ?>" target="_blank"><span class="fa fa-print"></a>
													</td>
												</tr>
											<?php 
											$no++; }
											?>	
											</tbody>
									</table>
								</div>
							</div>
						</div>
						<script>
							$(document).ready(function(){
								$('#myTable1').dataTable();
							});
						</script>
					</div>
				</section>			
		<?php 
		break;
		
		case 'create_invoice': 
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
						<h3 class="box-title">Form Job Order</h3><br>
						<h4 style="color: blue;">** Check Untuk Kebutuhan Create Invoice</h4>
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
															<td>CUSTOMER NAME</td>	
															<td>:</td>
															<td>
																<?= $hasil['cust_name'] ?>
																<input type="checkbox" name="id_pf" value="<?=$id_pf?>"><br>
															</td>		
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
															<td style="vertical-align:top">REAL CUSTOMER</td>
															<td style="vertical-align:top">:</td>
															<td style="vertical-align:top">
																<?php
																$no_ru=1;
																	$query1 = mysql_query("select * from real_user where id_pf=$id_pf");
																	while ($hasil1=mysql_fetch_array($query1)){
																		$id_real_user=$hasil1['id_real_user'];
																?>
																	<?=$no_ru?>. <?=$hasil1['name_real_user']?>
																	<input type="checkbox" name="real_user[]" value="<?=$id_real_user?>">	
																</br>
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
																	<th>CHECK</th>
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
																	<td>
																		<input type="checkbox" name="revenue[]" value="<?=$id_pf_revenue?>">
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
													
														<!-- Modal -->
														<div class="modal fade" id="invoice<?=$id_pf?>" role="dialog">
															<div class="modal-dialog modal-lg">
																<!-- Modal content-->
																<div class="modal-content" style="color: black;">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal"></button>
																		<h5>Tambah Invoice</h5>
																	</div>
																	<form name="submit1" action="<?=$aksi?>?module=invoice&act=tambah_invoice" method="POST">
																	<div class="modal-body" >

																		<div class="form-group col-lg-6">
																			<label>DATE :</label>
																			<input type="date" class="form-control" value="<?=date('Y-m-d')?>" name="tgl_inv" readonly>
																		</div>
																		<div class="form-group col-lg-6">
																			<label>NO INVOICE :</label>
																			<input type="text" class="form-control" name="no_inv" value="INV-<?=date('ym')?>01" readonly>
																		</div>
																		<div class="form-group">
																		<label>Category :</label>
																			<!--<input type="text" name="type2_revenue" class="form-control" value="<?=$hasil2['type2_revenue']?>">-->
																			
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
																			<input type="text" name="desc_revenue" class="form-control">
																		</div>
																		<div class="form-group">
																			<label>Revenue :</label>
																			<input type="text" name="revenue" class="form-control">
																		</div>
																		<div class="form-group">
																			<label>QUANTITY :</label>
																			<input type="text" name="qty_revenue" class="form-control">
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
													<div class="box-footer" align="center">	
														<a class="btn btn-default btn-sm" data-toggle="modal" href="#invoice<?=$id_pf?>" align="center">CREATE INVOICE</a>
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
			
		<?php 
		break;

        
    }
}
?>
