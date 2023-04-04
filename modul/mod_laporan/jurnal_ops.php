<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_laporan/aksi_jurnal_ops.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>LAPORAN JURNAL OPERASIONAL</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Laporan Jurnal Operasional</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
								<h2>JURNAL OPERASIONAL</h2>
										<div class="row">
									  <div class="table-responsive">
									  <form name="submit" action="<?=$aksi?>?module=hut_user&act=lunas"&id='<?$id_hutang?>' method="post" >
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
										  <th>DOC CUSTOM AND OPERATION</th>
										  <th>DOC SHIPPING/FORWARDING</th>
										  <th>DOC PORT</th>
										  <th>DOC DEPO/CFS</th>
										  <th>DOC THIRD PARTY</th>
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
										join pf_operasional on pf.id_pf=pf_operasional.id_pf 
										left join detail on pf_operasional.id_pf_operasional=detail.id_pf_operasional
										order by tgl_pf_operasional desc");
										while ($hasil=mysql_fetch_array($query)){
										    $id_pf=$hasil['id_pf'];
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
											<td>
											    <?php
											        $rc=mysql_query("select * from real_user where id_pf=$id_pf");
											        while ($hsl_rc=mysql_fetch_array($rc)){
											    ?>
											    <?=$hsl_rc['name_real_user']?>
											    
											    <?php } ?> 
											</td>
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
											    if($hasil['desc1']=='PORT CHARGES'){
											?>
											<td><?=$hasil['no_kontainer']?></td>
											<?php }else{
											?>
											<td></td>
											<?php } ?>
											
											<?php
											    if($hasil['desc1']=='DEPO/CFS CHARGES'){
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
									<!--<center><input type="submit" value="Submit Lunas"></center>-->
									</form>
									</div>
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
							<a class="btn btn-default btn-sm" href="<?=$aksi?>?module=lap_jurnal_ops&act=excel&id=<?=$id_pf_real_cost?>&id_pf=<?=$id_pf?>">Save Excel</a>
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
