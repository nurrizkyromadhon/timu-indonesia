<?php
	include "config/koneksi.php";
	function anti_injection($data){
	  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	  return $filter;
	}
	$username = anti_injection($_POST['username']);
	$pass     = anti_injection(md5($_POST['password']));

	// pastikan username dan password adalah berupa huruf atau angka.
	if (!ctype_alnum($username) OR !ctype_alnum($pass)){
		//echo "Sekarang loginnya tidak bisa di injeksi lho.";
		echo "Masukan Username dan Password dengan benar";
	}
	else{
		$login=mysql_query("SELECT * FROM users as u, users_level as ul WHERE u.id_users_level = ul.id_users_level AND u.username='$username' AND u.password='$pass' AND u.blokir='N'");
		$ketemu=mysql_num_rows($login);
		$r=mysql_fetch_array($login);

		// Apabila username dan password ditemukan
		if ($ketemu > 0){
			session_start();
			include "timeout.php";

			$_SESSION['KCFINDER']=array();
			$_SESSION['KCFINDER']['disabled'] = false;
			$_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
			$_SESSION['KCFINDER']['uploadDir'] = "";

			$_SESSION['id_users']	  = $r['id_users'];
			$_SESSION['username']     = $r['username'];
			$_SESSION['namalengkap']  = $r['nama_lengkap'];
			$_SESSION['password']     = $r['password'];
			$_SESSION['leveluser']    = $r['users_level_key'];
			$_SESSION['levelusername']= $r['users_level'];
			$_SESSION['id_users_level']= $r['id_users_level'];

			// session timeout
			$_SESSION[login] = 1;
			timer();

			$sid_lama = session_id();

			session_regenerate_id();

			$sid_baru = session_id();
			mysql_query("UPDATE users SET status_user='1' WHERE id_users='$_SESSION[id_users]'");

			mysql_query("UPDATE users SET id_session='$sid_baru' WHERE id_users='$username'");
			header('location:oklogin.php?module=home');
		}
		else{
			include "error-login.php";
		}
	}
?>
