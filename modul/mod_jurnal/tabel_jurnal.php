<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";
	    ?>
	        <html>
                <head>
                    <meta charset="utf-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<!-- Bootstrap 3.3.6 -->
					<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
					<!-- Font Awesome -->
					<link rel="stylesheet" href="../../bootstrap/font-awesome/css/font-awesome.min.css">
					<!-- DataTables -->
					<link rel="stylesheet" href="../../plugins/datatables/dataTables.bootstrap.css">

					<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
					<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
					<!--[if lt IE 9]>
					<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
					<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
					<![endif]-->
					<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
					<!-- jQuery UI 1.11.4 -->
					<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
					<!-- Bootstrap 3.3.6 -->
					<script src="../../bootstrap/js/bootstrap.min.js"></script>
					<!-- DataTables -->
					<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
					<script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
                    <script type="text/javascript">
                    	function insertopr(nm_perkiraan) {
                    		window.close();
                    		window.opener.document.getElementById('nm_perkiraan<?=$_GET['idrow']?>').value = nm_perkiraan;
                    	}
                    	$(document).ready(function(){
                        	$('#myTable').dataTable();
                        });
                    </script>
                    <style>
                        body {
                            padding : 10px;
                        }
                    </style>
                </head>
                
                
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        	<th height="47">No</th>
                            <th>Kode Perkiraan</th>
                            <th>Nama Perkiraan</th>
                            <th>Saldo Awal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=1;
                            $qry=mysql_query("select *, length(kode_perkiraan)as jml from perkiraan order by id_perkiraan asc");
                            while ($hasil=mysql_fetch_array($qry)){
                                $kode_perkiraan=$hasil['kode_perkiraan'];
                                $nm_perkiraan=$hasil['nm_perkiraan'];
                                $saldo_awal=$hasil['saldo_awal'];
                                
                                   if ($hasil['jml']==12){
						?>
                                    <tr>
                                        <td align="center"><?=$no?></td>
                                        <td align="left"><?=$kode_perkiraan?></td>
                                        <td align="left"><?=$nm_perkiraan?></td>
                                        <td align="left"><?=$saldo_awal?></td>
                                        <td align="left"><a class="btn btn-primary btn-sm" href="javascript:insertopr('<?=$nm_perkiraan?>').innerHTML" ><span class="fa fa-plus"></a></td>
                                    </tr>
                                    
                                <?php
								   }
                                $no++ ; 
                            }
                        ?>
                    </tbody>
                </table>
            </html>
        <?php
	}
?>