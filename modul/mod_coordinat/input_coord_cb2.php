<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta name="viewport" content="width=device-width">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Developer</title>

<?
include 'config.php'; 
?>
<form name="myform" action="marketing_input.php?siteplant=<?=$siteplant?>&nm_perumh=<?=$nm_perumh?>">
<select name="siteplant" >
<option value=""> -Pilih-</option>
<?
$query="select * from nm_perush";
$qry=mysql_query($query);
while ($hasil=mysql_fetch_array($qry)){
$siteplant=$hasil['siteplant'];
$nm_perush=$hasil['nm_perush'];
$nm_perumh=$hasil['nm_perumh'];
?>
<option value="<?=$siteplant?>"><?=$nm_perumh?></option>
<? } ?> 
</select>
<input type="submit" name="submit" value="Input Coordinat">
<input type="hidden" name="nm_perumh" value="<?=$nm_perumh?>" />
</form>