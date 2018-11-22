<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
       "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

<title>Adventskalender 2017</title>

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

function ZeigeGewinn(Nummer) {
 
	$.ajax({
 url:"showselect?n="+Nummer
 }).done(function(data) {
						 $("#zeige").html(data);						 
						 });
  };

$(function() {
	$("#Abfrage").click(function () {
		ZeigeGewinn($("#num").val());
	});	
});
		
</script>
<? include("oben.php");?>	

</head>
<body margin="none" padding="none">

<table width="290">
<th>Bitte tragen Sie Ihre Kalendernummer ein</th>
<tr><td><input class="ui-corner-all" type="text" name="nummer" id="num"><button class="ui-button-text" id="Abfrage">Los!</button></td></tr>

</table>
<div id="zeige"></div>
