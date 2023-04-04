<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_ppjb/aksi_ppjb.php";
	switch($_GET[act]){
		// Tampil User
		default:
		    
?>
                <script type="text/javascript">
                    function checkAllcek_item(checkEm) {
                        var cbs = document.getElementsByTagName('input');
                        for (var i = 0; i < cbs.length; i++) {
                            if (cbs[i].type == 'checkbox') {
                                if (cbs[i].name == 'cek_item[]') {
                                    cbs[i].checked = checkEm;
                                }
                            }
                        }
                    }
                </script>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">ppjb</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Boking Marketing</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
						<div class="row">
							<div class="box-body">
								<div class="col-md-12">	
								<h1><center>Print PPJB</center></h1>
								<table id="myTable1" class="table table-bordered table-striped">
									<thead bgcolor=#A5B4EC>
									<tr>
										<th>NO</th>
										<th>TANGGAL JUAL</th>
										<th>NAMA USER</th>
										<th>BLOK RUMAH</th>
										<th>HARGA JUAL</th>
										<th>KPR</th>
										<th>UANG MUKA</th>
										<th>DISC</th>
										<th>CASH BACK</th>
										<th>AKSI</th>
									</tr>
									</thead>
									
									<?php
									
										$no=1;
										$query=mysql_query("SELECT * FROM nasabah as n 
										where id_indikasi = '3' and aproval='OK' order by tgl_beli desc");
										while($hasil=mysql_fetch_array($query)){
										    $tgl1=$hasil['tgl_beli'];
											$tgl2=date('Y-m-d', strtotime('+3 days', strtotime($tgl1)));
											
											$huket=$hasil['hu.ket'];
											$id_nasabah1=$hasil['id_nasabah'];
											
    									if (strtotime(date("Y-m-d")) <= strtotime($tgl2)){		
    									?>
    									<tr  style="color: blue">
    										<td><?=$no?></td>
    										<td><?=$hasil['tgl_beli']?></td>
    										<td><?=$hasil['nama_user']?></td>
    										<td><?=$hasil['coord']?></td>
    										<td><?=number_format($hasil['harga_jual'])?></td>
    										<td><?=number_format($hasil['kpr'])?></td>
    										<td><?=number_format($hasil['um'])?></td>
    										<td><?=number_format($hasil['disc'])?></td>
    										<td><?=number_format($hasil[cb])?></td>
    										<td>
    											<button type="button" class="btn-sm" onclick="location.href='<?php echo "?module=aproval&act=edit&id=$id_nasabah1";?>';" ><i class="fa fa-edit"></i></button>
                                                <button type="button" class="btn-sm btn-info"  onclick="location.href='<?php echo "$aksi?module=ppjb&act=print&id=$id_nasabah";?>';","_blank" ><i class="fa fa-print"></i></button>    											
    										</td>
    									</tr>
    									<?php
    									}else{
    									?>    
    									<tr>
    										<td><?=$no?></td>
    										<td><?=$hasil['tgl_beli']?></td>
    										<td><?=$hasil['nama_user']?></td>
    										<td><?=$hasil['coord']?></td>
    										<td><?=number_format($hasil['harga_jual'])?></td>
    										<td><?=number_format($hasil['kpr'])?></td>
    										<td><?=number_format($hasil['um'])?></td>
    										<td><?=number_format($hasil['disc'])?></td>
    										<td><?=number_format($hasil[cb])?></td>
    										<td>
    											<button type="button" class="btn-sm" onclick="location.href='<?php echo "?module=aproval&act=edit&id=$id_nasabah1";?>';" ><i class="fa fa-edit"></i></button>
    											<button type="button" class="btn-sm btn-info" onclick="location.href='<?php echo "$aksi?module=ppjb&act=print&id=$id_nasabah";?>';","_blank" ><i class="fa fa-print"></i></button>
    										</td>
    									</tr>
    									<?php 
    									}
									$no++; 
									} ?>
								</table>
								</div>
							</div>	
						</div>
						</div>
						
					<script>
					$(function () {
						$("#myTable").DataTable();
						$("#myTable1").DataTable();
						$("#myTable2").DataTable();
					});
					</script>
						<div class="box-footer">
							<div class="text-center">
							<!---	<a href="?module=profil_perush&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-edit"></i>&nbsp Tambah Data</button></a>
								<a href="?module=profil_perush&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-check"></i>&nbsp Tambah Data</button></a> -->
							</div>
						</div>
						<!-- /.box-footer -->
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</section>
				<script>
					$(function () {
						$("#example1").DataTable();
					});
				</script>
			<?php
			
			
			break;
	  
		case "tambah":
			?>
				<section class="content-header">
					<h1>Form Pemesanan Rumah</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Penjualan</a></li>
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
							<!-- form start -->
							<form class="form-horizontal" method="POST" action="<?=$aksi2?>?module=marketing&act=input">	
								<!-- /.col -->
								<div class="col-md-6">	
								<H3 align="center">SPEK BLOK RUMAH :</H3>
										<div class="box-body">
											<div class="form-group">
												<label class="col-sm-5 control-label">Tanggal :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="tgl_beli" value="<?=date('Y-m-d')?>" readonly/>
												</div>
											</div>											
											<div class="form-group">
												<label class="col-sm-5 control-label">Nama Blok Rumah :</label>
												<div class="col-sm-5">
												<?php
														$qry0=mysql_query("Select * from nasabah where id_nasabah='$_GET[id]';");
									  					$hasil0=mysql_fetch_array($qry0); 
												?>
													<input type="hidden" name="id_coord" value="<?=$_GET['id']?>">	
													<input type="hidden" name="id_harga" value="<?=$hasil0['id_harga']?>">
 													<input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">type :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="tipe" value="<?=$hasil0['type_rumah']?>" readonly/>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Harga Jual :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="harga" value="<?=$hasil0['harga_jual'] ?>" readonly/>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Discount :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="disc" value="<?=number_format($hasil0['disc'])?>"  readonly  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Cash Back :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="cb" value="<?=number_format($hasil0['cb'])?>"  readonly  />
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-5 control-label">Harga Netto :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="net" value="<?=number_format($hasil0['harga_net'])?>" readonly   />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Uang Muka (Nominal Yg Harus Dibayar):</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="um" value="<?=number_format($hasil0['um'])?>"  readonly  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">KPR :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="kpr" value="<?=number_format($hasil0['kpr'])?>" readonly   >
												</div>
											</div>
													
											<div class="form-group">
												<label class="col-sm-5 control-label">5 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="lima" value="<?=number_format($hasil0['5th'])?>"  readonly  >
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">10 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="sepuluh" value="<?=number_format($hasil0['10th'])?>"  readonly  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">15 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="limabelas" value="<?=number_format($hasil0['15th'])?>" readonly  >
												</div>
											</div>													
										</div>
								</div>
									
								<div class="col-md-6">
								<H3 align="center">DATA FPR USER :</H3>
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-5 control-label">No FPR :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="no_fpr" autofocus required />
											</div>
										</div>									
										<div class="form-group">
											<label class="col-sm-5 control-label">Nama User :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="nasabah" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Alamat Rumah :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="alamat" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">No. KTP :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="ktp" autofocus required />
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-5 control-label">No. Telepon :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="telp" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Pekerjaan :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="pekerjaan" autofocus required/>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-5 control-label">Alamat Kantor :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="alamat_kantor" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Telp Kantor :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="telp_kantor" autofocus required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Gaji Perbulan :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="gaji" placeholder="Input tanpa Titik dan Koma" autofocus required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Penghasilan Lain-lain :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="usaha_lain"placeholder="Input tanpa Titik dan Koma" autofocus required/>
											</div>
										</div>																			
										<div class="form-group">
											<label class="col-sm-5 control-label">Cara Pembelian :</label>
											<div class="col-sm-5">
												<select class="form-control" name="ket">
													<option value=""> - Cara Beli - </option>
													<option value="Cash">Cash Keras</option>
													<option value="Inhouse">Cash Bertahap</option>
													<option value="KPR">KPR Bank</option>
												</select>
											</div>
										</div>	
										<?php
									    mysql_query("Select * from hutang where id_buyer='$id_nasabah' ");
										?>
										<div class="form-group">
											<label class="col-sm-5 control-label">Pembayaran Tanda Jadi (Rp) :</label>
											<div class="form-group">
											  <div class="col-sm-5"></div>
										  </div>
                                            <div class="form-group">
                                              <label class="col-sm-5 control-label">Nomor Kwitansi :</label>
                                              <div class="col-sm-5">
                                                <input class="form-control" type="text" name="no_kw2"  autofocus required  />
                                              </div>
                                            </div>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="tj" placeholder="Input tanpa Titik dan Koma"  autofocus required  />
											</div>
										</div>
										<div class="form-group">
										</div>											
										<div class="form-group">
											<label class="col-sm-5 control-label">Rencana Bayar UM I (Rp) :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="um1" placeholder="Input tanpa Titik dan Koma"  autofocus required  />
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-5 control-label">Rencana Tgl Bayar UM I (tgl) :</label>
											<div class="col-sm-5">
												<input class="form-control" type="date" name="tgl_byr_um1" autofocus required />
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-5 control-label">Periode Angsuran :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="periode" placeholder="Jumlah periode dalam bulan" autofocus required/>
											</div>
										</div>		
											
									</div>
								</div>
							</div>
							<div class="box-footer">
								<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
							</div>
						</form>
							
						</div>
					</div>
				</section>
				<script type="text/javascript" >				
					$(document).ready(function(){
						$('#koma').maskMoney({precision:0});			
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
					<h1>Edit Booking Marketing</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Edit Boking Marketing</a></li>
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
								<form class="form-horizontal" metode="POST" action="<?=$aksi?>?module=aproval&act=edit">	
								<!-- /.col -->
								<div class="col-md-6">	
								<H3 align="center">SPEK BLOK RUMAH :</H3>
										<div class="box-body">
                                        	<script type="text/javascript" >
												$(document).ready(function(){
													$('#koma').maskMoney({precision:0});
												});
											
												function net1() {
													var a = document.getElementById("txtharga").value;
													var b = document.getElementById("txtdisc").value;
													var c = document.getElementById("txtcb").value;
													var d = parseFloat(a)-(parseFloat(b)+parseFloat(c));
													var e = document.getElementById("txtum").value;
													var f = d-e;
			
													//var g = (f*(20/1200))*(1/(1-(1/((((1+(20/1200))^(10*12)))))));
													 if (!isNaN(d,e,f)) {
														 document.getElementById('txtnet').value = d;
														 document.getElementById('txtum').value = e;
														 document.getElementById('txtkpr').value = f;
														 //document.getElementById('txtlima').value = g;
													  }
												}	
											</script>
													<?php
												
														$qry0=mysql_query("Select * from nasabah as n 
														join profil_buyer as pu ON n.id_buyer = pu.id_buyer 
														
														where n.id_nasabah='$_GET[id]'");
									  					$hasil0=mysql_fetch_array($qry0); 
									  					
														?>
													<input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>">	
                                                    
											<div class="form-group">
												<label class="col-sm-5 control-label">Tanggal :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="tgl_beli" value="<?=$hasil0['tgl_beli']?>" readonly />
												</div>
											</div>											
											<div class="form-group">
												<label class="col-sm-5 control-label">Nama Blok Rumah :</label>
												<div class="col-sm-5">
 													<input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Jenis Type :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="tipe" value="<?=$hasil0['type_rumah']?>" />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Harga Jual :</label>
												<div class="col-sm-5">
                                                
													<input class="form-control" id="txtharga" type="text" name="harga" value="<?=$hasil0['harga_jual']+$hasil0['disc']+$hasil0['cb']?>" onFocus="net1()"/>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Discount :</label>
												<div class="col-sm-5">
													<input class="form-control" id="txtdisc" type="text" name="disc" value="<?=$hasil0['disc']?>"  onFocus="net1()"/>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Cash Back :</label>
												<div class="col-sm-5">
													<input class="form-control" id="txtcb" type="text" name="cb" value="<?=$hasil0['cb']?>"  onFocus="net1()"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-sm-5 control-label">Harga Netto :</label>
												<div class="col-sm-5">
													<input class="form-control" id="txtnet" type="text" name="net" value="<?=$hasil0['harga_jual']?>"  onFocus="net1()"/>
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">Uang Muka (Nominal Yg Harus Dibayar):</label>
												<div class="col-sm-5">
													<input class="form-control" id="txtum" type="text" name="um" value="<?=$hasil0['um']?>" onFocus="net1()" />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">KPR :</label>
												<div class="col-sm-5">
													<input class="form-control" id="txtkpr" type="text" name="kpr" value="<?=$hasil0['kpr']?>" onFocus="net1()"/>
												</div>
											</div>
											<!--		
											<div class="form-group">
												<label class="col-sm-5 control-label">5 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="lima" value="<?=$hasil0['5th']?>"  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">10 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="sepuluh" value="<?=$hasil0['10th']?>"  />
												</div>
											</div>	
											<div class="form-group">
												<label class="col-sm-5 control-label">15 Tahun :</label>
												<div class="col-sm-5">
													<input class="form-control" type="text" name="limabelas" value="<?=$hasil0['15th']?>" />
												</div>
											</div>	
                                            -->												
										</div>
								</div>
									
								<div class="col-md-6">
								<H3 align="center">DATA FPR USER :</H3>
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-5 control-label">No FPR :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="no_fpr" value=<?=$hasil0['fpr']?> autofocus required />
											</div>
										</div>									
										<div class="form-group">
											<label class="col-sm-5 control-label">Nama User :</label>
											<div class="col-sm-5">
											    <input class="form-control" type="hidden" name="id_buyer" value="<?=$hasil0['id_buyer']?>" />
												<input class="form-control" type="text" name="nm_nasabah" value="<?=$hasil0['nama_user']?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Alamat Rumah :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="alamat" value="<?=$hasil0['alamat_rmh']?>" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">No. KTP :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="ktp" value="<?=$hasil0['no_ktp']?>" autofocus required />
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-5 control-label">No. Telepon :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="telp" value="<?=$hasil0['telp']?>" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Pekerjaan :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="pekerjaan" value="<?=$hasil0['pekerjaan']?>" autofocus required/>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-5 control-label">Alamat Kantor :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="alamat_kantor" value="<?=$hasil0['alamat_kantor']?>" autofocus required />
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Telp Kantor :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="telp_kantor" value="<?=$hasil0['telp_kantor']?>" autofocus required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Gaji Perbulan :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="gaji" placeholder="Input tanpa Titik dan Koma" value="<?=$hasil0['gaji_bln']?>" autofocus required/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-5 control-label">Penghasilan Lain-lain :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="usaha_lain"placeholder="Input tanpa Titik dan Koma" value="<?=$hasil0['penghasilan_lain']?>" autofocus required/>
											</div>
										</div>																			
										<div class="form-group">
											<label class="col-sm-5 control-label">Cara Pembelian :</label>
											<div class="col-sm-5">
												<select class="form-control" name="ket">
													<option value="<?=$hasil0['ket']?>"> <?=$hasil0['ket']?> </option>
													<option value="Cash">Cash Keras</option>
													<option value="Inhouse">Cash Bertahap/Inhouse</option>
													<option value="KPR">KPR Bank</option>
												</select>
											</div>
										</div>	
										
										<!-- <div class="form-group">
											<label class="col-sm-5 control-label">Pembayaran Tanda Jadi (Rp) :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="tj" placeholder="Input tanpa Titik dan Koma"  autofocus required  />
											</div>
										</div>
										 
										<div class="form-group">
											<label class="col-sm-5 control-label">Nomor Kwitansi :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="no_kw" value="<?=$hasil0['referensi']?>"  autofocus required  />
											</div>
										</div>	-->										
										<div class="form-group">
											<label class="col-sm-5 control-label">Rencana Bayar UM I (Rp) :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="um1"value="<?=$hasil0['um1']?>" placeholder="Input tanpa Titik dan Koma"  autofocus required  />
											</div>
										</div>	
										
										<div class="form-group">
											<label class="col-sm-5 control-label">Rencana Tgl Bayar UM I (tgl) :</label>
											<div class="col-sm-5">
												<input class="form-control" type="date" name="tgl_byr_um1" value="<?=$hasil0['tgl_um1']?>" autofocus required />
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-5 control-label">Periode Angsuran :</label>
											<div class="col-sm-5">
												<input class="form-control" type="text" name="periode" value="<?=$hasil0['periode']?>" placeholder="Jumlah periode dalam bulan" autofocus required/>
											</div>
										</div>		
											
									</div>
								</div>
							</div>
							<div class="box-footer">
							    
								<button type="submit" name="edit" class="btn btn-primary pull-right">Submit</button>
							</div>
						</form>
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
