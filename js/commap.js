/**
 * Created by nerminyildiz on 5.04.2016.
 */

function load(culture) {
    var map = new google.maps.Map(document.getElementById("map-canvas"), {
        center: new google.maps.LatLng(-37.814396, 144.963616),
        zoom: 10,
        mapTypeId: 'roadmap',
        minZoom: 9,
        maxZoom: 14
    });
    //map.setMyLocationEnabled(true);
    //test(map);

    var sidebar = document.getElementById("sidebar");
    sidebar.innerHTML="";

    var infoWindow = new google.maps.InfoWindow({minWidth: 300, maxWidth: 350});


    // Change this depending on the name of your PHP file
    downloadUrl("../php/gencommap.php", function (data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        var b = culture;
        for (var i = 0; i < markers.length; i++) {
            var name = markers[i].getAttribute("comname");
            var address = markers[i].getAttribute("comaddress");
            var phone = markers[i].getAttribute("comphone");
            var website = markers[i].getAttribute("web");
            var cultur = markers[i].getAttribute("cul");
            var point = new google.maps.LatLng(
                parseFloat(markers[i].getAttribute("lat")),
                parseFloat(markers[i].getAttribute("lon")));
            //document.write(type);

            var html = '<div id="iw-container">' +
                '<div class="iw-title">' + name + '</div>' +
                '<div class="iw-content">' +
                '<p class="iw-subTitle">Address</p>'+ address+
                '<p class="iw-subTitle">Phone</p>'+ phone+
                '<br><br><a href="'+website+'" target="_blank">Visit Their Website'+
                '</div>' +
                '<div class="iw-bottom-gradient"></div>' +
                '</div>';


            //var a = document.getElementById("Culture");
            //var b = a.value;
            if ((cultur == b && b == 'Greek') || cultur == b && b == 'China' || cultur == b && b == 'Turkish' || cultur == b && b == 'Indian' || cultur == b && b == 'Italian' || b=='test') {

                if (cultur == 'Greek') {
                    var icon1 = 'http://labs.google.com/ridefinder/images/mm_20_blue.png';
                }
                else if (cultur == 'China') {
                    var icon1 = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
                }
                else if (cultur == 'Turkish') {
                    var icon1 = 'http://labs.google.com/ridefinder/images/mm_20_purple.png';
                }
                else if (cultur == 'Indian') {
                    var icon1 = 'http://labs.google.com/ridefinder/images/mm_20_brown.png';
                }
                else if (cultur == 'Italian') {
                    var icon1 = 'http://labs.google.com/ridefinder/images/mm_20_green.png';
                }

                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    icon: icon1
                });
                bindInfoWindow(marker, map, infoWindow, html);
            }

        }


    });

    function bindInfoWindow(marker, map, infoWindow, html) {
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
        });


        google.maps.event.addListener(map, 'click', function () {
            infoWindow.close();
        });


    }
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    request.open('GET', url, true);
    request.send(null);
}

function doNothing() {
}

