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
		$id_nasabah=$_POST['id_nasabah'];

		// Input user
		if ($module=='batal' AND $act=='batal'){
			
			// 1. mencari baris pada id nasabah
			$query=(mysql_query("select * from nasabah where id_nasabah = '$id_nasabah'"));
			$hasil=mysql_fetch_array($query);
			$id_harga=$hasil['id_harga'];
			$id_buyer=$hasil['id_buyer'];
			
			//3. insert / input pada tabel batal
			mysql_query("insert into batal (tgl_batal,no_batal,id_buyer,ket) value ('$_POST[tgl]','$_POST[no_batal]','$id_buyer','$_POST[ket_batal]') ");
			
			//4. mengambil id_batal untuk di inputkan pada database profil_buyer
			$query2=(mysql_query("select * from batal order by id_batal DESC LIMIT 1 "));
			$hasil2=mysql_fetch_array($query2);
			$id_batal=$hasil2['id_batal'];
			
			//5. update keterangan Batal Pada profil buyer
			mysql_query("update profil_buyer set id_batal='$id_batal',ket='Batal' where id_buyer='$id_buyer'");
				
			// 6. mengupdate table nasabah dimana terdatpat semua kavling di dalamnya 	
			mysql_query("update nasabah set id_indikasi='1', id_harga='', tgl_beli='', nama_user='', harga_jual='' ,um='',  kpr='', periode='', marketing='', ket='', fpr='', disc='', cb='', tgl_um1='', um1='' where  id_nasabah='$id_nasabah'");

			// 7. Merubah keteranga di table harga untuk terjual untuk filter harga yg blom terjual		
			mysql_query("update harga set status='' where id_harga='$id_harga'");
			
			//8. update statis batal pada hut_user
			mysql_query("update hut_user set status='batal' where id_nasabah='$id_nasabah'");
		
			//6. inputan pertama / baru pada hut_user 
			//$um=str_replace(',','',$_POST['um']);
			//mysql_query("insert into hut_user (id_nasabah,tgl_transaksi,referensi,ket,hutang) value ('$id_nasabah','$_POST[tgl_beli]','$_POST[no_fpr]',$_POST[ket]','$um')") or die(mysql_error());
			
			//7. input tanda jadi 
			//$tj=str_replace(',','',$_POST['tj']);			
			//mysql_query("insert into hut_user (id_nasabah,tgl_transaksi,referensi,ket,terbayar) value
			//('$id_nasabah','$_POST[tgl_beli]','$_POST[no_kw]','Pembayaran Tanda Jadi','$tj')")or die(mysql_error());
			 

			
			$last_id = mysql_insert_id();
			$id_modul = $_POST['id_modul'];
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($last_id, '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='userslevel' AND $act=='update'){
			mysql_query("UPDATE users_level SET users_level   		= '$_POST[users_level]',
												users_level_key   	= '$_POST[users_level_key]' 
										WHERE  id_users_level  	= '$_POST[id]'");
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_POST['id']);
			$id_modul = $_POST['id_modul'];
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($_POST[id], '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			header('location:../../oklogin.php?module='.$module);
		}

		// Update user
		elseif ($module=='userslevel' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM users_level WHERE  id_users_level = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
