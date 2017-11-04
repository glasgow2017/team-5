<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://www.webglearth.com/v2/api.js"></script>
  
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

        function initialize(lat,lng,country,whatToSend) {
                var earth = new WE.map('earth_div');
                WE.tileLayer('http://tileserver.maptiler.com/nasa/{z}/{x}/{y}.png').addTo(earth);

                var marker = WE.marker([lat,lng]).addTo(earth);
                marker.bindPopup(country+"<br>"+whatToSend, {maxWidth: 150, closeButton: true}).openPopup();

                earth.setView([lat, lng], 3);
                }
        
            $(document).ready(function()
            {
                $.get("http://ip-api.com/json", function(response) {
                    var whatToSend = "<h3> Your Country is Good, but do you know this one?";
                    initialize(response.lat,response.lon,response.country,whatToSend);
                    
                });
            });
                
            
    
    </script> 

      <div id="earth_div"></div>
  

</body>
     
</html>
