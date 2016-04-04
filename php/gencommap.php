<?php
/**
 * Created by PhpStorm.
 * User: nerminyildiz
 * Date: 1.04.2016
 * Time: PM 2:56
 */
require("dbinfo.php");

function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    return $xmlStr;
}

// Opens a connection to a MySQL server
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);
    $query = "SELECT C.Name as cname, C.Address as caddress, C.Phone as cphone, C.Website as cwebsite, C.Latitude as clat,
  C.Longtitude as clon, C.Culture as comCulture FROM Communities C "  ;
    $result = $conn->query($query);
    if(!$result) die($conn->error);


    header("Content-type: text/xml");

    echo '<markers>';

// Iterate through the rows, adding XML nodes for each
    foreach ($result as $row) {
        // ADD TO XML DOCUMENT NODE
        echo '<marker ';
        echo 'comname="' . parseToXML(stripslashes($row['cname'])) . '" ';
        echo 'comaddress="' . parseToXML(stripslashes($row['caddress'])) . '" ';
        echo 'comphone="' . parseToXML(stripslashes($row['cphone'])) . '" ';
        echo 'web="' . parseToXML(stripslashes($row['cwebsite'])) . '" ';
        echo 'lat="' . parseToXML(stripslashes($row['clat'])) . '" ';
        echo 'lon="' . parseToXML(stripslashes($row['clon'])) . '" ';
        echo 'cul="' . parseToXML(stripslashes($row['comCulture'])) . '" ';
        echo '/>';

    }
    echo '</markers>';

?>