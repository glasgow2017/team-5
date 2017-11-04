<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://www.webglearth.com/v2/api.js"></script>
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
    <style>
    
      html, body{padding: 0; margin: 0;}
      </style>
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
        <style>
            html,body
            {
                font-family: 'Varela Round', sans-serif;
            }
        </style>
        
    </head>
    <body style="text-align:center;">

        <h1 style="font-size:3.5em;margin-top:10%;">
            In their shoes
        </h1>
        <img src="{{ asset('img/front-page-girl.png') }}" style="margin-top:-3%;width:600px;margin-left:40px;"/>

        <script>
        var map;
            
        function initialize(lat,lng,country,whatToSend) {
            
                map = WE.map('map', {
                    center: [lat,lng],
                    zoom: 4,
                    dragging: true,
                    scrollWheelZoom: true,
                    proxyHost: 'http://srtm.webglearth.com/cgi-bin/corsproxy.fcgi?url='
                });
                
                var baselayer = WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                var marker = WE.marker([lat,lng]).addTo(map);
                marker.bindPopup(country+"<br>"+whatToSend, {maxWidth: 150, closeButton: true}).openPopup();

                map.setView([lat, lng], 3);
                }
            
                function changeViewAndAddMarkers(lat,lng,country,whatToSend)
                {
                    var marker = WE.marker([lat, lng]).addTo(map);
                    marker.bindPopup(country+"<br>"+whatToSend, {maxWidth: 150, closeButton: true}).openPopup();
                    map.panTo([lat,lng]);
                }
            
            $(document).ready(function()
            {
                $.get("http://ip-api.com/json", function(response) {
                    var whatToSend = "<h3> Your Country is Good, but do you know this one?";
                    initialize(response.lat,response.lon,response.country,whatToSend);
                    htmlstr= '<h3> How many girls in Russia go to school? </h3>\
    <div class="radio">\
        <label><input type="radio" name="optradio">52%</label>\
    </div>\
    <div class="radio">\
        <label><input type="radio" name="optradio">54%</label>\
    </div>\
    <div class="radio">\
        <label><input type="radio" name="optradio">60%</label>\
    </div>\
    <div class="radio">\
        <label><input type="radio" name="optradio">70%</label>\
    </div>';
                    setTimeout(function(){changeViewAndAddMarkers(22,77,"India",htmlstr)},3000);
                });
                
            });


    
                
            
    
    </script> 

    <div id="map"></div>
  
</body>
     
</html>
