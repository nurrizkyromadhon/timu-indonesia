<?php

session_start();

 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){

  echo "<link href='style.css' rel='stylesheet' type='text/css'>

 <center>Untuk mengakses modul, Anda harus login <br>";

  echo "<a href=../../index.php><b>LOGIN</b></a></center>";

}

else{

	$aksi="modul/mod_harga/aksi_harga.php";

	?>

		<script type="text/javascript" src="plugins/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

		<link rel="stylesheet" type="text/css" href="plugins/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />	

	<?php

	switch($_GET[act]){

		// Tampil User

		default:

			?>

				<section class="content-header">

					<h1>HARGA</h1>

					<ol class="breadcrumb">

						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

						<li class="active">Harga</li>

					</ol>

				</section>



				<!-- Main content -->

				<section class="content">



				  <!-- SELECT2 EXAMPLE -->

					<div class="box box-default">

						<div class="box-header with-border">

							<h3 class="box-title">Harga Semua Blok Rumah</h3>

						</div>

						<!-- /.box-header -->

						<div class="box-body">

							<div class="row">

								<!-- /.col -->

								<div class="col-md-12">
									<div class="table-responsive">

									<table id="myTable" class="table table-bordered table-striped">

								  	<thead>

									  <tr align="center">

										<th>No</th>

										<th>Type</th>

										<th>Blok Rumah</th>

										<th>Harga Jual</th>

										<th>Discount</th>

										<th>Cash Back</th>

										<th>Harga Netto</th>

										<th>Uang Muka</th>

										<th>KPR</th>

										<th>5th</th>

										<th>10th</th>

										<th>15th</th>

										<th>Aksi</th>

									  </tr>

								    </thead>

								    <tbody>

									  <?

									  $no=1;

									  $query="select * from harga where ket!='Terjual' and ket !='KAVLING KHUSUS /NON STANDART' order by no_blok";

									  $qry=mysql_query($query);

									  while ($hasil=mysql_fetch_array($qry)){

										  $tipe=$hasil['tipe'];

										  $no_blok=$hasil['no_blok'];

										  $harga=$hasil['harga'];

										  $disc=$hasil['disc'];

										  $harga_net=$hasil['harga_net'];

										  $um=$hasil['um'];

										  $kpr=$hasil['kpr'];

										  $lima=$hasil['5th'];

										  $sepuluh=$hasil['10th'];

										  $limabelas=$hasil['15th'];

										  $blok=$hasil['blok'];

										  $cashback=$hasil['cashback'];

									  ?>

									  <tr>

										<td  class="td1"><?=$no?></td>

										<td  class="td1"><?=$tipe?></td>

										<td  class="td1"><?=$no_blok?></td>

										<td  class="td1"><?=number_format($harga)?></td>

										<td  class="td1"><?=number_format($disc)?></td>

										<td  class="td1"><?=number_format($cashback)?></td>

										<td  class="td1"><?=number_format($harga_net)?></td>

										<td  class="td1"><?=number_format($um)?></td>

										<td  class="td1"><?=number_format($kpr)?></td>

										<td  class="td1"><?=number_format($lima)?></td>

										<td  class="td1"><?=number_format($sepuluh)?></td>

										<td  class="td1"><?=number_format($limabelas)?></td>

										<td align="center"  class="td1">	

										<button type="button" class="btn btn-primary" onclick="location.href='<?php echo "?module=harga&act=edit2&id=$hasil[id_harga]";?>';" ><i class="fa fa-edit"></i></button>

										

										<button type="button" class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=harga&act=hapus&id=$hasil[id_harga]";?>'; alert('Pastikan Data akan Terhapus')" ><i class="fa fa-trash"  ></i></button>

										  </td>

									  </tr>

									  <? $no++; } ?>

									</tbody>  

									</table>
									</div>
								</div>

								<!-- /.box-body -->

							</div>

							<!-- /.box -->

						</div>

						

						<div class="box-footer">

							<div class="text-center">

								<a href="?module=coordinat_harga"><button type="button" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i>&nbsp Tambah Data</button></a>

								<a href="<?=$aksi?>?module=harga&act=save_to_excel"><button type="button" class="btn btn-secondary"><i class="fa fa-fw fa-save"></i>Save to Excel</button></a>

							</div>



						</div>

						<!-- /.box-footer -->

						<!-- /.col -->

					</div>

					<!-- /.row -->

				</section>

				

				<section class="content">

				  <!-- SELECT2 EXAMPLE -->

					<div class="box box-default">

						<div class="box-header with-border">

							<h3 align="center">HARGA JUAL</h3><P>

							<h3 align="center">PERUMAHAN GRAND ALOHA REGENSI</h3>

							<h3 align="center">Blok Rumah KHUSUS / NON STANDART</h3>

						</div>

						<!-- /.box-header -->

						<div class="box-body">

							<div class="row">

								<!-- /.col -->

								<div class="col-md-12">
								    <div class="table-responsive">
									<table id="myTable1" class="table table-bordered table-striped">

								  	<thead>

									  <tr align="center">

										<th>No</th>

										<th>Type</th>

										<th>Blok Rumah</th>

										<th>Harga Jual</th>

										<th>Discount</th>

										<th>Cash Back</th>

										<th>Harga Netto</th>

										<th>Uang Muka</th>

										<th>KPR</th>

										<th>5th</th>

										<th>10th</th>

										<th>15th</th>

										<th>Aksi</th>										

									  </tr>

								    </thead>

								    <tbody>

									  <?

									  $no=1;

									  $query="select * from harga where ket='KAVLING KHUSUS /NON STANDART' order by harga asc";

									  $qry=mysql_query($query);

									  while ($hasil=mysql_fetch_array($qry)){

									  $tipe=$hasil['tipe'];

									  $no_blok=$hasil['no_blok'];

									  $harga=$hasil['harga'];

									  $disc=$hasil['disc'];

									  $cashback=$hasil['cashback']; 

									  $harga_net=$hasil['harga_net'];

									  $um=$hasil['um'];

									  $kpr=$hasil['kpr'];

									  $lima=$hasil['5th'];

									  $sepuluh=$hasil['10th'];

									  $limabelas=$hasil['15th'];

									  $blok=$hasil['blok'];



									  ?>

									  <tr>

										<td  class="td1"><?=$no?></td>

										<td  class="td1"><?=$tipe?></td>

										<td  class="td1"><?=$no_blok?></td>

										<td  class="td1"><?=number_format($harga)?></td>

										<td  class="td1"><?=number_format($disc)?></td>

										<td  class="td1"><?=number_format($cashback)?></td>

										<td  class="td1"><?=number_format($harga_net)?></td>

										<td  class="td1"><?=number_format($um)?></td>

										<td  class="td1"><?=number_format($kpr)?></td>

										<td  class="td1"><?=number_format($lima)?></td>

										<td  class="td1"><?=number_format($sepuluh)?></td>

										<td  class="td1"><?=number_format($limabelas)?></td>

										<td>

										<button type="button" class="btn btn-primary" onclick="location.href='<?php echo "?module=harga&act=edit2&id=$hasil[id_harga]";?>';" ><i class="fa fa-edit"></i></button>


										<button type="button" class="btn btn-danger" onclick="location.href='<?php echo "$aksi?module=harga&act=hapus&id=$hasil[no]";?>'; alert('Pastikan Data akan Terhapus')" ><i class="fa fa-trash"  ></i></button>								</td>		

									  </tr>

									  <? $no++; } ?>

									</tbody>  

									</table>
								     </div>
								</div>

								<!-- /.box-body -->

							</div>

							<!-- /.box -->

						</div>

						<!-- /.col -->

					</div>

					<!-- /.row -->	

							<div class="text-center">

								<a href="<?=$aksi?>?module=harga&act=save_to_excel2"><button type="button" class="btn btn-secondary"><i class="fa fa-fw fa-save"></i>Save to Excel</button></a>

							</div>

				</section>

					<script>

					$(document).ready(function(){

						$('#myTable').dataTable();

						$('#myTable1').dataTable();

					});

					</script>

			<?php

			break;

	  

		case "tambah":

			?>

				<section class="content-header">

					<h1>Harga Perumahan</h1>

					<ol class="breadcrumb">

						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

						<li><a href="#">Harga Perumahan</a></li>

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

								  <?php				

									  $qry=mysql_query("Select * from harga join coord on harga.id_coord=coord.id_coord where harga.id_coord='$_GET[id]';");

									  $hasil=mysql_fetch_array($qry);

								  ?>	

								  <input type="hidden" name="id_profil" value="<?=$hasil['id_profil']?>">

									<!-- form start -->

									<script type="text/javascript">

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

									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=harga&act=input">

									

										<div class="box-body">

										<?=$hasil['blok']?>

											<div class="form-group">

												<label class="col-sm-3 control-label">Nama Blok Rumah :</label>

												<div class="col-sm-5">

													<?php

									  				 if (empty($hasil['block'])){

														$qry0=mysql_query("Select * from coord where id_coord='$_GET[id]';");

									  					$hasil0=mysql_fetch_array($qry0); 

														?>

														<input class="form-control" type="text" name="block" value="<?=$hasil0['block']?>" />

														<input type="hidden" name="id_coord" value="<?=$_GET['id']?>">

														<? 

													 }else{

													?>

													<input class="form-control" type="text" name="block" value="<?=$hasil['block']?>" />

													<? } ?>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Jenis Type :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="tipe" value="<?=$hasil['tipe']?>" required />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Jual :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="harga" value="0" id="txtharga" onFocus="net1()"  required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Discount :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="disc" value="0" id="txtdisc" onFocus="net1()"  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Cash Back :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="cb" value="0" id="txtcb" onFocus="net1()"  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Netto :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="net"  id="txtnet" onFocus="net1()"  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Uang Muka :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="um" id="txtum" value="0" >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">KPR :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="kpr" value="0" id="txtkpr" onFocus="net1()" required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">5 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="lima" value="<?=$hasil['5th']?>" id="txtlima" onFocus="net1()" required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">10 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="sepuluh" value="<?=$hasil['10th']?>" id="sepuluh" required  />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">15 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="limabelas" value="<?=$hasil['15th']?>" id="limabelas" required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Keterangan :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="ket" value="<?=$hasil['ket']?>" required />

												</div>

											</div>																					

																					

										</div>

										 <?php

										 if (empty($hasil['block'])){	

										 ?>	 

										<div class="box-footer">

											<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>

										</div>

										<? } ?>

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

			?>

				<section class="content-header">

					<h1>Harga Perumahan</h1>

					<ol class="breadcrumb">

						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

						<li><a href="#">Harga Perumahan</a></li>

						<li class="active">Form Tambah</li>

					</ol>

				</section>



				<!-- Main content -->

				<section class="content">

				  <!-- SELECT2 EXAMPLE -->

					<div class="box box-default">

						<div class="box-header with-border">

							<h3 class="box-title">Form EDIT</h3>

						</div>

						<!-- /.box-header -->

						<div class="box-body">

							<div class="row">

								<!-- /.col -->

								<div class="col-md-12">	

								  <?php				

									  $qry=mysql_query("Select * from harga join coord on harga.id_coord=coord.id_coord where harga.id_coord='$_GET[id]';");

									  $hasil=mysql_fetch_array($qry);

								  ?>	

								  <input type="hidden" name="id_profil" value="<?=$hasil['id_profil']?>">

									<!-- form start -->

									<script type="text/javascript">

									

									function net1() {

										var a = document.getElementById("harga").value;

										var b = document.getElementById("disc").value;

										var c = document.getElementById("cb").value;

										var d = parseFloat(a)-(parseFloat(b)+parseFloat(c));

										var e = document.getElementById("um").value;

										var f = d-e;

										//var g = (f*(20/1200))*(1/(1-(1/((((1+(20/1200))^(10*12)))))));

										

										 if (!isNaN(d,e,f)) {

											 document.getElementById('net').value = d;

											 //document.getElementById('um').value = e;

											 document.getElementById('kpr').value = f;

											 //document.getElementById('txtlima').value = g;

										  }

									}

									</script>

									

									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=harga&act=edit">

									

										<div class="box-body">

										<?=$hasil['blok']?>

											<div class="form-group">

												<label class="col-sm-3 control-label">Nama Blok Rumah :</label>

												<div class="col-sm-5">

													<?php

									  				 if (empty($hasil['block'])){

														$qry0=mysql_query("Select * from coord where id_coord='$_GET[id]';");

									  					$hasil0=mysql_fetch_array($qry0); 

														?>

														<input class="form-control" type="text" name="block" value="<?=$hasil0['block']?>" />

														<input type="hidden" name="id_coord" value="<?=$_GET['id']?>">

														<? 

													 }else{

													?>

													<input type="hidden" name="id_coord" value="<?=$_GET['id']?>">

													<input class="form-control" type="text" name="block" value="<?=$hasil['block']?>" />

													<? } ?>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Jenis Type :</label>

												<div class="col-sm-5">

													<input type="hidden" name="id_harga" value="<?=$hasil['id_harga']?>">

													<input class="form-control" type="text" name="tipe" value="<?=$hasil['tipe']?>" required />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Jual :</label>

												<div class="col-sm-5">

													<input class="form-control harga" type="text" name="harga" value="<?=$hasil['harga']?>" id="harga"  onkeyup="net1()" required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Discount :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="disc" value="<?=$hasil['disc']?>" id="disc"  onkeyup="net1();" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Cash Back :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="cb" value="<?=$hasil['cashback']?>" id="cb"  onkeyup="net1();" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Netto :</label>

												<div class="col-sm-5">

													<input class="form-control net" type="text" name="net" value="<?=$hasil['harga_net']?>" id="net" onkeyup="net1()" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Uang Muka :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="um" value="<?=$hasil['um']?>" id="um" >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">KPR :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="kpr" value="<?=$hasil['kpr']?>" id="kpr" onFocus="net1()"  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">5 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="lima" value="<?=$hasil['5th']?>" id="lima"   >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">10 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="sepuluh" value="<?=$hasil['10th']?>" id="sepuluh"   />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">15 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="limabelas" value="<?=$hasil['15th']?>" id="limabelas"   >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Keterangan :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="ket" value="<?=$hasil['ket']?>" required />

												</div>

											</div>																					

																					

										</div>

										<div class="box-footer">

											<button type="submit" name="submit" class="btn btn-primary pull-right">Edit</button>

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

				case "edit2":

			?>

				<section class="content-header">

					<h1>Harga Perumahan</h1>

					<ol class="breadcrumb">

						<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

						<li><a href="#">Harga Perumahan</a></li>

						<li class="active">Form Tambah</li>

					</ol>

				</section>



				<!-- Main content -->

				<section class="content">

				  <!-- SELECT2 EXAMPLE -->

					<div class="box box-default">

						<div class="box-header with-border">

							<h3 class="box-title">Form EDIT</h3>

						</div>

						<!-- /.box-header -->

						<div class="box-body">

							<div class="row">

								<!-- /.col -->

								<div class="col-md-12">	

								  <?php				

									  $qry=mysql_query("Select * from harga join coord on harga.id_coord=coord.id_coord where harga.id_harga='$_GET[id]';");

									  $hasil=mysql_fetch_array($qry);

								  ?>	

								  <input type="hidden" name="id_profil" value="<?=$hasil['id_profil']?>">

									<!-- form start -->

									<script type="text/javascript">

									

									function net1() {

										var a = document.getElementById("harga").value;

										var b = document.getElementById("disc").value;

										var c = document.getElementById("cb").value;

										var d = parseFloat(a)-(parseFloat(b)+parseFloat(c));

										var e = document.getElementById("um").value;

										var f = d-e;

										//var g = (f*(20/1200))*(1/(1-(1/((((1+(20/1200))^(10*12)))))));

										

										 if (!isNaN(d,e,f)) {

											 document.getElementById('net').value = d;

											 //document.getElementById('um').value = e;

											 document.getElementById('kpr').value = f;

											 //document.getElementById('txtlima').value = g;

										  }

									}

									</script>

									

									<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=harga&act=edit">

									

										<div class="box-body">

										<?=$hasil['blok']?>

											<div class="form-group">

												<label class="col-sm-3 control-label">Nama Blok Rumah :</label>

												<div class="col-sm-5">

													<?php

									  				 if (empty($hasil['block'])){

														$qry0=mysql_query("Select * from coord where block='$hasil[block]';");

									  					$hasil0=mysql_fetch_array($qry0); 

														?>

														<input class="form-control" type="text" name="block" value="<?=$hasil0['block']?>" />

														<input type="hidden" name="id_coord" value="<?=$hasil0['id_coord']?>">

														<? 

													 }else{

													
                                                        $qry0=mysql_query("Select * from coord where block='$hasil[block]';");

									  					$hasil0=mysql_fetch_array($qry0); 

														?>
													<input type="hidden" name="id_coord" value="<?=$hasil0['id_coord']?>">

													<input class="form-control" type="text" name="block" value="<?=$hasil['block']?>" />

													<? } ?>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Jenis Type :</label>

												<div class="col-sm-5">

													<input type="hidden" name="id_harga" value="<?=$hasil['id_harga']?>">

													<input class="form-control" type="text" name="tipe" value="<?=$hasil['tipe']?>" required />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Jual :</label>

												<div class="col-sm-5">

													<input class="form-control harga" type="text" name="harga" value="<?=$hasil['harga']?>" id="harga"  onkeyup="net1()" required  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Discount :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="disc" value="<?=$hasil['disc']?>" id="disc"  onkeyup="net1();" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Cash Back :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="cb" value="<?=$hasil['cashback']?>" id="cb"  onkeyup="net1();" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Harga Netto :</label>

												<div class="col-sm-5">

													<input class="form-control net" type="text" name="net" value="<?=$hasil['harga_net']?>" id="net" onkeyup="net1()" required>

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Uang Muka :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="um" value="<?=$hasil['um']?>" id="um" >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">KPR :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="kpr" value="<?=$hasil['kpr']?>" id="kpr" onFocus="net1()"  >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">5 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="lima" value="<?=$hasil['5th']?>" id="lima"   >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">10 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="sepuluh" value="<?=$hasil['10th']?>" id="sepuluh"   />

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">15 Tahun :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="limabelas" value="<?=$hasil['15th']?>" id="limabelas"   >

												</div>

											</div>	

											<div class="form-group">

												<label class="col-sm-3 control-label">Keterangan :</label>

												<div class="col-sm-5">

													<input class="form-control" type="text" name="ket" value="<?=$hasil['ket']?>" required />

												</div>

											</div>																					

																					

										</div>

										<div class="box-footer">

											<button type="submit" name="submit" class="btn btn-primary pull-right">Edit</button>

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

