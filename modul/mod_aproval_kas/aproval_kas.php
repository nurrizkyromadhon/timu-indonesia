<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_aproval_kas/aksi_aproval_kas.php";
	switch($_GET[act]){
		// Tampil User
		default:
?>
                <script type="text/javascript">
					$(document).ready(function() {
						 // Check All
						 $('.checkall').click(function() {
							 $(":checkbox").attr("checked", true);
						 });
						 // Uncheck All
						 $('.uncheckall').click(function() {
							 $(":checkbox").attr("checked", false);
						 });
					 });
					
					$(function () {
						$("#example1").DataTable();
					});

				</script>	

				<section class="content-header">
					<h1>Aproval Pengeluaran Kas dan Bank</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Aproval Kas dan Bank</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
				    
	<div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-envelope-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">New Eproval</span>
              <span class="info-box-number color-red" id="hasil"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12" >
          <div class="info-box">
            <a href="?module=aproval_kas&act=data_aproval_kas"><span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Data Eproval</span>
              <span class="info-box-number">
				  <?php
					 $no1=1;
					 $query="SELECT *, sum(nominal) as jml FROM jurnal where aproval not in ('' , 'NA') group by no_ref ORDER BY tgl desc";
					 $qry=mysql_query($query);
					 while ($hasil=mysql_fetch_array($qry)){
						 $query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
						 $qry2=mysql_query($query2);
						 $hasil2=mysql_fetch_array($qry2);
					$no1++;
					 }
					 echo "$no1"-1;	 
				  ?>
			  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
		  <a href="?module=aproval_kas&act=saldo_kas"><span class="info-box-icon bg-yellow"><i class="fa fa-files-o"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Saldo Bank</span>
              <span class="info-box-number">
				  <?php
					$no=1;
					$query="select * from jurnal as j
					join perkiraan as p on j.id_perkiraan=p.id_perkiraan  where kode_perkiraan like '1.1.02%' group by j.id_perkiraan order by kode_perkiraan asc";
					$qry=mysql_query($query) or die(mysql_error());
					while ($hasil=mysql_fetch_array($qry)){	
						$a=$hasil['id_perkiraan'];
						$jmld=0;
						$jmlk=0;
						$sisa=0;
						$query1=mysql_query("select * from jurnal where id_perkiraan='$a'");
						while($hasil1=mysql_fetch_array($query1)){
							if ($hasil1['dk']=='D'){
								$jmld=$jmld+$hasil1['nominal'];
							}
							if ($hasil1['dk']=='K'){
								$jmlk=$jmlk+$hasil1['nominal'];
							}
							$sisa=$jmld-$jmlk;
						}
                        $total=$total+$sisa;
					}
				  ?>
				  <?=number_format($total)?> IDR
			  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
		  <a href="?module=aproval_kas&act=saldo_bank"><span class="info-box-icon bg-red"><i class="fa fa-star-o"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Saldo Kas</span>
              <span class="info-box-number">
			  <?php
					$no=1;
					$total=0;
					$query="select * from jurnal as j
					join perkiraan as p on j.id_perkiraan=p.id_perkiraan  where kode_perkiraan like '1.1.01%' group by j.id_perkiraan order by kode_perkiraan asc";
					$qry=mysql_query($query) or die(mysql_error());
					while ($hasil=mysql_fetch_array($qry)){	
						$a=$hasil['id_perkiraan'];
						
						$jmld=0;
						$jmlk=0;
						$sisa=0;
						$query1=mysql_query("select * from jurnal where id_perkiraan='$a'");
						while($hasil1=mysql_fetch_array($query1)){
							if ($hasil1['dk']=='D'){
								$jmld=$jmld+$hasil1['nominal'];
							}
							if ($hasil1['dk']=='K'){
								$jmlk=$jmlk+$hasil1['nominal'];
							}
							$sisa=$jmld-$jmlk;
						}
                        $total=$total+$sisa;
					}
				  ?>
				  <?=number_format($total)?> IDR
			  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->    

				  <!-- SELECT2 EXAMPLE -->
				<div class="box box-default">
					<div class="box-header with-border">
						<h3 class="box-title">Aproval Kas dan Bank</h3>
					</div>
						<!-- /.box-header -->
					<div class="box-body">
							<!-- /.box -->
						
						<div class="row">
							<div class="box-body">
								<div class="col-md-12 table-responsive">
								<form name="submit" metode="GET" action="<?=$aksi?>" >
									<table class="table table-bordered table-striped">
										<thead bgcolor=#A5B4EC>
										<tr>
											<th>No</th>
											<th>Tanggal</th>
											<th>BKK dan BKM</th>
											<th>Nominal</th>
											<th><a class="checkall" href="#"> Check All</a> - <a class="uncheckall" href="#"> Uncheck All</a></th>
										</tr>
										</thead>
										<tbody>
										<?php
											$no=1;
											$query="SELECT * FROM jurnal where aproval='' group by no_ref ORDER BY tgl desc";
											$qry=mysql_query($query);
											while ($hasil=mysql_fetch_array($qry)){
												$no_ref=$hasil['no_ref'];
												$query1=mysql_query("select * from jurnal where no_ref= '$hasil[no_ref]'");
												$jml=0;
												while ($hasil1=mysql_fetch_array($query1)){
												    if(($hasil1['id_perkiraan']!='73')or($hasil1['dk']!='D')){
													    $jml=$jml+$hasil1['nominal'];
												    }
												}

												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td>
															<a href="?module=aproval_kas&act=view_aproval_kas&id=<?=$hasil['no_ref']?>"><?=$no_ref?></a>
														</td>
														<td>
														   <?=number_format($jml)?> 
														</td>
														<td align="center">
															<!--<button type="button" class="btn btn-info" onclick="window.open('<?php echo "$aksi?module=jurnal&act=cetakkeu&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-print"></i></button>-->
															<input type="checkbox" name="cek_item[]" value="<?=$no_ref?>" id="cek_item[]" [[!+checkresourceschecked]] >
														</td>
													</tr>
													
												<?php
												
												$no++; 
											}
										?>
									<input type="hidden" id="input_form" value="<?=$no-1?>"/>
									</tbody>
									</table>
									<p align="right"><input type="submit" name="submit" value="submit"></p>
								</form>
								</div>
							</div>	
						</div>
					</div>
					<script>
						var jml=document.getElementById("input_form").value;
						document.getElementById("hasil").innerHTML=jml;

						$(function () {
							$("#myTable").DataTable();
						});
					</script>
					
					<div class="box-footer"></div>
				</div>
					<!-- /.row -->				
				</section>
		<?php
		break;
		case "view_aproval_kas":
			include("detail.php");
		break;
		case "data_aproval_kas":
			include("data_aproval.php");
		break;
		case "saldo_kas":
			include("bank.php");
		break;
		case "saldo_bank":
			include("kas.php");
		break;
	}
}
?>
