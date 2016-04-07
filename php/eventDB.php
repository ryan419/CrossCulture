<?php
/**
 * Created by PhpStorm.
 * User: Xiao
 * Date: 29/03/2016
 * Time: 7:20 PM
 */
require 'Eventbrite.php';
require 'dbinfo.php';

function getEventInfo($culture){
    $eb_client = new Eventbrite('I2JFEHP3RCYB6VA2QX6G');

    $info = array(
        'data' => array(
            'location.latitude' => '-37.814396',
            'location.longitude' => '144.963616',
            'location.within' => '78km',
            'expand' => 'organizer,venue',
            'q' => "$culture"
        )
    );

    $result = $eb_client->events('events/search/', $info)["events"];

    $conn = new mysqli;
    if ($conn->connect_error) die($conn->connect_error);

    foreach ($result as $event) {
//    $event = json_decode(json_encode($event),true);
        $event = json_decode(json_encode($event), True);
        $name = $event["name"]["text"];
        $name = addslashes($name);
        $descp = $event["description"]["text"];
        $descp = addslashes($descp);
        $eid = $event["id"];
        $start = $event["start"]["local"];
        $end = $event["end"]["local"];
        $capacity = $event["capacity"];
        $logo = $event["logo"]["url"];
        $organizer = $event["organizer"]["name"];
        $organizer = addslashes($organizer);
        $venue = $event["venue_id"];

        $address = $event["venue"]["address"];
        $venuename = $event["venue"]["name"];
        $venuename = addslashes($venuename);
        $latitude = $address["latitude"];
        $longitude = $address["longitude"];
        $address1 = $address["address_1"];
        $address2 = $address["address_2"];
        $city = $address["city"];
        $postal_code = $address["postal_code"];

        //****** Judge if the Event id exist
        $query3 = "SELECT * FROM Events WHERE eid = " . "'$eid'";
        $result = $conn->query($query3);
        if (!$result) die($conn->error);

        $rows = $result->num_rows;

//****** Inserting
        if ($rows == 0) {

            $query = "INSERT INTO Events(name, descp, eid, start, end, capacity, logo, organizer, venue, culture) VALUES" .
                "('$name', '$descp', $eid, '$start', '$end', $capacity, '$logo', '$organizer', '$venue', '$culture')";

            $result = $conn->query($query);

            if (!$result) {
                echo "INSERT failed: $query<br>" .
                    $conn->error . "<br><br>";
            }
        }

        //****** insert into Venue****
        //****** Judge if the Venue id exist
        $query3 = "SELECT * FROM Venues WHERE id = " . "'$venue'";
        $result = $conn->query($query3);
        if (!$result) die($conn->error);

        $rows = $result->num_rows;

        //****** Inserting
        if ($rows == 0) {
            $query2 = "INSERT INTO Venues VALUES" .
                "($venue, '$venuename', '$address1', '$address2', '$city', '$postal_code', $latitude, $longitude)";

            $result2 = $conn->query($query2);

            if (!$result2) {
                echo "INSERT failed: $query2<br>" .
                    $conn->error . "<br><br>";
            }
        }

        echo $name . '<br>';
    }

}
?>