<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Properties</title>
</head>

<body>
  <h1>Properties</h1>
  
  <ul>
    <?php foreach ($listings as $listing):?>
    <?php
      $address = $listing['Street_Number'].' '.ucwords(strtolower($listing['Street_Name'])).' '.ucfirst(strtolower($listing['Street_Type'])).' - '.$listing['Neighbourhood'].', '.ucwords(strtolower($listing['City_or_Town_Name']));
      
      if ($listing['Suite_Number'] !== '')
      {
        $address = $listing['Suite_Number'].' - '.$address;
      }
    ?>
    <li><?php echo $address; ?> (<?php echo anchor('/admin/set_map/'.$listing['class'].'/'.$listing['Matrix_Unique_ID'], 'Position Map Marker'); ?>)</li>
    <?php endforeach; ?>
  </ul>
  
</body>

</html>