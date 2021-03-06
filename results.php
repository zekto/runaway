<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   <head>
      <title>Runaway</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <link src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js">
      <link rel="stylesheet" href="css/results.css">
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      <script>
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          $("#mainContainer").html(xmlhttp.responseText);
        }
      }
      window.onload=function() {
        xmlhttp.open("GET","./getPackages.php?origin="+<?php echo "'".$_GET['origin']."'";?>+"&destination="+<?php echo "'".$_GET['destination']."'";?>);
        xmlhttp.send();
      }
      function searchPackages(){
        var maxPrice=$("#amount").val().replace("$","");

          xmlhttp.open("GET","./getPackages.php?origin="+<?php echo "'".$_GET['origin']."'";?>+"&destination="+<?php echo "'".$_GET['destination']."'";?>+"&price="+maxPrice);
        xmlhttp.send();
      }
      </script>
      <script>
        $(function() {
          $( "#slider" ).slider({
            value:2000,
            min: 0,
            max: 2000,
            step: 1,
            slide: function( event, ui ) {
              $( "#amount" ).val( "$" + ui.value );
            }
          });
          $( "#amount" ).val( "$" + $( "#slider" ).slider( "value" ) );
        });
      </script>
   </head>
   <body>
   <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./"><img alt="Brand" src="useful things/whitePlane.png" height="20" width="20"></a>
          <a class="navbar-brand" href="./">Runaway</a>
        </div>
      </div>
    </nav>
    <div class="container-fluid">
      <div class="row" id="wrapper">
         <div class="col-md-2" id="sidebar" style="position:fixed">
            <h1> Filters </h1>
            <p>
              <label style="padding-top:2px">Max Price</label>
              <input style="float:right" type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            </p>
            <div id="slider"></div>
            <br>
            <label for="startDate"> Earliest Departure Date </label>
            <input type="date" class="form-control" id="startDate" value="2015-11-08"> <br>
            <label for="endDate"> Latest Return Date </label>
            <input type="date" class="form-control" id="endDate" value="2015-11-30"> <br>

            <button type="button" class="btn btn-default" onclick="searchPackages();" style="float:right">Search</button>
         </div>
         <div id="mainContainer" class="col-md-9 col-md-offset-2"></div>
      </div>
   </div>
   </body>
</html>