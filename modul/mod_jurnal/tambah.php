<section class="content-header">
		<h1>JURNAL</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Jurnal</a></li>
			<li class="active">Form Tambah Jurnal</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">

      <!-- SELECT2 EXAMPLE -->
      
		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Form Tambah Jurnal</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<div class="table-responsive">
					<div class="col-md-12">	
						<!-- form start -->
						<form class="form-horizontal" method="POST" action="<?=$aksi?>?module=jurnal&act=input">
							<div class="box-body">
								<div class="row">
								<!-- /.col -->
								<div class="col-md-12">	
									<!-- form start -->
									  <div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">Tanggal</label>
										  <div class="col-sm-3">
											<input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?php echo date("Y-m-d");?>">
										  </div>
										</div>
										<div class="box-body">
										<div class="form-group">
										  <label class="col-sm-1 control-label">No. Jurnal</label>
										  <div class="col-sm-3">
											<input type="text" class="form-control" name="no_jurnal" placeholder="Nomor Jurnal " value="J.<?=date("y.m")?>." >
										  </div>
										</div>
									  <div class="box-body">
										
										<div class="product-item form-group">
							  		  	  <!--<div class="col-sm-2">
										  </div>
								  		  <div class="col-sm-2">
									  		<select class="form-control select2" style="width: 100%;" name="nm_perkiraan[]">
											  <option value="">Pilihan Account</option>
												<?php
													$query=mysql_query("select * from perkiraan order by id_perkiraan asc");
													while ($hasil=mysql_fetch_array($query)){
												?>
													<option value="<?=$hasil['id_perkiraan']?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></option>
												<?php
													}
												?>
							      			</select>
										  </div>-->	
										  <div class="col-sm-1">
												<button type="button" class="btn btn-danger pull-right" onclick="openwindow(1)"><span class="fa fa-search"></button>
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" id="nm_perkiraan1" name="nm_perkiraan[]" placeholder="Nama Perkiraan" readonly>
										  </div>
										  <div class="col-sm-1">
										  <input type="text" class="form-control" name="no_ref[]" placeholder="Referensi">
										  </div>
										  
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="ket[]" placeholder="Keterangan">
										  </div>
										  <div class="col-sm-2">
											<input type="text" class="form-control" name="nominal[]" placeholder="Nominal">
										  </div>
										  <div class="col-sm-2">
											<select class="form-control" name="dk[]" >
												<option value="">Debit / Kredit</option>
												<option value="D">Debit</option>
												<option value="K">Kredit</option>
											</select>
										  </div>
										  <div class="col-sm-2">
											<input type="checkbox" class="pull-left" name="item_index[]">
										  </div>
										</div>
											<div id="product"></div>
											<script type="text/javascript">
												var idrow = 1;
												function addMore() {
													idrow++;
													$("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right'onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-2'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]'placeholder='Nama Perkiraan'></div><div class='col-sm-1'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
										  
										  	
												}
												
												function deleteRow() {
													$('DIV.product-item').each(function(index, item){
														jQuery(':checkbox', this).each(function () {
															if ($(this).is(':checked')) {
																$(item).remove();
															}
														});
													});
												}
												function openwindow(idrow) {
													var features = "left=200,top=100,menubar=no,location=no,width=700,height=500,scrollbars=yes,resizable=no";
													var popup = window.open("modul/mod_kode_perkiraan/tabel_kode_perkiraan.php?idrow="+idrow,"",features);
												}
												$(function () {
													//Initialize Select2 Elements
													$(".select2").select2();
												});
											</script>
											<DIV class="btn-action float-clear" align="center">
												<input class="btn btn-default" type="button" name="add_item" value="Add More" onClick="addMore();" />
												<input class="btn btn-default" type="button" name="del_item" value="Delete" onClick="deleteRow();" />
												<span class="success"><?php if(isset($message)) { echo $message; }?></span>
											</DIV>
									  </div>
									  <!-- /.box-body -->
									  <div class="box-footer">
										<button type="submit" name="submit" class="btn btn-primary pull-right">Submit</button>
									  </div>
								</div>
							</div>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>