<?php

$data = array();
$check = false;
$test = '';
$testagain = '';


function removeLineBreak($tempDesc)
{
      $strDesc = '';
      $tempArray = explode("</br>",$tempDesc);
      $newArray = array();
      $ctr = 0;
      $setkey = 0;
      foreach($tempArray as $key=>$value)
      {
        if($ctr<2)
        {
            if(trim($value))
            {
                array_push($newArray,$value);
                $setkey = $key;
                $ctr++;
            }
        }
        else
        {
            if(!trim($value))
            {
                array_push($newArray,"</br>");
            }
            else
            {
                array_push($newArray,"</br>$value");
                $setkey = $key;
            }
        }
      }
      
      foreach($newArray as $key=>$value)
      {
          if($key < ($setkey+1))
          {
              $strDesc .= $value;
          }
      }
      
      return $strDesc;
}

function addSpace($newDesc)
{
    $newDesc = trim($newDesc);
    return str_replace(chr(10), '</br>', $newDesc);
}

function checkFirstArray($tempArray)
{
    return explode('</h2>',$tempArray);
}

function isMatch($tempArray, $value)
{
    return count(array_diff($tempArray, $value));
}

function templateVariables($varArray)
{
    $tempArray = array();
    $newArray = array();
    
    foreach($varArray as $key=>$value)
    {
        if($key != 0)
        {
            $tempArray =  mb_split('</h2>',$value);     
            array_push($newArray, "$tempArray[0]</h2>");        
        }
    }
    return $newArray;
}

function editDescription($description)
{       
    $strdesc = '';
    $templateDesc = array(); 
    $newArray = array();
    $newArray2 = array();
    $compareArray = array();
    $isSecond = false;
    
    $newArray =  mb_split('<h2>',addSpace($description));
    $templateDesc = templateVariables($newArray);
   
    if(count($templateDesc)> 0)
    {
        foreach ($templateDesc as $tempDescValue)
        {
            foreach ($newArray as $value)
            {
                $value = removeLineBreak($value);
                if($isSecond)
                {
                    if(strstr($value, $tempDescValue))
                    { 
                        
                        if(isMatch($compareArray,explode("•",$value)) > 0)
                        {
                            $newArray2 = explode("•",$value);
                            $compareArray = $newArray2;

                            if(count($newArray2) > 1)
                            {
                                $array5 = checkFirstArray($newArray2[0]);
                                $strdesc .= "<h2>$tempDescValue";                            
                                $strdesc .= $array5[1];
                                $strdesc .= "<ul>";
                                $newArray2[0] = "<ul>";
                                array_push($newArray2, '</ul>');
                                break;
                            }
                            else{$strdesc .= "\n<h2>$value"; break;}
                        }
                    }
                }
                else { $strdesc .= $value; $isSecond=true; $compareArray=$newArray;}
            }

            if(count($newArray2) > 1)
            {
                foreach($newArray2 as $value)
                {  
                    if($value != '<ul>' && $value != '</ul>')
                    {
                    $strdesc .= "<li>$value</li>";
                    }
                }
                $strdesc .= "</ul>";
            }
        }
    }
    else
    {         
        $strdesc .= addSpace($description);       
    }
    
    return $strdesc;
}

function add_person( $country, $city, $promotype, $promotitle, $promodescription, $title, $description, $expirydate, $link, $imagename, $thumbnail)
{
 global $data, $check;
 
 $a = addslashes(html_entity_decode($country,ENT_COMPAT,"UTF-8"));
 $b = addslashes(html_entity_decode($city,ENT_COMPAT,"UTF-8"));
 $c = addslashes(html_entity_decode($promotype,ENT_COMPAT,"UTF-8"));
 $d = addslashes(html_entity_decode($promotitle,ENT_COMPAT,"UTF-8"));
 $e = addslashes(html_entity_decode($promodescription,ENT_COMPAT,"UTF-8"));
 $f = addslashes(html_entity_decode($title,ENT_COMPAT,"UTF-8"));
 $g = addslashes(editDescription(html_entity_decode($description,ENT_COMPAT,"UTF-8")));
 $h = addslashes(html_entity_decode($expirydate,ENT_COMPAT,"UTF-8"));
 $i = addslashes(html_entity_decode($link,ENT_COMPAT,"UTF-8"));
 $j = addslashes(html_entity_decode($imagename,ENT_COMPAT,"UTF-8"));
 $k = addslashes(html_entity_decode($thumbnail,ENT_COMPAT,"UTF-8"));
 

$result = mysql_query("INSERT INTO names (country, city, promotype, promotitle, promodescription, title, description, expirydate, link, imagename, thumbnail)
 VALUES ('$a', '$b', '$c', '$d','$e', '$f', '$g', '$h', '$i', '$j', '$k')");	
if($result){
	$check = true;
} else{
	echo(mysql_error());
}

 $data []= array(
   'country' => $a,
   'city' => $b,
   'promotype' => $c,
   'promotitle' => $d,
   'promodescription' => $e,
   'title' => $f,
   'description' => $g,
   'expirydate' => $h,
   'link' => $i,
   'imagename' => $j,
   'thumbnail' => $k

 );
}

if ( $_FILES['file']['tmp_name'] )
{	
 mysql_connect("localhost","root","123qWER");
 mysql_select_db("exceldata");
	
 $dom = new DOMDocument();
 $dom->load($_FILES['file']['tmp_name']);
 
 $rows = $dom->getElementsByTagName( 'Row' );
 $first_row = true;
 foreach ($rows as $row)
 {
   if ( !$first_row )
   {
     $country = "";
     $city = "";
     $promotype = "";
     $promotitle = "";
     $promodescription = "";
     $title = "";
     $description = "";
     $expirydate = "";
     $link = "";
     $imagename = "";
     $thumbnail = "";

     $index = 1;
     $cells = $row->getElementsByTagName( 'Cell' );
     foreach( $cells as $cell )
     {
       $ind = $cell->getAttribute( 'Index' );
       if ( $ind != null ) $index = $ind;

       if ( $index == 1 )
       $country = $cell->nodeValue;
       if ( $index == 2 ) 
       $city = $cell->nodeValue;
       if ( $index == 3 ) 
       $promotype = $cell->nodeValue;
       if ( $index == 4 ) 
       $promotitle = $cell->nodeValue;
       if ( $index == 5 ) 
       $promodescription = $cell->nodeValue;
       if ( $index == 6 ) 
       $title = $cell->nodeValue;
       if ( $index == 7 ) 
       $description = $cell->nodeValue;
       if ( $index == 8 ) 
       $expirydate = $cell->nodeValue;
       if ( $index == 9 ) 
       $link = $cell->nodeValue;
       if ( $index == 11 ) 
       $imagename = $cell->nodeValue;
       if ( $index == 12 ) 
       $thumbnail = $cell->nodeValue;


       $index += 1;
     }
     if(!empty($country))
     {
        add_person( $country, $city, $promotype, $promotitle, $promodescription, $title, $description, $expirydate, $link, $imagename, $thumbnail );
     }
   }
   $first_row = false;
 }
    mysql_close();

    if($check){echo('Successful Upload!');}
}
?>

<!DOCTYPE html>
<html>
    <head><title>Import Excel</title></head>
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
<?php foreach( $data as $row ) { ?>
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
Click <a href="list.php">here</a> for the entire table.
</body>
</html>