<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Winnipeg Homes - Listings</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
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
</head>

<body class="page-fullwidth">
  <!-- START SITE -->
  <div class="site">
    <!-- START HEADER -->
    <header>
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <img src="<?php echo $assets_path; ?>images/winnipeg-homes-logo.png" alt="Winnipeg Homes" id="wpghomes-logo" />
            <img class="header-bg" src="<?php echo $assets_path; ?>images/header-bg-main.jpg" alt="Winnipeg Homes" />
            <nav>
              <ul>
                <li class="home active"><a href="http://WinnipegHomes.com/">Home</a></li>
                <li class="services"><a href="http://WinnipegHomes.com/services">Services</a>
                  <ul>
                    <li><a href="http://WinnipegHomes.com/services/buying-a-home">Buying a home</a></li>
                    <li><a href="http://WinnipegHomes.com/services/selling-a-home">Selling a home</a></li>
                    <li><a href="http://WinnipegHomes.com/services/working-with-a-realtor">Working with a Realtor</a></li>
                  </ul>
                </li>
                <li class="listings"><a href="http://WinnipegHomes.com/listings">Listings</a>
                  <ul>
                    <li><a href="http://WinnipegHomes.com/listings/homes">Homes</a></li>
                    <li><a href="http://WinnipegHomes.com/listings/condos">Condos</a></li>
                    <li><a href="http://WinnipegHomes.com/listings/rural">Rural/Farms</a></li>
                    <li><a href="http://WinnipegHomes.com/listings/developments">Developments</a></li>
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
        </div>
      </div>
      
    </header>
    <!-- END HEADER -->