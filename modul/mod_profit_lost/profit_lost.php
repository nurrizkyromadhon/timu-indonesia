<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
    echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
    echo '<a href=../../index.php><b>LOGIN</b></a></center>';
} else {
    $aksi = 'modul/mod_profit_lost/aksi_profit_lost.php';
    switch ($_GET[act]) { 
		default: 
			$hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_aw'])){
				$tgl_aw= date('Y-m-01', strtotime($hari_ini. '-1 months'));
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
					$('#myTable').dataTable();
					$('#myTable1').dataTable();
					$('#myTable2').dataTable();
				});
			</script>
			<div class="wraper">
				<section class="content-header">
					<h1>Sales Fee ( Other Charges ) and Print Profit / Lost</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. MJO</li>
						<li class="active">Profit & Lost</li>
					</ol>
				</section>
				
				<!-- Main content -->
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title"><b class="text-blue">Job Order</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
							<div class="box-tools pull-right">
								<a class="btn bg-gray text-blue btn-md text-bold" href="<?=$aksi?>?module=profit_lost&act=excel">Save Excel</a>
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<div class="box-body">
							<div class="row">
								<div class="col-md-9">
									<form name="submit" action="?module=profit_lost" method="POST">
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
								<div class="tabel-responsive">
									<div class="col-md-12">
										<table id="myTable" class="table table-striped">
											<thead class="bg-blue">
												<tr>
													<th>NO</th>
													<th>PROFORMA NUMBER</th>
													<th>JOB ORDER NUMBER</th>
													<th>STATUS</th>
													<th>TOTAL REVENUE</th>
													<th>TOTAL COST</th>													
													<th>SALES FEE</th>
													<th>ACTION</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												$query=mysql_query("SELECT * from pf_log where tgl_pf between '$tgl_aw' and '$tgl_ak' order by tgl_pf desc , no_pf desc");
												while($hasil=mysql_fetch_array($query)){
													if(!empty($hasil['aprove']) and $hasil['aprove']!='batal' ){
														$id_pf=$hasil['id_pf'];
														$id_pf_log=$hasil['id_pf_log'];
														
														//Total Revenue
														$total_revenue=0;
														$jml_revenue=0;
														$query1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log order by id_pf_revenue desc");
														while($hasil1=mysql_fetch_array($query1)){
															
															$jml_revenue=$hasil1['revenue']*$hasil1['qty_revenue'];
															$total_revenue=$total_revenue+$jml_revenue;
														}

														//Total Real Cost
														$total_real_cost=0;
														$jml_real_cost=0;
														$query3=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
														while($hasil3=mysql_fetch_array($query3)){
															$jml_real_cost=$hasil3['real_cost'];
															$total_real_cost=$total_real_cost+$jml_real_cost;
														}

														$jml_value=0;
														$value=0;
														$query6=mysql_query("select * from sales_fee where id_pf=$id_pf");
														while($hasil6=mysql_fetch_array($query6)){
															$value=$value+$hasil6['value_sales_fee'];
															$jml_value=$jml_value+$value;
														}
														
												?>
												<tr>
													<td><?=$no?></td>
													<td><?=$hasil['no_pf']?></td>
													<td><b><?=$hasil['no_jo']?></b></td>
													<td class="text-blue text-bold"><?=$hasil['status_ops']?></td>
													<td><?=number_format($total_revenue)?></td>
													<td><?=number_format($total_real_cost)?></td>													
													<td><?=number_format($jml_value)?></td>
													<td>
													<!--<button type="button" class="btn btn-primary btn-sm" onclick="location.href='<?php echo '?module=profit_lost&act=edit_pl&id='.$id_pf; ?>';" ><i class="fa fa-edit"></i></button>-->
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=profit_lost&act=saveexcel&id_pf=<?= $id_pf ?>&id_pf_log=<?= $id_pf_log ?>"><span class="fa fa-save"></a>
													<a class="btn bg-gray btn-sm" href="<?= $aksi ?>?module=profit_lost&act=print_pl&id_pf=<?= $id_pf ?>&id_pf_log=<?= $id_pf_log ?>" target="_blank"><span class="fa fa-print"></a>
													<!--<button type="button" target="_blank" class="btn bg-gray text-black btn-sm" onclick="location.href='<?php echo $aksi.'?module=profit_lost&act=print_pl&id_pf='.$id_pf; ?>';" ><i class="fa fa-print"></i></button>-->												
													<button type="button" class="btn bg-blue btn-sm" onclick="location.href='<?php echo '?module=profit_lost&act=pl&id='.$id_pf; ?>';" >FEE</i></button>
													<?php if($hasil['status_ops'] != "COMPLETED"){ ?>
														<a class="btn bg-green btn-sm" href="<?= $aksi ?>?module=profit_lost&act=status_ops&id_pf=<?= $id_pf ?>&id_pf_log=<?= $id_pf_log ?>"><span class="fa fa-check"> COMPLETED</a>														
													<?php 
													} ?>
													</td>
												</tr>
												<?php $no++; } } ?>
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
		
		case 'pl': 
		$id_pf=$_GET['id'];
		$query=mysql_query("select * from pf where id_pf=$id_pf");
		$hasil=mysql_fetch_array($query);

		$rev=mysql_query("select * from pf_revenue where id_pf=$id_pf");

		$est_cost=mysql_query("select * from pf_est_cost where id_pf=$id_pf");

		$real_cost=mysql_query("select * from pf_real_cost as prc join pf_est_cost as pec on prc.id_est_cost=pec.id_pf_est_cost where prc.id_pf=$id_pf");
		
		?>
		<div class="content">
			<section class="content-header">
				<h1>SALES FEE</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=proforma">Proforma</a></li>
					<li class="active">Add Sales Fee</li>
				</ol>
			</section>

			<div class="box box-default">
    			<div class="box-header with-border">
    				<h3 class="box-title">FORM INPUT SALES FEE</h3>
    		    </div>
    			<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=profit_lost&act=input_sales_fee&id_pf=<?=$id_pf?>">	
    				<div class="box box-body">
    				<div class="product-item form-group">
    					<div class="col-sm-1">
    							<input type="checkbox" class="pull-left" name="item_index[]">
    					</div>
    					<div class="col-sm-5">
    							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="desc_sales_fee[]" placeholder="Description">
    					</div>
    					<div class="col-sm-4">
    							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="nm_sales[]" placeholder="Sales Name">
    					</div>
    					<div class="col-sm-2">
    							<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="value_sales_fee[]" placeholder="IDR tanpa titik, koma">
    					</div>
    				</div>
    
    				<div id="product1"></div>
    				<script type="text/javascript">
    					var idrow = 1;
    					function addMore1() {
    						idrow++;
    						$("#product1").append("<div class='product-item form-group'><div class='col-sm-1'><input type='checkbox' class='pull-left' name='item_index[]'></div><div class='col-sm-5'><input onkeyup='this.value = this.value.toUpperCase()' type='text' class='form-control' name='desc_sales_fee[]' placeholder='Description'></div><div class='col-sm-4'><input onkeyup='this.value = this.value.toUpperCase()' type='text' class='form-control' name='nm_sales[]' placeholder='Sales Name'></div><div class='col-sm-2'><input onkeyup='this.value = this.value.toUpperCase()' type='text' class='form-control' name='value_sales_fee[]' placeholder='(IDR) tanpa titik, koma'></div></div>");
    					
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
    				</div>
    				
    				<div class="box box-footer">
    					<div class="btn-action float-clear">
    						<input class="btn btn-default" type="button" name="add_item" value="+" onClick="addMore1();" />
    						<input class="btn btn-default" type="button" name="del_item" value="-" onClick="deleteRow1();" />
    						<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
    						<span class="success"><?php if (isset($message)) {echo $message;} ?></span>
    					</div>
    				</div>	
    			</form>				    
            </div>
            
            <div class="box box-default">
                
			<div class="box-header with-border">
				<h3 class="box-title"><b>JOB ORDER NUMBER : <?=$hasil['no_jo']?></b></h3><br>
				<h3 class="box-title"><b>CUSTOMER NAME : <?=$hasil['cust_name']?></b></h3>
			</div>

				<div class="box-body">
					<div class="table-responsive">
						<div class="col-sm-16">
							<div class="box-header with-border">
								<h3 class="box-title">ESTIMASI PROFIT AND LOST</h3>
							</div>
							<table class="table">
								<thead>
									<tr>
										<td><b>1</b></td>
										<td span="4"><b>REVENUE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>DESCRIPTION</th>
										<th>VALUE (IDR)</th>
										<th>QTY</th>
										<th>JUMLAH</th>
									</tr>
									
								</thead>
								<tbody>
									
									<?php
									    $no_rev=1;
									    while($hasilrev=mysql_fetch_array($rev)){
                        					$jml_revenue=$hasilrev['revenue']*$hasilrev['qty_revenue'];
                        					$total_revenue=$total_revenue+$jml_revenue;
									?>
    									<tr>
    									    <td>1.<?=$no_rev?></td>
    									    <td><?=$hasilrev['desc_revenue']?></td>
    									    <td><?=number_format($hasilrev['revenue'])?></td>
    									    <td><?=number_format($hasilrev['qty_revenue'])?></td>
    									    <td><?=number_format($jml_revenue)?></td>
    									</tr>
									<?php $no_rev++; } ?>
									<tr>
									    <td></td>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL</b></td>									    
									    <td><b><?=number_format($total_revenue)?></b></td>
									</tr>
									
									
									<tr>
										<td><b>2</b></td>
										<td span="3"><b>TOTAL REAL COST</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>KEGIATAN</th>
										<th>STAKEHOLDER</th>
										<th>VALUE</th>																				
									</tr>
									<?php
									    $no_rc=1;
									    while($hasilrealcost=mysql_fetch_array($real_cost)){
                        					$jml_real_cost=$hasilrealcost['real_cost'];
                        					$total_real_cost=$total_real_cost+$jml_real_cost;
									?>
									<tr>
										<td>2.<?=$no_rc?></td>
										<td><?=$hasilrealcost['kegiatan']?></td>
										<td><?=$hasilrealcost['stakeholder']?></td>										
										<td><?=number_format($hasilrealcost['real_cost'])?></td>
									</tr>
									
								 	<?php $no_rc++; } ?>
								 	<tr>
									 	<td></td>
									    <td></td>
									    <td><b>TOTAL VALUE</b></td>
									    <td><b><?=number_format($total_real_cost)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>GROSS PROFIT AND LOST</b></td>									    
									    <td><b><?=number_format($total_revenue-$total_real_cost)?></b></td>
									</tr>
									<tr>
										<td><b>3</b></td>
										<td span="4"><b>SALES FEE</b></td>
									</tr>
									<tr>
										<th>NO</th>
										<th>NAMA SALES FEE</th>
										<th>DESCRIPTION SALES FEE</th>
										<th>VALUE</th>																				
										<th>ACTION</th>
									</tr>
									<?php
									    $no_sf=1;
									    $sales_fee=mysql_query("select * from sales_fee where id_pf=$id_pf");
									    while($hasilsalesfee=mysql_fetch_array($sales_fee)){
                        					$jml_sales_fee=$hasilsalesfee['value_sales_fee'];
                        					$total_sales_fee=$total_sales_fee+$jml_sales_fee;
                        					$id_sales_fee=$hasilsalesfee['id_sales_fee'];
									?>
									<tr>
										<td>3.<?=$no_sf?>
										<!-- Modal -->
												<div class="modal fade" id="sales_fee<?=$id_sales_fee?>" role="dialog">
													<div class="modal-dialog">
														<!-- Modal content-->
														<div class="modal-content" style="color: black;">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal"></button>
																<h5>Edit Sales Fee</h5>
															</div>
															<form name="submit1" action="<?=$aksi?>" method="get">
															<div class="modal-body" >
																
																<div class="form-group">
																	<input type="hidden" name="module" value="profit_lost">
																	<input type="hidden" name="act" value="update_profit_lost">
																	<input type="hidden" name="id" value="<?=$id_sales_fee?>">
																	<input type="hidden" name="id_pf" value="<?=$id_pf?>">

																	<label>Description :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="desc_sales_fee" class="form-control" value="<?=$hasilsalesfee['desc_sales_fee']?>">
																</div>

																<div class="form-group">
																	<label>Sales Name :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="nm_sales" class="form-control" value="<?=$hasilsalesfee['nm_sales']?>">
																</div>

																<div class="form-group">
																	<label>Value :</label>
																	<input onkeyup="this.value = this.value.toUpperCase()"  type="text" name="value_sales_fee" class="form-control" value="<?=$hasilsalesfee['value_sales_fee']?>">
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
											
										</td>
										<td><?=$hasilsalesfee['nm_sales']?></td>
										<td><?=$hasilsalesfee['desc_sales_fee']?></td>										
										<td><?=number_format($jml_sales_fee)?></td>
										<td>
											<a class="btn btn-primary btn-sm" data-toggle="modal" href="#sales_fee<?=$id_sales_fee?>"><span class="fa fa-edit"></a> 	
											<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=profit_lost&act=delete_profit_lost&id=<?=$id_sales_fee?>&id_pf=<?=$id_pf?>"><span class="fa fa-trash"></a>
										</td>
									</tr>
									
								 	<?php $no_sf++; } ?>
								 	<tr>
									    <td></td>
									    <td></td>
									    <td><b>TOTAL SALES FEE</b></td>									    
									    <td><b><?=number_format($total_sales_fee)?></b></td>
									</tr>
									<tr>
									    <td></td>
									    <td></td>
									    <td><b>NET PROFIT AND LOST</b></td>									    
									    <td><b><?=number_format($total_revenue-$total_real_cost-$total_sales_fee)?></b></td>
									</tr>
								</tbody>
							</table>	
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<?php 
		break;

		case 'edit_pl': ?>
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
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="no_jurnal_keu" placeholder="Input Nomor...." value="<?= $hasil[
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
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="shipper" value="<?= $hasil[
                   'shipper'
               ] ?>"  autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">ETH/ETD</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="eth" value="<?= $hasil[
                   'eth'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SALES</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="sales" value="<?= $hasil[
                   'sales'
               ] ?>"  autofocus required>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-3 control-label">ROUTE</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="route_pf" value="<?= $hasil[
                   'route_pf'
               ] ?>" autofocus required>
														</div>
													</div>  
													<div class="form-group">
														<label class="col-sm-3 control-label">QUANTITY</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="qty" value="<?= $hasil[
                   'qty'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">SHIPMENT</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="shipment" value="<?= $hasil[
                   'shipment'
               ] ?>" autofocus required>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 control-label">PU/DEL LOCATION</label>
														<div class="col-sm-6">
															<input onkeyup="this.value = this.value.toUpperCase()"  type="text" class="form-control" name="pudel_location" value="<?= $hasil[
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

	}
}
?>
