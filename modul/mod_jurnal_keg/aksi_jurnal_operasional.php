<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";

		$module=$_GET['module'];
		$act=$_GET['act'];
		$id_user=$_SESSION['id_users'];

		// Input user
		if ($module=='jurnal_operasional' AND $act=='tambah_pf_operasional'){
		
		$id_pf=$_POST['id_pf'];
		$stakeholder=$_POST['stakeholder'];
		$status_pf_operasional=$_POST['status_pf_operasional'];
		$tgl_pf_operasional=$_POST['tgl_pf_operasional'];
		$desc1=$_POST['desc1'];
		$desc2=$_POST['desc2'];
		$desc3=$_POST['desc3'];
		
		$query="INSERT INTO pf_operasional (id_pf,stakeholder,user_operasional,tgl_pf_operasional,status_pf_operasional,desc1,desc2,desc3) VALUE ('$id_pf','$stakeholder','$id_user','$tgl_pf_operasional','$status_pf_operasional','$desc1','$desc2','$desc3')";
		$sql= mysql_query ($query) or die (mysql_error());	

			header('location:../../oklogin.php?module='.$module);
		}

		if ($module=='jurnal_operasional' AND $act=='tambah_jurnal_ops'){
			if (isset($_POST['bupload'])){
				$id_user=$_SESSION['id_users'];
				$id_pf=$_POST['id_pf'];
				$id_pf_log=$_POST['id_pf_log'];
				$date_ops=$_POST['date_ops'];
				$type_ops=$_POST['type_ops'];
				$description=$_POST['description'];
				$qty=$_POST['qty'];
				$qty_type1=$_POST['qty_type1'];
				$qty_type2=$_POST['qty_type2'];
				$no_kontainer=$_POST['no_kontainer'];
				$no_seal=$_POST['no_seal'];
				$no_pol=$_POST['no_pol'];
				$nm_driver=$_POST['nm_driver'];
				$contact=$_POST['contact'];
				$nm_bl=$_POST['nm_bl'];
				$nm_aju=$_POST['nm_aju'];
				$stakeholder=$_POST['stakeholder'];
				$type_rev=$_POST['type_rev'];
				$type_allinrate =$_POST['type_allinrate'];
				$status_ops =$_POST['status_ops'];

				$id_jurnal_ops=$_POST['id_jurnal_ops'];
				$queryImage = mysql_query("SELECT * FROM images_db where id_jurnal_ops=$id_jurnal_ops order by id_images_db DESC");
				$hasilImage = mysql_fetch_array($queryImage);
				$idImage = $hasilImage['id_images_db']+1;

				$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg','xlsx','docx');
				$jumlah_file=count($_FILES['nm_file']['name']);

				
				if (!empty($type_allinrate)) {
					$queryOps="INSERT INTO jurnal_ops (user_operasional, id_pf_log, stakeholder, date_ops, status_ops, type_ops, type2_ops, desc_ops, qty, qty_type1, qty_type2) VALUES ('$id_user','$id_pf_log','$stakeholder','$date_ops','$status_ops','$type_ops','$type_allinrate','$description','$qty','$qty_type1','$qty_type2')";
					$sqlOps= mysql_query ($queryOps) or die (mysql_error());
					$opsId = mysql_insert_id();
					if ($type_allinrate =='TRANSPORTATION CHARGES') {
						for($y=0; $y < count($no_kontainer); $y++) { 
							$queryOps="INSERT INTO detail (id_pf_detail, id_jurnal_ops, tgl_detail, no_kontainer, no_seal, nopol, nm_driver, hp_driver, stakeholder) VALUES ('$id_pf','$opsId','$date_ops','$no_kontainer[$y]','$no_seal[$y]','$no_pol[$y]','$nm_driver[$y]','$contact[$y]','$stakeholder')";
							$sqlOps= mysql_query ($queryOps) or die (mysql_error());
						}
					}
				}else {
					$queryOps="INSERT INTO jurnal_ops (user_operasional, id_pf_log, stakeholder, date_ops, status_ops, type_ops, type2_ops, desc_ops, qty, qty_type1, qty_type2) VALUES ('$id_user','$id_pf_log','$stakeholder','$date_ops','$status_ops','$type_ops','$type_allinrate','$description','$qty','$qty_type1','$qty_type2')";
					$sqlOps= mysql_query ($queryOps) or die (mysql_error());
					$opsId = mysql_insert_id();
				}
				
				if ($type_rev =='TRANSPORTATION CHARGES') {
					for($y=0; $y < count($no_kontainer); $y++) { 
						$queryOps="INSERT INTO detail (id_pf_detail, id_jurnal_ops, tgl_detail, no_kontainer, no_seal, nopol, nm_driver, hp_driver, stakeholder) VALUES ('$id_pf','$opsId','$date_ops','$no_kontainer[$y]','$no_seal[$y]','$no_pol[$y]','$nm_driver[$y]','$contact[$y]','$stakeholder')";
						$sqlOps= mysql_query ($queryOps) or die (mysql_error());
					}
				}
				

				for ($i=0; $i < $jumlah_file; $i++) { 
					$nm_file=$_FILES['nm_file']['name'][$i];
					$file_tmp=$_FILES['nm_file']['tmp_name'][$i];
					$x=explode('.',$nm_file);
					$ext=strtolower(end($x));
					$ext2=end($x);
					$size=$_FILES['nm_file']['size'][$i];
					if (in_array($ext,$ext_diperbolehkan)=== true){
						if($size < 10000000){
							$nm_file2 = $idImage . $nm_file;
							move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file2);
	
							$query="INSERT INTO images_db (id_jurnal_ops, nm_file) VALUES ('$opsId','$nm_file2')";
							$sql= mysql_query ($query) or die (mysql_error());
	
						}else{
							echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
						}
					}else{
						echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
					}
				}
				
				//cek nomor bl dan aju
				$queryProforma = mysql_query("SELECT * from pf where id_pf=$_GET[id]");
				$proformaId=mysql_fetch_array($queryProforma);
				$checkBl = $proformaId['bl_number'];
				$checkAju = $proformaId['aju_number'];
				$queryLog = mysql_query("SELECT * from pf_log where id_pf=$_GET[id]");
				$logId=mysql_fetch_array($queryLog);
				$checkLogBl = $logId['bl_number'];
				$checkLogAju = $logId['aju_number'];
				if($nm_bl!= ""){
					//tambah nomer bl dan aju
					mysql_query ("UPDATE pf SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
					mysql_query ("UPDATE pf_log SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
					if($nm_aju!= ""){
						//tambah nomer bl dan aju
						mysql_query ("UPDATE pf SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
						mysql_query ("UPDATE pf_log SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
					}
				}

				header("location:../../oklogin.php?module=$module&act=detail_jurnal&id=$id_pf&id_log=$id_pf_log&ops_id=$opsId");
			}
		}
		if ($module=='jurnal_operasional' AND $act=='edit_jurnal_ops'){
			if (isset($_POST['bupload'])){
				$id_pf=$_POST['id_pf'];
				$id_pf_log=$_POST['id_pf_log'];
				$date_ops=$_POST['date_ops'];
				$type_ops=$_POST['type_ops'];
				$description=$_POST['description'];
				$qty=$_POST['qty'];
				$qty_type1=$_POST['qty_type1'];
				$qty_type2=$_POST['qty_type2'];
				$no_kontainer=$_POST['no_kontainer'];
				$no_seal=$_POST['no_seal'];
				$no_pol=$_POST['no_pol'];
				$nm_driver=$_POST['nm_driver'];
				$contact=$_POST['contact'];
				$nm_bl=$_POST['nm_bl'];
				$nm_aju=$_POST['nm_aju'];
				$stakeholder=$_POST['stakeholder'];

				$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg','xlsx','docx');
				$nm_file=$_FILES['nm_file']['name'];
				$x=explode('.',$nm_file);
				$ext=strtolower(end($x));
				$size=$_FILES['nm_file']['size'];
				$file_tmp=$_FILES['nm_file']['tmp_name'];

				$queryOps="INSERT INTO jurnal_ops (id_pf_log, date_ops, type_ops, desc_ops, qty, qty_type1, qty_type2) VALUES ('$id_pf_log','$date_ops','$type_ops','$description','$qty','$qty_type1','$qty_type2')";
				$sqlOps= mysql_query ($queryOps) or die (mysql_error());
				$opsId = mysql_insert_id();

				for($y=0; $y < count($no_kontainer); $y++) { 
					$queryOps="INSERT INTO detail (id_jurnal_ops, tgl_detail, no_kontainer, no_seal, nopol, nm_driver, hp_driver, stakeholder) VALUES ('$opsId','$date_ops','$no_kontainer[$y]','$no_seal[$y]','$no_pol[$y]','$nm_driver[$y]','$contact[$y]','$stakeholder[$y]')";
					$sqlOps= mysql_query ($queryOps) or die (mysql_error());
				}

				if (in_array($ext,$ext_diperbolehkan)=== true){
					if($size < 10000000){
						move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file);

						$query="INSERT INTO images_db (id_jurnal_ops, nm_file) VALUES ('$opsId', '$nm_file')";
						$sql= mysql_query ($query) or die (mysql_error());

					}else{
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				}else{
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
				
				//cek nomor bl dan aju
				$queryProforma = mysql_query("SELECT * from pf where id_pf=$_GET[id]");
				$proformaId=mysql_fetch_array($queryProforma);
				$checkBl = $proformaId['bl_number'];
				$checkAju = $proformaId['aju_number'];
				$queryLog = mysql_query("SELECT * from pf_log where id_pf=$_GET[id]");
				$logId=mysql_fetch_array($queryLog);
				$checkLogBl = $logId['bl_number'];
				$checkLogAju = $logId['aju_number'];
				if($nm_bl!= ""){
					//tambah nomer bl dan aju
					mysql_query ("UPDATE pf SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
					mysql_query ("UPDATE pf_log SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
				}
				if($nm_aju!= ""){
					//tambah nomer bl dan aju
					mysql_query ("UPDATE pf SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
					mysql_query ("UPDATE pf_log SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
				}

				header("location:../../oklogin.php?module=$module&act=detail_jurnal&id=$id_pf&id_log=$id_pf_log&ops_id=$opsId");
			}
		}
		elseif ($module=='jurnal_operasional' AND $act=='edit_laporan_jurnal'){
			if (isset($_POST['bupload'])){

			}
		}
		//edit detail ops
		elseif ($module=='jurnal_operasional' AND $act=='edit_detail_ops'){
			$id_pf=$_GET['id_pf'];
			$type_rev=$_GET['type_rev'];
			$id_pf_log=$_GET['id_pf_log'];
			$id_jurnal_ops=$_GET['id_jurnal_ops'];
			$type_ops=$_GET['type_ops'];
			$type_ops2=$_GET['type_ops2'];
			$description=$_GET['description'];
			$qty=$_GET['qty'];
			$qty_type1=$_GET['qty_type1'];
			$status_ops=$_GET['status_ops'];
			$qty_type2=$_GET['qty_type2'];
			$stakeholder=$_GET['stakeholder'];
			mysql_query ("UPDATE jurnal_ops SET status_ops='$status_ops',
												type_ops='$type_ops',
												type2_ops='$type_ops2',
					 							stakeholder='$stakeholder',
												desc_ops='$description', 
												qty='$qty', 
												qty_type1='$qty_type1', 
												qty_type2='$qty_type2' 
						WHERE id_jurnal_ops = $id_jurnal_ops ");
			header("location:../../oklogin.php?module=$module&act=jurnal_operasional&act=detail_jurnal&id=$id_pf&id_log=$id_pf_log&ops_id=$id_jurnal_ops&type_rev=$type_rev");
		}
		//edit detail non ops
		elseif ($module=='jurnal_operasional' AND $act=='update_nonops'){			
			$id_jurnal_nops = $_GET['id_jurnal_nops'];
			$description=$_GET['description'];	
			$kegiatan=$_GET['kegiatan'];
			$detail=$_GET['detail'];
			$value=$_GET['value_nops'];
			mysql_query ("UPDATE jurnal_non_ops SET desc_nops='$description', 
												kegiatan='$kegiatan', 
												detail='$detail', 
												value_nops='$value' 
						WHERE id_jurnal_nops = $id_jurnal_nops ");
			header("location:../../oklogin.php?module=$module&act=detail_jurnal_nops&id_jurnal_nops=$id_jurnal_nops");
		}
		//tambah ru
		elseif ($module=='jurnal_operasional' AND $act=='tambah_images'){
			if (isset($_POST['bupload'])){

				$id_pf=$_POST['id_pf'];
				$id_pf_log=$_POST['id_pf_log'];
				$type_ops=$_POST['type_ops'];
				$id_jurnal_ops=$_POST['id_jurnal_ops'];
				$queryImage = mysql_query("SELECT * FROM images_db where id_jurnal_ops=$id_jurnal_ops order by id_images_db DESC");
				$hasilImage = mysql_fetch_array($queryImage);
				$idImage = $hasilImage['id_images_db']+1;

				$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg','xlsx','docx');
				$jumlah_file=count($_FILES['nm_file']['name']);
				
				
				for ($i=0; $i < $jumlah_file; $i++) { 
					$nm_file=$_FILES['nm_file']['name'][$i];
					$file_tmp=$_FILES['nm_file']['tmp_name'][$i];
					$x=explode('.',$nm_file);
					$ext=strtolower(end($x));
					$ext2=end($x);
					$size=$_FILES['nm_file']['size'][$i];
					if (in_array($ext,$ext_diperbolehkan)=== true){
						if($size < 10000000){
							$nm_file2 = $idImage . $nm_file;
							move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file2);
	
							$query="INSERT INTO images_db (id_jurnal_ops, nm_file) VALUES ('$id_jurnal_ops','$nm_file2')";
							$sql= mysql_query ($query) or die (mysql_error());
	
						}else{
							echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
						}
					}else{
						echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
					}
				}
				
				
			}
			
			header("location:../../oklogin.php?module=$module&act=detail_jurnal&id=$id_pf&id_log=$id_pf_log&ops_id=$id_jurnal_ops&type_ops=$type_ops");
		}
		elseif ($module=='jurnal_operasional' AND $act=='tambah_imagesnon'){
			if (isset($_POST['bupload'])){

				$id_pf=$_POST['id_pf'];
				$id_pf_log=$_POST['id_pf_log'];
				$id_jurnal_nops=$_POST['id_jurnal_nops'];
				$queryImage = mysql_query("SELECT * FROM images_db where id_jurnal_nops=$id_jurnal_nops order by id_images_db DESC");
				$hasilImage = mysql_fetch_array($queryImage);
				$idImage = $hasilImage['id_images_db']+1;

				$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg','xlsx','docx');
				$jumlah_file=count($_FILES['nm_file']['name']);
				
				
				for ($i=0; $i < $jumlah_file; $i++) { 
					$nm_file=$_FILES['nm_file']['name'][$i];
					$file_tmp=$_FILES['nm_file']['tmp_name'][$i];
					$x=explode('.',$nm_file);
					$ext=strtolower(end($x));
					$ext2=end($x);
					$size=$_FILES['nm_file']['size'][$i];
					if (in_array($ext,$ext_diperbolehkan)=== true){
						if($size < 10000000){
							$nm_file2 = $idImage . $nm_file;
							move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file2);
	
							$query="INSERT INTO images_db (id_jurnal_nops, nm_file) VALUES ('$id_jurnal_nops','$nm_file2')";
							$sql= mysql_query ($query) or die (mysql_error());
	
						}else{
							echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
						}
					}else{
						echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
					}
				}
				
				
			}
			
			header("location:../../oklogin.php?module=$module&act=detail_jurnal_nops&id_jurnal_nops=$id_jurnal_nops");
		}
		//tambah sor
		elseif ($module=='jurnal_operasional' AND $act=='tambah_detail'){
			$id_pf=$_GET['id_pf'];
			$type_ops=$_GET['type_ops'];
			$id_pf_log=$_GET['id_pf_log'];
			$id_jurnal_ops=$_GET['id_jurnal_ops'];

			$query="INSERT INTO detail (id_pf_detail, id_jurnal_ops, tgl_detail, no_kontainer, no_seal, nopol, nm_driver, hp_driver, stakeholder) VALUES ('$id_pf','$id_jurnal_ops','$_GET[tgl_detail]','$_GET[no_kontainer]','$_GET[no_seal]','$_GET[nopol]','$_GET[nm_driver]','$_GET[hp_driver]','$_GET[stakeholder]')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail_jurnal&id=$id_pf&id_log=$id_pf_log&ops_id=$id_jurnal_ops&type_ops=$type_ops");
		}

		//tambah quantity
		elseif ($module=='jurnal_operasional' AND $act=='tambah_qty'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			// Data pf_Party
			$party_qty=$_GET['party_pf0'];
			$party_type1=$_GET['party_pf1'];
			$party_pf1_desc=$_GET['party_pf1_desc'];
			$party_type2=$_GET['party_pf2'];
			$party_pf2_desc=$_GET['party_pf2_desc'];

			$query="INSERT INTO pf_qty (id_pf_log, qty, type1, type2) VALUES ('$id_pf_log','$party_qty','$party_type1$party_pf1_desc','$party_type2$party_pf2_desc')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}

		//tambah pudel
		elseif ($module=='jurnal_operasional' AND $act=='tambah_pudel'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			// Data pf_pudel
			$pudel_date0=$_GET['pudel_date0'];
			$pudel_party_qty=$_GET['pudel_party_qty'];
			$pudel_party_pf1=$_GET['pudel_party_pf1'];
			$pudel_party_pf1_desc=$_GET['pudel_party_pf1_desc'];
			$pudel_party_pf2=$_GET['pudel_party_pf2'];
			$pudel_party_pf2_desc=$_GET['pudel_party_pf2_desc'];
			$pudel_route_from_pf=$_GET['pudel_route_from_pf'];
			$pudel_route_to_pf=$_GET['pudel_route_to_pf'];

			$query="INSERT INTO pf_pudel (id_pf_log, pudel_date, qty, type1, type2, pudel_from, pudel_to) VALUES ('$id_pf_log','$pudel_date0','$pudel_party_qty','$pudel_party_pf1$pudel_party_pf1_desc','$pudel_party_pf2$pudel_party_pf2_desc','$pudel_route_from_pf','$pudel_route_to_pf')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		//tambah sor
		elseif ($module=='jurnal_operasional' AND $act=='tambah_sor'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$desc_sor=$_GET['desc_sor'];
			$query="INSERT INTO pf_sor (id_pf_log, desc_sor) VALUES ('$id_pf_log','$desc_sor')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		//tambah real customer
		elseif ($module=='jurnal_operasional' AND $act=='tambah_ru'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$name_real_user=$_GET['name_real_user'];
			$address_real_user=$_GET['address_real_user'];
			$reff_cust=$_GET['reff_cust'];
			$code_cust=$_GET['code_cust'];
			$pic=$_GET['pic'];
			$phone_real_user=$_GET['phone_real_user'];

			$query="INSERT INTO real_user (id_pf_log, name_real_user,pic, address_real_user,reff_cust, code_cust, phone_real_user) VALUES ('$id_pf_log','$name_real_user','$pic','$address_real_user','$reff_cust','$code_cust','$phone_real_user')";
			$sql= mysql_query ($query) or die (mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		// Update Qty 
		elseif ($module=='jurnal_operasional' AND $act=='update_qty'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];			
			$qtyQuery = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
			if (mysql_num_rows($qtyQuery) != 0) { 

				$party_qty=$_GET['party_qty'];
				$party_type1=$_GET['party_type0'];
				$party_type2=$_GET['party_type1'];

				$x = 0;
				while($hasilQty = mysql_fetch_array($qtyQuery)) {
					$queryResultQty ="UPDATE pf_qty set qty = '$party_qty[$x]',
											type1 = '$party_type1[$x]',
											type2 = '$party_type2[$x]'
											WHERE id_pf_qty = '$hasilQty[id_pf_qty]'";
					$sqlQty = mysql_query ($queryResultQty) or die (mysql_error());
					$x++;
				}
			}

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		// Update Pudel
		elseif ($module=='jurnal_operasional' AND $act=='update_pudel'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$pudelQuery = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
			if (mysql_num_rows($pudelQuery) != 0) {

				$pudel_date=$_GET['pudel_date0'];
				$pudel_qty=$_GET['pudel_qty'];
				$pudel_type1=$_GET['pudel_type0'];
				$pudel_type2=$_GET['pudel_type1'];
				$pudel_from=$_GET['pudel_from'];
				$pudel_to=$_GET['pudel_to'];

				$y = 0;
				while($hasilPudel = mysql_fetch_array($pudelQuery)) {
					$queryResultPudel ="UPDATE pf_pudel set pudel_date = '$pudel_date[$y]',
											qty = '$pudel_qty[$y]',
											type1 = '$pudel_type1[$y]',
											type2 = '$pudel_type2[$y]',
											pudel_from = '$pudel_from[$y]',
											pudel_to = '$pudel_to[$y]'
											WHERE id_pf_pudel = '$hasilPudel[id_pf_pudel]'";
					$sqlPudel = mysql_query ($queryResultPudel) or die (mysql_error());
					$y++;
				}
			}
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}

		// Update sor
		elseif ($module=='jurnal_operasional' AND $act=='update_sor'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			$pudelQuery = mysql_query("SELECT * from pf_sor where id_pf_log=$id_pf_log");
			if (mysql_num_rows($pudelQuery) != 0) {

				$desc_sor=$_GET['desc_sor'];
				$y = 0;
				while($hasilPudel = mysql_fetch_array($pudelQuery)) {
					$queryResultPudel ="UPDATE pf_sor set desc_sor = '$desc_sor[$y]' WHERE id_pf_sor = '$hasilPudel[id_pf_sor]'";
					$sqlPudel = mysql_query ($queryResultPudel) or die (mysql_error());
					$y++;
				}
			}

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}

		// Update ru
		else if ($module=='jurnal_operasional' AND $act=='update_ru'){
			$id_pf=$_GET['id'];
			$id_pf_log=$_GET['id_pf_log'];
			mysql_query("UPDATE real_user SET name_real_user = '$_GET[name_real_user]',
											  address_real_user= '$_GET[address_real_user]', 
											  reff_cust='$_GET[reff_cust]',
											  code_cust='$_GET[code_cust]',
											  pic= '$_GET[pic]', 
											  phone_real_user= '$_GET[phone_real_user]'
						WHERE id_real_user = $_GET[id]") or die(mysql_error());

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		// Hapus data
		elseif ($module=='jurnal_operasional' AND $act=='delete_jurnal_ops'){
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM jurnal_ops WHERE  id_jurnal_ops = " .$_GET['id']);
			mysql_query("DELETE FROM detail WHERE  id_jurnal_ops = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_qty'){
			$id_pf=$_GET['id_pf'];
			/*$qryQty = mysql_query("SELECT id_pf from pf_log where id_pf_log=$id_pf_log");
			$hasilQty = mysql_fetch_array($qryQty);
			$id_pf2= $hasilQty['id_pf'];
			echo $id_pf2; break;*/
			mysql_query("DELETE FROM pf_qty WHERE  id_pf_qty = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_pudel'){
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM pf_pudel WHERE  id_pf_pudel = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_ru'){
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM real_user WHERE  id_real_user = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_sor'){
			$id_pf=$_GET['id_pf'];
			mysql_query("DELETE FROM pf_sor WHERE  id_pf_sor = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_est_cost'){
			mysql_query("DELETE FROM pf_est_cost WHERE  id_pf_est_cost = " .$_GET['id']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$_GET[id_pf]");
		}
		// tambah revenue operasional
		elseif ($module=='jurnal_operasional' AND $act=='tambah_revenue') {
			$id_pf=$_GET['id_pf'];
			$id_pf_log=$_GET['id'];
			$type_revenue=$_GET['type_revenue'];
			$desc_revenue=$_GET['desc_revenue'];
			$desc_revenue2=$_GET['desc_revenue2'];
			$qty_id=$_GET['qty_id'];
			$rate=$_GET['rate'];			

			for($y=0; $y < count($qty_id); $y++) {
				$queryPfLog="INSERT INTO pf_revenue (id_pf_log, type_revenue, desc_revenue, revenue, qty_revenue) VALUES ('$id_pf_log','$type_revenue','$desc_revenue','$rate[$y]','$qty_id[$y]')";
				$sql= mysql_query ($queryPfLog) or die (mysql_error());
				$rev_id = mysql_insert_id();
				$queryItem="INSERT INTO pf_pudel_qty (id_pf_revenue, from_pudel, to_pudel, qty, type1, type2, rate) VALUES ('$rev_id','','','$qty_id[$y]','','','$rate[$y]')";
				$sqlItem= mysql_query ($queryItem) or die (mysql_error());
				
			}

			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		//edit revenue
		elseif ($module=='jurnal_operasional' AND $act=='edit_revenue'){
			$id_pf=$_GET['id_pf'];
			$id_pf_log=$_GET['id'];
			$id_pf_revenue =$_GET['id_pf_revenue'];			
			$type_revenue=$_GET['type_revenue'];
			$desc_revenue=$_GET['desc_revenue'];
			$desc_revenue2=$_GET['desc_revenue2'];
			$qty_revenue=$_GET['qty_revenue'];
			$rate=$_GET['rate'];
			
			mysql_query("UPDATE pf_revenue SET type_revenue = '$type_revenue',
													desc_revenue = '$desc_revenue$desc_revenue2',
													revenue = '$rate',
													qty_revenue = '$qty_revenue'
	  					WHERE id_pf_revenue = $_GET[id_pf_revenue]");			
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		//hapus revenue
		elseif ($module=='jurnal_operasional' AND $act=='delete_revenue'){
			$id_pf= $_GET['id'];
			mysql_query("DELETE FROM pf_revenue WHERE  id_pf_revenue = " .$_GET['id_rev']);
			mysql_query("DELETE FROM pf_pudel_qty WHERE  id_pf_revenue = " .$_GET['id_rev']);
			header("location:../../oklogin.php?module=$module&act=detail&id=$id_pf");
		}
		// tambah jurnal non operasional
		elseif ($module=='jurnal_operasional' AND $act=='tambah_jurnal_nops') {
			$date_nops=$_POST['date_nops'];
			$desc_nops=$_POST['desc_nops'];
			$kegiatan=$_POST['kegiatan'];
			$detail=$_POST['detail'];
			$value_nops=$_POST['value_nops'];

			$ext_diperbolehkan=array('jpg','png','pdf','bmp','jpeg','xlsx','docx', 'svg');

			for($y=0; $y < count($date_nops); $y++) {
				$queryPfLog="INSERT INTO jurnal_non_ops (date_nops, desc_nops, kegiatan, detail, value_nops) VALUES ('$date_nops[$y]','$desc_nops[$y]','$kegiatan[$y]','$detail[$y]','$value_nops[$y]')";
				$sql= mysql_query ($queryPfLog) or die (mysql_error());
				$nopsId = mysql_insert_id();

				$file_img=$_FILES['nm_file'.$y];
				
				for($x=0; $x < count($file_img['name']); $x++) {
					$nm_file=$file_img['name'][$x];
					$ex=explode('.',$nm_file);
					$ext=strtolower(end($ex));
					$size=$file_img['size'][$x];
					$file_tmp=$file_img['tmp_name'][$x];

					//echo "<script>console.log('Debug Objects: " . json_encode($nm_file) . "' );</script>";

					if (in_array($ext,$ext_diperbolehkan)=== true) {
						if($size < 10000000){
							move_uploaded_file($file_tmp, '../../images/data_op/'.$nm_file);
	
							$query="INSERT INTO images_db (id_jurnal_nops, nm_file) VALUES ('$nopsId', '$nm_file')";
							$sql= mysql_query ($query) or die (mysql_error());
	
						}else{
							echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
						}
					} else{
						echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
					}
				}
			}
			
			header("location:../../oklogin.php?module=$module&act=jurnal_operasional");
		}

		// edit status
		elseif ($module=='jurnal_operasional' AND $act=='update_status') {
			/*if($nm_bl!= ""){
				//tambah nomer bl dan aju
				mysql_query ("UPDATE pf SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
				mysql_query ("UPDATE pf_log SET bl_number='$nm_bl' WHERE id_pf = $id_pf ");
				if($nm_aju!= ""){
					//tambah nomer bl dan aju
					mysql_query ("UPDATE pf SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
					mysql_query ("UPDATE pf_log SET aju_number='$nm_aju' WHERE id_pf = $id_pf ");
				}
			}*/

			mysql_query("UPDATE pf_log SET bl_number = '$_GET[bl_number]',
										   aju_number = '$_GET[aju_number]',
										   status_ops = '$_GET[status_ops]'
						 WHERE id_pf_log = $_GET[id_pf_log]");

			header("location:../../oklogin.php?module=$module&act=detail&id=$_GET[id]");
		}

		//tambah revenue
		elseif ($module=='jurnal_keu' AND $act=='tambah_revenue'){
			$id_pf=$_GET['id'];
			$type_revenue=$_GET['type_revenue'];
			$type2_revenue=$_GET['type2_revenue'];
			$desc_revenue=$_GET['desc_revenue'];
			$revenue=$_GET['revenue'];
			$qty_revenue=$_GET['qty_revenue'];
		
			$query="INSERT INTO pf_revenue (id_pf, type_revenue, type2_revenue, desc_revenue, revenue, qty_revenue ) VALUES ('$id_pf','$type_revenue','$type2_revenue','$desc_revenue','$revenue','$qty_revenue')";
			$sql= mysql_query ($query) or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}
		// tambah est_cost
		elseif ($module=='jurnal_keu' AND $act=='tambah_est_cost'){
			$id_pf=$_GET['id'];
			$type_est_cost=$_GET['type_est_cost'];
			$desc_est_cost=$_GET['desc_est_cost'];
			$est_cost=$_GET['est_cost'];
			$qty_est_cost=$_GET['qty_est_cost'];
		
			$query="INSERT INTO pf_est_cost (id_pf, type_est_cost, desc_est_cost, est_cost, qty_est_cost ) VALUES ('$id_pf','$type_est_cost','$desc_est_cost','$est_cost','$qty_est_cost')";
			$sql= mysql_query ($query) or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		// Update ru
		elseif ($module=='jurnal_operasional' AND $act=='update_pf_operasional'){
		
			mysql_query("UPDATE pf_operasional SET tgl_pf_operasional = '$_GET[tgl_pf_operasional]',
											  	   stakeholder= '$_GET[stakeholder]', 
											       status_pf_operasional= '$_GET[status_pf_operasional]',
												   desc1= '$_GET[desc1]',
												   desc2= '$_GET[desc2]',
												   desc3= '$_GET[desc3]'
						WHERE id_pf_operasional = $_GET[id]");

			header('location:../../oklogin.php?module='.$module);
		}
		// Update jurnal_keu
		elseif ($module=='jurnal_keu' AND $act=='update_jurnal_keu'){
		
			mysql_query("UPDATE pf SET no_pf = '$_GET[no_pf]',
									   tgl_pf = '$_GET[tgl_pf]',
									   cust_name = '$_GET[cust_name]',
									   address_pf = '$_GET[address_pf]',
									   cust_ref = '$_GET[cust_ref]',
									   cust_code = '$_GET[cust_code]',
									   pic = '$_GET[pic]',
									   shipment = '$_GET[shipment]',
									   qty_pf = '$_GET[qty_pf]',
									   route_pf = '$_GET[route_pf]',
									   pudel_date = '$_GET[pudel_date]',
									   pudel_location = '$_GET[pudel_location]',
									   sales = '$_GET[sales]',
									   ct = '$_GET[ct]',
									   sf = '$_GET[sf]',
									   vv = '$_GET[vv]',
									   etb_etd = '$_GET[etb_etd]',
									   openstack = '$_GET[openstack]',
									   ctc = '$_GET[ctc]',
									   ctd = '$_GET[ctd]',
									   bl_number = '$_GET[bl_number]'
						WHERE id_pf = $_GET[id]") 	or die(mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}
		// Update sor
		elseif ($module=='jurnal_operasional' AND $act=='update_detail'){
		
			mysql_query("UPDATE detail SET tgl_detail = '$_GET[tgl_detail]',
										   no_kontainer = '$_GET[no_kontainer]', 
										   no_seal = '$_GET[no_seal]', 
										   nopol = '$_GET[nopol]', 
										   nm_driver = '$_GET[nm_driver]', 
										   hp_driver = '$_GET[hp_driver]', 
										   stakeholder = '$_GET[stakeholder]' 
			
			WHERE id_detail = $_GET[id]");

			header('location:../../oklogin.php?module='.$module.'&act=detail_jurnal&id='.$_GET['id_pf'].'&id_log='.$_GET['id_pf_log'].'&ops_id='.$_GET['id_pf_operasional'].'&type_ops='.$_GET['type_ops']);
		}
		//Update Revenue
		elseif ($module=='jurnal_keu' AND $act=='update_revenue'){
		
			mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]' 
									   
						WHERE id_pf_revenue = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		//Update est_cost
		elseif ($module=='jurnal_keu' AND $act=='update_est_cost'){
		
			mysql_query("UPDATE pf_est_cost SET type_est_cost = '$_GET[type_est_cost]',
									   desc_est_cost = '$_GET[desc_est_cost]',
									   est_cost = '$_GET[est_cost]',
									   qty_est_cost= '$_GET[qty_est_cost]' 
									   
						WHERE id_pf_est_cost = $_GET[id]") or die (mysql_error());

			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus data
		elseif ($module=='jurnal_operasional' AND $act=='hapus_gambar'){
			mysql_query("DELETE FROM images_db WHERE  id_images_db = " .$_GET['id']);
			//Menghapus file gambar
			$gambar=$_GET["gambar"];
			//unlink("../../images/data_op/".$gambar);
			header('location:../../oklogin.php?module='.$module.'&act=detail_jurnal&id='.$_GET['id_pf'].'&id_log='.$_GET['id_log'].'&ops_id='.$_GET['ops_id'].'&type_ops='.$_GET['type_ops']);
		}
		elseif ($module=='jurnal_operasional' AND $act=='hapus_gambarnon'){
			mysql_query("DELETE FROM images_db WHERE  id_images_db = " .$_GET['id']);
			//Menghapus file gambar
			$gambar=$_GET["gambar"];
			$id_jurnal_nops = $_GET['id_jurnal_nops'];
			//unlink("../../images/data_op/".$gambar);
			header("location:../../oklogin.php?module=$module&act=detail_jurnal_nops&id_jurnal_nops=$id_jurnal_nops");
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_pf_operasional'){
			mysql_query("DELETE FROM pf_operasional WHERE  id_pf_operasional = " .$_GET['id']);
			
			/*$ops=mysql_query("select * from pf_operasional");
			while($hsl_ops=mysql_fetch_array($ops)){
			    $id_pf_operasional=$hsl_ops['id_pf_operasional'];
			    $id_pf=$hsl_ops['id_pf'];
			    
			    mysql_query("UPDATE detail SET id_pf_detail='$id_pf' where id_pf_operasional=$id_pf_operasional");
			    
			}*/
			
			header('location:../../oklogin.php?module='.$module);
		}
		elseif ($module=='jurnal_operasional' AND $act=='delete_detail'){
			
			mysql_query("DELETE FROM detail WHERE  id_detail = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module.'&act=detail_jurnal&id='.$_GET['id_pf'].'&id_log='.$_GET['id_log'].'&ops_id='.$_GET['ops_id'].'&type_rev='.$_GET['type_rev']);
		}
		elseif ($module=='jurnal_keu' AND $act=='delete_est_cost'){
			mysql_query("DELETE FROM pf_est_cost WHERE  id_pf_est_cost = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}

		//Save to Excel
		elseif ($module=='jurnal_keu' AND $act=='excel'){
			//Start
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=jurnal_keu($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		
			$id_pf=$_GET['id'];
			$query=mysql_query("select * from pf_log where id_pf='$id_pf'");
			$hasil=mysql_fetch_array($query);

		?>
			
			<body>
				<table class="table">
				    <tbody>
						<tr>
							<td colspan="2">NUMBER</td>
							<td colspan="2"><?=$hasil['no_pf']?></td>
							<td colspan="2">CUSTOMER REF</td>
							<td colspan="2"><?=$hasil['cust_ref']?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2" align="left"><?=$hasil['tgl_pf']?></td>
							<td colspan="2">CUSTOMER CODE</td>
							<td colspan="2"><?=$hasil['cust_code']?></td>
						</tr>
						<tr>
							<td colspan="2">CUSTOMER NAME</td>
							<td colspan="2"><?=$hasil['cust_name']?></td>
							<td colspan="2">PIC</td>
							<td colspan="2"><?=$hasil['pic']?></td>
						</tr>
						<tr>
							<td colspan="2">ADDRESS</td>
							<td colspan="2"><?=$hasil['address_pf']?></td>
							<td colspan="2">PHONE</td>
							<td colspan="2" align="left"><?=$hasil['phone']?></td>
						</tr>
						<tr>
							<td colspan="2">SHIPMENT</td>
							<td colspan="2"><?=$hasil['shipment']?></td>
							<td colspan="2">SHIPING/FORWARDING</td>
							<td colspan="2"><?=$hasil['sf']?></td>
						</tr>
						<tr>
							<td colspan="2">QUANTITY</td>
							<td colspan="2" align="left"><?=$hasil['qty_pf']?></td>
							<td colspan="2">VESEL/VOYAGE</td>
							<td colspan="2"><?=$hasil['vv']?></td>
						</tr>
						<tr>
							<td colspan="2">ROUTE</td>
							<td colspan="2"><?=$hasil['route_pf']?></td>
							<td colspan="2">ETB/ETD</td>
							<td colspan="2"><?=$hasil['etb_etd']?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL DATE</td>
							<td colspan="2" align="left"><?=$hasil['pudel_date']?></td>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2" align="left"><?=$hasil['openstack']?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL LOCATION</td>
							<td colspan="2"><?=$hasil['pudel_location']?></td>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2" align="left"><?=$hasil['ctc']?></td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td colspan="2"></td>
							<td colspan="2">CLOSING TIME DOCUMent</td>
							<td colspan="2" align="left"><?=$hasil['ctd']?></td>
						</tr>
						<tr>
							<td colspan="2">CREDIT TERM</td>
							<td colspan="2" align="left"><?=$hasil['ct']?></td>
							<td colspan="2">SALES</td>
							<td colspan="2"><?=$hasil['sales']?></td>
						</tr>	
						<tr>
							<td colspan="2">SPECIAL ORDER REQUEST</td>
						</tr>
						<?php
						$no=1;
							$query1=mysql_query("select * from pf_sor where id_pf_log='$id_pf_log'");
							while ($hasil1=mysql_fetch_array($query1)){
						?>
						<tr>
							<td></td>
							<td><?=$no?>. <?=$hasil1['desc_sor']?></td>
						</tr>
							<?php $no++; } ?>
					</tbody>
				</table>	
				<br>
				<h5>REAL CUSTOMER</h5>
				<table>
					<tr>
						<th>NO</th>
						<th>REAL CUSTOMER NAME</th>
						<th>ADDRESS</th>
						<th>PHONE>
					</tr>
					<?php
					$no_ru=1;
					$query_ru=mysql_query("select * from real_user where id_pf_log='$id_pf_log'");
					while($hasil_ru=mysql_fetch_array($query_ru)){
					?>
					<tr>
						<td><?=$no_ru?></td>
						<td><?=$hasil_ru['name_real_user']?></td>
						<td><?=$hasil_ru['address_real_user']?></td>
						<td><?=$hasil_ru['phone_real_user']?></td>
					</tr>
					<?php $no_ru++; } ?>
				</table>
				
				<table>
					<tr>
						<th><h5>TABEL REVENUE</h5></th>
					</tr>
					<tr>
						<th><h5>ALL IN RATE</h5></th>
					</tr>
					<tr>
						<th>NO</th>
						<th>DESCRIPTION</th>
						<th>REVENUE</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					<tbody style="border: thick;">
						<?php
							$no_rev=1;
							$total_revenue=0;
							$query2=mysql_query("select * from pf_revenue where id_pf_log='$id_pf_log' and type_revenue='ALL IN RATE'");
							while($hasil2=mysql_fetch_array($query2)){
							$total_revenue=$total_revenue+($hasil2['revenue']*$hasil2['qty_revenue']);
						?>
						<tr>
							<td><?=$no_rev?></td>
							<td><?=$hasil2['desc_revenue']?></td>
							<td><?=$hasil2['revenue']?></td>
							<td><?=$hasil2['qty_revenue']?></td>
							<td><?=$hasil2['revenue']*$hasil2['qty_revenue']?></td>
						</tr>
						<?php $no_rev++; } ?>
					</tbody>
				</table>
				</p>
				<th><h5>TABLE EST COST</h5></th>
				<table>
					<tr>
						<th>NO</th>
						<th>TYPE</th>
						<th>DESCRIPTION</th>
						<th>EST COST</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					</tr>
					<?php
						$no_est_cost=1;
						$total_est_cost=0;
						$query3=mysql_query("select * from pf_est_cost where id_pf_log='$id_pf_log'");
						while($hasil3=mysql_fetch_array($query3)){
						$total_est_cost=$total_est_cost+($hasil3['est_cost']*$hasil3['qty_est_cost']);
					?>
					<tr>
						<td><?=$no_est_cost?></td>
						<td><?=$hasil3['type_est_cost']?></td>
						<td><?=$hasil3['desc_est_cost']?></td>
						<td><?=$hasil3['est_cost']?></td>
						<td><?=$hasil3['qty_est_cost']?></td>
						<td><?=$hasil3['est_cost']*$hasil3['qty_est_cost']?></td>
					</tr>	
					<?php $no_est_cost++; } ?>			
				</table>

				<h5>TABEL P/L EST COST</h5>
				<table>
					<tr>
						<td>1</td>
						<td colspan="2">REVENUE</td>
						<td><?=$total_revenue?></td>
					</tr>
					<tr>
						<td>2</td>
						<td colspan="2">EST COST</td>
						<td><?=$total_est_cost?></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">PROFIT AND LOST EST COST</td>
						<td align='right'><?=$total_revenue-$total_est_cost?></td>
					</tr>
								
				</table>
			</body>
			<?php
		}
		//Save to Excel
		elseif ($module=='jurnal_operasional' AND $act=='excel'){
			//Start
			$date=date('ymd');
		
			header("Content-type: application/vnd-ms-excel");
			header("Content-Disposition: attachment; filename=Proforma($date).xls");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false);
			header("Cache-Control: max-age=0");
		
			$id_pf=$_GET['id'];
			$query=mysql_query("select * from pf_log where id_pf='$id_pf'");
			$hasil=mysql_fetch_array($query);
			$id_pf_log = $hasil['id_pf_log'];

		?>
			
			<body>
			    <lable><h3>NOMOR JO : <?=$hasil['no_jo']?></h3></lable>
				<table class="table" border='1'>
				    <tbody>
						<tr>
							<td colspan="2">NUMBER</td>
							<td colspan="2"><?=$hasil['no_pf']?></td>
							<td colspan="2">CUSTOMER REF</td>
							<td colspan="2"><?=$hasil['cust_ref']?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2" align="left"><?= date("d M y h:i:s", strtotime($hasil['tgl_pf'])) ?></td>
							<td colspan="2">CUSTOMER CODE</td>
							<td colspan="2"><?=$hasil['cust_code']?></td>
						</tr>
						<tr>
							<td colspan="2">CUSTOMER NAME</td>
							<td colspan="2"><?=$hasil['cust_name']?></td>
							<td colspan="2">PIC</td>
							<td colspan="2"><?=$hasil['pic']?></td>
						</tr>
						<tr>
							<td colspan="2">ADDRESS</td>
							<td colspan="2"><?=$hasil['address_pf']?></td>
							<td colspan="2">PHONE</td>
							<td colspan="2" align="left"><?=$hasil['phone']?></td>
						</tr>
						<tr>
							<td colspan="2">SHIPMENT</td>
							<td colspan="2"><?=$hasil['shipment']?></td>
							<td colspan="2">SHIPING/FORWARDING</td>
							<td colspan="2"><?=$hasil['sf']?></td>
						</tr>
						<tr>
							<td colspan="2">QUANTITY</td>
							<td colspan="2" align="top" align="left">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log='$id_pf_log'");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?><br>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td colspan="2">VESEL/VOYAGE</td>
							<td colspan="2"><?=$hasil['vv']?></td>
						</tr>
						<tr>
							<td colspan="2">ROUTE</td>
							<td colspan="2"><?=$hasil['route_pf']?></td>
							<td colspan="2">ETB/ETD</td>
							<td colspan="2"><?= date("d M y", strtotime($hasil['etb'])) ?>/<?= date("d M y", strtotime($hasil['etd'])) ?></td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log='$id_pf_log'");
							if (mysql_num_rows($query3) == 0) { ?>
						<tr>
							<td colspan="2">PU/DEL DATE</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?></td>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
						</tr>
						<tr>
							<td colspan="2">PU/DEL LOCATION</td>
							<td colspan="2"><?=$hasil['pudel_location']?></td>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['ctc'])) ?></td>
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
						</tr>
						<tr>
							<td colspan="2">DATE</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasilPudel['pudel_date'])) ?></td>
							<?php if($num == 1) { ?>
							<td colspan="2">OPEN STACK</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="2">QUANTITY</td>
							<td colspan="2"><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
							<?php if($num == 1) { ?>
							<td colspan="2">CLOSING TIME CONTAINER</td>
							<td colspan="2"><?=date("d M y h:i:s", strtotime($hasil['ctc'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td colspan="2">FROM</td>
							<td colspan="2"><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td colspan="2">TO</td>
							<td colspan="2"><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							}
						} ?>
						<tr>
							<td colspan="2"></td>
							<td colspan="2"></td>
							<td colspan="2">CLOSING TIME DOCUMent</td>
							<td colspan="2" align="left"><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
						</tr>
						<tr>
							<td colspan="2">CREDIT TERM</td>
							<td colspan="2" align="left"><?=$hasil['ct']?></td>
							<td colspan="2">SALES</td>
							<td colspan="2"><?=$hasil['sales']?></td>
						</tr>	
						<tr>
							<td colspan="2">SPECIAL ORDER REQUEST</td>
						</tr>
						<?php
						$no=1;
							$query1=mysql_query("select * from pf_sor where id_pf_log='$id_pf_log'");
							while ($hasil1=mysql_fetch_array($query1)){
						?>
						<tr>
							<td></td>
							<td><?=$no?>. <?=$hasil1['desc_sor']?></td>
						</tr>
							<?php $no++; } ?>
					</tbody>
				</table>	
				
				
				<table border='1'>
					<tr>
						<th><h5>TABEL REVENUE</h5></th>
					</tr>
					<tr>
						<th>NO</th>
						<th>DESCRIPTION</th>
						<th>REVENUE</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					<tbody style="border: thick;">
						<?php
							$no_rev=1;
							$total_revenue=0;
							$query2=mysql_query("select * from pf_revenue where id_pf_log='$id_pf_log'");
							while($hasil2=mysql_fetch_array($query2)){
							$total_revenue=$total_revenue+($hasil2['revenue']*$hasil2['qty_revenue']);
						?>
						<tr>
							<td><?=$no_rev?></td>
							<td><?=$hasil2['desc_revenue']?></td>
							<td><?=$hasil2['revenue']?></td>
							<td><?=$hasil2['qty_revenue']?></td>
							<td><?=$hasil2['revenue']*$hasil2['qty_revenue']?></td>
						</tr>
						<?php $no_rev++; } ?>
					</tbody>
				</table>
				</p>
				<th><h5>TABLE EST COST</h5></th>
				<table border='1'>
					<tr>
						<th>NO</th>
						<th>TYPE</th>
						<th>DESCRIPTION</th>
						<th>EST COST</th>
						<th>QTY</th>
						<th>SUM</th>
					</tr>
					</tr>
					<?php
						$no_est_cost=1;
						$total_est_cost=0;
						$query3=mysql_query("select * from pf_est_cost where id_pf_log='$id_pf_log'");
						while($hasil3=mysql_fetch_array($query3)){
						$total_est_cost=$total_est_cost+($hasil3['est_cost']*$hasil3['qty_est_cost']);
					?>
					<tr>
						<td><?=$no_est_cost?></td>
						<td><?=$hasil3['type_est_cost']?></td>
						<td><?=$hasil3['desc_est_cost']?></td>
						<td><?=$hasil3['est_cost']?></td>
						<td><?=$hasil3['qty_est_cost']?></td>
						<td><?=$hasil3['est_cost']*$hasil3['qty_est_cost']?></td>
					</tr>	
					<?php $no_est_cost++; } ?>			
				</table>

				<h5>TABEL P/L EST COST</h5>
				<table>
					<tr>
						<td>1</td>
						<td colspan="2">REVENUE</td>
						<td><?=$total_revenue?></td>
					</tr>
					<tr>
						<td>2</td>
						<td colspan="2">EST COST</td>
						<td><?=$total_est_cost?></td>
					</tr>
					<tr>
						<td></td>
						<td colspan="2">PROFIT AND LOST EST COST</td>
						<td align='right'><?=$total_revenue-$total_est_cost?></td>
					</tr>
								
				</table>
			</body>
			<?php
		}
		//Print 
		elseif ($module=='jurnal_operasional' AND $act=='print'){
			$id_pf=$_GET['id'];			
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="../../style.css">
			<title>Print Approved Proforma</title>
		</head>
		<body>
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
			<!-- Content Page -->
			<section class="content-header">
				<?php
				$no = 1;
				$query = mysql_query("SELECT * FROM pf_log where id_pf='$id_pf'");
				$hasil = mysql_fetch_array($query);
				$id_pf_log = $hasil['id_pf_log'];
				?>	
				<table class="table">
					<tr>
						<td><h1 class="nomargin-bottom">JOB ORDER NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nomargin-bottom">:</h1></td>
						<td><h1 class="nomargin-bottom"><?=$hasil['no_jo']?></h1></td>
					</tr>
					<tr>
						<td><h1 class="nopadding">B/L NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nopadding">:</h1></td>
						<td><h1 class="nopadding"><?=$hasil['bl_number']?></h1></td>
					</tr>
					<tr>
						<td><h1 class="nomargin-top">AJU NUMBER</h1></td>
						<td style="width: 3%;"><h1 class="nomargin-top">:</h1></td>
						<td><h1 class="nomargin-top" ><?=$hasil['aju_number']?></h1></td>
					</tr>
				</table>
				<!-- Main content -->
					<table class="table">
						<tr>
							<td style="width: 20%;">NUMBER</td>
							<td style="width: 2%;">:</td>
							<td style="width: 30%;"><?= $hasil['no_pf'] ?></td>
							<td style="width: 3%;"></td>
							<td style="width: 23%;">CUSTOMER REFF</td>
							<td style="width: 2%;">:</td>
							<td style="width: 20%;"><?= $hasil['cust_ref'] ?></td>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?= date("d M y", strtotime($hasil['tgl_pf']))  ?></td>
							<td></td>
							<td>CUSTOMER CODE</td>
							<td>:</td>
							<td><?= $hasil['cust_code'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">CUSTOMER NAME</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['cust_name'] ?></td>
							<td></td>
							<td>PIC</td> 
							<td>:</td>
							<td><?= $hasil['pic'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">ADDRESS</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['address_pf'] ?></td>
							<td></td>
							<td style="vertical-align:top">PHONE</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['phone'] ?></td>
						</tr>
						<?php
						if ($hasil['shipment']!="HANDLING EMKL IMPORT" && $hasil['shipment']!="EMKL IMPORT") { 
						?>
						<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td class="align-start">QUANTITY</td>
							<td class="align-start">:</td>
							<td class="align-start">
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$num ?>. <?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td></td>
							<td class="align-start">VESSEL/VOYAGE</td>
							<td class="align-start">:</td>
							<td class="align-start"><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td class="align-start">ETB/ETD</td>
							<td class="align-start">:</td>
							<td><?= date("d M y", strtotime($hasil['etb'])) ?> / <?= date("d M y", strtotime($hasil['etd']))  ?> </td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
							if (mysql_num_rows($query3)==0) { ?>
						<tr>
							<td>PU/DEL DATE</td>	
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
						</tr>
						<tr>
							<td class="align-start">PU/DEL LOCATION</td>	
							<td class="align-start">:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctc']))  ?></td>
						</tr>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td></td>
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?=date("d M y h:i:s", strtotime($hasil['openstack'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_date']?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctc']))  ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
							<?php if ($num == 1) { ?>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['ctd'])) ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>FROM</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td>TO</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							} ?>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
						</tr>
						<?php }
					} else { ?>
							<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td class="align-start">QUANTITY</td>
							<td class="align-start">:</td>
							<td>
							<?php					
								$query3 = mysql_query("SELECT * from pf_qty where id_pf_log=$id_pf_log");
								if (mysql_num_rows($query3)==0) { ?>
									<?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?>
								<?php 	
								} else {
									$num = 1;
									while ($hasilQty = mysql_fetch_array($query3)) { ?>
										<p class="nopadding"><?=$hasilQty['qty']?>X<?=$hasilQty['type1']?><?=$hasilQty['type2']?></p>
									<?php
									$num++;
									}
								} 
							?>
							</td>
							<td></td>
							<td>VESSEL/VOYAGE</td>
							<td>:</td>
							<td><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td>ETB/ETD</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['etb']))  ?>/<?=date("d M y h:i:s", strtotime($hasil['etd'])) ?></td>
						</tr>
						<?php					
							$query3 = mysql_query("SELECT * from pf_pudel where id_pf_log=$id_pf_log");
							if (mysql_num_rows($query3)==0) { ?>
						<tr>
							<td>PU/DEL DATE</td>	
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['pudel_date'])) ?>  </td>		
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>	
							<td>:</td>
							<td>
								<?= $hasil['pudel_location'] ?>
							</td>		
						</tr>
						<?php 	
						} else {
							$num = 1;
							while ($hasilPudel = mysql_fetch_array($query3)) { ?>
						<tr>
							<td>PICK UP DELIVERY #<?=$num ?></td>
							<?php if($num == 1) {?>
							<td>:</td>
							<td></td>
							<td></td>
							<td>B/L NUMBER</td>
							<td>:</td>
							<td><?= $hasil['bl_number'] ?></td>
							<?php } ?>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_date']?></td>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?=$hasilPudel['qty']?>X<?=$hasilPudel['type1']?><?=$hasilPudel['type2']?></td>
						</tr>
						<tr>
							<td>FROM</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_from']?></td>
						</tr>
						<tr>
							<td>TO</td>
							<td>:</td>
							<td><?=$hasilPudel['pudel_to']?></td>
						</tr>
						<?php
							$num++;
							}
						} ?>
						<?php } ?>	
						<tr>
							<td>SALES</td>
							<td>:</td>
							<td><?= $hasil['sales'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td><br></td>
						</tr>
						<tr>
							<td colspan="3">SPECIAL ORDER REQUEST :</td>
						</tr>
						<?php
							$no_sor=1;
							$query1 = mysql_query("select * from pf_sor where id_pf_log=$id_pf_log");
							while ($hasil1=mysql_fetch_array($query1)){
								$id_pf_sor=$hasil1['id_pf_sor'];
						?>
						<tr>
							<td><?=$no_sor?>. <?=$hasil1['desc_sor']?></td>
						</tr>
						<?php $no_sor++; }?>
					</table>

					<br>					
					<?php
						$type1=mysql_query("select * from pf_revenue where id_pf_log=$id_pf_log");
						$hasil_type1=mysql_fetch_array($type1);
					?>
					<a>DETAIL ORDER :</a> 
					<table>
						<?php
						$no_job2=1;	
						$sum_est_cost=0;
						$total_est_cost=0;						
						$query3 = mysql_query("select distinct type_est_cost from pf_est_cost where id_pf_log=$id_pf_log order by type_est_cost asc");
						while ($hasil3 = mysql_fetch_array($query3)) { 
							$type_est_cost=$hasil3['type_est_cost'];
						?>
						<tr>
							<td style="vertical-align:top"> <?=$no_job2?>. <?=$type_est_cost?></td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top">
								<?php
									$no_job3=1;
									$query4=mysql_query("select * from pf_est_cost where id_pf_log=$id_pf_log and type_est_cost='$type_est_cost' order by type_est_cost asc");
									while($hasil4=mysql_fetch_array($query4)){
								?>
								<?=$no_job3?>. <?=$hasil4['desc_est_cost']?><br>
									<?php $no_job3++; } ?>
							</td>	
							
							
						</tr>	
						<?php
							$total_est_cost=$total_est_cost+$sum_est_cost ; 					
							$no_job2++; 
						}?>	
					</table>
			</section>			
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
			</body>
		</html>
		<?php
		}
		//Print 
		elseif ($module=='jurnal_keu' AND $act=='print'){
			$id_pf=$_GET['id'];			
		?>
		
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
			<!-- Content Page -->
			<section class="content-header">
					<h1>Jurnal Keuangan</h1>
				<?php
				$no = 1;
				$query = mysql_query("SELECT * FROM pf_log where id_pf='$id_pf'");
				$hasil = mysql_fetch_array($query);
				$id_pf_log = $hasil['id_pf_log'];
				?>	
				<!-- Main content -->
					<table class="table">
						<tr>
							<td style="width: 20%;">NUMBER</td>
							<td style="width: 2%;">:</td>
							<td style="width: 30%;"><?= $hasil['no_pf'] ?></td>
							<td style="width: 3%;"></td>
							<td style="width: 23%;">CUSTOMER REFF</td>
							<td style="width: 2%;">:</td>
							<td style="width: 20%;"><?= $hasil['cust_ref'] ?></td>
						</tr>
						<tr>
							<td>DATE</td>
							<td>:</td>
							<td><?= $hasil['tgl_pf'] ?></td>
							<td></td>
							<td>CUSTOMER CODE</td>
							<td>:</td>
							<td><?= $hasil['cust_code'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">CUSTOMER NAME</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['cust_name'] ?></td>
							<td></td>
							<td>PIC</td> 
							<td>:</td>
							<td><?= $hasil['pic'] ?></td>
						</tr>
						<tr>
							<td style="vertical-align:top">ADDRESS</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['address_pf'] ?></td>
							<td></td>
							<td style="vertical-align:top">PHONE</td>
							<td style="vertical-align:top">:</td>
							<td style="vertical-align:top"><?= $hasil['phone'] ?></td>
						</tr>
						<?php
						if ($hasil['shipment']!="EMKL IMPORT"){ 
						?>
						<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?></td>
							<td></td>
							<td>VESSEL/VOYAGE</td>
							<td>:</td>
							<td><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td>ETB/ETD</td>
							<td>:</td>
							<td><?= date("d M y h:i:s", strtotime($hasil['etb']))  ?>/<?=date("d M y h:i:s", strtotime($hasil['etd'])) ?></td>
						</tr>
						<tr>
							<td>PU/DEL DATE</td>
							<td>:</td>
							<td><?= $hasil['pudel_date'] ?></td>
							<td></td>
							<td>OPEN STACK</td>
							<td>:</td>
							<td><?= $hasil['openstack'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>
							<td>:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td>CLOSING TIME CONT</td>
							<td>:</td>
							<td><?= $hasil['ctc'] ?></td>
						</tr>
						<tr>
							<td>CREDIT TERM</td>
							<td>:</td>
							<td><?= $hasil['ct'] ?> days</td>
							<td></td>
							<td>CLOSING TIME DOC</td>
							<td>:</td>
							<td><?= $hasil['ctd'] ?></td>
						</tr>
						<?php } else { ?>
							<tr>
							<td>SHIPMENT</td>
							<td>:</td>
							<td><?= $hasil['shipment'] ?></td>
							<td></td>
							<td>SHIPPING/FORWARDING</td>
							<td>:</td>
							<td><?= $hasil['sf'] ?></td>
						</tr>
						<tr>
							<td>QUANTITY</td>
							<td>:</td>
							<td><?= $hasil['qty_pf'] ?> - <?=$hasil['type_qty']?></td>
							<td></td>
							<td>VESSEL/VOYAGE</td>
							<td>:</td>
							<td><?= $hasil['vv'] ?></td>
						</tr>
						<tr>
							<td>ROUTE</td>
							<td>:</td>
							<td><?= $hasil['route_pf'] ?></td>
							<td></td>
							<td>ETB/ETD</td>
							<td>:</td>
							<td><?= $hasil['etb_etd'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL DATE</td>
							<td>:</td>
							<td><?= $hasil['pudel_date'] ?></td>
							<td></td>
							<td>B/L NUMBER</td>
							<td>:</td>
							<td><?= $hasil['bl_number'] ?></td>
						</tr>
						<tr>
							<td>PU/DEL LOCATION</td>
							<td>:</td>
							<td><?= $hasil['pudel_location'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php } ?>	
						<tr>
							<td>SALES</td>
							<td>:</td>
							<td><?= $hasil['sales'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="3">SPECIAL ORDER REQUEST :</td>
						</tr>
						<?php
							$no_sor=1;
							$query1 = mysql_query("select * from pf_sor where id_pf_log='$id_pf_log'");
							while ($hasil1=mysql_fetch_array($query1)){
								$id_pf_sor=$hasil1['id_pf_sor'];
						?>
						<tr>
							<td></td>
							<td colspan="3"><?=$no_sor?>. <?=$hasil1['desc_sor']?></td>
						</tr>
						<?php $no_sor++; }?>
					</table>	
							</p>
					<a>REAL CUSTOMER</a>
					<table border="1">
						<tr>
							<th>NO</th>
							<th>REAL CUSTOMER NAME</th>
							<th>ADDRESS</th>
							<th>PHONE>
						</tr>
						<?php
						$no_ru=1;
						$query_ru=mysql_query("select * from real_user where id_pf_log='$id_pf_log'");
						while($hasil_ru=mysql_fetch_array($query_ru)){
						?>
						<tr>
							<td><?=$no_ru?></td>
							<td><?=$hasil_ru['name_real_user']?></td>
							<td><?=$hasil_ru['address_real_user']?></td>
							<td><?=$hasil_ru['phone_real_user']?></td>
						</tr>
						<?php $no_ru++; } ?>
					</table>
							</p>
									
									<?php
										$type1=mysql_query("select * from pf_revenue where id_pf_log='$id_pf_log'");
										$hasil_type1=mysql_fetch_array($type1);
									?>
									<a>REVENUE | <?=$hasil_type1['type_revenue']?></a>
									<table border="1">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>REVENUE</th>
											<th>QTY</th>
											<th>SUM</th>
										</tr>
									
										<?php
										$no_job=1;	
										$sum_revenue=0;		
										$total_revenue=0;				
										$query2 = mysql_query("select * from pf_revenue where id_pf_log='$id_pf_log' order by id_pf_revenue asc");
										while ($hasil2 = mysql_fetch_array($query2)) { 	
											$sum_revenue=$hasil2['revenue']*$hasil2['qty_revenue'];
											$id_pf_revenue=$hasil2['id_pf_revenue'];
										?>	
										<tr>					
											<td align="center"><?=$no_job?></td>
											<td><?=$hasil2['type2_revenue']?></td>
											<td><?=$hasil2['desc_revenue']?></td>
											<td align="right"><?=number_format($hasil2['revenue'])?></td>
											<td align="center"><?=$hasil2['qty_revenue']?></td>
											<td align="right"><?=number_format($sum_revenue)?></td>
										</tr>

										<?php
											$total_revenue=$total_revenue+$sum_revenue;
											$no_job++; 
										}?>	
									</table>
									</p>
									<a>EST COST</a> 
									<table border="1">
										<tr>
											<th>NO</th>
											<th>TYPE</th>
											<th>DESCRIPTION</th>
											<th>EST COST</th>
											<th>QTY</th>
											<th>ALL IN RATE</th>
										</tr>
										<?php
										$no_job2=1;	
										$sum_est_cost=0;
										$total_est_cost=0;						
										$query3 = mysql_query("select * from pf_est_cost where id_pf_log='$id_pf_log' order by id_pf_est_cost asc");
										while ($hasil3 = mysql_fetch_array($query3)) { 
											$sum_est_cost=$hasil3['est_cost']*$hasil3['qty_est_cost']; 
											$id_pf_est_cost=$hasil3['id_pf_est_cost'];
										?>
										<tr>				
											<td align="center"><?=$no_job2?></td>
											<td><?=$hasil3['type_est_cost']?></td>
											<td><?=$hasil3['desc_est_cost']?></td>
											<td align="right"><?=number_format($hasil3['est_cost'])?></td>
											<td align="center"><?=$hasil3['qty_est_cost']?></td>
											<td align="right"><?=number_format($sum_est_cost)?></td>
										</tr>	
										<?php
											$total_est_cost=$total_est_cost+$sum_est_cost ; 					
											$no_job2++; 
										}?>	
									</table>	
									</p>
									<a>P/L ESTIMASI COST</a>	
									<table border="1">
										<tr>
											<th>NO</th>
											<th>DESCRIPTION</th>
											<th>TOTAL</th>
										</tr>
										<tr>
											<td align="center">1</td>
											<td>Total Revenue</td>
											<td align="right"><?=number_format($total_revenue)?></td>
										</tr>
										<tr>
											<td align="center">2</td>
											<td>Total Estimasi Cost</td>
											<td align="right"><?=number_format($total_est_cost)?></td>
										</tr>
										<tr>
											<td></td>
											<td>Profit and Lost Estimasi Cost</td>
											<td align="right"><?=number_format($total_revenue-$total_est_cost)?></td>
										</tr>

									</table>
								</div>		
							</div>
						</div>
					</div>
      			</div>
			</section>		
			<!-- JS Print -->
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
		<?php
			
		}
	}
?>
