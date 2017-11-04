<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<script>
$(document).ready(function()
{
	$.get('http://api.worldbank.org/countries/IN/indicators/SE.ADT.LITR.ZS?format=json'),

 function(data)
	{
		console.log(data);	
	}
    $.get('http://api.worldbank.org/countries/IN/indicators/SG.LAW.CHMR?format=json'),
    function(data)
    {
     console.log(data);
    }
    $.get('http://api.worldbank.org/countries/IN/indicators/SH.STA.MMRT?format=json'),
    function(data)
    {
        console.log(data);
        $.get ('http://api.worldbank.org/countries/IN/indicatorsSL.EMP.1524.SP.FE.NE.ZS?format=json'),
        function(data)
        {
            console.log(data);

        $get ('http://api.worldbank.org/countries/IN/indicators/SP.MTR.1519.ZS?format=json'),
         function(data)
         {
             console.log(data)

         }
        
         $.get('http://api.worldbank.org/countries/ID/indicators/SE.ADT.LITR.ZS?format=json'),

 function(data)
	{
		console.log(data);	
	}
    $.get('http://api.worldbank.org/countries/ID/indicators/SG.LAW.CHMR?format=json'),
    function(data)
    {
     console.log(data);
    }
    $.get('http://api.worldbank.org/countries/ID/indicators/SH.STA.MMRT?format=json'),
    function(data)
    {
        console.log(data);
        $.get ('http://api.worldbank.org/countries/ID/indicatorsSL.EMP.1524.SP.FE.NE.ZS?format=json'),
        function(data)
        {
            console.log(data);

        $get ('http://api.worldbank.org/countries/ID/indicators/= SP.MTR.1519.ZS?format=json'),
         function(data)
         {
             console.log(data)

         }
        
         $.get('http://api.worldbank.org/countries/IN/indicators/SE.ADT.LITR.ZS?format=json'),

 function(data)
	{
		console.log(data);	
	}
    $.get('http://api.worldbank.org/countries/RW/indicators/SG.LAW.CHMR?format=json'),
    function(data)
    {
     console.log(data);
    }
    $.get('http://api.worldbank.org/countries/RW/indicators/SH.STA.MMRT?format=json'),
    function(data)
    {
        console.log(data);
        $.get ('http://api.worldbank.org/countries/RW/indicatorsSL.EMP.1524.SP.FE.NE.ZS?format=json'),
        function(data)
        {
            console.log(data);

        $get ('http://api.worldbank.org/countries/RW/indicators/= SP.MTR.1519.ZS?format=json'),
         function(data)
         {
             console.log(data)

         }
        country=(ID,IN,RWD)
        codes[SE.ADT.LITR.ZS,SG.LAW.CHMR,SH.STA.MMRT,SL.EMP.1524.SP.FE.NE.ZS,SP.MTR.1519.ZS]
         for country int country;
         for code in codes:
         url="('http://api.worldbank.org/countries"/+code+ "/indicators/"/+country



        }
    }


}
</script>

</body>
</html>
