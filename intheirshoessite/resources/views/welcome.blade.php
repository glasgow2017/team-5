<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://www.webglearth.com/v2/api.js"></script>
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
    
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="AM" />
    <meta name="description" content="Endless Roller" />

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.min.js" integrity="sha256-atgxWORFPH5jcOKVvZzWhe90dUmt2G7TEpl8v9Nf/ec=" crossorigin="anonymous"></script>

    <script type="text/javascript" src="{{ asset('js/three.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/stats.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/OrbitControls.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/endlessroller.js') }}"></script>
        
        
    
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
                    startGame();
                }
            
                function shuffle(array) {
                    var currentIndex = array.length, temporaryValue, randomIndex;

                    // While there remain elements to shuffle...
                    while (0 !== currentIndex) {

                        // Pick a remaining element...
                        randomIndex = Math.floor(Math.random() * currentIndex);
                        currentIndex -= 1;

                        // And swap it with the current element.
                        temporaryValue = array[currentIndex];
                        array[currentIndex] = array[randomIndex];
                        array[randomIndex] = temporaryValue;
                    }

                    return array;
                    }

            $(document).ready(function()
            {
                $.get("http://ip-api.com/json", function(response) {
                   
                    $.get('/data',function(res)
                    {
                        res = JSON.parse(res);
                     console.log(res);
                        for(var i =0;i<res.length;i++)
                       {
                           console.log(res[i].country);
                           if(res[i].country==response.country)
                           {
                               if(res[i]["SE.ADT.LITR.FE.ZS"]!=0)
                                {
                                    value = parseInt(res[i]["SE.ADT.LITR.FE.ZS"]);
                                    options=[]
                                    if(value+10>100)
                                    {
                                        options.push(100);
                                    }
                                    else
                                    {
                                        options.push(95);
                                    }
                                    for(var j=15;j<=30;j+=15)
                                    {
                                        options.push(value-j);
                                    }
                                    options.push(Math.floor(value));
                                    options = shuffle(options);
                                    htmlstr= '<h3> How many females get employed in your country? Any ideas? </h3>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio">'+options[0]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio">'+options[1]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio">'+options[2]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio">'+options[3]+'%</label>\
                                                <button id="submit">I am sure!</button>\
                                                </div>';
                                      
                                    // var whatToSend = '<h3> Your Country is Good, but do you know this one?</h3> ';
                                    initialize(response.lat,response.lon,response.country,htmlstr);
                                }
                           }
                       }
                             
                    });
                   
    // init();
    
                    // htmlstr='<div id="TutContainer" style="width:50% !important;"></div>';

                    // setTimeout(function(){changeViewAndAddMarkers(22,77,"India",htmlstr)},3000);
                });
                
            });


    
                
            
    
    </script> 

    <div id="map"></div>
    
    <!-- <div style="zoom:0.5;" id="TutContainer" ></div> -->

</body>
     
</html>
