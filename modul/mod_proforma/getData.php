<?php
    session_start();
    if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
        echo "<link href='style.css' rel='stylesheet' type='text/css'>
        <center>Untuk mengakses modul, Anda harus login <br>";
        echo "<a href=../../index.php><b>LOGIN</b></a></center>";
    }
    else{
		include "../../config/koneksi.php";
        $act=$_GET['act'];

        if ($act=='auto' && isset($_GET["nm_cust"]) && isset($_GET["shipment"])) {
            $cust_name =  $_GET["nm_cust"];
            $shipment = $_GET["shipment"];
            $rows = array();

            // Query Proforma
            $query=mysql_query("SELECT * FROM pf_log WHERE cust_name='$cust_name' AND shipment='$shipment' ORDER BY id_pf DESC") or die (mysql_error());
            $hasil = mysql_fetch_assoc($query);
            $id_pf = $hasil['id_pf'];
            $id_pf_log = $hasil['id_pf_log'];
            $rows['pf'] = $hasil;
            
            if ($id_pf != 0) {
                // Query Revenue
                $sth = mysql_query("SELECT * FROM pf_revenue WHERE id_pf='$id_pf'");
                while($r = mysql_fetch_assoc($sth)) {
                    $rows['rev'][] = $r;
                }

                // Query Cost
                $ste = mysql_query("SELECT * FROM pf_est_cost WHERE id_pf='$id_pf'");
                while($s = mysql_fetch_assoc($ste)) {
                    $rows['cost'][] = $s;
                }
            }
            echo json_encode($rows);
            //Query Cost
            
            exit();
        }
        if ($act=='submit') {
            ob_start();
            $exist = 'n';
            $data = $_GET["data"];

            for($x=0; $x < count($data); $x++) {
                $cust_name = $data[$x]['cust_name'];
                $shipment=$data[$x]['shipment'];
                $type_rev=$data[$x]['type_rev'];
                $desc_rev=$data[$x]['desc_rev'];
                $queryRate=mysql_query("SELECT * FROM ct_rev_rate WHERE cust_name='$cust_name' AND shipment='$shipment' AND type_rev='$type_rev' AND desc_rev='$desc_rev'")  or die (mysql_error());
                if (mysql_num_rows($queryRate) != 0) {
                    $exist = 'y';
                    break;
                }
			}
            $arr = array('exist' => $exist);
            ob_end_clean();
            echo json_encode($arr);
            exit();
        }
        if ($act == 'auto_ru') {
            $nm_cust =  $_GET["nm_cust"];            
            $query=mysql_query("SELECT * FROM data_cust WHERE nm_cust='$nm_cust'") or die (mysql_error());
            $hasil = mysql_fetch_array($query);
            echo json_encode($hasil);
            exit();
        }
        if ($act=='auto_rate') {
            ob_start();
            $exist = 'n';
            $data = $_GET["data"];

            for($x=0; $x < count($data); $x++) {
                $cust_name = $data[$x]['cust_name'];
                $shipment=$data[$x]['shipment'];
                $type_rev=$data[$x]['type_rev'];
                $desc_rev=$data[$x]['desc_rev'];
                $queryRate=mysql_query("SELECT * FROM ct_rev_rate WHERE cust_name='$cust_name' AND shipment='$shipment' AND type_rev='$type_rev' AND desc_rev='$desc_rev'")  or die (mysql_error());
                if (mysql_num_rows($queryRate) != 0) {
                    $exist = 'y';
                    break;
                }
			}
            $arr = array('exist' => $exist);
            ob_end_clean();
            echo json_encode($arr);
            exit();
        }
    }
?>