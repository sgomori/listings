<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>Admin Dashboard - Properties</title>

  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.min.js"></script>
  
  <script>
  
    var base_url = '<?php echo base_url(); ?>';
  
    $(document).ready(function()
    {
      $('.status-switcher').change(function()
      {        
        var data = 
          {
            matrix_unique_ids : $(this).data('matrix_unique_id'),
            status: $(this).val(),
            type: $(this).data('class')
          };
      
        $.ajax(
        {
          type: 'POST',
          url: base_url+'admin/update_status', 
          data: data,
          context: this,
          success: function(result)
          {
            if (parseInt(result) === 1)
            {
              $(this).parents('.property').removeClass('Active');
              $(this).parents('.property').removeClass('Pending');
              $(this).parents('.property').removeClass('Sold');
              
              $(this).parents('.property').addClass(data.status);
              
              alert('Property status changed.');
            }
            else
            {
              alert('Something seems to have gone wrong. The status may not have properly saved.');
            }
          }
        });
      });
      
    });
  
  </script>
    
  <style>
    #wrapper {
      width: 90%;
    }
    
    .property {
      padding: 1em;
      border: 1px solid #ccc;
    }
    
    .property.Active {
      background-color: #e6ffe6;
    }
    
    .property.Pending {
      background-color: #fff5cc;
    }
    
    .property.Sold {
      background-color: #ffcccc;
    }
  </style>
</head>

<body>
  <div id="wrapper">
  
    <h1>Admin Dashboard - Properties</h1>
    
    <?php foreach ($listings as $listing):?>
    <?php
      $address = $listing['Street_Number'].' '.ucwords(strtolower($listing['Street_Name'])).' '.ucfirst(strtolower($listing['Street_Type'])).' - '.$listing['Neighbourhood'].', '.ucwords(strtolower($listing['City_or_Town_Name']));
      
      if ($listing['Suite_Number'] !== '')
      {
        $address = $listing['Suite_Number'].' - '.$address;
      }
    ?>
    
    <div class="property <?php echo $listing['Status']; ?>">
      <div><?php echo $address; ?></div>
      <div style="float: right">
        Status:
        <select class="status-switcher" data-matrix_unique_id="<?php echo $listing['Matrix_Unique_ID']; ?>" data-class="<?php echo $listing['class']; ?>">
          <option value="Active"<?php if ($listing['Status'] === 'Active'): ?> selected<?php endif; ?>>Active</option>
          <option value="Pending"<?php if ($listing['Status'] === 'Pending'): ?> selected<?php endif; ?>>Pending</option>
          <option value="Sold"<?php if ($listing['Status'] === 'Sold'): ?> selected<?php endif; ?>>Sold</option>
        </select>
      </div>
      <?php echo anchor('/admin/set_map/'.$listing['class'].'/'.$listing['Matrix_Unique_ID'], 'Position Map Marker'); ?>
    </div>
    <?php endforeach; ?>
  </div>
  
</body>

</html>