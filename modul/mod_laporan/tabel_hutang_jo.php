<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_laporan/aksi_hutang_jo.php";
	switch($_GET[act]){
		// Tampil User
		default:
		    $hari_ini = date("Y-m-d H:i:s");
			if (empty($_POST['tgl_ak'])){
				$tgl_aw= date('Y-01-01', strtotime($hari_ini. ''));
				$tgl_ak= date('Y-m-d', strtotime($hari_ini));

				$tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
				$tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

			}else{
				$tgl_aw= date('Y-01-01', strtotime($hari_ini. ''));
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
								<h3 class="box-title"><b class="text-blue">Tabel Laporan Hutang</b> by <strong>Vendor</strong> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
							</div>
                            <div class="col-md-6">
								<form name="submit" action="?module=op_cash_jo" method="POST">
									<div class="col-md-1"></div>
									<div class="col-md-3 justify-content-end">
										<h4><strong><?=$tgl_aw_str?></strong></h4>
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
                                <!-- HUTANG -->
								<div class="tabel-responsive">
									<div class="col-md-12">
                                    <div>
                                        <b class="text-danger">TABEL HUTANG SALDO TERAKHIR : Rp. </b>
                                        <b id='jmlOpcash'></b>
                                        <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=hutang_jo&act=print_hutang_jo_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" target="_blank"><span class="fa fa-print"></a>
                                        <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=hutang_jo&act=excel_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" ><span class="fa fa-save"></a>
                                    </div>    
									<table id="myTable" class="table table-striped table-bordered">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>VENDOR</th>																								
												<th>HUTANG</th>
                                                <th>SALDO HUTANG</th>										
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
                                            <?php
                                            $no=1;
                                                $qry_ven=mysql_query("select * from data_vendor");                                                
                                                while ($hsl_ven=mysql_fetch_array($qry_ven)){
                                                    $nama_ven = $hsl_ven['nm_vendor'];                                                    
                                                    $jml_oc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    $saldo_ob=0;                                                    
                                                    $saldo_hut2=0;
                                                    $selisih = 0;
                                                    $saldo_oc2 = 0;
                                                    $saldo_ob2 = 0;
                                                    
                                                        $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                        join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                        where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by id_pf_real_cost ");
                                                        while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                                                                                        
                                                            $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                            $id_pf_log= $hsl_oc['id_pf_log'];
                                                            $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                            $rc= $hsl_oc['real_cost'];
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
                                                            $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];

                                                            $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														    while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){																													
															    $saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                                $saldo_ob2=$hsl_oc2['real_cost'];
                                                            }

                                                            $selisih = $saldo_oc2-$saldo_ob2;
                                                            $qry_hut=mysql_query("select * from pf_real_cost																																							                                
                                                                where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
                                                            while ($hsl_hut = mysql_fetch_array($qry_hut)){                                                                                                                            
                                                                $saldo_hut2=$saldo_hut2+$hsl_hut['real_cost'];
                                                            }
                                                            
                                                            
                                                        }
                                                        $saldo_ak=$saldo_oc - $saldo_ob - $saldo_hut2;                                                                                                
                                                        $saldo_ak3=$saldo_hut2;                                                                                                
                                                        $saldo_ak2=$saldo_ak2+$saldo_ak; 
                                                    
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_ven['nm_vendor']?></td>
                                                <td><?=number_format($saldo_ak)?></td>
                                                <td><?=number_format($saldo_ak2)?></td>                                                
                                                <td>
                                                    <a class="btn bg-black btn-sm" href="?module=hutang_jo&act=hutang_jo&nama_ven=<?=$nama_ven?>&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" target="_blank"><span class="fa fa-eye"></a>	
                                                    <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=hutang_jo&act=print_hutang_jo&nama_ven=<?= $nama_ven ?>&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" target="_blank"><span class="fa fa-print"></a>
                                                    <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=hutang_jo&act=excel&nama_ven=<?= $nama_ven ?>&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" ><span class="fa fa-save"></a>
                                                </td>
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak2); 
                                            ?>
                                            <script>
                                                var x = "<?=$jmlSaldoak?>";
                                                document.getElementById("jmlOpcash").innerHTML = x ;
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

		case "hutang_jo":
            $nama_ven=$_GET['nama_ven'];
            $tgl_aw=$_GET['tgl_aw'];
            $tgl_ak=$_GET['tgl_ak'];
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
					<h1>HUTANG</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Laporan</a></li>
						<li class="active">Hutang</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">HUTANG VENDOR <?=$nama_ven?></h3>
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
                                                    <th>JO NUMBER</th>
                                                    <th>NO REFF HUT</th>                                                                                                        
													<th>D</th>
													<th>DUE DATE</th>
													<th>PAYMENT DATE BBK</th>                                                                                                        
													<th>NO REFF BBK</th>                                                                                                                                                            
													<th>K</th>                                                                                                                                                            
                                                    <th>SELISIH</th>										
                                                    <th>PAYMENT DATE HUT</th>										
                                                    <th>NO REFF HUT</th>										
                                                    <th>K</th>										
                                                    <th>HUTANG</th>										
                                                    <th>SALDO HUTANG</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                    join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                    where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and prc.stakeholder='$nama_ven' and ( no_reff_keu like 'HUT%AP') order by tgl_pf ");
                                                    while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                        $no_reff_keu= $hsl_oc['no_reff_keu'];
                                                        $id_pf_log= $hsl_oc['id_pf_log'];
                                                        $id_pf_real_cost = $hsl_oc['id_pf_real_cost'];
                                                        $no_jo = substr($hsl_oc['no_jo'],4,10);
                                                        $selisih = 0;
                                                        $saldo_oc2 = 0;
                                                        $saldo_ob2 = 0;
                                                        $hutang = 0;
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf']?></td>
                                                    <td><?=$hsl_oc['no_jo']?></td>                                                    
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>													
                                                    <td>
                                                        <?php                                                        
                                                            $saldo_oc=$saldo_oc+$hsl_oc['real_cost'];
                                                            $saldo_oc2=$hsl_oc['real_cost'];
                                                        ?>
                                                        <?=number_format($hsl_oc['real_cost'])?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $due_date= date('Y-m-d', strtotime($hsl_oc['tgl_pf_real_cost']. '+30 day'));
                                                        echo $due_date;
                                                        ?>
                                                    </td>
                                                    <td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['tgl_pf_real_cost']?> <br>
														<?php } 
														?> 
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=$hsl_oc2['no_reff_keu']?> <br>
														<?php } 
														?> 														
													</td>
													<td>
														<?php $qry_rc2=mysql_query("select * from pf_real_cost as prc
															join pf_log as pl on prc.id_pf_log=pl.id_pf_log																																							                                
															where prc.id_pf_log='$id_pf_log' and prc.no_hut = '$id_pf_real_cost' and category1='HUT' and category2='BBK' and (prc.id_hut = '$no_reff_keu' or kegiatan like '%$no_jo%')");
														while ($hsl_oc2 = mysql_fetch_array($qry_rc2)){ ?>
															<?=number_format($hsl_oc2['real_cost'])?> <br>
														<?php 
															$saldo_ob=$saldo_ob+$hsl_oc2['real_cost'];
                                                            $saldo_ob2=$hsl_oc2['real_cost']; 
														}
                                                        
														?> 														
													</td>                                                                                                                                                           
                                                    <td>
                                                        <?php
                                                        
                                                        $selisih = $saldo_oc2-$saldo_ob2;
                                                        echo number_format($selisih);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['tgl_pf_real_cost']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=$hsl_hut['no_reff_keu']?> <br>
														<?php } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php $qry_hut=mysql_query("select * from pf_real_cost																																							                                
															where real_cost = '$selisih' and category1='HUTANG LAIN' and category2='HUT' and (id_pf_log='$id_pf_log' or kegiatan like '%$no_jo%') and kegiatan like 'POT PPH%'");
														while ($hsl_hut = mysql_fetch_array($qry_hut)){ ?>
															<?=number_format($hsl_hut['real_cost'])?> <br>
														<?php 
                                                            $hutang = $hsl_hut['real_cost'];
                                                        } 
														?>
                                                    </td>
                                                    <td>
                                                        <?php                                                     
                                                        $saldo_hut=$saldo_oc2-$saldo_ob2 - $hutang;
                                                        $saldo_ak=$saldo_ak+$saldo_hut;
                                                        echo number_format($saldo_hut);
                                                        ?>
                                                    </td>
                                                    <td><?=number_format($saldo_ak)?></td>
                                                </tr>
                                                <?php $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak);  ?>
                                                <script>
                                                    var x = "<?=$jmlSaldoak?>";
                                                    document.getElementById("jmlhut").innerHTML = x ;
                                                </script>
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
		
            case "print_hutang_jo":
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
                                            where prc.id_pf_log='$id_pf_log' and category1='HUT' and category2='BBK' ");
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

	}
}
?>
