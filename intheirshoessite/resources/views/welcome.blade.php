<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="http://www.webglearth.com/v2/api.js"></script>
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
    

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="AM" />
    <meta name="description" content="Endless Roller" />

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.min.js" integrity="sha256-atgxWORFPH5jcOKVvZzWhe90dUmt2G7TEpl8v9Nf/ec=" crossorigin="anonymous"></script>


    
        
        
    
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
        <img src="{{ asset('img/front-page-girl.png') }}" class="img-fluid rounded mx-auto d-block" style="margin-bottom: 15px;z-index: -9999;"/>
	

        <script>
        var map;
        var marker;
        var countryData;
        
        function initialize(lat,lng,country,whatToSend) {
            
                map = WE.map('map', {
                    center: [lat,lng],
                    zoom: 10,
                    dragging: true,
                    scrollWheelZoom: true,
                    proxyHost: 'http://srtm.webglearth.com/cgi-bin/corsproxy.fcgi?url='
                });
                
                var baselayer = WE.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                marker = WE.marker([lat,lng]).addTo(map);
                marker.bindPopup(country+"<br>"+whatToSend, {closeButton: true}).openPopup();

                map.setView([lat, lng], 3);
                }
            
                function AddMarkers(lat,lng)
                {
                    var marker1 = WE.marker([lat, lng]).addTo(map);
                    map.panTo([lat,lng]);
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
                               countryData = res[i];

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
                                                    <label><input type="radio" name="optradio" value="'+options[0]+'">'+options[0]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio" value="'+options[1]+'">'+options[1]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio" value="'+options[2]+'">'+options[2]+'%</label>\
                                                </div>\
                                                <div class="radio">\
                                                    <label><input type="radio" name="optradio" value="'+options[3]+'">'+options[3]+'%</label>\
                                                </div><br><br>\
                                                <button id="submit" style="margin-left:20%;" class="btn btn-primary">I am sure!</button>';
                                      
                                    // var whatToSend = '<h3> Your Country is Good, but do you know this one?</h3> ';
                                    initialize(response.lat,response.lon,response.country,htmlstr);
                                    $("#submit").on("click",function(){
                                        if(Math.floor(value)==$("input[name='optradio']:checked").val())
                                        {
                                            swal(
                                                'Good job!',
                                                'You know your facts!',
                                                'success'
                                                )
                                                marker.closePopup();
                                        }
                                        else
                                        {
                                            swal(
                                                'Oops...',
                                                'Oh no sorry you got that wrong!',
                                                'error'
                                                )
                                                marker.closePopup();
                                        }
                                        marker.bindPopup("<p>Every year, hundreds of young women suffer from gender inequality poverty.</p><button id='learnMore' style='margin-top:10%;margin-left:20%;' class='btn btn-primary'>Now let's step into their shoes </button>", {closeButton: true}).openPopup();
                                    
                                        $('#learnMore').on("click",function()
                                        {
                                            marker.closePopup();
                                            console.log("learn more");
                                            htmlstr='<div id="TutContainer" style="zoom:0.3;"></div>';
                                            marker.bindPopup(htmlstr,{closeButton:true}).openPopup();
                                            init();
                                        });
                                    });
                                
                                   
                                }
                           }
                       }
                             
                    });
                   
    // init();
    
                    

                    // setTimeout(function(){changeViewAndAddMarkers(22,77,"India",htmlstr)},3000);
                });
                
            });
    
    
    locations = [];
    for(var i = 0; i<locations.length;i++)
    {
        AddMarkers
    }


    </script> 
   

    <div id="map" style="width:100%"></div>
    
    <!-- <div style="zoom:0.5;" id="TutContainer" ></div> -->

            
    <script type="text/javascript" src="{{ asset('js/three.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/stats.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/OrbitControls.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/endlessroller.js') }}"></script>

    <h3 style="margin-top:5%;text-align:center;"> Thank you for being part of this demonstration and raising awareness together.</h3>

</body>
     
</html>
