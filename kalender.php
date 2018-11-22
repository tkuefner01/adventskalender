<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
       "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<title>Adventskalender des Lions-Club Hagen-Mark</title>

<link href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/ui-lightness/jquery-ui.min.css" rel="stylesheet">
<link href="table.css" rel="stylesheet">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68963247-1', 'auto');
  ga('send', 'pageview');

</script>
	
<script type="text/javascript">

function OeffneTuer(Nummer) {
	$("#tuer").dialog("option", "title", "Die Gewinne hinter der "+Nummer+". Tür:");	
	$("#tuer").dialog("open");
	$.ajax({
 url:"showwinners?q="+Nummer
 }).done(function(data) {

						 $("#tuer").html(data);
						 });
  };

$(function() {
	$("#tuer").dialog({
		autoOpen: false,
		modal: true,
		closeText: "hide",
		dialogClass: "dlg-no-title",
		width: 500
	});	
});
		
</script>
<? include("oben.php");?>	

</head>
<body>
<div id="tuer" title="Tür">
</div>

<div>
  <map name="Kalender">
  <area id="7" shape="rect" coords="23,23,112,117" onclick="OeffneTuer(this.id)" alt="7. Tag">
  <area id="12" shape="rect" coords="140,37,230,126" onclick="OeffneTuer(this.id)" alt="12. Tag">
  <area id="20" shape="rect" coords="307,24,403,118"  onclick="OeffneTuer(this.id)" alt="20. Tag">
  <area id="18" shape="rect" coords="430,51,522,143"  onclick="OeffneTuer(this.id)" alt="18. Tag">
  <area id="11" shape="rect" coords="552,32,646,128"  onclick="OeffneTuer(this.id)" alt="11. Tag">
  <area id="23" shape="rect" coords="664,45,761,132" onclick="OeffneTuer(this.id)" alt="23. Tag">
  <area id="15" shape="rect" coords="38,156,134,251" onclick="OeffneTuer(this.id)" alt="15. Tag">
  <area id="21" shape="rect" coords="165,137,254,231" onclick="OeffneTuer(this.id)" alt="21. Tag">
  <area id="8" shape="rect" coords="283,150,377,242" onclick="OeffneTuer(this.id)" alt="8. Tag">
  <area id="17" shape="rect" coords="397,175,492,266" onclick="OeffneTuer(this.id)" alt="17. Tag">
  <area id="5" shape="rect" coords="517,182,610,276" onclick="OeffneTuer(this.id)" alt="5. Tag">
  <area id="4" shape="rect" coords="630,150,722,244" onclick="OeffneTuer(this.id)" alt="4. Tag">
  <area id="1" shape="rect" coords="36,297,129,386" onclick="OeffneTuer(this.id)" alt="1. Tag">
  <area id="6" shape="rect" coords="155,263,246,358" onclick="OeffneTuer(this.id)" alt="6. Tag">
  <area id="14" shape="rect" coords="276,279,368,370" onclick="OeffneTuer(this.id)" alt="14. Tag">
  <area id="24" shape="rect" coords="393,292,484,383" onclick="OeffneTuer(this.id)" alt="24. Tag">
  <area id="3" shape="rect" coords="518,315,611,410" onclick="OeffneTuer(this.id)" alt="3. Tag">
  <area id="22" shape="rect" coords="659,277,753,371" onclick="OeffneTuer(this.id)" alt="22. Tag">
  <area id="16" shape="rect" coords="20,438,112,529" onclick="OeffneTuer(this.id)" alt="16. Tag">
  <area id="10" shape="rect" coords="154,415,252,513" onclick="OeffneTuer(this.id)" alt="10. Tag">
  <area id="2" shape="rect" coords="291,399,382,489" onclick="OeffneTuer(this.id)" alt="2. Tag">
  <area id="19" shape="rect" coords="400,426,499,519" onclick="OeffneTuer(this.id)" alt="19. Tag">
  <area id="13" shape="rect" coords="531,434,623,527" onclick="OeffneTuer(this.id)" alt="13. Tag">
  <area id="9" shape="rect" coords="647,408,740,500" onclick="OeffneTuer(this.id)" alt="9. Tag">
  </map>
</div>

<div id="kalender" align="center" padding=0 margin=0><img src="/images/kalender2017.png" width=810 padding=0 margin=0 alt="Kalender" usemap="#Kalender"></div>
