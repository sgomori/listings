
<body class="page-fullwidth">

  <!-- START SITE -->
  <div class="site">

    <!-- START NOO WRAPPER -->
    <div class="noo-wrapper">

      <!-- START NOO MAINBODY -->
      <div class="container noo-mainbody">
        <div class="noo-mainbody-inner">
          <div class="row clearfix">
            <!-- START MAIN CONTENT -->
            <div class="noo-content col-xs-12">
              <div class="recent-properties">
                <div class="properties list">
                  <!-- START PROPERTIES HEADER -->
                  <div class="properties-header">
                    <h1><?php echo $h1; ?></h1>
                  </div>
                  <!-- END PROPERTIES HEADER -->

                  <!-- START PROPERTIES CONTENT -->
                  <div class="properties-content<?php if ($map): ?> map<?php endif; ?>">
                  
                  <?php if (empty($listings)): ?>
                    <p>There are currently no listings to show you here.</p>
                  <?php endif; ?>
                  
                  <?php foreach ($listings as $listing) : ?>
                  
                    <article class="hentry" id="id_<?php echo $listing['Matrix_Unique_ID']; ?>">
                      <div class="property-featured">
                        <?php if (file_exists(FCPATH.'assets/images/properties/image-'.$listing['Matrix_Unique_ID'].'-0.jpg')): ?>
                        <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], '<img src="'.$assets_path.'images/properties/image-'.$listing['Matrix_Unique_ID'].'-0.jpg" alt="">', array('class' => 'content-thumb', 'target' => '_blank')); ?>
                        <?php else: ?>
                        <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], '<img src="'.$assets_path.'images/properties/default.gif" alt="">', array('class' => 'content-thumb', 'target' => '_blank')); ?>
                        <?php endif; ?>
                        <?php if (($listing['Status'] === 'Sold') && ($listing['Sold_Date'] !== '0000-00-00 00:00:00') && (strtotime($listing['Sold_Date']) < time())): ?>
                        <span class="property-label">Sold</span>
                        <?php elseif ($listing['Status'] === 'Pending'): ?>
                        <span class="property-label">Sale Pending</span>                    
                        <?php elseif ((isset($listing['Open_House_Date_NUM1'])) && ((strtotime($listing['Open_House_Date_NUM1']) + (3600 * 24)) > time())): ?>
                        <span class="property-label">Open House - <?php echo date('l', strtotime($listing['Open_House_Date_NUM1'])); ?></span>                        
                        <?php elseif ((strtotime($listing['LastChangeTypeDate']) > (time() - (3600 * 24 * 14))) && ($listing['LastChangeType']) && ($listing['LastChangeType'] !== '') && (!in_array(strtolower($listing['LastChangeType']), array('price change', 'back on market', 'pending')))): ?>
                        <span class="property-label"><?php echo $listing['LastChangeType']; ?></span>
                        <?php endif; ?>
                        <span class="property-category"><?php echo $listing['Style']; ?></span>
                      </div>
                      <div class="property-wrap">
                        <h2 class="property-title">
                          <?php if (intval($listing['Display_Addrs_on_Pub_Web_Sites']) === 1): ?>
                            <?php
                              $address = $listing['Street_Number'].' '.ucwords(strtolower($listing['Street_Name'])).' '.ucfirst(strtolower($listing['Street_Type'])).' - '.$listing['Neighbourhood'].', '.ucwords(strtolower($listing['City_or_Town_Name']));
                              
                              if ($listing['Suite_Number'] !== '')
                              {
                                $address = $listing['Suite_Number'].' - '.$address;
                              }
                            ?>
                          <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], $address, array('class' => $listing['class'], 'target' => '_blank')); ?>
                          <?php endif; ?>
                        </h2>
                        <div class="property-excerpt">
                          <p><?php echo substr($listing['Public_Remarks'], 0, 30); ?>...</p>
                          <p class="property-fullwidth-excerpt"><?php echo substr($listing['Public_Remarks'], 0, 200); ?>...</p>
                          <p class="property-fullwidth-excerpt listed-by">Listed by <span itemscope itemtype="https://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $listing['Agent_1_First_Name']; ?> <?php echo $listing['Agent_1_Last_Name']; ?></span></span>
                          <?php if (isset($listing['Agent_2_First_Name']) && ($listing['Agent_1_First_Name'] !== '')): ?>
                            and <span itemscope itemtype="https://schema.org/RealEstateAgent"><span itemprop="name"><?php echo $listing['Agent_2_First_Name']; ?> <?php echo $listing['Agent_2_Last_Name']; ?></span></span>
                          <?php endif; ?>
                          </p>
                        </div>
                        <div class="property-summary">
                          <div class="property-detail">
                            <div class="size">
                              <span><?php echo $listing['Total_FloorLiv_Area_SF']; ?> sqft</span>
                            </div>
                            <div class="bathrooms">
                              <span><?php echo $listing['Number_of_Total_Baths']; ?></span>
                            </div>
                            <div class="bedrooms">
                              <span><?php echo $listing['Total_Bedrooms']; ?></span>
                            </div>
                          </div>
                          <div class="property-info">
                            <div class="property-price">
                              <span>
                                <span class="amount">$ <?php echo number_format($listing['CurrentPrice'], 0); ?></span>
                              </span>
                            </div>
                            <div class="property-action">
                              <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], 'More Details', array('target' => '_blank')); ?>
                            </div>
                          </div>
                          <div class="property-info property-fullwidth-info">
                            <div class="property-price">
                              <span><span class="amount">$ <?php echo number_format($listing['CurrentPrice'], 0); ?></span> </span>
                            </div>
                            <div class="size"><span><?php echo $listing['Total_FloorLiv_Area_SF']; ?> sqft</span></div>
                            <div class="bathrooms"><span><?php echo $listing['Number_of_Total_Baths']; ?></span></div>
                            <div class="bedrooms"><span><?php echo $listing['Total_Bedrooms']; ?></span></div>
                          </div>
                        </div>
                      </div>
                      <div class="property-action property-fullwidth-action">
                        <?php echo anchor($types[$listing['class']]['path'].'/'.$listing['Matrix_Unique_ID'].'/'.$listing['address_slug'], 'More Details', array('target' => '_blank')); ?>
                      </div>
                    </article>
                    
                    <?php endforeach; ?>

                    <div class="clearfix"></div>

                  </div>
                  <!-- END PROPERTIES CONTENT -->
                </div>
              </div>                              
            </div>        
            <!-- END MAIN CONTENT -->
          </div>
        </div>
      </div>
      <!-- END NOO MAINBODY -->
    </div>
    <!-- END NOO WRAPPER -->
    
  </div>
  <!-- END SITE -->
