<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";
		$date=date('Y-m-d');
		$module="aproval_kas";
		if ($_GET['submit']=="submit") {
		    $aproval="$_SESSION[username]";
			//update nasabah status cek = OK
			echo "$_SESSION[username]";
	
            foreach($_GET['cek_item'] as $item){
                mysql_query("update jurnal set aproval='$aproval' where no_ref='$item'");
             // echo $item ."<br/>";
			}
		
			header('location:../../oklogin.php?module='.$module);
		}
		else if ($_GET['batal']=='submit') {
			
			foreach($_GET['cek_item'] as $item){
                mysql_query("update jurnal set aproval='' where no_ref='$item'");
             // echo $item ."<br/>";
			}
		
			header('location:../../oklogin.php?module='.$module);
		}
		// Prin FPR
		else if ($module=='aproval_kas' AND $act=='print'){
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

	