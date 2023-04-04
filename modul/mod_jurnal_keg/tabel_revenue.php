<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";
        $hari_ini = date("Y-m-d H:i:s");
        if (empty($_POST['tgl_aw'])){
            $tgl_aw= date('Y-m-01', strtotime($hari_ini. ' - 1 months'));
            $tgl_ak= date('Y-m-t', strtotime($hari_ini));

            $tgl_aw_str=date('01-M-Y',strtotime($tgl_aw));
            $tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));

        } else {
            $tgl_aw=$_POST['tgl_aw'];
            $tgl_ak=$_POST['tgl_ak'];
            
            $tgl_aw_str=date('d-M-Y',strtotime($tgl_aw));
            $tgl_ak_str=date('d-M-Y',strtotime($tgl_ak));
        }
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
                    	function insertopr(id_pf_revenue) {
                    		window.close();
                    		window.opener.document.getElementById('id_pf_revenue<?=$_GET['idrow']?>').value = id_pf_revenue;
                    	}
                    </script>
                    <style>
                        body {
                            padding : 10px;
                        }
                    </style>
                </head>
                <label>TANGGAL</label>
                <form name="submit" action="?module=jurnal_keu2&idrow=<?=$_GET['idrow']?>" method="POST" class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <input class="form-control" type="date" name="tgl_aw">
                    </div>
                    
                    <div class="col-md-2">
                        <h5>Sampai : </h5>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control" type="date" name="tgl_ak">
                    </div>
                    
                    <div class="col-md-1">
                        <button class="pull-right btn bg-gray text-blue text-bold" type="submit">OK</button>
                    </div>
                </form>
                <h4 class="box-title"><b class="text-blue">Tabel Job Order</b></h4>
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        	<th>NO</th>
                            <th>NO JO</th>
                            <th>ACT</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no=1;
                            $qry=mysql_query("SELECT * from pf_log order by no_jo DESC");
                            while($hasil=mysql_fetch_array($qry)){
                                $id_pf_log = $hasil['id_pf_log'];
                                $no_jo=$hasil['no_jo'];
						?>
                                    <tr>
                                        <td align="center"><?=$no?></td>
                                        <td align="center"><?=$no_jo?></td>
                                        <td align="left"><a class="btn btn-primary btn-sm" href="javascript:insertopr('<?=$hasil['id_pf_log']?>').innerHTML" ><span class="fa fa-plus"></a></td>
                                          
                                    </tr>
                                    
                                <?php
								$no++ ;  
                            }
                        ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function(){
                        $('#myTable').dataTable();
                    });
                </script>
            </html>
        <?php
	}
?>