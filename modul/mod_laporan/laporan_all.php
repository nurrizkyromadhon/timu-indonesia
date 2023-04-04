<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_laporan/aksi_laporan_all.php";
	switch($_GET[act]){
		// Tampil User
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
			$tgl_aw_select=date('Y-m-d',strtotime($tgl_aw));
			$tgl_ak_select=date('Y-m-d',strtotime($tgl_ak));
			
			$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
			$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
			/*echo $tgl_aw;
			echo $tgl_ak;
			break;*/
			
		}
			$tgl1=date('Y-m-d',strtotime($tgl_aw));
			$tgl2=date('Y-m-d',strtotime($tgl_ak));
			$today=date('d-M-Y',strtotime($hari_ini));
			?>
				<section class="content-header">
					<div class="box-body">
						<form name="submit" action="?module=laporan_all" method="POST">
							<div class="col-sm-1">
								<h4>Dari : </h4>
							</div>
							<div class="col-md-2">
								<input class="form-control" type="date" name="tgl_aw">
							</div>
							<div class="col-sm-1">
								<h4>s/d : </h4>
							</div>
							<div class="col-md-2">
								<input class="form-control" type="date" name="tgl_ak">
							</div>
							
							<div class="col-md-1">
								<input class="padding-top-2" type="submit" value="OK">
							
							</div>
						</form>
					</div>
					<h1>Laporan Gabungan dari <?=$tgl_aw_str?> s/d <?=$tgl_ak_str?></h1> 
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Laporan Jurnal Operasional</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
										<div class="row">
									  <div class="table-responsive">
									  <form name="submit" action="<?=$aksi?>?module=hut_user&act=lunas"&id='<?$id_hutang?>' method="post" >
									  <table id="myTable" class="table table-bordered table-striped">
									  <thead>

									  <tr>
										  <th>NO</th>
										  <th>DATE</th>
										  <th>NO PPL</th>
										  <th>JO NUMBER</th>
										  <th>CUST NAME</th>
										  <th>SHIPMENT</th>
										  <th>QUANTITY</th>
										  <th>ROUTE</th>
										  <th>AJU NUMBER</th>
										  <th>B/L NUMBER</th>
										  <th>SHIPPING/FORWARDING</th>
										  <th>VESEL/VOY</th>
										  <th>PU/DEL DATE</th>
										  <th>PU/DEL QTY</th>
										  <th>PU/DEL LOCATION</th>
										  <th>REVENUE</th>
										  <th>EST COST</th>
										  <th>REAL REVENUE</th>
										  <th>REAL COST</th>
										  <th>PROFIT/LOST</thz>
										  <th>SALES INSENTIVE</th>
										  <th>NET MARGIN</th>
										  <th>NO INVOICE</th>
										  <th>TGL INVOICE</th>
										  <th>VALUE</th>
										  <th>DPP</th>
										  <th>PPN</th>
										  <th>JML VALUE</th>
										  <th>DOWN PAYMENT</th>
										  <th>NET VALUE</th>
										  <th>CREDIT TERM</th>
										  <th>DUE DATE</th>	
										  <th>PAYMENT DATE</th>
										  <th>VALUE</th>
										  <th>PPH</th>
										  <th>NET VALUE</th>
										  <th>AKSI</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query=mysql_query("select * from pf_log where tgl_pf between '$tgl_aw' and '$tgl_ak' order by tgl_pf desc");
										while ($hasil=mysql_fetch_array($query)){
										?>
										<tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_pf']?></td>
											<td><?=$hasil['no_pf']?></td>
											<td><?=$hasil['no_jo']?></td>
											<td><?=$hasil['cust_name']?></td>
											<td><?=$hasil['shipment']?></td>
											<td>
											    <?php
												$qry_qty=mysql_query("select * from pf_qty where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_qty=mysql_fetch_array($qry_qty)){
												 echo $hsl_qty['qty']. "-" . $hsl_qty['type1']. "<br>";
												}
												?>
											</td>
											<td><?=$hasil['route_pf']?></td>
											<td><?=$hasil['aju_number']?></td>
											<td><?=$hasil['bl_number']?></td>
											<td><?=$hasil['sf']?></td>
											<td><?=$hasil['vv']?></td>
											<td>
											    <?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['pudel_date']. "<br>";
												}
												?>
											</td>
											<td>
											    <?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['qty']. "-" .$hsl_pudel['type1']."-".$hsl_pudel['type2']."<br>";
												}
												?>
											</td>
											<td>
												<?php
												$qry_pudel=mysql_query("select * from pf_pudel where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_pudel=mysql_fetch_array($qry_pudel)){
												 echo $hsl_pudel['pudel_from']. " to " .$hsl_pudel['pudel_to']."<br>";
												}
												?>
											</td>
											<td>
												<?php
												$total_rev='0';
												$qry_rev=mysql_query("select * from pf_revenue where id_pf='$hasil[id_pf]'");
												while ($hsl_rev=mysql_fetch_array($qry_rev)){
													$jml_rev=$hsl_rev['revenue']*$hsl_rev['qty_revenue'];
													$total_rev=$total_rev+$jml_rev;
												}
												echo number_format($total_rev);
												?>
											</td>
											<td>
											<?php
												$total_ec='0';
												$qry_ec=mysql_query("select * from pf_est_cost where id_pf='$hasil[id_pf]'");
												while ($hsl_ec=mysql_fetch_array($qry_ec)){
													$jml_ec=$hsl_ec['est_cost']*$hsl_ec['qty_est_cost'];
													$total_ec=$total_ec+$jml_ec;
												}
												echo number_format($total_ec);
												?>
											</td> 
											<td>
												<?php
												$total_rev='0';
												$qry_rev=mysql_query("select * from pf_revenue where id_pf_log='$hasil[id_pf_log]'");
												while ($hsl_rev=mysql_fetch_array($qry_rev)){
													$jml_rev=$hsl_rev['revenue']*$hsl_rev['qty_revenue'];
													$total_rev=$total_rev+$jml_rev;
												}
												echo number_format($total_rev);
												?>
											</td>   
											<td>
												<?php
												$total_rc='0';
												$qry_rc=mysql_query("select * from pf_real_cost as prc join pf_est_cost as pec on prc.id_est_cost=pec.id_pf_est_cost where prc.id_pf_log=$hasil[id_pf_log] and category1='OP CASH'");
												while ($hsl_rc=mysql_fetch_array($qry_rc)){
													$jml_rc=$hsl_rc['real_cost'];
													$total_rc=$total_rc+$jml_rc;
												}
												echo number_format($total_rc);
												?>
											</td>   
											<td><?=number_format($total_rev-$total_rc)?></td> 
											<td>
												<?php
												$qry_fee=mysql_query("select * from sales_fee where id_pf_log='$hasil[id_pf_log]'");
												$hsl_fee=mysql_fetch_array($qry_fee);
												echo number_format($hsl_fee['value_sales_fee']);
												?>
											</td> 
											<td>
											<?=number_format($total_rev-$total_rc-$hsl_fee['value_sales_fee'])?>
											</td> 
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													echo $hsl_inv['no_invoice'].'<br>';
												}
												?>
											</td>   
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													echo $hsl_inv['tgl_invoice'].'<br>';
												}
												?>
											</td>    
											<td>
												<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													echo number_format($subtotal).'<br>';
												}
												
												?>
											</td>  
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													echo number_format($dpp).'<br>';
												}
												
												?>
											</td>   
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													echo number_format($ppn).'<br>';
												}
												?>
											</td> 
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													echo number_format($total_inv).'<br>';
												}
												?>
											</td>  
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													echo number_format($dp).'<br>';
												}
												?>
											</td>
											<td>
											<?php
												$subtotal='0';
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													$subtotal='0';
													while ($hasil9=mysql_fetch_array($query9)){
														$id_pf_revenue2=$hasil9['id_pf_revenue'];
														$dpp_proc=$hasil9['dpp']/100;
														$ppn_proc=number_format($hasil9['ppn']/100,3);
														$dp=$hasil9['dp'];

														$query10=mysql_query("select * from pf_revenue where id_pf_revenue=$id_pf_revenue2");
														$hasil10=mysql_fetch_array($query10);
														$subtotal=$subtotal+($hasil10['revenue']*$hasil10['qty_revenue']);
														$dpp=$subtotal*$dpp_proc;
														if($hasil9['dpp']==''){
															$ppn=$subtotal*$ppn_proc;
														}else{
															$ppn=$dpp*$ppn_proc;	
														}
														$total_inv=$subtotal+$ppn;
													} 
													$net=$total_inv-$dp;
													echo number_format($net).'<br>';
												}
												?>
											</td>     
											<td>
												<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													
													while ($hasil9=mysql_fetch_array($query9)){
														$ct=$hasil9['ct_invoice'];
													} 
													$net=$total_inv-$dp;
													echo ($ct).'<br>';
												}
												?>
											</td> 
											<td>
											<?php
												$qry_inv=mysql_query("select * from pf_invoice where id_pf_log='$hasil[id_pf_log]' group by no_invoice
												");
												while($hsl_inv=mysql_fetch_array($qry_inv)){
													$no_invoice=$hsl_inv['no_invoice'];

													$query9=mysql_query("select * from pf_invoice where no_invoice='$no_invoice'");
													
													while ($hasil9=mysql_fetch_array($query9)){
														$ct=$hasil9['ct_invoice'];
														$tgl_inv=$hasil9['tgl_invoice'];
													} 
													$net=$total_inv-$dp;
													echo date("Y-m-d",strtotime("+$ct day",strtotime($tgl_inv))).'<br>'; 
												}
												?>
											</td>     
											 
											<td>
												<?php
												//	$qry_pay_inv=mysql_query("select * from pf_real_cost where id_pf=$hasil['id_pf'] and ");

												?>
											</td>
											<td></td>
											<td></td>  
											<td></td>                 
                                            <td>
                                                <a class="btn btn-primary" onclick="location.href='<?php echo '?module=lap_jurnal_ops&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
                                            </td>
										</tr>
										
										
									  <?php
										
										 $no++; }
									  ?>
									  </tbody>
									</table>
									<!--<center><input type="submit" value="Submit Lunas"></center>-->
									</form>
									</div>
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
							<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=laporan_all&act=excel&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>">Save Excel</a>
							</div>
						</div>
						<!-- /.box-footer -->
				</section>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
	
			<?php
			break;
			case 'tambah_image':
			$id_pf_operasional=$_GET['id'];

			$query=mysql_query("select * from pf_operasional as pfo
			join pf on pfo.id_pf=pf.id_pf
			where id_pf_operasional=$id_pf_operasional");
			$hasil=mysql_fetch_array($query);
			$id_pf=$hasil['id_pf'];
			
		?>
			<section class="content-header">
				<h1>Jurnal Operasional</h1>
				<ol class="breadcrumb">
					<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i> Home</a></li>
					<li><a href="oklogin.php?module=jurnal_operasional">Jurnal operasional</a></li>
					<li><a href="oklogin.php?module=jurnal_operasional&act=jurnal&id=<?=$id_pf?>">Form Jurnal operasional</a></li>
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
						<div class="modal fade" id="operational<?=$id__est_cost?>" role="dialog">
								<div class="modal-dialog">
									<!-- Modal content-->
									<div class="modal-content" style="color: black;">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"></button>
											<h5>Tambah Images</h5>
										</div>
										<form name="submit" action="<?=$aksi?>?module=jurnal_operasional&act=tambah_images" method="POST" enctype="multipart/form-data">
										<div class="modal-body" >
											<div class="form-group">
												<input type="hidden" name="id_pf" value="<?=$id_pf?>">
												<input type="hidden" name="id_pf_operasional" value="<?=$id_pf_operasional?>">
											</div>																
											<div class="form-group">
												<label>DATE:</label>
												<input type="text" class="form-control" name="tgl_pf_operasional" value="<?=date('Y-m-d')?>" readonly>
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
							<a class="btn btn-default btn-sm" data-toggle="modal" href="#operational<?=$id_pf_est_cost?>">+</a>
						
						</div>
						
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="row">
							<div class="col-md-12">	
								<!-- form start -->
							<form name="submit2" action="<?=$aksi?>?module=jurnal_operasional&act=hapus_gambar" method="POST">	
								<div class="box-body">
									<h4>JOB ORDER NUMBER : <?=$hasil['no_jo']?></h4></p>
									<h4>JOB ORDER : <?=$hasil['desc1']?></h4></p>
									<h4>DESCRIPTION : <?=$hasil['desc2']?></h4>
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
									$query=mysql_query("select * from images_db where id_pf=$id_pf  and id_pf_operasional=$id_pf_operasional");
									while ($hasil=mysql_fetch_array($query)){
										$id_images_db=$hasil['id_images_db'];
									?>	
									<div class="kotak col-md-3 checkbox-wrapper">	
										<input type="hidden" name="id_pf_operasional" value="<?=$hasil['id_pf_operasional']?>">
										<input type="checkbox" name="check[]" value="<?=$id_images_db?>"/>
										<img width="200px" src="images/data_op/<?=$hasil['nm_file']?>"><br>	<?=$hasil['nm_file']?> 
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
		
		case 'save_excel' :
		    
		    $date=date('ymd');
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_jurnal_ops($date).xls");
        ?>    
            <table id="myTable" class="table table-bordered table-striped">
									  <thead>

									  <tr>
										  <th>NO</th>
										  <th>DATE</th>
										  <th>JO NUMBER</th>
										  <th>B/L NUMBER</th>
										  <th>AJU NUMBER</th>
										  <th>TYPE</th>
										  <th>KEGIATAN</th>
										  <th>CUST NAME</th>
										  <th>CUST REFF</th>
										  <th>REAL CUST</th>
										  <th>SHIPMENT</th>
										  <th>QUANTITY</th>
										  <th>ROUTE</th>
										  <th>SHIPPINF/FORWARDING</th>
										  <th>VESEL/VOY</th>
										  <th>ETB/ETD</th>
										  <th>PU/DEL DATE</th>
										  <th>PU/DEL LOCATION</th>
										  <th>STAKEHOLDER</th>
										  <th>CUSTOM AND OPERATION</th>
										  <th>SHIPPING/FORWARDING</th>
										  <th>THIRD PARTY</th>
										  <th>CNTR NUMBER</th>
										  <th>SEAL NUMBER</th>
										  <th>SURAT JALAN NUMBER</th>
										  <th>AKSI</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query=mysql_query("select * from pf  
										left join pf_operasional on pf.id_pf=pf_operasional.id_pf 
										left join detail on pf_operasional.id_pf_operasional=detail.id_pf_operasional");
										while ($hasil=mysql_fetch_array($query)){	
											$hut=$hasil['hut'];
											$byr=$hasil['byr'];
											$sisa_hut=$hut-$byr;
											$id_pf_operasional=$hasil['id_pf_operasional'];
											$id_hutang=$hasil['id_hutang'];
											$id_nasabah=$hasil['id_nasabah'];
											$tgl1=$hasil['tgl'];
											$tgl2=date('Y-m-d', strtotime('+30 days', strtotime($tgl1)));
										?>
										<tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_pf_operasional']?></td>
											<td><?=$hasil['no_jo']?></td>
											<td><?=$hasil['bl_number']?></td>
											<td><?=$hasil['aju_number']?></td>
											<td><?=$hasil['desc1']?></td>
											<td><?=$hasil['desc2']?></td>
											<td><?=$hasil['cust_name']?></td>
											<td><?=$hasil['cust_ref']?></td>
											<td><?=$hasil['real_cust']?></td>
											<td><?=$hasil['shipment']?></td>
											<td><?=$hasil['qty_pf']?></td>
											<td><?=$hasil['route_pf']?></td>
											<td><?=$hasil['sf']?></td>
											<td><?=$hasil['vv']?></td>
											<td><?=$hasil['etb']?>/<?=$hasil['etd']?></td>
											<td><?=$hasil['pudel_date']?></td>
											<td><?=$hasil['pudel_location']?></td>
											<td><?=$hasil['stakeholder']?></td>
											<?php
											    if($hasil['desc1']=='CUSTOMS AND OPERATION CHARGES'){
											?>
											<td><?=$hasil['no_kontainer']?></td>
											<?php }else{
											?>
											<td></td>
											<?php } ?>
											
											<?php
											    if($hasil['desc1']=='SHIPPING/FORWARDING CHARGES'){
											?>
											<td><?=$hasil['no_kontainer']?></td>
											<?php }else{
											?>
											<td></td>
											<?php } ?>
											
											<?php
											    if($hasil['desc1']=='THIRD PARTY CHARGES'){
											?>
											<td><?=$hasil['no_kontainer']?></td>
											<?php }else{
											?>
											<td></td>
											<?php } ?>
											
											<?php
											    if ($hasil['desc1']=='TRANSPORTATION CHARGES'){
											?>
											<td><?=$hasil['no_kontainer']?></td>
											<td><?=$hasil['no_seal']?></td>
											<td><?=$hasil['nopol']?></td>
                                            <?php }else{
                                            ?>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <?php
                                            } ?>
                                            
                                            <td>
                                                <a class="btn btn-primary" onclick="location.href='<?php echo '?module=lap_jurnal_ops&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
                                            </td>
										</tr>
										
										
									  <?php
										
										 $no++; }
									  ?>
									  </tbody>
									</table>
    <?php        
		
		break;    
	}   
}
?>
