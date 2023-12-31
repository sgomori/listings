    <!-- START FOOTER -->
    <footer>
    
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xs-12 col-md-3 col-md-offset-2">
              <h3>Find Your Winnipeg Home</h3>
              <ul>
          			<li><a href="<?php echo base_url(); ?>homes">Homes</a></li>
          			<li><a href="<?php echo base_url(); ?>condos">Condominiums</a></li>
          			<li><a href="<?php echo base_url(); ?>rural">Rural/Farms</a></li>
          			<li><a href="https://WinnipegHomes.com/developments">Developments</a></li>
          			<li><a href="https://WinnipegHomes.com/mls-map">MLS Map</a></li>
          		</ul>
          	</div>
          	
          	
          	<div itemscope itemtype="https://schema.org/RealEstateAgent" class="col-xs-12 col-md-3 contact">
          		<h3 itemprop="name">Blair &amp; Tyson Sonnichsen</h3>
          		<span itemprop="branchOf" itemscope itemtype="https://schema.org/Organization">
          			<span itemprop="name">Royal LePage Dynamic</span>
          		</span>
          		<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
          			<span itemprop="streetAddress">1450 Corydon Ave.</span>
          			<span class="city-prov">
          				<span itemprop="addressLocality">Winnipeg</span>, 
          				<span itemprop="addressRegion">Manitoba</span>
          			</span>
          			<span itemprop="postalCode">R3N 0J3</span>
          		</div>
          		<span itemprop="telephone">204-989-5000</span>
          		<span><a href="https://www.google.ca/maps/@49.86319,-97.186035,3a,75y,143.72h,93.71t/data=!3m4!1e1!3m2!1s_wMC8-AlblelWw1T9xt9bA!2e0!6m1!1e1" itemprop="map">View in Google Street View</a></span>
          	</div>
          	
          	<div class="col-xs-12 col-md-3">
          		<h3>Join the Discussion</h3>
              <ul>
          			<li><a href="https://WinnipegHomes.com/contact">Send Us Your Comments</a></li>
          			<li><a href="https://www.facebook.com/WinnipegHomes.Com" rel="me" target="_blank">facebook.com/WinnipegHomes.Com</a></li>
          			<li><a href="https://dmsconnect.cld.bz/Sonnichsen-Blair-Tyson" target="_blank">Winnipeg Homes Bookshelf</a></li>
          			<li><a href="https://www.yelp.ca/biz/tyson-sonnichsen-royal-lepage-dynamic-winnipeg" rel="me" target="_blank">Tyson Sonnichsen on YELP.ca</a></li>
          			<li><a href="<?php echo $wpg_news_comm_link; ?>" target="_blank">Real Estate News - Commercial</a></li>
                <li><a href="<?php echo $wpg_news_res_link; ?>" target="_blank">Real Estate News - Residential</a></li>
          		</ul>
          	</div>
        	</div>
      	</div>
    	</div>
        
    </footer>
    <!-- END FOOTER -->
  </div>
  <!-- END SITE -->
      
  <!-- JQUERY PLUGIN -->
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.parallax-1.1.3.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.nouislider.all.min.js"></script>
  <script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClxbWC10PTf5lyJjh6xIE04axk_sLf0yY"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/infobox.js"></script>

  <!-- THEME SCRIPT -->
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/script.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/numeral.min.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/jquery.flexslider-min.js"></script>
  <script type="text/javascript" src="<?php echo $assets_path; ?>script/wpg-homes.js"></script>
  
  <?php if ($map): ?>
  <script>
    var listings_coords = <?php echo $listings_coords_json; ?>;
  </script>
  <script src="<?php echo $assets_path; ?>script/listings-map.js"></script>
  <?php elseif ($property_detail): ?>
    <?php
      if (!$property['Lat'])
      {
        $property['Lat'] = 49.8756157;
        $property['Lon'] = -97.1358158;                
      }
    ?>                            
  <script>
    var lat = <?php echo $property['Lat']; ?>;
    var lon = <?php echo $property['Lon']; ?>;
  </script>
  <script src="<?php echo $assets_path; ?>script/property-map.js"></script>
  <?php endif; ?>
  
  <link rel="shortcut icon" href="<?php echo $assets_path; ?>images/icon/favicon.ico" type="image/x-icon" media="all">
  
  <div id="calendly">
    <a href="https://calendly.com/tyson-sonnichsen" target=_blank">Book time with us</a>
  </div>

</body>

</html>