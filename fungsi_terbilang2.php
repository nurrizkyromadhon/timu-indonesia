<?php
function konversi($x){
  
  $x = abs($x);
  $angka = array ("","Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  $temp = "";
  
  if($x < 12){
   $temp = " ".$angka[$x];
  }else if($x<20){
   $temp = konversi($x - 10)." Belas";
  }else if ($x<100){
   $temp = konversi($x/10)." Puluh". konversi($x%10);
  }else if($x<200){
   $temp = " Seratus".konversi($x-100);
  }else if($x<1000){
   $temp = konversi($x/100)." Ratus".konversi($x%100);   
  }else if($x<2000){
   $temp = " Seribu".konversi($x-1000);
  }else if($x<1000000){
   $temp = konversi($x/1000)." Ribu".konversi($x%1000);   
  }else if($x<1000000000){
   $temp = konversi($x/1000000)." Juta".konversi($x%1000000);
  }else if($x<1000000000000){
   $temp = konversi($x/1000000000)." Milyar".konversi($x%1000000000);
  }
  
  return $temp;
 }
  
 function tkoma($x){
  $str = stristr($x,",");
  $ex = explode(',',$x);
  
  if(($ex[1]/10) >= 1){
   $a = abs($ex[1]);
  }
  $string = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan","Sepuluh", "Sebelas");
  $temp = "";
 
  $a2 = $ex[1]/10;
  $pjg = strlen($str);
  $i =1;
    
  
  if($a>=1 && $a< 12){   
   $temp .= " ".$string[$a];
  }else if($a>12 && $a < 20){   
   $temp .= konversi($a - 10)." Belas";
  }else if ($a>20 && $a<100){   
   $temp .= konversi($a / 10)." Puluh". konversi($a % 10);
  }else{
   if($a2<1){
    
    while ($i<$pjg){     
     $char = substr($str,$i,1);     
     $i++;
     $temp .= " ".$string[$char];
    }
   }
  }  
  return $temp;
 }
 
 function terbilang($x){
  if($x<0){
   $hasil = "minus ".trim(konversi(x));
  }else{
   $poin = trim(tkoma($x));
   $hasil = trim(konversi($x));
  }
  
if($poin){
   $hasil = $hasil." koma ".$poin;
  }else{
   $hasil = $hasil;
  }
  return $hasil;  
 }

//echo ucwords(terbilang('3,99'));
?>