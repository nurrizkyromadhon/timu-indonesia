<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_laporan/aksi_op_ar_jo.php";
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
								<h3 class="box-title"><b class="text-blue">Tabel Laporan OP AR</b> dari tgl <strong><?=$tgl_aw_str?></strong> s/d <strong><?=$tgl_ak_str?></strong> </h3>
							</div>
							<div class="col-md-6">
								<form name="submit" action="?module=op_ar_jo" method="POST">
									<div class="col-md-1"></div>
									<div class="col-md-4">
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
                                <!-- OP AP -->
								<div class="tabel-responsive">
									<div class="col-md-12">
                                    <div>
                                        <b class="text-danger">TABEL OP AR SALDO TERAKHIR : Rp. </b>
                                        <b id='jmlOpap'></b>
                                        <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=op_ar_jo&act=print_op_ar_jo_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" target="_blank"><span class="fa fa-print"></a>
                                        <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=op_ar_jo&act=excel_all&tgl_aw=<?=$tgl_aw?>&tgl_ak=<?=$tgl_ak?>" ><span class="fa fa-save"></a>
                                    </div>    
									<table id="myTable" class="table table-striped table-bordered">
										<thead class="bg-blue">
											<tr>
												<th>NO</th>
												<th>DATE</th>
												<th>JO NUMBER</th>												
                                                <th>NO INVOICE</th>
												<th>OP AR</th>
												<th>SALDO OP AR</th>                                                
												<th>ACTION</th>
											</tr>
										</thead>
										<tbody>
                                            <?php
                                            $no=1;
                                            
                                                $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                where pl.tgl_pf between '$tgl_aw' and '$tgl_ak' and category1 = 'OP AR' group by prc.id_pf_log order by tgl_pf asc");
                                                while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                    $op_balik= substr($hsl_oc['no_reff_keu'],10,3);
                                                    $id_pf_log=$hsl_oc['id_pf_log'];
                                                    $no_jo=$hsl_oc['no_jo'];
                                                    $jml_oc=0;
                                                    $jml_ob=0;
                                                    $saldo_oc=0;
                                                    
                                                    $qryjml_oc=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'OP AR'");
                                                    while ($hsljml_oc=mysql_fetch_array($qryjml_oc)){
                                                        $jml_oc=$jml_oc+$hsljml_oc['real_cost'];
                                                    }
                                                    $qryjml_ob=mysql_query("select * from pf_real_cost where id_pf_log= '$id_pf_log' and category1 = 'DP' and category2 = 'BBM'");
                                                    while ($hsljml_ob=mysql_fetch_array($qryjml_ob)){
                                                        $jml_ob=$jml_ob+$hsljml_ob['real_cost'];
                                                    }
                                                    $saldo_oc=$jml_oc-$jml_ob; 
                                                    $saldo_ak=$saldo_ak+$saldo_oc;
                                            ?>
                                            <tr>
                                                <td><?=$no?></td>
                                                <td><?=$hsl_oc['tgl_pf']?></td>
                                                <td><?=$hsl_oc['no_jo']?></td>                                                
                                                <td>
                                                <?php
													$inv=mysql_query("SELECT no_invoice from pf_invoice 
													where id_pf_log='$id_pf_log' group by no_invoice ");
													while ($hslrc=mysql_fetch_array($inv)){
													?>
													<?=$hslrc['no_invoice']?><br>
													<?php } ?>
                                                </td>
                                                <td>
                                                    
                                                    <?=number_format($saldo_oc)?>
                                                </td>
                                                <td><?=number_format($saldo_ak)?></td>
                                                <td>
                                                    <a class="btn bg-black btn-sm" href="?module=op_ar_jo&act=op_ar_jo&id_pf_log=<?=$id_pf_log?>&no_jo=<?=$no_jo?>" target="_blank"><span class="fa fa-eye"></a>	
                                                    <a class="btn bg-gray btn-sm" href="<?=$aksi?>?module=op_ar_jo&act=print_op_ar_jo&id=<?= $id_pf_log ?>&no_jo=<?=$no_jo?>" target="_blank"><span class="fa fa-print"></a>
                                                    <a class="btn bg-primary btn-sm" href="<?=$aksi?>?module=op_ar_jo&act=excel&id=<?= $id_pf_log ?>&no_jo=<?=$no_jo?>" ><span class="fa fa-save"></a>
                                                    <?php
													$inv2=mysql_query("SELECT no_invoice from pf_invoice 
													where id_pf_log='$id_pf_log' group by no_invoice ");
													$hslrc2=mysql_fetch_array($inv2);
													$invhasil = $hslrc2['no_invoice'];
													?>
													<?php if(!empty($invhasil) && $saldo_oc != 0){?>
													<a class="btn bg-green btn-sm" href="<?=$aksi?>?module=op_cash_jo&act=balik_op_ar&id_pf_log=<?= $id_pf_log ?>" >OP BALIK</a>
													<?php }?>
                                                </td>
                                            </tr>
                                            <?php 
                                                $no++; } 
                                                $jmlSaldoak=number_format($saldo_ak); 
                                            ?>
                                            <script>
                                                var x = "<?=$jmlSaldoak?>";
                                                document.getElementById("jmlOpap").innerHTML = x ;
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

		case "op_ar_jo":
            $id_pf_log=$_GET['id_pf_log'];
            $no_jo=$_GET['no_jo'];
			?>
				<section class="content-header">
					<h1>OP AR</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Laporan</a></li>
						<li class="active">Op Ar</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">OP AR</h3>
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
                                                    <th>NO REFF KEUANGAN</th>
                                                    <th>TYPE COST</th>
                                                    <th>KEGIATAN</th>
                                                    <th>STAKEHOLDER</th>
                                                    <th>D</th>
                                                    <th>K</th>										
                                                    <th>ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no=1;
                                                    $qry_oc=mysql_query("select * from pf_real_cost as prc
                                                    join pf_log as pl on prc.id_pf_log=pl.id_pf_log
                                                    where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AR','DP') ");
                                                    while ($hsl_oc=mysql_fetch_array($qry_oc)){
                                                        $op_balik= substr($hsl_oc['no_reff_keu'],10,3);
                                                ?>
                                                <tr>
                                                    <td><?=$no?></td>
                                                    <td><?=$hsl_oc['tgl_pf_real_cost']?></td>
                                                    <td><?=$hsl_oc['no_jo']?></td>                                                    
                                                    <td><?=$hsl_oc['no_reff_keu']?></td>
                                                    <td><?=$hsl_oc['category1']?></td>
                                                    <td><?=$hsl_oc['kegiatan']?></td>
                                                    <td><?=$hsl_oc['stakeholder']?></td>
                                                    <?php
                                                        if($op_balik != '_AR'){
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
		
            case "print_op_ar_jo":
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
										where prc.id_pf_log='$id_pf_log' and prc.category1 in ('OP AR','HUT')");
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
                                                if($op_balik != '_AR'){
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
