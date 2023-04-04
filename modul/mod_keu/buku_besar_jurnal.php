<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
    $aksi="modul/mod_keu/aksi_bukubesar_jurnal.php";
    $kode_perkiraan=$_GET['kode_perkiraan'];
    $query3=mysql_query("select * from perkiraan where kode_perkiraan='$kode_perkiraan'");
    $hasil3=mysql_fetch_array($query3);
    $nm_perkiraan=$hasil3['nm_perkiraan'];
    switch($_GET[act]){
        // Tampil User
    default:

    ?>
    <title><?=$nm_perkiraan?></title>
        <section class="content-header">
            <h1>Buku Besar</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Buku Besar</li>
            </ol>
        </section>
        <!-- Main content -->
        
        <!-- SELECT2 EXAMPLE -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <h1 class="box-title"><?=$kode_perkiraan?> - <?=$nm_perkiraan?></h1>
                </div>
                <!-- /.box-header -->
                <div class="table-responsive">
                <div class="box-body">
                    <div class="row">
                                    
                        <div class="box-body" style="background:#D7D6D6">
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
                                    <tr>
                                    <!--<td>Nama Account </td>
                                    <td>:</td>
                                    <td>
                                        <span>
                                            <select class="form-control select2" style="width: 100%;" name="kode_perkiraan">
                                            <option value="">Pilihan Account</option>
                                                <?php
                                                    $query=mysql_query("select *, length(p.kode_perkiraan) as jml from perkiraan as p
                                                    join jurnal as j on p.id_perkiraan = j.id_perkiraan group by j.id_perkiraan
                                                    order by kode_perkiraan asc");
                                                    while ($hasil=mysql_fetch_array($query)){
                                                ?>
                                                        <option value="<?=$hasil['kode_perkiraan']?>"><?=$hasil['kode_perkiraan']?> - <?=$hasil['nm_perkiraan']?></option>

                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </span>
                                    </td>-->
                                    </tr>
                                    <tr>
                                        <td><input type="submit" value="Submit"></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                </table>
                            </form>
                        </div>
                        <form name="submit" action="<?=$aksi?>?module=bukubesarjurnal&act=savejurnal" method="POST">
                           <!-- <form name="submit" action="<?=$aksi?>?module=bukubesar&act=savetoexcel" method="post">-->
                            <div class="box-body">
                            
                            <?php
                            $no=1;
                            // Menentukan tanggal awal bulan dan akhir bulan
                            $hari_ini = date("Y-m-d");
                            if (empty($_POST['tgl_aw'])){
                                $tgl_aw= date('Y-m-01', strtotime($hari_ini));
                                $tgl_ak = date('Y-m-t', strtotime($hari_ini));

                            }else{
                                $tgl_aw=$_POST['tgl_aw'];
                                $tgl_ak=$_POST['tgl_ak'];
                                
                            }
                                $tgl1=date('Y-m-d',strtotime($tgl_aw));
                                $tgl2=date('Y-m-d',strtotime($tgl_ak));
                                
                            ?>
                            
                            
                                <h3>Periode : <?=date('d-M-Y',strtotime($tgl_aw))?> s/d <?=date('d-M-Y',strtotime($tgl_ak))?></h3> 
                                <!-- Variable yang di gunakan untuk save ke Excel -->
                                <input type="hidden" name="tgl_aw" value="<?=$tgl1?>">
                                <input type="hidden" name="tgl_ak" value="<?=$tgl2?>">
                                <!--<input type="text" name="kode_perkiraan" value="<?=$kode_perkiraan?>">-->
                                <table class="table table-bordered table-striped">
                                        <thead bgcolor=#A5B4EC>
                                            <tr>
                                                <th>No.</th>
                                                <th>Tanggal</th>
                                                <th>Perkiraan (D)</th>
                                                <th>Perkiraan (K)</th>
                                                <th>Keterangan</th>
                                                <th>No BG dan CEK</th>
                                                <th>Debet</th>
                                                <th>Kredit</th>
                                                <th>Saldo</th>
                                                <!--<th>Aksi</th>-->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>0</td>
                                                <td><?=date('d-M-Y',strtotime($tgl_aw))?></td>
                                                <td></td>
                                                <td></td>
                                                <td>Saldo Awal </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <?php
                                                        //1. Menentukan saldo awal 
                                                        // Menentukan tanggal mulai start sampai tgl sebelum ( tgl_aw )
                                                        $tgl_sld1=date('2017-01-01');
                                                        $tgl_sld2=date('Y-m-d', strtotime('-1 day', strtotime($tgl_aw)));

                                                        //Jika Kode Perkiraan kosong  
                                                        if ($kode_perkiraan==''){
                                                            //Mencari saldo Jumlah Debet dan kredit untuk 
                                                            $query1=mysql_query("SELECT * FROM jurnal as j 
                                                            join perkiraan as p on j.id_perkiraan=p.id_perkiraan
                                                            where tgl between '$tgl_sld1' and '$tgl_sld2' 
                                                            ORDER BY tgl asc");
                                                            while ($hasil1=mysql_fetch_array($query1)){
                                                                if($hasil1['dk']==D){
                                                                    $jmld=$jmld+$hasil1['nominal'];
                                                                }else{
                                                                    $jmlk=$jmlk+$hasil1['nominal'];
                                                                }
                                                            }
                                                        //jika kode perkiraan terisi 	
                                                        }else{
                                                            //Mencari saldo Jumlah Debet dan kredit untuk 
                                                            $query1=mysql_query("SELECT * FROM jurnal as j 
                                                            join perkiraan as p on j.id_perkiraan=p.id_perkiraan
                                                            where tgl between '$tgl_sld1' and '$tgl_sld2' and kode_perkiraan='$kode_perkiraan'
                                                            ORDER BY tgl asc");
                                                            while ($hasil1=mysql_fetch_array($query1)){
                                                                if($hasil1['dk']==D){
                                                                    $jmld=$jmld+$hasil1['nominal'];
                                                                }else if($hasil1['dk']==K){
                                                                    $jmlk=$jmlk+$hasil1['nominal'];
                                                                }
                                                            }
                                                        }
                                                        
                                                        //echo "$tgl_sld1";
                                                        //echo " ke $tgl_sld2 <br>";
                                                        $saldo_aw=$jmld-$jmlk;
                                                    ?>
                                                        <?=number_format($saldo_aw)?>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <?php
                                            if ($kode_perkiraan==''){
                                                $query=mysql_query("SELECT * FROM jurnal as j 
                                                join perkiraan as p on j.id_perkiraan=p.id_perkiraan
                                                where tgl between '$tgl_aw' and '$tgl_ak' 
                                                ORDER BY tgl asc");
                                            }else{
                                                $query=mysql_query("SELECT * FROM jurnal as j 
                                                join perkiraan as p on j.id_perkiraan=p.id_perkiraan
                                                where tgl between '$tgl_aw' and '$tgl_ak' and kode_perkiraan='$kode_perkiraan'
                                                ORDER BY tgl asc");
                                            }
                                                while ($hasil=mysql_fetch_array($query)){
                                                    $query2=mysql_query("select * from perkiraan where id_perkiraan=$hasil[id_perkiraan2]");
                                                    $hasil2=mysql_fetch_array($query2);
                                                    ?>
                                                        <tr>
                                                            <input type="hidden" name="id_jurnal[]" value="<?=$hasil['id_jurnal']?>">
                                                            <td><?=$no?></td>
                                                            <td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
                                                        <?php
                                                        if ($hasil['dk']==D){
                                                        ?>
                                                            <td><?php echo $hasil['kode_perkiraan']." - " .$hasil['nm_perkiraan']; ?></td>
                                                            <td>
                                                            <span>
                                                                <select class="form-control select2" style="width: 100%;" name="id_perkiraan[]">
                                                                <option value=""><?=$hasil2['kode_perkiraan']?> - <?=$hasil2['nm_perkiraan']?></option>
                                                                    <?php
                                                                        $query0=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan 
                                                                        order by kode_perkiraan asc");
                                                                    
                                                                        while ($hasil0=mysql_fetch_array($query0)){
                                                                            if ($hasil0['jml'] == 10){
                                                                    ?>
                                                                            <option value="<?=$hasil0['id_perkiraan']?>"><?=$hasil0['kode_perkiraan']?> - <?=$hasil0['nm_perkiraan']?></option>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </span>
                                                            </td>
                                                            
                                                        <?php       
                                                        }if ($hasil['dk']==K){
                                                        ?>    
                                                            
                                                            <td>
                                                            <span>
                                                                <select class="form-control select2" style="width: 100%;" name="id_perkiraan[]">
                                                                <option value=""><?=$hasil2['kode_perkiraan']?> - <?=$hasil2['nm_perkiraan']?></option>
                                                                    <?php
                                                                        $query0=mysql_query("select *, length(kode_perkiraan) as jml from perkiraan 
                                                                        order by kode_perkiraan asc");
                                                                    
                                                                        while ($hasil0=mysql_fetch_array($query0)){
                                                                            if ($hasil0['jml'] == 10){
                                                                    ?>
                                                                            <option value="<?=$hasil0['id_perkiraan']?>"><?=$hasil0['kode_perkiraan']?> - <?=$hasil0['nm_perkiraan']?></option>
                                                                    <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </span>
                                                            </td>
                                                            <td><?php echo $hasil['kode_perkiraan']." - " .$hasil['nm_perkiraan']; ?></td>
                                                        <?php
                                                        }
                                                        ?>
                                                            <td><?=$hasil['ket']?></td>
                                                            <td><?=$hasil['bgcek']?></td>
                                                            <?php
                                                            if ($hasil['dk']==D){
                                                            ?>
                                                                <td><?=number_format($hasil['nominal'])?></td>
                                                                <td></td>
                                                            <?php
                                                            }if ($hasil['dk']==K){
                                                            ?>
                                                                <td></td>
                                                                <td><?=number_format($hasil['nominal'])?></td>
                                                                
                                                            <?php
                                                            }
                                                            ?>
                                                            <td>
                                                            <?php
                                                                if($hasil['dk']==D){ 
                                                                    $saldo=($saldo+$hasil['nominal']);
                                                                }else{
                                                                    $saldo=($saldo-$hasil['nominal']);	
                                                                }
                                                                
                                                                $saldoak=$saldo+$saldo_aw;
                                                            ?>
                                                            <?=number_format($saldoak)?>
                                                           
                                                        </tr>
                                                    <?php
                                                    $no++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            <div class="text-center">
                                <button type="submit"><i class="fa fa-fw fa-save"></i> Save to Jurnal</button>
                                <!--<button type="submit"><i class="fa fa-fw fa-save"></i> Save to Excel</button>-->
                            </div>
                            </form>
                        </form>
                            
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->

			<div class="box-body">
				<div class="row">
					<!-- /.col -->
					<h3>Periode : <?=date('d-M-Y',strtotime($tgl1))?> s/d <?=date('d-M-Y',strtotime($tgl2))?></h3> 
					<div class="col-md-6">
						<div class="table-responsive">
							<div class="box-body">						
								<table id="myTable2" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>No.</th>
											<th>Tanggal</th>
											<th>No.Jurnal</th>
											<th>Total Nominal</th>
											<th style="min-width:135px;" >Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                            $no=1;
                                            
											$query="SELECT *, sum(nominal) as jml FROM jurnal where tgl between '$tgl_aw' and '$tgl_ak' group by no_jurnal ORDER BY no_jurnal desc";
                                            $qry=mysql_query($query);
                                            
											while ($hasil=mysql_fetch_array($qry)){

                                                

												$query2="SELECT * FROM perkiraan WHERE id_perkiraan='$hasil[id_perkiraan]'";
												$qry2=mysql_query($query2);
												$hasil2=mysql_fetch_array($qry2);
                                                
												
												?>
													<tr>
														<td><?=$no?></td>
														<td><?=date("d M Y", strtotime($hasil['tgl']))?></td>
														<td><?=$hasil['no_jurnal']?></td>
														<td>
                                                            <?php
                                                            
                                                                $query3=mysql_query("select * from jurnal where no_jurnal = '$hasil[no_jurnal]'" );
                                                                $jmlkr=0;
                                                                $jmldb=0;
                                                                $jmlkrdb=0;
                                                                while($hasil3=mysql_fetch_array($query3)){
                                                                
                                                                   if($hasil3['dk']=='K'){
                                                                        $jmlkr=$jmlkr+$hasil3['nominal'];
                                                                        
                                                                    }else{
                                                                        $jmldb=$jmldb+$hasil3['nominal'];
                                                                    } 
                                                                    
                                                                }    
                                                            ?>
                                                            <?=$jmlkr?><br>
                                                            <?=$jmldb?><br>
                                                            <?=number_format($jmldb-$jmlkr)?>
                                                        </td>
														<td align="center">
															<button type="button" class="btn " onclick="window.open('<?php echo "$aksi?module=jurnal&act=editform&id=$hasil[no_ref]";?>','_blank');" ><i class="fa fa-eye"></i></button>
															<a href="?module=jurnal&act=view_jurnal&id=<?=$hasil['no_jurnal']?>"><button type="button" class="btn btn-default"><i class="fa fa-eyes"></i>View</button></a>
														</td>
													</tr>
												<?php
												$no++;
											}
										?>
									</tbody>
								</table>
								<!-- /.tabel 1. -->
							</div>
							<!-- /.box-body -->
                        </div>
                    </div>  
                </div>
			</div>          
    <script>
    $(document).ready(function(){
        $('#myTable').dataTable();
        $('#myTable2').dataTable();
    });
        
    $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
    </script>

    <?php
    break;

    case "tambahbbk":
        $no_jurnal=$_GET['no_jurnal'];
        $tgl=$_GET['tgl'];
        ?>
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
                                <form class="form-horizontal" method="POST" action="<?=$aksi?>?module=bukubesarjurnal&act=input_bg_cek">
                                    <div class="box-body">
                                        <div class="row">
                                        <!-- /.col -->
                                        <div class="col-md-12">	
                                            <!-- form start -->
                                              <div class="box-body">
                                                <div class="form-group">
                                                  <label class="col-sm-1 control-label">Tanggal</label>
                                                  <div class="col-sm-3">
                                                    <input type="date" class="form-control" name="tanggal" placeholder="Input Tanggal...." value="<?=$tgl?>" readonly>
                                                  </div>
                                                </div>
                                                <div class="box-body">
                                                <div class="form-group">
                                                  <label class="col-sm-1 control-label">No. Jurnal</label>
                                                  <div class="col-sm-3">
                                                    <input type="text" class="form-control" name="no_jurnal" placeholder="Nomor Jurnal " value="<?=$no_jurnal?>" readonly >
                                                  </div>
                                                </div>
                                            <?php
                                                if($no_jurnal==''){
                                            ?>
                                              <div class="box-body">
                                                
                                                <div class="product-item form-group">
                                                      
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
                                                            $("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right' onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-2'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]' placeholder='Nama Perkiraan'></div><div class='col-sm-1'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control' name='ket[]' placeholder='Keterangan'></div><div class='col-sm-2'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-2'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-2'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
                                                  
                                                      
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
                                            <?php
                                                }else{
                                            ?>			
                                                <div class="box-body">
                                                <?php
                                                
                                                for ($a = 1; $a <= 2; $a++) {
                                                
                                                    $x=1;
                                                    $query=mysql_query("select * from jurnal as j join perkiraan as p on j.id_perkiraan=p.id_perkiraan where no_jurnal='$no_jurnal'");
                                                    while ($hasil=mysql_fetch_array($query)){
                                                        if($a==1){
                                                    ?>	
                                                            <div class="product-item form-group">  
                                                              <div class="col-sm-1">
                                                                    <button type="button" class="btn btn-danger pull-right" onclick="openwindow(<?=$x?>)"><span class="fa fa-search"></button>
                                                              </div>
                                                              <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="nm_perkiraan<?=$x?>"  name="nm_perkiraan[]" placeholder="Nama Perkiraan" readonly>
                                                              </div>
                                                              <div class="col-sm-3">
                                                              <input type="text" class="form-control" name="no_ref[]" value="BBK-<?=date('Y-m')?>-" placeholder="Referensi">
                                                              </div>
                                                              
                                                              <div class="col-sm-2">
                                                                <input type="text" class="form-control" name="ket[]" value="<?=$hasil[ket]?>" placeholder="Keterangan">
                                                              </div>
                                                              
                                                              <div class="col-sm-1">
                                                                  <input type="text" class="form-control" name="bgcek[]" value="<?=$hasil[no_ref]?>" placeholder="BG dan Cek">
                                                              </div>
                                                              
                                                              <div class="col-sm-1">
                                                                <input type="text" class="form-control" name="nominal[]" value="<?=$hasil[nominal]?>" placeholder="Nominal">
                                                              </div>
                                                              <div class="col-sm-1">
                                                                <select class="form-control" name="dk[]" >
                                                                    <option value="<?=$hasil['dk']?>">
                                                                    <?php
                                                                        if ($hasil['dk']=='D'){
                                                                            echo "Debit";
                                                                        }else{
                                                                            echo "Kredit";
                                                                        }
                                                                    ?>		
                                                                    </option>
                                                                    <option value="D">Debit</option>
                                                                    <option value="K">Kredit</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-sm-2">
                                                                <input type="checkbox" class="pull-left" name="item_index[]">
                                                              </div>
                                                            </div>
                                                            <?php
                                                            $x++ ; 
                                                        }else{ 
                                                            ?>	
                                                            <div class="box" style="background-color: grey;">
                                                            <div class="product-item form-group">  
                                                              <div class="col-sm-1">
                                                                    <button type="button" class="btn btn-danger pull-right" onclick="openwindow(<?=$x?>)"><span class="fa fa-search"></button>
                                                              </div>
                                                              <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="nm_perkiraan<?=$x?>"  name="nm_perkiraan[]" placeholder="Nama Perkiraan" value="<?=$hasil[nm_perkiraan]?>" readonly>
                                                              </div>
                                                              <div class="col-sm-3">
                                                              <input type="text" class="form-control" name="no_ref[]" value="<?=$hasil[no_ref]?>" placeholder="Referensi">
                                                              </div>
                                                              
                                                              <div class="col-sm-2">
                                                                <input type="text" class="form-control" name="ket[]" value="<?=$hasil[ket]?>" placeholder="Keterangan">
                                                              </div>
                                                              
                                                              <div class="col-sm-1"><input type="text" class="form-control" name="bgcek[]" value="" placeholder="BG dan Cek"></div>
                                                              
                                                              <div class="col-sm-1">
                                                                <input type="text" class="form-control" name="nominal[]" value="<?=$hasil[nominal]?>" placeholder="Nominal">
                                                              </div>
                                                              <div class="col-sm-1">
                                                                <select class="form-control" name="dk[]" >
                                                                    <option value="D">
                                                                    <?php
                                                                        if ($hasil['dk']=='D'){
                                                                            echo "Kredit";
                                                                        }else{
                                                                            echo "Debit";
                                                                        }
                                                                    ?>		
                                                                    </option>
                                                                    <option value="D">Debit</option>
                                                                    <option value="K">Kredit</option>
                                                                </select>
                                                              </div>
                                                              <div class="col-sm-2">
                                                                <input type="checkbox" class="pull-left" name="item_index[]">
                                                              </div>
                                                            </div>
                                                            </div>
                                                            
                                                            <?php 
                                                            $x++ ; 		
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                                        
                                                    <div id="product"></div>
                                                    
                                                    <script type="text/javascript">
                                                    var idrow = <?=$x?>;
                                                        function addMore() {
                                                            idrow++;
                                                            $("#product").append("<div class='product-item form-group'><div class='col-sm-1'><button type='button' class='btn btn-danger pull-right'onclick='openwindow("+idrow+")'><span class='fa fa-search'></button></div><div class='col-sm-1'><input type='text' class='form-control' id='nm_perkiraan"+idrow+"' name='nm_perkiraan[]'placeholder='Nama Perkiraan' readonly></div><div class='col-sm-3'><input type='text' class='form-control' name='no_ref[]' placeholder='Referensi'></div><div class='col-sm-2'><input type='text' class='form-control'name='ket[]' placeholder='Keterangan'></div><div class='col-sm-1'><input type='text' class='form-control' name='bgcek[]' placeholder='BG dan Cek'></div><div class='col-sm-1'><input type='text' class='form-control' name='nominal[]' placeholder='Nominal'></div><div class='col-sm-1'><select class='form-control' name='dk[]' id='dk'><option value=''>Debit / Kredit</option><option value='D'>Debit</option><option value='K'>Kredit</option></select></div><div class='col-sm-1'><input type='checkbox' class='pull-left'name='item_index[]'></div></div>");
                                                  
                                                      
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
                                            <?php  	
                                                }
                                            ?>
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
            
        <?php
        break;

	}
}
?>