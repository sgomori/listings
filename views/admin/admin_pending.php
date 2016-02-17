<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Manage Pending Properties</title>
  
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.min.js"></script>
  
  <script>
  
    var base_url = '<?php echo base_url(); ?>';
  
    $(document).ready(function()
    {
      $('#submit').click(function()
      {
        var selected_properties = new Array();

        $('#pending input:checked').each(function()
        {
          selected_properties.push($(this).val());
        });
        
        if (selected_properties.length === 0)
        {
          alert('Please select one or more properties.');
          return;
        }
        
        var data = 
          {
            matrix_unique_ids : selected_properties
          }
      
        $.post(base_url+'admin/set_as_sold', data, function(data)
        {
          if (data === '1')
          {
            var refresh = confirm('Changes have been saved. Refresh this page?');
            
            if (refresh)
            {
              location.reload();
            }
          }
          else
          {
            alert('Something seems to have gone wrong. Properties may not have properly saved.');
          }
        });
  
      });
      
    });
  
  </script>
  
  <style>
    
    button {
      margin-top: 1em;
    }
    
  </style>
  
</head>

<body>
  <h1>Manage Pending Lots</h1>
  
  <?php if (count($listings) > 0): ?>
  
  <p>Select the Pending lots that should be set as Sold.</p>
  
  <div id="pending">
    <?php foreach ($listings as $listing) : ?>
    <input type="checkbox" id="property_<?php echo $listing['Matrix_Unique_ID']; ?>" value="<?php echo $listing['Matrix_Unique_ID']; ?>" /> <label for="property_<?php echo $listing['Matrix_Unique_ID']; ?>"><?php echo $listing['Street_Number']; ?> <?php echo ucwords(strtolower($listing['Street_Name'])); ?> <?php echo ucfirst(strtolower($listing['Street_Type'])); ?></label><br/>
    <?php endforeach; ?>
  </div>
  
  <button id="submit">Mark Selected Properties as SOLD</button>
  
  <?php else: ?>
  
  <p>There are currently no Pending lots.</p>
  
  <?php endif; ?>
  
</body>

</html>