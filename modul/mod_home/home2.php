<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_home/aksi_home.php";
	switch($_GET[act]){
		// Tampil User
		default:
		
			?>
			<!--<meta http-equiv="refresh" content="10" />-->

			<script type="text/javascript">
				$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip(); 
				
				$("#responsecontainer").load("response.php");
						var refreshId = setInterval(function(){
							$("#responsecontainer").load('response.php?randval='+ Math.random());
							}, 1000);
				});
				
					
					$(function () {
						$("#myTable").DataTable();
						$("#myTable1").DataTable();
					});
				
			</script>

				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active"></li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div id="responsecontainer"></div>	

				  	<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">CONTROL TABEL JURNAL</h3>
						</div>
						<!-- /Tabel Perbandingan EST COST dan REAL COST -->
						<div class="box box-body">
							<div class="row">
							<div class="table-responsive">
								<!-- /.col -->
								<div class="col-md-12">
									
										
									<div class="box-header">
										<label>TABEL JOB ORDER </label>
									</div>

									<div class="box-body">
									  <table id="myTable1" class="table table-striped">
										<thead>
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>
												<th>CUSTOMER NAME</th>
												<th>TYPE</th>
												<th>DESCRIPTION 1</th>
												<th>DESCRIPTION 2</th>
												<th>STAKE HOLDER</th>
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no_real_cost=1;
												$query4=mysql_query("select * from pf_operasional as pfo 
												join pf on pfo.id_pf = pf.id_pf
												order by id_pf_operasional desc");
												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
												$id_pf_operasional=$hasil4['id_pf_operasional'];
												$id_pf2=$hasil4['id_pf'];
											?>
											<tr>
												<td><?=$no_real_cost?></td>
												<td><?=$hasil4['tgl_pf_operasional']?></td>
												<td><?=$hasil4['no_jo']?></td>
												<td><?=$hasil4['cust_name']?></td>
												<td><?=$hasil4['desc1']?></td>
												<td><?=$hasil4['desc2']?></td>
												<td><?=$hasil4['desc3']?></td>
												<td><?=$hasil4['stakeholder']?></td>
												
												<td>
													<a class="btn btn-success" onclick="location.href='<?php echo '?module=home&act=detail&id='.$id_pf2; ?>';"><span class="fa fa-eye"></span></a>
												</td>
											<?php $no_real_cost++; } ?>	
											</tr>
										</tbody>
									</table>  
									  <table id="myTable" class="table table-bordered table-striped">
									  <thead>
										<tr>
											<th>NO</th>
											<th>DATE</th>
											<th>STATUS</th>
											<th>CUSTOMER NAME</th>
											<th>PROFORMA NUMBER</th>
											<th>JO NUMBER</th>
											<th>TYPE JURNAL OPERASIONAL</th>
											<th>DESCRIPTION</th>
											
											<th>DETAIL</th>
										</tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										
										$query=mysql_query("select * from pf order by tgl_pf desc");
										while($hasil=mysql_fetch_array($query)){
											$id_pf=$hasil['id_pf'];
											$total_revenue=0;
											$jml_revenue=0;
											$query1=mysql_query("select * from pf_revenue where id_pf=$id_pf order by id_pf_revenue desc");
											while($hasil1=mysql_fetch_array($query1)){
												$jml_revenue=$hasil1['revenue']*$hasil1['qty_revenue'];
												$total_revenue=$total_revenue+$jml_revenue;
											}
											
											$total_est_cost=0;
											$jml_est_cost=0;
											$query3=mysql_query("select * from pf_est_cost where id_pf=$id_pf order by id_pf_est_cost desc");
											while($hasil3=mysql_fetch_array($query3)){
												$jml_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost'];
												$total_est_cost=$total_est_cost+$jml_est_cost;
											}	
									  	?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_pf']?></td>
											<td>
											    <?php
													$query5=mysql_query("select status_pf_operasional from pf_operasional where id_pf=$id_pf and status_pf_operasional!='-' order by id_pf_operasional desc");
													$hasil5=mysql_fetch_array($query5);
												?>
												<?=$hasil5['status_pf_operasional']?>
											</td>
											<td><?=$hasil['cust_name']?></td>
											<td><?=$hasil['no_pf']?></td>
											<td><?=$hasil['no_jo']?></td>
											<td>
											     <?php
											    $query2 = mysql_query("select * from pf_operasional where id_pf=$id_pf order by id_pf_operasional asc");
        										while ($hasil2 = mysql_fetch_array($query2)) { 	
        											//$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
        											//$id_pf_revenue=$hasil2['id_pf_revenue'];
        										echo $hasil2['desc1'].'<br>';
        										    
        										}
											    ?>
											</td>
											<td>
											     <?php
											    $query2 = mysql_query("select * from pf_operasional where id_pf=$id_pf order by id_pf_operasional asc");
        										while ($hasil2 = mysql_fetch_array($query2)) { 	
        											//$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
        											//$id_pf_revenue=$hasil2['id_pf_revenue'];
        										echo $hasil2['desc2'],'<br>';
        										    
        										}
											    ?>
											</td>
											
											<td><a class="btn btn-success" onclick="location.href='<?php echo '?module=home&act=detail&id='.$id_pf; ?>';"><span class="fa fa-eye"></span></a></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									  </table>
									</div>
									
									
									<div class="box-header">
									    <label>JURNAL KEUANGAN</label>
									</div>
									<div class="box-body">
            							<div class="row">
            								<div class="tabel-responsive">
            									<div class="col-md-12">
            									<table id="myTable1" class="table table-striped">
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
            												$query4=mysql_query("select * from pf_real_cost as rc
            												join pf on rc.id_pf=pf.id_pf 
            												join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
            												order by id_pf_real_cost desc");
            												while($hasil4=mysql_fetch_array($query4) or die(mysql_error())){
            													$id_pf_real_cost=$hasil4['id_pf_real_cost'];
            											?>
            											<tr>
            												<td><?=$no_real_cost?></td>
            												<td><?=$hasil4['tgl_pf_real_cost']?></td>
            												<td><?=$hasil4['no_jo']?></td>
            												<td><?=$hasil4['kegiatan']?></td>
            												<td><?=$hasil4['category1']?></td>
            												<td><?=$hasil4['type_est_cost']?></td>
            												<td><?=$hasil4['desc_est_cost']?></td>
            												<td><?=$hasil4['stakeholder']?></td>
            												<td><?=number_format($hasil4['real_cost'])?></td>
            												<td><?=$hasil4['status_keu']?></td>
            												
            												<td>
            													<!-- Modal -->
            													<div class="modal fade" id="jurnal_keu2<?=$id_pf_real_cost?>" role="dialog">
            														<div class="modal-dialog">
            															<!-- Modal content-->
            															<div class="modal-content" style="color: black;">
            																<div class="modal-header">
            																	<button type="button" class="close" data-dismiss="modal"></button>
            																	<h5>Edit Jurnal Keuangan OP</h5>
            																</div>
            																<form name="submit1" action="<?=$aksi?>" method="get">
            																<div class="modal-body" >
            																	<div class="form-group">
            																		<input type="hidden" name="module" value="jurnal_keu">
            																		<input type="hidden" name="act" value="update_rc">
            																		<input type="hidden" name="id" value="<?=$id_pf_real_cost?>">
            																		<input type="hidden" name="id_pf" value="<?=$id_pf?>">
            
            																		<label>DATE :</label>
            																		<input type="date" class="form-control" name="tgl_pf_real_cost" value="<?=$hasil4['tgl_pf_real_cost']?>" readonly >
            																	</div>
            																	<div class="form-group">
            																		<label>CATEGORY 1 :</label>
            																		<select class="form-control" name="category1">
            																			<option value="<?=$hasil4['category1']?>"><?=$hasil4['category1']?></option>
            																			<option value="OP"> ORDER IN PROCCESS </option>
            																			<option value="CASH"> CASH </option>
            																			<option value="BANK"> BANK </option>
            																			<option value="PIUTANG"> PIUTANG </option>
            																			<option value="HUTANG"> HUTANG </option>
            																			<option value="PENDAPATAN"> PENDAPATAN </option>
            																			<option value="BIAYA"> BIAYA </option>
            																		</select>
            																	</div>
            																	<div class="form-group">
            																		<label>CATEGORY 2 :</label>
            																		<select class="form-control" name="category2">
            																			<option value="<?=$hasil4['category2']?>"><?=$hasil4['category2']?></option>
            																			<option value="OP"> ORDER IN PROCCESS </option>
            																			<option value="CASH"> CASH </option>
            																			<option value="BANK"> BANK </option>
            																			<option value="PIUTANG"> PIUTANG </option>
            																			<option value="HUTANG"> HUTANG </option>
            																			<option value="PENDAPATAN"> PENDAPATAN </option>
            																			<option value="BIAYA"> BIAYA </option>
            																		</select>
            																	</div>
            																	<div class="form-group">
            																		<label>STATUS</label>
            																		<select class="form-control" name="status_rc">
            																			<option value="<?=$hasil4['status_rc']?>"><?=$hasil4['status_rc']?></option>
            																			<option value="Keluar"> KELUAR </option>
            																			<option value="Masuk"> MASUK </option>
            																		</select>
            																	</div>
            																	<div class="form-group">
            																	<label>Description 1:</label>
            																		<!--<input type="text" name="type2_revenue" class="form-control" value="<?=$hasil4['category1']?>">-->
            																		
            																		<select class="form-control" name="desc1">
            																			<option value="<?=$hasil4['desc1']?>"><?=$hasil4['desc1']?></option>
            																			<option value="">- PILIH JIKA ALL IN RATE - </option>
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
            																		<label>Description 2 :</label>
            																		<input type="text" name="desc2" class="form-control" value="<?=$hasil4['desc2']?>">
            																	</div>
            																	<div class="form-group">
            																		<label>Description 3 :</label>
            																		<input type="text" name="desc3" class="form-control" value="<?=$hasil4['desc3']?>">
            																	</div>
            																	<div class="form-group">
            																		<label>Description 4 :</label>
            																		<input type="text" name="desc4" class="form-control" value="<?=$hasil4['desc4']?>">
            																	</div>
            																	<div class="form-group">
            																		<label>Stake Holder :</label>
            																		<input type="text" name="stakeholder" class="form-control" value="<?=$hasil4['stakeholder']?>">
            																	</div>
            																	<div class="form-group">
            																		<label>Real Cost :</label>
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
            													<!--<a class="btn btn-primary btn-sm" data-toggle="modal" href="#jurnal_keu2<?=$id_pf_real_cost?>"><span class="fa fa-edit"></a>	
            													<a class="btn btn-danger btn-sm" href="<?=$aksi?>?module=jurnal_keu2&act=delete_pf_real_cost&id=<?=$id_pf_real_cost?>&id_pf=<?=$id_pf?>" onclick="return confirm('Sudah Yakin Mau di Hapus')">
            														<span class="fa fa-trash">
            													</a>-->
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
									
								</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /.box default-->	
				
		break;

		case "tambah":
			?>
				<section class="content-header">
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
						<li class="active">Form Tambah</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Tambah</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=input">
										<div class="box-body">
											FORM TAMBAH
										</div>
										<div class="box-footer">
											<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
										</div>
									</form>
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
		
case "edit":

$id_jurnal = $_GET['id'];
if (empty($id_jurnal)){
		echo'Not Select Data !!';
	}else{
		$edit = mysql_query("select *  from jurnal where id_jurnal='$id_jurnal'");
		$update = mysql_fetch_array($edit);
	}
?>
	<section class="content-header">
		<h1>Edit Data</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Edit Data</a></li>
			<li class="active">Form Edit Data</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

	  <!-- SELECT2 EXAMPLE -->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Form Edit Data</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
			<!-- /.col -->
				<div class="col-md-12">	
				<!-- form start -->
					<div class="box-body">
					<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=home&act=edit">
						<div class="row">
						<!-- /.col -->
						<div class="col-md-12">	
							<!-- form start -->
							<div class="box-body">
								
								<div class="form-group">
								  <label class="col-sm-2 control-label">Tanggal</label>
								  <div class="col-sm-6">
								  	<input type="hidden" class="form-control" name="id_jurnal"  value='<?php echo $update['id_jurnal'];?>'>
									<input type="text" class="form-control" name="tgl"  value="<?php echo $update['tgl'];?>">
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Referensi</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="no_ref"  value='<?php echo $update['no_ref'];?>'>
								  </div>
								</div>
								<div class="form-group">
								  <label class="col-sm-2 control-label">Keterangan</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="ket"  value="<?php echo $update['ket'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Nominal</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="nominal"  value="<?php echo $update['nominal'];?>">
								  </div>
								</div>
								<div class="form-group">
								<label class="col-sm-2 control-label">Debet/Kredit</label>
								  <div class="col-sm-6">
									<input type="text" class="form-control" name="dk" value="<?php echo $update['dk'];?>">
									<a style="color: red">** inputka D atau K Saja **</a>
								  </div>
								</div>
							</div>
							  <!-- /.box-body -->
							  <div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
							  </div>
							</form>
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
