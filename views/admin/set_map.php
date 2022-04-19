<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html>
<?php
    $address = $property['Street_Number'].' '.ucwords(strtolower($property['Street_Name'])).' '.ucfirst(strtolower($property['Street_Type']));
    
    if ($property['Suite_Number'] !== '')
    {
      $address = $property['Suite_Number'].' - '.$address;
    }
    
    if (($property['Lat'] === '') || ($property['Lon'] === ''))
    {
      $property['Lat'] = 49.89975410;
      $property['Lon'] = -97.13749369999999;
    }
  ?>  
<head>
  <meta charset="utf-8">
  <title>Set Map: <?php echo $address; ?></title>
  
  <style>
    #property-map {
      width: 90%;
      height: 400px;
      margin: 1em 0;
    }  
  </style>
</head>

<body>
  <h1>Set Map: <?php echo $address; ?></h1>
  
  <p><a href="/admin">&lt;-- Back to properties list</a></p>

  <div>
    <button id="save-marker">Save Marker Position</button>
  </div>
    
  <div id="property-map"></div>

<script src="<?php echo $assets_path; ?>script/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxbWC10PTf5lyJjh6xIE04axk_sLf0yY&sensor=false"></script>
<script>
$(document).ready(function()
{
  var mapOptions = 
  {
    zoom: 15,
    center: {lat: <?php echo $property['Lat']; ?>, lng: <?php echo $property['Lon']; ?>},
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  };
  
  var map = new google.maps.Map(document.getElementById('property-map'), mapOptions);
  
  var marker = new google.maps.Marker({
    map: map,
    position: new google.maps.LatLng(<?php echo $property['Lat']; ?>, <?php echo $property['Lon']; ?>),
    icon: '/assets/images/WH-icon.gif',
    draggable: true
  });
  
  $('#save-marker').click(function()
  {
    var data = {
                matrix_unique_id: '<?php echo $property['Matrix_Unique_ID']; ?>',
                type: '<?php echo $class; ?>',
                lat: marker.getPosition().lat(),
                lon: marker.getPosition().lng()
               };

    $.ajax(
    {
      url: '/admin/update_map_marker',
      data: data,
      type: 'POST',
      success: function(resp)
      {
        if (parseInt(resp) === 1)
        {
          alert('Marker position saved!');
        }
      }
    });
    
  });
      
  google.maps.event.addListener(marker, 'dragend', function(mapEvent)
  {
    map.panTo(mapEvent.latLng);
  });


});
</script>
</body>
</html>