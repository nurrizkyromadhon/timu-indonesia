<?php
// Menghubungkan ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "coba";
$koneksi = mysqli_connect($host, $user, $password, $database);

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <a href="p062.php">Tambah siswa</a>
    </div>
    <!-- Page Content -->
    <div class="container mt-3" id="tabel">
        <h2>Daftar Siswa</h2>        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>                    
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no=1;
                    $kegiatan = mysqli_query($koneksi, "SELECT * FROM siswa");
                    while ($hslkeg = mysqli_fetch_array($kegiatan)) { ?>
                        <tr>
                            <td><?= $no?></td>
                            <td><?= $hslkeg['nama']?></td>
                            <td><?= $hslkeg['alamat']?></td>                            
                        </tr>
                    
                    <?php
                    $no++;
                    }
                    ?>                
            </tbody>
        </table>
    </div>
</body>
</html>