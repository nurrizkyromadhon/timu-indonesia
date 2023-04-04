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
		$date=date('Y-m-d');

		if ($module=='proses_kpr' AND $act=='update') {
			//1. log update tgl proses AKAD
			mysql_query("insert into update_akad  (tgl_update, id_nasabah, ket_update) value ('$_POST[tgl_update]','$_POST[id_nasabah]','$_POST[ket_update]')");
			
			//2. update database nasabah
			
			$harga=str_replace(',','',$_POST['harga']);
			$kpr=str_replace(',','',$_POST['kpr']);	
			$um=str_replace(',','',$_POST['um']);	
			$cb=str_replace(',','',$_POST['cb']);
			mysql_query("update nasabah set nama_user='$_POST[nm_user]',v_account='$_POST[v_account]', no_shgb='$_POST[no_shgb]', no_pbb='$_POST[no_pbb]', type_rumah='$_POST[type_rumah]', fpr='$_POST[fpr]', ppjb='$_POST[ppjb]', ob='$_POST[ob]', kpr='$kpr', harga_jual='$harga',um='$um', cb='$cb', ajb='$_POST[ajb]', tgl_real='$_POST[tgl_real]', no_meter='$_POST[no_meter]',  bank='$_POST[bank]', notaris='$_POST[notaris]', ket ='$_POST[ket_update]' where id_nasabah='$_POST[id_nasabah]'");
			
			//3.Update Hutang User Jika yang di update UM 
			mysql_query("update hutang_user set hutang='$um' where id_nasabah='$_POST(id_nasabah) and ket='Hutang User' " );
			

			if (!empty($_POST['tgl_real'])){
				mysql_query("update nasabah set id_indikasi='5' where id_nasabah='$_POST[id_nasabah]'");
			}

			header('location:../../oklogin.php?module='.$module);
		}
		// Prin FPR
		else if ($module=='kpr' AND $act=='print'){
		break;
			?>
			<html>
			<head>
			<title>SURAT PERMINTAAN/PEMBELIAN</title>

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

			</head>
			<body>
				<img src="../../images/nm_perush/logo/logo.jpg" width="100%" height="93">
				<h3 align="right">Nomor : <?=$_POST['fpr']?></h3>
				<center><u><h1>FORMULIR PEMESANAN RUMAH</h1></u></center>
			<div id="marginkiri"> 
			<table> 
			<tr>
			  <td colspan="3">Yang Bertanda tangan di bawah ini, </td>
			</tr>
			<tr>
				<td colspan="3">&nbsp;</td>
			</tr>

			<tr>
			  <td width="174">Nama</td>
			  <td width="3">:</td>
			  <td width="384"><?=$_POST['nm_user']?></td>
			</tr>
			<tr>
			  <td>Alamat Rumah</td>
			  <td>:</td>
			  <td><?=$_POST['alamat_rmh']?></td>
			</tr>
			<tr>
			  <td>No. Telpon / HP</td>
			  <td>:</td>
			  <td><?=$_POST['telp']?></td>
			</tr>
			<tr>
			  <td>Pekerjaan </td>
			  <td>:</td>
			  <td><?=$_POST['pekerjaan']?></td>
			</tr>
			<tr>
			  <td>Alamat Kantor</td>
			  <td>:</td>
			  <td><?=$_POST['alamat_kantor']?></td>
			</tr>
			<tr>
			  <td>Telpon Kantor</td>
			  <td>:</td>
			  <td><?=$_POST['telp']?></td>
			</tr>
			<tr>
			  <td>Gaji Perbulan </td>
			  <td>:</td>
			  <td><?=$_POST['gaji_bln']?></td>
			</tr>
			<tr>
			  <td>Penghasilan Lain-lain</td>
			  <td>:</td>
			  <td><?=$_POST['penghasilan_lain']?></td>
			</tr>
			</table>
			<b>&nbsp;</b>
			<table width="584">
			  <tr>
				 <td colspan="3">Dengan ini menyatakan berminat untuk membeli rumah di :</td>
			   </tr>
			   <tr>
				 <td width="177">Perumahan</td>
				 <td width="3">:</td>
				 <td width="388"><?=$_POST['nm_perumh']?></td>
			   </tr>
			   <tr>
				 <td>Type</td>
				 <td>:</td>
				 <td><?=$_POST['tipe']?></td>
			   </tr>
			   <tr>
				 <td>Blok/No. Kapling</td>
				 <td>:</td>
				 <td><?=$_POST['block']?></td>
			   </tr>
			   <tr>
				 <td>Cara Pembayaran</td>
				 <td>:</td>
				 <td><?=$_POST['cara_byr']?></td>
			   </tr>
			 </table>
			 <b>&nbsp;</b>
			 <table border="1">
			   <tbody>
				 <tr>
				   <td width="180">Harga Jual</td>
				   <td width="237">Rp. <?=$_POST['harga']?></td>
				 </tr>
				 <tr>
				   <td>Diskon</td>
				   <td>Rp. <?=$_POST['disc']?></td>
				 </tr>
				 <tr>
				   <td>Cash Back</td>
				   <td>Rp. <?=$_POST['cb']?></td>
			     </tr>
				 <tr>
				   <td>Harga Jual Neto</td>
				   <td>Rp. <?=$_POST['harga_net']?></td>
				 </tr>
				 <tr>
				   <td>Uang Muka </td>
				   <td>Rp. <?=$_POST['um']?></td>
				 </tr>
				 <tr>
				   <td>KPR</td>
				   <td>Rp. <?=$_POST['kpr']?></td>
				 </tr>
			   </tbody>
			 </table>
			 <p><br>
			   <u>Catatan :</u></br>
			 <br>
			* Uang Tanda Jadi berlaku tiga hari sejak ditandatangani pemesanan ini.<br>
			* Pembayaran uang muka pertama Rp.
			<?=$_POST['um1']?>, sisa di angsur <?=$_POST['periode']?> bulan.<br>
			(Jadwal dan besarannya tercantum dalam Perjanjian Pengikatan Jual Beli).
			 <br>
			* Apabila sampai batas waktu diatas tidak ada konfirmasi pembayaran uang muka pertama maka dianggap batal dan Uang Tanda Jadi dinyatakan hangus serta harga tidak mengikat.  </p>
			 <table width="100%" border="1">
			   <tbody>
				<tr>
				  <td align="center"><p>PT. Sidoarjo Bangkit<br>
					Marketing</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>(  ............................................  )</p>
					<p>&nbsp;</p></td>
				  <td align="center"><p>Mengetahui <br>
					Keuangan 
				  </p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>(  ............................................  )</p>
					<p>&nbsp;</p></td>
				  <td align="center"><p>Sidoarjo, 
					<?=$_POST['tb']?>
					<br>
				  </p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>(  ............................................  )</p>
					<p>&nbsp; </p></td>
				</tr>
			  </tbody>
			</table>

			 </p>
			</div>
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
			<div id="garis"></div>
			<center>
			  <br>
			Ruko Deltasari Indah Blok AQ No.4 Waru - Sidoarjo Telp. 031-8545134</center>

									<!-- Inner Container End -->
			</body>
			</html>
<?php
		}
	}
?>

	