<!DOCTYPE html>
<html lang="en">
<head>
  <title>Form Pesanan Barang</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
  // define variables and set to empty values
  $namaErr = $barangErr = $pembayaranErr = $jumlahErr = $tanggalErr = "";
  $nama = $barang = $pembayaran = $jumlah = $tanggal = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // validate nama
    if (empty($_POST["nama"])) {
      $namaErr = "Nama harus diisi";
    } else {
      $nama = test_input($_POST["nama"]);
      // check if nama only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
        $namaErr = "Hanya huruf dan spasi yang diizinkan"; 
      }
    }

    // validate barang
    if (empty($_POST["barang"])) {
      $barangErr = "Minimal dua barang harus dipilih";
    } else {
      $barang = $_POST["barang"];
    }

    // validate pembayaran
    if (empty($_POST["pembayaran"])) {
      $pembayaranErr = "Jenis pembayaran harus dipilih";
    } else {
      $pembayaran = test_input($_POST["pembayaran"]);
    }

    // validate jumlah
    if (empty($_POST["jumlah"])) {
      $jumlahErr = "Jumlah barang harus dipilih";
    } else {
      $jumlah = test_input($_POST["jumlah"]);
    }

    // validate tanggal
    if (empty($_POST["tanggal"])) {
      $tanggalErr = "Tanggal harus diisi";
    } else {
      $tanggal = test_input($_POST["tanggal"]);
    }
    echo nl2br("Pesanan yang harus Dibayar :\n");    
    for ($i=0; $i < count($barang); $i++) { 
      echo $barang[$i];
      echo nl2br(" dengan jumlah ". $jumlah."\n");
    };
    
  }

  // function to clean input data
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

    <div class="container">
        <h2>Form Pesanan Barang</h2>
        <form id="form-pesanan" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
            <label>Jenis Barang:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="barang[]" value="Buku">
                <label class="form-check-label">Buku</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="barang[]" value="Pensil">
                <label class="form-check-label">Pensil</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="barang[]" value="Pulpen">
                <label class="form-check-label">Pulpen</label>
            </div>
            </div>
            <div class="form-group">
            <label>Jenis Pembayaran:</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pembayaran" value="Cash">
                <label class="form-check-label">Cash</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pembayaran" value="Kartu Kredit">
                <label class="form-check-label">Kartu Kredit</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pembayaran" value="Transfer">
                <label class="form-check-label">Transfer</label>
            </div>
            </div>
            <div class="form-group">
            <label for="jumlah">Jumlah Barang:</label>
            <select class="form-control" id="jumlah" name="jumlah">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>    
</body>
</html>

