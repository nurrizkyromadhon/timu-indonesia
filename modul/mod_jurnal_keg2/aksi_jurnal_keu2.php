<?php
session_start();
error_reporting(0);
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
	echo "<a href=../../index.php><b>LOGIN</b></a></center>";
} else {
	include "../../config/koneksi.php";
	$id_user = $_SESSION['id_users'];
	$module = $_POST['module'];
	$act = $_POST['act'];
	$module = $_GET['module'];
	$act = $_GET['act'];


	// Input user
	if ($module == 'jurnal_keu2' and $act == 'tambah_jurnal_keu2') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_est_cost = $_POST['id_pf_est_cost'];
		$id_pf_revenue = $_POST['id_pf_revenue'];
		$id_pf_invoice = $_POST['id_pf_invoice'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			if (!empty($id_pf_est_cost)) {
				$qryid_pf = mysql_query("SELECT * from pf_est_cost where id_pf_est_cost=$id_pf_est_cost[$x]");
				$hslid_pf = mysql_fetch_array($qryid_pf);
				$id_pf = $hslid_pf['id_pf'];
			}
			if (!empty($id_pf_revenue)) {
				$revid_pf = mysql_query("SELECT * from pf_revenue where id_pf_revenue=$id_pf_revenue[$x]");
				$hslrevid_pf = mysql_fetch_array($revid_pf);
				$id_pf = $hslrevid_pf['id_pf'];
			}
			if (!empty($id_pf_invoice)) {
				$invid_pf = mysql_query("SELECT * from pf_invoice where id_pf_invoice=$id_pf_invoice[$x]");
				$hslinv_id_pf = mysql_fetch_array($invid_pf);
				$id_pf = $hslinv_id_pf['id_pf'];
				$id_pf_revenue = $hslinv_id_pf['id_pf_revenue'];
			}

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf,user_pf_real_cost,id_est_cost,id_revenue,id_pf_invoice,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk) VALUE ('$id_pf','$id_user','$id_pf_est_cost[$x]','$id_pf_revenue[$x]','$id_pf_invoice[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();


			if (!empty($id_pf_est_cost[$x])) {
				mysql_query("UPDATE pf_est_cost SET cek_est_cost='1' where id_pf_est_cost=$id_pf_est_cost[$x]");
			}

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				echo "<script>console.log('Debug Objects: " . json_encode($nm_file) . "' );</script>";

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_est_cost, id_revenue, id_pf_real_cost, nm_file) VALUES ('$id_pf','$id_pf_est_cost[$x]','$id_pf_revenue[$x]','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_op_kas') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_est_cost = $_POST['id_pf_est_cost'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$hut_id = $_POST['hut_id'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {

			$qryid_pf = mysql_query("SELECT * from pf_est_cost where id_pf_est_cost=$id_pf_est_cost[$x]");
			$hslid_pf = mysql_fetch_array($qryid_pf);
			$id_pf_log = $hslid_pf['id_pf_log'];
			if (!empty($id_pf_est_cost[$x])) {
				mysql_query("UPDATE pf_est_cost SET cek_est_cost='1' where id_pf_est_cost=$id_pf_est_cost[$x]");
			}
			/*if(!empty($hut_id[$x])) {					
					mysql_query("UPDATE pf_real_cost SET bl=1 
							WHERE 'id_pf_real_cost'=$hut_id[$x]") or die(mysql_error());
				}*/
			$qryhut = mysql_query("SELECT * from pf_real_cost where id_hut2='$hut_id[$x]' and category1 ='HUT' and category2='HUT'");
			$hslhut = mysql_fetch_array($qryhut);
			$cost_hut = $hslhut['real_cost'];
			$id_pf_real_cost_hut = $hslhut['id_pf_real_cost'];
			$no_reff_hut = $hslhut['no_reff_keu'];

			$query = mysql_query("INSERT INTO pf_real_cost(id_pf_log,user_pf_real_cost,id_est_cost,id_hut,no_hut,id_hut2,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk)VALUE('$id_pf_log','$id_user','$id_pf_est_cost[$x]','$no_reff_hut','$id_pf_real_cost_hut','$hut_id[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_op_kas2') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_est_cost = $_POST['id_pf_est_cost'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$hut_id = $_POST['hut_id'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			$qryid_pf = mysql_query("SELECT * from pf_est_cost where id_pf_est_cost=$id_pf_est_cost[$x]");
			$hslid_pf = mysql_fetch_array($qryid_pf);
			$id_pf_log = $hslid_pf['id_pf_log'];

			if (!empty($hut_id[$x])) {
				mysql_query("UPDATE pf_real_cost SET bl=1 
							WHERE 'id_pf_real_cost'=$hut_id[$x]") or die(mysql_error());
			}
			if (!empty($id_pf_est_cost[$x])) {
				mysql_query("UPDATE pf_est_cost SET cek_est_cost='1' where id_pf_est_cost=$id_pf_est_cost[$x]");
			}

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_est_cost,id_hut,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,dk) VALUE ('$id_pf_log','$id_user','$id_pf_est_cost[$x]','$hut_id[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_op_ap') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_est_cost = $_POST['id_pf_est_cost'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			$qryid_pf = mysql_query("SELECT * from pf_est_cost where id_pf_est_cost=$id_pf_est_cost[$x]");
			$hslid_pf = mysql_fetch_array($qryid_pf);
			$id_pf_log = $hslid_pf['id_pf_log'];

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_est_cost,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk) VALUE ('$id_pf_log','$id_user','$id_pf_est_cost[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	}

	//tambah est_cost
	elseif ($module == 'jurnal_keu2' and $act == 'tambah_est_cost') {
		$id_pf_log = $_GET['id_pf_log'];
		$id_pf = $_GET['id_pf'];
		$type_est_cost = $_GET['type_est_cost'];
		$desc_est_cost = $_GET['desc_est_cost'];
		$est_cost = $_GET['est_cost'];
		$qty_est_cost = $_GET['qty_est_cost'];

		$query = "INSERT INTO pf_est_cost (id_pf_log, type_est_cost, desc_est_cost, est_cost, qty_est_cost) VALUES ('$id_pf_log','$type_est_cost','$desc_est_cost','$est_cost','$qty_est_cost')";
		$sql = mysql_query($query) or die(mysql_error());

		header("location:../../oklogin.php?module=$module&act=detailestcost&id=$id_pf");
	} elseif ($module == 'jurnal_keu2' and $act == 'update_est_cost') {
		mysql_query("UPDATE pf_est_cost SET type_est_cost='$_GET[type_est_cost]',
									   desc_est_cost='$_GET[desc_est_cost]',
									   est_cost='$_GET[est_cost]',
									   qty_est_cost='$_GET[qty_est_cost]'
						WHERE id_pf_est_cost = $_GET[id]") or die(mysql_error());

		header("location:../../oklogin.php?module=$module&act=detailestcost&id=$_GET[id_pf]");
	} elseif ($module == 'jurnal_keu2' and $act == 'delete_est_cost') {
		mysql_query("DELETE FROM pf_est_cost WHERE  id_pf_est_cost = " . $_GET['id']);
		header("location:../../oklogin.php?module=$module&act=detailestcost&id=$_GET[id_pf]");
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_bbm') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_revenue = $_POST['id_pf_revenue'];
		$id_pf_invoice = $_POST['id_pf_invoice'];
		$category1 = $_POST['id_pf_invoice'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$no_inv = $_POST['no_inv'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			$invid_pf = mysql_query("SELECT * from pf_invoice where no_invoice='$category1[$x]'");
			$hslinv_id_pf = mysql_fetch_array($invid_pf);
			$id_pf_log = $hslinv_id_pf['id_pf_log'];
			$no_invo = $hslinv_id_pf['no_invoice'];
			if ($id_pf_log == 0) {
				$revid_pf = mysql_query("SELECT * from pf_revenue where id_pf_log=$id_pf_revenue[$x]");
				$hslrev_id_pf = mysql_fetch_array($revid_pf);
				$id_pf_log = $hslrev_id_pf['id_pf_log'];
				$id_pf_revenue2 = $hslrev_id_pf['id_pf_revenue'];
				$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_revenue,id_pf_invoice,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk) VALUE ('$id_pf_log','$id_user','$id_pf_revenue2','$id_pf_invoice[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
				$real_cost_id = mysql_insert_id();
				if (substr($bukti[$x], 0, 3)  == 'INV') {
					mysql_query("UPDATE pf_log SET status_ops='PAID' where id_pf_log=$id_pf_log");
				}
				if (substr($category1[$x], 0, 3)  == 'INV') {
					mysql_query("UPDATE pf_log SET status_ops='PAID' where id_pf_log=$id_pf_log");
				}
			} else {
				mysql_query("UPDATE pf_log SET status_ops='PAID' where id_pf_log=$id_pf_log");
				$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_revenue,id_pf_invoice,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk) VALUE ('$id_pf_log','$id_user','$id_pf_revenue2','$id_pf_invoice[$x]','$tgl_pf_real_cost','$no_invo','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
				$real_cost_id = mysql_insert_id();
			}


			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				echo "<script>console.log('Debug Objects: " . json_encode($nm_file) . "' );</script>";

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_bkm') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_revenue = $_POST['id_pf_revenue'];
		$id_pf_invoice = $_POST['id_pf_invoice'];
		$category1 = $_POST['id_pf_invoice'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$no_inv = $_POST['no_inv'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			$invid_pf = mysql_query("SELECT * from pf_invoice where id_pf_invoice=$id_pf_invoice[$x]");
			$hslinv_id_pf = mysql_fetch_array($invid_pf);
			$id_pf_log = $hslinv_id_pf['id_pf_log'];
			$no_invo = $hslinv_id_pf['no_invoice'];
			if ($id_pf_log == 0) {
				$revid_pf = mysql_query("SELECT * from pf_revenue where id_pf_revenue=$id_pf_revenue[$x]");
				$hslrev_id_pf = mysql_fetch_array($revid_pf);
				$id_pf_log = $hslrev_id_pf['id_pf_log'];
			}
			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_revenue,id_pf_invoice,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,dk) VALUE ('$id_pf_log','$id_user','$id_pf_revenue[$x]','$id_pf_invoice[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				echo "<script>console.log('Debug Objects: " . json_encode($nm_file) . "' );</script>";

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_piut') {
		$no_reff_keu = $_POST['no_reff_keu'];
		$tgl_pf_real_cost = $_POST['tgl_pf_real_cost'];
		$id_pf_invoice = $_POST['id_pf_invoice'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$real_cost = $_POST['real_cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($real_cost); $x++) {
			$invid_pf = mysql_query("SELECT * from pf_invoice where id_pf_invoice=$id_pf_invoice[$x]");
			$hslinv_id_pf = mysql_fetch_array($invid_pf);
			$id_pf_log = $hslinv_id_pf['id_pf_log'];

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log,user_pf_real_cost,id_pf_invoice,tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk) VALUE ('$id_pf_log','$id_user','$id_pf_invoice[$x]','$tgl_pf_real_cost','$category1[$x]','$act2','$kegiatan[$x]','$no_reff_keu','$stakeholder[$x]','$bukti[$x]','$real_cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
			$real_cost_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				echo "<script>console.log('Debug Objects: " . json_encode($nm_file) . "' );</script>";

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_pf, id_pf_real_cost, nm_file) VALUES ('$id_pf','$real_cost_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'balik_op_kas') {
		$tgl = date("Y-m-d H:i:s");
		$act2 = $_POST['act2'];
		$id_op_ap = $_POST['id_op_kas'];
		$op_ap = mysql_query("SELECT * from pf_real_cost as rc 
					left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
					left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost 
					where rc.id_pf_log=$id_op_ap and
					category1 = 'OP CASH' and
					bl = '0' order by id_pf_real_cost");
		while ($hasil_ap = mysql_fetch_array($op_ap)) {
			$stakeholder = $hasil_ap['stakeholder'];
			$description = $hasil_ap['desc_est_cost'];
			$no_jo = $hasil_ap['no_jo'];

			mysql_query("UPDATE pf_real_cost SET bl = 1, updated_date='$tgl'
							WHERE id_pf_real_cost='$hasil_ap[id_pf_real_cost]'");

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log, user_pf_real_cost, id_est_cost, tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk,bl) 
									VALUE ('$id_op_ap','$id_user','$hasil_ap[id_est_cost]','$tgl','BIAYA','BBK','PENGAKUAN BIAYA ATAS $hasil_ap[no_reff_keu] JO $no_jo','$hasil_ap[no_reff_keu]_AP','$stakeholder','$hasil_ap[bukti]','$hasil_ap[real_cost]','$hasil_ap[bank]','D','1')") or die(mysql_error());
		}

		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'balik_op_ap') {

		$act2 = $_POST['act2'];
		$id_op_ap = $_POST['id_op_ap'];

		$op_ap = mysql_query("SELECT * from pf_real_cost as rc 
					left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
					left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost 
					where rc.id_pf_log=$id_op_ap and
					category1 = 'OP AP' and
					bl = '0'");
		while ($hasil_ap = mysql_fetch_array($op_ap)) {
			$tgl = date("Y-m-d H:i:s");
			$stakeholder = $hasil_ap['stakeholder'];
			$description = $hasil_ap['desc_est_cost'];
			$no_jo = $hasil_ap['no_jo'];
			$id_pf_real_cost = $hasil_ap['id_pf_real_cost'];

			mysql_query("UPDATE pf_real_cost SET bl = 1, updated_date='$tgl'
							WHERE id_pf_real_cost='$hasil_ap[id_pf_real_cost]'");

			$query = mysql_query("INSERT INTO pf_real_cost (id_pf_log, user_pf_real_cost, id_est_cost, id_hut2, tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk,bl) 
									VALUE ('$id_op_ap','$id_user','$hasil_ap[id_est_cost]','$id_pf_real_cost','$tgl','HUT','HUT','PENGAKUAN HUTANG $hasil_ap[kegiatan]','$hasil_ap[no_reff_keu]_AP','$stakeholder','$hasil_ap[bukti]','$hasil_ap[real_cost]','$hasil_ap[bank]','K','1')") or die(mysql_error());
		}

		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'balik_op_ar') {

		$act2 = $_POST['act2'];
		$id_op_ar = $_POST['id_op_ar'];

		$op_ap = mysql_query("SELECT * from pf_real_cost as rc 
					left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
					left join pf_revenue as ec on rc.id_revenue=ec.id_pf_revenue
					where rc.id_pf_log=$id_op_ar and
					category1 = 'OP AR' and
					bl = '0'");

		while ($hasil_ap = mysql_fetch_array($op_ap)) {
			$tgl = date("Y-m-d H:i:s");
			$stakeholder = $hasil_ap['stakeholder'];
			$description = $hasil_ap['desc_est_cost'];
			$no_jo = $hasil_ap['no_jo'];

			mysql_query("UPDATE pf_real_cost SET bl = 1, 
													updated_date='$tgl'
							WHERE id_pf_real_cost='$hasil_ap[id_pf_real_cost]'");

			mysql_query("INSERT INTO pf_real_cost (id_pf_log, user_pf_real_cost, id_revenue, tgl_pf_real_cost,category1,category2,kegiatan,no_reff_keu,stakeholder,bukti,real_cost,bank,dk,bl) 
									VALUE ('$hasil_ap[id_pf_log]','$id_user','$hasil_ap[id_pf_revenue]','$tgl','DP','BBM','PENGURANG INVOICE ATAS $hasil_ap[no_reff_keu] JO $no_jo','$hasil_ap[no_reff_keu]_AR','$stakeholder','$hasil_ap[bukti]','$hasil_ap[real_cost]','$hasil_ap[bank]','K','1')") or die(mysql_error());
		}

		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_keu_njo') {
		$no_reff = $_POST['no_reff'];
		$tgl_keu = $_POST['tgl_keu'];
		$category1 = $_POST['category1'];
		$kegiatan = $_POST['kegiatan'];
		$stakeholder = $_POST['stakeholder'];
		$bukti = $_POST['bukti'];
		$cost = $_POST['cost'];
		$bank = $_POST['bank'];
		$dk = $_POST['dk'];
		$act2 = $_POST['act2'];
		$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg', 'xlsx', 'docx', 'svg');

		for ($x = 0; $x < count($category1); $x++) {
			$query = mysql_query("INSERT INTO keu_non_jo (user_keu,tgl_keu,category1,category2,kegiatan,no_reff,stakeholder,bukti,cost,bank,dk) VALUE ('$id_user','$tgl_keu','$category1[$x]','$act2','$kegiatan[$x]','$no_reff','$stakeholder[$x]','$bukti[$x]','$cost[$x]','$bank[$x]','$dk')") or die(mysql_error());
			$keu_id = mysql_insert_id();

			$file_img = $_FILES['nm_file' . $x];

			for ($y = 0; $y < count($file_img['name']); $y++) {
				$nm_file = $file_img['name'][$y];
				$ex = explode('.', $nm_file);
				$ext = strtolower(end($ex));
				$size = $file_img['size'][$y];
				$file_tmp = $file_img['tmp_name'][$y];

				if (in_array($ext, $ext_diperbolehkan) === true) {
					if ($size < 10000000) {
						move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

						$query = "INSERT INTO images_db (id_keu_njo, nm_file) VALUES ('$keu_id','$nm_file')";
						$sql = mysql_query($query) or die(mysql_error());
					} else {
						echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
					}
				} else {
					echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
				}
			}
		}
		header('location:../../oklogin.php?module=' . $module . '&act=' . $act2);
	} elseif ($module == 'jurnal_keu2' and $act == 'update_rc') {

		$no_jo = $_GET['id_pf_log'];
		$type = $_GET['type'];
		$bukti = $_GET['bukti'];
		$category = $_GET['category1'];
		$hut_id = $_GET['hut_id'];
		$qryhut = mysql_query("SELECT * from pf_real_cost where id_hut2=$hut_id and category1 ='HUT' and category2='HUT'");
		$hslhut = mysql_fetch_array($qryhut);
		$cost_hut = $hslhut['real_cost'];
		$no_reff_hut = $hslhut['no_reff_keu'];
		$id_pf_real_cost = $hslhut['id_pf_real_cost'];
		$id_pf_log = mysql_query("SELECT * from pf_log where no_jo='$no_jo'");
		$hslid_pf_log = mysql_fetch_array($id_pf_log);
		$id_new = $hslid_pf_log['id_pf_log'];
		if ($type == "BBK" or $type == "BKK" or $type == "HUT") {
			$est_cost = mysql_query("SELECT * from pf_est_cost where id_pf_log='$id_new'");
			$hslest_cost = mysql_fetch_array($est_cost);
			$id_est_cost = $hslest_cost['id_pf_est_cost'];
			$buktiInv = substr($category, 0, 3);
			if ($buktiInv  == 'INV') {
				mysql_query("UPDATE pf_log SET status_ops='PAID' where id_pf_log=$id_new");
			}
		} elseif ($type == "BBM" or $type == "BKM") {
			$buktiInv = substr($category, 0, 3);
			if ($buktiInv  == 'INV') {
				mysql_query("UPDATE pf_log SET status_ops='PAID' where id_pf_log=$id_new");
			}
			$revenue = mysql_query("SELECT * from pf_revenue where id_pf_log='$id_new'");
			$hslrevenue = mysql_fetch_array($revenue);
			$id_revenue = $hslrevenue['id_pf_revenue'];
		}

		if (!empty($no_jo)) {
			mysql_query("UPDATE pf_real_cost SET id_pf_log = '$id_new',
												 id_est_cost = '$id_est_cost',
												 id_revenue = '$id_revenue',
												 id_hut = '$no_reff_hut',
												 no_hut = '$id_pf_real_cost',												 
												 id_hut2 = '$hut_id',												 
												 tgl_pf_real_cost = '$_GET[tgl_pf_real_cost]',
											  	 no_reff_keu = '$_GET[no_reff_keu]', 
												
												 category1 = '$_GET[category1]',
												 kegiatan = '$_GET[kegiatan]',
												 stakeholder = '$_GET[stakeholder]',
												 bukti = '$_GET[bukti]',
												 real_cost = '$_GET[real_cost]',
												 bank = '$_GET[bank]'
						WHERE id_pf_real_cost = $_GET[id]");
		} else {
			mysql_query("UPDATE pf_real_cost SET tgl_pf_real_cost = '$_GET[tgl_pf_real_cost]',
											  	 no_reff_keu = '$_GET[no_reff_keu]', 
												
												 category1 = '$_GET[category1]',
												 kegiatan = '$_GET[kegiatan]',
												 stakeholder = '$_GET[stakeholder]',
												 bukti = '$_GET[bukti]',
												 real_cost = '$_GET[real_cost]',
												 bank = '$_GET[bank]'
						WHERE id_pf_real_cost = $_GET[id]");
		}


		header('location:../../oklogin.php?module=' . $module);
	}
	// Update jurnal_keu
	elseif ($module == 'jurnal_keu2' and $act == 'update_jurnal_keu2') {

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

		header('location:../../oklogin.php?module=' . $module);
	}
	// Update sor
	elseif ($module == 'jurnal_keu2' and $act == 'update_sor') {

		mysql_query("UPDATE pf_sor SET desc_sor = '$_GET[desc_sor]' WHERE id_pf_sor = $_GET[id]");

		header('location:../../oklogin.php?module=' . $module);
	}
	//Update Revenue
	elseif ($module == 'jurnal_keu2' and $act == 'update_revenue') {

		mysql_query("UPDATE pf_revenue SET type_revenue = '$_GET[type_revenue]',
									   type2_revenue = '$_GET[type2_revenue]',
									   desc_revenue = '$_GET[desc_revenue]',
									   revenue = '$_GET[revenue]',
									   qty_revenue= '$_GET[qty_revenue]' 
									   
						WHERE id_pf_revenue = $_GET[id]") or die(mysql_error());

		header('location:../../oklogin.php?module=' . $module);
	}

	//Update est_cost
	elseif ($module == 'jurnal_keu2' and $act == 'update_ec') {

		mysql_query("UPDATE pf_real_cost SET type_est_cost = '$_GET[type_est_cost]',
									   desc_est_cost = '$_GET[desc_est_cost]',
									   est_cost = '$_GET[est_cost]',
									   qty_est_cost= '$_GET[qty_est_cost]' 
									   
						WHERE id_pf_est_cost = $_GET[id]") or die(mysql_error());

		header('location:../../oklogin.php?module=' . $module);
	}

	// Hapus data
	elseif ($module == 'jurnal_keu2' and $act == 'delete_pf_real_cost') {
		$id_pf_real_cost = $_GET['id_pf_real_cost'];
		$id_est_cost = $_GET['id_est_cost'];

		mysql_query("DELETE FROM pf_real_cost WHERE  id_pf_real_cost = " . $_GET['id']);
		mysql_query("UPDATE pf_est_cost SET cek_est_cost='0' where id_pf_est_cost='$id_est_cost'");



		header('location:../../oklogin.php?module=' . $module);
	}

	// Hapus data
	elseif ($module == 'jurnal_keu2' and $act == 'hapus_gambar') {
		$check = $_POST["check"];
		$id_pf_real_cost = $_POST['id_pf_real_cost'];
		if (isset($_POST["check"])) {

			for ($x = 0; $x < count($check); $x++) {
				mysql_query("DELETE FROM images_db WHERE id_images_db = $check[$x]");
			}
		}

		header('location:../../oklogin.php?module=' . $module . '&act=tambah_image&id=' . $id_pf_real_cost);
	} elseif ($module == 'jurnal_keu2' and $act == 'tambah_images') {
		if (isset($_POST['bupload'])) {
			$id_pf = $_POST['id_pf'];
			$id_est_cost = $_POST['id_est_cost'];
			$id_revenue = $_POST['id_revenue'];
			$id_pf_real_cost = $_POST['id_pf_real_cost'];
			//echo $id_revenue; break;
			$ext_diperbolehkan = array('jpg', 'png', 'pdf', 'bmp', 'jpeg');
			$nm_file = $_FILES['nm_file']['name'];
			$x = explode('.', $nm_file);
			$ext = strtolower(end($x));
			$size = $_FILES['nm_file']['size'];
			$file_tmp = $_FILES['nm_file']['tmp_name'];

			if (in_array($ext, $ext_diperbolehkan) === true) {
				if ($size < 10000000) {
					move_uploaded_file($file_tmp, '../../images/data_op/' . $nm_file);

					$query = "INSERT INTO images_db (id_pf, id_est_cost, id_revenue, id_pf_real_cost, nm_file) VALUES ('$id_pf','$id_est_cost','$id_revenue','$id_pf_real_cost','$nm_file')";
					$sql = mysql_query($query) or die(mysql_error());
				} else {
					echo "<script>alert('File Tidak Boleh Lebih dari 10Mb !!!'); exit;</script>";
				}
			} else {
				echo "<script>alert('File belum dipilih atau Ext File tidak diperbolehkan !!!'); exit;</script>";
			}
		}


		header('location:../../oklogin.php?module=' . $module . '&act=tambah_image&id=&id=' . $id_pf_real_cost);
	}
	//Save to Excel
	elseif ($module == 'jurnal_keu2' and $act == 'excel') {
		$hari_ini = date("Y-m-d H:i:s");
		if (empty($_GET['tgl_aw'])) {
			$tgl_aw = date('Y-m-01', strtotime($hari_ini . ''));
			$tgl_ak = date('Y-m-t', strtotime($hari_ini));

			$tgl_aw_str = date('01-M-Y', strtotime($tgl_aw));
			$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
		} else {
			$tgl_aw = $_GET['tgl_aw'];
			$tgl_ak = $_GET['tgl_ak'];

			$tgl_aw_str = date('d-M-Y', strtotime($tgl_aw));
			$tgl_ak_str = date('d-M-Y', strtotime($tgl_ak));
		}
		//Start
		$date = date('ymd');

		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=jurnal_keu($date).xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Cache-Control: max-age=0");

?>

		<body>
			<table border="1">
				<thead>
					<tr>
						<th>NO</th>
						<th>DATE</th>
						<th>NO REFF</th>
						<th>NO INVOICE</th>
						<th>JO NUMBER</th>
						<th>DESCRIPTION</th>
						<th></th>
						<th>KATEGORY</th>
						<th>KEGIATAN</th>
						<th>STAKEHOLDER</th>
						<th>BUKTI</th>
						<th>VALUE</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no_real_cost = 1;

					$categoryJu = $_GET['categoryJu'];
					if ($categoryJu == 'JO') {
						$query4 = mysql_query("select * from pf_real_cost as rc
						left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
						left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
						left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
						where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak' and no_jo !=''
						order by id_pf_real_cost desc");
					} elseif ($categoryJu == 'ALL') {
						$query4 = mysql_query("select * from pf_real_cost as rc
						left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
						left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
						left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue						
						order by id_pf_real_cost desc");
					} else {
						$query4 = mysql_query("select * from pf_real_cost as rc
						left join pf_log on rc.id_pf_log=pf_log.id_pf_log 
						left join pf_est_cost as ec on rc.id_est_cost=ec.id_pf_est_cost
						left join pf_revenue as pr on rc.id_revenue=pr.id_pf_revenue
						where tgl_pf_real_cost between '$tgl_aw' and '$tgl_ak'
						order by id_pf_real_cost desc");
					}

					while ($hasil4 = mysql_fetch_array($query4) or die(mysql_error())) {
						$id_pf_real_cost = $hasil4['id_pf_real_cost'];
						$id_est_cost = $hasil4['id_est_cost'];
						$id_revenue = $hasil4['id_revenue'];
						$id_pf = $hasil4['id_pf'];

					?>
						<tr>
							<td><?= $no_real_cost ?></td>
							<td><?= $hasil4['tgl_pf_real_cost'] ?></td>
							<td><?= $hasil4['no_reff_keu'] ?></td>
							<td><?= $hasil4['no_invoice'] ?></td>
							<td><?= $hasil4['no_jo'] ?></td>

							<?php
							if (!empty($id_est_cost)) {
							?>
								<td><?= $hasil4['type_est_cost'] ?></td>
								<td><?= $hasil4['desc_est_cost'] ?></td>
							<?php } else { ?>
								<td><?= $hasil4['type_revenue'] ?> <?= $hasil4['type2_revenue'] ?></td>
								<td><?= $hasil4['desc_revenue'] ?></td>
							<?php } ?>
							<td><?= $hasil4['category1'] ?></td>
							<td><?= $hasil4['kegiatan'] ?></td>
							<td><?= $hasil4['stakeholder'] ?></td>
							<td><?= $hasil4['bukti'] ?></td>
							<td><?= number_format($hasil4['real_cost']) ?></td>
						</tr>
					<?php $no_real_cost++;
					} ?>
				</tbody>
			</table>
		</body>
	<?php
	}
	//Print 
	elseif ($module == 'jurnal_keu2' and $act == 'print') {
		$id_pf = $_GET['id'];
	?>

		<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>

		<style type="text/css">
			@page {
				size: Legal;
				size: portrait;
				margin: 5mm 5mm 5mm;
				font-size: 13px;
			}

			#marginkiri {
				margin: 10mm 10mm 5mm 20mm;
			}

			#garis {
				border-top: 1px solid #afbcc6;
				border-bottom: 1px solid #eff2f6;
				height: 0px;
			}
		</style>

		<?php
		$id_pf = $_GET['id_pf'];
		$id_pf_real_cost = $_GET['id'];
		$reff = $_GET['reff'];
		$no_reff_keu = $_GET['no_reff_keu'];
		$pf = mysql_query("select * from pf_real_cost where id_pf_real_cost=$id_pf_real_cost");
		$hsl_pf = mysql_fetch_array($pf);
		?>

		<!-- Content Page -->
		<section class="content-header">
			<img src="../../images/logo_perush/LOGO TIMU1.png" width="250" height="50">
			<br>
			<?php
			if ($reff == 'BBK' or $reff == 'BKK') {
			?>
				<h2 align="center" style="color: red;">- <?= $hsl_pf['no_reff_keu'] ?> -</h2>
			<?php
			} else {
			?>
				<h2 align="center" style="color: blue;">- <?= $hsl_pf['no_reff_keu'] ?> -</h2>
			<?php } ?>

			<lable>DATE : <?= $hsl_pf['tgl_pf_real_cost'] ?></lable>

			<table border="1" width="100%">

				<?php
				if ($reff == 'BBK' or $reff == 'BKK') {
				?>
					<tr style="background-color: RED">
						<th>NO</th>
						<th>BUKTI</th>
						<th>DISCRIPTION</th>
						<th>NOMINAL</th>
					</tr>
				<?php
				} elseif ($reff == 'HUT') { ?>
					<tr style="background-color: BLUE; color:white;">
						<th>NO</th>
						<th>ID HUT</th>
						<th>BUKTI</th>
						<th>DISCRIPTION</th>
						<th>NOMINAL</th>
					</tr>
				<?php
				} else {
				?>
					<tr style="background-color: BLUE; color:white;">
						<th>NO</th>
						<th>BUKTI</th>
						<th>DISCRIPTION</th>
						<th>NOMINAL</th>
					</tr>
				<?php
				}
				?>
				<?php
				$no = 1;
				$rc = mysql_query("select * from pf_real_cost as rc
										where no_reff_keu='$no_reff_keu' ");
				while ($hslrc = mysql_fetch_array($rc)) {
					$bukti = $hslrc['bukti'];
					$kegiatan = $hslrc['kegiatan'];
					$real_cost = $hslrc['real_cost'];
					$id_pf_real_cost2 = $hslrc['id_pf_real_cost'];
					$total = $total + $real_cost;
				?>
					<?php
					if ($reff == 'HUT') { ?>
						<tr>
							<td align="center"><?= $no ?></td>
							<td><?= $id_pf_real_cost2 ?></td>
							<td><?= $bukti ?></td>
							<td><?= $kegiatan ?></td>
							<td align="right"><?= number_format($real_cost) ?></td>
						</tr>
					<?php
					} else { ?>
						<tr>
							<td align="center"><?= $no ?></td>
							<td><?= $bukti ?></td>
							<td><?= $kegiatan ?></td>
							<td align="right"><?= number_format($real_cost) ?></td>
						</tr>
					<?php
					}
					?>

				<?php $no++;
				} ?>
				<tr>
					<td colspan="3" align="right">TOTAL :</td>
					<td align="right"><?= number_format($total) ?></td>
				</tr>
			</table>
			<br>
			<p></p>
			<table border="1" width="100%">
				<tr>
					<td><br><br><br><br><br><br></td>
					<td><br><br><br><br><br><br></td>
					<td><br><br><br><br><br><br></td>
				</tr>
			</table>
		</section>


		<!-- JS Print -->
		<script type="text/javascript">
			$(function() {
				window.print();
			});
		</script>
<?php
	}
}
?>