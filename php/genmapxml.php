<?php
/**
 * Created by PhpStorm.
 * User: Xiao
 * Date: 29/03/2016
 * Time: 4:24 PM
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
    $query = "SELECT E.name as ename, E.descp as description, E.capacity as cap, V.name as vname, E.start as start, E.end as end, E.logo as logo,
 V.latitude as lat, V.longitude as lon, E.culture as culture FROM Events E ,Venues V WHERE E.Venue = V.id"  ;
    $result = $conn->query($query);
    if (!$result) die($conn->error);


    header("Content-type: text/xml");

    echo '<markers>';

// Iterate through the rows, adding XML nodes for each
    foreach ($result as $row) {
        // ADD TO XML DOCUMENT NODE
        echo '<marker ';
        echo 'event="' . parseToXML(stripslashes($row['ename'])) . '" ';
        echo 'descp="' . parseToXML(stripslashes($row['description'])) . '" ';
        echo 'capacity="' . parseToXML(stripslashes($row['cap'])) . '" ';
        echo 'venue="' . parseToXML(stripslashes($row['vname'])) . '" ';
        echo 'start="' . parseToXML(stripslashes($row['start'])) . '" ';
        echo 'end="' . parseToXML(stripslashes($row['end'])) . '" ';
        echo 'logo="' . parseToXML(stripslashes($row['logo'])) . '" ';
        echo 'lat="' . parseToXML(stripslashes($row['lat'])) . '" ';
        echo 'lon="' . parseToXML(stripslashes($row['lon'])) . '" ';
        echo 'type="' . parseToXML(stripslashes($row['culture'])) . '" ';
        echo '/>';

    }
    echo '</markers>';

?>