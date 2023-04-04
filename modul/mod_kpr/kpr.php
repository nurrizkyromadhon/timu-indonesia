<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
	$aksi="modul/mod_kpr/aksi_kpr.php";
	switch($_GET[act]){
		// Tampil User
		default:
			?>
				<section class="content-header">
					<h1>Home</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
						<li class="active">Proses ke Akad</li>
					</ol>
				</section>
				<!-- Main content -->
				<section class="content">
				
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Proses Akad</h3>
						</div>
						<!-- /.box-header -->
						<div class="table-responsive">
						<div class="box-body">
							<div class="row">	
									<center><h2>Rumah Sudah Terjual Belom AKAD</h2></center>
									<table id="myTable1" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>TGL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>VIR. ACCOUNT</th>
										  <th>TYPE</th>
										  <th>SHGB</th>
										  <th>PBB</th>
										  <th>FPR</th>
										  <th>OB</th>
										  <th>PPJB</th>
										  <th>HARGA</th>
										  <th>KPR</th>
										  <th>UM</th>									  
										  <th>AKSI</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi='3'and aproval='OK'
										order by n.tgl_beli desc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											$id_nasabah=$hasil['id_nasabah'];
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_beli']?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['v_account']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['no_shgb']?></td>
											<td><?=$hasil['no_pbb']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td align="right"><?=number_format($hasil['harga_jual'])?></td>
											<td align="right"><?=number_format($hasil['kpr'])?></td>
											<td align="right"><?=number_format($hasil['um'])?></td>
										
											<td>
												<button type="button" class="btn-sm" onclick="location.href='<?php echo "?module=proses_kpr&act=tambah&id=$id_nasabah";?>';" ><i class="fa fa-edit"></i></button>

												<button type="button" class="btn-sm btn-info" onclick="location.href='<?php echo "?module=proses_kpr&act=print_fpr&id=$id_nasabah";?>';" ><i class="fa fa-print"></i></button>
											  </td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
							</div>
						</div>
						</div>	
								<!-- /.box-body -->
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
							</div>
						</div>
						<!-- /.box-footer -->
					</div>
					<!-- /.box default-->				
				</section>
				
				<section class="content">
				
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Proses Akad</h3>
						</div>
						<!-- /.box-header -->
						<div class="table-responsive">
						<div class="box-body">
							<div class="row">	
								<h2 align="center">Rumah Sudah Terjual</h2>
							</div>
							<div class="row-sm">
								<div class="table-responsive">
									<table id="myTable2" class="table table-bordered table-striped">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>TANGGAL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>VIR. ACCOUNT</th>
										  <th>TYPE</th>
										  <th>SHGB</th>
										  <th>PBB</th>
										  <th>FPR</th>
										  <th>OB</th>
										  <th>PPJB</th>
										  <th>HARGA</th>
										  <th>KPR</th>
										  <th>UM</th>
										  <th>AJB</th>
										  <th>BANK</th>
										  <th>NOTARIS</th>										  
										  <th>update</th>
										  <th>Print</th>

									  </tr> 
									  </thead>
									  <tbody>
									  <?php
									$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										where n.id_indikasi!='1'
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){	
											$id_nasabah=$hasil['id_nasabah'];
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['tgl_beli']?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['v_account']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['no_shgb']?></td>
											<td><?=$hasil['no_pbb']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td align="right"><?=number_format($hasil['harga_jual'])?></td>
											<td align="right"><?=number_format($hasil['kpr'])?></td>
											<td align="right"><?=number_format($hasil['um'])?></td>
											<td><?=$hasil['ajb']?></td>
											<td><?=$hasil['bank']?></td>
											<td><?=$hasil['notaris']?></td>
											
											<td>
												<button type="button" class="btn-sm" onclick="location.href='<?php echo "?module=proses_kpr&act=tambah&id=$id_nasabah";?>';" ><i class="fa fa-edit"></i></button>
											</td>
											<td>
												<button type="button" class="btn-sm btn-info" onclick="location.href='<?php echo "?module=proses_kpr&act=print_fpr&id=$id_nasabah";?>';" ><i class="fa fa-print"></i></button>
											</td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
								</div>
							</div>
							</div>
								<!-- /.box-body -->
						
						
						<div class="box-footer">
							<div class="text-center">
								<!--<a href="?module=spp&act=tambah"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>-->
								
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
					<h1>Update User Proses AKAD</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Proses Ke AKAD</a></li>
						<li class="active">Form Update</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Update</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=proses_kpr&act=update">
										<div class="col-md-6">	
												<div class="box-body">
													<div class="form-group">
														<label class="col-sm-5 control-label">Tanggal update:</label>
														<div class="col-sm-5">
															<input class="form-control" type="date" name="tgl_update" value="<?=date('Y-m-d')?>" />
														</div>
													</div>											
													<div class="form-group">
														<label class="col-sm-5 control-label">Blok Rumah :</label>
														<div class="col-sm-5">
															<?php
																$qry0=mysql_query("Select *, nasabah.um as umn, nasabah.kpr as nkpr, nasabah.ket as nket from nasabah join harga on harga.id_harga=nasabah.id_harga where id_nasabah='$_GET[id]';");
																$hasil0=mysql_fetch_array($qry0); 
																?>
														  <input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>">	
														  <input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama User :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="nm_user" value="<?=$hasil0['nama_user']?>" readonly />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Virtual Account :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="v_account" value="<?=$hasil0['v_account']?>"  />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Jenis Type :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="type_rumah" value="<?=$hasil0['type_rumah']?>" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">No SHGB :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="no_shgb" value="<?=$hasil0['no_shgb']?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No PBB :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="no_pbb" value="<?=$hasil0['no_pbb']?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No FPR :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="fpr" value="<?=$hasil0['fpr']?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No PPJB :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="=ppjb" value="<?=$hasil0['ppjb']?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No OB :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="ob" value="<?=$hasil0['ob']?>" />
														</div>
													</div>
											</div>	
										</div>		
										<div class="col-md-6">
												<div class="box-body">
													<div class="form-group">
														<label class="col-sm-5 control-label">Harga Jual :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga" value="<?=number_format($hasil0['harga'])?>" id="koma" readonly  />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Discount (-) :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga" value="<?=number_format($hasil0['disc'])?>" id="koma" readonly  />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">CashBack (-) :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="cb" value="<?=number_format($hasil0['cb'])?>" id="cb"  />
														</div>
													</div>						
													<div class="form-group">
														<label class="col-sm-5 control-label">Harga Netto :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga" value="<?=number_format($hasil0['harga_jual'])?>" id="koma"  />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Uang Muka (-) :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="um" value="<?=number_format($hasil0['umn'])?>" id="um"  />
														</div>
													</div>		
													<div class="form-group">
														<label class="col-sm-5 control-label">KPR :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="kpr" value="<?=number_format($hasil0['nkpr'])?>" id="kpr"  />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">No AJB:</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="ajb" />
														</div>
													</div>		
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama Notaris:</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="notaris" value="<?=$hasil0['notaris']?>" />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama Bank KPR:</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="bank" value="<?=$_POST[bank]?>" />
															<input type="hidden" name="periode" value="<?=$hasil0['periode']?>">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Tanggal Akad :</label>
														<div class="col-sm-5">
															<input class="form-control" type="date" name="tgl_real" value="<?=$hasil0['tgl_real']?>" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No Meter :</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="no_meter" value="<?=$hasil0['no_meter']?>" />
														</div>
													</div>			
													<div class="form-group">
														<label class="col-sm-5 control-label">Keterangan :</label>
														<div class="col-sm-5">
														  <textarea name="ket_update" class="form-control" rows="3"  placeholder="Enter ..."><?=$hasil0['nket']?></textarea>
														</div>
													</div>	
													<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>					
												</div>
										</div>
									</form>
								</div>	
							</div>
						</div>
					</div>
				</div>
				</section>
				<script>			
				  $(document).ready(function(){
					$('#koma').maskMoney({precision:0});
					$('#kpr').maskMoney({precision:0});
					$('#cb').maskMoney({precision:0});
					$('#um').maskMoney({precision:0});
				  });	
				</script>
			<?php
			break;
		
		case "print_fpr":
			//Rubah SQL dibawah ini
			/* $edit=mysql_query("SELECT * FROM spp WHERE id_spp='$_GET[id]'");
			$r=mysql_fetch_array($edit); */
			?>
				<section class="content-header">
					<h1>Penyerahan Document dari Marketing</h1>
					<ol class="breadcrumb">
						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="#">Print</a></li>
						<li class="active">Form Penerimaan Document</li>
					</ol>
				</section>

				<!-- Main content -->
				<section class="content">

				  <!-- SELECT2 EXAMPLE -->
					<div class="box box-default">
						<div class="box-header with-border">
							<h3 class="box-title">Form Penerimaan Document FPR</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									<?php
										$qry0=mysql_query("Select *,n.kpr, n.um, n.harga_jual, n.ket as keter, n.tgl_um1 as tu, n.um1 as u, n.tgl_beli as tb from nasabah as n 
										join profil_buyer as pb on n.id_buyer=pb.id_buyer 
										join profil as p on n.id_profil=p.id_profil
										join harga as h on n.id_harga=h.id_harga
										where id_nasabah='$_GET[id]';");
										$hasil0=mysql_fetch_array($qry0); 
									?>									
											<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=kpr&act=print">
												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-5 control-label">Tanggal update:</label>
														<div class="col-sm-5">
															<input class="form-control" type="text" name="tgl" value="<?=$hasil0['tgl_beli']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No FPR :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="fpr" value="<?=$hasil0['fpr']?>" readonly />
														</div>
													</div>		
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama User :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="nm_user" value="<?=$hasil0['nama_user']?>"readonly />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Alamat :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="alamat_rmh" value="<?=$hasil0['alamat_rmh']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No. KTP :</label>
														<div class="col-sm-5">
														  <input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>">	
														  <input class="form-control" type="text" name="no_ktp" value="<?=$hasil0['no_ktp']?>" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">No. Telepon :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="telp" value="<?=$hasil0['telp']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Pekerjaan :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="pekerjaan" value="<?=$hasil0['pekerjaan']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Alamat Kantor :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="alamat_kantor" value="<?=$hasil0['alamat_kantor']?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Telepon Kantor :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="telp_kantor" value="<?=$hasil0['telp_kantor']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Gaji Per Bulan :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="gaji_bln" value="<?=number_format($hasil0['gaji_bln'])?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Penghasilan Lain-lain :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="penghasilan_lain" value="<?=$hasil0['penghasilan_lain']?>" readonly/>
														</div>
													</div>
												
												</div>									
												<div class="col-md-6">	
												
													<div class="form-group">
														<label class="col-sm-5 control-label">Nama Perumahan :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="nm_perumh" value="<?=$hasil0['nm_perumh']?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Type Rumah :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="tipe" value="<?=$hasil0['type_rumah']?>" readonly/>
														</div>
													</div>							
													<div class="form-group">
														<label class="col-sm-5 control-label">Blok Rumah :</label>
														<div class="col-sm-5">
														  <input type="hidden" name="id_nasabah" value="<?=$_GET['id']?>">	
														  <input class="form-control" type="text" name="block" value="<?=$hasil0['coord']?>" readonly />
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Cara Pembelian :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="cara_byr" value="<?=$hasil0['keter']?>" readonly/>
														</div>
													</div>	
													<div class="form-group">
														<label class="col-sm-5 control-label">Harga Jual :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga" value="<?=number_format($hasil0['harga'])?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Discount :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="disc" value="<?=number_format($hasil0['disc'])?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Cash Back :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="cb" value="<?=number_format($hasil0['cb'])?>" readonly/>
														  <input type="hidden" name="tgl_um1" value="<?=$_hasil0['tu']?>">
														  <input type="hidden" name="um1" value="<?=number_format($hasil0['u'])?>">
														  <input type="hidden" name="periode" value="<?=$hasil0['periode']?>">
														  <input type="hidden" name="tb" value="<?=$hasil0['tb']?>">
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Harga Netto :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="harga_net" value="<?=number_format($hasil0['harga_jual'])?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">Uang Muka :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="um" value="<?=number_format($hasil0['um'])?>" readonly/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-5 control-label">KPR :</label>
														<div class="col-sm-5">
														  <input class="form-control" type="text" name="kpr" value="<?=number_format($hasil0['kpr'])?>" readonly/>
														</div>
													</div>
													
												</div>
												<div class="box-footer">
													<button type="submit" name="submit" class="btn btn-primary pull-right" formtarget="_blank"  ><i class="fa fa-print"></i>  Print</button>
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
