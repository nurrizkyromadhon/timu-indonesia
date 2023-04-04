<?php
	session_start();
	if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
		echo "<link href='style.css' rel='stylesheet' type='text/css'>
		<center>Untuk mengakses modul, Anda harus login <br>";
		echo "<a href=../../index.php><b>LOGIN</b></a></center>";
	}
	else{
		include "../../config/koneksi.php";

		$module=$_GET['module'];
		$act=$_GET['act'];
		$date=date('Y-m-d');

		if ($module=='ppjb' AND $act=='print'){
		    
			?>
			
			<html>
			<head>
			<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
            <img src="../../images/nm_perush/logo/logo.jpg" width="100%" height="93">
            
			<style type="text/css">
			@page {
			size: Legal;
			size: portrait; 
			margin: 5mm 5mm 5mm;
			font-size:13px;
			
			}
				#marginkiri{
				margin:10mm 10mm 5mm 20mm;
				    
				}

			
				#garis{
				border-top: 1px solid #afbcc6;
				border-bottom: 1px solid #eff2f6;
				height: 0px;
				}
			</style> 
			<!-- <style type="text/css">
    			@page {
    			  size: legal;
    			  size: portrait; 
    			  margin: 10mm 20mm;
    			}
    			@media print {
    				html, body {
    					height: 297mm !important;
	    				width: 210mm !important;
	    				window.print();
    				}
    				table th, table td {
    					border:1px solid #000;
    					margin:0mm;
    				}
    				table { page-break-inside:auto }
    				tr    { page-break-inside:avoid; page-break-after:auto }
    				thead { display:table-header-group }
    				.akhir {page-break-after: always;}
    			}
        			.container, .container table {
        				width:100%;
        			}
        			.container table tr, .container table tr td, .container table tr th, .container table {
        				margin:0px !important;
        			}
    		</style>-->

			</head>
			<body>
			<div class="print">    
			<div class="page">
			<div id="marginkiri"> 
			<p align="center"><strong><u>PERJANJIAN PENGIKATAN JUAL BELI</u><br>
NO	:  PPJB-665/FPR-785/ SB /IV/ 2019</strong></p>

<p>Pada hari  ini, Kamis Tanggal 02 Mei 2019 , Kami yang bertanda tangan dibawah ini :
  
</p>
<p>Nama		:	Moch Yufi Amrozi
  
</p>
<p>Jabatan		:	Manager Operasional
  
</p>
<p>Alamat:		:	Ruko Deltasari Aq No.04, Waru ,  Sidoarjo
  
</p>
<p>Dalam hal ini bertindak untuk dan atas nama PT.SIDOARJO BANGKIT untuk selanjutnya dalam perjanjian ini disebut  sebagai PIHAK PERTAMA.
  
</p>
<p>Nama		:  	Tri Idayati
  
  NO KTP/SIM	:  	351518490260001
  
</p>
<p>Pekerjaan	: 	Swasta
  
</p>
<p>Alamat		: 	 Taman Pondok Legi RT/RW 007/0008  Sidoarjo
  
  Telepon		: 	08123276373
  
</p>
<p>Dalam hal ini bertindak untuk dan atas nama sendiri,untuk selanjutnya dalam perjanjian ini disebut sebagai PIHAK KEDUA.
  
  Terlebih dahulu kami kedua belah pihak menerangkan bahwa,  PIHAK PERTAMA adalah badan usaha yang bergerak dalam bidang pembangunan/pengadaan unit rumah, beserta fasilitas yang ada di Perumahan GRAND ALOHA REGENCY, dengan lokasi yang terletak di Desa Wage ,Kecamatan Taman, Kabupaten Sidoarjo.
  Selanjutnya PIHAK PERTAMA bermaksud hendak menjual tanah dan bangunan ,yang menjadi obyek usahanya kepada PIHAK KEDUA dan PIHAK KEDUA bermaksud hendak membelinya dari PIHAK PERTAMA. Lebih lanjut kedua belah pihak telah bersepakat mengadakan perjanjian pengikatan untuk jual beli ( selanjutnya disebut perjanjian ) , atas tanah dan bangunan dengan ketentuan-ketentuan sebagai berikut:
</p>
<p align="center"><strong>Pasal 1<br>
</strong><strong> POKOK PERJANJIAN  </strong></p>
<p> unit rumah yang dibangun oleh PIHAK PERTAMA berikut tanahnya merupakan obyek perjanjian pengikatan untuk jual beli adalah :</p>
<p> Luas Bangunan		: 	70  </p>
<p>Luas Tanah		: 	135  </p>
<p>Blok         	: 	A1 - 04  </p>
<p>No. FPR			:  	000785  </p>
<p align="center"><strong>Pasal 2<br>
</strong><strong>HARGA JUAL BELI  TANAH DAN BANGUNAN </strong></p>
<p>Harga Pengikatan				: Rp. 963.600.000,-  </p>
<p>Cash Back				: (Rp.  15.000.000),-  </p>
<p>Diskon Tunai				: (Rp.  21.559.090),-  </p>
<p>Biaya Notaris				: (Rp.    3.000.000),-  </p>
<p>Harga Jual Netto				: Rp. 924.040.910,- ( Inclusive PPN )  </p>
<p>Jadi Harga jual Netto sebesar ( Sembilan Ratus Dua Puluh Empat Juta Empat Puluh Ribu Sembilan Ratus Sepuluh Rupiah ) , inclusive PPN.
  Jika dalam pengukuran luas tanah ternyata luas tanah tersebut lebih atau kurang ,maka perhitungan harga jual beli tanah dan Bangunan diperhitungkan ulang sesuai harga jual yang telah disepakati.  </p>
<p>Harga tersebut sudah termasuk  :  Biaya PPAT/ BBN , Sertifikat  SHM , IMB, PLN 1300 Watt, Sumur Bor
  Pompa Listrik , PPN dan Pajak lain yang ditentukan Pemerintah</p>
<p> Harga tersebut belum termasuk  : Biaya KPR dan  BPHTB.  </p>
<p align="center"><strong>Pasal 3  </strong><br>
<strong>JAMINAN PIHAK PERTAMA</strong></p>
  
<p>PIHAK PERTAMA menjamin bahwa apa yang dijual dalam perjanjian ini benar milik PIHAK PERTAMA, tidak tersangkut dalam suatu perkara/sengketa.  </p>
<p align="center"><strong>Pasal 4  </strong><br>
<strong>CARA PEMBAYARAN</strong></p>
  	
<p>1. PIHAK KEDUA  menyatakan  bersedia membayar Uang  Muka / pelunasan Harga jual,  sebesar         Rp  927.040.910,- ( Sembilan Ratus Dua Puluh Tujuh Juta Empat Puluh Ribu Sembilan Ratus Sepuluh Rupiah ) dengan jadwal sebagai berikut:  </p>
<p>Tanggal	Pembayaran	Jumlah	Keterangan  </p>
<p>04 Maret 2019	Booking Fee	Rp          5.000.000,-	ADMINISTRASI  </p>
<p>25 April 2019	UM ke I	Rp      116.813.637.,-  </p>
<p>26 April 2019	UM ke II	Rp      400.000.000.,-  </p>
<p>30 April 2019	UM ke III	Rp      405.227.273.,-  </p>
<p>2. Pembayaran dapat dilakukan secara Tunai di kantor PT.SIDOARJO BANGKIT,  atau melalui bank yang ditunjuk oleh PIHAK PERTAMA.Sebagai bukti pembayaran berlaku kwitansi dari PIHAK PERTAMA yang secara sah ditanda tangani oleh PIHAK PERTAMA.Apabila pembayaran dilakukan dengan cek/giro atau sejenisnya, pembayaran dianggap sah setelah cek/giro atau sejenisnya dapat diuangkan atau dicairkan dengan baik.  </p>
<p align="center"><strong>Pasal 5</strong><br>
<strong> SANKSI-SANKSI PEMBAYARAN</strong></p>
<p> 1.	Jika PIHAK KEDUA tidak melakukan pembayaran angsuran menurut jadwal yang telah disepakati bersama, maka PIHAK KEDUA bersedia dikenakan denda keterlambatan 10/00 ( satu permil perhari), setiap hari keterlambatan sejak jatuh tempo yang harus dibayar oleh PIHAK KEDUA  </p>
<p>2.	Apabila PIHAK KEDUA dalam waktu 2 bulan dua kali berturut-turut belum ada pembayaran uang muka dan PIHAK PERTAMA juga telah mengirimkan Surat Pemberitahuan dua kali berturut-turut tetap tidak ada pembayaran , maka  PIHAK KEDUA telah menyatakan dan menyetujui untuk membatalkan Pemesanan Pembelian rumah dengan demikian uang yang telah diterima oleh PIHAK PERTAMA ( Kecuali uang tanda jadi atau booking Fee) akan dikembalikan kepada PIHAK KEDUA, setelah dipotong ganti rugi sesuai dengan Pasal 9 ayat 4 dan atau ayat 5,adapun jatuh tempo pengembalian uangnya maximal 30 hari sejak ditanda tangani surat pernyataan pembatalan  </p>
<p>3.	PIHAK KEDUA wajib membayar angsuran Uang Muka setiap bulan, sesuai dengan jadwal yang telah disepakati, tanpa mengkaitkan dengan proses permohonan KPR yang belum disetujui oleh Bank pemberi kredit.  </p>
<p align="center"><strong>Pasal 6  </strong><br>
<strong>PEMBANGUNAN DAN PENYERAHAN RUMAH  </strong></p>
<p>1.	PIHAK PERTAMA akan memulai pembangunan unit rumah yang di pesan oleh PIHAK KEDUA, dalam waktu 7 Hari( untuk uang Muka cash) ,sedangkan untuk Uang Muka standart 6x Pembangunan akan dilaksanakan setelah UM ke 3 dan  setelah ada persetujuan tertulis dari pihak Bank pemberi kredit secara tertulis / maksimal 1 bulan sejak diterbitkannya Surat Persetujuan Kredit dr Bank.  </p>
<p>2.	PIHAK PERTAMA akan memulai kegiatan pembangunan unit rumah yang dipesan oleh PIHAK KEDUA ,  dengan system pembayaran tunai keras atau bertahap minimal pembayaran PIHAK KEDUA  telah mencapai minimai 50 % dari total harga jual.Dan PIHAK PERTAMA bersedia meyelesaikan pekerjaan Fisik pembangunan dalam waktu 4 bulan, terhitung sejak PIHAK KEDUA menyelesaikan pembayarannya kepada PIHAK PERTAMA, sesuai harga jual yang disepakati kedua belah pihak,kecuali bila ada keterlambatan yang disebabkan oleh adanya “force Majeure “yang berada diluar kekuasaan PIHAK PERTAMA.  </p>
<p>3.	PIHAK KEDUA wajib melakukan Realisasi Rumah tepat waktu ,dengan ketentuan-ketentuan yang telah ditetapkan oleh PIHAK PERTAMA ( Biaya KPRdan Pelunasan Uang Muka).Apabila terjadi keterlambatan dari waktu yang ditentukan oleh PIHAK PERTAMA maximal 30 hari maka hak complain pembenahan rumah dinyatakan hangus/tidak berlaku.  </p>
<p>4.	Suku bunga yang berlaku pada PIHAK KEDUA adalah suku bunga pada saat realisasi rumah.  </p>
<p>5.	Jika terjadi Force majeure yang mengakibatkan terhambatnya pelaksanaan pembangunan rumah ,maka jangka waktu penyelesaian dan penyerahan rumah akan diatur dan ditinjau kembali.  </p>
<p>6.	Pemasangan atau penyerahan fasilitas Penerangan,  dalam hal ini PIHAK PERTAMA mengikuti atau mengacu pada ketentuan Instansi yang berwenang,  dalam hal ini Pihak ketiga ( PLN )  </p>
<p align="center"><strong>PASAL 7  </strong><br>
<strong>KEADAAN MEMAKSA (FORCE MAJEURE )  </strong></p>
<p>'Kedua Belah Pihak setuju untuk melakukan perubahan / tambahan perjanjian ini, apabila dikemudian hari terjadi Force Majeure, yaitu hal - hal yang terjadi diluar kekuasaan PIHAK PERTAMA untuk mencegahnya,  termasuk akan tetapi tidak terbatas pada Bencana Alam, Huru - Hara, Epidemic, Kebakaran, Banjir, Ledakan, Pemogokan Massal, Perang, Perubahan Peraturan Perundang – Undangan, Perubahan Kebijakan Pemerintah dan Peristiwa lain apapun , diluar kekuasaan  PIHAK PERTAMA yang menyebabkan PIHAK PERTAMA tidak dapat melaksanakan kewajiban sesuai dengan perjanjian ini dan atau apabila prestasi tersebut dijalankan akan terjadi kerugian yang sangat besar bagi PIHAK PERTAMA.  </p>
<p align="center"><strong>PASAL 8 </strong><br>
<strong>SANKSI KETERLAMBATAN PENYERAHAN RUMAH</strong></p>
<p> Bilamana PIHAK PERTAMA tidak dapat menyelesaikan pembangunan rumah yang dipesan Oleh PIHAK KEDUA ,  sebagaimana tersebut dalam pasal 6 ayat 1 dan 2, maka PIHAK KEDUA berhak memperoleh ganti rugi keterlambatan sebesar 1 ‰ ( satu permil perhari )dari sisa pekerjaan yang belum diselesaikan ,maksimum 5 % ( lima persen) dari nilai sisa pekerjaan yang belum diselesaikan .</p>
<p align="center"> <strong>Pasal 9 </strong><br>
<strong>SANKSI PEMBATALAN  </strong></p>
<p>Apabila PIHAK KEDUA  oleh sebab apapun juga ternyata tidak dapat memenuhi ketentuan-ketentuan sebagai berikut :  </p>
<p>1.	PIHAK KEDUA menyatakan batal pembelian dengan alasan pengajuan KPR tidak disetujui oleh Pihak Bank Pemberi Kredit minimal telah mengajukan ke 2 Bank yang berbeda,maka PIHAK PERTAMA akan membayar kembali uang yang telah dibayarkan oleh PIHAK KEDUA seluruhnya, kecuali Uang tanda jadi atau Booking Fee.  </p>
<p>2.	Apabila pengajuan KPR PIHAK KEDUA telah disetujui pihak Bank, dengan persyaratan khusus ( TUM = Tambahan Uang Muka) sebesar-besarnya 10% dari Plafon KPR yang disetujui, maka PIHAK KEDUA wajib menyelesaikam dalam waktu yang telah ditentukan oleh PIHAK PERTAMA  </p>
<p>3.	Apabila PIHAK KEDUA tidak bersedia menyelesaikan dan atau melakukan pembatalan dikarenakan persyaratan tersebut diatas,  maka PIHAK KEDUA dianggap melakukan pembatalan atas permintaan sendiri dan akan dikenakan denda sesuai dengan Pasal 9 ayat 4 dan 5  </p>
<p>4.	PIHAK KEDUA menyatakan batal pembelian dengan alasan apapun,dengan kondisi rumah belum terbangun, maka PIHAK KEDUA bersedia dikenakan denda sebesar 30 % ( Tiga Puluh persen )  dari Uang yang telah terbayar kepada PIHAK PERTAMA.  </p>
<p>5.	PIHAK KEDUA menyatakan batal dengan alasan apapun, sementara kondisi rumah sudah terbangun   ( Minimal Pondasi ) dan atau Pengajuan KPR PIHAK KEDUA telah mendapat persetujuan dari PIHAK BANK , maka PIHAK KEDUA bersedia dikenakan denda sebesar 50 % ( lima puluh persen ) dari uang yang sudah terbayar kepada PIHAK PERTAMA..
  PIHAK PERTAMA akan melaksanakan pembayaran Kepada PIHAK KEDUA,   terhitung dalam tempo 1( satu bulan ) bulan atau 30 hari sejak ditandatanganinya Surat Pernyataan Pembatalan.
  Untuk pembatalan ini para pihak sepakat untuk melepas ketentuan-ketentuan dalam pasal 1266 1267 KUHPdt  </p>
<p align="center"><strong>Pasal 10  </strong><br>
<strong>MASA PEMELIHARAAN DAN FASILITAS UMUM  </strong></p>
<p>1. PIHAK PERTAMA memberikan jaminan pemeliharaan bangunan kepada PIHAK KEDUA atas pembelian tanah dan bangunan tersebut dalam jangka waktu 100 hari terhitung sejak ditandatanganinya Berita acara Penyerahan Rumah  antara PIHAK PERTAMA dengan PIHAK KEDUA  </p>
<p>2.	Selama masa pemeliharaan PIHAK KEDUA tidak diperkenankan melakukan perubahan pada rumah tersebut.  </p>
<p>3.	Jika PIHAK KEDUA  tidak mengindahkan ketentuan-ketentuan dalam pasal  10 ayat 2 ini, maka jaminan masa pemeliharaan dari PIHAK PERTAMA menjadi gugur dengan sendirinya dan mengenai hal ini untuk selanjutnya menjadi beban / resiko PIHAK KEDUA sepenuhnya.</p>
<p> 4.	PIHAK KEDUA bersedia ikut menjaga kebersihan lingkungan baik di lingkungan rumah masing2 maupun di lingkungan fasilitas yang telah di bangun oleh PIHAK PERTAMA.  </p>
<p>5.	PIHAK PERTAMA berkuasa penuh atas seluruh asset baik berupa jalan,taman bangunan ( kecuali unit rumah yang telah serah terima ke PIHAK KEDUA),yang berada  di lingkungan Perumahan Grand Aloha Regency selama kegitan proyek berlangsung,  </p>
<p>6.	PIHAK KEDUA menyetujui apabila peraturan desa mewajibkan untuk segera dibentuk pengurus warga ( RT /RW )  maka biaya2 yang timbul seperti iuran kebersihan dan keamanan,tagihan listrik PJU menjadi tanggung jawab warga Perumahan.  </p>
<p align="center"><strong>Pasal 11  </strong><br>
<strong>PEMINDAHAN HAK  </strong></p>
<p>1.	Apabila PIHAK KEDUA ingin mengalihkan/memindahkan hak atas tanah berikut bangunan rumah kepada PIHAK KETIGA,  sebelum dilaksanakannya penandatangan akta jual beli antara PIHAK PERTAMA dengan PIHAK KEDUA dihadapan Notaris, maka harus terlebih dahulu mendapat persetujuan dari PIHAK PERTAMA  dan untuk itu PIHAK KEDUA,  berkewajiban membayar biaya administrasi sebesar 10 % ( sepuluh persen) dari harga total nilai jual beli.Khusus untuk pembelian tunai dengan persyaratan lunas seluruh kewajiban pembayaran kepada Pihak Pertama.  </p>
<p>2.	Perjanjian ini mengikat para ahli waris atau penerima hak dari PIHAK KEDUA dan mereka wajib untuk mentaati semua ketentuan yang telah ditetapkan  dalam perjanjian ini.  </p>
<p>3.	Jika PIHAK KEDUA meninggal dunia sebelum melakukan kewajiban seperti termaksud dalam pasal 4, maka segala hak dan kewajiban PIHAK KEDUA  termaksud dalam perjanjian ini, diteruskan oleh para ahli warisnya dan dalam jangka waktu 30 ( tiga puluh ) hari kalender, sejak wafatnya PIHAK KEDUA harus ditunjukkan salah satu ahli warisnya untuk meneruskan hak dan kewajiban berdasarkan perjanjian ini.  </p>
<p align="center"><strong>Pasal 12<br>
LAIN-LAIN </strong></p>
<p>1.	Jika terjadi perselisihan,maka hal tersebut akan diselesaikan oleh para pihak secara musyawarah yang tidak saling merugikan.Dalam hal dengan musyawarah tersebut tidak tercapai kesepakatan,maka hal tersebut diselesaikan melalui pengadilan Negeri di Sidoarjo  </p>
<p>2.	Hal-hal yang belum diatur atau belum cukup diatur dalam perjanjian ini akan diputus bersama oleh para pihak secara musyawarah untuk mufakat..  </p>
<p>3.	Demikian Surat Perjanjian Pengikatan Jual Beli ini dibuat dalam 2 ( dua ) rangkap dan masing-masing mempunyai kekuatan hukum yang sama,dan ditandatangani oleh kedua belah pihak dalam keadaan sadar tanpa adanya unsur paksaan maupun kekhilafan. </p>
<p>Surabaya, 02 Mei 2019  </p>
<p>PIHAK KEDUA					PIHAK PERTAMA  </p>
<p>( Tri Idayati )					(  M.Yufi Amrozi )</p>

			</div>
            </div>
            </div>
			</body>
			</html>
			<script type="text/javascript">
				$(function () {				
				   window.print();
				});
			</script>
<?php
		}
	}
?>

	