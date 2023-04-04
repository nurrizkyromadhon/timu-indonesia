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
		$datenow=date('Y-m-d');
		
		// Save Terjual Excel
		if ($module=='hut_user' AND $act=='input'){
			$cara_bayar=$_POST['cara_bayar'];
			$angsuran=$_POST['angsuran_ke'];
			$keterangan="$cara_bayar  Angsuran Ke  $angsuran";
			$bayar=str_replace(',','',$_POST['bayar']);
			
			mysql_query("insert into hut_user (id_nasabah,id_buyer,tgl_transaksi,referensi,ket,terbayar) value ('$_POST[id_nasabah]','$_POST[id_buyer]','$_POST[tgl_transaksi]','$_POST[referensi]','$keterangan','$bayar')") or die(mysql_error());
			
			header("location:../../oklogin.php?module=$module&act=tambah&id=$_POST[id_nasabah]");
		}
		elseif ($module=='hut_user' AND $act=='update'){
			$id_hutang=$_POST['id_hutang'];
			$hutang=$_POST['hutang'];
			mysql_query("update hut_user set hutang='$hutang' where id_hutang='$id_hutang'");
			
			header("location:../../oklogin.php?module=$module");
		}
		elseif ($module=='hut_user' AND $act=='lunas'){
		    
			/*$x=0;
			$id_nasabah=$_POST['cek'];
			echo "$id_nasabah";
			break;
			for($x=0; $x < count($id_nasabah); $x++) {
				mysql_query("update hut_user set status='lunas' where id_nasabah='$id_nasabah[$x]'");
			}*/
			
			foreach($_POST['cek'] as $item){
			    $query=mysql_query("select * from hut_user where id_hutang='$item'");
			    $hasil=mysql_fetch_array($query);
			    $id_buyer=$hasil['id_buyer'];
                mysql_query("update hut_user set status='lunas' where id_buyer='$id_buyer'");
               
              echo $item ."<br/>";
              echo $id_buyer ."<br/>";
            }
            
			header("location:../../oklogin.php?module=$module");	
		}
		// Save Kosong Excel
		elseif ($module=='hut_user' AND $act=='save_rekap'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=rekap_hutang($datenow).xls");
?>			
									  <table border="1">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>Referensi</th>
										  <th>TANGGAL</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>KETERANGAN</th>
										  <th>HUTANG USER</th>
										  <th>BAYAR</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select *, h.ket as keterangan from hut_user as h
										join nasabah as n on h.id_nasabah=n.id_nasabah
										join profil_buyer as pb on h.id_buyer=pb.id_buyer
										order by nama_user asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['referensi']?></td>
											<td><?=$hasil['tgl_transaksi']?></td>
											<td><?=$hasil['coord']?></td>
											<td><?=$hasil['nm_buyer']?></td>
											<td><?=$hasil['keterangan']?></td>
											<td><?=$hasil['hutang']?></td>
											<td><?=$hasil['terbayar']?></td>
										  </tr>
										  
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
<?php									

		}
		
		// Save Kosong Excel
		elseif ($module=='home' AND $act=='save_all'){
			
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=laporan_user($date).xls");
?>
								<table border="1">
									  <thead>
									  <tr>
										  <th>NO</th>
										  <th>BLOK</th>
										  <th>NAMA USER</th>
										  <th>TYPE</th>
										  <th>FPR</th>
										  <th>PPJB</th>
										  <th>OB</th>
										  <th>HARGA JUAL</th>
										  <th>KPR</th>
										  <th>UM</th>
									  </tr> 
									  </thead>
									  <tbody>
									  <?php
										$no=1;
										$query="select * from nasabah as n
										join coord as c on n.id_cord=c.id_coord 
										join indikasi as i on n.id_indikasi=i.id_indikasi
										join profil as p on n.id_profil=p.id_profil
										order by n.id_cord asc";
										$qry=mysql_query($query) or die(mysql_error());
										while ($hasil=mysql_fetch_array($qry)){		
									  ?>
										  <tr>
											<td><?=$no?></td>
											<td><?=$hasil['block']?></td>
											<td><?=$hasil['nama_user']?></td>
											<td><?=$hasil['type_rumah']?></td>
											<td><?=$hasil['fpr']?></td>
											<td><?=$hasil['ppjb']?></td>
											<td><?=$hasil['ob']?></td>
											<td><?=$hasil['harga_jual']?></td>
											<td><?=$hasil['kpr']?></td>
											<td><?=$hasil['um']?></td>
										  </tr>
									  <?php
										$no++; } 
									  ?>
									  </tbody>
									</table>
<?php			
		}

		// Update user
		elseif ($module=='userslevel' AND $act=='hapus'){
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_GET['id']);
			mysql_query("DELETE FROM users_level WHERE  id_users_level = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
	}
?>
