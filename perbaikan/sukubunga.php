<form action="<?php $_SERVER['PHP_SELF'] ?>" name="kalkulator" method="post">
<fieldset>
<input type="kredit" id="kredit" placeholder="Jumlah Kredit (Rp)" name="kredit"/>
<input type="waktu" id="waktu" placeholder="Jangka Waktu (tahun)" name="waktu"/>
<input type="bunga" id="bunga" placeholder="Bunga" name="bunga"/>
<input type="submit" value="Hitung Cicilan" onclick="hitung()"/>
</fieldset>
</form>

<?php
$i=$_POST['kredit'];
$n=$_POST['waktu'];
$p=$_POST['bunga'];
function PMT($i,$n,$p){
$p/=1200;
$n*=12;
return ($i*$p)*(1/(1-(1/(pow((1+$p),$n)))));
}
$hasil=@PMT($i,$n,$p);
$rupiah=@number_format($hasil,'0',',','.');
echo "<table>
<tr><td class=\"kolom\">Kredit</td><td>:</td><td class=\"spasi\"></td><td>".number_format($i,'0',',','.')."</td></tr>
<tr><td class=\"kolom\">Waktu</td><td>:</td><td class=\"spasi\"></td><td>".$n." tahun</td></tr>
<tr><td class=\"kolom\">Bunga</td><td>:</td><td class=\"spasi\"></td><td>".$p." %</td></tr>
<tr><td class=\"kolom\">Cicilan</td><td>:</td><td class=\"spasi\"></td><td><b>".$rupiah."</b></td></tr>
</table>";
?>