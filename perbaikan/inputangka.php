<!doctype html>
<html>
	<head>
		<title>Inputan Format Angka</title>
		<script type="text/javascript" src="../bootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="../plugins/jquerymoney/jquery.maskMoney.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#angka1').maskMoney({precision:0});
			$('#angka2').maskMoney({prefix:'US$'});
			$('#angka3').maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
			$('#angka4').maskMoney();
		});
		</script>
	</head>
	<body>
	<form action="" method="post">
		Input angka (default): <input type="text" name="angka1" id="angka1"/>
		<br/>Input angka (US$): <input type="text" name="angka2" id="angka2"/>
		<br/>Input angka (Rp. ): <input type="text" name="angka3" id="angka3"/>
		<br/>Input angka (Rp. ) - HTML5: <input type="text" name="angka4" id="angka4" data-affixes-stay="true" data-prefix="Rp. " data-thousands="." data-decimal="," />
		<br/><input type="submit" name="submit" value="Submit"/>
	</form>
	<?php
	if(isset($_POST['submit'])) {
		echo "<pre>";
		$angka1=str_replace(",","",$_POST['angka1']); ?></br><?
		echo "$angka1";
		print_r($_POST);
		echo "</pre>";
	}
	?>
	</body>
</html>