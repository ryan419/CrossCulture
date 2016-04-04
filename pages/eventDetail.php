<!DOCTYPE html>
<html>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: nerminyildiz
 * Date: 4.04.2016
 * Time: PM 3:57
 */
require("../php/dbinfo.php");
$get_string = $_SERVER['QUERY_STRING'];

parse_str($get_string, $get_array);


$name = $get_array['event'];
$name = addslashes($name);

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$query = "SELECT E.name as ename, E.descp as description, E.capacity as cap, V.name as vname, E.start as start, E.end as end, E.logo as logo,
 V.latitude as lat, V.longitude as lon, E.culture as culture FROM Events E ,Venues V WHERE E.Venue = V.id and E.name='$name'"   ;
$result = $conn->query($query);
if (!$result) die($conn->error);

$event;
foreach($result as $row){
    //print_r($row);
    $event = $row;
    $eventname = $row['ename'];
    $descp = $row['description'];
    $cap = $row['cap'];
    $eventstart = $row['start'];
    $eventend = $row['end'];
    $venue = $row['vname'];
    $pic = $row['logo'];
}

?>
<div>
    <?php
    echo $eventname;
    ?>
</div>

</body>
</html>
