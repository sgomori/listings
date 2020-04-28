<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?> | Winnipeg Homes</title>
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
  <link rel="publisher" href="https://plus.google.com/+Winnipeghomescom">
  <link rel="shortcut icon" href="<?php echo $assets_path; ?>images/icon/favicon.ico" type="image/x-icon">

  <!-- GOOGLE WEB FONTS INCLUDE -->
  <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,300italic,400italic' rel='stylesheet' type='text/css'>

  <!-- STYLESHEETS -->
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/jquery.nouislider.min.css">

  <!-- THEME STYLESHEETS -->
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/style.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/shortcode.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/citilights-shortcode.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/color/color1.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/flexslider.css">
  <link rel="stylesheet" href="<?php echo $assets_path; ?>css/wpghomes.css">
  
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  
  <script>
    var base_url = '<?php echo base_url(); ?>';
  </script>
  
  <!-- Facebook Pixel Code -->
  <script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
  n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
  document,'script','https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '832690430240759'); // Insert your pixel ID here.
  fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=832690430240759&ev=PageView&noscript=1"
  /></noscript>
  <!-- DO NOT MODIFY -->
  <!-- End Facebook Pixel Code -->
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
                  <li class="home"><a href="http://WinnipegHomes.com/">Home</a></li>
                  <li class="services"><a href="http://WinnipegHomes.com/services/buying-a-home">Services</a>
                    <ul>
                      <li><a href="http://WinnipegHomes.com/services/buying-a-home">Buying a home</a></li>
                      <li><a href="http://WinnipegHomes.com/services/selling-a-home">Selling a home</a></li>
                      <li><a href="http://WinnipegHomes.com/services/working-with-a-realtor">Working with a Realtor</a></li>
                    </ul>
                  </li>
                  <li class="listings active"><a href="<?php echo base_url(); ?>">Listings</a>
                    <ul>
                      <li><a href="<?php echo base_url(); ?>homes">Homes</a></li>
                      <li><a href="<?php echo base_url(); ?>condos">Condos</a></li>
                      <li><a href="<?php echo base_url(); ?>rural">Rural</a></li>
                      <li><a href="http://WinnipegHomes.com/developments">Developments</a></li>
                      <li><a href="<?php echo base_url(); ?>office">Office Listings</a></li>
                    </ul>
                  </li>
                  <li class="homes-wanted"><a href="http://WinnipegHomes.com/homes-wanted">Homes Wanted</a></li>
                  <li class="mls-map"><a href="http://WinnipegHomes.com/mls-map">MLS Map</a></li>
                  <li class="blog"><a href="http://WinnipegHomes.com/blog">Blog</a></li>
                  <li class="contact"><a href="http://WinnipegHomes.com/contact">Contact</a></li>
                  <li class="testimonials"><a href="http://WinnipegHomes.com/testimonials">Testimonials</a></li>
                </ul>
              </nav>
            </div>
            <img src="<?php echo $assets_path; ?>images/winnipeg-homes-logo.png" alt="Winnipeg Homes" id="wpghomes-logo" />
            <img class="header-bg" src="<?php echo $assets_path; ?>images/header-bg-<?php echo $header_variant; ?>.jpg" alt="Winnipeg Homes" />
          </div>
        </div>
      </div>
      
    </header>
    <!-- END HEADER -->