<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_cashflow/aksi_cashflow.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">CashFlow</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
									
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Balancing Sheet</h3>
						</div>
						<div class="box-body">
							<div class="row">
							    <div class="box-body" style="background:#D7D6D6">
            						<form name="submit" action="" method="post"	>	
            						    <div class="form-group">
            						        <label> Pilih Tahun Laporan</label>
            						            <select name="thn">
            						                <option value="">- Pilih -</option>
            						                <?php
            						                    $queryth=mysql_query("select date_format(tgl,'%Y') as th from jurnal group by th ");
            						                    while($hasilthn=mysql_fetch_array($queryth)){
            						                ?>      
            						                        <option value="<?=$hasilthn['th']?>"><?=$hasilthn['th']?></option>
            						                <?php    
            						                    }
            						                ?>
            						                
            						            </select>
            						           <td><input type="submit" value="Submit"></td>
            						    </div>
            						</form>
        						</div>
								<div class="col-md-12">
									<div class="container">
										<div class="table-responsive">
											<table id= "myTable" class="table table-bordered table-striped">
												<thead>
												<tr>
													<th>NO</th>
													<th>KETERANGAN</th>
													<?php
													if($_POST[thn]==''){
													    $thn=date(Y);
													}else{
													    $thn=$_POST[thn];
													}
													
													$jmlbln=0;
														$query=mysql_query("select date_format(tgl,'%Y-%m') as bln from jurnal where tgl like '$thn-%' group by bln ");
														while($hasil=mysql_fetch_array($query)){
															$bulan=$hasil['bln'];
															$bln[]=$hasil['bln'];
															$jmlbln++;
													?>		
														<!--<th><?=$bulan?> D</th>
														<th><?=$bulan?> K</th>-->
														<th><?=$bulan?> S</th>
													    
													<?php
														}
													?>	
													<th>Total</th>

												</tr> 
												</thead>
												<tbody>
													<?php
														$no=1;
														$query0=mysql_query("select *,date_format(j.tgl,'%Y') as th from jurnal as j 
														join perkiraan as p on j.id_perkiraan=p.id_perkiraan  group by j.id_perkiraan 
														order by p.kode_perkiraan asc");
														
														while($hasil0=mysql_fetch_array($query0)){
														$ket=$hasil0['nm_perkiraan'];
														$nm[]=$hasil0['nm_perkiraan'];$total=0;
													?>  
															<tr>
																<td><?=$no?></td>
																<td><?=$ket?></td>
																<?php
																	$query1=mysql_query("select date_format(tgl,'%Y-%m') as bln from jurnal group by bln");
																	$x=0;
																	while($hasil1=mysql_fetch_array($query1)){
																		$bulan=$hasil1['bln'];
																		
																		for($x==0; $x<=$jmlbln-1; $x++){				
																			 $query2=mysql_query("select * from jurnal as j 
																			 join perkiraan as p on j.id_perkiraan = p.id_perkiraan 
																			 where p.nm_perkiraan = '$hasil0[nm_perkiraan]' and j.tgl like '$bln[$x]%' ");
																			 $saldo=0;
																			 $jmlK=0;
																			 $jmlD=0;
																			 while($hasil2=mysql_fetch_array($query2)){
																				 if($hasil2['dk']=='D'){
																					 $jmlD=$jmlD+$hasil2['nominal'];
																				 }else{
																					 $jmlK=$jmlK+$hasil2['nominal'];
																				 }
																				 $saldo=$jmlD-$jmlK;
																			 }
																				$total=$total+$saldo;
																			?>
																		<!--<td><?=number_format($jmlD)?></td>
																		<td><?=number_format($jmlK)?></td>-->
																		<td>
																			<?=number_format($saldo)?>
																		</td>
																<?php 
																		}
																	} 
																?>
																<td><?=number_format($total)?></td>
															</tr>
													<?php
														$no++;
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
								<a href="<?=$aksi?>?module=cashflow&act=save_excel&thn=<?=$thn?>"><button type="button" class="btn btn-info"><i class="fa fa-fw fa-print"></i>Save Excel</button></a>
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.box default-->				
				</section>
				<script>
					$(function () {
						$("#myTable").DataTable();
						$("#myTable1").DataTable();
						$("#myTable2").DataTable();
					});
				</script>
			<?php
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
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>SPP</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">SPP</a></li>
						<li class="active">Form Edit</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Edit</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=spp&act=update">
										<div class="box-body">
											Form Edit SPP
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
	}
}
?>
