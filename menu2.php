<?php
	include "config/koneksi.php";
?>
<ul class="sidebar-menu">
	<li class="header">MAIN NAVIGATION</li> 
    <li <?php if($_GET['module'] == 'home') { echo 'class="active"'; } ?>>
        <a href="?module=home"><i class='fa fa-dashboard'></i> <span>Home</span></a>
    </li>

	<?php
		$main = mysql_query("SELECT * FROM mainmenu WHERE aktif = 'Y' order by nama_menu asc");
		while($r = mysql_fetch_array($main)) {
			if(empty($r['link'])){
				$flag = false;
				$flag2 = true;
				$sub = mysql_query("SELECT * FROM submenu, mainmenu WHERE submenu.id_main = mainmenu.id_main AND submenu.id_main = $r[id_main] AND submenu.aktif='Y' order by submenu.nama_sub asc") ;
				$jml = mysql_num_rows($sub);
				// apabila sub menu ditemukan
				if($jml > 0) {
					while($w=mysql_fetch_array($sub)){
						if($w['link_sub'] == '?module='.$_GET['module']) { 
							$flag = true;
						}
						$check = mysql_query("SELECT m.key_modul FROM permission as p, users_level as ul, modul as m WHERE p.id_users_level = ul.id_users_level AND p.id_modul = m.id_modul AND p.id_users_level = ".$_SESSION['id_users_level']);
						while($c=mysql_fetch_array($check)){
							if($w['link_sub'] == '?module='.$c['key_modul']) { 
								$flag2 = false;
							}
						}
					}
				}
				if($flag2) {
					continue;
				}
				?>
					<li class="treeview <?php if($flag) { echo 'active'; } ?>">
						<a href="#">
							<i class="fa <?=$r['icon']?>"></i>
							<span><?=$r['nama_menu']?></span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
				<?php
			}else {
				$check = mysql_query("SELECT m.key_modul FROM permission as p, users_level as ul, modul as m WHERE p.id_users_level = ul.id_users_level AND p.id_modul = m.id_modul AND p.id_users_level = ".$_SESSION['id_users_level']);
				while($c=mysql_fetch_array($check)){
					if($r['link'] == '?module='.$c['key_modul']) { 
						?>
							<li <?php if($r['link'] == '?module='.$_GET['module']) { echo 'class="active"'; } ?>><a href="<?=$r['link']?>"><i class="fa <?=$r['icon']?>"></i> <span><?=$r['nama_menu']?></span></a>
						<?php
					}
				}
			}
			
			$sub = mysql_query("SELECT * FROM submenu, mainmenu WHERE submenu.id_main = mainmenu.id_main AND submenu.id_main = $r[id_main] AND submenu.aktif='Y'");
			$jml = mysql_num_rows($sub);
			// apabila sub menu ditemukan
			if($jml > 0) {
				?>
					<ul class="treeview-menu">
						<?php
							while($w=mysql_fetch_array($sub)){								
								$check = mysql_query("SELECT m.key_modul FROM permission as p, users_level as ul, modul as m WHERE p.id_users_level = ul.id_users_level AND p.id_modul = m.id_modul AND p.id_users_level = ".$_SESSION['id_users_level']);
								while($c=mysql_fetch_array($check)){
									if($w['link_sub'] == '?module='.$c['key_modul']) { 
										?>
											<li <?php if($w['link_sub'] == '?module='.$_GET['module']) { echo 'class="active"'; } ?>>
												<a href="<?=$w['link_sub']?>"> <i class="fa fa-circle-o"></i> <span><?=$w['nama_sub']?></span></a>
											</li>
										<?php
									}
								}
							}
						?>
					</ul>
				<?php
			}
			?>
				</li>
			<?php
		}
	?>
</ul>
