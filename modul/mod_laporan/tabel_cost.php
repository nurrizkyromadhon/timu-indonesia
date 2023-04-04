<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_laporan/aksi_cost.php";
	switch($_GET[act]){
		// Tampil User
		default:
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
			<!--<meta http-equiv="refresh" content="10" />-->

			<script type="text/javascript">					
					$(function () {
						$("#myTable").DataTable();
					});
				
			</script>

				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Tabel Laporan</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->					

                  <div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">TABEL LAPORAN</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-eye"></i></button>
							</div>
						</div>

						<div class="box-header with-border row">
							<div class="col-md-6">
								<h3 class="box-title"><b class="text-blue">Tabel Laporan Cost</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
							</div>
							<div class="col-md-6">
								<form name="submit" action="?module=cost" method="POST">
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
                                <!-- OP CASH -->
								<div class="tabel-responsive">
									<div class="col-md-12">
                                    <div>
                                        <b class="text-danger">TABEL REVENUE SALDO TERAKHIR : Rp. </b>
                                        <b id='jmlOpcash'></b><br>
										<b class="text-danger">TABEL COST SALDO TERAKHIR : Rp. </b>
                                        <b id='jmlOpcash2'></b>
                                        <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=cost&act=print_cost_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" target="_blank"><span class="fa fa-print"></a>
                                        <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=cost&act=excel_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" ><span class="fa fa-save"></a>
                                    </div>    
									<table id="myTable" class="table table-striped table-bordered">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>												                                                
												<th>REVENUE</th>
												<th>COST</th>
                                                <th>SALDO REVENUE</th>										
                                                <th>SALDO COST</th>										
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_revenue as prc
                                                join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' group by prc.id_pf_log order by tgl_pf asc");
                                                while ($hasil=mysql_fetch_array($qry_oc)){
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
                                                        $saldo_revenue = $saldo_revenue + $total_revenue;

														//Total Real Cost
														$total_real_cost=0;
														$jml_real_cost=0;
														$query3=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
														while($hasil3=mysql_fetch_array($query3)){
															$jml_real_cost=$hasil3['real_cost'];
															$total_real_cost=$total_real_cost+$jml_real_cost;
														}
														$saldo_rc = $saldo_rc + $total_real_cost;

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
                                                <td><?=$hasil['tgl_pf']?></td>
                                                <td><?=$hasil['no_jo']?></td>                                                                                                                                                                                                                                                                                                                                                                                                
                                                <td>                                                    
                                                    <?=number_format($total_revenue)?>
                                                </td>
												<td><?=number_format($total_real_cost)?></td>
                                                <td><?=number_format($saldo_revenue)?></td>
												<td><?=number_format($saldo_rc)?></td>
                                                <td>
                                                    <a class="btn bg-black btn-sm" href="?module=cost&act=cost_jo&id_pf_log=<?=$id_pf_log?>&no_jo=<?=$hasil['no_jo']?>" target="_blank"><span class="fa fa-eye"></a>	
                                                    <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=cost&act=print_cost_jo&id=<?= $id_pf_log ?>" target="_blank"><span class="fa fa-print"></a>
                                                    <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=revenue&act=excel&id=<?= $id_pf_log ?>" ><span class="fa fa-save"></a>                                                    
                                                </td>
                                            </tr>
                                            <?php 
                                                $no++; } } 
                                                $jmlSaldoak=number_format($saldo_revenue); 
                                                $jmlSaldoak2=number_format($saldo_rc); 
                                            ?>
                                            <script>
                                                var x = "<?=$jmlSaldoak?>";
												var x2 = "<?=$jmlSaldoak2?>";
                                                document.getElementById("jmlOpcash").innerHTML = x ;
                                                document.getElementById("jmlOpcash2").innerHTML = x2 ;
                                            </script>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box default-->	
			<?php	
		break;

		case "cost_jo":
            $id_pf_log=$_GET['id_pf_log'];
            $no_jo=$_GET['no_jo'];
			?>
				<script type="text/javascript">					
					$(document).ready(function() {
						$('#myTable').dataTable();
						$('#myTable2').dataTable();
					});
					$(function () {
						$('.select2').select2()											
					})				
				</script>
				<section class="content-header">
					<h1>COST</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Laporan</a></li>
						<li class="active">Cost</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">COST JO <?=$no_jo?></h3>
						</div>						
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
                                    <div class="tabel-responsive">
                                        <div class="col-md-12">
                                        <table id="myTable" class="table table-striped table-bordered">
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
													<th>TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost where id_pf_log=$id_pf_log AND category1 IN ('OP CASH','OP AP') order by id_pf_real_cost desc");
                                                    while ($hsl=mysql_fetch_array($qry_oc)){														                                                        
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
														<td><?=$hsl['tgl_pf_real_cost']?></td>														
														<td><?=$hsl['no_reff_keu']?></td>														
														<td><?=$hsl['category1']?></td>														
														<td><?=$hsl['kegiatan']?></td>														
														<td><?=$hsl['stakeholder']?></td>														
														<td><?=$hsl['bukti']?></td>																																																																						
														<td><?=number_format($hsl['real_cost'])?></td>																																																																						
														<td>
															<?php
																$saldo=$saldo+$hsl['real_cost'];
																echo number_format($saldo);
															?>
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

					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title text-blue text-bold">REVENUE JO <?=$no_jo?></h3>
						</div>						
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
                                    <div class="tabel-responsive">
                                        <div class="col-md-12">
                                        <table id="myTable2" class="table table-striped table-bordered">
                                            <thead class="bg-blue">
                                                <tr>
                                                    <th>NO</th>                                                    
                                                    <th>TYPE REVENUE</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>QTY</th>
                                                    <th>RATE</th>
                                                    <th>VALUE</th>										
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_revenue as prc
                                                    join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                    where prc.id_pf_log='$id_pf_log'");
                                                    while ($hsl_oc=mysql_fetch_array($qry_oc)){
														$saldo = 0;
														$saldo = $hsl_oc['qty_revenue'] * $hsl_oc['revenue'];                                                        
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['type_revenue']?></td>
                                                    <td><?=$hsl_oc['desc_revenue']?></td>
                                                    <td><?=$hsl_oc['qty_revenue']?></td>
                                                    <td><?=number_format($hsl_oc['revenue'])?></td>
                                                    <td><?=number_format($hsl_oc['qty_revenue'] * $hsl_oc['revenue'])?></td>                                                                                                        
                                                    <?php 
                                                
                                                    $saldo_ak=$saldo_ak+$saldo;
                                                    ?>
                                                    
                                                    <td><?=number_format($saldo_ak)?></td>
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
				</section>
				<script>
				  $(function () {
					//Initialize Select2 Elements
					$(".select2").select2();
				  });
				</script>
			<?php
			break;
		
            case "print_op_cash_jo":
            $id_pf_log = $_GET['id'];
            ?>
                <section class="content-header">
                    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
                    <style type="text/css">
                    @page {
                    size: Legal;
                    size: portrait; 
                    margin: 5mm 5mm 5mm;
                    font-size:13px;
                    }
                        #marginkiri{
                        margin:10mm 10mm 5mm 20mm;
                        }
                        #garis{
                        border-top: 1px solid #afbcc6;
                        border-bottom: 1px solid #eff2f6;
                        height: 0px;
                        }
                    </style>
                    <div class="box-body">
                                <table id="table" border='1'>
                                    
                                        <tr>
                                            <th>NO</th>
                                            <th>DATE</th>
                                            <th>JO NUMBER</th>
                                            <th>NAMA CUSTOMER</th>
                                            <th>NO REFF KEUANGAN</th>
                                            <th>KEGIATAN</th>
                                            <th>STAKEHOLDER</th>
                                            <th>D</th>
                                            <th>K</th>										
                                            <th>ACTION</th>
                                        </tr>
                                    
                                    <tbody>
                                        <?php
                                        $no=1;
                                            $qry_oc=mysql_query("select * from pf_real_cost as prc
                                            join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                            where prc.id_pf_log='$id_pf_log' and no_reff_keu like 'BBK%' and category1 IN ('OP CASH', 'BIAYA')  ");
                                            while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                $op_balik= substr($hsl_oc['no_reff_keu'],10,3);
                                        ?>
                                        <tr>
                                            <td><?=$no?></td>
                                            <td><?=$hsl_oc['tgl_pf_real_cost']?></td>
                                            <td><?=$hsl_oc['no_jo']?> - <?=$hsl_oc['id_pf_log']?></td>
                                            <td><?=$hsl_oc['cust_name']?></td>
                                            <td><?=$hsl_oc['no_reff_keu']?></td>
                                            <td><?=$hsl_oc['kegiatan']?></td>
                                            <td><?=$hsl_oc['stakeholder']?></td>
                                            <?php
                                                if($op_balik != '_AP'){
                                                    $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                            ?>
                                                    <td><?=number_format($hsl_oc['real_cost'])?></td>
                                                    <td></td>
                                            <?php        
                                                }else{
                                                    $saldo_ob=$saldo_ob+$hsl_oc['real_cost'];
                                            ?>       
                                                    <td></td>
                                                    <td><?=number_format($hsl_oc['real_cost'])?></td>
                                            <?php 
                                            } 
                                            $saldo_ak=$saldo_oc-$saldo_ob;
                                            ?>
                                            
                                            <td><?=number_format($saldo_ak)?></td>
                                        </tr>
                                        <?php $no++; } ?>
                                    </tbody>
                                </table>
                    </div>
                </section>
                    <!-- JS Print -->
                    <script type="text/javascript">
                        $(function () {				
                        window.print();
                        });
                    </script>   
            <?php 
            break;
	
	case "list_proforma":
	?>
    <section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel cancel Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU NUmber</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='0' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
<?php
	break;
	
	case "detail":
?>
                <section class="content-header">
					<h1>DETAIL MJO</h1>
					<ol class="breadcrumb">
						<li><a href="oklogin.php?module=home"><i class="fa fa-dashboard"></i>Home</a></li>
						<li>1. MJO</li>
						<li class="active">DETAIL MJO</li>
					</ol>
				</section>
				<?php
				$id_pf = $_GET['id']; 
				$no = 1;
				$queryd = mysql_query("SELECT * FROM pf where id_pf=$id_pf");
				$hasild = mysql_fetch_array($queryd);
					
				?>	
				<!-- Main content -->
				<section class="content">
					
				  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<!--<button type="button" class="btn btn-default btn-sm" onclick="location.href='<?php echo '?module=aproval&act=tambah'; ?>';" ><i class="fa fa-plus"></i></button>
						<h3 class="box-title"> - Tambah Proforma</h3>-->
					</div>
						<!-- /.box-header -->
			
					<div class="bg-primary">
						<div class="box-body">
							
						<div class="col-md-5">
							<table style="width:100%" >
								<tr>
									<td>NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['no_pf'] ?></td>		
								</tr>
								<tr>
									<td>DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['tgl_pf'])) ?></td>		
								</tr>
								<tr>
									<td>CUSTOMER NAME</td>	
									<td>:</td>
									<td><?= $hasild['cust_name'] ?></td>		
								</tr>
								<tr>
									<td style="vertical-align:top">ADDRESS</td>	
									<td style="vertical-align:top">:</td>
									<td><?= $hasild['address_pf'] ?></td>		
								</tr>
								<tr>
									<td>SHIPMENT</td>	
									<td>:</td>
									<td><?= $hasild['shipment'] ?></td>		
								</tr>
								<tr>
									<td>QUANTITY</td>	
									<td>:</td>
									<td><?= $hasild['qty_pf'] ?> - <?=$hasild['type_qty']?></td>		
								</tr>
								<tr>
									<td>ROUTE</td>	
									<td>:</td>
									<td><?= $hasild['route_pf'] ?></td>		
								</tr>
								<tr>
									<td>PU/DEL DATE</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['pudel_date']))  ?> </td>		
								</tr>
								<tr>
									<td>PU/DEL LOCAtION</td>	
									<td>:</td>
									<td><?= $hasild['pudel_location'] ?> </td>		
								</tr>
								<tr>
									<td>CREDIT TERM</td>	
									<td>:</td>
									<td><?= $hasild['ct'] ?> HARI</td>		
								</tr>
								<tr>
									<td>SALES</td>	
									<td width=15>:</td>
									<td><?= $hasild['sales'] ?> </td>		
								</tr>
								<tr>
									<td style="vertical-align:top" width=35%>SPECIAL ORDER REQUES - 
										
									</td>

									<td style="vertical-align:top">:</td>
									<td style="vertical-align:top">
										<?php
										$no_sor=1;
											$query1 = mysql_query("select * from pf_sor where id_pf=$id_pf");
											while ($hasil1=mysql_fetch_array($query1)){
												$id_pf_sor=$hasil1['id_pf_sor'];
										?>
											<?=$no_sor?>. <?=$hasil1['desc_sor']?><br>

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
									<td><?= $hasild['no_jo'] ?></td>		
								</tr>												
								<tr>
									<td>CUSTOMER REFF</td>	
									<td>:</td>
									<td><?= $hasild['cust_ref'] ?></td>		
								</tr>
								<tr>
									<td>CUSTOMER CODE</td>	
									<td>:</td>
									<td><?= $hasild['cust_code'] ?></td>		
								</tr>
								<tr>
									<td>PIC</td>	
									<td>:</td>
									<td><?= $hasild['pic'] ?></td>		
								</tr>
								<tr>
									<td>PHONE</td>	
									<td>:</td>
									<td><?= $hasild['phone'] ?></td>		
								</tr>
								<tr>
									<td>SHIPPING/FORWARDING</td>	
									<td>:</td>
									<td><?= $hasild['sf'] ?></td>		
								</tr>
								<tr>
									<td>VESSEL/VOYAGE</td>	
									<td>:</td>
									<td><?= $hasild['vv'] ?></td>		
								</tr>
								<tr>
									<td>ETB/ETD</td>	
									<td>:</td>
									<td><?=date("d M y ", strtotime($hasild['etb'])) ?>/<?=date("d M y", strtotime($hasild['etd'])) ?></td>		
								</tr>
								<?php
									if($hasild['shipment']!="EMKL IMPORT"){
								?>					
								<tr>
									<td>OPEN STACK</td>	
									<td>:</td>
									<td><?= date("d M y h:i:s", strtotime($hasild['openstack'])) ?> </td>		
								</tr>
								<tr>
									<td>CLOSING TIME CONTAINER</td>	
									<td>:</td>
									<td><?=date("d M y h:i:s", strtotime($hasild['ctc']))  ?> </td>		
								</tr>
								<tr>
									<td>CLOSING TIME DOCUMENT</td>	
									<td>:</td>
									<td><?=date("d M y h:i:s", strtotime($hasild['ctd'])) ?> </td>		
								</tr>
									<?php }?> 
									<?php 
									if($hasild['shipment']!="EMKL IMPORT"){ ?>
								<tr>
									<td>B/L NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['bl_number'] ?> </td>		
								</tr>
								<tr>
									<td>AJU NUMBER</td>	
									<td>:</td>
									<td><?= $hasild['aju_number'] ?> </td>		
								</tr>
									<?php } ?>
									<tr>
									<td style="vertical-align:top">REAL CUSTOMER - 
											
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
										<?php $no_ru++; } ?>
									</td>
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
											if($hasild['aprove']=="batal"){
										?>
											<img src="images/aproved/batal.png" width="150" height="150">

										<?php } elseif ($hasild['aprove']=="0"){ ?>

											<h2>PROFORMA</h2>
										<?php	
										}elseif ($hasild['aprove']=="42"){
										?>	
											<img src="images/aproved/aproved.png" width="150" height="150">
										<?php	
										}elseif($hasild['aprove']=="BILL"){
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
						
					<!--<div class="bg-default">
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
									</a>
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>REVENUE</th>
											<th>QTY</th>
											<th>SUM</th>
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
											<td><?=number_format($hasil2['revenue'])?></td>
											<td><?=$hasil2['qty_revenue']?></td>
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
									
									<table class="table table-striped">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>EST COST</th>
											<th>QTY</th>
											<th>SUM</th>
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
									<label>ESTIMASI PROFIT AND LOST</label>	
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
					</div>-->
      			</div>
				</section> 	
				
				<section class="content">
					<div class="box box-default">
						<div class="box-header">
							<h3 class="box-title">TABEL JURNAL OPERASIONAL</h3>
						</div>
						<div class="box-body">
						
							
							<div class="col-sm-12">
							<!-- /.col -->
							<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>STATUS</th>
												<th>TYPE</th>
												<th>DESCRIPTION 1</th>
												<th>DESCRIPTION 2</th>
												<th>STAKE HOLDER</th>
												<th>IMAGES</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("select * from pf_operasional as pfo 
												join pf on pfo.id_pf = pf.id_pf
												where pfo.id_pf=$id_pf
												order by id_pf_operasional desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
												$id_pf_operasional=$hasil4['id_pf_operasional'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_operasional']?></td>
												<td><?=$hasil4['no_jo']?></td>
												<td><?=$hasil4['status_pf_operasional']?></td>
												<td><?=$hasil4['desc1']?></td>
												<td><?=$hasil4['desc2']?></td>
												<td><?=$hasil4['desc3']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												<td>
													<a class="btn btn-primary" onclick="location.href='<?php echo '?module=jurnal_operasional&act=tambah_image&id='.$id_pf_operasional; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
											<?php $no_real_cost++; } ?>	
											</tr>
										</tbody>
									</table>
							</div>
						</div>	
							<div class="col-sm-6">
								<div class="tabel-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>KEGIATAN</th>
												<th>KATEGORY</th>
												<th>DESCRIPTION</th>
												<th></th>
												<th>STAKEHOLDER</th>
												<th>VALUE</th>
												<th>STATUS INV</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query5=die("select * from pf_real_cost as rc
												join pf on rc.id_pf=pf.id_pf 
												join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
												where rc.id_pf=$id_pf
												order by id_pf_real_cost desc");
												while($hasil5=mysql_fetch_array($query5) or die(mysql_error())){
													$id_pf_real_cost=$hasil5['id_pf_real_cost'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil5['tgl_pf_real_cost']?></td>
												<td><?=$hasil5['no_jo']?></td>
												<td><?=$hasil5['kegiatan']?></td>
												<td><?=$hasil5['category1']?></td>
												<td><?=$hasil5['type_est_cost']?></td>
												<td><?=$hasil5['desc_est_cost']?></td>
												<td><?=$hasil5['stakeholder']?></td>
												<td><?=number_format($hasil5['real_cost'])?></td>
												<td><?=$hasil5['status_keu']?></td>
												
												<td>
													<a class="btn btn-primary" onclick="location.href='<?php echo '?module=jurnal_keu2&act=tambah_image&id='.$id_pf_real_cost; ?>';"><span class="fa  fa-file-image-o"></span></a>
												</td>
											</tr>
											<?php $no_real_cost++; } ?>	
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</section>

				
<?php
	break;
	case "list_aprove":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel Aprove Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU Number</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='42' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	  	
<?php
	break;
	case "list_cancel":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel cancel Proforma</label>
			</div>
			<div class="box box-body">
			<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Date</th>
							<th>Proforma Number</th>
							<th>JO Number</th>
							<th>B/L Number</th>
							<th>AJU NUmber</th>
							<th>Customer Name</th>
							<th>Status</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf where aprove='batal' order by tgl_pf ");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<td><?=$hasil['aprove']?></td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
<?php
	break;
	case "list_total":
?>
	<section class="content">
		<!-- SELECT2 EXAMPLE -->
		<div class="box-default">
		    <div class="box box-header">
				<label>List Tabel total Proforma</label>
			</div>
			<div class="box box-body">
				<table id="myTable" class="table table-striped">
					<thead>
						<tr>
							<th>NO</th>
							<th>DATE</th>
							<th>PROFORMA NUMBER</th>
							<th>JO NUMBER</th>
							<th>B/L NUMBER</th>
							<th>AJU NUMBERr</th>
							<th>CUSTOMER NAME</th>
							<!--<th>Status</th>-->
							<th>STATUS</th>
						</tr>
						
					</thead>
					<tbody>
						<?php
						$no=1;
						$query=mysql_query("select * from pf order by tgl_pf");
						while($hasil=mysql_fetch_array($query)){

						
						?>
						<tr>
							<td><?=$no?></td>
							<td><?=$hasil['tgl_pf']?></td>
							<td><?=$hasil['no_pf']?></td>
							<td><?=$hasil['no_jo']?></td>
							<td><?=$hasil['bl_number']?></td>
							<td><?=$hasil['aju_number']?></td>
							<td><?=$hasil['cust_name']?></td>
							<!--<td><?=$hasil['aprove']?></td>-->
							<td>
							<?php
								$query5=mysql_query("select status_pf_operasional from pf_operasional where id_pf=$hasil[id_pf] and id_pf_operasional!='' order by id_pf_operasional desc limit 1 ");
								$hasil5=mysql_fetch_array($query5);
								echo $hasil5['status_pf_operasional'];
							?>
							</td>
						</tr>
						<?php
						$no++; }
						?>
					</tbody>
				</table>
				<script>
					$(function () {
						$("#myTable").DataTable();
					});
				</script>
			</div>
		</div>
	</section>	
	<?php
	break;
	}
}
?>
