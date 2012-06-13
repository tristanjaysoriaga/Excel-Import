<?php
global $data;
mysql_connect("localhost","root","123qWER");
 mysql_select_db("exceldata");
 
 $result = mysql_query("SELECT * FROM names");	
if($result){
	//$check = true;
} else{
	echo(mysql_error());
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>db listing</title>
    </head>
    <body>
      
  <table style="border:thin #000 solid">
<tr >
<th style="border:thin #000 solid">country</th>
<th style="border:thin #000 solid">city</th>
<th style="border:thin #000 solid">promotype</th>
<th style="border:thin #000 solid">promotitle</th>
<th style="border:thin #000 solid">promodescription</th>
<th style="border:thin #000 solid">title</th>
<th style="border:thin #000 solid">description</th>
<th style="border:thin #000 solid">expirydate</th>
<th style="border:thin #000 solid">link</th>
<th style="border:thin #000 solid">imagename</th>
<th style="border:thin #000 solid">thumbnail</th>
</tr>
<?php while($row = mysql_fetch_array($result)) { ?>
<tr>
<td style="border:thin #000 solid"><?=$row['country']; ?></td>
<td style="border:thin #000 solid"><?=$row['city']; ?></td>
<td style="border:thin #000 solid"><?=$row['promotype']; ?></td>
<td style="border:thin #000 solid"><?=$row['promotitle']; ?></td>
<td style="border:thin #000 solid"><?=$row['promodescription']; ?></td>
<td style="border:thin #000 solid"><?=$row['title']; ?></td>
<td style="border:thin #000 solid"><?=$row['description']; ?></td>
<td style="border:thin #000 solid"><?=$row['expirydate']; ?></td>
<td style="border:thin #000 solid"><?=$row['link']; ?></td>
<td style="border:thin #000 solid"><?=$row['imagename']; ?></td>
<td style="border:thin #000 solid"><?=$row['thumbnail']; ?></td>
</tr>
<?php } ?>

</table>

    </body>
</html>
