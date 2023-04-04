<?php
// Menghubungkan ke database
$host = "kprikaryasehat.site";
$username = "kprikary_kuliah";
$password = "unijoyo2020";
$database = "kprikary_resto";
$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal: " . mysqli_connect_error();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Agusti Rahmad Triandana</title>
</head>
<body>
    <div class="container">
        <h2>Modul 3: PHP Database</h2>
        <h4>Tugas Praktikum</h4>
    </div>
    
    <!-- Page Content -->
    <div class="container mt-3" id="tabel">
        <h2>Daftar Menu</h2>
        <form class="form-inline" action="modul3.php" method="get">
            <div class="form-group mb-2">
                <label for="Pencarian">Pencarian :</label>            
            </div>
            <div class="form-group mx-sm-3 mb-2">            
                <input type="text" class="form-control" placeholder="Masukkkan kata yang diinginkan" name="cari" id="cari" value="<?php if(isset($_GET['cari'])) { echo $_GET['cari']; } ?>">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </form>        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>                    
                    <th>Kategori</th>                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no=1;
                    $batas = 10;
                    $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
                    $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	
    
                    $previous = $halaman - 1;
                    $next = $halaman + 1;
                    
                    $data = mysqli_query($koneksi,"select * from menu1");
                    $jumlah_data = mysqli_num_rows($data);
                    $total_halaman = ceil($jumlah_data / $batas);
    
                    if(isset($_GET['cari'])){
                        $cari = $_GET['cari'];
                        $data_menu = mysqli_query($koneksi,"select * from menu1 where nama like '%".$cari."%' or harga like '%".$cari."%' or kategori like '%".$cari."%' limit $halaman_awal, $batas");				
                    }else{
                        $data_menu = mysqli_query($koneksi,"select * from menu1 limit $halaman_awal, $batas");		
                    }                    
                    $nomor = $halaman_awal+1;
                    $menu = mysqli_query($koneksi, "SELECT * FROM menu1");
                    while ($hsl_menu = mysqli_fetch_array($data_menu)) { ?>
                        <tr>
                            <td><?= $nomor++?></td>
                            <td><?= $hsl_menu['nama']?></td>
                            <td><?= $hsl_menu['harga']?></td>                            
                            <td><?= $hsl_menu['kategori']?></td>                            
                        </tr>
                    
                    <?php
                    $no++;
                    }
                    ?>                
            </tbody>
        </table>
        <nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item">
					<a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				</li>
			</ul>
		</nav>
    </div>
</body>
</html>