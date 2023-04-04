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
  <div class="container" id="form">
        <h2>Tambah Siswa</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Siswa" name="nama" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" class="form-control" id="alamat" placeholder="Masukkan Alamat Siswa" name="alamat" required>
            </div>           
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <?php    
      if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $query = "INSERT INTO siswa set nama='$nama',alamat='$alamat'";
        mysqli_query($koneksi, $query);
        echo "<script type='text/javascript'>alert('Berhasil');</script>";
        header('location:p06.php');
      }
    ?>
</body>
</html>