<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_keu/aksi_akuntansi.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Pilih dari tanggal sampai ke tanggal</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>HOME</a></li>
						<li class="active">Laporan Keuangan </li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
                
				  <!-- SELECT2 EXAMPLE -->
			<div class="box box-default">
					    
				<div class="box-header with-border">
					<h3 class="box-title">Laporan Keuangan </h3>
				</div>
				<!-- /.box-header -->
					    
					    <div class="box-body" style="background: #C7C5C5">	    				
                        <form name="submit" action="" method="post"	>	
							<table width="484">
							  <tbody>
								<tr>
								  <td width="140">Mulai Tanggal </td>
								  <td width="10">:</td>
								  <td width="325"><input type="date" name="tgl_aw" ></td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>
								<tr>
								  <td>s/d Tanggal</td>
								  <td>:</td>
								  <td><input type="date" name="tgl_ak" ></td>
							    </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>

									<td><input type="submit" value="Submit"></td>
									<td></td>
									<td></td>
								</tr>
							  </tbody>
							</table>
							</form>
				  		</div>
							<?php
							$no=1;
							// Menentukan tanggal awal bulan dan akhir bulan
							$hari_ini = date("Y-m-d");
							if (empty($_POST['tgl_aw'])){
							    $tgl_aw = date('Y-m-01', strtotime('-1 month', strtotime($hari_ini)));
								$tgl_aw_a= date('Y-m-01', strtotime($hari_ini));
								$tgl_ak = date('Y-m-t', strtotime($hari_ini));

							}else{
								$tgl_aw_a=$_POST['tgl_aw'];
								$tgl_ak=$_POST['tgl_ak'];

							}
								$tgl1=date('Y-m-d',strtotime($tgl_aw_a));
								$tgl2=date('Y-m-d',strtotime($tgl_ak));
							?>	
								<h3>Periode : <?=date('d-M-Y',strtotime($tgl1))?> s/d <?=date('d-M-Y',strtotime($tgl2))?></h3>   
						    
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">
									<div class="table-responsive">
										<div class="box-body">	
									       
											<table id="myTable" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th>No.</th>
														<th>Tanggal</th>
														<th>No.Reff</th>
														<th>Keterangan</th>
														<th>BG dan CEK</th>
														<th>Nominal</th>
														<th>Total Nominal</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$no=1;
														$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl_aw_a' and '$tgl_ak' group by no_ref ORDER BY tgl desc";
														$qry=mysql_query($query);
														while ($hasil=mysql_fetch_array($qry)){
															$no_ref=$hasil['no_ref'];
															$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
															$qry2=mysql_query($query2);
															$hasil2=mysql_fetch_array($qry2);
															?>
																<tr>
																	<td><?=$no?></td>
																	<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
																	<td><?=$no_ref?></td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where tgl between '$tgl_aw_a' and '$tgl_ak' and no_ref = '$no_ref'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo $hasil_detail['ket']."<br />"; 
																			}
															
																		?>
																	</td>
																	<td>
																	<?php 
																		$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
																		while ($hasil_detail=mysql_fetch_array($detail_qry)){
																			echo $hasil_detail['bgcek']."<br />"; 
																		}
																	?>
																	</td>
																	<td>
																		<?php 
																			$detail_qry=mysql_query("select * from jurnal where tgl between '$tgl_aw_a' and '$tgl_ak' and no_ref = '$no_ref'");
																			while ($hasil_detail=mysql_fetch_array($detail_qry)){
																				echo number_format($hasil_detail['nominal'])."<br />"; 
																			}
															
																		?>
																	</td>
																	<td><?=number_format($hasil['jml'])?></td>
																	
																</tr>
															<?php
															$no++;
														}
													?>
												</tbody>
											</table>
											<!-- /.tabel 1. -->
											
											</form>
										</div>
										<!-- /.box-body -->
										<div class="box-footer">
											<div class="text-center">
												<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->

											  <a href="<?=$aksi?>?module=akunting&act=save"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
											</div>
										</div>
									</div>
									<!-- /.responsiv -->
								</div>
								<!-- /.col-md-12 -->
							</div>
			  <!-- /.row -->
					</div>
					<!-- /.box-body -->
			</div>	
					<script>

						$(document).ready(function(){

							$('#myTable').dataTable();

							$('#myTable2').dataTable();

							$('#myTable3').dataTable();

						});
					</script>
				
			<?php
		break;
			
		case "save":
		    
		    header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=BKKBKMBBMBBM($date).xls");
            
            		$tgl1=$_GET['tgl1'];
            		$tgl2=$_GET['tgl2'];
            		$date=date('Ymd');
		    ?>
		        <table border="1" class="table table-bordered table-striped">
					<thead>
					    <tr>
							<th>No.</th>
							<th>Tanggal</th>
							<th>No.Reff</th>
							<th>Keterangannn</th>
							<th>BG dan CEK</th>
							<th>Nominal</th>
							<th>Total Nominal</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$no=1;
						$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl1' AND '$tgl2' group by no_ref ORDER BY tgl desc";
						$qry=mysql_query($query);
						while ($hasil=mysql_fetch_array($qry)){
							$no_ref=$hasil['no_ref'];
							$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
							$qry2=mysql_query($query2);
							$hasil2=mysql_fetch_array($qry2);
					        ?>
    						<tr>
    							<td><?=$no?></td>
    							<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
    							<td><?=$no_ref?></td>
    							<td>
    					        <?php 
    								$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
    								while ($hasil_detail=mysql_fetch_array($detail_qry)){
    									echo $hasil_detail['ket']."<br />"; 
    								}
    							?>
    							</td>
								<td>
									<?php 
    								$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
    								while ($hasil_detail=mysql_fetch_array($detail_qry)){
    									echo $hasil_detail['bgcek']."<br />"; 
    								}
    							?>
								</td>
    							<td>
    							<?php 
    									$detail_qry=mysql_query("select * from jurnal where no_ref = '$no_ref' and tgl between '$tgl1' AND '$tgl2'");
    									while ($hasil_detail=mysql_fetch_array($detail_qry)){
    										echo number_format($hasil_detail['nominal'])."<br />"; 
    									}
    							?>
    							</td>
    							<td><?=number_format($hasil['jml'])?></td>
    						</tr>
						    <?php
							    $no++;
						}
						?>
					</tbody>
				</table>
			<?php
		break;
	}
}
?>
