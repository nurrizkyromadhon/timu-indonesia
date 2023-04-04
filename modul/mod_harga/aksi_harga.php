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
		$user=$_SESSION['username'];


		// Input user
		if ($module=='harga' AND $act=='input'){
			$id_coord=$_POST['id_coord'];
			$harga=str_replace(",","",$_POST['harga']);
			$disc=str_replace(",","",$_POST['disc']);
			$net=str_replace(",","",$_POST['net']);
			$um=str_replace(",","",$_POST['um']);
			$kpr=str_replace(",","",$_POST['kpr']);
			$lima=str_replace(",","",$_POST['lima']);
			$sepuluh=str_replace(",","",$_POST['sepuluh']);
			$limabelas=str_replace(",","",$_POST['limabelas']);
			
			//1. inssert /input pada tabel harga
			$sql="insert into harga (id_coord,no_blok,tipe,harga,disc,harga_net,um,kpr,5th,10th,15th,ket) value ('$id_coord','$_POST[block]','$_POST[tipe]','$harga','$disc','$net','$um','$kpr','$lima','$sepuluh','$limabelas','$_POST[ket]')";
			$res=mysql_query($sql) or die (mysql_error());
			
			//2. Mencari variable id_harga untuk update id_harga pada table nasabah
			$query=mysql_query("select * from harga where id_coord='$id_coord'");
			$hasil=mysql_fetch_array($query);
			$id_harga=$hasil['id_harga'];
			
			//3. update id_harga pada table nasabah
			mysql_query("update nasabah set id_harga='$id_harga' where id_coord='$id_coord'");
			
			header('location:../../oklogin.php?module='.$module);
		}
		// Edit user
		elseif ($module=='harga' AND $act=='edit'){
			$id_coord=$_POST['id_coord'];
			$id_harga=$_POST['id_harga'];
			$harga=str_replace(",","",$_POST['harga']);
			$disc=str_replace(",","",$_POST['disc']);
			$cashback=str_replace(",","",$_POST['cb']);
			$net=str_replace(",","",$_POST['net']);
			$um=str_replace(",","",$_POST['um']);
			$kpr=str_replace(",","",$_POST['kpr']);
			$lima=str_replace(",","",$_POST['lima']);
			$sepuluh=str_replace(",","",$_POST['sepuluh']);
			$limabelas=str_replace(",","",$_POST['limabelas']);
				
			mysql_query("UPDATE harga SET id_coord = '$id_coord', no_blok = '$_POST[block]', tipe = '$_POST[tipe]', harga = '$harga', disc = '$disc', cashback='$cashback', harga_net = '$net', um = '$um', kpr='$kpr', 5th='$lima', 10th='$sepuluh', 15th='$limabelas', ket='$_POST[ket]'
			WHERE id_harga = '$id_harga'");
												 
										
			mysql_query("DELETE FROM permission WHERE  id_users_level = " .$_POST['id']);
			$id_modul = $_POST['id_modul'];
			
			for($x=0; $x < count($id_modul); $x++) {
				$query = "INSERT INTO permission (id_users_level, id_modul)
				VALUES($_POST[id], '$id_modul[$x]')";
				$sql = mysql_query ($query) or die (mysql_error());
			}
			
			header('location:../../oklogin.php?module='.$module);
		}

		// Hapus user
		elseif ($module=='harga' AND $act=='hapus'){
			mysql_query("DELETE FROM harga WHERE  id_harga = " .$_GET['id']);
			header('location:../../oklogin.php?module='.$module);
		}
		// print to excel
		elseif ($module=='harga' AND $act=='save_to_excel'){
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Harga($date).xls");
		?>
			<table border="1">
			  	<thead>
				  <tr align="center">
					<th>No</th>
					<th>Type</th>
					<th>Kavling</th>
					<th>Harga Jual</th>
					<th>Discount</th>
					<th>Cash Back</th>
					<th>Harga Netto</th>
					<th>Uang Muka</th>
					<th>KPR</th>
					<th>5th</th>
					<th>10th</th>
					<th>15th</th>
				  </tr>
			    </thead>
			   <tbody>
				  <?php
					  $no=1;
					  $query="select * from harga where ket!='Terjual' and ket !='KAVLING KHUSUS /NON STANDART' order by no_blok";
					  $qry=mysql_query($query);
					  while ($hasil=mysql_fetch_array($qry)){
					  $type=$hasil['tipe'];
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
					  $blok=$hasil['no_blok'];
				  ?>
				<tr>
					<td  class="td1"><?=$no?></td>
					<td  class="td1"><?=$type?></td>
					<td  class="td1"><?=$no_blok?></td>
					<td  class="td1"><?=$harga?></td>
					<td  class="td1"><?=$disc?></td>
					<td  class="td1"><?=$cashback?></td>
					<td  class="td1"><?=$harga_net?></td>
					<td  class="td1"><?=$um?></td>
					<td  class="td1"><?=$kpr?></td>
					<td  class="td1"><?=$lima?></td>
					<td  class="td1"><?=$sepuluh?></td>
					<td  class="td1"><?=$limabelas?></td>

				</tr>
			<? $no++; } ?>
			</tbody>  
		</table>	
		<?php	
			//header('location:../../oklogin.php?module='.$module);
		}
				// print to excel
		elseif ($module=='harga' AND $act=='save_to_excel2'){
			header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=HrgKavNonStandart($date).xls");
		?>
		<table border="1">
			<thead>
				<tr align="center">
					<th>No</th>
					<th>Type</th>
					<th>Kavling</th>
					<th>Harga Jual</th>
					<th>Discount</th>
					<th>Cash Back</th>
					<th>Harga Netto</th>
					<th>Uang Muka</th>
					<th>KPR</th>
					<th>5th</th>
					<th>10th</th>
					<th>15th</th>
				</tr>
			</thead>
		<tbody>
		<?php
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
				$blok=$hasil['no_blok'];

			?>
			<tr>
				<td  class="td1"><?=$no?></td>
				<td  class="td1"><?=$tipe?></td>
				<td  class="td1"><?=$no_blok?></td>
				<td  class="td1"><?=$harga?></td>
				<td  class="td1"><?=$disc?></td>
				<td  class="td1"><?=$cashback?></td>
				<td  class="td1"><?=$harga_net?></td>
				<td  class="td1"><?=$um?></td>
				<td  class="td1"><?=$kpr?></td>
				<td  class="td1"><?=$lima?></td>
				<td  class="td1"><?=$sepuluh?></td>
				<td  class="td1"><?=$limabelas?></td>
			</tr>
			<? $no++; } ?>
		</tbody>  
	</table>
		<?php
		}
	}
?>
