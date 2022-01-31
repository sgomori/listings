<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?> | Winnipeg Homes</title>
  <?php if ($no_index): ?>
  <meta name="robots" content="noindex">
  <?php endif; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo $description; ?>">
  <meta property="og:title" content="<?php echo $title; ?> | Winnipeg Homes">
  <meta property="og:description" content="<?php echo $description; ?>">
  <meta property="og:site_name" content="Winnipeg Homes - Listings | An Experience Worth Repeating" />
  <meta property="og:url" content="<?php echo current_url(); ?>" />  
  <meta property="og:image" content="<?php echo $og_image; ?>" />
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="<?php echo $og_width; ?>" />
  <meta property="og:image:height" content="<?php echo $og_height; ?>" />
    
  <!-- STYLESHEETS -->
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/packaged-css-min.css" media="all" type="text/css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/fonts.css" media="all" type="text/css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/wpghomes.css" media="all" type="text/css">
      
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
</head>

<body class="page-fullwidth">
<?php echo $analytics; ?>
  <!-- START SITE -->
  <div class="site">
    <!-- START HEADER -->
    <header>
      <div class="container">
        <div class="row">
          <div class="col-xs-12 header-row">
            <div class="col-xs-12 header-content">
              <div class="toggle_title">Winnipeg Homes</div>
              <div class="toggle"></div>
              <nav>
                <ul>
                  <li class="home"><a href="https://WinnipegHomes.com/">Home</a></li>
                  <li class="services"><a href="https://WinnipegHomes.com/services/buying-a-home">Services</a>
                    <ul>
                      <li><a href="https://WinnipegHomes.com/services/buying-a-home">Buying a home</a></li>
                      <li><a href="https://WinnipegHomes.com/services/selling-a-home">Selling a home</a></li>
                      <li><a href="https://WinnipegHomes.com/services/working-with-a-realtor">Working with a Realtor</a></li>
                    </ul>
                  </li>
                  <li class="listings active"><a href="<?php echo base_url(); ?>">Listings</a>
                    <ul>
                      <li><a href="<?php echo base_url(); ?>homes">Homes</a></li>
                      <li><a href="<?php echo base_url(); ?>condos">Condos</a></li>
                      <li><a href="<?php echo base_url(); ?>rural">Rural</a></li>
                      <li><a href="https://WinnipegHomes.com/developments">Developments</a></li>
                      <li><a href="<?php echo base_url(); ?>office">Office Listings</a></li>
                    </ul>
                  </li>
                  <li class="homes-wanted"><a href="https://WinnipegHomes.com/homes-wanted">Homes Wanted</a></li>
                  <li class="mls-map"><a href="https://WinnipegHomes.com/mls-map">MLS Map</a></li>
                  <li class="blog"><a href="https://WinnipegHomes.com/blog">Blog</a></li>
                  <li class="contact"><a href="https://WinnipegHomes.com/contact">Contact</a></li>
                  <li class="testimonials"><a href="https://WinnipegHomes.com/testimonials">Testimonials</a></li>
                </ul>
              </nav>
            </div>
            <img src="<?php echo $assets_path; ?>images/winnipeg-homes-logo.png" alt="Winnipeg Homes" id="wpghomes-logo" />

            <picture>
              <source type="image/webp" srcset="<?php echo $assets_path; ?>images/header-bg-<?php echo $header_variant; ?>.webp">
              <source type="image/jpeg" srcset="<?php echo $assets_path; ?>images/header-bg-<?php echo $header_variant; ?>.jpg">
              <img class="header-bg" src="<?php echo $assets_path; ?>images/header-bg-<?php echo $header_variant; ?>.jpg" alt="Winnipeg Homes" />
            </picture>
            
          </div>
        </div>
      </div>
      
    </header>
    <!-- END HEADER -->