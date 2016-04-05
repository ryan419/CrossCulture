<!DOCTYPE html>
<html>
<head>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <link href="../css/bootstrap.css" rel="stylesheet">

    <link href="../css/main.css" rel="stylesheet">

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="../css/eventdetail.css">
</head>
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
 V.latitude as lat, V.longitude as lon, E.culture as culture, V.address1 as ad1, V.address2 as ad2, V.postal_code as postcode, V.city as city
  FROM Events E ,Venues V WHERE E.Venue = V.id and E.name='$name'"   ;
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
    $address = $row['ad2']. ' '. $row['ad1']. ' '. $row['city'];
    $pcode = $row['postcode'];
}
?>
<header id="navigation" class="navbar-static-top" style="background-color: rgba(0, 0, 0, 0.3);">
    <div class="container">

        <div class="navbar-header">
            <!-- responsive nav button -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- /responsive nav button -->

            <!-- logo -->
            <h1 class="navbar-brand">
                <a href="#body">
                    <img src="../images/logo.png" width="112" height="36" alt="Logo">
                </a>
            </h1>
            <!-- /logo -->

        </div>

        <!-- main nav -->
        <nav class="collapse navigation navbar-collapse navbar-right" role="navigation">
            <ul id="nav" class="nav navbar-nav">
                <li><a href="../index.html">Home</a></li>
                <li class="current"><a href="event.html">Event</a></li>
                <li><a href="community.html">Community</a></li>
                <li><a href="#story">Story</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <!-- /main nav -->
    </div>

    </div>
</header>

<div id="" class="eventhead" style="background-image: url('<?=$pic?>');">
    <div class="image-overlay">
        <div class="eventname">
            <h2> <?=$eventname?> </h2>
            <br>
            <?=$venue?>
        </div>
    </div>

</div>
<div class="container">
    <div class="descp">
        <b>Detail:</b><br>
        <?=$descp?>
    </div>
    <div class="detail">
        <b>Address</b>
        <br>
        <?=$address?>
        <br>
        <br>
        <b>Postal Code</b>
        <br>
        <?=$pcode?>
        <br>
        <br>
        <b>Venue</b>
        <br>
        <?=$venue?>
        <br>
        <br>
        <b>Start Time</b>
        <br>
        <?=$eventstart?>
        <br>
        <br>
        <b>End Time</b>
        <br>
        <?=$eventend?>
        <br>
        <br>
        <b>Capacity</b>
        <br>
        <?=$cap.' people'?>
    </div>
    <div id="clear"></div>
</div>





</body>
</html>
